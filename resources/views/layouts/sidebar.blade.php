<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href={{ url('/') }} class="brand-link">
        <img src={{ asset('adminlte/img/logo-bmine.png') }} alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <div class="d-flex justify-content-center">
            <span class="brand-text font-weight-light"><b>B'MINE App</b></span>
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
                    <a href={{ url('/') }} class="d-block"> {{ session('logged_in_user')['nama'] }} <br>
                        <h6>{{ session('logged_in_user')['level'] }}</h6>
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
                    @if (session('logged_in_user')['level'] === 'admin')
                        <a href="{{ url('/personal_task') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task Admin</p>
                        </a>
                    @elseif (session('logged_in_user')['level'] === 'admin_section')
                        <a href="{{ url('/personal_task_she') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task Section</p>
                        </a>
                    @elseif (session('logged_in_user')['level'] === 'she')
                        <a href="{{ url('/personal_task_she') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task SHE</p>
                        </a>
                    @elseif (session('logged_in_user')['level'] === 'pjo')
                        <a href="{{ url('/personal_task_she') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task PJO</p>
                        </a>
                    @elseif (session('logged_in_user')['level'] === 'bec')
                        <a href="{{ url('/personal_task_bec') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task BEC</p>
                        </a>
                    @elseif (session('logged_in_user')['level'] === 'ktt')
                        <a href="{{ url('/personal_task_ktt') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Personal Task KTT</p>
                        </a>
                </li>
                @endif
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link"
                            style="background: none; border: none; color: white; padding: 0; text-align: left; width: 100%;">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column mt-4" style="position: absolute; bottom: 10px;">
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
