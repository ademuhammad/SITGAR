@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                <li class="breadcrumb-item">Data</li>
                <li class="breadcrumb-item active">{{ $data->no_lhp }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Temuan</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-file-earmark-text"></i></span>
                            <span class="info-box-text">No LHP :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->no_lhp }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-building"></i></span>
                            <span class="info-box-text">Sumber Informasi :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->informasi->dinas_name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-people"></i></span>
                            <span class="info-box-text">Nama OPD :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->opd->opd_name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-clipboard-check"></i></span>
                            <span class="info-box-text">Status :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->status->status }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($data->statustgr)
                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-clipboard"></i></span>
                            <span class="info-box-text">Status TGR :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->statustgr->status_tgr }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-person"></i></span>
                            <span class="info-box-text">Nama Pegawai :</span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{ $data->pegawai->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-truck"></i></span>
                            <span class="info-box-text">Nama Penyedia : </span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->penyedia->penyedia_name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-calendar"></i></span>
                            <span class="info-box-text">Tgl LHP :</span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{ $data->tgl_lhp }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-briefcase"></i></span>
                            <span class="info-box-text">Obrik Pemeriksaan :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->obrik_pemeriksaan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-file-earmark-text"></i></span>
                            <span class="info-box-text">Temuan :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">{{ $data->temuan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-file-earmark-check"></i></span>
                            <span class="info-box-text">Rekomendasi :</span>
                            <div class="info-box-content">
                                <span class="info-box-number">    {!! str_replace('pola_pencarian', 'pengganti', $data->rekomendasi) !!}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon "><i class="bi bi-currency-dollar"></i></span>
                            <span class="info-box-text">Nilai Rekomendasi : </span>
                            <div class="info-box-content">

                                <span class="info-box-number">Rp.{{ number_format($data->nilai_rekomendasi, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-currency-dollar"></i></span>
                            <span class="info-box-text">Nilai Telah Dibayar :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">Rp.{{ number_format($data->nilai_telah_dibayar, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-currency-dollar"></i></span>
                            <span class="info-box-text">Sisa Nilai Uang :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">Rp.{{ number_format($data->sisa_nilai_uang, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="info-box shadow-sm p-3 mb-5 bg-body rounded">
                            <span class="info-box-icon"><i class="bi bi-envelope"></i></span>
                            <span class="info-box-text">Bukti Surat :</span>
                            <div class="info-box-content">

                                <span class="info-box-number">
                                    @if ($data->bukti_surat)
                                        <a href="{{ asset('storage/' . $data->bukti_surat) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Bukti Surat</a>
                                    @else
                                        <span class="text-danger">Tidak ada bukti surat</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('data.index') }}" class="btn btn-primary mt-3">Kembali</a>
            </div>
        </div>
    </section>
</main>
@endsection
