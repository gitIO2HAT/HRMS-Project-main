<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-name">
            <img src="<?php echo e(asset('img/HUMAN.png')); ?>">

            <h3>HRMS</h3>
        </div>
    </div>

    <div class="sidebar-main">
        <div class="sidebar-user">

            <img src="<?php echo e(asset('public/accountprofile/' . Auth::user()->profile_pic)); ?>" alt="Employee">
        </div>
        <div class="name">
            <h3 class="text-dark text-center"><?php echo e(Auth::user()->name); ?></h3>
            <div class="d-flex align-content-center justify-content-center">
            <span class="text-dark"><?php echo e(Auth::user()->custom_id); ?></span>
            </div>
            <div class="d-flex align-content-center justify-content-center">
            <?php if(Auth::user()->user_type == 0): ?>
            <span class="text-dark">Super Admin Account</span>
            <?php elseif(Auth::user()->user_type == 1): ?>
            <span class="text-dark">Admin Account</span>
            <?php elseif(Auth::user()->user_type == 2): ?>
            <span class="text-dark">Employee Account</span>
            <?php endif; ?>
            </div>


        </div>
    </div>

    <ul class="side-menu top">
    <?php if(Auth::user()->user_type == 0): ?>
        <?php if(Request::segment(2)== 'Dashboard'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php else: ?>
        <li class="">
            <a href="<?php echo e(url('SuperAdmin/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Department'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Department')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Department</span>
            </a>
        </li>
        <?php else: ?>
        <li class="">
            <a href="<?php echo e(url('SuperAdmin/Department')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Department</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Employee'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Employee')); ?>">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Admins & Employees</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('SuperAdmin/Employee')); ?>">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Admins & Employees</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Leave'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('SuperAdmin/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2) == 'Announcement'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Announcement')); ?>">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('SuperAdmin/Announcement')); ?>">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        <?php endif; ?>


        <?php elseif(Auth::user()->user_type == 1): ?>

        <?php if(Request::segment(2)== 'Dashboard'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php else: ?>
        <li class="">
            <a href="<?php echo e(url('Admin/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Department'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Department')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Department</span>
            </a>
        </li>
        <?php else: ?>
        <li class="">
            <a href="<?php echo e(url('Admin/Department')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Department</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Employee'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Employee')); ?>">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employees</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Admin/Employee')); ?>">
                <i class="bx fas fa-users" style="color: #080808;"></i>
                <span class="text">Employees</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2)== 'Leave'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Admin/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if(Request::segment(2) == 'Announcement'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Announcement')); ?>">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Admin/Announcement')); ?>">
                <i class="bx fas fa-bullhorn" style="color: #000000;"></i>
                <span class="text">Announcement</span>
            </a>
        </li>
        <?php endif; ?>

        <?php endif; ?>


        <?php if(Auth::user()->user_type == 2): ?>
        <?php if(Request::segment(2)== 'Dashboard'): ?>
        <li class="active">
            <a href="<?php echo e(url('Employee/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php else: ?>
        <li class="">
            <a href="<?php echo e(url('Employee/Dashboard')); ?>">
                <i class="bx fab fa-windows" style="color: #000000;"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <?php endif; ?>
        <?php endif; ?>

        <?php if(Auth::user()->user_type == 2): ?>
        <?php if(Request::segment(2)== 'Leave'): ?>
        <li class="active">
            <a href="l<?php echo e(url('Employee/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Employee/Leave')); ?>">
                <i class="bx far fa-calendar-alt" style="color: #000000;"></i>
                <span class="text">Leave</span>
            </a>
        </li>
        <?php endif; ?>
        <?php endif; ?>



        <?php if(Auth::user()->user_type == 0): ?>

        <?php if(Request::segment(2) == 'Attendance'): ?>
        <li class="active">
            <a href="<?php echo e(url('SuperAdmin/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('SuperAdmin/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php endif; ?>
        <?php elseif(Auth::user()->user_type == 1): ?>

        <?php if(Request::segment(2) == 'Attendance'): ?>
        <li class="active">
            <a href="<?php echo e(url('Admin/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Admin/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php endif; ?>
        <?php elseif(Auth::user()->user_type == 2): ?>
        <?php if(Request::segment(2) == 'Attendance'): ?>
        <li class="active">
            <a href="<?php echo e(url('Employee/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Employee/Attendance')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">Attendance</span>
            </a>
        </li>
        <?php endif; ?>
        <?php endif; ?>
    </ul>

    <ul class="side-menu bottom">

        <?php if(Auth::user()->user_type == 0): ?>

        <?php if(Request::segment(2) == 'MyAccount'): ?>
        <li class="active">
            <a href="<?php echo e(url('/SuperAdmin/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">My Account</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('/SuperAdmin/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">MyAccount</span>
            </a>
        </li>
        <?php endif; ?>
        <?php elseif(Auth::user()->user_type == 1): ?>

        <?php if(Request::segment(2) == 'MyAccount'): ?>
        <li class="active">
            <a href="<?php echo e(url('/Admin/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">MyAccount</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('/Admin/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">MyAccount</span>
            </a>
        </li>
        <?php endif; ?>
        <?php elseif(Auth::user()->user_type == 2): ?>
        <?php if(Request::segment(2) == 'MyAccount'): ?>
        <li class="active">
            <a href="<?php echo e(url('Employee/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">MyAccount</span>
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e(url('Employee/MyAccount')); ?>">
                <i class="bx fas fa-cog" style="color: #000000;"></i>
                <span class="text">MyAccount</span>
            </a>
        </li>
        <?php endif; ?>
        <?php endif; ?>

        <li>
            <a href="<?php echo e(route('logoutButton')); ?>" class="logout">
                <i class="bx fas fa-sign-out-alt" style="color: #b30303;"></i>
                <span class="text" onclick="return confirm('Are you sure you want to Logout?');">Logout</span>
            </a>
        </li>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>