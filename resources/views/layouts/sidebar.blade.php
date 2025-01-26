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
                    <a href={{ url('/') }} class="d-block"><b>{{ session('logged_in_user')['nama'] }}</b>
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
                @if (session('logged_in_user')['level'] === 'bec' || session('logged_in_user')['level'] === 'ktt')
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-arrow-alt-circle-up"></i>
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
                @endif
                <li class="nav-item">
                    <a href={{ url('/history') }} class="nav-link">
                        <i class="fas fa-undo-alt"></i>
                        <p>History</p>
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
                <li class="nav-item">
                    <a href="{{ url('/personal_task_she') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Personal Task SHE</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/personal_task_pjo') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Personal Task PJO</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/personal_task_bec') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Personal Task BEC</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/personal_task_ktt') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>Personal Task KTT</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/personal_task_rejected') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-times"></i>
                        <p>Personal Task rejected</p>
                    </a>
                </li>
                @endif

                {{-- reset password --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <form action="{{ url('/karyawan/reset-password') }}" method="POST" class="nav-link">
                                @csrf
                                <!-- Input Hidden untuk NIK -->
                                <input type="hidden" name="nik"
                                    value="{{ session('logged_in_user')['identifier'] }}">
                                <button type="submit" class="btn btn-link nav-link"
                                    style="border: none; background: none; padding: 0; margin: 0;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Reset Password</p>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/about') }}" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>About</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column mt-4" style="position: absolute; bottom: 10px;">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
