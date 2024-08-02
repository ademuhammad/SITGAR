@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h3>Buat SKP2K</h3>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('skp2ks.store') }}" method="POST" enctype="multipart/form-data" id="sktjmForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
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
                                            <option value="{{ $opd->id }}"
                                                {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
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
                                                {{ old('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
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
                                                {{ old('status_id') == $status->id ? 'selected' : '' }}>
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
                                                {{ old('penyedia_id') == $penyedia->id ? 'selected' : '' }}>
                                                {{ $penyedia->penyedia_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nilai_rekomendasi_display">Nilai Rekomendasi</label>
                                    <input type="text" class="form-control" id="nilai_rekomendasi_display"
                                        oninput="formatRupiah(this)">
                                    <input type="hidden" id="nilai_rekomendasi" name="nilai_rekomendasi"
                                        value="{{ old('nilai_rekomendasi') }}">
                                </div>

                                <div class="form-group">
                                    <label for="jenistemuan_id">Jenis Jaminan</label>
                                    <select class="form-control" id="jenistemuan_id" name="jenistemuan_id">
                                        <option value="">Belum Ada Jenis Temuan</option>
                                        @foreach ($jenisTemuans as $jenisTemuan)
                                            <option value="{{ $jenisTemuan->id }}"
                                                {{ old('jenistemuan_id') == $jenisTemuan->id ? 'selected' : '' }}>
                                                {{ $jenisTemuan->jenis_temuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_jaminan">Jumlah Jaminan</label>
                                    <input type="text" class="form-control" id="jumlah_jaminan" name="jumlah_jaminan"
                                        value="{{ old('jumlah_jaminan') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_sktjm">No SKTJM</label>
                                    <input type="text" class="form-control" id="no_sktjm" name="no_sktjm"
                                        value="{{ old('no_sktjm') }}">
                                </div>

                                <div class="form-group">
                                    <label for="statustgr_id">Status TGR</label>
                                    <input type="hidden" id="statustgr_id" name="statustgr_id"
                                        value="{{ $defaultStatustgr->id }}">
                                    <input type="text" class="form-control" value="{{ $defaultStatustgr->tgr_name }}"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label for="temuan">Temuan</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="temuan" name="temuan">{{ old('temuan') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="obrik_pemeriksaan" name="obrik_pemeriksaan"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rekomendasi">Rekomendasi</label>
                                    <textarea class="form-control" style="width: 100%; height: 150px;" id="rekomendasi" name="rekomendasi"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="bukti_surat">Bukti Surat Lunas</label>
                                    <input type="file" class="form-control-file" id="bukti_surat" name="bukti_surat">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Tambah</button>
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
            document.getElementById('nilai_rekomendasi').value = value.replace(/[^,\d]/g, '');
        }
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
