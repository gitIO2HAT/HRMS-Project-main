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
                                        <a type="button" class="btn btn-info mx-2 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#generateReportsModal">
                                            Generate Reports
                                        </a>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-dark text-center">
                                            <tr class="bg-title">
                                                <th class="centered">#</th>
                                                <th class="centered">Employee Name</th>
                                                @foreach ($dailySeries as $date => $duration)
                                                <th>{{ \Carbon\Carbon::parse($date)->format('M d') }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($employeeRecords as $index => $record)
                                            <tr>
                                                <td>{{ ($employeeRecords->currentPage() - 1) * $employeeRecords->perPage() + $index + 1 }}</td>
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
                                                    $attendance && $attendance->punch_in_am_first
                                                    ? '✔'
                                                    : '✘';
                                                    $amSecond =
                                                    $attendance && $attendance->punch_in_am_second
                                                    ? '✔'
                                                    : '✘';
                                                    $pmFirst =
                                                    $attendance && $attendance->punch_in_pm_first
                                                    ? '✔'
                                                    : '✘';
                                                    $pmSecond =
                                                    $attendance && $attendance->punch_in_pm_second
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
                                                    } elseif ($amStatus === '✘' && $pmStatus === '✔') {
                                                    $displayStatus = '✘ ✔';
                                                    } elseif (
                                                    $amStatus === '✔' &&
                                                    $pmStatus === '✔'
                                                    ) {
                                                    $displayStatus = '✔';
                                                    } elseif ($amStatus === '✘' && $pmStatus === '✘') {
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
                                        Attendance Admin & Employee Records</th>
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
                        <div class="modal fade" id="generateReportsModal" tabindex="-1" aria-labelledby="generateReportsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-dark" id="generateReportsModalLabel">Generate Reports</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('/SuperAdmin/Attendance/GenerateReports') }}" method="POST">
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
                        @endsection