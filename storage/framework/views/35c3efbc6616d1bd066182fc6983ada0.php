<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-sm-12 col-xl-12">
                    <div>
                        <h2 class="text-dark text-start border-bottom border-success">Add New Employee</h2>
                    </div>
                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <div class="d-flex justify-content-between border-bottom  ">
                                <a>Admin Controller</a>
                            </div>

                            <form method="post" action="">
                                <?php echo csrf_field(); ?>
                                <div class="row g-4">
                                    <div class="col-sm-6 col-xl-6">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label>First Name</label>
                                                <input type="text" placeholder="Enter First Name" class="form-control" name="name" value="" required>
                                                <?php if($errors->has('name')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Middle Name</label>
                                                <input type="text" placeholder="Enter Middle Name" class="form-control" name="middlename" value="" required>
                                                <?php if($errors->has('middlename')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('middlename')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Last Name</label>
                                                <input type="text" placeholder="Enter Last Name" class="form-control" name="lastname" value="" required>
                                                <?php if($errors->has('lastname')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('lastname')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label for="suffix">Suffix</label>
                                                <select id="suffix" class="form-control" name="suffix">
                                                    <option selected disabled>--Select Suffix--</option>
                                                    <option value="Jr.">Jr.</option>
                                                    <option value="Sr.">Sr.</option>
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">II</option>
                                                </select>
                                                <?php if($errors->has('suffix')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('suffix')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-6">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label for="sex">Sex</label>
                                                <select id="sex" class="form-control" name="sex">
                                                    <option selected disabled>--Select Sex--</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                    <?php if($errors->has('sex')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('sex')); ?></span>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="input-field">
                                                <label>Birth Date</label>
                                                <input type="date" placeholder="Enter Birth Date" class="form-control" name="birth_date" id="birth_date" value="" required>
                                                <?php if($errors->has('birth_date')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('birth_date')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Age</label>
                                                <input type="number" placeholder="Enter Age" class="form-control" name="age" id="age" value="" required>
                                                <?php if($errors->has('age')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('age')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="phonenumber" pattern="(\+63\s?|0)(\d{3}\s?\d{3}\s?\d{4}|\d{4}\s?\d{3}\s?\d{4})" placeholder="e.g., +63 123 456 7890 or 0912 345 6789" value="" required>
                                                <?php if($errors->has('phonenumber')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('phonenumber')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xl-12">
                                        <div class="fields">
                                            <div class="hidden input-field">
                                                <label>Role</label>
                                                <input class="form-control" name="user_type" value="2" required>
                                                <?php if($errors->has('user_type')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('user_type')); ?></span>
                                                <?php endif; ?>
                                            </div>


                                            <div class="input-field">
                                                <label for="department">Department</label>
                                                <select id="department" name="department" class="form-control">
                                                    <option value="">Select Department</option>
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
                                                    <option value="">Select Position</option>
                                                </select>
                                                <?php if($errors->has('position')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('position')); ?></span>
                                                <?php endif; ?>
                                            </div>



                                            <div class="input-field">
                                                <label>Email</label>
                                                <input type="email" placeholder="Enter Email" class="form-control" name="email" value="" required>
                                                <?php if($errors->has('email')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="hidden input-field">
                                                <label>Password</label>
                                                <input type="password" value="12345" placeholder="Enter Password" class="form-control" name="password" value="" required>
                                                <?php if($errors->has('password')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>End of Contract</label>
                                                <input type="date" class="form-control" name="end_of_contract" required>
                                                <?php if($errors->has('birth_date')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('birth_date')); ?></span>
                                                <?php endif; ?>
                                            </div>


                                            <div class="input-field">
                                                <label>Daily Rate</label>
                                                <input type="numeric" class="form-control" name="daily_rate" placeholder="e.g., 560" value="" required>
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
                        url: '/Admin/positionsAdmin/' + departmentId,
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/employee/addemployee.blade.php ENDPATH**/ ?>