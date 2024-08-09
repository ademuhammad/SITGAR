@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h3>Tambah Temuan</h3>

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
                                    <label for="penyedia_id">Penyedia</label>
                                    <select class="form-control" id="penyedia_id" name="penyedia_id"
                                        onchange="showNewPenyediaForm()">
                                        <option value="new">Buat Penyedia Baru</option>
                                        @foreach ($penyedias as $penyedia)
                                            <option value="{{ $penyedia->id }}"
                                                {{ old('penyedia_id') == $penyedia->id ? 'selected' : '' }}>
                                                {{ $penyedia->penyedia_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="newPenyediaForm" style="display: none;">
                                    <div class="mb-3">
                                        <label for="penyedia_name" class="form-label">Nama Penyedia</label>
                                        <input type="text" class="form-control" id="penyedia_name" name="penyedia_name">
                                    </div>
                                    <button type="button" class="btn btn-primary"
                                        onclick="submitNewPenyedia()">Simpan</button>
                                </div>

                                <input type="hidden" id="new_penyedia_id" name="new_penyedia_id" value="">

                                <div class="form-group">
                                    <label for="statustgr_id">Status TGR</label>
                                    <select class="form-control" id="statustgr_id" name="statustgr_id">
                                        <option value="">Belum Ada Status</option>
                                        @foreach ($statustgrs as $statustgr)
                                            <option value="{{ $statustgr->id }}"
                                                {{ old('statustgr_id') == $statustgr->id ? 'selected' : '' }}>
                                                {{ $statustgr->tgr_name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                    <label for="nilai_rekomendasi_display">Nilai Rekomendasi</label>
                                    <input type="text" class="form-control" id="nilai_rekomendasi_display" oninput="formatRupiah(this)" value="{{ old('nilai_rekomendasi_display') }}">
                                    <input type="hidden" id="nilai_rekomendasi" name="nilai_rekomendasi" value="{{ old('nilai_rekomendasi') }}">
                                </div>


                            </div>

                            <div class="col-md-6">



                                <div class="form-group">
                                    <label for="obrik_pemeriksaan">Objek Pemeriksaan</label>
                                    <textarea class="form-control" id="obrik_pemeriksaan" name="obrik_pemeriksaan" style="width: 100%; height: 150px;">{{ old('obrik_pemeriksaan') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="temuan">Temuan</label>
                                    <textarea class="form-control" id="temuan" name="temuan" style="width: 100%; height: 150px;">{{ old('temuan') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rekomendasi">Rekomendasi</label>
                                    <textarea class="form-control" id="rekomendasi" name="rekomendasi" style="width: 100%; height: 150px;">{{ old('rekomendasi') }}</textarea>
                                </div>


                                <div class="form-group">
                                    <label for="bukti_pembayaran">Bukti Pembayaran (Optional)</label>
                                    <input type="file" class="form-control" id="bukti_pembayaran"
                                        name="bukti_pembayaran">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah</button>
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
            function formatRupiah(input) {
                let value = input.value.replace(/\D/g, '');
                let formattedValue = new Intl.NumberFormat('id-ID').format(value / 100);
                input.value = formattedValue;

                let hiddenInput = document.getElementById('nilai_rekomendasi');
                let numericValue = formattedValue.replace(/\./g, '').replace(',', '.');
                hiddenInput.value = numericValue;
            }
        </script>
        <script>
            function showNewPenyediaForm() {
                var penyediaSelect = document.getElementById('penyedia_id');
                var newPenyediaForm = document.getElementById('newPenyediaForm');

                if (penyediaSelect.value === 'new') {
                    newPenyediaForm.style.display = 'block';
                } else {
                    newPenyediaForm.style.display = 'none';
                }
            }

            function submitNewPenyedia() {
                var penyediaName = document.getElementById('penyedia_name').value;
                var newPenyediaIdInput = document.getElementById('new_penyedia_id');

                $.ajax({
                    url: '{{ route('penyedia.store') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        penyedia_name: penyediaName
                    },
                    success: function(response) {
                        newPenyediaIdInput.value = response.id; // Set the new penyedia ID
                        alert('Penyedia created successfully!');
                        showNewPenyediaForm(); // Hide the form after successful creation
                    },
                    error: function(error) {
                        console.error(error);
                        alert('An error occurred while creating Penyedia.');
                    }
                });
            }
        </script>

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

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1].substr(0, 2) : rupiah; // Keep only two decimal places
                element.value = 'Rp ' + rupiah;

                // Update the hidden input with the correct numerical value
                document.getElementById('nilai_rekomendasi').value = value.replace(/\./g, '').replace(',', '.');
            }

            document.getElementById('nilai_rekomendasi_display').addEventListener('input', function() {
                formatRupiah(this);
            });


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
                $('#status_id').select2({
                    placeholder: "Pilih Status",
                    allowClear: true
                });
                $('#statustgr_id').select2({
                    placeholder: "Pilih Status TGR",
                    allowClear: true
                });
                $('#informasis_id').select2({
                    placeholder: "Pilih Informasi",
                    allowClear: true
                });
            });
        </script>
    @endsection
