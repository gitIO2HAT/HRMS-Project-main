@extends('layouts.app')

@section('content')
@if(\Carbon\Carbon::today()->between(
    \Carbon\Carbon::parse(Auth::user()->end_of_contract)->subMonth(),
    \Carbon\Carbon::parse(Auth::user()->end_of_contract)
))
<div class="col-sm-12 col-xl-12 bg-warning text-center py-3">
    <i class="fas fa-bell" style="font-size: 24px;"></i>
    <span class="ml-2 font-weight-bold">Reminder: Your contract is ending soon! Don't hesitate to contact the administrator.</span>
</div>
@endif


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">

                <div class=" pt-4 px-4 ">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">

                <div class="col-sm-12 col-xl-8">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-white text-center rounded-3  p-4">


                                <div class="col-12">
                                    <div class="bg-white rounded h-100 p-4">
                                        <h5 class="text-dark">Announcement Board</h5>

                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Start</th>
                                                        <th scope="col">End</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($getAnn as $index => $announce)
                                                    <tr>
                                                        <th class="border-bottom border-white" scope="row">{{ ($getAnn->currentPage() - 1) * $getAnn->perPage() + $index + 1 }}</th>
                                                        <td class="border-bottom border-white">{{$announce->title}}</td>
                                                        <td class="border-bottom border-white">{{ date('Y, M d - h:i A',
                                                            strtotime($announce->scheduled_date)) }}</td>
                                                        <td class="border-bottom border-white">{{ date('Y, M d - h:i A',
                                                            strtotime($announce->scheduled_end)) }}</td>
                                                        <td class="border-bottom border-white">
                                                            @if($announce->scheduled_date > $currentDateTime)
                                                            <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-warning"></i> Ongoing</span>

                                                            @elseif($announce->scheduled_date <= $currentDateTime && $announce->scheduled_end >= $currentDateTime)
                                                            <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-danger"></i> In Progress</span>
                                                                @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            {{$getAnn->onEachSide(1)->links()}}

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                        <div class="col-sm-12 col-xl-4 rounded">
                            <div class="bg-white rounded-3 h-100 p-4">
                                <h6 class="mb-4 fs-2 text-primary">Today's Birthday</h6>

                                @foreach($birthdayUsers as $user)
                                <div class="my-2 rounded-2 border-start border-primary">
                                    <span class=" d-flex justify-content-between align-items-center">

                                        <img class="my-1 mx-1" src="{{ asset('public/accountprofile/' . $user->profile_pic) }}" alt="Employee"
                                            width="30px">
                                        <h3 class="fs-5 text-start text-dark">Today is {{$user->name}}'s birthday!</h3>
                                        <i class="fas fa-birthday-cake" style="color: #000000;"></i>
                                    </span>
                                </div>
                                @endforeach



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
