<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SITEGAR APPS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('NiceAdmin/assets/img/sitgar no bg.png') }}" rel="icon">
    <link href="{{ asset('NiceAdmin/assets/img/sitgar no bg.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('NiceAdmin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <div class="logo d-flex flex-column align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('NiceAdmin/assets/img/sitgar no bg.png') }}" alt="logo">
                    <span class="d-none d-lg-block">SITGAR</span>
                    <img height="" src="{{ asset('NiceAdmin/assets/img/logokabupatenketapang.png') }}"
                        alt="logo2">
                </div>
                <div class="logo-text">
                    <h6>KABUPATEN KETAPANG</h6>
                </div>
            </div>

            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    @auth
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                            data-bs-toggle="dropdown">

                            @if (Auth::user()->photo)
                                <img src="{{ asset('photos/' . Auth::user()->photo) }}" alt="Profile"
                                    class="rounded-circle">
                            @else
                                <img src="{{ asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="Profile"
                                    class="rounded-circle">
                            @endif

                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                        </a><!-- End Profile Image Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{ Auth::user()->name }}</h6>
                                <span>{{ Auth::user()->role }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('user.myprofile') }}">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>

                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('profile.edit', Auth::user()->id) }}">
                                <i class="bi bi-person"></i>
                                <span>Edit Profile</span>
                            </a>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>

                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            </li>
                        </ul><!-- End Profile Dropdown Items -->
                    @endauth
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard.index') ? 'active' : '' }}"
                    href="{{ route('dashboard.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            @role('Super Admin')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav"
                        class="nav-content collapse {{ Request::is('opds', 'informasi', 'pegawai', 'status', 'tgr', 'penyedia') ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">

                        <li>
                            <a href="{{ route('opds.index') }}" class="{{ Request::is('opds') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Nama OPD</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('informasi.index') }}"
                                class="{{ Request::is('informasi') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Sumber Informasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.index') }}" class="{{ Request::is('pegawai') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Pegawai</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('status.index') }}" class="{{ Request::is('status') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Status Proses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tgr.index') }}" class="{{ Request::is('tgr') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Status TGR (Tuntutan Ganti Rugi)</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('penyedia.index') }}"
                                class="{{ Request::is('penyedia') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Penyedia</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('jenistemuan.index') }}"
                                class="{{ Request::is('jenistemuan') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span> Jenis Jaminan</span>
                            </a>
                        </li>
                    </ul>
                </li><!-- End Components Nav -->
            @endrole


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Laporan Temuan</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav"
                    class="nav-content collapse {{ Request::is('data', 'temuan', 'temuans*') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('data.index') }}" class="{{ Request::is('data') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Temuan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('temuans.datasktjm') }}"
                            class="{{ Request::is('temuans/data-sktjm') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> SKTJM</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('temuans.dataskp2k') }}"
                            class="{{ Request::is('temuans/data-skp2k') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> SKP2K</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('temuans.dataskp2ks') }}"
                            class="{{ Request::is('temuans/data-skp2ks') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> SKP2KS</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surat-dipersamakan.index') }}"
                            class="{{ Request::is('surat-dipersamakan') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> Surat Dipersamakan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('temuans.selesai') }}"
                            class="{{ Request::is('temuans/selesai') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> Selesai</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data.alldata') }}"
                            class="{{ Request::is('data-keseluruhan') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> Temuan Keseluruhan</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            @role('Super Admin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Management User</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="user-nav" class="nav-content collapse {{ Request::is('user', 'role') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('user.index') }}" class="{{ Request::is('user') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>User</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('role.index') }}" class="{{ Request::is('role') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span> Role</span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            @endrole


        </ul>
    </aside><!-- End Sidebar-->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SITGAR</span></strong> Apps
        </div>

    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('NiceAdmin/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

</body>

</html>
