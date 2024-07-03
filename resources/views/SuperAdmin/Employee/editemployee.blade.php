@extends('layouts.app')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                @include('layouts._message')
                <div class="col-sm-12 col-xl-12">
                    <div>
                        <h2 class="text-dark text-start border-bottom border-success">Edit {{$getId->name}}
                            {{$getId->lastname}}</h2>
                    </div>
                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <div class="d-flex justify-content-between border-bottom  ">
                                <a>Admin Controller</a>
                            </div>
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">

                                    <div class="col-sm-12 col-xl-12">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label for="suffix">Department</label>
                                                <select class="form-control" name="department">
                                                    <option selected disabled>--Select Department--</option>
                                                    <option value="Department 1" @if($getId->department == 'Department 1') selected @endif>Department 1</option>
                                                    <option value="Department 2" @if($getId->department == 'Department 2') selected @endif>Department 2</option>
                                                    <option value="Department 3" @if($getId->department == 'Department 3') selected @endif>Department 3</option>
                                                    <option value="Department 4" @if($getId->department == 'Department 4') selected @endif>Department 4</option>
                                                    <option value="Department 5" @if($getId->department == 'Department 5') selected @endif>Department 5</option>
                                                    <option value="Department 6" @if($getId->department == 'Department 6') selected @endif>Department 6</option>
                                                    <option value="Department 7" @if($getId->department == 'Department 7') selected @endif>Department 7</option>
                                                </select>
                                                @if($errors->has('department'))
                                                <span class="text-danger">{{ $errors->first('department') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label for="suffix">Position</label>
                                                <select class="form-control" name="position">
                                                    <option selected disabled>--Select position--</option>
                                                    <option value="Position 1" @if($getId->position == 'Position 1')
                                                        selected @endif>Position 1</option>
                                                    <option value="Position 2" @if($getId->position == 'Position 2')
                                                        selected @endif>Position 2</option>
                                                    <option value="Position 3" @if($getId->position == 'Position 3')
                                                        selected @endif>Position 3</option>
                                                    <option value="Position 4" @if($getId->position == 'Position 4')
                                                        selected @endif>Position 4</option>
                                                    <option value="Position 5" @if($getId->position == 'Position 5')
                                                        selected @endif>Position 5</option>
                                                    <option value="Position 6" @if($getId->position == 'Position 6')
                                                        selected @endif>Position 6</option>
                                                    <option value="Position 7" @if($getId->position == 'Position 7')
                                                        selected @endif>Position 7</option>
                                                    <option value="Position 8" @if($getId->position == 'Position 8')
                                                        selected @endif>Position 8</option>
                                                    <option value="Position 9" @if($getId->position == 'Position 9')
                                                        selected @endif>Position 9</option>
                                                    <option value="Position 10" @if($getId->position == 'Position 10')
                                                        selected @endif>Position 10</option>
                                                </select>
                                                @if($errors->has('position'))
                                                <span class="text-danger">{{ $errors->first('position') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>End of Contract</label>
                                                <input type="date" class="form-control" name="end_of_contract"
                                                    value="{{$getId->end_of_contract}}" required>
                                                @if($errors->has('birth_date'))
                                                <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Daily Rate</label>
                                                <input type="numeric" class="form-control" name="daily_rate"
                                                    placeholder="e.g., 560" value="{{$getId->daily_rate}}" required>
                                                @if($errors->has('daily_rate'))
                                                <span class="text-danger">{{ $errors->first('daily_rate') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Current Credit</label>
                                                <input type="numeric" class="form-control" name="credit"
                                                    placeholder="e.g., 560" value="{{$getId->credit}}" required>
                                                @if($errors->has('credit'))
                                                <span class="text-danger">{{ $errors->first('credit') }}</span>
                                                @endif
                                            </div>

                                           
            
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                @if(Auth::user()->user_type == 0)
                                <a href="{{url('SuperAdmin/Employee')}}" class="btn btn-primary">Done<a>
                                        @elseif(Auth::user()->user_type == 1)
                                        <a href="{{url('Admin/Employee')}}" class="btn btn-primary">Done<a>
                                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @endsection