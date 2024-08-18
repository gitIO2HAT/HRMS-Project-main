<?php $__env->startSection('content'); ?>
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
                                    <h3 class="fs-5 text-start text-dark"><?php echo e($employeeCount); ?></h3>
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
                                    <h3 class="fs-5 text-start text-dark"><?php echo e($departmentCount); ?></h3>
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
                                    <?php $__currentLoopData = $notification['notify']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <h3 class="fs-5 text-start text-dark"><?php echo e($key->unread); ?></h3>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                                <?php $__currentLoopData = $birthdayUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="my-2 rounded-2 border-start border-primary">
                                    <span class=" d-flex justify-content-between align-items-center">

                                        <img class="my-1 mx-1" src="<?php echo e(asset('public/accountprofile/' . $user->profile_pic)); ?>" alt="Employee"
                                            width="30px">
                                        <h3 class="fs-5 text-start text-dark">Today is <?php echo e($user->name); ?>'s birthday!</h3>
                                        <i class="fas fa-birthday-cake" style="color: #000000;"></i>
                                    </span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/employee/dashboard.blade.php ENDPATH**/ ?>