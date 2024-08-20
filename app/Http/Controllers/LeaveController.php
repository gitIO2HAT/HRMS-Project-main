<?php

namespace App\Http\Controllers;

use App\Exports\LeavesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\Message;
use App\Models\Leave;
use App\Models\User;

class LeaveController extends Controller
{
    public function leave(Request $request)
    {
        // Retrieve notifications
        $notification['notify'] = DB::select("
        SELECT
            users.id,
            users.name,
            users.lastname,
            users.email,
            COUNT(messages.is_read) AS unread
        FROM
            users
        LEFT JOIN
            messages ON users.id = messages.send_to AND messages.is_read = 0
        WHERE
            users.id = " . Auth::id() . "
        GROUP BY
            users.id, users.name, users.lastname, users.email
    ");

        // Initialize query for leaves
        if (Auth::user()->user_type == 0) {
            // Get the latest leave request for each user
            $leave = Leave::where('user_type', '!=', 0)
                ->whereIn('id', function ($leave) {
                    $leave->selectRaw('MAX(id)')
                        ->from('leaves')
                        ->where('user_type', '!=', 0)
                        ->groupBy('employee_id');
                })
                ->latest('created_at');
        } elseif (Auth::user()->user_type == 1) {
            $leave = Leave::where('user_type', 2)
            ->whereIn('id', function ($leave) {
                $leave->selectRaw('MAX(id)')
                    ->from('leaves')
                    ->where('user_type', '!=', 0)
                    ->groupBy('employee_id');
            })
            ->latest('created_at');
        } elseif (Auth::user()->user_type == 2) {
            $leave = Leave::where('employee_id', Auth::user()->custom_id);
        }

        // Fetch departments that match the search query and are not marked as deleted
        if (Auth::user()->user_type === 0) {
            $users = User::where('user_type', '!=', 0)
                ->where('is_archive', 1)
                ->get();
        } else {
            $users = User::where('user_type', 2)
                ->where('is_archive', 1)
                ->get();
        }


        // Apply search filter
        if ($request->filled('search')) {
            $leave->where('reason', 'like', '%' . $request->input('search') . '%');
        }

        // Apply date filters
        if ($request->filled('from') && $request->filled('to')) {
            $leave->whereBetween('from', [$request->input('from'), $request->input('to')]);
        }

        // Apply leave type filter
        if ($request->filled('leave_type')) {
            $leave->where('leave_type', $request->input('leave_type'));
        }

        // Paginate the results
        $leaves = $leave->orderBy('id', 'desc')->paginate(10);

        // Retrieve notifications
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();


        if (Auth::user()->user_type === 0) {
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                ->where('user_type', '!=', 0)
                ->groupBy('year')
                ->pluck('total', 'year')
                ->toArray();
        } else {
            $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                ->whereNotIn('user_type', [0, 1])
                ->groupBy('year')
                ->pluck('total', 'year')
                ->toArray();
        }
        // Calculate growth rate for each year
        $growthRates = [];
        $years = array_keys($employeeData);
        for ($i = 1; $i < count($years); $i++) {
            $previousYearEmployees = $employeeData[$years[$i - 1]];
            $currentYearEmployees = $employeeData[$years[$i]];
            $growthRate = (($currentYearEmployees - $previousYearEmployees) / $previousYearEmployees) * 100;
            $growthRates[$years[$i]] = $growthRate;
        }

        // Determine view path based on user type
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.leave.leave'
            : (Auth::user()->user_type == 1
                ? 'admin.leave.leave'
                : 'employee.leave.leave');

        // Return the appropriate view
        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'leaves' => $leaves,
            'users' => $users,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,
        ]);
    }


    public function addleave(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'leave_type' => 'required|in:Sick Leave,Vacation Leave',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'reason' => 'required|string',
        ], [
            'leave_type.required' => 'The leave type field is required.',
            'from.required' => 'This field is required.',
            'to.required' => 'This field is required.',
            'reason.required' => 'The reason field is required.',
        ]);

        $user = Auth::user();
        $sickBalance = $user->sick_balance;
        $vacationBalance = $user->vacation_balance;

        // TimeZoneDB API details
        $apiUrl = "https://api.timezonedb.com/v2.1/list-time-zone";
        $apiKey = 'INQ8VCI2UGFC'; // Your TimeZoneDB API Key

        // Make the request to TimeZoneDB API
        $response = Http::get($apiUrl, [
            'key' => $apiKey,
            'format' => 'json',
            'zone' => 'Asia/Manila',
            'fields' => 'zoneName,gmtOffset'
        ]);

        // Check if the response is successful
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Unable to retrieve time information.');
        }

        $data = $response->json();

        // Get the GMT offset from the API response
        $gmtOffset = $data['zones'][0]['gmtOffset'];

        // Calculate the current time using the offset
        $internetTime = Carbon::now()->utc()->addSeconds($gmtOffset);

        // Calculate the number of leave days, excluding Saturdays and Sundays
        $fromDate = Carbon::parse($validatedData['from']);
        $toDate = Carbon::parse($validatedData['to']);
        $leaveDays = 0;

        for ($date = $fromDate; $date->lte($toDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $leaveDays++;
            }
        }

        // Check if the leave starts in the future
        if ($fromDate->lessThan($internetTime)) {
            return redirect()->back()->with('error', 'Leave start date must be in the future.');
        }

        // Check if the balance is sufficient for the requested leave type
        if ($validatedData['leave_type'] == 'Sick Leave' && $sickBalance < $leaveDays) {
            return redirect()->back()->with('error', 'Insufficient Balance in Sick Leave Credit');
        }

        if ($validatedData['leave_type'] == 'Vacation Leave' && $vacationBalance < $leaveDays) {
            return redirect()->back()->with('error', 'Insufficient Balance in Vacation Leave Credit');
        }

        // Create a new Leave instance and assign validated data
        $leave = new Leave([
            'employee_id' => $user->custom_id, // Correctly set employee_id here
            'leave_type' => $validatedData['leave_type'],
            'user_type' => Auth::user()->user_type,
            'from' => $validatedData['from'],
            'to' => $validatedData['to'],
            'reason' => $validatedData['reason'],
            'leave_days' => $leaveDays, // Assuming you have a column in your table to store leave days
        ]);

        // Save the leave record
        $leave->save();

        return redirect()->back()->with('success', 'Leave successfully added');
    }



    public function addcredit(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type' => 'required|string',
            'quantity' => 'required|numeric|min:-1000|max:100',
        ]);

        $user = User::find($validatedData['user_id']);

        // Update the appropriate balance based on leave_type
        if ($validatedData['leave_type'] === 'sick_balance') {
            $user->sick_balance += $validatedData['quantity'];
        } elseif ($validatedData['leave_type'] === 'vacation_balance') {
            $user->vacation_balance += $validatedData['quantity'];
        }

        $user->save();

        return redirect()->back()->with('success', 'Successfully updated credit');
    }


    public function updaterequest(Request $request, $id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            return redirect()->back()->with('error', 'Leave request not found.');
        }

        // Ensure status is never null
        $status = $request->input('status', 'Pending'); // Default to 'Pending' if not provided
        $request->merge(['status' => $status]);

        $request->validate([
            'status' => 'nullable|in:Pending,Approved,Declined',
        ], [
            'status.required' => 'The status field is required to select.',
        ]);

        $user = User::where('custom_id', $leave->employee_id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $previousStatus = $leave->status;

        // Check if status is changing
        Log::info('Previous Status: ' . $previousStatus . ' New Status: ' . $status);

        // Check if user has enough balance before approving the leave
        if ($status === 'Approved' && $previousStatus !== 'Approved') {
            if ($leave->leave_type === 'Sick Leave') {
                if ($user->sick_balance < $leave->leave_days) {
                    return redirect()->back()->with('error', 'Insufficient sick leave balance.');
                }
                $user->sick_balance -= $leave->leave_days;
            } elseif ($leave->leave_type === 'Vacation Leave') {
                if ($user->vacation_balance < $leave->leave_days) {
                    return redirect()->back()->with('error', 'Insufficient vacation leave balance.');
                }
                $user->vacation_balance -= $leave->leave_days;
            }
        } elseif ($status === 'Declined' && $previousStatus === 'Approved') {
            if ($leave->leave_type === 'Sick Leave') {
                $user->sick_balance += $leave->leave_days;
            } elseif ($leave->leave_type === 'Vacation Leave') {
                $user->vacation_balance += $leave->leave_days;
            }
        } elseif ($status === 'Pending' && $previousStatus === 'Approved') {
            if ($leave->leave_type === 'Sick Leave') {
                $user->sick_balance += $leave->leave_days;
            } elseif ($leave->leave_type === 'Vacation Leave') {
                $user->vacation_balance += $leave->leave_days;
            }
        }

        $leave->status = $status;
        $leave->save();
        $user->save();

        return redirect()->back()->with('success', 'Leave request successfully updated');
    }

    public function exportexcel(Request $request)
{
    $employeeIds = $request->input('employee_ids');

    // Fetch all approved and declined leave records for the selected employee IDs
    $leaves = Leave::whereIn('employee_id', $employeeIds)
        ->whereIn('status', ['Declined', 'Approved'])
        ->with('user')
        ->get();

    // Map the leave records to the desired export format
    $data = $leaves->map(function ($leave) {
        return [
            'Employee' => $leave->user->name . ' ' . $leave->user->lastname,
            'Leave Type' => $leave->leave_type,
            'Reason' => $leave->reason,
            'Start Date' => \Carbon\Carbon::parse($leave->from)->format('Y, F j'), // Format as "2024, January 26"
            'End Date' => \Carbon\Carbon::parse($leave->to)->format('Y, F j'), // Format as "2024, January 26"
            'Leave Days' => $leave->leave_days, // Ensure consistency with the heading 'Leave Days'
            'Status' => $leave->status,
        ];
    });

    // Return the Excel download
    return \Maatwebsite\Excel\Facades\Excel::download(new LeavesExport($data), 'leaves.xlsx');
}



}
