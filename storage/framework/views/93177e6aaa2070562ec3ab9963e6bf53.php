<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-sm-12 col-xl-12">
                    <div>
                        <h2 class="text-dark text-start border-bottom border-success">Edit <?php echo e($getId->name); ?>

                            <?php echo e($getId->lastname); ?></h2>
                    </div>
                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <div class="d-flex justify-content-between border-bottom  ">
                                <a>Admin Controller</a>
                            </div>
                            <form method="post" action="" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row g-4">

                                    <div class="col-sm-12 col-xl-12">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label for="suffix">Department</label>
                                                <select class="form-control" name="department">
                                                    <option selected disabled>--Select Department--</option>
                                                    <option value="Department 1" <?php if($getId->department == 'Department 1'): ?> selected <?php endif; ?>>Department 1</option>
                                                    <option value="Department 2" <?php if($getId->department == 'Department 2'): ?> selected <?php endif; ?>>Department 2</option>
                                                    <option value="Department 3" <?php if($getId->department == 'Department 3'): ?> selected <?php endif; ?>>Department 3</option>
                                                    <option value="Department 4" <?php if($getId->department == 'Department 4'): ?> selected <?php endif; ?>>Department 4</option>
                                                    <option value="Department 5" <?php if($getId->department == 'Department 5'): ?> selected <?php endif; ?>>Department 5</option>
                                                    <option value="Department 6" <?php if($getId->department == 'Department 6'): ?> selected <?php endif; ?>>Department 6</option>
                                                    <option value="Department 7" <?php if($getId->department == 'Department 7'): ?> selected <?php endif; ?>>Department 7</option>
                                                </select>
                                                <?php if($errors->has('department')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('department')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label for="suffix">Position</label>
                                                <select class="form-control" name="position">
                                                    <option selected disabled>--Select position--</option>
                                                    <option value="Position 1" <?php if($getId->position == 'Position 1'): ?>
                                                        selected <?php endif; ?>>Position 1</option>
                                                    <option value="Position 2" <?php if($getId->position == 'Position 2'): ?>
                                                        selected <?php endif; ?>>Position 2</option>
                                                    <option value="Position 3" <?php if($getId->position == 'Position 3'): ?>
                                                        selected <?php endif; ?>>Position 3</option>
                                                    <option value="Position 4" <?php if($getId->position == 'Position 4'): ?>
                                                        selected <?php endif; ?>>Position 4</option>
                                                    <option value="Position 5" <?php if($getId->position == 'Position 5'): ?>
                                                        selected <?php endif; ?>>Position 5</option>
                                                    <option value="Position 6" <?php if($getId->position == 'Position 6'): ?>
                                                        selected <?php endif; ?>>Position 6</option>
                                                    <option value="Position 7" <?php if($getId->position == 'Position 7'): ?>
                                                        selected <?php endif; ?>>Position 7</option>
                                                    <option value="Position 8" <?php if($getId->position == 'Position 8'): ?>
                                                        selected <?php endif; ?>>Position 8</option>
                                                    <option value="Position 9" <?php if($getId->position == 'Position 9'): ?>
                                                        selected <?php endif; ?>>Position 9</option>
                                                    <option value="Position 10" <?php if($getId->position == 'Position 10'): ?>
                                                        selected <?php endif; ?>>Position 10</option>
                                                </select>
                                                <?php if($errors->has('position')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('position')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>End of Contract</label>
                                                <input type="date" class="form-control" name="end_of_contract"
                                                    value="<?php echo e($getId->end_of_contract); ?>" required>
                                                <?php if($errors->has('birth_date')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('birth_date')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Daily Rate</label>
                                                <input type="numeric" class="form-control" name="daily_rate"
                                                    placeholder="e.g., 560" value="<?php echo e($getId->daily_rate); ?>" required>
                                                <?php if($errors->has('daily_rate')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('daily_rate')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Current Credit</label>
                                                <input type="numeric" class="form-control" name="credit"
                                                    placeholder="e.g., 560" value="<?php echo e($getId->credit); ?>" required>
                                                <?php if($errors->has('credit')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('credit')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                           
            
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <?php if(Auth::user()->user_type == 0): ?>
                                <a href="<?php echo e(url('SuperAdmin/Employee')); ?>" class="btn btn-primary">Done<a>
                                        <?php elseif(Auth::user()->user_type == 1): ?>
                                        <a href="<?php echo e(url('Admin/Employee')); ?>" class="btn btn-primary">Done<a>
                                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/employee/editemployee.blade.php ENDPATH**/ ?>