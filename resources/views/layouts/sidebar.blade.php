<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo - Logo aplikasi B'MINE dengan desain yang lebih modern -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte/img/logo-bmine.png') }}" alt="B'MINE Logo" class="brand-image elevation-2"
            style="opacity: 1; margin-left: 10px;">
        <span class="brand-text font-weight-bold">B'MINE <span class="text-orange">App</span></span>
    </a>

    <!-- Sidebar - Container utama untuk elemen-elemen di sidebar -->
    <div class="sidebar">
        <!-- Search - Kotak pencarian dengan desain yang lebih modern dan animasi -->
        <div class="form-inline mt-4 d-flex">
            <div class="input-group search-animated" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar rounded-pill" type="search" placeholder="Search Menu"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar rounded-pill">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu - Daftar menu navigasi dalam sidebar dengan animasi hover -->
        <nav class="mt-1">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @php
                    // Mengambil level/role pengguna dari session untuk menentukan menu yang ditampilkan
                    $userLevel = session('logged_in_user')['level'] ?? '';
                @endphp

                <!-- Main Navigation - Header untuk kategori menu utama dengan ikon yang lebih besar -->
                <li class="nav-header"><i class="fas fa-compass mr-2"></i>MAIN NAVIGATION</li>
                <li class="nav-item">
                    <!-- Menu Dashboard - Menampilkan halaman utama aplikasi dengan efek hover -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-link menu-item-animated {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Tasks Management Section - Header untuk kategori manajemen tugas -->
                <li class="nav-header"><i class="fas fa-clipboard-list mr-2"></i>TASK MANAGEMENT</li>

                <!-- Admin Tasks - Menu khusus untuk admin, tidak ditampilkan untuk level bec dan ktt -->
                @if (!in_array($userLevel, ['bec', 'ktt']))
                    <li class="nav-item {{ request()->is('request*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link menu-item-animated {{ request()->is('request*') ? 'active' : '' }}">
                            <i class="fas fa-arrow-alt-circle-up nav-icon-custom"></i>
                            <p>
                                Admin Tasks
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Sub-menu Request untuk membuat permintaan baru -->
                            <li class="nav-item">
                                <a href="{{ route('request.index') }}"
                                    class="nav-link menu-item-animated {{ request()->is('request') ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>Request</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Task Status Views - Menu status tugas yang tersedia untuk semua pengguna -->
                <li
                    class="nav-item {{ request()->is('history') || request()->is('outstanding') || request()->is('personal_task/rejected/view') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link menu-item-animated {{ request()->is('history') || request()->is('outstanding') || request()->is('personal_task/rejected/view') ? 'active' : '' }}">
                        <i class="fas fa-tasks nav-icon-custom"></i>
                        <p>
                            Task Status
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Sub-menu History - Menampilkan riwayat tugas yang telah dikerjakan -->
                        <li class="nav-item">
                            <a href="{{ route('history') }}"
                                class="nav-link menu-item-animated {{ request()->is('history') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>History</p>
                            </a>
                        </li>
                        <!-- Sub-menu Outstanding - Menampilkan tugas yang sedang berjalan/belum selesai -->
                        <li class="nav-item">
                            <a href="{{ route('outstanding') }}"
                                class="nav-link menu-item-animated {{ request()->is('outstanding') ? 'active' : '' }}">
                                <i class="fas fa-hourglass-half nav-icon"></i>
                                <p>Outstanding</p>
                            </a>
                        </li>
                        <!-- Sub-menu Completed - Menampilkan tugas yang telah selesai, hanya untuk level admin dan she -->
                        @if (in_array($userLevel, ['admin', 'she']))
                            <li class="nav-item">
                                <a href="{{ route('data_completed') }}"
                                    class="nav-link menu-item-animated {{ request()->is('completed/submission') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard-check nav-icon"></i>
                                    <p>Completed</p>
                                </a>
                            </li>
                        @endif
                        <!-- Sub-menu Rejected - Menampilkan tugas yang ditolak -->
                        <li class="nav-item">
                            <a href="{{ route('reject.task') }}"
                                class="nav-link menu-item-animated {{ request()->is('personal_task/rejected/view') ? 'active' : '' }}">
                                <i class="fas fa-times-circle nav-icon"></i>
                                <p>Rejected</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Role-Specific Tasks - Menu khusus untuk admin untuk melihat tugas berdasarkan peran -->
                @if ($userLevel === 'admin')
                    <li class="nav-item {{ request()->is('personal_task/*/view') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link menu-item-animated {{ request()->is('personal_task/*/view') ? 'active' : '' }}">
                            <i class="fas fa-user-tag nav-icon-custom"></i>
                            <p>
                                Role Tasks
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Sub-menu SHE Tasks dengan ikon yang lebih sesuai -->
                            <li class="nav-item">
                                <a href="{{ route('she.task') }}"
                                    class="nav-link menu-item-animated {{ request()->is('personal_task/she/view') ? 'active' : '' }}">
                                    <i class="fas fa-user-shield nav-icon"></i>
                                    <p>
                                        SHE Tasks
                                        @if (isset($sheprosess) && $sheprosess > 0)
                                            <span class="badge badge-danger right">{{ $sheprosess }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <!-- Sub-menu PJO Tasks -->
                            <li class="nav-item">
                                <a href="{{ route('pjo.task') }}"
                                    class="nav-link menu-item-animated {{ request()->is('personal_task/pjo/view') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie nav-icon"></i>
                                    <p>
                                        PJO Tasks
                                        @if (isset($pjoprosess) && $pjoprosess > 0)
                                            <span class="badge badge-warning right">{{ $pjoprosess }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <!-- Sub-menu BEC Tasks -->
                            <li class="nav-item">
                                <a href="{{ route('bec.task') }}"
                                    class="nav-link menu-item-animated {{ request()->is('personal_task/bec/view') ? 'active' : '' }}">
                                    <i class="fas fa-user-cog nav-icon"></i>
                                    <p>
                                        BEC Tasks
                                        @if (isset($becprosess) && $becprosess > 0)
                                            <span class="badge badge-info right">{{ $becprosess }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                            <!-- Sub-menu KTT Tasks dengan sub-menu area -->
                            <li class="nav-item {{ request()->is('personal_task/ktt/view*') ? 'menu-open' : '' }}">
                                <a href="{{ route('ktt.task') }}"
                                    class="nav-link menu-item-animated {{ request()->is('personal_task/ktt/view*') ? 'active' : '' }}">
                                    <i class="fas fa-user-check nav-icon"></i>
                                    <p>
                                        KTT Tasks
                                        @if (isset($kttprosess) && $kttprosess > 0)
                                            <span class="badge badge-primary right">{{ $kttprosess }}</span>
                                        @endif
                                        @if (isset($kttTaskAreas) && count($kttTaskAreas) > 0)
                                            <i class="right fas fa-angle-left"></i>
                                        @endif
                                    </p>
                                </a>
                                @if (isset($kttTaskAreas) && count($kttTaskAreas) > 0)
                                    <!-- List area KTT -->
                                    <ul class="nav nav-treeview">
                                        @foreach ($kttTaskAreas as $area => $count)
                                            <li class="nav-item">
                                                <a href="{{ route('ktt.task', ['area' => $area]) }}"
                                                    class="nav-link {{ request()->query('area') == $area ? 'active' : '' }}">
                                                    <i class="fas fa-map-marker-alt nav-icon"></i>
                                                    <p>
                                                        Area {{ $area }}
                                                        @if ($count > 0)
                                                            <span
                                                                class="badge badge-info right">{{ $count }}</span>
                                                        @endif
                                                    </p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        </ul>
                    </li>
                    <!-- Menu My Tasks - Menampilkan tugas personal untuk level she, pjo, bec, dan ktt -->
                @elseif (in_array($userLevel, ['she', 'pjo', 'bec', 'ktt']))
                    <li
                        class="nav-item {{ $userLevel == 'ktt' && request()->is('personal_task/ktt/view*') ? 'menu-open' : '' }}">
                        <a href="{{ route($userLevel . '.task') }}"
                            class="nav-link menu-item-animated {{ request()->is('personal_task/' . $userLevel . '/view') ? 'active' : '' }}">
                            <i
                                class="nav-icon fas fa-user-{{ $userLevel == 'she' ? 'shield' : ($userLevel == 'pjo' ? 'tie' : ($userLevel == 'bec' ? 'cog' : 'check')) }} nav-icon-custom"></i>
                            <p>
                                My Tasks
                                @if ($userLevel == 'she' && isset($sheprosess) && $sheprosess > 0)
                                    <span class="badge badge-danger right">{{ $sheprosess }}</span>
                                @elseif ($userLevel == 'pjo' && isset($pjoprosess) && $pjoprosess > 0)
                                    <span class="badge badge-warning right">{{ $pjoprosess }}</span>
                                @elseif ($userLevel == 'bec' && isset($becprosess) && $becprosess > 0)
                                    <span class="badge badge-info right">{{ $becprosess }}</span>
                                @elseif (
                                    $userLevel == 'ktt' &&
                                        isset($userArea) &&
                                        isset($kttTaskAreas) &&
                                        isset($kttTaskAreas[$userArea]) &&
                                        $kttTaskAreas[$userArea] > 0)
                                    <span class="badge badge-primary right">{{ $kttTaskAreas[$userArea] }}</span>
                                @endif
                                @if (
                                    $userLevel == 'ktt' &&
                                        isset($userArea) &&
                                        isset($kttTaskAreas) &&
                                        isset($kttTaskAreas[$userArea]) &&
                                        $kttTaskAreas[$userArea] > 0)
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>
                        @if (
                            $userLevel == 'ktt' &&
                                isset($userArea) &&
                                isset($kttTaskAreas) &&
                                isset($kttTaskAreas[$userArea]) &&
                                $kttTaskAreas[$userArea] > 0)
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ktt.task', ['area' => $userArea]) }}"
                                        class="nav-link {{ !request()->has('area') || request()->query('area') == $userArea ? 'active' : '' }}">
                                        <i class="fas fa-map-marker-alt nav-icon"></i>
                                        <p>
                                            Area {{ $userArea }}
                                            <span class="badge badge-info right">{{ $kttTaskAreas[$userArea] }}</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </li>
                @endif

                <!-- Admin Features - Fitur-fitur administrasi khusus untuk level admin dan she -->
                @if (in_array($userLevel, ['admin', 'she']))
                    <li class="nav-header"><i class="fas fa-cog mr-2"></i>ADMINISTRATION</li>
                    <!-- Account Management - Menu untuk mengelola akun pengguna -->
                    <li class="nav-item {{ request()->is('akun*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link menu-item-animated {{ request()->is('akun*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon-custom"></i>
                            <p>
                                Account
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Sub-menu Internal Accounts - Mengelola akun pengguna internal -->
                            <li class="nav-item">
                                <a href="{{ route('dataaccounts_int.view') }}"
                                    class="nav-link menu-item-animated {{ request()->is('akun/internal') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends nav-icon"></i>
                                    <p>Internal Accounts</p>

                                </a>
                            </li>
                            <!-- Sub-menu External Accounts - Mengelola akun pengguna eksternal -->
                            <li class="nav-item">
                                <a href="{{ route('dataaccounts_ext.view') }}"
                                    class="nav-link menu-item-animated {{ request()->is('akun/external') ? 'active' : '' }}">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>External Accounts</p>

                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- User Settings - Pengaturan untuk akun pengguna yang sedang login -->
                <li class="nav-header"><i class="fas fa-user-cog mr-2"></i>USER SETTINGS</li>
                <li
                    class="nav-item {{ request()->routeIs('akun.change_password') || request()->routeIs('about') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link menu-item-animated {{ request()->routeIs('akun.change_password') || request()->routeIs('about') ? 'active' : '' }}">
                        <i class="fas fa-cogs nav-icon-custom"></i>
                        <p>
                            My Profile
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Sub-menu Change Password - Untuk mengubah kata sandi pengguna -->
                        <li class="nav-item">
                            <a href="{{ route('akun.change_password') }}"
                                class="nav-link menu-item-animated {{ request()->routeIs('akun.change_password') ? 'active' : '' }}">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <!-- Sub-menu About - Informasi tentang aplikasi -->
                        <li class="nav-item">
                            <a href="{{ route('about') }}"
                                class="nav-link menu-item-animated {{ request()->routeIs('about') ? 'active' : '' }}">
                                <i class="fas fa-info-circle nav-icon"></i>
                                <p>About</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Menu Logout - Untuk keluar dari sistem -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link menu-item-animated"
                            style="background: transparent; border: none; width: 100%; text-align: left;">
                            <i class="nav-icon fas fa-sign-out-alt nav-icon-custom"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Enhanced CSS styles for modern sidebar */
    .main-sidebar {
        background: linear-gradient(180deg, #2c3e50 0%, #1a2530 100%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: width 0.3s ease;
    }

    .brand-link {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .brand-link:hover {
        background: rgba(0, 0, 0, 0.3);
    }

    .brand-text {
        font-size: 1.3rem;
        display: inline-block;
        margin-left: 0.5rem;
        letter-spacing: 1px;
    }

    .user-panel {
        background: rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        padding: 10px;
        margin-left: 7px;
        margin-right: 7px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .user-panel:hover {
        background: rgba(0, 0, 0, 0.25);
        transform: translateY(-2px);
    }

    .user-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 5px;
    }

    .user-details {
        font-size: 0.8rem;
        line-height: 1.4;
        display: flex;
        flex-direction: column;
        color: #ccc;
    }

    .dept-area {
        display: flex;
        align-items: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-panel .info {
        padding-left: 10px;
        overflow: hidden;
        white-space: normal;
    }

    .badge {
        display: inline-block;
        font-size: 75%;
        padding: 0.25em 0.6em;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .badge-glow {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .text-orange {
        color: #FF8800 !important;
    }

    .border-orange {
        border-color: #FF8800 !important;
    }

    .badge-info {
        background-color: #17a2b8;
    }

    /* Improved search box */
    .search-animated {
        transition: all 0.3s ease;
        margin: 0 7px;
    }

    .search-animated:focus-within {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .form-control-sidebar {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        padding-left: 15px;
        transition: all 0.3s ease;
    }

    .form-control-sidebar:focus {
        background-color: rgba(255, 255, 255, 0.2);
        box-shadow: none;
    }

    .btn-sidebar {
        background-color: rgba(255, , 255, 255, 0.1);
        border: none;
        color: #adb5bd;
        transition: all 0.3s ease;
    }

    .btn-sidebar:hover {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    /* Improved treeview styles - Enhanced menu hierarchy */
    .nav-treeview {
        margin-left: 0.25rem;
        padding-left: 0.75rem;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-header {
        padding: 0.75rem 1rem 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #c2c7d0;
        margin-top: 0.5rem;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
    }

    .menu-open>.nav-link i.right {
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }

    .nav-sidebar .nav-item {
        margin-bottom: 0.2rem;
    }

    .nav-sidebar .nav-link {
        display: flex;
        align-items: center;
        border-radius: 6px;
        margin: 0 7px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .menu-item-animated {
        position: relative;
        overflow: hidden;
    }

    .menu-item-animated::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: all 0.5s ease;
    }

    .menu-item-animated:hover::before {
        left: 100%;
    }

    .menu-item-animated:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(3px);
    }

    .nav-sidebar .nav-link.active {
        background: linear-gradient(90deg, rgba(255, 136, 0, 0.7), rgba(255, 136, 0, 0.4));
        color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .nav-sidebar .nav-link i.nav-icon,
    .nav-sidebar .nav-link i.fas,
    .nav-sidebar .nav-link i.far {
        margin-right: 0.7rem;
        width: 1.6rem;
        text-align: center;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .nav-sidebar .nav-link:hover i {
        transform: scale(1.1);
    }

    .nav-icon-custom {
        color: #FF8800;
    }

    .nav-sidebar .nav-link p {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
        width: 100%;
    }

    /* Custom logout button */
    .logout-item {
        margin-top: 20px;
        margin-bottom: 80px;
        /* Meningkatkan ruang kosong di bawah tombol logout */
    }

    .logout-button {
        color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .logout-button:hover {
        background-color: rgba(220, 53, 69, 0.2) !important;
        color: #ff6b6b;
    }

    .logout-button:hover i {
        animation: shake 0.5s ease;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-2px);
        }

        40%,
        80% {
            transform: translateX(2px);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .user-panel {
            margin-left: 3px;
            margin-right: 3px;
        }

        .nav-sidebar .nav-link {
            margin: 0 3px;
            padding: 0.5rem 0.75rem;
        }
    }

    /* Dark theme enhanced contrast */
    .dark-mode .main-sidebar {
        background: linear-gradient(180deg, #171f26 0%, #0d1117 100%);
    }

    .dark-mode .nav-link.active {
        background: linear-gradient(90deg, #FF8800, #cc6600);
    }
</style>

<!--
    Sidebar telah dioptimalkan:
    - Desain modern dengan warna oranye sebagai aksen
    - Badge counter telah dihilangkan sesuai permintaan
    - Label admin telah dihilangkan
    - Tampilan informasi pengguna yang lebih baik
    - Interaktivitas dengan efek hover dan animasi
-->
