@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="row g-4">
                    <div class="pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-xl-12">
                                <div class="bg-white rounded-3 h-100 p-4">
                                    <h6 class="mb-4 text-center text-dark">Attendance Records</h6>
                                    <form method="GET" action="{{ url('/SuperAdmin/Attendance') }}">
                                        <div class="d-flex align-content-center mb-3">
                                            @csrf
                                            <label class="text-dark" for="search">Employee Name:</label>
                                            <input type="text" name="search" id="search"
                                                value="{{ request('search') }}" placeholder="Search by Name" class="modify">

                                            <label class="text-dark" for="month">Select Month:</label>
                                            <select name="month" id="month" class="modify">
                                                @for ($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m }}"
                                                        {{ $selectedMonth == $m ? 'selected' : '' }}>
                                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <label class="text-dark" for="year">Select Year:</label>
                                            <select name="year" id="year" class="modify">
                                                @for ($y = Carbon\Carbon::now()->year; $y >= Carbon\Carbon::now()->year - 5; $y--)
                                                    <option value="{{ $y }}"
                                                        {{ $selectedYear == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <button class="btn btn-success" type="submit">Search</button>
                                        </div>
                                    </form>
                                    <form method="POST" action="{{ url('/SuperAdmin/Attendance/ExportExcelAttendance') }}" id="export-form">
                                        @csrf
                                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                                        <input type="hidden" name="year" value="{{ $selectedYear }}">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-dark text-center">
                                                    <tr class="bg-title">
                                                        <th class="centered">Select</th>
                                                        <th class="centered">Employee Name</th>
                                                        @foreach ($dailySeries as $date => $duration)
                                                            <th>{{ \Carbon\Carbon::parse($date)->format('M d') }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    @foreach ($employeeRecords as $record)
                                                        <tr>
                                                            <td class="text-dark centered">
                                                                <input type="checkbox" name="custom_ids[]" value="{{ $record->custom_id }}" class="employee-checkbox"></td>
                                                            </td>
                                                            <td class="text-dark  d-flex align-items-center">
                                                                <img class="rounded-circle me-lg-2"
                                                                    src="{{ asset('public/accountprofile/' . $record->profile_pic) }}"
                                                                    alt="" style="width: 40px; height: 40px;">
                                                                {{ $record->name }} {{ $record->lastname }}
                                                            </td>
                                                            @foreach ($dailySeries as $date => $duration)
                                                                <td class="text-dark centered">
                                                                    @php
                                                                        $attendance = $RecordsAttendance
                                                                            ->where('user_id', $record->custom_id)
                                                                            ->where('date', $date)
                                                                            ->first();
                                                                        $amFirst =
                                                                            $attendance &&
                                                                            $attendance->punch_in_am_first
                                                                                ? '✔'
                                                                                : '✘';
                                                                        $amSecond =
                                                                            $attendance &&
                                                                            $attendance->punch_in_am_second
                                                                                ? '✔'
                                                                                : '✘';
                                                                        $pmFirst =
                                                                            $attendance &&
                                                                            $attendance->punch_in_pm_first
                                                                                ? '✔'
                                                                                : '✘';
                                                                        $pmSecond =
                                                                            $attendance &&
                                                                            $attendance->punch_in_pm_second
                                                                                ? '✔'
                                                                                : '✘';

                                                                        $amStatus =
                                                                            $amFirst === '✔' && $amSecond === '✔'
                                                                                ? '✔'
                                                                                : '✘';
                                                                        $pmStatus =
                                                                            $pmFirst === '✔' && $pmSecond === '✔'
                                                                                ? '✔'
                                                                                : '✘';
                                                                        $finalStatus =
                                                                            $amStatus === '✔' && $pmStatus === '✔'
                                                                                ? '✔'
                                                                                : '✘';

                                                                        // Additional logic to display CHECK MARK and XMARK as per requirements
                                                                        if ($amStatus === '✔' && $pmStatus === '✘') {
                                                                            $displayStatus = '✔ ✘';
                                                                        } elseif (
                                                                            $amStatus === '✘' &&
                                                                            $pmStatus === '✔'
                                                                        ) {
                                                                            $displayStatus = '✘ ✔';
                                                                        } elseif (
                                                                            $amStatus === '✔' &&
                                                                            $pmStatus === '✔'
                                                                        ) {
                                                                            $displayStatus = '✔';
                                                                        } elseif (
                                                                            $amStatus === '✘' &&
                                                                            $pmStatus === '✘'
                                                                        ) {
                                                                            $displayStatus = '✘';
                                                                        } else {
                                                                            $displayStatus =
                                                                                $amStatus . ' and ' . $pmStatus;
                                                                        }
                                                                    @endphp

                                                                    @if ($displayStatus === '✔ ✘')
                                                                        <i class="fas fa-check-square"
                                                                            style="color: #63E6BE;"></i> <i
                                                                            class="fas fa-window-close"
                                                                            style="color: #e22c2c;"></i>
                                                                    @elseif ($displayStatus === '✘ ✔')
                                                                        <i class="fas fa-window-close"
                                                                            style="color: #e22c2c;"></i> <i
                                                                            class="fas fa-check-square"
                                                                            style="color: #63E6BE;"></i>
                                                                    @elseif ($displayStatus === '✔')
                                                                        <i class="fas fa-check-square"
                                                                            style="color: #63E6BE;"></i>
                                                                    @elseif ($displayStatus === '✘')
                                                                        <i class="fas fa-window-close"
                                                                            style="color: #e22c2c;"></i>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $employeeRecords->onEachSide(1)->links() }}
                                        </div>
                                        <button type="submit" class="hidden" style="display: none;">Export</button>
                                        <div class="d-flex align-items-center">
                                            <a href="#" id="export-btn" style="display: none;">Export</a>
                                            <a href="#" id="select-all" class="mx-3" style="display: none;">Select All</a>
                                            <a href="#" id="deselect-all" class="mx-3" style="display: none;">Deselect All</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <div class="col-sm-12 col-xl-12">
                                <div class="row g-4">
                                    <div class=" pt-4 px-4 ">
                                        <div class="row g-4">
                                            <div class="col-sm-12 col-xl-7 rounded">
                                                <div class=" bg-white rounded-3  h-100 p-4">
                                                    <h1 class="mb-6 text-start text-dark">
                                                        <div id="current-date-superadmin"></div>
                                                    </h1>

                                                    <div style="background-color:#f9f9f9" class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                                                        <h6 class="text-start text-dark">Punch In at</h6>
                                                        <div id="current-date1-superadmin"></div>

                                                    </div>


                                                    <h3 class="text-dark hours-circle"><span id="todays-hours">0s</span></h3>

                                                    <div class="d-flex justify-content-center">
                                                        <form action="{{ ('/SuperAdmin/ClockIn') }}" method="POST" class="me-2">
                                                            @csrf
                                                            <button type="submit" class="btn btn-orange hidden rounded-pill" id="clockInButton">Clock In</button>
                                                        </form>
                                                        <form action="{{ ('/SuperAdmin/ClockOut') }}" method="POST" class="me-2">
                                                            @csrf
                                                            <button type="submit" class="btn btn-orange hidden rounded-pill" id="clockOutButton">Clock Out</button>
                                                        </form>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-sm-12 col-xl-5 rounded">
                                                <div class="bg-white rounded-3 h-100 p-4">
                                                    <div class="row g-4">
                                                        <div class="col-sm-12">
                                                            <div class="bg-white rounded-3 h-100 p-4">
                                                                <h4 class="text-dark mb-4">Statistics</h4>
                                                                <div class="bg-today shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                    <div class="d-flex justify-content-between">
                                                                        <h6 class="text-start text-dark">Today</h6>
                                                                        <span id="todays-hours-stat">0 / 8 hrs</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <progress id="progressBar" value="0" max="28800"></progress>
                                                                    </div>
                                                                </div>

                                                                <div class="bg-week shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                    <div class="d-flex justify-content-between">
                                                                        <h6 class="text-start text-dark">This Week</h6>
                                                                        <span id="week-stats">{{$weeklyFinal}} / 40 hrs</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <progress id="progressBar" value="{{$weeklyProgressBar}}" max="144000"></progress>
                                                                    </div>
                                                                </div>

                                                                <div class="bg-month shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                    <div class="d-flex justify-content-between">
                                                                        <h6 class="text-start text-dark">This Month</h6>
                                                                        <span id="month-stats">{{$monthlyFinal}}/ 160 hrs</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <progress id="progressBar" value="{{$monthlyProgressBar}}" max="576000"></progress>
                                                                    </div>
                                                                </div>

                                                                <div class="bg-remaining shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                    <div class="d-flex justify-content-between">
                                                                        <h6 class="text-start text-dark">Remaining</h6>
                                                                        <span id="month-stats">{{$monthlyRemainingFinals}}/ 160 hrs</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <progress id="progressBar" value="{{$monthlyRemaining}}" max="576000"></progress>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                    <script>
                                        function updateDateTime() {
                                            const today = new Date();
                                            const day = today.getDate();
                                            const monthNames = [
                                                "January", "February", "March", "April", "May", "June",
                                                "July", "August", "September", "October", "November", "December"
                                            ];
                                            const month = monthNames[today.getMonth()];
                                            const year = today.getFullYear();

                                            const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                                            const dayOfWeek = daysOfWeek[today.getDay()];
                                            let hours = today.getHours();
                                            const minutes = today.getMinutes().toString().padStart(2, '0');
                                            const seconds = today.getSeconds().toString().padStart(2, '0');
                                            const ampm = hours >= 12 ? 'PM' : 'AM';
                                            hours = hours % 12;
                                            hours = hours ? hours : 12; // the hour '0' should be '12'
                                            const timeString = `${hours}:${minutes}:${seconds}${ampm}`;

                                            const dateString =
                                                `<span class="timesheet">Timesheet</span> <span class="date">${day} ${month} ${year} <span> `;
                                            document.getElementById('current-date-superadmin').innerHTML = dateString;
                                        }

                                        // Update the date and time every second
                                        setInterval(updateDateTime, 1000);

                                        // Initial call to display the date and time immediately on page load
                                        updateDateTime();
                                    </script>
                                    <script>
                                        function updateTime() {
                                            const today1 = new Date();
                                            const day1 = today1.getDate();
                                            const daySuffix1 = (day1) => {
                                                if (day1 > 3 && day1 < 21) return 'th';
                                                switch (day1 % 10) {
                                                    case 1:
                                                        return "st";
                                                    case 2:
                                                        return "nd";
                                                    case 3:
                                                        return "rd";
                                                    default:
                                                        return "th";
                                                }
                                            };

                                            const daysOfWeek1 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
                                            const months1 = [
                                                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                            ];

                                            const dayOfWeek1 = daysOfWeek1[today1.getDay()];
                                            const month1 = months1[today1.getMonth()];
                                            const year1 = today1.getFullYear();

                                            let hours1 = today1.getHours();
                                            const minutes1 = today1.getMinutes().toString().padStart(2, '0');
                                            const seconds1 = today1.getSeconds().toString().padStart(2, '0');
                                            const ampm1 = hours1 >= 12 ? ' PM' : ' AM';
                                            hours1 = hours1 % 12;
                                            hours1 = hours1 ? hours1 : 12; // the hour '0' should be '12'
                                            const timeString1 = `${hours1}:${minutes1}:${seconds1}${ampm1}`;

                                            const dateString1 =
                                                `<span class="date1">${dayOfWeek1}, ${day1}${daySuffix1(day1)} ${month1} ${year1} ${timeString1}</span>`;
                                            document.getElementById('current-date1-superadmin').innerHTML = dateString1;
                                        }

                                        // Update the time every second
                                        setInterval(updateTime, 1000);

                                        // Initial call to display the time immediately on page load
                                        updateTime();
                                    </script>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let intervalId;
                                            let totalDuration = 0;
                                            const progressBar = document.getElementById("progressBar");

                                            function updateDisplay() {
                                                const hours = Math.floor(totalDuration / 3600);
                                                const minutes = Math.floor((totalDuration % 3600) / 60);
                                                const seconds = totalDuration % 60;

                                                const hoursDisplay = hours > 0 ? `${hours}h ` : "";
                                                const minutesDisplay = minutes > 0 ? `${minutes}m ` : "";
                                                const secondsDisplay = `${seconds}s`;

                                                document.getElementById("todays-hours").textContent = hoursDisplay + minutesDisplay + secondsDisplay;
                                                document.getElementById("todays-hours-stat").textContent = hoursDisplay + minutesDisplay + secondsDisplay + ' / 8 hrs'; // Update this span
                                                progressBar.value = totalDuration; // Update progress bar
                                            }

                                            function fetchCurrentTime() {
                                                fetch("{{ route('current-time-superadmin') }}")
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        totalDuration = data.totalDuration;
                                                        updateDisplay();
                                                    })
                                                    .catch(error => console.error("Error fetching current time:", error));
                                            }

                                            function startTimer() {
                                                intervalId = setInterval(() => {
                                                    totalDuration++;
                                                    updateDisplay();
                                                }, 1000);
                                            }

                                            function stopTimer() {
                                                clearInterval(intervalId);
                                            }

                                            fetchCurrentTime();

                                            document.getElementById("clockInButton").addEventListener("click", function() {
                                                startTimer();
                                            });

                                            document.getElementById("clockOutButton").addEventListener("click", function() {
                                                stopTimer();
                                            });

                                            // Initial display update
                                            setInterval(updateDisplay, 60000);
                                            updateDisplay();
                                        });
                                    </script>

                                    <script>
                                        async function fetchInternetTime() {
                                            try {
                                                const response = await fetch(`http://api.timezonedb.com/v2.1/get-time-zone?key=INQ8VCI2UGFC&format=json&by=zone&zone=Asia/Manila`);
                                                if (!response.ok) {
                                                    throw new Error('Network response was not ok');
                                                }
                                                const data = await response.json();
                                                return new Date(data.formatted);
                                            } catch (error) {
                                                console.error('There was a problem with the fetch operation:', error);
                                                return null;
                                            }
                                        }

                                        async function checkTimeAndDisplayButton() {
                                            const now = await fetchInternetTime();
                                            if (!now) {
                                                console.error('Unable to fetch the internet time');
                                                return;
                                            }

                                            const formatter = new Intl.DateTimeFormat('en-US', {
                                                timeZone: 'Asia/Manila',
                                                hour: '2-digit',
                                                minute: '2-digit',
                                                hour12: false
                                            });

                                            const formattedTime = formatter.formatToParts(now);
                                            const hours = parseInt(formattedTime.find(part => part.type === 'hour').value);
                                            const minutes = parseInt(formattedTime.find(part => part.type === 'minute').value);

                                            const isClockInTime = (
                                                (hours === 14 && minutes >= 0 && minutes <= 59) ||
                                                (hours === 8 && minutes >= 0 && minutes <= 15) ||
                                                (hours === 12 && minutes >= 31 && minutes <= 59) ||
                                                (hours === 13 && minutes >= 0 && minutes <= 15)
                                            );

                                            const isClockOutTime = (
                                                (hours === 14 && minutes >= 0 && minutes <= 59) ||
                                                (hours === 17 && minutes >= 0 && minutes <= 59) ||
                                                (hours === 18 && minutes === 0)
                                            );

                                            document.getElementById('clockInButton').style.display = isClockInTime ? 'block' : 'none';
                                            document.getElementById('clockOutButton').style.display = isClockOutTime ? 'block' : 'none';
                                        }

                                        // Check every minute if the button should be displayed
                                        setInterval(checkTimeAndDisplayButton, 60000);

                                        // Initial check when the page loads
                                        checkTimeAndDisplayButton();
                                    </script>

                @endsection
