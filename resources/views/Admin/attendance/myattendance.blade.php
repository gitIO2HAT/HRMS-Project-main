@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="row g-4">
                                <div class=" pt-4 px-4 ">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-xl-7 rounded">
                                            <div class=" bg-white rounded-3  h-100 p-4">
                                                <h1 class="mb-6 text-start text-dark">
                                                    <div id="current-date-admin"></div>
                                                </h1>
                                                <div style="background-color:#f9f9f9"
                                                    class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                                                    <h6 class="text-start text-dark">Punch In at</h6>
                                                    <div id="current-date1-admin"></div>

                                                </div>
                                                <h3 class="text-dark hours-circle"><span id="todays-hours">0s</span>
                                                </h3>
                                                <div class="d-flex justify-content-center">
                                                    <form action="{{ '/Admin/ClockIn' }}" method="POST"
                                                        class="me-2">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-orange hidden rounded-pill"
                                                            id="clockInButton">Clock In</button>
                                                    </form>
                                                    <form action="{{ '/Admin/ClockOut' }}" method="POST"
                                                        class="me-2">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-orange hidden rounded-pill"
                                                            id="clockOutButton">Clock Out</button>
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
                                                            <div
                                                                class="bg-today shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                <div class="d-flex justify-content-between">
                                                                    <h6 class="text-start text-dark">Today</h6>
                                                                    <span id="todays-hours-stat">0 / 8 hrs</span>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <progress id="progressBar" value="0"
                                                                        max="28800"></progress>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="bg-week shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                <div class="d-flex justify-content-between">
                                                                    <h6 class="text-start text-dark">This Week</h6>
                                                                    <span id="week-stats">{{ $weeklyFinal }} / 40
                                                                        hrs</span>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <progress id="progressBar"
                                                                        value="{{ $weeklyProgressBar }}"
                                                                        max="144000"></progress>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="bg-month shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                <div class="d-flex justify-content-between">
                                                                    <h6 class="text-start text-dark">This Month</h6>
                                                                    <span id="month-stats">{{ $monthlyFinal }}/ 160
                                                                        hrs</span>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <progress id="progressBar"
                                                                        value="{{ $monthlyProgressBar }}"
                                                                        max="576000"></progress>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="bg-remaining shadow-sm p-3 mb-5 bg-body-tertiary rounded-2 ">
                                                                <div class="d-flex justify-content-between">
                                                                    <h6 class="text-start text-dark">Remaining</h6>
                                                                    <span
                                                                        id="month-stats">{{ $monthlyRemainingFinals }}/
                                                                        160 hrs</span>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <progress id="progressBar"
                                                                        value="{{ $monthlyRemaining }}"
                                                                        max="576000"></progress>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="generateReportsModal" tabindex="-1" aria-labelledby="generateReportsModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-dark" id="generateReportsModalLabel">Generate Reports</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('/Admin/Attendance/GenerateReports') }}" method="POST">
                                                            @csrf <!-- Add CSRF token for security -->
                                                            <label class="text-dark" for="employeeIds">Select User</label>
                                                            <select id="employeeIds" name="employeeIds" class="form-control underline-input">
                                                                <option value="" selected>--Select All--</option>
                                                                @foreach ($users as $user)
                                                                <option value="{{ $user->custom_id }}">{{ $user->lastname }}, {{ $user->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <label for="timeframeStart">From:</label>
                                                            <input type="date" name="timeframeStart" id="timeframeStart"
                                                                class="form-control underline-input">
                                                            <label for="timeframeEnd">To:</label>
                                                            <input type="date" name="timeframeEnd" id="timeframeEnd"
                                                                class="form-control underline-input">
                                                            <div class="text-center mt-1">
                                                                <button type="submit" class="btn btn-info">Generate Reports</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-12 ">
                                            <div class="bg-white rounded-3 h-100 p-4">
                                                <table
                                                    class="table table-striped table-hover table-responsive table-bordered">
                                                    <thead class="text-dark text-center">
                                                        <tr>
                                                            <th class="bg-head" scope="col" colspan="7">
                                                                My Attendance</th>
                                                        </tr>
                                                        <tr class="bg-title">
                                                            <th class="centered" scope="col" rowspan="2">#</th>
                                                            <th class="centered" scope="col" rowspan="2">
                                                                Employee Name</th>
                                                            <th class="centered" scope="col" rowspan="2">Date
                                                            </th>
                                                            <th scope="col" colspan="2">Morning</th>
                                                            <th scope="col" colspan="2">Afternoon</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-morning" scope="col">Clock In</th>
                                                            <th class="bg-afternoon" scope="col">Clock Out</th>
                                                            <th class="bg-morning" scope="col">Clock In</th>
                                                            <th class="bg-afternoon" scope="col">Clock Out</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        @foreach ($getall as $index => $punch)

                                                        <tr>
                                                            <th scope="row">{{ ($getall->currentPage() - 1) * $getall->perPage() + $index + 1 }}</th>
                                                            <td><img class="rounded-circle me-lg-2"
                                                                    src="{{ asset('public/accountprofile/' . $punch->user->profile_pic) }}"
                                                                    alt=""
                                                                    style="width: 40px; height: 40px;">
                                                                {{ $punch->user->lastname }}, {{ $punch->user->name }} {{ $punch->user->middlename }} @if($punch->user->suffix == 'N/A')  @else {{$punch->user->suffix}}@endif
                                                            </td>
                                                            <td class="text-dark"> 
                                                                {{ \Carbon\Carbon::parse($punch->date)->format('Y, F j') }}
                                                            </td>
                                                            <td class="text-dark">
                                                                @if (is_null($punch->punch_in_am_first))
                                                                NO DATA
                                                                @else
                                                                {{ \Carbon\Carbon::parse($punch->punch_in_am_first)->format('g:i A') }}
                                                                @endif
                                                            </td>
                                                            <td class="text-dark">
                                                                @if (is_null($punch->punch_in_am_second))
                                                                NO DATA
                                                                @else
                                                                {{ \Carbon\Carbon::parse($punch->punch_in_am_second)->format('g:i A') }}
                                                                @endif
                                                            </td>
                                                            <td class="text-dark">
                                                                @if (is_null($punch->punch_in_pm_first))
                                                                NO DATA
                                                                @else
                                                                {{ \Carbon\Carbon::parse($punch->punch_in_pm_first)->format('g:i A') }}
                                                                @endif
                                                            </td>
                                                            <td class="text-dark">
                                                                @if (is_null($punch->punch_in_pm_second))
                                                                NO DATA
                                                                @else
                                                                {{ \Carbon\Carbon::parse($punch->punch_in_pm_second)->format('g:i A') }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        @endforeach

                                                    </tbody>
                                                </table>
                                                {{ $getPunch->onEachSide(1)->links() }}
                                                @foreach($getNot['getNotify'] as $unread)
                                                <!-- Modal -->
                                                <div class="modal fade" id="descriptionModal{{ $unread->id }}" tabindex="-1" aria-labelledby="descriptionModalLabel{{ $unread->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-dark" id="descriptionModalLabel{{ $unread->id }}">{{$unread->title_message}}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $unread->description_message }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                @if(Auth::user()->user_type == 0)
                                                                <a href="{{ url('SuperAdmin/Read/'.$unread->id)}}" class="btn btn-success">Ok!</a>
                                                                @elseif(Auth::user()->user_type == 1)
                                                                <a href="{{ url('Admin/Read/'.$unread->id)}}" class="btn btn-success">Ok!</a>
                                                                @elseif(Auth::user()->user_type == 2)
                                                                <a href="{{ url('Employee/Read/'.$unread->id)}}" class="btn btn-success">Ok!</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
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
                                                        document.getElementById('current-date-admin').innerHTML = dateString;
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
                                                        document.getElementById('current-date1-admin').innerHTML = dateString1;
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

                                                            document.getElementById("todays-hours").textContent = hoursDisplay + minutesDisplay +
                                                                secondsDisplay;
                                                            document.getElementById("todays-hours-stat").textContent = hoursDisplay + minutesDisplay +
                                                                secondsDisplay + ' / 8 hrs'; // Update this span
                                                            progressBar.value = totalDuration; // Update progress bar
                                                        }

                                                        function fetchCurrentTime() {
                                                            fetch("{{ route('current-time-admin') }}")
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
                                                            const response = await fetch(
                                                                `http://api.timezonedb.com/v2.1/get-time-zone?key=INQ8VCI2UGFC&format=json&by=zone&zone=Asia/Manila`
                                                            );
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

                                                        /*  const isClockInTime = (
                                                              (hours === 7 && minutes >= 0 && minutes <= 59) ||
                                                              (hours === 8 && minutes >= 0 && minutes <= 15) ||
                                                              (hours === 12 && minutes >= 31 && minutes <= 59) ||
                                                              (hours === 13 && minutes >= 0 && minutes <= 15)
                                                          );

                                                          const isClockOutTime = (
                                                              (hours === 12 && minutes >= 0 && minutes <= 30) ||
                                                              (hours === 17 && minutes >= 0 && minutes <= 59) ||
                                                              (hours === 18 && minutes === 0)
                                                          );
                                                          */
                                                        const isClockInTime = true;

                                                        // Always allow clock-out at any time
                                                        const isClockOutTime = true;

                                                        document.getElementById('clockInButton').style.display = isClockInTime ? 'block' : 'none';
                                                        document.getElementById('clockOutButton').style.display = isClockOutTime ? 'block' : 'none';
                                                    }

                                                    // Check every minute if the button should be displayed
                                                    setInterval(checkTimeAndDisplayButton, 60000);

                                                    // Initial check when the page loads
                                                    checkTimeAndDisplayButton();
                                                </script>
                                                @endsection