@extends('layouts.app')

@section('content')
    <div class="container my-4">
        @include('layouts._message')
        <div class="card p-3 rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ url('/Admin/Leave') }}" class="w-100" method="GET" id="searchForm">
                    @csrf
                    <div class="input-group mb-3">
                        <a type="button" class=" btn btn-success  d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addLeaveModal">
                            Add Leave
                        </a>
                        <a type="button" class="btn btn-success mx-1 d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addCreditModal">
                            Credit
                        </a>
                        <span class="input-group-text bg-white border-end">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" id="search" class="form-control border-start-0 rounded-1" name="search"
                            placeholder="Search Here" value="{{ request('search') }}" oninput="submitForm()">
                        <span class="mx-1 d-flex align-items-center bg-white">
                            From
                        </span>
                        <input type="date" id="from" class="form-control rounded-1 mx-1" name="from"
                            placeholder="From" value="{{ request('from') }}" onchange="submitForm()">
                        <span class="mx-1 d-flex align-items-center bg-white">
                            To
                        </span>
                        <input type="date" id="to" class="form-control rounded-1 mx-1" name="to"
                            placeholder="To" value="{{ request('to') }}" onchange="submitForm()">
                        <select class="form-control rounded-1 mx-1" name="leave_type" id="leave_type"
                            onchange="submitForm()">
                            <option value="">Leave Type</option>
                            <option value="Sick Leave" {{ request('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick
                                Leave</option>
                            <option value="Vacation Leave"
                                {{ request('leave_type') == 'Vacation Leave' ? 'selected' : '' }}>Vacation Leave</option>
                        </select>

                        <button class="btn btn-light " type="button" onclick="clearSearch()">Clear</button>
                        <a type="button" class="btn btn-info mx-2 d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#generateReportsModal">
                            Generate Reports
                        </a>
                    </div>
                </form>




            </div>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employees Name</th>
                        <th>Leave Type</th>
                        <th>Role</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Sick Credit</th>
                        <th>Vacation Credit</th>
                        <th>Request Send</th>
                        <th class="text-center">ABS. UND. W/P</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($leaves as $index => $SuperAdmin)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            @foreach ($users as $user)
                                @if ($SuperAdmin->employee_id === $user->custom_id)
                                    <td><img class="rounded-circle me-lg-2"
                                            src="{{ asset('public/accountprofile/' . $user->profile_pic) }}" alt=""
                                            style="width: 40px; height: 40px;"> {{ $user->name }} {{ $user->lastname }}
                                    </td>
                                @endif
                            @endforeach
                            <td>{{ $SuperAdmin->leave_type }}</td>
                            <td>
                                @if ($SuperAdmin->user_type === 1)
                                    Admin
                                @elseif($SuperAdmin->user_type === 2)
                                    Employee
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($SuperAdmin->from)->format('Y, F j') }}</td>
                            <td>{{ \Carbon\Carbon::parse($SuperAdmin->to)->format('Y, F j') }}</td>
                            <td>{{ $SuperAdmin->user->sick_balance }}</td>
                            <td>{{ $SuperAdmin->user->vacation_balance }}</td>
                            <td>{{ \Carbon\Carbon::parse($SuperAdmin->created_at)->format('Y, F j') }}</td>
                            <td class="text-center"><span
                                    class="rounded-pill shadow p-2">-{{ $SuperAdmin->leave_days }}</span></td>
                            <td class="text-center">
                                <form id="statusForm{{ $SuperAdmin->id }}"
                                    action="{{ url('/Admin/Leave/UpdateRequestLeave/' . $SuperAdmin->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="dropdown">
                                        <button class="btn btn-white shadow rounded-pill dropdown-toggle" type="button"
                                            id="statusDropdown{{ $SuperAdmin->id }}" data-bs-toggle="dropdown">
                                            <i
                                                class="far fa-dot-circle {{ $SuperAdmin->status === 'Approved' ? 'text-success' : ($SuperAdmin->status === 'Declined' ? 'text-danger' : 'text-warning') }}"></i>
                                            {{ $SuperAdmin->status }}
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $SuperAdmin->id }}">
                                            <li><a class="dropdown-item" href="#"
                                                    onclick="updateStatus({{ $SuperAdmin->id }}, 'Pending')"><i
                                                        class="fas fa-hourglass-start me-2"></i>Pending</a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    onclick="updateStatus({{ $SuperAdmin->id }}, 'Approved')"><i
                                                        class="fas fa-check-circle me-2 text-success"></i>Approved</a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    onclick="updateStatus({{ $SuperAdmin->id }}, 'Declined')"><i
                                                        class="fas fa-times-circle me-2 text-danger"></i>Declined</a></li>
                                        </ul>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>



            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="text-muted">
                    Showing {{ $leaves->firstItem() }} to {{ $leaves->lastItem() }} of {{ $leaves->total() }} entries
                </p>
                <nav>
                    {{ $leaves->links() }} <!-- This will generate the pagination links -->
                </nav>
            </div>
            <h3 class="text-dark text-center">Leave History</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th class="text-center">ABS. UND. W/P</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($history as $index => $leave)

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{$leave->leave_type}}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->from)->format('Y, F j') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->to)->format('Y, F j') }}</td>
                        <td>{{$leave->reason}}</td>
                        <td class="text-center"><span class="rounded-pill shadow p-2">-{{$leave->leave_days}}</span></td>
                        <td class="text-center"> <span class="rounded-pill shadow p-2">@if($leave->status === 'Pending')
                                <i class="far fa-dot-circle text-warning"></i> {{$leave->status}}
                                @elseif ($leave->status === 'Approved')
                                <i class="far fa-dot-circle text-success"></i> {{$leave->status}}
                                @elseif ($leave->status === 'Declined')
                                <i class="far fa-dot-circle text-danger"></i> {{$leave->status}}
                                @endif
                            </span></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="text-muted">
                    Showing {{ $history->firstItem() }} to {{ $history->lastItem() }} of {{ $history->total() }} entries
                </p>
                <nav>
                    {{ $history->links() }} <!-- This will generate the pagination links -->
                </nav>
            </div>


        </div>
    </div>
    <div class="modal fade" id="addCreditModal" tabindex="-1" aria-labelledby="addCreditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addCreditModalLabel">Credit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ url('/Admin/Leave') }}" method="POST">
                        @csrf
                        <div class="form-group my-1">
                            <label class="text-dark" for="user_id">Select Employee*</label>
                            <select id="user_id" name="user_id" class="form-control underline-input" required>
                                <option value="" disabled selected>Select Employee*</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }},
                                        {{ $user->middlename }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_id'))
                                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label class="text-dark" for="leave_type">Leave Type*</label>
                            <select id="leave_type" name="leave_type" class="form-control underline-input" required>
                                <option value="" disabled selected>Select Leave Type</option>
                                <option value="sick_balance">Sick Credit</option>
                                <option value="vacation_balance">Vacation Credit</option>
                            </select>
                            @if ($errors->has('leave_type'))
                                <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                            @endif
                        </div>
                        <div class="quantity-input">
                            <button type="button" class="decrement">-</button>
                            <input type="number" id="quantity" name="quantity" min="-1000" max="100"
                                step="0.01" value="0">
                            <button type="button" class="increment">+</button>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-2">Add</button>
                        </div>
                    </form>


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
                    <form action="{{ url('/Admin/Leave/GenerateReports') }}" method="POST">
                        @csrf <!-- Add CSRF token for security -->
                        <label class="text-dark" for="employeeIds">Select User</label>
                        <select id="employeeIds" name="employeeIds" class="form-control underline-input">
                            <option value="" selected>--Select All--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->custom_id }}">{{ $user->lastname }}, {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="text-dark" for="employeetype">Select Type</label>
                        <select id="employeetype" name="employeetype" class="form-control underline-input">
                            <option value="" selected>--Select All--</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Vacation Leave">Vacation Leave</option>
                        </select>
                        <label class="text-dark" for="employeestatus">Select Status</label>
                        <select id="employeestatus" name="employeestatus" class="form-control underline-input">
                            <option value="" selected>--Select All--</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Declined">Declined</option>
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
    <div class="modal fade" id="addLeaveModal" tabindex="-1" aria-labelledby="addLeaveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addLeaveModalLabel">Add Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Admin/Leave/AddLeave" method="POST">
                        @csrf
                        <div class="form-group my-1">
                            <label class="text-dark" for="leave_type">Leave Type*</label>
                            <select id="leave_type" name="leave_type" class="form-control underline-input" required>
                                <option value="" disabled selected>Select Leave Type</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Vacation Leave">Vacation Leave</option>
                            </select>
                            @if($errors->has('leave_type'))
                            <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label class="text-dark" for="from">From*</label>
                            <input type="date" name="from" class="form-control" id="from" required>
                            @if($errors->has('from'))
                            <span class="text-danger">{{ $errors->first('from') }}</span>
                            @endif
                        </div>
                        <div class="form-group my-1">
                            <label class="text-dark" for="to">To*</label>
                            <input type="date" name="to" class="form-control" id="to" required>
                            @if($errors->has('to'))
                            <span class="text-danger">{{ $errors->first('to') }}</span>
                            @endif
                        </div>

                        <div class="form-group my-1">
                            <label class="text-dark" for="reason">Reason*</label>
                            <input type="text" name="reason" class="form-control underline-input" required>
                            @if($errors->has('reason'))
                            <span class="text-danger">{{ $errors->first('reason') }}</span>
                            @endif
                        </div>


                        <div class="d-flex justify-content-between">
                            <div class="form-group my-1 text-dark">
                                <Label for="sick_balance">Sick Balance:</Label>
                                <span class="text-dark" id="sick_balance">{{Auth::user()->sick_balance}}</span>
                            </div>
                            <div class="form-group my-1 text-dark">
                                <Label for="vacation_balance">Vacation Balance:</Label>
                                <span class="text-dark" id="vacation_balance">{{Auth::user()->vacation_balance}}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-2">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
