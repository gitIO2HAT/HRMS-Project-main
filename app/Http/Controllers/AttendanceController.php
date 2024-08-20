<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
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
            ? 'superadmin.attendance'
            : (Auth::user()->user_type == 1
                ? 'admin.attendance'
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
            'employeeRecords' => $employeeRecords,
            'dailySeries' => $dailySeries,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'RecordsAttendance' => $RecordsAttendance,
            'growthRates' => $growthRates,
            'employeeData' => $employeeData,
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




    public function exportexcelattendance(Request $request)
    {
        $employeeIds = $request->input('custom_ids');
        $month = $request->input('month');
        $year = $request->input('year');

        $tempDir = storage_path('app/public/temp_attendance_exports');

        if (!file_exists($tempDir)) {
            if (!mkdir($tempDir, 0777, true)) {
                Log::error('Unable to create directory: ' . $tempDir);
                return response()->json(['error' => 'Unable to create directory.'], 500);
            }
        }

        $files = [];

        foreach ($employeeIds as $employeeId) {
            $attendance = Attendance::where('user_id', $employeeId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->with('user')
                ->get();

            if ($attendance->isEmpty()) {
                continue;
            }

            $user = $attendance->first()->user;

            // Initialize total sum
            $total = 0;

            $data = $attendance->map(function ($record) use (&$total) {
                $format = 'F, j Y, g:i a';

                $amFirstPunch = $record->punch_in_am_first ? Carbon::parse($record->punch_in_am_first)->format($format) : 'N/A';
                $amSecondPunch = $record->punch_in_am_second ? Carbon::parse($record->punch_in_am_second)->format($format) : 'N/A';
                $pmFirstPunch = $record->punch_in_pm_first ? Carbon::parse($record->punch_in_pm_first)->format($format) : 'N/A';
                $pmSecondPunch = $record->punch_in_pm_second ? Carbon::parse($record->punch_in_pm_second)->format($format) : 'N/A';

                // Calculate total based on AM and PM statuses
                $dayTotal = 0;
                if ($record->punch_in_am_first && $record->punch_in_pm_first) {
                    $dayTotal = 1; // Full day
                } elseif (!$record->punch_in_am_first && $record->punch_in_pm_first) {
                    $dayTotal = 0.5; // Half day
                }

                // Add day total to the overall total
                $total += $dayTotal;

                return [
                    'Employee Name' => $record->user->name . ' ' . $record->user->lastname,
                    'Date' => Carbon::parse($record->date)->format('F, j Y'),
                    'AM First Punch' => $amFirstPunch,
                    'AM Second Punch' => $amSecondPunch,
                    'PM First Punch' => $pmFirstPunch,
                    'PM Second Punch' => $pmSecondPunch,
                    'Total' => $dayTotal, // Include the calculated total for the day
                ];
            })->toArray();

            // Add a final row to show the sum of all totals for the employee
            $data[] = [
                'Employee Name' => 'Total Days of ' . $user->name . ' ' . $user->lastname,
                'Date' => '',
                'AM First Punch' => '',
                'AM Second Punch' => '',
                'PM First Punch' => '',
                'PM Second Punch' => '',
                'Total' => $total, // Sum total for the employee
            ];

            $fileName = $user->name . '_' . $user->lastname . '_attendance.xlsx';
            $filePath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

            Excel::store(new AttendanceExport($data), 'public/temp_attendance_exports/' . $fileName);
            $files[] = $filePath;
        }

        $zipFileName = 'attendance_records_' . $month . '_' . $year . '.zip';
        $zipFilePath = $tempDir . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            Log::error('Unable to create ZIP file: ' . $zipFilePath);
            return response()->json(['error' => 'Unable to create ZIP file.'], 500);
        }

        foreach ($files as $file) {
            unlink($file);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }



}
