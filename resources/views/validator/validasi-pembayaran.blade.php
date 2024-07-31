<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SITEGAR APPS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('NiceAdmin/assets/img/sitegarapss.png') }}" rel="icon">
    <link href="{{ asset('NiceAdmin/assets/img/sitegarapss.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
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
                    <img src="{{ asset('NiceAdmin/assets/img/sitegarapss.png') }}" alt="logo">
                    <span class="d-none d-lg-block">SITGAR</span>
                    <img height="" src="{{ asset('NiceAdmin/assets/img/logokabupatenketapang.png') }}" alt="logo2">
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
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            @if (Auth::user()->photo)
                                <img src="{{ asset('photos/' . Auth::user()->photo) }}" alt="Profile" class="rounded-circle">
                            @else
                                <img src="{{ asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
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
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit', Auth::user()->id) }}">
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
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <main id="main" class="main">
        <section class="section">
            <div class="container">
                <h2 class="mb-4">Validasi Pembayaran</h2>

                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            {{-- <th>Temuan ID</th> --}}
                            <th>Jumlah Pembayaran</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                            <th>Status</th>
                            <th>OPD Name</th>
                            <th>No LHP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            <tr>
                                <td>{{ $pembayaran->id }}</td>
                                {{-- <td>{{ $pembayaran->temuan->id }}</td> --}}
                                <td class="jumlah-pembayaran">{{ $pembayaran->jumlah_pembayaran }}</td>
                                <td>{{ $pembayaran->tgl_pembayaran }}</td>
                                <td>
                                    @if ($pembayaran->bukti_pembayaran)
                                        <a href="{{ url('bukti_pembayaran/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-info btn-sm">Lihat Bukti</a>
                                    @endif
                                </td>
                                <td>{{ ucfirst($pembayaran->status) }}</td>
                                <td>{{ $pembayaran->temuan->opd->opd_name ?? 'N/A' }}</td>
                                <td><a class="a-none" href="{{ route('data.show', $pembayaran->id) }}">{{ $pembayaran->temuan->no_lhp ?? 'N/A' }}</a></td>
                                <td>
                                    @if ($pembayaran->status == 'pending')
                                        <form action="{{ route('pembayaran.validate', $pembayaran->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm mb-2" required>
                                                <option value="diterima">Terima</option>
                                                <option value="ditolak">Tolak</option>
                                            </select>
                                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                        </form>
                                    @else
                                        {{ ucfirst($pembayaran->status) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SITGAR</span></strong> Apps
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.jumlah-pembayaran');
            elements.forEach(function (element) {
                const amount = parseFloat(element.textContent);
                if (!isNaN(amount)) {
                    element.textContent = amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                }
            });
        });
    </script>

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
