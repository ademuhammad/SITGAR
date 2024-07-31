{{-- resources/views/crud/edit-temuan.blade.php --}}

@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h1>Edit SKTJM</h1>

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

                <form action="{{ route('sktjm.update', $temuan->id) }}" method="POST" enctype="multipart/form-data" id="editTemuanForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_lhp">No LHP</label>
                                <input type="text" class="form-control" id="no_lhp" name="no_lhp" value="{{ $temuan->no_lhp }}">
                            </div>

                            <div class="form-group">
                                <label for="tgl_lhp">Tanggal LHP</label>
                                <input type="date" class="form-control" id="tgl_lhp" name="tgl_lhp" value="{{ $temuan->tgl_lhp }}">
                            </div>

                            <div class="form-group">
                                <label for="opd_id">OPD</label>
                                <select class="form-control" id="opd_id" name="opd_id">
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $temuan->opd_id == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->opd_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pegawai_id">PPK</label>
                                <select class="form-control" id="pegawai_id" name="pegawai_id">
                                    @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ $temuan->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select class="form-control" id="status_id" name="status_id">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $temuan->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="temuan">Temuan</label>
                                <textarea class="form-control" id="temuan" name="temuan">{{ $temuan->temuan }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="penyedia_id">Penyedia</label>
                                <select class="form-control" id="penyedia_id" name="penyedia_id">
                                    @foreach ($penyedias as $penyedia)
                                        <option value="{{ $penyedia->id }}" {{ $temuan->penyedia_id == $penyedia->id ? 'selected' : '' }}>
                                            {{ $penyedia->penyedia_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nilai_rekomendasi">Nilai Rekomendasi</label>
                                <input type="text" class="form-control" id="nilai_rekomendasi" name="nilai_rekomendasi" value="{{ $temuan->nilai_rekomendasi }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_sktjm">No SKTJM</label>
                                <input type="text" class="form-control" id="no_sktjm" name="no_sktjm" value="{{ $temuan->no_sktjm }}">
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
                                <label for="informasis_id">Informasi</label>
                                <select class="form-control" id="informasis_id" name="informasis_id">
                                    @foreach ($informasis as $informasi)
                                        <option value="{{ $informasi->id }}" {{ $temuan->informasis_id == $informasi->id ? 'selected' : '' }}>
                                            {{ $informasi->informations_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                                <input type="text" class="form-control" id="obrik_pemeriksaan" name="obrik_pemeriksaan" value="{{ $temuan->obrik_pemeriksaan }}">
                            </div>

                            <div class="form-group">
                                <label for="rekomendasi">Rekomendasi</label>
                                <textarea class="form-control" id="rekomendasi" name="rekomendasi">{{ $temuan->rekomendasi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="jenistemuan_id">Jenis Jaminan</label>
                                <select class="form-control" id="jenistemuan_id" name="jenistemuan_id">
                                    @foreach ($jenisTemuans as $jenisTemuan)
                                        <option value="{{ $jenisTemuan->id }}" {{ $temuan->jenistemuan_id == $jenisTemuan->id ? 'selected' : '' }}>
                                            {{ $jenisTemuan->jenis_temuan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group">
                                <label for="jumlah_jaminan">Jumlah Jaminan</label>
                                <input type="text" class="form-control" id="jumlah_jaminan" name="jumlah_jaminan" value="{{ $temuan->jumlah_jaminan }}">
                            </div>

                            <div class="form-group">
                                <label for="bukti_surat">Bukti Surat (PDF)</label>
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

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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
                        pegawaiDropdown.append($('<option></option>').attr('value', value.id).text(value.name));
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
                        pegawaiDropdown.append($('<option></option>').attr('value', value.id).text(value.name));
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }


    });
</script>
@endsection
