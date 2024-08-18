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
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by Name" class="modify">

                                        <label class="text-dark" for="month">Select Month:</label>
                                        <select name="month" id="month" class="modify">
                                            @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                </option>
                                                @endfor
                                        </select>

                                        <label class="text-dark" for="year">Select Year:</label>
                                        <select name="year" id="year" class="modify">
                                            @for ($y = Carbon\Carbon::now()->year; $y >= Carbon\Carbon::now()->year - 5; $y--)
                                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                            @endfor
                                        </select>

                                        <button class="btn btn-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-dark text-center">
                                        <tr class="bg-title">
                                            <th class="centered">Employee Name</th>
                                            @foreach($dailySeries as $date => $duration)
                                            <th>{{ \Carbon\Carbon::parse($date)->format('M d') }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($employeeRecords as $record)
                                        <tr>
                                            <td class="text-dark  d-flex aling-items-center">
                                                <img class="rounded-circle me-lg-2"
                                                src="{{ asset('public/accountprofile/' . $record->profile_pic) }}" alt=""
                                                style="width: 40px; height: 40px;"> {{ $record->name }} {{ $record->lastname }}
                                            </td>
                                            @foreach($dailySeries as $date => $duration)
                                            <td class="text-dark centered">
                                                @php
                                                $attendance = $RecordsAttendance->where('user_id', $record->custom_id)->where('date', $date)->first();
                                                $amFirst = $attendance && $attendance->punch_in_am_first ? '✔' : '✘';
                                                $amSecond = $attendance && $attendance->punch_in_am_second ? '✔' : '✘';
                                                $pmFirst = $attendance && $attendance->punch_in_pm_first ? '✔' : '✘';
                                                $pmSecond = $attendance && $attendance->punch_in_pm_second ? '✔' : '✘';

                                                $amStatus = ($amFirst === '✔' && $amSecond === '✔') ? '✔' : '✘';
                                                $pmStatus = ($pmFirst === '✔' && $pmSecond === '✔') ? '✔' : '✘';
                                                $finalStatus = ($amStatus === '✔' && $pmStatus === '✔') ? '✔' : '✘';

                                                // Additional logic to display CHECK MARK and XMARK as per requirements
                                                if ($amStatus === '✔' && $pmStatus === '✘') {
                                                $displayStatus = '✔ ✘';
                                                } elseif ($amStatus === '✘' && $pmStatus === '✔') {
                                                $displayStatus = '✘ ✔';
                                                } elseif ($amStatus === '✔' && $pmStatus === '✔') {
                                                $displayStatus = '✔';
                                                } elseif ($amStatus === '✘' && $pmStatus === '✘') {
                                                $displayStatus = '✘';
                                                } else {
                                                $displayStatus = $amStatus . ' and ' . $pmStatus;
                                                }
                                                @endphp

                                                @if($displayStatus === '✔ ✘')
                                                <i class="fas fa-check-square" style="color: #63E6BE;"></i> <i class="fas fa-window-close" style="color: #e22c2c;"></i>
                                                @elseif ($displayStatus === '✘ ✔')
                                                <i class="fas fa-window-close" style="color: #e22c2c;"></i> <i class="fas fa-check-square" style="color: #63E6BE;"></i>
                                                @elseif ($displayStatus === '✔')
                                                <i class="fas fa-check-square" style="color: #63E6BE;"></i>
                                                @elseif ($displayStatus === '✘')
                                                <i class="fas fa-window-close" style="color: #e22c2c;"></i>
                                                @endif
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$employeeRecords->onEachSide(1)->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endsection
