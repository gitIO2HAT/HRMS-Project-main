@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">

                <div class=" pt-4 px-4 ">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-7 rounded">
                            <div class="bg-white rounded-3  h-100 p-4">
                                <h1 class="mb-6 text-start text-dark">
                                    <div id="current-date"></div>
                                </h1>
                                <div style="background-color:#f9f9f9" class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                                    <h6 class="text-start text-dark">Punch In at</h6>
                                    <div id="current-date1"></div>

                                </div>
                                @include('layouts._message')

                                <h3 class="text-dark hours-circle"><span id="todays-hours">0s</span></h3>

                                <div class="d-flex justify-content-center">
                                    <form action="{{ ('/Employee/ClockIn') }}" method="POST" class="me-2">
                                        @csrf
                                        <button type="submit" class="btn btn-orange hidden rounded-pill" id="clockInButton">Clock In</button>
                                    </form>

                                    <form action="{{ ('/Employee/ClockOut') }}" method="POST">
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
                                            <div>

                                            <h4 class="text-dark mb-4"></h4>
                                                <div class="d-flex justify-content-between">
                                                    <span>Today</span>
                                                    <progress id="progressBar" value="0" max="28800"></progress>
                                                    <span id="todays-hours-stat">0 / 8 hrs</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>This Week</span>
                                                    <progress id="progressBar" value="{{$weeklyProgressBar}}" max="144000"></progress>


                                                    <span id="week-stats">{{$weeklyFinal}} / 40 hrs</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>This Month</span>
                                                    <progress  id="progressBar" value="{{$monthlyProgressBar}}" max="576000"></progress>
                                                    <span id="month-stats">{{$monthlyFinal}}/ 160 hrs</span>
                                                </div>
                                            </div>
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
                        document.getElementById('current-date').innerHTML = dateString;
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
                        document.getElementById('current-date1').innerHTML = dateString1;
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
                            document.getElementById("todays-hours-stat").textContent = hoursDisplay + ' / 8 hrs'; // Update this span
                            progressBar.value = totalDuration; // Update progress bar
                        }

                        function fetchCurrentTime() {
                            fetch("{{ route('current-time') }}")
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
                        setInterval(updateDisplay, 1000);
                        updateDisplay();
                    });
                </script>

                <script>
                    function checkTimeAndDisplayButton() {
                        const now = new Date();
                        const formatter = new Intl.DateTimeFormat('en-US', {
                            timeZone: 'Asia/Manila',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });

                        const formattedTime = formatter.formatToParts(now);
                        const hours = parseInt(formattedTime.find(part => part.type === 'hour').value);
                        const minutes = parseInt(formattedTime.find(part => part.type === 'minute').value);


                        if ((hours === 1 && minutes >= 0 && minutes <= 59) ||
                            (hours === 8 && minutes === 0) ||
                            (hours === 12 && minutes >= 31 && minutes <= 59) ||
                            (hours === 13 && minutes === 0)
                        ) {
                            document.getElementById('clockInButton').style.display = 'block';
                        } else {
                            document.getElementById('clockInButton').style.display = 'none';
                        }
                        if ((hours === 1 && minutes >= 1 && minutes <= 50) ||
                            (hours === 17 && minutes >= 0 && minutes <= 59) ||
                            (hours === 18 && minutes === 0)
                        ) {
                            document.getElementById('clockOutButton').style.display = 'block';
                        } else {
                            document.getElementById('clockOutButton').style.display = 'none';
                        }


                    }

                    // Check every minute if the button should be displayed
                    setInterval(checkTimeAndDisplayButton, 1000);

                    // Initial check when the page loads
                    checkTimeAndDisplayButton();
                </script>



                @endsection