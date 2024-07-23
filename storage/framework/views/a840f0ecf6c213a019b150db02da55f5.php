<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-white text-center rounded-3  p-4">
                        <?php
                        $counter = 1;
                        ?>
                        <div class="col-12">
                            <div class="bg-white rounded h-100 p-4">
                            <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class=" text-dark ">List of Employees</h6>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <form action="" class="me-1">
                                            <?php echo csrf_field(); ?>
                                            <input type="search" id="search" class="form-control bg-transparent"
                                                name="search" placeholder="Search Here" value="<?php echo e(request('search')); ?>">
                                            <button style="display: none;" class="btn btn-success m-1"
                                                type="submit">Search</button>
                                            <button style="display: none;" type="hidden" class="btn btn-success m-1"
                                                onclick="clearSearch()">Clear</button>
                                        </form>
                                        <?php if(Auth::user()->user_type == 0): ?>
                                        <a href="<?php echo e(url('SuperAdmin/Employee/AddEmployee')); ?>"
                                            class="btn btn-success "><i class="fas fa-user-plus" style="color: #ffffff;"></i> Add Employee</a>
                                            <a href="<?php echo e(url('SuperAdmin/Employee/ArchiveEmployee')); ?>" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Archived</a>
                                            <?php elseif(Auth::user()->user_type == 1): ?>
                                        <a href="<?php echo e(url('Admin/Employee/AddEmployee')); ?>" class="btn btn-success ">Add Employee</a>
                                        <a href="<?php echo e(url('Admin/Employee/ArchiveEmployee')); ?>" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Archived</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">ID Number</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Position</th>
                                                <th scope="col">End of Contract</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Preview</th>
                                                <th scope="col">Archive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $getEmployee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row"><?php echo e($counter++); ?></th>
                                                <td><?php echo e($employee->custom_id); ?></td>
                                                <td><?php echo e($employee->name); ?> <?php echo e($employee->lastname); ?></td>
                                             
                                                <td><?php echo e($employee->email); ?></td>
                                                <td><?php echo e($employee->department); ?></td>
                                                <td><?php echo e($employee->position); ?></td>
                                                <td><?php echo e($employee->end_of_contract); ?></td>
                                                <?php if(Auth::user()->user_type == 0): ?>
                                                <td>
                                                    <a class="bg-skyblue rounded-1"  href="<?php echo e(url('SuperAdmin/Employee/EditEmployee/'.$employee->id)); ?>"> <i class="fas fa-user-edit" style="color: #ffffff;"></i></a>
                                                </td>
                                                <td> <a class=" rounded-1" href="<?php echo e(url('SuperAdmin/Employee/PreviewEmployee/'.$employee->id)); ?>"> <i class="far fa-file-pdf" style="color: #000000;"></i></a></td>
                                                <td><a class="bg-danger rounded-1" href="<?php echo e(url('SuperAdmin/Employee/Archive/'.$employee->id)); ?>"> <i class="fas fa-user-times" style="color: #ffffff;"></i></a></td>
                                                <?php elseif(Auth::user()->user_type == 1): ?>
                                                <td>
                                                    <a class="bg-skyblue rounded-1"  href="<?php echo e(url('Admin/Employee/EditEmployee/'.$employee->id)); ?>"> <i class="fas fa-user-edit" style="color: #ffffff;"></i></a>
                                                   
                                                </td>
                                                <td> <a class=" rounded-1" href="<?php echo e(url('Admin/Employee/PreviewEmployee/'.$employee->id)); ?>"> <i class="far fa-file-pdf" style="color: #000000;"></i></a></td>
                                                <td><a class="bg-danger rounded-1" href="<?php echo e(url('Admin/Employee/Archive/'.$employee->id)); ?>"> <i class="fas fa-user-times" style="color: #ffffff;"></i></a></td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                    <?php echo e($getEmployee->onEachSide(1)->links()); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/employee/employee.blade.php ENDPATH**/ ?>