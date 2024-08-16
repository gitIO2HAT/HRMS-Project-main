@extends('layouts.app')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">

                <div class=" pt-4 px-4 ">
                    @include('layouts._message')

                    <div class="row g-4">
                        <div class="col-12 rounded">
                            <div class="bg-white rounded-3  h-100 p-4">
                                <h2 class="text-dark text-center">DEPARTMENT</h2>
                                <div class="d-flex align-items-center">
                                    <div class="col-sm-10 ms-5 ">
                                        <form action="{{url('/Admin/Department')}}" class="me-1">
                                            @csrf
                                            <input type="search" id="search" class="form-control bg-transparent" name="search" placeholder="Search Here" value="{{ request('search') }}">
                                            <button style="display: none;" class="btn btn-success m-1" type="submit">Search</button>
                                            <button style="display: none;" type="hidden" class="btn btn-success m-1" onclick="clearSearch()">Clear</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-2 ms-5 ">
                                        @if(Auth::user()->user_type == 0)
                                        <a href="{{url('/SuperAdmin/Department/DepartmentArchived')}}" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Archived</a>
                                        @elseif(Auth::user()->user_type == 1)
                                        <a href="{{url('/Admin/Department/DepartmentArchived')}}" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Archived</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 rounded">

                            <div class="bg-white rounded-3  h-100 p-4">

                                <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus-circle" style="color: #FFD43B;"></i>
                                </a>

                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Department</th>
                                                <th class="text-center">Year Published</th>
                                                <th class="text-center">Actionsss</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($departments as $index => $list)
                                            <form action="{{ url('/Admin/Department/UpdateDepartment/'.$list->id) }}" method="POST">
                                                @csrf
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">
                                                        <span id="editable-span-{{ $list->id }}" onclick="toggleEdit('{{$list->id}}')">
                                                            {{ $list->name }}
                                                        </span>
                                                        <input type="text" id="editable-input-{{ $list->id }}" name="name" value="{{ $list->name }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('{{$list->id}}')">
                                                    </td>
                                                    <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($list->created_at)->format('Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if(Auth::user()->user_type == 0)
                                                        <a href="{{ url('/SuperAdmin/Department/Deleted/'.$list->id) }}"> <i class="fas fa-trash-alt" style="color: #ee7c7c;"></i></a>
                                                        @elseif(Auth::user()->user_type == 1)
                                                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                                            <i class="fas fa-save" style="color: #63E6BE; font-size: 18px;"></i>
                                                        </button>
                                                        <a href="{{ url('/Admin/Department/Deleted/'.$list->id) }}"> <i class="fas fa-trash-alt" style="color: #ee7c7c;"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </form>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$departments->onEachSide(1)->links()}}
                                </div>

                            </div>

                        </div>
                        <div class="col-6 rounded">

                            <div class="bg-white rounded-3  h-100 p-4">


                                <a type="button" class="mx-2" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                                    <i class="fas fa-plus-circle" style="color: #FFD43B;"></i>
                                </a>


                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Department</th>
                                                <th class="text-center">Positions</th>
                                                <th class="text-center">Year Published</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($position as $index => $list)
                                            <form action="{{ url('/Admin/Department/UpdatePosition/'.$list->id) }}" method="POST">
                                                @csrf
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>

                                                    <td class="text-center">
                                                    @foreach($departments as $depart)

                                                        @if($list->department_id === $depart->id)
                                                            {{$depart->name}}
                                                        @endif

                                                    @endforeach
                                                    </td>
                                                    <td class="text-center">
                                                        <span id="editable-span-{{ $list->id }}" onclick="toggleEdit('{{$list->id}}')">
                                                            {{ $list->name }}
                                                        </span>
                                                        <input type="text" id="editable-input-{{ $list->id }}" name="name" value="{{ $list->name }}" class="form-control text-center" style="display:none;" onblur="toggleEdit('{{$list->id}}')">
                                                    </td>
                                                    <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($list->created_at)->format('Y') }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if(Auth::user()->user_type == 0)
                                                    <td class="text-center"> <a href="{{ url('/Admin/Department/Deleted/'.$list->id) }}" onclick="return confirm('Are you sure you want to delete this permanently?');">
                                                            <i class="fas fa-trash-alt" style="color: #ee7c7c;"></i>
                                                        </a>
                                                        @elseif(Auth::user()->user_type == 1)
                                                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                                            <i class="fas fa-save" style="color: #63E6BE; font-size: 18px;"></i>
                                                        </button>

                                                        <a href="{{ url('/Admin/Department/DeletedPosition/'.$list->id) }}" onclick="return confirm('Are you sure you want to delete this permanently?');">
                                                            <i class="fas fa-trash-alt" style="color: #ee7c7c;"></i>
                                                        </a>
                                                    </td>
                                                    @endif
                                                </tr>
                                            </form>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                {{$position->onEachSide(1)->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addUserModalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form action="/Admin/Department/AddDepartment" method="POST">
                        @csrf
                        <div class="text-center">
                            <input type="text" placeholder="Department Name" class="form-control underline-input" name="name">
                            @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <button type="submit" class="btn btn-success mt-3">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="addPositionModalLabel">Add Position for Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content here -->
                    <form action="/Admin/Department/AddPosition" method="POST">
                        @csrf
                        <div>
                            <select id="department" name="department_id" class="form-control underline-input">
                                <option value="" disabled selected>Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('department_id'))
                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                            @endif
                        </div>
                        <div class="row g-4">
                            <div class="text-center">
                                <input type="text" placeholder="Position Name" class="form-control underline-input" name="name" value="">
                                @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                <button type="submit" class="btn btn-success mt-2">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
