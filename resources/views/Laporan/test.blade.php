@extends('template.header-footer')

@section('content')
    <style>
        .th-width {
            width: 150px;
            text-align: center;
        }

        .th-width2 {
            width: 200px;
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
                    <a href="{{ route('temuan.create') }}" class="btn btn-primary mb-3">Tambah Temuan</a>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('temuan.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by NO LHP or Nama OPD" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-md-2">
                                <!-- In your Blade template -->
                                <a href="{{ route('temuan.downloadPdf', ['search' => request('search')]) }}"
                                    class="btn btn-danger">Download PDF</a>

                            </div>
                        </div>
                    </form>

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
                        <!-- SKTJM Tab -->
                        <div class="tab-pane fade show active overflow-auto" id="bordered-justified-home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="table-responsive">
                                <table class="table">
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
                                                <td> <a
                                                        href="{{ route('data.show', $temuan->id) }}">{{ $temuan->no_lhp }}</a>
                                                </td>
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
                                                        <a href="{{ asset('bukti_temuan/' . $temuan->bukti_surat) }}"
                                                            target="_blank">View</a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex " style="gap: 5px">
                                                        <a href="{{ route('temuan.edit', $temuan) }}"
                                                            class="btn btn-warning"><i
                                                                class="bi bi-pencil-square"></i></a>
                                                        <form action="{{ route('temuan.destroy', $temuan) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="bi bi-trash3"></i></button>
                                                        </form>
                                                        <a href="{{ route('pembayaran.create', $temuan) }}"
                                                            class="btn btn-success"><i
                                                                class="bi bi-currency-dollar"></i></a>
                                                        <a href="{{ route('pembayaran.index', $temuan) }}"
                                                            class="btn btn-secondary"><i
                                                                class="bi bi-hourglass-split"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- SKP2KS Tab -->
                        <div class="tab-pane fade overflow-auto" id="bordered-justified-profile" role="tabpanel"
                            aria-labelledby="profile-tab">
                            <div class="table-responsive">
                                <table class="table">
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
                                        @foreach ($temuans2 as $temuan)
                                            <tr>
                                                <td> <a
                                                        href="{{ route('data.show', $temuan->id) }}">{{ $temuan->no_lhp }}</a>
                                                </td>
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
                                                <td>
                                                    @if ($temuan->bukti_surat)
                                                        <a href="{{ asset('bukti_temuan/' . $temuan->bukti_surat) }}"
                                                            target="_blank">View</a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('temuan.edit', $temuan) }}"
                                                            class="btn btn-warning me-1"><i
                                                                class="bi bi-pencil-square"></i></a>
                                                        <form action="{{ route('temuan.destroy', $temuan) }}"
                                                            method="POST" class="me-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="bi bi-trash3"></i></button>
                                                        </form>
                                                        <a href="{{ route('pembayaran.create', $temuan) }}"
                                                            class="btn btn-success me-1"><i
                                                                class="bi bi-currency-dollar"></i></a>
                                                        <a href="{{ route('pembayaran.index', $temuan) }}"
                                                            class="btn btn-secondary"><i
                                                                class="bi bi-hourglass-split"></i></a>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- SKP2K Tab -->
                        <div class="tab-pane fade overflow-auto" id="bordered-justified-contact" role="tabpanel"
                            aria-labelledby="contact-tab">
                            <div class="table-responsive">
                                <table class="table">
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
                                        @foreach ($temuans3 as $temuan)
                                            <tr>
                                                <td> <a
                                                        href="{{ route('data.show', $temuan->id) }}">{{ $temuan->no_lhp }}</a>
                                                </td>
                                                <td>{{ $temuan->informasi->dinas_name }}</td>
                                                <td>{{ $temuan->obrik_pemeriksaan }}</td>
                                                <td>{{ $temuan->opd->opd_name }}</td>
                                                <td>{{ $temuan->temuan }}</td>
                                                <td>{{ $temuan->rekomendasi }}</td>
                                                <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}
                                                </td>
                                                <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}
                                                </td>
                                                <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                                                <td>{{ $temuan->status->status }}</td>
                                                <td>{{ $temuan->pegawai->name }}</td>
                                                <td>{{ $temuan->penyedia->penyedia_name }}</td>
                                                <td>{{ $temuan->tgl_lhp }}</td>
                                                <td>
                                                <td>
                                                    @if ($temuan->bukti_surat)
                                                        <a href="{{ asset('bukti_temuan/' . $temuan->bukti_surat) }}"
                                                            target="_blank">View</a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>

                                                </td>
                                                <td>
                                                    <div class="d-flex" style="gap: 5px">
                                                        <a href="{{ route('temuan.edit', $temuan) }}"
                                                            class="btn btn-light"><i class="bi bi-pencil-square"></i></a>
                                                        <form action="{{ route('temuan.destroy', $temuan) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light"><i
                                                                    class="bi bi-trash3"></i></button>
                                                        </form>
                                                        <a href="{{ route('pembayaran.create', $temuan) }}"
                                                            class="btn btn-light"><i
                                                                class="bi bi-currency-dollar"></i></a>
                                                        <a href="{{ route('pembayaran.index', $temuan) }}"
                                                            class="btn btn-light"><i
                                                                class="bi bi-hourglass-split"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Bordered Tabs Justified -->
                </div>
        </section>
    </main><!-- End #main -->
@endsection
