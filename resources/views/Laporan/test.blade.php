@extends('template.header-footer')

@section('content')
<style>

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
                <a href="{{ route('temuan.create') }}" class="btn btn-primary">Add New Temuan</a>

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
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col" class="th-width">NO LHP</th>
                                    <th scope="col" class="th-width">Sumber Informasi</th>
                                    <th scope="col" class="th-width">Obrik Pemeriksaan</th>
                                    <th scope="col" class="th-width">Nama OPD</th>
                                    <th scope="col" class="th-width">Temuan</th>
                                    <th scope="col" class="th-width">Rekomendasi</th>
                                    <th scope="col" class="th-width">Nilai Rekomendasi (Rp)</th>
                                    <th scope="col" class="th-width">Nilai Telah Dibayar (Rp)</th>
                                    <th scope="col" class="th-width">Sisa Nilai Uang (Rp)</th>
                                    <th scope="col" class="th-width">Status</th>
                                    <th scope="col" class="th-width">Nama PPK</th>
                                    <th scope="col" class="th-width">Nama Penyedia</th>
                                    <th scope="col" class="th-width">Tanggal</th>
                                    <th scope="col" class="th-width">Bukti Surat</th>
                                    <th scope="col" class="th-width">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($temuans as $temuan)
                                    <tr>
                                        <td>{{ $temuan->no_lhp }}</td>
                                        <td>{{ $temuan->informasi->dinas_name }}</td>
                                        <td>{{ $temuan->obrik_pemeriksaan }}</td>
                                        <td>{{ $temuan->opd->opd_name }}</td>
                                        <td>{{ $temuan->temuan }}</td>
                                        <td>{{ $temuan->rekomendasi }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                                        <td>{{ $temuan->status->status }}</td>
                                        <td>{{ $temuan->pegawai->name }}</td>
                                        <td>{{ $temuan->penyedia->penyedia_name }}</td>
                                        <td>{{ $temuan->tgl_lhp }}</td>
                                        <td>
                                            @if ($temuan->bukti_surat)
                                                <a href="{{ asset($temuan->bukti_surat) }}" target="_blank">View</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                         <a href="{{ route('temuan.edit', $temuan) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('temuan.destroy', $temuan) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <a href="{{ route('pembayaran.create', $temuan) }}" class="btn btn-success">Pembayaran</a>
                                            <a href="{{ route('pembayaran.index', $temuan) }}" class="btn btn-secondary">History</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade overflow-auto" id="bordered-justified-profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <!-- Add your SKP2KS content here -->
                        <table class="table table-borderless2 datatable6">
                            <thead>
                                <tr>
                                    <th scope="col" class="th-width2">NO LHP</th>
                                    <th scope="col" class="th-width2">Sumber Informasi</th>
                                    <th scope="col" class="th-width2">Obrik Pemeriksaan</th>
                                    <th scope="col" class="th-width2">Nama OPD</th>
                                    <th scope="col" class="th-width2">Temuan</th>
                                    <th scope="col" class="th-width2">Rekomendasi</th>
                                    <th scope="col" class="th-width2">Nilai Rekomendasi (Rp)</th>
                                    <th scope="col" class="th-width2">Nilai Telah Dibayar (Rp)</th>
                                    <th scope="col" class="th-width2">Sisa Nilai Uang (Rp)</th>
                                    <th scope="col" class="th-width2">Status</th>
                                    <th scope="col" class="th-width2">Nama PPK</th>
                                    <th scope="col" class="th-width2">Nama Penyedia</th>
                                    <th scope="col" class="th-width2">Tanggal</th>
                                    <th scope="col" class="th-width2">Bukti Surat</th>
                                    <th scope="col" class="th-width2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($temuans2 as $temuan)
                                    <tr>
                                        <td>{{ $temuan->no_lhp }}</td>
                                        <td>{{ $temuan->informasi->dinas_name }}</td>
                                        <td>{{ $temuan->obrik_pemeriksaan }}</td>
                                        <td>{{ $temuan->opd->opd_name }}</td>
                                        <td>{{ $temuan->temuan }}</td>
                                        <td>{{ $temuan->rekomendasi }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                                        <td>{{ $temuan->status->status }}</td>
                                        <td>{{ $temuan->pegawai->name }}</td>
                                        <td>{{ $temuan->penyedia->penyedia_name }}</td>
                                        <td>{{ $temuan->tgl_lhp }}</td>
                                        <td>
                                            @if ($temuan->bukti_surat)
                                                <a href="{{ asset($temuan->bukti_surat) }}" target="_blank">View</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                         <a href="{{ route('temuan.edit', $temuan) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('temuan.destroy', $temuan) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <a href="{{ route('pembayaran.create', $temuan) }}" class="btn btn-success">Pembayaran</a>
                                            <a href="{{ route('pembayaran.index', $temuan) }}" class="btn btn-secondary">History</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade overflow-auto" id="bordered-justified-contact" role="tabpanel"
                        aria-labelledby="contact-tab">
                        <!-- Add your SKP2K content here -->
                        <table class="table table-borderless3 datatable7">
                            <thead>
                                <tr>
                                    <th scope="col" class="th-width">NO LHP</th>
                                    <th scope="col" class="">Sumber Informasi</th>
                                    <th scope="col" class="">Obrik Pemeriksaan</th>
                                    <th scope="col" class="">Nama OPD</th>
                                    <th scope="col" class="">Temuan</th>
                                    <th scope="col" class="">Rekomendasi</th>
                                    <th scope="col" class="">Nilai Rekomendasi (Rp)</th>
                                    <th scope="col" class="">Nilai Telah Dibayar (Rp)</th>
                                    <th scope="col" class="">Sisa Nilai Uang (Rp)</th>
                                    <th scope="col" class="">Status</th>
                                    <th scope="col" class="">Nama PPK</th>
                                    <th scope="col" class="">Nama Penyedia</th>
                                    <th scope="col" class="">Tanggal</th>
                                    <th scope="col" class="">Bukti Surat</th>
                                    <th scope="col" class="">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($temuans3 as $temuan)
                                    <tr>
                                        <td>{{ $temuan->no_lhp }}</td>
                                        <td>{{ $temuan->informasi->dinas_name }}</td>
                                        <td>{{ $temuan->obrik_pemeriksaan }}</td>
                                        <td>{{ $temuan->opd->opd_name }}</td>
                                        <td>{{ $temuan->temuan }}</td>
                                        <td>{{ $temuan->rekomendasi }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                                        <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                                        <td>{{ $temuan->status->status }}</td>
                                        <td>{{ $temuan->pegawai->name }}</td>
                                        <td>{{ $temuan->penyedia->penyedia_name }}</td>
                                        <td>{{ $temuan->tgl_lhp }}</td>
                                        <td>
                                            @if ($temuan->bukti_surat)
                                                <a href="{{ asset($temuan->bukti_surat) }}" target="_blank">View</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                         <a href="{{ route('temuan.edit', $temuan) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('temuan.destroy', $temuan) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <a href="{{ route('pembayaran.create', $temuan) }}" class="btn btn-success">Pembayaran</a>
                                            <a href="{{ route('pembayaran.index', $temuan) }}" class="btn btn-secondary">History</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div><!-- End Bordered Tabs Justified -->
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection
