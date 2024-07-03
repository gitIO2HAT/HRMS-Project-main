@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-4 col-xl-4">
                    <div class="bg-white text-center rounded-3  p-4">
                        <div class="row g-4">
                            <div
                                class="d-flex justify-content-center align-items-center rounded-3 col-sm-4 col-xl-4 bg-info">
                                <i class="bx fas fa-users fa-2x" style="color: #080808;"></i>
                            </div>
                            <div class=" col-sm-4 col-xl-4">
                                <span class="">
                                    <h3 class="fs-5 text-start text-dark">2</h3>
                                    <p class="text-dark">Employees</p>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 text-dark"></span>
                    </div>
                </div>
                <div class="rounded col-sm-4 col-xl-4">
                    <div class="bg-white text-center rounded-3  p-4">
                        <div class="row g-4">
                            <div
                                class="d-flex justify-content-center align-items-center rounded-3 col-sm-4 col-xl-4 bg-danger">
                                <i class="far fa-building fa-2x" style="color: #000000;"></i>
                            </div>
                            <div class=" col-sm-4 col-xl-4">
                                <span class="">
                                    <h3 class="fs-5 text-start text-dark">2</h3>
                                    <p class="text-dark">Departments</p>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 text-dark"></span>
                    </div>
                </div>
                <div class="col-sm-4 col-xl-4">
                    <div class="bg-white text-center rounded-3  p-4">

                        <div class="row g-4">
                            <div
                                class="d-flex justify-content-center align-items-center rounded-3 col-sm-4 col-xl-4 bg-light">
                                <i class="fas fa-bullhorn fa-2x" style="color: #000000;"></i>
                            </div>
                            <div class=" col-sm-4 col-xl-4">
                                <span class="">
                                    @foreach($notification['notify'] as $key)
                                    <h3 class="fs-5 text-start text-dark">{{$key->unread}}</h3>
                                    @endforeach
                                    <p class="text-dark">Announcement</p>
                                </span>
                            </div>
                        </div>
                        <span class="fs-5 text-dark"></span>
                    </div>
                </div>
                <div class=" pt-4 px-4 ">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-7 rounded">
                            <div class="bg-white rounded-3  h-100 p-4">
                                <h6 class="mb-4 text-center text-dark">Employee Growth Rate</h6>
                                <canvas id="Male-chart" width="400" height="400"></canvas>
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
    @endsection