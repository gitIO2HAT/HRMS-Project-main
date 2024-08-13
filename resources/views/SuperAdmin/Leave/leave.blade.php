@extends('layouts.app')

@section('content')

<div class="container my-4">
    @include('layouts._message')
    <div class="card p-3 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ url('/SuperAdmin/Leave') }}" class="w-100" method="GET">
                @csrf
                <div class="input-group mb-3">
                    <a type="button" class="btn btn-success mx-4 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                        Add Leave
                    </a>
                    <span class="input-group-text bg-white border-end">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="search" class="form-control border-start-0 rounded-1" name="search" placeholder="Search Here" value="{{ request('search') }}">
                    <span class="mx-1 d-flex align-items-center bg-white">
                        From
                    </span>
                    <input type="date" id="from" class="form-control rounded-1 mx-1" name="from" placeholder="From" value="{{ request('from') }}">
                    <span class="mx-1 d-flex align-items-center bg-white">
                        To
                    </span>
                    <input type="date" id="to" class="form-control rounded-1 mx-1" name="to" placeholder="To" value="{{ request('to') }}">
                    <select class="form-control rounded-1 mx-1" name="leave_type" id="leave_type">
                        <option value="">Leave Type</option>
                        <option value="Sick Leave" {{ request('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                        <option value="Vacation Leave" {{ request('leave_type') == 'Vacation Leave' ? 'selected' : '' }}>Vacation Leave</option>
                    </select>
                    <button class="btn btn-warning m-1" type="submit">Search</button>
                    <button class="btn btn-light m-1" type="button" onclick="clearSearch()">Clear</button>
                </div>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th class="text-center">ABS. UND. W/P</th>
                    <th class="text-center">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $index => $leave)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $leave->employee_id }}</td>
                    <td>{{ $leave->leave_type }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->from)->format('Y, F j') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->to)->format('Y, F j') }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td class="text-center"><span class="rounded-pill shadow p-2">-{{ $leave->leave_days }}</span></td>
                    <td class="text-center">
                        <form action="{{ url('/SuperAdmin/Leave/UpdateRequestLeave/' . $leave->id) }}" method="post">
                            @csrf
                            <div class="dropdown">
                                <button class="btn btn-white shadow rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton{{ $leave->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-dot-circle {{ $leave->status === 'Approved' ? 'text-success' : ($leave->status === 'Declined' ? 'text-danger' : 'text-warning') }}"></i>
                                    {{ $leave->status }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $leave->id }}">
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Pending', '{{ $leave->id }}')"><i class="fas fa-hourglass-start me-2"></i>Pending</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Approved', '{{ $leave->id }}')"><i class="fas fa-check-circle me-2 text-success"></i>Approved</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Declined', '{{ $leave->id }}')"><i class="fas fa-times-circle me-2 text-danger"></i>Declined</a></li>
                                </ul>
                            </div>
                            <input type="hidden" id="statusInput{{ $leave->id }}" name="status">
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
    </div>
</div>

@endsection


<script>
    function changeStatus(status, leaveId) {
        if (confirm('Are you sure you want to change the status?')) {
            const form = document.querySelector(`form[action*="${leaveId}"]`);
            if (form) {
                form.querySelector(`#statusInput${leaveId}`).value = status;
                form.submit();
            } else {
                console.error('Form not found for leaveId:', leaveId);
            }
        }
    }
</script>
