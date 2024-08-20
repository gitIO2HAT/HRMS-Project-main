<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="row g-4">
                <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-sm-12 col-xl-12">
                    <div>
                        <h2 class="text-dark text-start border-bottom border-success">My Account</h2>
                    </div>
                    <div class="bg-white text-center p-4">
                        <div class="user-head">
                            <div class=" text-dark d-flex justify-content-between border-bottom  ">
                                <a>Personal Details</a>
                            </div>

                            <form method="POST" action="<?php echo e(url('/Employee/MyAccount/Update')); ?>" enctype="multipart/form-data">
                               <?php echo csrf_field(); ?>
                                <div class="row g-4">
                                    <div class="col-sm-3 col-xl-3 border-end  border-bottom">
                                        <div class="fields">
                                            <div class="mt-2" id="profileContainer">
                                                <label for="profileImage" onclick="handleImageClick(event)">
                                                    <img class="rounded-circle" id="profilePicture" src="<?php echo e(asset('public/accountprofile/' . Auth::user()->profile_pic)); ?>"
                                                        alt="Profile" width="100px" style="cursor: pointer;">
                                                </label>
                                                <input type="file" name="profile_pic" id="profileImage" style="display: none;"
                                                    onchange="displayImage(this)">
                                            </div>
                                            <div class="border-bottom border-light ">
                                                <h5 class="text-dark"><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->middlename); ?> <?php echo e(Auth::user()->lastname); ?></h5>
                                                <h6 class="text-light"><?php echo e(Auth::user()->position); ?></h6>
                                                <h6 class="text-light"><?php echo e(Auth::user()->department); ?></h6>
                                            </div>
                                            <div>
                                                <div class="mt-2">
                                                    <h5 class="text-light text-start">Email Address</h5>
                                                    <p class="text-start text-dark"><?php echo e(Auth::user()->email); ?></p>
                                                </div>
                                                <div class="">
                                                    <h5 class="text-light text-start">Mobile Number</h5>
                                                    <p class="text-start text-dark"><?php echo e(Auth::user()->phonenumber); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label class="text-start">First Name</label>
                                                <input type="text" placeholder="Enter First Name" class="form-control"
                                                    name="name" value="<?php echo e(Auth::user()->name); ?>" required>
                                                <?php if($errors->has('name')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Middle Name</label>
                                                <input type="text" placeholder="Enter Middle Name" class="form-control"
                                                    name="middlename" value="<?php echo e(Auth::user()->middlename); ?>" required>
                                                <?php if($errors->has('middlename')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('middlename')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Last Name</label>
                                                <input type="text" placeholder="Enter Last Name" class="form-control"
                                                    name="lastname" value="<?php echo e(Auth::user()->lastname); ?>" required>
                                                <?php if($errors->has('lastname')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('lastname')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label for="suffix">Suffix</label>
                                                <select id="suffix" class="form-control" name="suffix">
                                                    <option selected disabled>--Select Suffix--</option>
                                                    <option value="Jr."<?php if(Auth::user()->suffix == 'Jr.'): ?> selected <?php endif; ?>>Jr.</option>
                                                    <option value="Sr." <?php if(Auth::user()->suffix == 'Sr.'): ?> selected <?php endif; ?>>Sr.</option>
                                                    <option value="I" <?php if(Auth::user()->suffix == 'I'): ?> selected <?php endif; ?>>I</option>
                                                    <option value="II" <?php if(Auth::user()->suffix == 'II'): ?> selected <?php endif; ?>>II</option>
                                                    <option value="III" <?php if(Auth::user()->suffix == 'III'): ?> selected <?php endif; ?>>III</option>
                                                </select>
                                                <?php if($errors->has('suffix')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('suffix')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">
                                            <div class="input-field">
                                                <label for="sex">Sex</label>
                                                <select id="sex" class="form-control" name="sex" required>
                                                    <option selected disabled>--Select Sex--</option>
                                                    <option value="Male" <?php if(Auth::user()->sex == 'Male'): ?> selected <?php endif; ?>>Male</option>
                                                    <option value="Female" <?php if(Auth::user()->sex == 'Female'): ?> selected <?php endif; ?>>Female</option>
                                                    <option value="Other" <?php if(Auth::user()->sex == 'Other'): ?> selected <?php endif; ?>>Other</option>
                                                    <?php if($errors->has('sex')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('sex')); ?></span>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="input-field">
                                                <label>Age</label>
                                                <input type="number" placeholder="Enter Age" class="form-control"
                                                    name="age" value="<?php echo e(Auth::user()->age); ?>" required>
                                                <?php if($errors->has('age')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('age')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Birth Date</label>
                                                <input type="date" placeholder="Enter Birth Date" class="form-control"
                                                    name="birth_date" value="<?php echo e(Auth::user()->birth_date); ?>" required>
                                                <?php if($errors->has('birth_date')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('birth_date')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="phonenumber"
                                                    pattern="(\+63\s?|0)(\d{3}\s?\d{3}\s?\d{4}|\d{4}\s?\d{3}\s?\d{4})"
                                                    placeholder="e.g., +63 123 456 7890 or 0912 345 6789" value="<?php echo e(Auth::user()->phonenumber); ?>"
                                                    required>
                                                <?php if($errors->has('phonenumber')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('phonenumber')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xl-3 border-bottom">
                                        <div class="fields">

                                            <div class="input-field">
                                                <label for="status">Civil Status</label>
                                                <select id="status" class="form-control" name="civil_status" required>
                                                    <option selected disabled>--Select Status--</option>
                                                    <option value="Single" <?php if(Auth::user()->civil_status == 'Single'): ?> selected <?php endif; ?>>Single</option>
                                                    <option value="Married" <?php if(Auth::user()->civil_status == 'Married'): ?> selected <?php endif; ?>>Married</option>
                                                    <option value="Widowed" <?php if(Auth::user()->civil_status == 'Widowed'): ?> selected <?php endif; ?>>Widowed</option>
                                                    <?php if($errors->has('civil_status')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('civil_status')); ?></span>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="input-field">
                                                <label>Full Address</label>
                                                <input type="text" placeholder="Enter Full Address" class="form-control"
                                                    name="fulladdress" value="<?php echo e(Auth::user()->fulladdress); ?>" required>
                                                <?php if($errors->has('fulladdress')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('fulladdress')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="input-field">
                                                <label>Email</label>
                                                <input type="email" placeholder="Enter Email" class="form-control"
                                                    name="email" value="<?php echo e(Auth::user()->email); ?>" required>
                                                <?php if($errors->has('email')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Password</label>
                                                <input type="password" placeholder="Enter Password" class="form-control"
                                                    name="password" value="">
                                                <?php if($errors->has('password')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" text-dark d-flex justify-content-between border-bottom  ">
                                        <a>Emergency Contact</a>
                                    </div>
                                    <div class="col-sm-12 col-xl-12">

                                        <div class="fields">
                                            <div class="input-field">
                                                <label class="text-start">Full Name</label>
                                                <input type="text" placeholder="Enter Full Name" class="form-control"
                                                    name="emergency_fullname" value="<?php echo e(Auth::user()->emergency_fullname); ?>" required>
                                                <?php if($errors->has('name')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Full Address</label>
                                                <input type="text" placeholder="Enter Full Address" class="form-control"
                                                    name="emergency_fulladdress" value="<?php echo e(Auth::user()->emergency_fulladdress); ?>" required>
                                                <?php if($errors->has('full_address')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('full_address')); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="input-field">
                                                <label>Phone Number</label>
                                                <input type="number" class="form-control" name="emergency_phonenumber"
                                                    pattern="(\+63\s?|0)(\d{3}\s?\d{3}\s?\d{4}|\d{4}\s?\d{3}\s?\d{4})"
                                                    placeholder="e.g., +63 123 456 7890 or 0912 345 6789" value="<?php echo e(Auth::user()->emergency_phonenumber); ?>"
                                                    required>
                                                <?php if($errors->has('phonenumber')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('phonenumber')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="input-field">
                                                <label>Relationship</label>
                                                <input type="text" placeholder="Enter Relationship" class="form-control"
                                                    name="emergency_relationship" value="<?php echo e(Auth::user()->emergency_relationship); ?>" required>
                                                <?php if($errors->has('emergency_relationship')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('emergency_relationship')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="<?php echo e(url('Employee/Dashboard')); ?>" class="btn btn-primary">Done<a>
                                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/employee/myaccount/myaccount.blade.php ENDPATH**/ ?>