@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3>Edit Temuan</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('data.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_lhp">No LHP</label>
                                <input type="text" class="form-control" id="no_lhp" name="no_lhp" value="{{ $data->no_lhp }}">
                            </div>
                            <div class="form-group">
                                <label for="tgl_lhp">Tanggal LHP</label>
                                <input type="date" class="form-control" id="tgl_lhp" name="tgl_lhp" value="{{ $data->tgl_lhp }}">
                            </div>
                            <div class="form-group">
                                <label for="informasis_id">Informasi</label>
                                <select class="form-control" id="informasis_id" name="informasis_id">
                                    @foreach ($informasis as $informasi)
                                        <option value="{{ $informasi->id }}" {{ $data->informasis_id == $informasi->id ? 'selected' : '' }}>
                                            {{ $informasi->dinas_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="opd_id">OPD</label>
                                <select class="form-control" id="opd_id" name="opd_id">
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $data->opd_id == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->opd_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select class="form-control" id="status_id" name="status_id">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $data->status_id == $status->status ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pegawai_id">Nama PPK</label>
                                <select class="form-control" id="pegawai_id" name="pegawai_id">
                                    @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}" {{ $data->pegawai_id == $pegawai->id ? 'selected' : '' }}>
                                            {{ $pegawai->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penyedia_id">Penyedia</label>
                                <select class="form-control" id="penyedia_id" name="penyedia_id">
                                    @foreach ($penyedias as $penyedia)
                                        <option value="{{ $penyedia->id }}" {{ $data->penyedia_id == $penyedia->id ? 'selected' : '' }}>
                                            {{ $penyedia->penyedia_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statustgr_id">Status TGR</label>
                                <select class="form-control" id="statustgr_id" name="statustgr_id">
                                    <option value="" {{ is_null($data->statustgr_id) ? 'selected' : '' }}>Pilih Status TGR</option>
                                    @foreach ($statustgrs as $statustgr)
                                        <option value="{{ $statustgr->id }}" {{ $data->statustgr_id == $statustgr->id ? 'selected' : '' }}>
                                            {{ $statustgr->tgr_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenistemuan_id">Jenis Jaminan</label>
                                <select class="form-control" id="jenistemuan_id" name="jenistemuan_id">
                                    @foreach ($jenisTemuans as $jenisTemuan)
                                        <option value="{{ $jenisTemuan->id }}" {{ $data->jenistemuan_id == $jenisTemuan->id ? 'selected' : '' }}>
                                            {{ $jenisTemuan->jenis_temuan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nilai_rekomendasi_display">Nilai Rekomendasi</label>
                                <input type="text" class="form-control" id="nilai_rekomendasi_display" oninput="formatRupiah(this)" value="{{ number_format($data->nilai_rekomendasi, 0, ',', '.') }}">
                                <input type="hidden" id="nilai_rekomendasi" name="nilai_rekomendasi" value="{{ $data->nilai_rekomendasi }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                                <textarea class="form-control" id="obrik_pemeriksaan" name="obrik_pemeriksaan" style="width: 100%; height: 150px;">{{ $data->obrik_pemeriksaan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="temuan">Temuan</label>
                                <textarea class="form-control" id="temuan" name="temuan" style="width: 100%; height: 150px;">{{ $data->temuan }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="rekomendasi">Rekomendasi</label>
                                <textarea class="form-control" id="rekomendasi" name="rekomendasi" style="width: 100%; height: 150px;">{{ $data->rekomendasi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="bukti_pembayaran">Bukti Pembayaran (Optional)</label>
                                <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran">
                                @if($data->bukti_pembayaran)
                                    <a href="{{ Storage::url($data->bukti_pembayaran) }}" target="_blank">Lihat Bukti Pembayaran</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </section>
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function formatRupiah(element) {
            let value = element.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            element.value = 'Rp ' + rupiah;

            // Update the hidden input with the numerical value
            document.getElementById('nilai_rekomendasi').value = value.replace(/\./g, '');
        }

        $(document).ready(function() {
            $('#informasis_id, #opd_id, #status_id, #pegawai_id, #penyedia_id, #statustgr_id, #jenistemuan_id').select2();
        });
    </script>
</main>
@endsection
