<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Message;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function attendance()
    {
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
        $query = Message::getNotify();


        $userId = Auth::user()->custom_id;
        $timezone = 'Asia/Manila';
        Carbon::setLocale('en'); // Optional: Set locale if needed

        

        // Get the start and end of the current week in Asia/Manila timezone
        $startOfWeek = Carbon::now($timezone)->startOfWeek();
        $endOfWeek = Carbon::now($timezone)->endOfWeek();
        $weekly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->sum('total_duration');
        $weeklyProgressBar = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->sum('total_duration');

        if ($weekly <= 3599) {
            $weeklyDuration = floor($weekly / 60);
            $weeklyFinal = $weeklyDuration . 'm';
        } else {
            $weeklyDuration = floor($weekly / 3600);
            $weeklyFinal = $weeklyDuration . 'h';
        }

        $startOfMonth = Carbon::now($timezone)->startOfMonth();
        $endOfMonth = Carbon::now($timezone)->endOfMonth();
        $monthly = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('total_duration');
        $monthlyProgressBar = Attendance::where('user_id', $userId)->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('total_duration');
        $monthlyRemaining = 576000 -  $monthlyProgressBar;

        if ($monthly <= 3599) {
            $monthlyDuration = floor($monthly / 60);
            $monthlyFinal = $monthlyDuration . 'm';
        } else {
            $monthlyDuration = floor($monthly / 3600);
            $monthlyFinal = $monthlyDuration . 'h';
        }

        if ($monthlyRemaining <= 3599) {
            $monthlyRemainingFinal = floor($monthlyRemaining / 60);
            $monthlyRemainingFinals = $monthlyRemainingFinal . 'm';
        } else {
            $monthlyRemainingFinal = floor($monthlyRemaining / 3600);
            $monthlyRemainingFinals = $monthlyRemainingFinal . 'h';
        }

        $getPunch = Attendance::where('user_id', $userId) ->orderBy('created_at', 'desc')->take(10)->paginate(10);

        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.dashboard'
            : (Auth::user()->user_type == 1
                ? 'admin.dashboard'
                : 'employee.attendance');




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

        ]);
    }

    public function getInternetTime()
    {
        $response = Http::get('http://worldtimeapi.org/api/timezone/Asia/Manila');
        return Carbon::parse($response->json()['datetime']);
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

        if ($attendance->end_time) {
            $attendance->start_time = $now;
            $attendance->end_time = null;
        }
        if ($attendance->punch_in_am_first === null) {
            $attendance->punch_in_am_first = $now;
        } else {
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

        if ($attendance->punch_in_am_second === null) {
            $attendance->punch_in_am_second = $now;
        } else {
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
}
