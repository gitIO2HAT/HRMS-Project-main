<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
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

     
        return view($viewPath,[
            'notification' => $notification,
            'getNot' => $getNot,
        ]);
    }

    public function clockin()
    {
        $attendance = Attendance::create([
            'user_id' => auth()->id(),
            'clock_in' => now(),
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully');
    }

    public function clockout()
    {
        $attendance = Attendance::where('user_id', auth()->id())
                                ->whereNull('clock_out')
                                ->latest()
                                ->first();

        if ($attendance) {
            $attendance->update(['clock_out' => now()]);
            return redirect()->back()->with('success', 'Clocked out successfully');
        }

        return redirect()->back()->with('error', 'No active clock-in found');
    }
    public function getCurrentTime()
    {
        $todayAttendance =  Attendance::where('user_id', auth()->id())
                            ->whereDate('clock_in', \Carbon\Carbon::today())
                            ->whereNotNull('clock_out')
                            ->get();

        $totalDuration = $todayAttendance->reduce(function($carry, $attendance) 
        {
            $clockIn = \Carbon\Carbon::parse($attendance->clock_in);
            $clockOut = \Carbon\Carbon::parse($attendance->clock_out);
            return $carry->add($clockOut->diffAsCarbonInterval($clockIn));
        }, \Carbon\CarbonInterval::seconds(0));

        return response()->json(['totalDuration' => $totalDuration->cascade()->forHumans()]);
    }
}