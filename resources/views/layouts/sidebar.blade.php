<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href={{ url('/') }} class="brand-link">
        <img src={{ asset('adminlte/img/logo-bmine.png') }} alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <div class="d-flex justify-content-center">
            <span class="brand-text font-weight-light"><b>B'MINE | Buma-IPR</b></span>
        </div>
    </a>
    {{-- sidebar --}}
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/img/profil.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <div class="d-flex justify-content-center">
                    <a href={{ url('/') }} class="d-block">Eddy Adha Saputra <br>
                        <h6>Admin</h6>
                    </a>
                </div>

            </div>
        </div>
        {{-- search --}}
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href={{ url('/') }} class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href={{ url('/dashboard_external') }} class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard External</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-arrow-alt-circle-up"> </i>
                        <p>
                            Admin Task
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/request') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Request</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href={{ url('/comingsoon') }} class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Admin Task</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href={{ url('/comingsoon') }} class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Performance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href={{ url('/personal_tak') }} class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Personal Task</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href={{ url('/login') }} class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>Login / Logout</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column mt-4" style="position: absolute; bottom: 20px;">
                <li class="nav-item">
                    <a href="{{ url('/about') }}" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>About</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
