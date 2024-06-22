{{-- resources/views/crud/edit-temuan.blade.php --}}

@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h1>Edit Temuan</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('temuan.update', $temuan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="informasis_id">Informasi</label>
                        <select class="form-control" id="informasis_id" name="informasis_id">
                            @foreach ($informasis as $informasi)
                                <option value="{{ $informasi->id }}" {{ $temuan->informasis_id == $informasi->id ? 'selected' : '' }}>
                                    {{ $informasi->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opd_id">OPD</label>
                        <select class="form-control" id="opd_id" name="opd_id">
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->id }}" {{ $temuan->opd_id == $opd->id ? 'selected' : '' }}>
                                    {{ $opd->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_id">Status</label>
                        <select class="form-control" id="status_id" name="status_id">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" {{ $temuan->status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="statustgr_id">Status TGR</label>
                        <select class="form-control" id="statustgr_id" name="statustgr_id">
                            @foreach ($statustgrs as $statustgr)
                                <option value="{{ $statustgr->id }}" {{ $temuan->statustgr_id == $statustgr->id ? 'selected' : '' }}>
                                    {{ $statustgr->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pegwai_id">Pegawai</label>
                        <select class="form-control" id="pegwai_id" name="pegwai_id">
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ $temuan->pegwai_id == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penyedia_id">Penyedia</label>
                        <select class="form-control" id="penyedia_id" name="penyedia_id">
                            @foreach ($penyedias as $penyedia)
                                <option value="{{ $penyedia->id }}" {{ $temuan->penyedia_id == $penyedia->id ? 'selected' : '' }}>
                                    {{ $penyedia->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_lhp">No LHP</label>
                        <input type="text" class="form-control" id="no_lhp" name="no_lhp" value="{{ $temuan->no_lhp }}">
                    </div>

                    <div class="form-group">
                        <label for="tgl_lhp">Tanggal LHP</label>
                        <input type="date" class="form-control" id="tgl_lhp" name="tgl_lhp" value="{{ $temuan->tgl_lhp }}">
                    </div>

                    <div class="form-group">
                        <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                        <input type="text" class="form-control" id="obrik_pemeriksaan" name="obrik_pemeriksaan" value="{{ $temuan->obrik_pemeriksaan }}">
                    </div>

                    <div class="form-group">
                        <label for="temuan">Temuan</label>
                        <textarea class="form-control" id="temuan" name="temuan">{{ $temuan->temuan }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="rekomendasi">Rekomendasi</label>
                        <textarea class="form-control" id="rekomendasi" name="rekomendasi">{{ $temuan->rekomendasi }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="nilai_rekomendasi">Nilai Rekomendasi</label>
                        <input type="text" class="form-control" id="nilai_rekomendasi" name="nilai_rekomendasi" value="{{ $temuan->nilai_rekomendasi }}">
                    </div>

                    <div class="form-group">
                        <label for="bukti_surat">Bukti Surat (PDF)</label>
                        <input type="file" class="form-control-file" id="bukti_surat" name="bukti_surat">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
