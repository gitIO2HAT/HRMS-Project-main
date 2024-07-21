<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $getNot['getNotify'] = $query->orderBy('id', 'desc')->take(10)->get();
        $viewPath = Auth::user()->user_type == 0
            ? 'superadmin.dashboard'
            : (Auth::user()->user_type == 1
                ? 'admin.dashboard'
                : 'employee.attendance');


  

        return view($viewPath, [
            'notification' => $notification,
            'getNot' => $getNot,
       
        ]);
    }

    public function clockIn()
    {
        $user = Auth::user();
        $now = Carbon::now('Asia/Manila');
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
    
        $attendance->save();
    
        return redirect()->back()->with('success', 'Clock In successfully!');
    }

    public function clockOut()
{
    $user = Auth::user();
    $now = Carbon::now('Asia/Manila');
    $attendance = Attendance::where('user_id', $user->custom_id)
                            ->where('date', $now->toDateString())
                            ->first();

    if (!$attendance || $attendance->end_time) {
        // Return a warning message if there is no active clock-in
        return redirect()->back()->with('warning', 'No active Clock In!');
    }

    $attendance->end_time = $now;
    $attendance->total_duration += $now->diffInSeconds($attendance->start_time);
    $attendance->save();

    return redirect()->back()->with('success', 'Clock Out successfully!');
}
    public function currentTime()
    {
        $user = Auth::user();
        $now = Carbon::now('Asia/Manila');
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
