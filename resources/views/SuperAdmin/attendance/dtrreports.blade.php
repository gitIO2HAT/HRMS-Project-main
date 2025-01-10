<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Time Record Report</title>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 5px 0;

        }

        .header span {
            font-size: 18px;
            display: block;
            margin-top: 5px;
        }

        .border {

            border-bottom: 1px solid #000;
            display: table;
            width: 100%;
            font-size: 12px;
        }

        .border div {
            display: table-cell;
            width: 25%;
            vertical-align: middle;
        }

        .border div:first-child {
            text-align: left;
        }

        .border div:nth-child(2) {
            text-align: center;
        }

        .border div:nth-child(3) {
            text-align: center;
        }

        .border div:last-child {
            text-align: center;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            /* Adds border to the table, header, and cells */
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .HRMS {
            border-bottom: 1px solid #000;
        }
    </style>

</head>

<body>
    <header class="header">
        <h1>Daily Time Record</h1>
        <span>Province of Davao del Sur</span>
        <span>Municipality of Sulop</span>
        <h1 class="HRMS">HUMAN RESOURCE MANAGEMENT OFFICE</h1>
        <h1>ATTENDANCE SUMMARY REPORTS</h1>
    </header>

    <div class="border">
        <div>
            <p><b>SORTED BY:</b>{{ Auth::user()->lastname }}, {{ Auth::user()->name }}</p>
            @if ($employeeIds == !null)
            <p><b>Employee ID:</b> {{ $employeeIds }}</p>
            @endif

        </div>

        <div>
            @if ($timeframeStart && $timeframeEnd == !null)
            <p><b>TIME FRAME:</b> {{ \Carbon\Carbon::parse($timeframeStart)->format('Y, F j') }} -
                {{ \Carbon\Carbon::parse($timeframeEnd)->format('Y, F j') }}
            </p>
            @else
            <p><b>TIME FRAME:</b> All</p>
            @endif

        </div>
        <div>
            <p><b>Total Result:</b> {{ $recordCount }}</p>
        </div>
        <div>
            <p><b>DATE:</b> {{ \Carbon\Carbon::parse($dateNow)->format('Y, F j') }} </p>
        </div>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Full Name</th>
                    <th colspan="2">Morning</th>
                    <th colspan="2">Afernoon</th>
                    <th colspan="2">Undertime</th>
                </tr>
                <tr>

                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Hours</th>
                    <th>Minutes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailySeries as $date => $details)
                @php
                $currentDay = \Carbon\Carbon::parse($date)->format('M d');
                $isWeekend = in_array($date, $weekends); // Check if the date is a weekend
                $isHoliday = in_array($date, $holidays); // Check if the date is a holiday
                $dayRecords = $attendancegenerate->filter(function ($punch) use ($date) {
                return $punch->date === $date;
                });
                @endphp

                @if ($isWeekend && $dayRecords->isEmpty())
                {{-- Display "Weekend" if it's a weekend and no attendance records exist --}}
                <tr>
                    <td>{{ $currentDay }}</td>
                    <td colspan="8" style="color: blue;">Weekend</td>
                </tr>
                @elseif ($isHoliday && $dayRecords->isEmpty())
                {{-- Display "Holiday" if it's a holiday and no attendance records exist --}}
                <tr>
                    <td>{{ $currentDay }}</td>
                    <td colspan="8" style="color: green;">Holiday</td>
                </tr>
                @elseif ($dayRecords->isEmpty())
                {{-- Display a blank row for other days without attendance records --}}
                <tr>
                    <td>{{ $currentDay }}</td>
                    <td colspan="8">No records available</td>
                </tr>
                @else
                {{-- Display rows for days with attendance records --}}
                @foreach ($dayRecords as $index => $punch)
                @foreach ($attendanceData as $data)
                @if ($data['user_id'] === $punch->user_id && $data['date'] === $punch->date)
                <tr>
                    {{-- Display the Day only for the first record of the day --}}
                    <td>{{ $currentDay }}</td>

                    {{-- Display attendance details --}}
                    <td>
                        {{ $punch->user->lastname }}, {{ $punch->user->name }} {{ $punch->user->middlename }}
                        @if ($punch->user->suffix !== 'N/A') {{ $punch->user->suffix }} @endif
                    </td>
                    <td>
                        @if ($punch->punch_in_am_first != null)
                        {{ \Carbon\Carbon::parse($punch->punch_in_am_first)->format('g:i A') }}
                        @else
                        
                        @endif
                    </td>
                    <td>
                        @if ($punch->punch_in_am_second != null)
                        {{ \Carbon\Carbon::parse($punch->punch_in_am_second)->format('g:i A') }}
                        @else
                        
                        @endif
                    </td>
                    <td>
                        @if ($punch->punch_in_pm_first != null)
                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_first)->format('g:i A') }}
                        @else
                        
                        @endif
                    </td>
                    <td>
                        @if ($punch->punch_in_pm_second != null)
                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_second)->format('g:i A') }}
                        @else
                        
                        @endif
                    </td>
                    @if ($data['total_minutes'] <= 480)
                        @php
                        $remainingMinutes=480 - $data['total_minutes']; // Calculate the remaining minutes
                        $remainingHours=intdiv($remainingMinutes, 60); // Convert remaining minutes to hours
                        $remainingMinutesMod=$remainingMinutes % 60; // Calculate remaining minutes after hours
                        @endphp
                        @if ($remainingMinutesMod> 10)
                        <td style="color: red;">{{ $remainingHours }}</td>
                        <td style="color: red;">{{ $remainingMinutesMod }}</td>
                        @else
                        <td></td>
                        <td></td>
                        @endif
                        @endif
                </tr>
                @endif
                @endforeach
                @endforeach
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>