@extends('layouts.app')

@section('content')
@include('layouts._message')



<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      
        <div class="col-sm-12 col-xl-12 bg-white rounded-1">
            <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addLeaveModal">
                Add Leave
            </a>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">Inclusive Date</th>
                            <th scope="col">No. of Days</th>
                            <th scope="col">Documents Provided</th>
                            <th scope="col">Date of Application</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveData as $leave)
                        <tr>
                            <td>#</td>
                            <td>{{$leave->employee_id}}</td>
                            <td>{{$leave->leave_type}}</td>
                            <td>{{$leave->from}} - {{$leave->to}} </td>
                            <td>{{$leave->leave_days}}</td>
                            <td>

                                @if($leave->monetazation || $leave->terminal || $leave->adoption)
                                {{-- Check if Monetazation document exists --}}
                                @if($leave->monetazation)
                                @php
                                // Get the file extension for monetazation (in lowercase to handle case-sensitivity)
                                $fileExtension = strtolower(pathinfo($leave->monetazation, PATHINFO_EXTENSION));
                                @endphp


                                @if(in_array($fileExtension, ['png', 'jpeg', 'jpg']))
                                {{-- Display image document and provide download link --}}
                                <img src="{{ asset('public/leavedocuments/' . $leave->monetazation) }}" alt="Image file" style="max-width: 40px;" /> |
                                <a href="{{ asset('public/leavedocuments/' . $leave->monetazation) }}" download>Download Image ({{ strtoupper($fileExtension) }})</a>
                                @else
                                {{-- Handle unsupported file formats --}}
                                Invalid file format.
                                @endif

                                {{-- Check if Terminal document exists --}}
                                @elseif($leave->terminal)
                                @php
                                // Get the file extension for terminal (in lowercase)
                                $fileExtension = strtolower(pathinfo($leave->terminal, PATHINFO_EXTENSION));
                                @endphp


                                @if(in_array($fileExtension, ['png', 'jpeg', 'jpg']))
                                {{-- Display image document and provide download link --}}
                                <img src="{{ asset('public/leavedocuments/' . $leave->terminal) }}" alt="Image file" style="max-width: 40px;" /> |
                                <a href="{{ asset('public/leavedocuments/' . $leave->terminal) }}" download>Download Image ({{ strtoupper($fileExtension) }})</a>
                                @else
                                {{-- Handle unsupported file formats --}}
                                Invalid file format.
                                @endif

                                {{-- Check if Adoption document exists --}}
                                @elseif($leave->adoption)
                                @php
                                // Get the file extension for adoption (in lowercase)
                                $fileExtension = strtolower(pathinfo($leave->adoption, PATHINFO_EXTENSION));
                                @endphp


                                @if(in_array($fileExtension, ['png', 'jpeg', 'jpg']))
                                {{-- Display image document and provide download link --}}
                                <img src="{{ asset('public/leavedocuments/' . $leave->adoption) }}" alt="Image file" style="max-width: 40px;" /> |
                                <a href="{{ asset('public/leavedocuments/' . $leave->adoption) }}" download>Download Image ({{ strtoupper($fileExtension) }})</a>
                                @else
                                {{-- Handle unsupported file formats --}}
                                Invalid file format.
                                @endif
                                @endif

                                {{-- If no files are available --}}
                                @else
                                No file available.
                                @endif



                            </td>
                            <td>{{$leave->created_at}}</td>
                            <td>
                                <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#editStatusModal-{{ $leave->id }}" data-leave-id="{{ $leave->id }}">
                                    {{$leave->status}}
                                </a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

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

                    <!-- Form content here -->
                    <form action="/Admin/Leave/AddLeave" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">

                            <div>
                                <label from="employee_id">Details Leave</label>
                                <select id="employee_id" name="employee_id" class="form-control underline-input">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->custom_id }}">{{ $user->lastname }},{{ $user->name }} {{ $user->middlename }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('employee_id'))
                                <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                                @endif
                            </div>
                            <div>
                                <label for="leave_type">Leave Type</label>
                                <select id="leave_type" name="leave_type" class="form-control underline-input">
                                    <option value="" disabled selected>Leave Type</option>
                                    @foreach($leavetype as $type)
                                    <option value="{{ $type->id }}">{{ $type->status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="details-leave-container" class="hidden">
                                <label for="details-leave">Details Leave</label>
                                <select id="details-leave" name="details_leave" class="form-control underline-input">
                                    <option value="" disabled selected>Details Leave</option>
                                    <option value="1">Within the Philippines</option>
                                    <option value="2">Abroad (Please Specify if na pili ang abroad)</option>
                                </select>
                                <div id="details-abroad-container" class="hidden">
                                    <label for="abroad">Specify:</label>
                                    <input type="text" name="abroad" id="abroad" class="form-control underline-input">
                                </div>
                            </div>

                            <div id="details-monetization-container" class="hidden">
                                <label for="monetization_leave">Upload Document for Monetization Leave</label>
                                <input type="file" name="monetization" id="monetization_leave" class="form-control underline-input">
                            </div>
                            <div id="details-terminal-container" class="hidden">
                                <label for="terminal_leave">Upload Document for Terminal Leave</label>
                                <input type="file" name="terminal" id="terminal_leave" class="form-control underline-input">
                            </div>
                            <div id="details-adoption-container" class="hidden">
                                <label for="adoption_leave">Upload Document for Adoption Leave</label>
                                <input type="file" name="adoption" id="adoption_leave" class="form-control underline-input">
                            </div>

                            <script>
                                document.getElementById('details-leave').addEventListener('change', function() {
                                    const selectedLeaveType = this.value;
                                    const detailsLeaveContainer = document.getElementById('details-abroad-container');

                                    if (selectedLeaveType == '2') {
                                        detailsLeaveContainer.classList.remove('hidden'); // Show the "Specify" section
                                    } else {
                                        detailsLeaveContainer.classList.add('hidden'); // Hide the "Specify" section
                                    }
                                });
                            </script>
                            <script>
                                document.getElementById('leave_type').addEventListener('change', function() {
                                    const selectedLeaveType = this.value;
                                    const detailsLeaveContainer = document.getElementById('details-leave-container');

                                    if (selectedLeaveType == '1' || selectedLeaveType == '6') {
                                        detailsLeaveContainer.classList.remove('hidden'); // Show the "Details Leave" section
                                    } else {
                                        detailsLeaveContainer.classList.add('hidden'); // Hide the "Details Leave" section
                                    }
                                });
                            </script>
                            <script>
                                document.getElementById('leave_type').addEventListener('change', function() {
                                    const selectedLeaveType = this.value;
                                    const detailsLeaveContainer = document.getElementById('details-monetization-container');

                                    if (selectedLeaveType == '13') {
                                        detailsLeaveContainer.classList.remove('hidden'); // Show the "monetization" section
                                    } else {
                                        detailsLeaveContainer.classList.add('hidden'); // Hide the "monetization" section
                                    }
                                });
                            </script>
                            <script>
                                document.getElementById('leave_type').addEventListener('change', function() {
                                    const selectedLeaveType = this.value;
                                    const detailsLeaveContainer = document.getElementById('details-terminal-container');

                                    if (selectedLeaveType == '14') {
                                        detailsLeaveContainer.classList.remove('hidden'); // Show the "terminal" section
                                    } else {
                                        detailsLeaveContainer.classList.add('hidden'); // Hide the "terminal" section
                                    }
                                });
                            </script>
                            <script>
                                document.getElementById('leave_type').addEventListener('change', function() {
                                    const selectedLeaveType = this.value;
                                    const detailsLeaveContainer = document.getElementById('details-adoption-container');

                                    if (selectedLeaveType == '15') {
                                        detailsLeaveContainer.classList.remove('hidden'); // Show the "adoption" section
                                    } else {
                                        detailsLeaveContainer.classList.add('hidden'); // Hide the "adoption" section
                                    }
                                });
                            </script>
                            @if($errors->has('leave_type'))
                            <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                            @endif
                            <label for="inclusive-from">Inclusive From:</label>
                            <input type="date" name="from" id="inclusive-from" class="form-control underline-input">
                            <label for="inclusive-to">Inclusive To:</label>
                            <input type="date" name="to" id="inclusive-to" class="form-control underline-input">

                            <label for="leave_days">Number of Working Days Applied for:</label>
                            <input type="text" name="leave_days" id="leave_days" readonly class="form-control underline-input">
                            <script>
                                document.getElementById('inclusive-from').addEventListener('change', calculateLeaveDays);
                                document.getElementById('inclusive-to').addEventListener('change', calculateLeaveDays);

                                function calculateLeaveDays() {
                                    const fromDate = new Date(document.getElementById('inclusive-from').value);
                                    const toDate = new Date(document.getElementById('inclusive-to').value);

                                    if (fromDate && toDate && toDate >= fromDate) {
                                        let count = 0;
                                        let currentDate = new Date(fromDate);

                                        while (currentDate <= toDate) {
                                            const dayOfWeek = currentDate.getDay();
                                            // 0 = Sunday, 6 = Saturday; exclude weekends
                                            if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                                                count++;
                                            }
                                            currentDate.setDate(currentDate.getDate() + 1); // Increment by one day
                                        }

                                        document.getElementById('leave_days').value = count;
                                    } else {
                                        document.getElementById('leave_days').value = ''; // Clear value if invalid dates
                                    }
                                }
                            </script>
                            <button type="submit" class="btn btn-success mt-3">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($leaveData as $leave)
    <div class="modal fade" id="editStatusModal-{{ $leave->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel-{{ $leave->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel-{{ $leave->id }}">Edit Leave Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm-{{ $leave->id }}" method="POST" action="{{ url('/Admin/Leave/AddLeave/EditStatus/' . $leave->id) }}">
                        @csrf
                        @method('PATCH')


                        <label for="status-{{ $leave->id }}">Status:</label>
                        <select name="status" id="status-{{ $leave->id }}" class="form-control underline-input">
                            <option value="Pending" @if($leave->status == 'Pending') selected @endif>Pending</option>
                            <option value="Approved" @if($leave->status == 'Approved') selected @endif>Approved</option>
                            <option value="Declined" @if($leave->status == 'Declined') selected @endif>Declined</option>
                        </select>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach



    @endsection