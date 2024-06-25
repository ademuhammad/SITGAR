@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Detail</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Data</li>
                    <li class="breadcrumb-item active">{{$data->no_lhp}}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->



        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Temuan</h5>

                    <table class="table">
                        <tr>
                            <th>No LHP</th>
                            <td>{{ $data->no_lhp }}</td>
                        </tr>
                        <tr>
                            <th>Sumber Informasi</th>
                            <td>{{ $data->informasi->dinas_name }}</td>
                        </tr>
                        <tr>
                            <th>Nama OPD</th>
                            <td>{{ $data->opd->opd_name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $data->status->status }}</td>
                        </tr>
                        <tr>
                            @if ($data->statustgr)
                                <th>Status TGR</th>
                                <td>{{ $data->statustgr->status_tgr }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Nama Pegawai</th>
                            <td>{{ $data->pegawai->name }}</td>
                        </tr>
                        <tr>
                            <th>Nama Penyedia</th>
                            <td>{{ $data->penyedia->penyedia_name }}</td>
                        </tr>
                        <tr>
                            <th>Tgl LHP</th>
                            <td>{{ $data->tgl_lhp }}</td>
                        </tr>
                        <tr>
                            <th>Obrik Pemeriksaan</th>
                            <td>{{ $data->obrik_pemeriksaan }}</td>
                        </tr>
                        <tr>
                            <th>data</th>
                            <td>{{ $data->temuan }}</td>
                        </tr>
                        <tr>
                            <th>Rekomendasi</th>
                            <td>{{ $data->rekomendasi }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Rekomendasi</th>
                            <td>{{ number_format($data->nilai_rekomendasi, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Nilai Telah Dibayar</th>
                            <td>{{ number_format($data->nilai_telah_dibayar, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Sisa Nilai Uang</th>
                            <td>{{ number_format($data->sisa_nilai_uang, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Bukti Surat</th>
                            <td>
                                @if ($data->bukti_surat)
                                    <a href="{{ asset('storage/' . $data->bukti_surat) }}" target="_blank">Lihat Bukti
                                        Surat</a>
                                @else
                                    Tidak ada bukti surat
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a href="{{ route('data.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </section>
    </main>
@endsection
