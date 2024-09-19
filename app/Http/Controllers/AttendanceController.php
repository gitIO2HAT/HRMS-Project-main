<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\User;

class AttendanceController extends Controller
{
    private $timeZoneDbApiKey = 'INQ8VCI2UGFC'; // Your TimeZoneDB API Key

    public function attendance(Request $request)
    {
        // Get notifications
        $notification['notify'] = User::select('users.id', 'users.name', 'users.lastname', 'users.email')
        ->selectRaw('COUNT(messages.is_read) AS unread')
        ->selectRaw('COUNT(messages.inbox) AS inbox')
        ->leftJoin('messages', function($join) {
            $join->on('users.id', '=', 'messages.send_to')
                 ->where('messages.inbox', '=', 0);
        })
        ->where('users.id', Auth::id())
        ->groupBy('users.id', 'users.name', 'users.lastname', 'users.email')
        ->get();
    
        $query = Message::getNotify();

        $userId = Auth::user()->custom_id;
        $timezone = 'Asia/Manila';
        Carbon::setLocale('en'); // Optional: Set locale if needed

        // Get the start and end of the current week in Asia/Manila timezone
        $startOfWeek = Carbon::now($timezone)->startOfWeek();
        $endOfWeek = Carbon::now($timezone)->endOfWeek();
        $weekly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfWeek, $endOfWeek])->sum('total_duration');
        $weeklyProgressBar = $weekly;

        $weeklyFinal = ($weekly <= 3599) ? floor($weekly / 60) . 'm' : floor($weekly / 3600) . 'h';

        // Get the start and end of the current month in Asia/Manila timezone
        $startOfMonth = Carbon::now($timezone)->startOfMonth();
        $endOfMonth = Carbon::now($timezone)->endOfMonth();
        $monthly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfMonth, $endOfMonth])->sum('total_duration');
        $monthlyProgressBar = $monthly;
        $monthlyRemaining = 576000 - $monthlyProgressBar;

        $monthlyFinal = ($monthly <= 3599) ? floor($monthly / 60) . 'm' : floor($monthly / 3600) . 'h';
        $monthlyRemainingFinals = ($monthlyRemaining <= 3599) ? floor($monthlyRemaining / 60) . 'm' : floor($monthlyRemaining / 3600) . 'h';

        // Get selected year and month from the request, or default to current year and month
        $selectedYear = $request->input('year', Carbon::now($timezone)->year);
        $selectedMonth = $request->input('month', Carbon::now($timezone)->month);

        // Generate a series of all days in the selected month of the selected year
        $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1, 0, 0, 0, $timezone)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $allDays = [];
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lte($endOfMonth)) {
            $allDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        // Fetch daily series data
        $dailySeries = Attendance::selectRaw('DATE(date) as date, SUM(total_duration) as total_duration')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->total_duration];
            })
            ->toArray();

        // Ensure all days have an entry, even if the total duration is zero
        $dailySeries = array_merge(array_fill_keys($allDays, 0), $dailySeries);

        // Get recent punches
        $getPunch = Attendance::where('user_id', $userId)->orderBy('created_at', 'desc')->take(10)->paginate(10);
        $getall = Attendance::with('user')
        ->where('user_id', '!=', 1)->orderBy('created_at', 'desc')->take(10)->paginate(10);
        // Search for employee records
        $search = $request->input('search');

        $employeeRecords = User::query();

        if ($search) {
            $employeeRecords->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%$search%"])
                    ->orWhere('custom_id', 'LIKE', "%$search%");
            });
        }


        if (Auth::user()->user_type === 0) {
            $users = user::where('user_type', '!=', 0)
                ->where('is_archive', 1)
                ->get();
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

            $usersadmin = user::where('user_type', 2)
            ->where('is_archive', 1)
                ->get();
        } else {
            $usersadmin = user::where('user_type', 2)
            ->where('is_archive', 1)
                ->get();

            $users = user::where('user_type', [0, 1])
                ->where('is_archive', 1)
                ->get();
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
        // Add the is_archive condition
        if (Auth::user()->user_type === 0) {
            $employeeRecords->where('is_archive', '=', 1)
                ->where('user_type', '!=', 0);
        } else {
            $employeeRecords->where('is_archive', '=', 1)
                ->where('user_type', '=', 2);;
        }

        $employeeRecords = $employeeRecords->paginate(10); // Apply pagination

        $RecordsAttendance = Attendance::all();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.attendance.attendance'
            : (Auth::user()->user_type == 1
                ? 'admin.attendance.attendance'
                : 'employee.attendance.attendance');

        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'weeklyFinal' => $weeklyFinal,
            'weeklyProgressBar' => $weeklyProgressBar,
            'monthlyFinal' => $monthlyFinal,
            'monthlyProgressBar' => $monthlyProgressBar,
            'monthlyRemaining' => $monthlyRemaining,
            'monthlyRemainingFinals' => $monthlyRemainingFinals,
            'getPunch' => $getPunch,
            'employeeRecords' => $employeeRecords,
            'dailySeries' => $dailySeries,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'RecordsAttendance' => $RecordsAttendance,
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
            'getall' => $getall,
            'usersadmin' => $usersadmin,
            'users' => $users






        ]);
    }

    public function myattendance(Request $request)
    {
        // Get notifications
        $notification['notify'] = User::select('users.id', 'users.name', 'users.lastname', 'users.email')
        ->selectRaw('COUNT(messages.is_read) AS unread')
        ->selectRaw('COUNT(messages.inbox) AS inbox')
        ->leftJoin('messages', function($join) {
            $join->on('users.id', '=', 'messages.send_to')
                 ->where('messages.inbox', '=', 0);
        })
        ->where('users.id', Auth::id())
        ->groupBy('users.id', 'users.name', 'users.lastname', 'users.email')
        ->get();
    
        $query = Message::getNotify();

        $userId = Auth::user()->custom_id;
        $timezone = 'Asia/Manila';
        Carbon::setLocale('en'); // Optional: Set locale if needed

        // Get the start and end of the current week in Asia/Manila timezone
        $startOfWeek = Carbon::now($timezone)->startOfWeek();
        $endOfWeek = Carbon::now($timezone)->endOfWeek();
        $weekly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfWeek, $endOfWeek])->sum('total_duration');
        $weeklyProgressBar = $weekly;

        $weeklyFinal = ($weekly <= 3599) ? floor($weekly / 60) . 'm' : floor($weekly / 3600) . 'h';

        // Get the start and end of the current month in Asia/Manila timezone
        $startOfMonth = Carbon::now($timezone)->startOfMonth();
        $endOfMonth = Carbon::now($timezone)->endOfMonth();
        $monthly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfMonth, $endOfMonth])->sum('total_duration');
        $monthlyProgressBar = $monthly;
        $monthlyRemaining = 576000 - $monthlyProgressBar;

        $monthlyFinal = ($monthly <= 3599) ? floor($monthly / 60) . 'm' : floor($monthly / 3600) . 'h';
        $monthlyRemainingFinals = ($monthlyRemaining <= 3599) ? floor($monthlyRemaining / 60) . 'm' : floor($monthlyRemaining / 3600) . 'h';

        // Get selected year and month from the request, or default to current year and month
        $selectedYear = $request->input('year', Carbon::now($timezone)->year);
        $selectedMonth = $request->input('month', Carbon::now($timezone)->month);

        // Generate a series of all days in the selected month of the selected year
        $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1, 0, 0, 0, $timezone)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $allDays = [];
        $currentDate = $startOfMonth->copy();
        while ($currentDate->lte($endOfMonth)) {
            $allDays[] = $currentDate->toDateString();
            $currentDate->addDay();
        }

        // Fetch daily series data
        $dailySeries = Attendance::selectRaw('DATE(date) as date, SUM(total_duration) as total_duration')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->total_duration];
            })
            ->toArray();

        // Ensure all days have an entry, even if the total duration is zero
        $dailySeries = array_merge(array_fill_keys($allDays, 0), $dailySeries);

        // Get recent punches
        $getPunch = Attendance::where('user_id', $userId)->orderBy('created_at', 'desc')->take(10)->paginate(10);
        $getall = Attendance::with('user')
        ->where('user_id', '=', Auth::user()->custom_id)
        ->orderBy('created_at', 'desc')
        ->paginate(10); // No need for take(10) if you're paginating 10 records per page

        // Search for employee records
        $search = $request->input('search');

        $employeeRecords = User::query();

        if ($search) {
            $employeeRecords->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(name, ' ', lastname) LIKE ?", ["%$search%"])
                    ->orWhere('custom_id', 'LIKE', "%$search%");
            });
        }


        if (Auth::user()->user_type === 0) {
            $users = user::where('user_type', '!=', 0)
                ->where('is_archive', 1)
                ->get();
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

            $usersadmin = user::where('user_type', 2)
            ->where('is_archive', 1)
                ->get();
        } else {
            $usersadmin = user::where('user_type', 2)
            ->where('is_archive', 1)
                ->get();

            $users = user::where('user_type', [0, 1])
                ->where('is_archive', 1)
                ->get();
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
        // Add the is_archive condition
        if (Auth::user()->user_type === 0) {
            $employeeRecords->where('is_archive', '=', 1)
                ->where('user_type', '!=', 0);
        } else {
            $employeeRecords->where('is_archive', '=', 1)
                ->where('user_type', '=', 2);;
        }

        $employeeRecords = $employeeRecords->paginate(10); // Apply pagination

        $RecordsAttendance = Attendance::all();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.attendance.myattendance'
            : (Auth::user()->user_type == 1
                ? 'admin.attendance.myattendance'
                : 'employee.attendance.attendance');

        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'weeklyFinal' => $weeklyFinal,
            'weeklyProgressBar' => $weeklyProgressBar,
            'monthlyFinal' => $monthlyFinal,
            'monthlyProgressBar' => $monthlyProgressBar,
            'monthlyRemaining' => $monthlyRemaining,
            'monthlyRemainingFinals' => $monthlyRemainingFinals,
            'getPunch' => $getPunch,
            'employeeRecords' => $employeeRecords,
            'dailySeries' => $dailySeries,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'RecordsAttendance' => $RecordsAttendance,
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
            'getall' => $getall,
            'usersadmin' => $usersadmin,
            'users' => $users






        ]);
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

    public function clockIn()
    {
        $user = Auth::user();
        $now = $this->getInternetTime(); // Use the internet time

        $attendance = Attendance::where('user_id', $user->custom_id)
            ->where('date', $now->toDateString())
            ->first();

        if ($attendance && is_null($attendance->end_time)) {
            // Return a warning message since the user is already clocked in
            return redirect()->back()->with('warning', 'You already Clocked In!');
        }

        $attendance = Attendance::firstOrCreate(
            ['user_id' => $user->custom_id, 'date' => $now->toDateString()],
            ['start_time' => $now, 'total_duration' => 0]
        );
        $currentTime = $now->format('H:i'); // Get the current time in HH:mm format

        if ($attendance->end_time) {
            $attendance->start_time = $now;
            $attendance->end_time = null;
        }
        if ($currentTime >= '07:00' && $currentTime <= '12:30') {
            $attendance->punch_in_am_first = $now;
        } elseif ($currentTime >= '12:31' && $currentTime <= '18:00') {
            $attendance->punch_in_pm_first = $now;
        }

        $attendance->save();

        return redirect()->back()->with('success', 'Clock In successfully!');
    }

    public function clockOut()
    {
        $user = Auth::user();
        $now = $this->getInternetTime(); // Use the internet time

        $attendance = Attendance::where('user_id', $user->custom_id)
            ->where('date', $now->toDateString())
            ->first();

        if (!$attendance || $attendance->end_time) {
            // Return a warning message if there is no active clock-in
            return redirect()->back()->with('warning', 'No active Clock In!');
        }

        // Calculate the duration since the last clock-in
        $duration = $now->diffInSeconds($attendance->start_time);

        $attendance->end_time = $now;

        $currentTime = $now->format('H:i'); // Get the current time in HH:mm format

        // Update punch_in_am_second or punch_in_pm_second based on the current time
        if ($currentTime >= '07:00' && $currentTime <= '12:30') {
            $attendance->punch_in_am_second = $now;
        } elseif ($currentTime >= '12:31' && $currentTime <= '18:00') {
            $attendance->punch_in_pm_second = $now;
        }

        $attendance->total_duration += $duration;
        $attendance->save();

        return redirect()->back()->with('success', 'Clock Out successfully!');
    }

    public function currentTime()
    {
        $user = Auth::user();
        $now = $this->getInternetTime(); // Use the internet time
        $attendance = Attendance::where('user_id', $user->custom_id)->where('date', $now->toDateString())->first();

        if ($attendance) {
            $totalDuration = $attendance->total_duration;
            if ($attendance->start_time && !$attendance->end_time) {
                $totalDuration += $now->diffInSeconds($attendance->start_time);
            }
        } else {
            $totalDuration = 0;
        }

        return response()->json(['totalDuration' => $totalDuration]);
    }

    public function generateReports(Request $request)
    {
        // Retrieve input values for the date range and employee ID
        $timeframeStart = $request->input('timeframeStart');
        $timeframeEnd = $request->input('timeframeEnd');
        $employeeIds = $request->input('employeeIds');


        // Initialize the Leave query with the user relationship


        if (Auth::user()->user_type == 0) {
            $attendancedata = Attendance::query()->with('user');
            }
            if (Auth::user()->user_type == 1) {
                $attendancedata = Attendance::query()->where('user_id','!=', 1)->with('user');
                }

        $dateNow = $this->getInternetTime();

        // Apply employee filter if an employee is selected
        if ($employeeIds) {
            $attendancedata->where('user_id', $employeeIds);
        }
        // Apply date range filter if both start and end dates are provided
        if ($timeframeStart && $timeframeEnd) {
            $attendancedata->whereBetween('created_at', [$timeframeStart, $timeframeEnd]);
        }

        // Get the filtered data
        $attendancedata = $attendancedata->get();

        // Count the records
        $recordCount = $attendancedata->count();

        // Generate the PDF with the filtered data, count, and date range
        if (Auth::user()->user_type == 0) {
            $pdf = PDF::loadView('superadmin.attendance.generatereports', [
                'attendancedata' => $attendancedata,
                'recordCount' => $recordCount,
                'timeframeStart' => $timeframeStart,
                'timeframeEnd' => $timeframeEnd,
                'dateNow' => $dateNow,
                'employeeIds' => $employeeIds
            ]);
        }
        if (Auth::user()->user_type == 1) {
            $pdf = PDF::loadView('admin.attendance.generatereports', [
                'attendancedata' => $attendancedata,
                'recordCount' => $recordCount,
                'timeframeStart' => $timeframeStart,
                'timeframeEnd' => $timeframeEnd,
                'dateNow' => $dateNow,
                'employeeIds' => $employeeIds
            ]);
        }


        // Return the PDF to be viewed in the browser
        return $pdf->inline('Attendace_report.pdf');
    }
}
