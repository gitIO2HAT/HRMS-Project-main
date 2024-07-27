<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-name">
            <img src="{{ asset('img/HUMAN.png') }}">

            <h3>HRMS</h3>
        </div>
    </div>

    <div class="sidebar-main">
        <div class="sidebar-user">
            
            <img src="{{ asset('public/accountprofile/' . Auth::user()->profile_pic) }}" alt="Employee">
        </div>
        <div class="name">
            <h3 class="text-dark text-center">{{Auth::user()->name}}</h3>
            <div class="d-flex align-content-center justify-content-center">
            <span class="text-dark">{{Auth::user()->custom_id}}</span>
            </div>
            <div class="d-flex align-content-center justify-content-center">
            @if(Auth::user()->user_type == 0)
            <span class="text-dark">Super Admin Account</span>
            @elseif(Auth::user()->user_type == 1)
            <span class="text-dark">Admin Account</span>
            @elseif(Auth::user()->user_type == 2)
            <span class="text-dark">Employee Account</span>
            @endif
            </div>


        </div>
    </div>

    <ul class="side-menu top">
    @if(Auth::user()->user_type == 0)
        @if(Request::segment(2)== 'Dashboard')
        <li class="active">
            <a href="{{url('SuperAdmin/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @else
        <li class="">
            <a href="{{url('SuperAdmin/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2)== 'Employee')
        <li class="active">
            <a href="{{url('SuperAdmin/Employee')}}">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employee</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('SuperAdmin/Employee')}}">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employee</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2)== 'Leave')
        <li class="active">
            <a href="{{url('SuperAdmin/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('SuperAdmin/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2) == 'Announcement')
        <li class="active">
            <a href="{{url('SuperAdmin/Announcement')}}">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('SuperAdmin/Announcement')}}">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        @endif

        
        @elseif(Auth::user()->user_type == 1)

        @if(Request::segment(2)== 'Dashboard')
        <li class="active">
            <a href="{{url('Admin/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @else
        <li class="">
            <a href="{{url('Admin/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2)== 'Employee')
        <li class="active">
            <a href="{{url('Admin/Employee')}}">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employee</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Admin/Employee')}}">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employee</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2)== 'Leave')
        <li class="active">
            <a href="{{url('Admin/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Admin/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @endif
        @if(Request::segment(2) == 'Announcement')
        <li class="active">
            <a href="{{url('Admin/Announcement')}}">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Admin/Announcement')}}">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        @endif
        
        @endif


        @if(Auth::user()->user_type == 2)
        @if(Request::segment(2)== 'Dashboard')
        <li class="active">
            <a href="{{url('Employee/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @else
        <li class="">
            <a href="{{url('Employee/Dashboard')}}">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        @endif
        @endif

        @if(Auth::user()->user_type == 2)
        @if(Request::segment(2)== 'Leave')
        <li class="active">
            <a href="l{{url('Employee/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Employee/Leave')}}">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        @endif
        @endif
    
        @if(Auth::user()->user_type == 2)
        @if(Request::segment(2) == 'Attendance')
        <li class="active">
            <a href="{{url('Employee/Attendance')}}">
                <i class="bx far fa-comment-dots" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Employee/Attendance')}}">
                <i class="bx far fa-comment-dots" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @endif
        @endif
        @if(Auth::user()->user_type == 2)
        @if(Request::segment(2) == 'MyAccount')
        <li class="active">
            <a href="{{url('Employee/MyAccount')}}">
                <i class="bx far fa-user" style="color: #000000;"></i>
                <span class="text">My Account</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Employee/MyAccount')}}">
                <i class="bx far fa-user" style="color: #000000;"></i>
                <span class="text">My Account</span>
            </a>
        </li>
        @endif
        @endif
        @if(Auth::user()->user_type == 0)
        @if(Request::segment(2) == 'Attendance')
        <li class="active">
            <a href="{{url('SuperAdmin/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('SuperAdmin/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @endif
        @elseif(Auth::user()->user_type == 1)
        @if(Request::segment(2) == 'Attendance')
        <li class="active">
            <a href="{{url('Admin/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Admin/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @endif
        @elseif(Auth::user()->user_type == 2)
        @if(Request::segment(2) == 'Attendance')
        <li class="active">
            <a href="{{url('Employee/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @else
        <li>
            <a href="{{url('Employee/Attendance')}}">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        @endif
        @endif
    </ul>

    <ul class="side-menu bottom">
      


        <li>
            <a href="{{route('logoutButton')}}" class="logout">
                <i class="bx fas fa-sign-out-alt" style="color: #b30303;"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</div>