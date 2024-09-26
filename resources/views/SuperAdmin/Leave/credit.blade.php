@extends('layouts.app')

@section('content')
@include('layouts._message')



<div class="container-fluid pt-4 px-4">
    <div class="row g-4">


        <div class="col-sm-12 col-xl-12 bg-white rounded-1">
            <div class="row">
                <div class="col-6 col-sm-6 col-xl-6 mt-2">
                    <form action="{{ url()->current() }}" method="GET" class="me-1">
                        @csrf
                        <input type="search" id="search" class="form-control bg-transparent"
                            name="search" placeholder="Search Here"
                            value="{{ request('search') }}">
                        <button style="display: none;" class="btn btn-success m-1" type="submit">Search</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Sick Leave Balance</th>
                                <th scope="col">Vacation Balance</th>
                                <th scope="col">Special Previlege Balance</th>
                                <th scope="col">Add Credits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}</td>
                                <td>{{$user->lastname}}, {{$user->name}} {{$user->middlename}}</td>
                                <td>{{$user->sick_leave}}</td>
                                <td>{{$user->vacation_leave}}</td>
                                <td>{{$user->special_previlege_leave}}</td>
                                <td> <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#editCreditsModal-{{ $user->id }}" data-leave-id="{{ $user->id }}">
                                        +
                                    </a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->appends(['search' => request('search')])->links() }}

                </div>
            </div>
        </div>
        @foreach($users as $user)
        <div class="modal fade" id="editCreditsModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editCreditsModalLabel-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCreditsModalLabel-{{ $user->id }}">Edit Credits</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="statusForm-{{ $user->id }}" method="POST" action="{{ url('/SuperAdmin/Credits/EditCredits/' . $user->id) }}">
                            @csrf
                            @method('PATCH')

                            <!-- Sick Leave with Add and Minus Buttons and Editable Input -->
                            <label for="sick_leave_{{ $user->id }}">Sick Leave</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementLeave('sick_leave_{{ $user->id }}', 0.1)">-</button>
                                <input type="number" id="sick_leave_{{ $user->id }}" name="sick_leave" value="{{ $user->sick_leave }}" step="0.1" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" onclick="incrementLeave('sick_leave_{{ $user->id }}', 0.1)">+</button>
                            </div>

                            <!-- Vacation Leave with Add and Minus Buttons and Editable Input -->
                            <label for="vacation_leave_{{ $user->id }}">Vacation Leave</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementLeave('vacation_leave_{{ $user->id }}', 0.1)">-</button>
                                <input type="number" id="vacation_leave_{{ $user->id }}" name="vacation_leave" value="{{ $user->vacation_leave }}" step="0.1" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" onclick="incrementLeave('vacation_leave_{{ $user->id }}', 0.1)">+</button>
                            </div>

                            <!-- Special Privilege Leave with Add and Minus Buttons and Editable Input -->
                            <label for="special_previlege_leave_{{ $user->id }}">Special Privilege Leave</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrementLeave('special_previlege_leave_{{ $user->id }}', 0.1)">-</button>
                                <input type="number" id="special_previlege_leave_{{ $user->id }}" name="special_previlege_leave" value="{{ $user->special_previlege_leave }}" step="0.1" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" onclick="incrementLeave('special_previlege_leave_{{ $user->id }}', 0.1)">+</button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- JavaScript for handling the increment and decrement of various leave types -->
        <script>
            function incrementLeave(leaveId, step) {
                var input = document.getElementById(leaveId);
                var value = parseFloat(input.value);
                if (!isNaN(value)) {
                    input.value = (value + step).toFixed(1);
                }
            }

            function decrementLeave(leaveId, step) {
                var input = document.getElementById(leaveId);
                var value = parseFloat(input.value);
                if (!isNaN(value) && value > 0) {
                    input.value = (value - step).toFixed(1);
                }
            }

            function resetLeaves(userId) {
                document.getElementById('sick_leave_' + userId).value = '0.0'; // Reset Sick Leave
                document.getElementById('vacation_leave_' + userId).value = '0.0'; // Reset Vacation Leave
                document.getElementById('special_previlege_leave_' + userId).value = '0.0'; // Reset Special Leave
            }
        </script>

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