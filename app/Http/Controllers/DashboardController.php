<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // TimeZoneDB API Details
        $apiUrl = "https://api.timezonedb.com/v2.1/get-time-zone";
        $apiKey = 'INQ8VCI2UGFC'; // Your TimeZoneDB API Key

        // Fetch current time in Asia/Manila timezone
        $response = Http::get($apiUrl, [
            'key' => $apiKey,
            'format' => 'json',
            'by' => 'zone',
            'zone' => 'Asia/Manila',
        ]);

        if ($response->successful()) {
            $currentDate = $response->json()['formatted'];
            $month = date('m', strtotime($currentDate));
            $day = date('d', strtotime($currentDate));

            // Fetch users whose birth date matches the current month and day
            $birthdayUsers = User::whereMonth('birth_date', $month)
                ->whereDay('birth_date', $day)
                ->where('is_archive', 1)
                ->get();
        } else {
            // Handle the error response, perhaps log it or set an empty collection
            $birthdayUsers = collect(); // Empty collection
        }
        if(Auth::user()->user_type === 0){
        $employeeCount = User::where('is_archive', 1)
        ->where('user_type', '!=', 0)
                ->count();
            }else{$employeeCount = User::where('is_archive', 1)
                ->whereNotIn('user_type', [0, 1])
                ->count();
            }

        $departmentCount = Department::where('deleted', 1)
                ->count();

                if(Auth::user()->user_type === 0){
                    $employeeData = User::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
                    ->where('user_type', '!=', 0)
                    ->groupBy('year')
                    ->pluck('total', 'year')
                    ->toArray();
                }else{
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

date_default_timezone_set('Asia/Manila');

// Get the current date and time in Asia/Manila timezone
$currentDateTime['currentDateTime'] = Carbon::now()->setTimezone('Asia/Manila');
        // Notification query
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
        $gettask = Task::getTask();
        $getAnn['getAnn'] = $gettask->orderby('scheduled_date', 'asc')->paginate(10);

        $task = Task::getCompleted();
        $getCompleted['getCompleted'] = $task->orderby('scheduled_date', 'asc')->paginate(10);
        // Get notifications (latest 10)
        $query = Message::getNotify();
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();

        // Determine the view path based on user type
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.dashboard'
            : (Auth::user()->user_type == 1
                ? 'admin.dashboard'
                : 'employee.dashboard');

        // Pass variables to the view
        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
            'birthdayUsers' => $birthdayUsers,
            'employeeCount' => $employeeCount,
            'departmentCount' => $departmentCount,
            'getAnn' => $getAnn['getAnn'],
            'getCompleted' => $getCompleted['getCompleted'],
            'currentDateTime' => $currentDateTime['currentDateTime'],
            'growthRates' => $growthRates,
            'employeeData' => $employeeData, // Pass the birthday users to the view
        ]);
    }
}
