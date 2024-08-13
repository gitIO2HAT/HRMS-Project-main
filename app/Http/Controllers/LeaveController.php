<?php

namespace App\Http\Controllers;

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
            $query = Leave::query();
        } elseif (Auth::user()->user_type == 1) {
            $query = Leave::query();
        } elseif (Auth::user()->user_type == 2) {
            $query = Leave::where('employee_id', Auth::user()->custom_id);
        }


        // Apply search filter
        if ($request->filled('search')) {
            $query->where('reason', 'like', '%' . $request->input('search') . '%');
        }

        // Apply date filters
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('from', [$request->input('from'), $request->input('to')]);
        }

        // Apply leave type filter
        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->input('leave_type'));
        }



        // Paginate the results
        $leaves = $query->orderBy('id', 'desc')->paginate(10);

        // Retrieve notifications
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();

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

    try {
        // Get the current time from the external API
        $response = Http::get('http://worldtimeapi.org/api/timezone/Asia/Manila');
        $internetTime = Carbon::parse($response->json()['datetime']);

        // Calculate the number of leave days
        $fromDate = Carbon::parse($validatedData['from']);
        $toDate = Carbon::parse($validatedData['to']);
        $leaveDays = $toDate->diffInDays($fromDate) + 1; // Include the start date in the count

        // Check if the leave starts in the future
        if ($fromDate->lessThan($internetTime)) {
            return redirect()->back()->with('error','Leave start date must be in the future.');
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
            'from' => $validatedData['from'],
            'to' => $validatedData['to'],
            'reason' => $validatedData['reason'],
            'leave_days' => $leaveDays, // Assuming you have a column in your table to store leave days
        ]);

        // Save the leave record
        $leave->save();

        return redirect()->back()->with('success', 'Leave successfully added');

    } catch (\Exception $e) {
        // Handle any unexpected exceptions
        return redirect()->back()-with('error', 'Leave successfully added');;
    }
}


    public function updaterequest(Request $request, $id)
    {
        Log::info('Updating leave request', ['leave_id' => $id, 'status' => $request->input('status')]);

        $leave = Leave::find($id);
        if (!$leave) {
            return redirect()->back()->with('Error', 'Leave request not found.');
        }

        $request->validate([
            'status' => 'nullable|in:Pending,Approved,Declined',
        ], [
            'status.required' => 'The status field is required to select.',
        ]);

        $user = User::where('custom_id', $leave->employee_id)->first();
        if (!$user) {
            return redirect()->back()->with('Error', 'User not found.');
        }

        $previousStatus = $leave->status;
        $status = $request->input('status');

        // Check if status is changing
        Log::info('Previous Status: ' . $previousStatus . ' New Status: ' . $status);

        if ($status === 'Approved') {
            if ($previousStatus !== 'Approved') {
                if ($leave->leave_type === 'Sick Leave') {
                    $user->sick_balance -= $leave->leave_days;
                } elseif ($leave->leave_type === 'Vacation Leave') {
                    $user->vacation_balance -= $leave->leave_days;
                }
            }
        } elseif ($status === 'Declined') {
            if ($previousStatus === 'Approved') {
                if ($leave->leave_type === 'Sick Leave') {
                    $user->sick_balance += $leave->leave_days;
                } elseif ($leave->leave_type === 'Vacation Leave') {
                    $user->vacation_balance += $leave->leave_days;
                }
            }
        } elseif ($status === 'Pending') {
            if ($previousStatus === 'Approved') {
                if ($leave->leave_type === 'Sick Leave') {
                    $user->sick_balance += $leave->leave_days;
                } elseif ($leave->leave_type === 'Vacation Leave') {
                    $user->vacation_balance += $leave->leave_days;
                }
            }
        }

        $leave->status = $status;
        $leave->save();
        $user->save();

        return redirect()->back()->with('Success', 'Leave request successfully updated');
    }
}
