@extends('layouts.app')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                @include('layouts._message')
                <div class="col-sm-12 col-xl-12">
                    <div>
                        <h2 class="text-dark text-start border-bottom border-success">My Account</h2>
                    </div>
                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <div class=" text-dark d-flex justify-content-between border-bottom  ">
                                <a>Personal Details</a>
                            </div>

                            <form method="post" action="{{url('/Admin/MyAccount/Update')}}" enctype="multipart/form-data">
                               @csrf
                                <div class="row g-4">
                                    <div class="col-sm-3 col-xl-3 border-end  border-bottom">
                                        <div class="fields">
                                            <div class="mt-2" id="profileContainer">
                                                <label for="profileImage" onclick="handleImageClick(event)">
                                                    <img class="rounded-circle" id="profilePicture" src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}"
                                                        alt="Profile" width="100px" style="cursor: pointer;">
                                                </label>
                                                <input type="file" name="profile_pic" id="profileImage" style="display: none;"
                                                    onchange="displayImage(this)">
                                            </div>
                                            <div class="border-bottom border-light ">
                                                <h5 class="text-dark">{{Auth::user()->name}} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</h5>
                                                <h6 class="text-light">{{Auth::user()->position}}</h6>
                                                <h6 class="text-light">{{Auth::user()->department}}</h6>
                                            </div>
                                            <div>
                                                <div class="mt-2">
                                                    <h5 class="text-light text-start">Email Address</h5>
                                                    <p class="text-start text-dark">{{Auth::user()->email}}</p>
                                                </div>
                                                <div class="">
                                                    <h5 class="text-light text-start">Mobile Number</h5>
                                                    <p class="text-start text-dark">{{Auth::user()->phonenumber}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label class="text-start">First Name</label>
                                                <input type="text" placeholder="Enter First Name" class="form-control"
                                                    name="name" value="{{Auth::user()->name}}" required>
                                                @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Middle Name</label>
                                                <input type="text" placeholder="Enter Middle Name" class="form-control"
                                                    name="middlename" value="{{Auth::user()->middlename}}" required>
                                                @if($errors->has('middlename'))
                                                <span class="text-danger">{{ $errors->first('middlename') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Last Name</label>
                                                <input type="text" placeholder="Enter Last Name" class="form-control"
                                                    name="lastname" value="{{Auth::user()->lastname}}" required>
                                                @if($errors->has('lastname'))
                                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label for="suffix">Suffix</label>
                                                <select id="suffix" class="form-control" name="suffix">
                                                    <option selected disabled>--Select Suffix--</option>
                                                    <option value="Jr."@if(Auth::user()->suffix == 'Jr.') selected @endif>Jr.</option>
                                                    <option value="Sr." @if(Auth::user()->suffix == 'Sr.') selected @endif>Sr.</option>
                                                    <option value="I" @if(Auth::user()->suffix == 'I') selected @endif>I</option>
                                                    <option value="II" @if(Auth::user()->suffix == 'II') selected @endif>II</option>
                                                    <option value="III" @if(Auth::user()->suffix == 'III') selected @endif>III</option>
                                                </select>
                                                @if($errors->has('suffix'))
                                                <span class="text-danger">{{ $errors->first('suffix') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label for="sex">Sex</label>
                                                <select id="sex" class="form-control" name="sex" required>
                                                    <option selected disabled>--Select Sex--</option>
                                                    <option value="Male" @if(Auth::user()->sex == 'Male') selected @endif>Male</option>
                                                    <option value="Female" @if(Auth::user()->sex == 'Female') selected @endif>Female</option>
                                                    <option value="Other" @if(Auth::user()->sex == 'Other') selected @endif>Other</option>
                                                    @if($errors->has('sex'))
                                                    <span class="text-danger">{{ $errors->first('sex') }}</span>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="input-field">
                                                <label>Age</label>
                                                <input type="number" placeholder="Enter Age" class="form-control"
                                                    name="age" value="{{Auth::user()->age}}" required>
                                                @if($errors->has('age'))
                                                <span class="text-danger">{{ $errors->first('age') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Birth Date</label>
                                                <input type="date" placeholder="Enter Birth Date" class="form-control"
                                                    name="birth_date" value="{{Auth::user()->birth_date}}" required>
                                                @if($errors->has('birth_date'))
                                                <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="phonenumber"
                                                    pattern="(\+63\s?|0)(\d{3}\s?\d{3}\s?\d{4}|\d{4}\s?\d{3}\s?\d{4})"
                                                    placeholder="e.g., +63 123 456 7890 or 0912 345 6789" value="{{Auth::user()->phonenumber}}"
                                                    required>
                                                @if($errors->has('phonenumber'))
                                                <span class="text-danger">{{ $errors->first('phonenumber') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">

                                            <div class="input-field">
                                                <label for="status">Civil Status</label>
                                                <select id="status" class="form-control" name="civil_status" required>
                                                    <option selected disabled>--Select Status--</option>
                                                    <option value="Single" @if(Auth::user()->civil_status == 'Single') selected @endif>Single</option>
                                                    <option value="Married" @if(Auth::user()->civil_status == 'Married') selected @endif>Married</option>
                                                    <option value="Widowed" @if(Auth::user()->civil_status == 'Widowed') selected @endif>Widowed</option>
                                                    @if($errors->has('civil_status'))
                                                    <span class="text-danger">{{ $errors->first('civil_status')
                                                        }}</span>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="input-field">
                                                <label>Full Address</label>
                                                <input type="text" placeholder="Enter Full Address" class="form-control"
                                                    name="fulladdress" value="{{Auth::user()->fulladdress}}" required>
                                                @if($errors->has('fulladdress'))
                                                <span class="text-danger">{{ $errors->first('fulladdress') }}</span>
                                                @endif
                                            </div>

                                            <div class="input-field">
                                                <label>Email</label>
                                                <input type="email" placeholder="Enter Email" class="form-control"
                                                    name="email" value="{{Auth::user()->email}}" required>
                                                @if($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Password</label>
                                                <input type="password" placeholder="Enter Password" class="form-control"
                                                    name="password" value="">
                                                @if($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" text-dark d-flex justify-content-between border-bottom  ">
                                        <a>Emergency Contact</a>
                                    </div>
                                    <div class="col-sm-12 col-xl-12">

                                        <div class="fields">
                                            <div class="input-field">
                                                <label class="text-start">Full Name</label>
                                                <input type="text" placeholder="Enter Full Name" class="form-control"
                                                    name="emergency_fullname" value="{{Auth::user()->emergency_fullname}}" required>
                                                @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Full Address</label>
                                                <input type="text" placeholder="Enter Full Address" class="form-control"
                                                    name="emergency_fulladdress" value="{{Auth::user()->emergency_fulladdress}}" required>
                                                @if($errors->has('full_address'))
                                                <span class="text-danger">{{ $errors->first('full_address') }}</span>
                                                @endif
                                            </div>

                                            <div class="input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="emergency_phonenumber"
                                                    pattern="(\+63\s?|0)(\d{3}\s?\d{3}\s?\d{4}|\d{4}\s?\d{3}\s?\d{4})"
                                                    placeholder="e.g., +63 123 456 7890 or 0912 345 6789" value="{{Auth::user()->emergency_phonenumber}}"
                                                    required>
                                                @if($errors->has('phonenumber'))
                                                <span class="text-danger">{{ $errors->first('phonenumber') }}</span>
                                                @endif
                                            </div>
                                            <div class="input-field">
                                                <label>Relationship</label>
                                                <input type="text" placeholder="Enter Relationship" class="form-control"
                                                    name="emergency_relationship" value="{{Auth::user()->emergency_relationship}}" required>
                                                @if($errors->has('emergency_relationship'))
                                                <span class="text-danger">{{ $errors->first('emergency_relationship')
                                                    }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="{{url('Admin/Dashboard')}}" class="btn btn-primary">Done<a>
                                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
