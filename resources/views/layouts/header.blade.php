<nav class="navbar navbar-expand bg-success navbar-dark sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-dark mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars" style="color:black;"></i>
    </a>
    <a>
        <span class=" text-white d-none d-lg-inline-flex">Human Resource Management System</span>
    </a>
    <div class="navbar-nav align-items-center ms-auto">
        @foreach($notification['notify'] as $key)
        <div class="nav-item dropdown" id="{{$key->id}}">
            <a href="#" class="nav-link  me-2" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2" style="color:black;">
                    @if($key->unread)
                    <span class="badge badge-danger bg-primary pending">{{$key->unread}}</span>
                    @endif
                </i>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded-0 rounded-bottom m-0 custom-width"
                style="max-height: 500px; overflow-y: auto;">

                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th class="text-gray fs-6 border-bottom border-light">Notification <span
                                    class="text-danger">{{$key->unread}}</span></th>
                        </tr>
                    </thead>
                    @foreach($getNot['getNotify'] as $unread)
                    <tr>
                        <td class="border-bottom-0">
                            @if(Auth::user()->user_type == 0)
                            <a href="{{ url('SuperAdmin/Read/'.$unread->id)}}">
                            @elseif(Auth::user()->user_type == 1)
                            <a href="{{ url('Admin/Read/'.$unread->id)}}">
                            @elseif(Auth::user()->user_type == 2)
                            <a href="{{ url('Employee/Read/'.$unread->id)}}">
                            @endif
                           
                                <div class="row g-4">
                                    <div class="col-1 mx-1 justify-content-start align-items-center">
                                        <img class="rounded-circle me-lg-2"
                                            src="{{ asset('public/accountprofile/' . $unread->profile_pic) }}" alt=""
                                            style="width: 40px; height: 40px;">
                                    </div>
                                    <div class="col-sm-10 col-xl-10">
                                        <p class="text-dark text-capitalize mt-1" style="font-size:12px;">
                                            {{$unread->title_message}} :
                                            <span
                                                class="text-light text-capitalize">{{$unread->description_message}}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-xl-12">
                                        <span class="text-end text-light">{{ \Carbon\Carbon::parse($unread->created_at)->format('g:i A') }}</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach
        @if(empty($notification['notify']))
        <!-- If $notification['notify'] is empty, set a default value of 1 -->
        <div class="nav-item dropdown" id="defaultNotification">
            <a href="#" class="nav-link dropdown-toggle me-2" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2" style="color:black;">
                    <span class="badge badge-danger bg-primary pending">1</span>
                </i>
                <span class="text-white d-none d-lg-inline-flex">Notification</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded-0 rounded-bottom m-0">
                <!-- Your dropdown content here -->
            </div>
        </div>
        @endif
        <div class="nav-item ">
            <a class=" ">

                <img class="rounded-circle me-lg-2"
                    src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}" alt=""
                    style="width: 40px; height: 40px;">

                <span class=" text-white d-none d-lg-inline-flex">{{Auth::user()->name}}</span>
            </a>
        </div>
    </div>
</nav>