@extends('template.header-footer')
@section('content')
    <style>
        th.th-width {
            min-width: 100px;
        }
    </style>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Temuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Temuan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Temuan</h5>
                    <button type="button" class="btn btn-primary"><i class="file-earmark-plus-fill me-1"></i> With Text</button>
                    <!-- Bordered Tabs Justified -->
                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">SKTJM</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#bordered-justified-profile" type="button" role="tab"
                                aria-controls="profile" aria-selected="false">SKP2KS</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                aria-controls="contact" aria-selected="false">SKP2K</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                        <div class="tab-pane fade show active overflow-auto" id="bordered-justified-home" role="tabpanel"
                            aria-labelledby="home-tab">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vero blanditiis sit corrupti alias,
                            officia maxime voluptatibus eum itaque laboriosam voluptatum, facere nam laborum autem nostrum,
                            nemo ipsum. Consequatur, magnam molestias?
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="th-width">NO LHP</th>
                                        <th scope="col" class="th-width">Sumber Informasi</th>
                                        <th scope="col" class="th-width">Obrik pemeriksaan</th>
                                        <th scope="col" class="th-width">Nama OPD</th>
                                        <th scope="col" class="th-width">Temuan</th>
                                        <th scope="col" class="th-width">Rekomendasi</th>
                                        <th scope="col" class="th-width">Nilai Rekomendasi(Rp)</th>
                                        <th scope="col" class="th-width">Nilai telah dibayar (RP)</th>
                                        <th scope="col" class="th-width">Sisa nilai uang(RP)</th>
                                        <th scope="col" class="th-width">Status</th>
                                        <th scope="col" class="th-width">Nama PPK</th>
                                        <th scope="col" class="th-width">Nama Penyedia</th>
                                        <th scope="col" class="th-width">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>006</td>
                                        <td>Audit Internal</td>
                                        <td>Dinas Perhubungan</td>
                                        <td>Terminal Bus</td>
                                        <td>Kerusakan Fasilitas</td>
                                        <td>Perbaikan Fasilitas</td>
                                        <td>1,000,000,000</td>
                                        <td>600,000,000</td>
                                        <td>400,000,000</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                        <td>Drs. Arifin</td>
                                        <td>PT. Transport Aman</td>
                                        <td>2023-01-12</td>
                                    </tr>
                                    <tr>
                                        <td>007</td>
                                        <td>Laporan Warga</td>
                                        <td>Dinas Kebersihan</td>
                                        <td>TPA Kota</td>
                                        <td>Pencemaran Lingkungan</td>
                                        <td>Pembersihan Area</td>
                                        <td>800,000,000</td>
                                        <td>500,000,000</td>
                                        <td>300,000,000</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
                                        <td>Dr. Susi Hartati</td>
                                        <td>PT. Bersih Sejahtera</td>
                                        <td>2023-02-20</td>
                                    </tr>
                                    <tr>
                                        <td>008</td>
                                        <td>Laporan Media</td>
                                        <td>Dinas Pariwisata</td>
                                        <td>Destinasi Wisata</td>
                                        <td>Kurangnya Sarana</td>
                                        <td>Penambahan Fasilitas</td>
                                        <td>2,000,000,000</td>
                                        <td>1,200,000,000</td>
                                        <td>800,000,000</td>
                                        <td><span class="badge bg-warning">Belum Selesai</span></td>
                                        <td>Drs. Dedi Santoso</td>
                                        <td>PT. Wisata Indah</td>
                                        <td>2023-03-18</td>
                                    </tr>
                                    <tr>
                                        <td>009</td>
                                        <td>Laporan BPK</td>
                                        <td>Dinas Kehutanan</td>
                                        <td>Taman Kota</td>
                                        <td>Penebangan Liar</td>
                                        <td>Reboisasi</td>
                                        <td>1,500,000,000</td>
                                        <td>1,000,000,000</td>
                                        <td>500,000,000</td>
                                        <td>Proses</td>
                                        <td>Dr. Andi Firmansyah</td>
                                        <td>PT. Hutan Lestari</td>
                                        <td>2023-04-05</td>
                                    </tr>
                                    <tr>
                                        <td>010</td>
                                        <td>Laporan Masyarakat</td>
                                        <td>Dinas Pemadam Kebakaran</td>
                                        <td>Stasiun Damkar</td>
                                        <td>Kekurangan Alat</td>
                                        <td>Pengadaan Alat</td>
                                        <td>900,000,000</td>
                                        <td>600,000,000</td>
                                        <td>300,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Hendra Setiawan</td>
                                        <td>PT. Fire Safety</td>
                                        <td>2023-05-10</td>
                                    </tr>
                                    <tr>
                                        <td>011</td>
                                        <td>Audit Internal</td>
                                        <td>Dinas Kominfo</td>
                                        <td>Data Center</td>
                                        <td>Keamanan Data</td>
                                        <td>Upgrade Sistem</td>
                                        <td>3,000,000,000</td>
                                        <td>2,000,000,000</td>
                                        <td>1,000,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Bambang Hermawan</td>
                                        <td>PT. Data Secure</td>
                                        <td>2023-06-25</td>
                                    </tr>
                                    <tr>
                                        <td>012</td>
                                        <td>Laporan Warga</td>
                                        <td>Dinas Energi</td>
                                        <td>PLN Kota</td>
                                        <td>Pemadaman Listrik</td>
                                        <td>Perbaikan Jaringan</td>
                                        <td>1,700,000,000</td>
                                        <td>1,200,000,000</td>
                                        <td>500,000,000</td>
                                        <td>Proses</td>
                                        <td>Dr. Ferry Abdullah</td>
                                        <td>PT. Listrik Terang</td>
                                        <td>2023-07-11</td>
                                    </tr>
                                    <tr>
                                        <td>013</td>
                                        <td>Laporan Media</td>
                                        <td>Dinas Pertamanan</td>
                                        <td>Taman Kota</td>
                                        <td>Kurangnya Fasilitas</td>
                                        <td>Penambahan Fasilitas</td>
                                        <td>1,200,000,000</td>
                                        <td>700,000,000</td>
                                        <td>500,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Hariyanto</td>
                                        <td>PT. Taman Indah</td>
                                        <td>2023-08-15</td>
                                    </tr>
                                    <tr>
                                        <td>014</td>
                                        <td>Laporan BPK</td>
                                        <td>Dinas Perindustrian</td>
                                        <td>Industri Kecil</td>
                                        <td>Kurangnya Modal</td>
                                        <td>Pemberian Modal</td>
                                        <td>2,500,000,000</td>
                                        <td>1,500,000,000</td>
                                        <td>1,000,000,000</td>
                                        <td>Proses</td>
                                        <td>Dr. Ratna Dewi</td>
                                        <td>PT. Industri Maju</td>
                                        <td>2023-09-20</td>
                                    </tr>
                                    <tr>
                                        <td>015</td>
                                        <td>Laporan Masyarakat</td>
                                        <td>Dinas Koperasi</td>
                                        <td>Koperasi Kota</td>
                                        <td>Kurangnya Dana</td>
                                        <td>Pemberian Dana</td>
                                        <td>1,800,000,000</td>
                                        <td>1,200,000,000</td>
                                        <td>600,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Taufik Hidayat</td>
                                        <td>PT. Dana Koperasi</td>
                                        <td>2023-10-12</td>
                                    </tr>
                                    <tr>
                                        <td>016</td>
                                        <td>Audit Internal</td>
                                        <td>Dinas Kependudukan</td>
                                        <td>Disdukcapil</td>
                                        <td>Pengadaan KTP</td>
                                        <td>Penggantian Alat</td>
                                        <td>2,200,000,000</td>
                                        <td>1,500,000,000</td>
                                        <td>700,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Ali Akbar</td>
                                        <td>PT. Identitas Aman</td>
                                        <td>2023-11-15</td>
                                    </tr>
                                    <tr>
                                        <td>017</td>
                                        <td>Laporan Media</td>
                                        <td>Dinas Kebudayaan</td>
                                        <td>Museum Kota</td>
                                        <td>Kurangnya Koleksi</td>
                                        <td>Penambahan Koleksi</td>
                                        <td>900,000,000</td>
                                        <td>600,000,000</td>
                                        <td>300,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Bambang Wijaya</td>
                                        <td>PT. Budaya Lestari</td>
                                        <td>2023-12-20</td>
                                    </tr>
                                    <tr>
                                        <td>018</td>
                                        <td>Laporan BPK</td>
                                        <td>Dinas Lingkungan Hidup</td>
                                        <td>DLH Kota</td>
                                        <td>Pencemaran Air</td>
                                        <td>Pembersihan Sungai</td>
                                        <td>1,500,000,000</td>
                                        <td>1,000,000,000</td>
                                        <td>500,000,000</td>
                                        <td>Proses</td>
                                        <td>Dr. Dedi Mulyadi</td>
                                        <td>PT. Alam Bersih</td>
                                        <td>2024-01-10</td>
                                    </tr>
                                    <tr>
                                        <td>019</td>
                                        <td>Laporan Warga</td>
                                        <td>Dinas Pemuda dan Olahraga</td>
                                        <td>GOR Kota</td>
                                        <td>Kurangnya Fasilitas</td>
                                        <td>Penambahan Fasilitas</td>
                                        <td>2,000,000,000</td>
                                        <td>1,200,000,000</td>
                                        <td>800,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Sandi Yuda</td>
                                        <td>PT. Olahraga Maju</td>
                                        <td>2024-02-05</td>
                                    </tr>
                                    <tr>
                                        <td>020</td>
                                        <td>Laporan Media</td>
                                        <td>Dinas Perdagangan</td>
                                        <td>Pasar Kota</td>
                                        <td>Kerusakan Pasar</td>
                                        <td>Perbaikan Pasar</td>
                                        <td>1,000,000,000</td>
                                        <td>600,000,000</td>
                                        <td>400,000,000</td>
                                        <td>Proses</td>
                                        <td>Drs. Anto Suharto</td>
                                        <td>PT. Pasar Bersih</td>
                                        <td>2024-03-15</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel"
                            aria-labelledby="profile-tab">

                        </div>
                        <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel"
                            aria-labelledby="contact-tab">
                            Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque.
                            Accusantium
                            quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum
                            veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
                        </div>
                    </div><!-- End Bordered Tabs Justified -->

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
