<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Toggle sidebar button -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link toggle-sidebar" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <div class="page-title">
                <h5 class="mb-0"><span class="user-welcome">{{ session('logged_in_user')['nama'] }}</span>
                </h5>
                <small
                    class="text-muted d-none d-md-inline-block">{{ session('logged_in_user')['departement'] }}</small>
            </div>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Date and time -->
        <li class="nav-item d-none d-md-inline-block">
            <div class="navbar-date-time">
                <div class="current-date" id="currentDate"></div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </li>

        <!-- Logo -->
        <li class="nav-item logo-container">
            <a class="nav-link" href="{{ url('/') }}">
                <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo" class="navbar-logo">
            </a>
        </li>
    </ul>
</nav>

<style>
    /* Enhanced Navbar Styling */
    .main-header.navbar {
        background: #ffffff;
        padding: 0.5rem 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        height: 60px;
        border-bottom: 1px solid #e9ecef;
    }

    /* Toggle sidebar button */
    .toggle-sidebar {
        color: #495057;
        font-size: 1.25rem;
        transition: all 0.3s ease;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
    }

    .toggle-sidebar:hover {
        background-color: rgba(0, 0, 0, 0.05);
        transform: scale(1.05);
    }

    .toggle-sidebar:active {
        transform: scale(0.95);
    }

    /* Page title styling */
    .page-title {
        margin-left: 10px;
        line-height: 1.1;
        padding-top: 3px;
    }

    .page-title h5 {
        color: #343a40;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 2px;
    }

    .user-welcome {
        color: #FF8800;
    }

    .page-title small {
        color: #6c757d;
        font-size: 0.75rem;
    }

    /* Date and time styling */
    .navbar-date-time {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        line-height: 1.1;
        margin-right: 15px;
        padding-top: 3px;
    }

    .current-date {
        color: #6c757d;
        font-size: 0.75rem;
    }

    .current-time {
        color: #343a40;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Logo styling */
    .logo-container {
        display: flex;
        align-items: center;
        padding-left: 10px;
        border-left: 1px solid #e9ecef;
    }

    .navbar-logo {
        height: 36px;
        transition: all 0.3s ease;
    }

    .navbar-logo:hover {
        transform: scale(1.05);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .logo-container {
            border-left: none;
        }

        .navbar-logo {
            height: 30px;
        }
    }

    /* Add script to the page for current date and time */
</style>

<script>
    // Function to update date and time
    function updateDateTime() {
        const dateElement = document.getElementById('currentDate');
        const timeElement = document.getElementById('currentTime');

        const now = new Date();

        // Format date: Mon, 23 Mar 2025
        const options = {
            weekday: 'short',
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        };
        dateElement.textContent = now.toLocaleDateString('id-ID', options);

        // Format time: 15:45
        timeElement.textContent = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Initial call and set interval
    document.addEventListener('DOMContentLoaded', function() {
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute
    });
</script>
