<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-white text-center rounded-3  p-4">

                        <div class="col-12">
                            <div class="bg-white rounded h-100 p-4">
                                <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class=" text-dark ">List of Admins & Employees</h6>


                                    <div class="d-flex justify-content-between align-items-center">
                                        <form action="" class="me-1">
                                            <?php echo csrf_field(); ?>
                                            <input type="search" id="search" class="form-control bg-transparent"
                                                name="search" placeholder="Search Here"
                                                value="<?php echo e(request('search')); ?>">
                                            <button style="display: none;" class="btn btn-success m-1"
                                                type="submit">Search</button>
                                            <button style="display: none;" type="hidden" class="btn btn-success m-1"
                                                onclick="clearSearch()">Clear</button>
                                        </form>
                                        <?php if(Auth::user()->user_type == 0): ?>
                                        <a href="<?php echo e(url('SuperAdmin/Employee/AddEmployee')); ?>"
                                            class="btn btn-success "><i class="fas fa-user-plus"
                                                style="color: #ffffff;"></i> Add Employee</a>
                                        <a href="<?php echo e(url('SuperAdmin/Employee/ArchiveEmployee')); ?>"
                                            class="m-1 btn btn-warning "><i class="far fa-file-archive"
                                                style="color: #000000;"></i> Archived</a>
                                        <?php elseif(Auth::user()->user_type == 1): ?>
                                        <a href="<?php echo e(url('Admin/Employee/AddEmployee')); ?>"
                                            class="btn btn-success ">Add Employee</a>
                                        <a href="<?php echo e(url('SuperAdmin/Employee/ArchiveEmployee')); ?>"
                                            class="m-1 btn btn-warning "><i class="far fa-file-archive"
                                                style="color: #000000;"></i> Archived</a>
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
                                                <th scope="col">Date of Assumption</th>
                                                <th scope="col">Contract</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">End of Contract</th>
                                                <th scope="col">PDS File</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Preview</th>
                                                <th scope="col">Archive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $getEmployee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row"><?php echo e(($getEmployee->currentPage() - 1) * $getEmployee->perPage() + $index + 1); ?></th>
                                                <td><?php echo e($employee->custom_id); ?></td>
                                                <td><?php echo e($employee->name); ?> <?php echo e($employee->lastname); ?></td>

                                                <td><?php echo e($employee->email); ?></td>
                                                <td>
                                                    <?php $__currentLoopData = $depart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($employee->department == $data->id): ?>
                                                    <?php echo e($data->name); ?>

                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <td>
                                                    <?php $__currentLoopData = $pos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($employee->position == $data->id): ?>
                                                    <?php echo e($data->name); ?>

                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </td>
                                                <td><?php echo e($employee->date_of_assumption); ?></td>
                                                <td>
                                                    <?php if($employee->contract == 1): ?>
                                                    Regular
                                                    <?php elseif($employee->contract == 2): ?>
                                                    Casual
                                                    <?php elseif($employee->contract == 3): ?>
                                                    Contractual
                                                    <?php elseif($employee->contract == 4): ?>
                                                    Job Order
                                                    <?php elseif($employee->contract == 5): ?>
                                                    Seasonal
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($employee->user_type === 1): ?>
                                                    Admin
                                                    <?php elseif($employee->user_type === 2): ?>
                                                    Employee
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($employee->end_of_contract); ?></td>
                                                <td>
                                                    <?php if($employee->pds_file): ?>
                                                    <?php
                                                    // Get the file extension
                                                    $fileExtension = pathinfo($employee->pds_file, PATHINFO_EXTENSION);
                                                    ?>

                                                    <?php if($fileExtension === 'pdf'): ?>
                                                    <!-- Display the PDF file and provide download -->
                                                    <a href="<?php echo e(asset('public/employeepdsfile/' . $employee->pds_file)); ?>" target="_blank">View PDF</a> |
                                                    <a href="<?php echo e(asset('public/employeepdsfile/' . $employee->pds_file)); ?>" download>Download PDF</a>
                                                    <?php elseif($fileExtension === 'xlsx' || $fileExtension === 'xls'): ?>
                                                    <!-- Provide download for Excel files -->
                                                    <a href="<?php echo e(asset('public/employeepdsfile/' . $employee->pds_file)); ?>" download>Download Excel (<?php echo e(strtoupper($fileExtension)); ?>)</a>
                                                    <?php else: ?>
                                                    <!-- In case other file types are present -->
                                                    Invalid file format.
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    No file available
                                                    <?php endif; ?>
                                                </td>


                                                <?php if(Auth::user()->user_type == 0): ?>
                                                <td>
                                                    <a class=" rounded-1"
                                                        href="<?php echo e(url('SuperAdmin/Employee/EditEmployee/' . $employee->id)); ?>">
                                                        <i class="far fa-edit" style="color: #161717;"></i></a>
                                                </td>
                                                <td> <a class=" rounded-1"
                                                        href="<?php echo e(url('SuperAdmin/Employee/PreviewEmployee/' . $employee->id)); ?>">
                                                        <i class="far fa-eye" style="color: #19191a;"></i></a>
                                                </td>
                                                <td><a class=" rounded-1"
                                                        href="<?php echo e(url('SuperAdmin/Employee/Archive/' . $employee->id)); ?>">
                                                        <i class="fas fa-user-times"
                                                            style="color:#fe2e2e;"></i></a></td>
                                                <?php elseif(Auth::user()->user_type == 1): ?>
                                                <td>
                                                    <a class=" rounded-1"
                                                        href="<?php echo e(url('Admin/Employee/EditEmployee/' . $employee->id)); ?>">
                                                        <i class="far fa-edit" style="color: #161717;"></i></a>

                                                </td>
                                                <td> <a class=" rounded-1"
                                                        href="<?php echo e(url('Admin/Employee/PreviewEmployee/' . $employee->id)); ?>">
                                                        <i class="far fa-eye" style="color: #19191a;"></i></a>
                                                </td>
                                                <td><a class=" rounded-1"
                                                        href="<?php echo e(url('Admin/Employee/Archive/' . $employee->id)); ?>">
                                                        <i class="fas fa-user-times"
                                                            style="color: #fe2e2e;"></i></a></td>
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
        <?php $__currentLoopData = $getNot['getNotify']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Modal -->
        <div class="modal fade" id="descriptionModal<?php echo e($unread->id); ?>" tabindex="-1" aria-labelledby="descriptionModalLabel<?php echo e($unread->id); ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="descriptionModalLabel<?php echo e($unread->id); ?>"><?php echo e($unread->title_message); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo e($unread->description_message); ?>

                    </div>
                    <div class="modal-footer">
                        <?php if(Auth::user()->user_type == 0): ?>
                        <button href="<?php echo e(url('SuperAdmin/Read/'.$unread->id)); ?>" type="button" class="btn btn-success" data-bs-dismiss="modal">Ok!</button>
                        <?php elseif(Auth::user()->user_type == 1): ?>
                        <button href="<?php echo e(url('Admin/Read/'.$unread->id)); ?>" type="button" class="btn btn-success" data-bs-dismiss="modal">Ok!</button>
                        <?php elseif(Auth::user()->user_type == 2): ?>
                        <button href="<?php echo e(url('Employee/Read/'.$unread->id)); ?>" type="button" class="btn btn-success" data-bs-dismiss="modal">Ok!</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/superadmin/employee/employee.blade.php ENDPATH**/ ?>