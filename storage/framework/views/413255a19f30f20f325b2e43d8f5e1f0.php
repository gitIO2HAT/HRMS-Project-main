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
                                                <label for="department">Department</label>
                                                <select id="department" name="department" class="form-control">
                                                    <option value="" disabled selected><?php echo e($getId->department); ?></option>
                                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php if($errors->has('department')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('department')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="input-field">
                                                <label for="position">Position</label>
                                                <select id="position" name="position" class="form-control">
                                                    <option value=""><?php echo e($getId->position); ?></option>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#department').on('change', function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    $.ajax({
                        url: '/SuperAdmin/positionsSuper/' + departmentId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#position').empty();
                            $('#position').append('<option value="">Select Position</option>');
                            $.each(data, function(key, value) {
                                $('#position').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + error);
                        }
                    });
                } else {
                    $('#position').empty();
                    $('#position').append('<option value="">Select Position</option>');
                }
            });
        });
    </script>

   
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/superadmin/employee/editemployee.blade.php ENDPATH**/ ?>