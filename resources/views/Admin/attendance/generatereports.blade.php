<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance History</title>
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
        <h1>LOCAL GOVERNMENT UNIT OF SULOP</h1>
        <span>Province of Davao del Sur</span>
        <span>Municipality of Sulop</span>
        <h1 class="HRMS">HUMAN RESOURCE MANAGEMENT OFFICE</h1>
        <h1>ATTENDANCE SUMMARY REPORTS</h1>
    </header>

    <div class="border">
        <div>
            <p><b>SORTED BY:</b>{{ Auth::user()->lastname }}, {{ Auth::user()->name }} {{ Auth::user()->middlename }} @if(Auth::user()->suffix == 'N/A')  @else {{Auth::user()->suffix}}@endif</p>
            @if ($employeeIds == !null)
                <p><b>Employee ID:</b> {{ $employeeIds }}</p>
            @endif

        </div>

        <div>
            @if ($timeframeStart && $timeframeEnd == !null)
                <p><b>TIME FRAME:</b> {{ \Carbon\Carbon::parse($timeframeStart)->format('Y, F j') }} -
                    {{ \Carbon\Carbon::parse($timeframeEnd)->format('Y, F j') }}</p>
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
                    <th  rowspan="2">Full Name</th>
                    <th  rowspan="2">Date</th>
                    <th colspan="2">Morning</th>
                    <th colspan="2">Afernoon</th>
                </tr>
                <tr>

                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendancedata as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->user->lastname }}, {{ $data->user->name }} {{ $data->user->middlename }} @if($data->user->suffix == 'N/A')  @else {{$data->user->suffix}}@endif</td>
                        <td>{{ \Carbon\Carbon::parse($data->date)->format('Y, F j') }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->punch_in_am_first)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->punch_in_am_second)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->punch_in_pm_first)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->punch_in_pm_second)->format('g:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
