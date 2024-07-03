<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview- <?php echo e($getId->name); ?> <?php echo e($getId->lastname); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo e(asset('lib/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')); ?>" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
</head>
<style>
    body {
        width: 210mm;
        height: 297mm;
        margin: 0 auto;
        /* Optional: Center the content on the page */
    }

    /* Additional styles for your content go here */
</style>

<?php if(Auth::user()->user_type == '0'): ?>
<body class="bg-white" onclick="window.location='<?php echo e(url('SuperAdmin/Employee')); ?>'" style="cursor: pointer;">
<?php elseif(Auth::user()->user_type == '1'): ?>
<body class="bg-white" onclick="window.location='<?php echo e(url('Admin/Employee')); ?>'" style="cursor: pointer;">
<?php endif; ?>
    <container class="col-12">
        <div class="row g-4">
            <div class="col-sm-4 col-xl-4 text-center d-flex justify-content-around align-items-center">
                <img src="<?php echo e(asset('img/LOGOSULOP.png')); ?>" alt="Super Admin" width="350px">
            </div>
            <div class="col-sm-8 col-xl-8 ">
                <div class="mt-5 bg-success " style="height:50%; width:100%">
                    <p class="mt-2 d-flex justify-content-center align-items-center">
                    <h3 class="mt-5 text-center d-flex justify-content-around align-items-center text-white">Employee
                        Information
                        Sheet</h3>
                    </p>
                </div>
                <p class="mt-1 text-end text-dark"><?php echo e(now()->format('Y-m-d')); ?></p>
            </div>

            <div class=" bg-success " style="height:50%; width:100%">
                <p class=" d-flex justify-content-center align-items-center">
                <h3 class=" text-start  text-white">Personal Information:</h3>
                </p>
            </div>
            <h3 class="text-dark"><?php echo e($getId->name); ?> <?php echo e($getId->middlename); ?> <?php echo e($getId->lastname); ?></h3>

            <div class="col-sm-4 col-xl-4 text-start text-dark ">
                <p>Email:</p>
                <p><?php echo e($getId->email); ?></p>
            </div>
            <div class="col-sm-8 col-xl-8 text-dark">
                <p>Cell Phone:</p>
                <p><?php echo e($getId->phonenumber); ?></p>
            </div>
            <div class="col-sm-4 col-xl-4 text-start text-dark ">
                <p>Address:</p>
                <p><?php echo e($getId->fulladdress); ?></p>
            </div>
            <div class="col-sm-8 col-xl-8 text-dark">
                <p>Birth Date:</p>
                <p><?php echo e($getId->birth_date); ?></p>
            </div>
            <div class="col-sm-12 col-xl-12 text-dark">
                <p>Marital Status:</p>
                <p><?php echo e($getId->civil_status); ?></p>
            </div>
            <div class=" bg-success " style="height:50%; width:100%">
                <p class=" d-flex justify-content-center align-items-center">
                <h3 class=" text-start  text-white">Job Information:</h3>
                </p>
            </div>
            <div class="col-sm-12 col-xl-12 border-bottom border-info">
                <div class="row g-4">
                    <div class="col-sm-3 col-xl-3 text-start text-dark ">
                        <p>Title:</p>
                        <p><?php echo e($getId->position); ?></p>
                    </div>
                    <div class="col-sm-3 col-xl-3 text-dark">
                        <p>Employee ID:</p>
                        <p><?php echo e($getId->custom_id); ?></p>
                    </div>
                    <div class="col-sm-3 col-xl-3 text-start text-dark ">
                        <p>Start Date:</p>
                        <p><?php echo e($getId->created_at); ?></p>
                    </div>
                    <div class="col-sm-3 col-xl-3 text-start text-dark ">
                        <p>End of Contract:</p>
                        <p><?php echo e($getId->end_of_contract); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-12 border-bottom border-info">
                <div class="row g-4">
                    <div class="col-sm-8 col-xl-8 text-start text-dark ">
                        <p>Department:</p>
                        <p><?php echo e($getId->department); ?></p>
                    </div>
                   
                    <div class="col-sm-4 col-xl-4 text-start text-dark ">
                        <p>Daily Rate:</p>
                        <p><?php echo e($getId->daily_rate); ?></p>
                    </div>
                </div>
            </div>
            <div class=" bg-success " style="height:50%; width:100%">
                <p class=" d-flex justify-content-center align-items-center">
                <h3 class=" text-start  text-white">Emergency Contact Information:</h3>
                </p>
            </div>
            <h3 class="text-dark"><?php echo e($getId->emergency_fullname); ?></h3>
            <div class="col-sm-12 col-xl-12">
                <div class="row g-4">
                    <div class="col-sm-4 col-xl-4 text-start text-dark ">
                        <p>Address:</p>
                        <p><?php echo e($getId->emergency_fulladdress); ?></p>
                    </div>
                    <div class="col-sm-4 col-xl-4 text-dark">
                        <p>Phone Number:</p>
                        <p><?php echo e($getId->emergency_phonenumber); ?></p>
                    </div>
                    <div class="col-sm-4 col-xl-4 text-start text-dark ">
                        <p>Relationship:</p>
                        <p><?php echo e($getId->emergency_relationship); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </container>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('lib/chart/chart.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/easing/easing.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/waypoints/waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/owlcarousel/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/tempusdominus/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/tempusdominus/js/moment-timezone.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>

<!-- Template Javascript -->
<script src="<?php echo e(asset('js/main.js')); ?>"></script>

</html><?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/admin/employee/previewemployee.blade.php ENDPATH**/ ?>