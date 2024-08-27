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
use ZipArchive;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;


use App\Models\Message;
use App\Models\Leave;
use App\Models\User;

class LeaveController extends Controller
{
    private $timeZoneDbApiKey = 'INQ8VCI2UGFC';
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
            $leave->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            });
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


        $history = Leave::where('employee_id', Auth::user()->custom_id)->paginate(10);

        // Retrieve notifications
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();


        if (Auth::user()->user_type === 0) {
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
                ->where('user_type', '!=', 0)
                ->groupBy('year')
                ->pluck('total', 'year')
                ->toArray();
            $employeeCount = User::where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->where('user_type', '!=', 0)
                ->count();

            $employeefemale = User::where('sex', '=', 'Female')
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employeemale = User::where('sex', '=', 'Male')
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee1822 = User::whereBetween('age', [18, 22])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee2327 = User::whereBetween('age', [23, 27])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee2833 = User::whereBetween('age', [28, 33])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee3438 = User::whereBetween('age', [34, 38])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee3943 = User::whereBetween('age', [39, 43])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee4448 = User::whereBetween('age', [44, 48])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee4953 = User::whereBetween('age', [49, 53])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee5460 = User::whereBetween('age', [54, 60])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();

            $departmentCounts = User::select('department', DB::raw('count(*) as total'))
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->groupBy('department')
                ->get();

            // Prepare data for Chart.js
            $departments = $departmentCounts->pluck('department');
            $counts = $departmentCounts->pluck('total');

            $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
                ->where('user_type', '!=', 0)->count();
            $employeesStayed = User::where('is_archive', 1)
                ->where('user_type', '!=', 0)->count();

            // Handle division by zero
            if ($totalEmployeesAtStart > 0) {
                // Calculate retention rate
                $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
            } else {
                // Set retention rate to 0 or handle it differently
                $retentionRate = 0;
            }
            $totalEmployeesAtEnd = User::count();
            // Calculate the number of employees who have left (assuming archived employees have left)
            $employeesLeft = User::where('is_archive', 2)
                ->where('user_type', '!=', 0)
                ->count();

            // Calculate the average number of employees
            if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
                $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
            } else {
                $averageEmployees = 0;
            }

            // Handle division by zero
            if ($averageEmployees > 0) {
                // Calculate turnover rate
                $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
            } else {
                $turnoverRate = 0;
            }
        } else {
            $employeeData = User::selectRaw('YEAR(date_of_assumption) as year, COUNT(*) as total')
                ->whereNotIn('user_type', [0, 1])
                ->groupBy('year')
                ->pluck('total', 'year')
                ->toArray();
            $employeeCount = User::where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->where('user_type', '!=', 0)
                ->count();

            $employeefemale = User::where('sex', '=', 'Female')
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employeemale = User::where('sex', '=', 'Male')
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee1822 = User::whereBetween('age', [18, 22])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee2327 = User::whereBetween('age', [23, 27])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee2833 = User::whereBetween('age', [28, 33])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee3438 = User::whereBetween('age', [34, 38])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee3943 = User::whereBetween('age', [39, 43])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee4448 = User::whereBetween('age', [44, 48])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee4953 = User::whereBetween('age', [49, 53])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();
            $employee5460 = User::whereBetween('age', [54, 60])
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->count();

            $departmentCounts = User::select('department', DB::raw('count(*) as total'))
                ->where('is_archive', 1)
                ->where('user_type', '!=', 0)
                ->groupBy('department')
                ->get();

            // Prepare data for Chart.js
            $departments = $departmentCounts->pluck('department');
            $counts = $departmentCounts->pluck('total');

            $totalEmployeesAtStart = User::where('date_of_assumption', '<=', now()->startOfYear())
                ->where('user_type', '!=', 0)->count();
            $employeesStayed = User::where('is_archive', 1)
                ->where('user_type', '!=', 0)->count();

            // Handle division by zero
            if ($totalEmployeesAtStart > 0) {
                // Calculate retention rate
                $retentionRate = ($employeesStayed / $totalEmployeesAtStart) * 100;
            } else {
                // Set retention rate to 0 or handle it differently
                $retentionRate = 0;
            }
            $totalEmployeesAtEnd = User::count();
            // Calculate the number of employees who have left (assuming archived employees have left)
            $employeesLeft = User::where('is_archive', 2)
                ->where('user_type', '!=', 0)
                ->count();

            // Calculate the average number of employees
            if ($totalEmployeesAtStart + $totalEmployeesAtEnd > 0) {
                $averageEmployees = ($totalEmployeesAtStart + $totalEmployeesAtEnd) / 2;
            } else {
                $averageEmployees = 0;
            }

            // Handle division by zero
            if ($averageEmployees > 0) {
                // Calculate turnover rate
                $turnoverRate = ($employeesLeft / $averageEmployees) * 100;
            } else {
                $turnoverRate = 0;
            }
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
            'employeefemale' => $employeefemale,
            'employeemale' => $employeemale,
            'employee1822' => $employee1822,
            'employee2327' => $employee2327,
            'employee2833' => $employee2833,
            'employee3438' => $employee3438,
            'employee3943' => $employee3943,
            'employee4448' => $employee4448,
            'employee4953' => $employee4953,
            'employee5460' => $employee5460,
            'departments' => $departments,
            'counts' => $counts,
            'employeesStayed' => $employeesStayed,
            'totalEmployeesAtStart' => $totalEmployeesAtStart,
            'retentionRate' => $retentionRate,
            'averageEmployees' => $averageEmployees,
            'employeesLeft' => $employeesLeft,
            'turnoverRate' => $turnoverRate,
            'history' => $history


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
        Log::info('Request Data:', $request->all());

        $employeeIds = $request->input('employee_ids');

        if (is_null($employeeIds)) {
            Log::error('employee_ids is null');
        } else {
            Log::info('employee_ids:', $employeeIds);
        }

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
    private function getInternetTime()
    {
        // Use the TimeZoneDB API to get the current time in Asia/Manila
        $response = Http::get('https://api.timezonedb.com/v2.1/list-time-zone', [
            'key' => $this->timeZoneDbApiKey,
            'format' => 'json',
            'zone' => 'Asia/Manila',
            'fields' => 'zoneName,gmtOffset'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $gmtOffset = $data['zones'][0]['gmtOffset'];
            return Carbon::now()->utc()->addSeconds($gmtOffset);
        }

        throw new \Exception('Unable to retrieve time information.');
    }

    public function generateReports(Request $request)
    {
        // Retrieve input values for the date range and employee ID
        $timeframeStart = $request->input('timeframeStart');
        $timeframeEnd = $request->input('timeframeEnd');
        $employeeIds = $request->input('employeeIds');
        $employeetype = $request->input('employeetype');
        $employeestatus = $request->input('employeestatus');

        // Initialize the Leave query with the user relationship
        if (Auth::user()->user_type == 0) {
        $leaveData = Leave::query()->with('user');
        }
        if (Auth::user()->user_type == 1) {
            $leaveData = Leave::query()->where('employee_id','!=', 1)->with('user');
            }
        $dateNow = $this->getInternetTime();
        // Apply employee filter if an employee is selected
        if ($employeeIds) {
            $leaveData->where('employee_id', $employeeIds);
        }
        if ($employeetype) {
            $leaveData->where('leave_type', $employeetype);
        }
        if ($employeestatus) {
            $leaveData->where('status', $employeestatus);
        }

        // Apply date range filter if both start and end dates are provided
        if ($timeframeStart && $timeframeEnd) {
            $leaveData->whereBetween('created_at', [$timeframeStart, $timeframeEnd]);
        }

        // Get the filtered data
        $leaveData = $leaveData->get();

        // Count the records
        $recordCount = $leaveData->count();

        // Generate the PDF with the filtered data, count, and date range

        if (Auth::user()->user_type == 0) {
            $pdf = PDF::loadView('superadmin.leave.generatereports', [
                'leaveData' => $leaveData,
                'recordCount' => $recordCount,
                'timeframeStart' => $timeframeStart,
                'timeframeEnd' => $timeframeEnd,
                'dateNow' => $dateNow,
                'employeeIds' => $employeeIds,
                'employeestatus' => $employeestatus,
                'employeetype' => $employeetype
            ]);
        }
        if (Auth::user()->user_type == 1) {
            $pdf = PDF::loadView('admin.leave.generatereports', [
                'leaveData' => $leaveData,
                'recordCount' => $recordCount,
                'timeframeStart' => $timeframeStart,
                'timeframeEnd' => $timeframeEnd,
                'dateNow' => $dateNow,
                'employeeIds' => $employeeIds,
                'employeestatus' => $employeestatus,
                'employeetype' => $employeetype
            ]);
        }

        // Return the PDF to be viewed in the browser
        return $pdf->inline('leave_report.pdf');
    }
}
