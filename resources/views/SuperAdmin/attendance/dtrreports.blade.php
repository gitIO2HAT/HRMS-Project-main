<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-size: 12px;
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
    <div class="container">
        <div class="row g-4">
            <div class="col-12 d-flex justify-content-around">
                <div>
                    <header class="header">
                        <span style="text-align: start;">Civil Service Form No.48</span>
                        <span style="font-size: 14px"><b>DAILY TIME RECORD</b></span>
                        <span>-----o0o-----</span>
                        <span style="font-size: 14px"><u><b>{{ Auth::user()->lastname }}, {{ Auth::user()->name }}</b></u></span>
                        <span><b>(Name)</b></span>
                        <span style="text-align: start;">For the month of <u>TEST MONTH</u></span>
                        <span style="text-align: start;">Official hours for Regular days <u>100</u></span>
                        <span style="text-align: start;">Arrival and Departure Saturday <u>123</u></span>
                    </header>

                    <div>
                        <table style="font-size:8px;">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th colspan="2">AM</th>
                                    <th colspan="2">PM</th>
                                    <th colspan="2">Undertime</th>
                                </tr>
                                <tr>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Hours</th>
                                    <th>Minutes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailySeries as $date => $details)
                                @php
                                $currentDay = \Carbon\Carbon::parse($date)->format('d');
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
                                <tr>
                                    {{-- Display the Day only for the first record of the day --}}
                                    <td>{{ $currentDay }}</td>

                                    {{-- Display attendance details --}}
                                    <td>
                                        @if ($punch->punch_in_am_first != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_am_first)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_am_second != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_am_second)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_pm_first != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_first)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_pm_second != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_second)->format('g:i A') }}
                                        @endif
                                    </td>

                                    @php
                                    $total_minutes_am = 0;
                                    $total_minutes_pm = 0;

                                    // Morning punch-in and punch-out
                                    if (!empty($punch['punch_in_am_first']) && !empty($punch['punch_in_am_second'])) {
                                    $punch_in_time = (new DateTime($punch['punch_in_am_first']))->format('H:i:s');
                                    $punch_out_time = (new DateTime($punch['punch_in_am_second']))->format('H:i:s');

                                    if ($punch_in_time < '08:00:00' || $punch_out_time> '12:00:00') {
                                        $punch_in = new DateTime("08:00:00");
                                        $punch_out = new DateTime("12:00:00");
                                        } else {
                                        $punch_in = new DateTime($punch['punch_in_am_first']);
                                        $punch_out = new DateTime($punch['punch_in_am_second']);
                                        }

                                        $interval = $punch_in->diff($punch_out);
                                        $total_minutes_am = ($interval->h * 60) + $interval->i;
                                        }

                                        // Afternoon punch-in and punch-out
                                        if (!empty($punch['punch_in_pm_first']) && !empty($punch['punch_in_pm_second'])) {
                                        $punch_in_time_pm = (new DateTime($punch['punch_in_pm_first']))->format('H:i:s');
                                        $punch_out_time_pm = (new DateTime($punch['punch_in_pm_second']))->format('H:i:s');

                                        if ($punch_in_time_pm < '13:00:00' || $punch_out_time_pm> '17:00:00') {
                                            $punch_in_pm = new DateTime("13:00:00");
                                            $punch_out_pm = new DateTime("17:00:00");
                                            } else {
                                            $punch_in_pm = new DateTime($punch['punch_in_pm_first']);
                                            $punch_out_pm = new DateTime($punch['punch_in_pm_second']);
                                            }

                                            $interval_pm = $punch_in_pm->diff($punch_out_pm);
                                            $total_minutes_pm = ($interval_pm->h * 60) + $interval_pm->i;
                                            }

                                            // Total minutes
                                            $total = $total_minutes_am + $total_minutes_pm;
                                            @endphp


                                            @php
                                            $remainingMinutes=480 - $total; // Calculate the remaining minutes
                                            $remainingHours=intdiv($remainingMinutes, 60); // Convert remaining minutes to hours
                                            $remainingMinutesMod=$remainingMinutes % 60; // Calculate remaining minutes after hours
                                            @endphp


                                            @if($remainingHours === 0 && $remainingMinutesMod < 10 )
                                                <td>
                                                </td>
                                                <td></td>
                                                @else
                                                <td style="color:red;">{{$remainingHours}}</td>
                                                <td style="color:red;">{{$remainingMinutesMod}}</td>
                                                @endif

                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                <div>
                    <header class="header">
                        <span style="text-align: start;">Civil Service Form No.48</span>
                        <span style="font-size: 14px"><b>DAILY TIME RECORD</b></span>
                        <span>-----o0o-----</span>
                        <span style="font-size: 14px"><u><b>{{ Auth::user()->lastname }}, {{ Auth::user()->name }}</b></u></span>
                        <span><b>(Name)</b></span>
                        <span style="text-align: start;">For the month of <u>TEST MONTH</u></span>
                        <span style="text-align: start;">Official hours for Regular days <u>100</u></span>
                        <span style="text-align: start;">Arrival and Departure Saturday <u>123</u></span>
                    </header>

                    <div>
                        <table style="font-size:8px;">
                            <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th colspan="2">AM</th>
                                    <th colspan="2">PM</th>
                                    <th colspan="2">Undertime</th>
                                </tr>
                                <tr>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th>Departure</th>
                                    <th>Hours</th>
                                    <th>Minutes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailySeries as $date => $details)
                                @php
                                $currentDay = \Carbon\Carbon::parse($date)->format('d');
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
                                <tr>
                                    {{-- Display the Day only for the first record of the day --}}
                                    <td>{{ $currentDay }}</td>

                                    {{-- Display attendance details --}}
                                    <td>
                                        @if ($punch->punch_in_am_first != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_am_first)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_am_second != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_am_second)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_pm_first != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_first)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($punch->punch_in_pm_second != null)
                                        {{ \Carbon\Carbon::parse($punch->punch_in_pm_second)->format('g:i A') }}
                                        @endif
                                    </td>

                                    @php
                                    $total_minutes_am = 0;
                                    $total_minutes_pm = 0;

                                    // Morning punch-in and punch-out
                                    if (!empty($punch['punch_in_am_first']) && !empty($punch['punch_in_am_second'])) {
                                    $punch_in_time = (new DateTime($punch['punch_in_am_first']))->format('H:i:s');
                                    $punch_out_time = (new DateTime($punch['punch_in_am_second']))->format('H:i:s');

                                    if ($punch_in_time < '08:00:00' || $punch_out_time> '12:00:00') {
                                        $punch_in = new DateTime("08:00:00");
                                        $punch_out = new DateTime("12:00:00");
                                        } else {
                                        $punch_in = new DateTime($punch['punch_in_am_first']);
                                        $punch_out = new DateTime($punch['punch_in_am_second']);
                                        }

                                        $interval = $punch_in->diff($punch_out);
                                        $total_minutes_am = ($interval->h * 60) + $interval->i;
                                        }

                                        // Afternoon punch-in and punch-out
                                        if (!empty($punch['punch_in_pm_first']) && !empty($punch['punch_in_pm_second'])) {
                                        $punch_in_time_pm = (new DateTime($punch['punch_in_pm_first']))->format('H:i:s');
                                        $punch_out_time_pm = (new DateTime($punch['punch_in_pm_second']))->format('H:i:s');

                                        if ($punch_in_time_pm < '13:00:00' || $punch_out_time_pm> '17:00:00') {
                                            $punch_in_pm = new DateTime("13:00:00");
                                            $punch_out_pm = new DateTime("17:00:00");
                                            } else {
                                            $punch_in_pm = new DateTime($punch['punch_in_pm_first']);
                                            $punch_out_pm = new DateTime($punch['punch_in_pm_second']);
                                            }

                                            $interval_pm = $punch_in_pm->diff($punch_out_pm);
                                            $total_minutes_pm = ($interval_pm->h * 60) + $interval_pm->i;
                                            }

                                            // Total minutes
                                            $total = $total_minutes_am + $total_minutes_pm;
                                            @endphp


                                            @php
                                            $remainingMinutes=480 - $total; // Calculate the remaining minutes
                                            $remainingHours=intdiv($remainingMinutes, 60); // Convert remaining minutes to hours
                                            $remainingMinutesMod=$remainingMinutes % 60; // Calculate remaining minutes after hours
                                            @endphp


                                            @if($remainingHours === 0 && $remainingMinutesMod < 10 )
                                                <td>
                                                </td>
                                                <td></td>
                                                @else
                                                <td style="color:red;">{{$remainingHours}}</td>
                                                <td style="color:red;">{{$remainingMinutesMod}}</td>
                                                @endif

                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>