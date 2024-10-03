<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>B'Mine - Buma IPR</title>

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css?v=3.2.0') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <style>
        /* Tambahkan gambar latar belakang */
        body {
            background-image: url('{{ asset('adminlte/img/bg-login.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            position: relative;
            z-index: 1;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna hitam transparan */
            z-index: -1;
            /* Supaya tetap di belakang konten */
            filter: blur(5px);
            /* Efek blur */
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.8);
            /* Memberikan efek transparan pada kotak login */
            padding: 20px;
            border-radius: 10px;
        }

        .login-logo img {
            margin-bottom: 1px;
        }

        /* Tambahkan styling untuk footer */
        .footer {
            text-align: center;
            color: rgb(0, 0, 0);
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <!-- Logo Website -->
            <img src="{{ asset('adminlte/img/bmine-logo.png') }}" alt="Logo" width="100"><br>
            <span class="brand-text font-weight-light">
                <b>
                    <h5 style="color: orange;">Mining Identity Number Electronic</h5>
                </b>
            </span>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <!-- Login Form -->
                <form action="" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            {{-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> --}}
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-block">Sign In</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>Copyright © 2024 BUMA Site IPR. <br>
                All rights reserved.</p>
        </div>
        <!-- /.footer -->
    </div>



    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>
