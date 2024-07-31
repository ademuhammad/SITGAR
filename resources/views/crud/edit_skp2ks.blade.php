{{-- resources/views/crud/edit-temuan.blade.php --}}

@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h1>Edit SKP2KsS</h1>

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

                    <form action="{{ route('skp2ks.update', $temuan->id) }}" method="POST" enctype="multipart/form-data"
                        id="editTemuanForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_lhp">No LHP</label>
                                    <input type="text" class="form-control" id="no_lhp" name="no_lhp"
                                           value="{{ old('no_lhp', $temuan->no_lhp) }}">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_lhp">Tanggal LHP</label>
                                    <input type="date" class="form-control" id="tgl_lhp" name="tgl_lhp"
                                           value="{{ old('tgl_lhp', $temuan->tgl_lhp) }}">
                                </div>
                                <div class="form-group">
                                    <label for="informasis_id">Informasi</label>
                                    <select class="form-control" id="informasis_id" name="informasis_id">
                                        @foreach ($informasis as $informasi)
                                            <option value="{{ $informasi->id }}"
                                                    {{ old('informasis_id', $temuan->informasis_id) == $informasi->id ? 'selected' : '' }}>
                                                {{ $informasi->dinas_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="opd_id">OPD</label>
                                    <select class="form-control" id="opd_id" name="opd_id">
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}"
                                                    {{ old('opd_id', $temuan->opd_id) == $opd->id ? 'selected' : '' }}>
                                                {{ $opd->opd_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pegawai_id">Nama PPK</label>
                                    <select class="form-control" id="pegawai_id" name="pegawai_id">
                                        @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}"
                                                    {{ old('pegawai_id', $temuan->pegawai_id) == $pegawai->id ? 'selected' : '' }}>
                                                {{ $pegawai->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status_id">Status</label>
                                    <select class="form-control" id="status_id" name="status_id">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                    {{ old('status_id', $temuan->status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="penyedia_id">Penyedia</label>
                                    <select class="form-control" id="penyedia_id" name="penyedia_id">
                                        @foreach ($penyedias as $penyedia)
                                            <option value="{{ $penyedia->id }}"
                                                    {{ old('penyedia_id', $temuan->penyedia_id) == $penyedia->id ? 'selected' : '' }}>
                                                {{ $penyedia->penyedia_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nilai_rekomendasi_display">Nilai Rekomendasi</label>
                                    <input type="text" class="form-control" id="nilai_rekomendasi_display"
                                           oninput="formatRupiah(this)" value="{{ old('nilai_rekomendasi', number_format($temuan->nilai_rekomendasi, 0, ',', '.')) }}">
                                    <input type="hidden" id="nilai_rekomendasi" name="nilai_rekomendasi"
                                           value="{{ old('nilai_rekomendasi', $temuan->nilai_rekomendasi) }}">
                                </div>
                                <div class="form-group">
                                    <label for="jenistemuan_id">Jenis Jaminan</label>
                                    <select class="form-control" id="jenistemuan_id" name="jenistemuan_id">
                                        @foreach ($jenisTemuans as $jenisTemuan)
                                            <option value="{{ $jenisTemuan->id }}"
                                                    {{ old('jenistemuan_id', $temuan->jenistemuan_id) == $jenisTemuan->id ? 'selected' : '' }}>
                                                {{ $jenisTemuan->jenis_temuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_jaminan">Jumlah Jaminan</label>
                                    <input type="text" class="form-control" id="jumlah_jaminan" name="jumlah_jaminan"
                                           value="{{ old('jumlah_jaminan', $temuan->jumlah_jaminan) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                             <div class="form-group">
                                    <label for="no_sktjm">No skp2k</label>
                                    <input type="text" class="form-control" id="no_skp2k" name="no_skp2k" value="{{ $temuan->no_skp2k }}">
                                </div>
                                <div class="form-group">
                                    <label for="statustgr_id">Status TGR</label>
                                    <select class="form-control" id="statustgr_id" name="statustgr_id">
                                        @foreach ($statustgrs as $statustgr)
                                            <option value="{{ $statustgr->id }}" {{ $temuan->statustgr_id == $statustgr->id ? 'selected' : '' }}>
                                                {{ $statustgr->tgr_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="temuan">Temuan</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="temuan" name="temuan">{{ old('temuan', $temuan->temuan) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="obrik_pemeriksaan" name="obrik_pemeriksaan">{{ old('obrik_pemeriksaan', $temuan->obrik_pemeriksaan) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rekomendasi">Rekomendasi</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="rekomendasi" name="rekomendasi">{{ old('rekomendasi', $temuan->rekomendasi) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="bukti_surat">Bukti Surat Lunas</label>
                                    <input type="file" class="form-control-file" id="bukti_surat" name="bukti_surat">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#opd_id').on('change', function() {
                var opdId = $(this).val();
                $.ajax({
                    url: '{{ route('pegawai.byopd') }}',
                    type: 'GET',
                    data: {
                        opd_id: opdId
                    },
                    success: function(response) {
                        var pegawaiDropdown = $('#pegawai_id');
                        pegawaiDropdown.empty();
                        $.each(response, function(key, value) {
                            pegawaiDropdown.append($('<option></option>').attr('value',
                                value.id).text(value.name));
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Initialize the pegawai dropdown based on the initial opd_id value
            var initialOpdId = $('#opd_id').val();
            if (initialOpdId) {
                $.ajax({
                    url: '{{ route('pegawai.byopd') }}',
                    type: 'GET',
                    data: {
                        opd_id: initialOpdId
                    },
                    success: function(response) {
                        var pegawaiDropdown = $('#pegawai_id');
                        pegawaiDropdown.empty();
                        $.each(response, function(key, value) {
                            pegawaiDropdown.append($('<option></option>').attr('value', value
                                .id).text(value.name));
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }


        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pegawai_id').select2({
                placeholder: "Pilih PPK",
                allowClear: true
            });
            $('#opd_id').select2({
                placeholder: "Pilih OPD",
                allowClear: true
            });

            $('#penyedia_id').select2({
                placeholder: "Pilih Penyedia",
                allowClear: true
            });


            $('#sktjmForm').on('submit', function(e) {
                const statusId = $('#status_id').val();
                const statusSelesaiId = 1; // Gantilah 1 dengan id status "selesai" yang sesuai
                const buktiSurat = $('#bukti_surat').val();

                if (statusId == statusSelesaiId && !buktiSurat) {
                    e.preventDefault();
                    alert('Bukti Surat Lunas wajib diunggah jika status adalah "selesai"');
                }
            });
        });
    </script>
@endsection
