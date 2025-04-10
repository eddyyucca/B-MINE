<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>B'Mine - Login</title>

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css?v=3.2.0') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: url('{{ asset('adminlte/img/bg-login.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.8), rgba(76, 175, 80, 0.8));
            z-index: -1;
        }

        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: -2;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            background-color: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo img {
            width: 80px;
            height: auto;
        }

        .logo-text {
            color: #ff8c00;
            margin-top: 8px;
            font-size: 15px;
            font-weight: 600;
        }

        .login-heading {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        .login-subheading {
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 40px 10px 40px;
            border: none;
            background-color: #f7f7f7;
            border-radius: 50px;
            font-size: 13px;
            transition: all 0.3s;
        }

        .input-group input:focus {
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 2px rgba(255, 140, 0, 0.3);
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #ff8c00;
        }

        .login-btn {
            background: linear-gradient(to right, #ff8c00, #4caf50);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin: 15px auto;
            display: block;
            width: 100%;
            max-width: 180px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 140, 0, 0.4);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .forgot-link {
            color: #ff8c00;
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: #4caf50;
            text-decoration: none;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 10px 15px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            position: relative;
            padding-top: 15px;
        }

        .footer:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 140, 0, 0.5), transparent);
        }

        .footer p {
            margin: 0;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="{{ asset('adminlte/img/bmine-logo.png') }}" alt="B'Mine Logo">
            <div class="logo-text">Mining Identity Number Electronic</div>
        </div>

        <h2 class="login-heading">LOGIN</h2>
        <p class="login-subheading">Sign in to start your session</p>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('auth') }}" method="post">
            @csrf
            <div class="input-group">
                <span class="input-icon">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" placeholder="NIK/Email" name="identifier" required>
            </div>

            <div class="input-group">
                <span class="input-icon">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" placeholder="Password" name="password" id="password" required>
                <span class="toggle-password">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <div class="remember-forgot">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">Login Now</button>
        </form>

        <div class="footer">
            <p><strong>Copyright © 2025 B'Mine</strong><br>
                <span style="color: #ff8c00;">All rights reserved.</span>
            </p>
        </div>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('.toggle-password').click(function() {
                const passwordInput = $('#password');
                const passwordFieldType = passwordInput.attr('type');
                const eyeIcon = $(this).find('i');

                if (passwordFieldType === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
</body>

</html>
