<style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Arial', sans-serif;
    }

    /* Full height container */
    .content-header {
        position: relative;
        height: 100vh;
        /* Full viewport height */
        width: 100%;
        overflow: hidden;
        /* Ensure no overflow issues */
    }

    /* Background Image with Blur */
    .content-header .bg-image {
        background-image: url('{{ asset('adminlte/img/bg.jpg') }}');
        /* Path ke gambar */
        height: 100%;
        width: 100%;
        background-position: center;
        background-size: cover;
        position: absolute;
        top: 0;
        left: 0;
        filter: blur(4px);
        /* Blur effect */
        z-index: 1;
        /* Behind everything */
    }

    /* Overlay for dark effect */
    .content-header .overlay {
        background-color: rgba(0, 0, 0, 0.195);
        /* Transparent dark overlay */
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 1;
        /* Above background but behind content */
    }

    /* Centering the content */
    .content-header .content-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: rgb(255, 255, 255);
        z-index: 1;
        /* Above overlay and background */
    }

    .content-header .content-center h1 {
        font-size: 4rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .content-header .content-center p {
        font-size: 1.5rem;
        margin-bottom: 30px;
    }

    .content-header .content-center .countdown {
        font-size: 2rem;
    }
</style>
@extends('layouts.main')

@section('content')
    <div class="content-header">
        <!-- Background Image with Blur -->
        <div class="bg-image"></div>
        <div class="overlay"></div>

        <!-- Content in the center -->
        <div class="content-center">
            <h1>Coming Soon</h1>
            <p>We're working on something amazing. Stay tuned!</p>
            <div class="countdown" id="countdown-timer">
                Launching in: <span id="timer"></span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set the launch date
        var launchDate = new Date("Dec 31, 2024 23:59:59").getTime();

        // Update the countdown every second
        var countdownInterval = setInterval(function() {
            var now = new Date().getTime();
            var distance = launchDate - now;

            // Calculate days, hours, minutes, and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result
            document.getElementById("countdown-timer").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            // If the countdown is finished, display a message
            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown-timer").innerHTML = "We're live!";
            }
        }, 1000);
    </script>
@endsection
