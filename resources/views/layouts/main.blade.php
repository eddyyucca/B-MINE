<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/chart.js/Chart.min.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <style>
        /* CSS untuk progress bar */
        .loading-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(255, 255, 255);
            z-index: 9999;
        }

        /* Logo */
        .logo {
            width: 150px;
            /* Atur ukuran logo */
            margin-bottom: 20px;
            /* Jarak antara logo dan progress bar */
        }


        .progress-text {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 80%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #3498db;
            width: 0;
            transition: width 0.2s;
        }

        #content {
            visibility: hidden;
        }
    </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed">
    {{-- loading screen --}}
    <div class="loading-screen" id="loading-screen">
        <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo" class="logo">
        <div class="progress-text" id="progress-text">0%</div>
        <div class="progress-bar">
            <div class="progress-bar-fill" id="progress-bar-fill"></div>
        </div>
    </div>
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.footer')

    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    <!-- Page specific script -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>


    {{-- loading --}}
    <script>
        document.onreadystatechange = function() {
            if (document.readyState === "interactive") {
                let progress = 0;
                const progressText = document.getElementById('progress-text');
                const progressBarFill = document.getElementById('progress-bar-fill');

                const loadingInterval = setInterval(() => {
                    progress += Math.floor(Math.random() * 10) + 5; // Naikkan progress secara acak
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(loadingInterval);
                        document.getElementById('loading-screen').style.display = 'none';
                        document.getElementById('content').style.visibility = 'visible';
                    }
                    progressText.textContent = progress + '%';
                    progressBarFill.style.width = progress + '%';
                }, 100);
            }
        };
    </script>
    @yield('scripts')
</body>

</html>
