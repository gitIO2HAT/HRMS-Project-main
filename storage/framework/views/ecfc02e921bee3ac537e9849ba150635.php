<?php $__env->startSection('content'); ?>

<div class="container my-4">
    <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="card p-3 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="<?php echo e(url('/SuperAdmin/Leave')); ?>" class="w-100" method="GET">
                <?php echo csrf_field(); ?>
                <div class="input-group mb-3">
                    <a type="button" class="btn btn-success mx-4 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                        Add Leave
                    </a>
                    <span class="input-group-text bg-white border-end">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="search" id="search" class="form-control border-start-0 rounded-1" name="search" placeholder="Search Here" value="<?php echo e(request('search')); ?>">
                    <span class="mx-1 d-flex align-items-center bg-white">
                        From
                    </span>
                    <input type="date" id="from" class="form-control rounded-1 mx-1" name="from" placeholder="From" value="<?php echo e(request('from')); ?>">
                    <span class="mx-1 d-flex align-items-center bg-white">
                        To
                    </span>
                    <input type="date" id="to" class="form-control rounded-1 mx-1" name="to" placeholder="To" value="<?php echo e(request('to')); ?>">
                    <select class="form-control rounded-1 mx-1" name="leave_type" id="leave_type">
                        <option value="">Leave Type</option>
                        <option value="Sick Leave" <?php echo e(request('leave_type') == 'Sick Leave' ? 'selected' : ''); ?>>Sick Leave</option>
                        <option value="Vacation Leave" <?php echo e(request('leave_type') == 'Vacation Leave' ? 'selected' : ''); ?>>Vacation Leave</option>
                    </select>
                    <button class="btn btn-warning m-1" type="submit">Search</button>
                    <button class="btn btn-light m-1" type="button" onclick="clearSearch()">Clear</button>
                </div>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th class="text-center">ABS. UND. W/P</th>
                    <th class="text-center">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($leave->employee_id); ?></td>
                    <td><?php echo e($leave->leave_type); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($leave->from)->format('Y, F j')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($leave->to)->format('Y, F j')); ?></td>
                    <td><?php echo e($leave->reason); ?></td>
                    <td class="text-center"><span class="rounded-pill shadow p-2">-<?php echo e($leave->leave_days); ?></span></td>
                    <td class="text-center">
                        <form action="<?php echo e(url('/Admin/Leave/UpdateRequestLeave/' . $leave->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="dropdown">
                                <button class="btn btn-white shadow rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton<?php echo e($leave->id); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="far fa-dot-circle <?php echo e($leave->status === 'Approved' ? 'text-success' : ($leave->status === 'Declined' ? 'text-danger' : 'text-warning')); ?>"></i>
                                    <?php echo e($leave->status); ?>

                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($leave->id); ?>">
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Pending', '<?php echo e($leave->id); ?>')"><i class="fas fa-hourglass-start me-2"></i>Pending</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Approved', '<?php echo e($leave->id); ?>')"><i class="fas fa-check-circle me-2 text-success"></i>Approved</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="changeStatus('Declined', '<?php echo e($leave->id); ?>')"><i class="fas fa-times-circle me-2 text-danger"></i>Declined</a></li>
                                </ul>
                            </div>
                            <input type="hidden" id="statusInput<?php echo e($leave->id); ?>" name="status">
                        </form>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="text-muted">
                Showing <?php echo e($leaves->firstItem()); ?> to <?php echo e($leaves->lastItem()); ?> of <?php echo e($leaves->total()); ?> entries
            </p>
            <nav>
                <?php echo e($leaves->links()); ?> <!-- This will generate the pagination links -->
            </nav>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/leave/leave.blade.php ENDPATH**/ ?>