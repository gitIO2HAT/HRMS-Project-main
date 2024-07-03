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
                                <h1 class="mb-6 text-start text-dark"> <div id="current-date"></div> </h1>
                                <div style="background-color:#f9f9f9" class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
                                    <h6 class="text-start text-dark">Punch In at</h6>
                                    <div id="current-date1"></div>
                                    
                                </div>
                                <div class="hours-circle">
                                    <p>3.45 hrs</p>
                                </div>
                                
                            </div>
                          
                        </div>
                        <div class="col-sm-12 col-xl-5 rounded">
                            <div class="bg-white rounded-3 h-100 p-4">
                                <h6 class="mb-4 fs-2 text-primary">Today's Birthday</h6>
                                <div class="my-2 rounded-2 border-start border-primary">
                                    <span class=" d-flex justify-content-between align-items-center">
                                        <img class="my-1 mx-1" src="{{ asset('img/user.png') }}" alt="Employee"
                                            width="30px">
                                        <h3 class="fs-5 text-start text-dark">Today is Ben's 30th birthday!</h3>
                                        <i class="fas fa-birthday-cake" style="color: #000000;"></i>
                                    </span>
                                </div>
                                <div class="my-2 rounded-2 border-start border-primary">
                                    <span class=" d-flex justify-content-between align-items-center">
                                        <img class="my-1 mx-1" src="{{ asset('img/user.png') }}" alt="Employee"
                                            width="30px">
                                        <h3 class="fs-5 text-start text-dark">Today is Ben's 30th birthday!</h3>
                                        <i class="fas fa-birthday-cake" style="color: #000000;"></i>
                                    </span>
                                </div>
                                <div class="my-2 rounded-2 border-start border-primary">
                                    <span class=" d-flex justify-content-between align-items-center">
                                        <img class="my-1 mx-1" src="{{ asset('img/user.png') }}" alt="Employee"
                                            width="30px">
                                        <h3 class="fs-5 text-start text-dark">Today is Ben's 30th birthday!</h3>
                                        <i class="fas fa-birthday-cake" style="color: #000000;"></i>
                                    </span>
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
            
            const dateString = `<span class="timesheet">Timesheet</span> <span class="date">${day} ${month} ${year} <span> `;
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
                    case 1:  return "st";
                    case 2:  return "nd";
                    case 3:  return "rd";
                    default: return "th";
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

            const dateString1 = `<span class="date1">${dayOfWeek1}, ${day1}${daySuffix1(day1)} ${month1} ${year1} ${timeString1}</span>`;
            document.getElementById('current-date1').innerHTML = dateString1;
        }

        // Update the time every second
        setInterval(updateTime, 1000);

        // Initial call to display the time immediately on page load
        updateTime();
    </script>
    
@endsection