@extends('layouts.app')

@section('content')
@include('layouts._message')



<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="d-flex justify-content-between">
                <div class=" bg-today mx-2 p-2 rounded-3 text-center" style="width: 500px;">
                    <h1>{{Auth::user()->sick_leave}}</h1>
                    <span class="text-dark"><b>Sick Leave</b></span>
                    <p class="mt-1">Balance</p>
                </div>
                <div class=" bg-week mx-2 p-2 rounded-3 text-center" style="width: 500px;">
                    <h1>{{Auth::user()->vacation_leave}}</h1>
                    <span class="text-dark"><b>Vacation Leave</b></span>
                    <p class="mt-1">Balance</p>
                </div>
                <div class=" bg-month mx-2 p-2 rounded-3 text-center" style="width: 500px;">
                    <h1>{{Auth::user()->special_previlege_leave}}</h1>
                    <span class="text-dark"><b>Special Previlege Leave</b></span>
                    <p class="mt-1">Balance</p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-12 bg-white rounded-1">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">Inclusive Date</th>
                            <th scope="col">No. of Days</th>
                            <th scope="col">Date of Application</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                 
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                     
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>

    @endsection