<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        .background {
            width: 100%;
            height: 100vh;
            background-image: url("img/SULOP.png");
            background-size: cover;
            background-position: center;
            filter: blur(20px);
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 75%;
            height: 550px;
            background-image: url(img/SULOP.png);
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-top: 20px;

        }

        .logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
        }

        .form {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
        }

        .form .form-login {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            background: transparent;
            backdrop-filter: blur(20px);
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            color: #e4e4e4;
        }

        .form-login h4 {
            font-size: 32px;
            text-align: center;
        }

        .form-login .input-box {
            position: relative;
            width: 340px;
            height: 50px;
            border-bottom: 2px solid #e4e4e4;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #e4e4e4;
            font-weight: 500;
            padding-right: 28px;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            font-size: 15px;
            font-weight: 500;
            pointer-events: none;
            transition: .5s ease;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }

        .input-box .icon {
            position: absolute;
            top: 13px;
            right: 0;
            font-size: 16px;
        }

        .remember-forgot {
            font-size: 14px;
            font-weight: 500;
            margin: -15px 0 15px;
            display: flex;
            justify-content: space-between;
        }

        .remember-forgot label input {
            accent-color: #e4e4e4;
            margin-right: 3px;
        }

        .remember-forgot a {
            color: #e4e4e4;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            height: 45px;
            background-color: rgba(37, 116, 37, 0.699);
            border: none;
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            color: #e4e4e4;
            font-weight: 500;
            box-shadow: 0 0 10px rgba(0, 0, 0, 2);
        }

        .btn:hover {
            background-color: rgb(50, 158, 50);
        }
    </style>

</head>

<body>
    <div class="background"></div>
    <div class="container">
        <div class="logo">
            <img src="<?php echo e(asset('img/SULOP.png')); ?>" alt="logo" height="550px">
        </div>

        <div class="form">
            <div class="form-login">
                <form method="post" action="<?php echo e(url('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="text-center">
                        <img src="<?php echo e(asset('img/HUMAN.png')); ?>" alt="logo" height="200px" weight="200px">
                    </div>
                    <?php if(Session::has('success')): ?>
                    <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
                    <?php endif; ?>
                    <?php echo $__env->make('layouts._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input name="email" type="email" required>
                        <label>Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input name="password" type="password" required>
                        <label>Password</label>
                    </div>

                    <div class="remember-forgot">


                    </div>

                    <div class="login">
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
            </div>

        </div>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\HRMS-Project-main\resources\views/loginform/login.blade.php ENDPATH**/ ?>