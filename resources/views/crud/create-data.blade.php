@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h1>Create New Temuan</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('data.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="informasis_id">Informasi</label>
                            <select class="form-control" id="informasis_id" name="informasis_id">
                                @foreach ($informasis as $informasi)
                                    <option value="{{ $informasi->id }}"
                                        {{ old('informasis_id') == $informasi->id ? 'selected' : '' }}>
                                        {{ $informasi->dinas_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="opd_id">OPD</label>
                            <select class="form-control" id="opd_id" name="opd_id">
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                        {{ $opd->opd_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select class="form-control" id="status_id" name="status_id">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pegawai_id">Pegawai</label>
                            <select class="form-control" id="pegawai_id" name="pegawai_id">
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}"
                                        {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="penyedia_id">Penyedia</label>
                            <select class="form-control" id="penyedia_id" name="penyedia_id">
                                @foreach ($penyedias as $penyedia)
                                    <option value="{{ $penyedia->id }}"
                                        {{ old('penyedia_id') == $penyedia->id ? 'selected' : '' }}>
                                        {{ $penyedia->penyedia_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_lhp">No LHP</label>
                            <input type="text" class="form-control" id="no_lhp" name="no_lhp"
                                value="{{ old('no_lhp') }}">
                        </div>
                        <div class="form-group">
                            <label for="tgl_lhp">Tanggal LHP</label>
                            <input type="date" class="form-control" id="tgl_lhp" name="tgl_lhp"
                                value="{{ old('tgl_lhp') }}">
                        </div>
                        <div class="form-group">
                            <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                            <input type="text" class="form-control" id="obrik_pemeriksaan" name="obrik_pemeriksaan"
                                value="{{ old('obrik_pemeriksaan') }}">
                        </div>
                        <div class="form-group">
                            <label for="temuan">Temuan</label>
                            <textarea class="form-control" id="temuan" name="temuan">{{ old('temuan') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="rekomendasi">Rekomendasi</label>
                            <textarea class="form-control" id="rekomendasi" name="rekomendasi">{{ old('rekomendasi') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="nilai_rekomendasi">Nilai Rekomendasi</label>
                            <input type="text" class="form-control" id="nilai_rekomendasi" name="nilai_rekomendasi"
                                value="{{ old('nilai_rekomendasi') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
