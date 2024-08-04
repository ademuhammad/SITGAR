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
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-text display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">No LHP :</h6>
                                <p class="mb-0">{{ $data->no_lhp }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-building display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Sumber Informasi :</h6>
                                <p class="mb-0">{{ $data->informasi->dinas_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Nama OPD :</h6>
                                <p class="mb-0">{{ $data->opd->opd_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clipboard-check display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Status :</h6>
                                <p class="mb-0">{{ $data->status->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($data->statustgr)
                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clipboard display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Status TGR :</h6>
                                <p class="mb-0">{{ $data->statustgr->status_tgr }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Nama PPK :</h6>
                                <p class="mb-0">{{ $data->pegawai->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-truck display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Nama Penyedia :</h6>
                                <p class="mb-0">{{ $data->penyedia->penyedia_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Tgl LHP :</h6>
                                <p class="mb-0">{{ $data->tgl_lhp }}</p>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-currency-dollar display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Nilai Rekomendasi :</h6>
                                <p class="mb-0">Rp.{{ number_format($data->nilai_rekomendasi, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-currency-dollar display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Nilai Telah Dibayar :</h6>
                                <p class="mb-0">Rp.{{ number_format($data->nilai_telah_dibayar, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-currency-dollar display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Sisa Nilai Uang :</h6>
                                <p class="mb-0">Rp.{{ number_format($data->sisa_nilai_uang, 2, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Bukti Surat :</h6>
                                <p class="mb-0">
                                    @if ($data->bukti_surat)
                                        <a href="{{ asset('storage/' . $data->bukti_surat) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Bukti Surat</a>
                                    @else
                                        <span class="text-danger">Tidak ada bukti surat</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-text display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Temuan :</h6>
                                <p class="mb-0">{{ $data->temuan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-check display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Rekomendasi :</h6>
                                <p class="mb-0">{!! str_replace('pola_pencarian', 'pengganti', $data->rekomendasi) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="shadow-sm p-3 mb-3 bg-body rounded">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-briefcase display-6 me-3"></i>
                            <div>
                                <h6 class="mb-0">Obrik Pemeriksaan :</h6>
                                <p class="mb-0">{{ $data->obrik_pemeriksaan }}</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <a href="{{ route('data.index') }}" class="btn btn-primary mt-3">Kembali</a>
        </div>
    </section>
</main>
@endsection
