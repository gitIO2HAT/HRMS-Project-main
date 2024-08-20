<?php $__env->startSection('content'); ?>
<?php if(Auth::user()->end_of_contract == \Carbon\Carbon::today()->toDateString()): ?>
<div class="col-sm-12 col-xl-12 bg-warning text-center py-3">
    <i class="fas fa-bell" style="font-size: 24px;"></i>
    <span class="ml-2 font-weight-bold">Reminder: Your contract is ending soon! Don't hesitate to contact the administrator.</span>
</div>
<?php endif; ?>
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
                        <div class="col-sm-12 col-xl-8">
                            <div class="row g-4">
                                <div class="col-sm-12 col-xl-12">
                                    <div class="bg-white text-center rounded-3  p-4">
                                        <?php
                                        $counter = 1;
                                        $counters = 1;
                                        ?>

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
                                                            <?php $__currentLoopData = $getAnn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announce): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <th class="border-bottom border-white" scope="row"><?php echo e($counter++); ?></th>
                                                                <td class="border-bottom border-white"><?php echo e($announce->title); ?></td>
                                                                <td class="border-bottom border-white"><?php echo e(date('Y, M d - h:i A',
                                                                    strtotime($announce->scheduled_date))); ?></td>
                                                                <td class="border-bottom border-white"><?php echo e(date('Y, M d - h:i A',
                                                                    strtotime($announce->scheduled_end))); ?></td>
                                                                <td class="border-bottom border-white">
                                                                    <?php if($announce->scheduled_date > $currentDateTime): ?>
                                                                    <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-warning"></i> Ongoing</span>

                                                                    <?php elseif($announce->scheduled_date <= $currentDateTime && $announce->scheduled_end >= $currentDateTime): ?>
                                                                    <span class=" rounded-pill shadow p-2"><i class="far fa-dot-circle text-danger"></i> In Progress</span>
                                                                        <?php endif; ?>
                                                                </td>

                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>

                                                    <?php echo e($getAnn->onEachSide(1)->links()); ?>


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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>