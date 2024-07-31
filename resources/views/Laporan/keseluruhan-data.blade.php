<!DOCTYPE html>
<html>
<head>
    <title>Temuan Data</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h2>Temuan Data</h2>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>OPD</th>
                <th>Status</th>
                <th>Pegawai</th>
                <th>Penyedia</th>
                <th>No LHP</th>
                <th>No SKTJM</th>
                <th>No SKP2KS</th>
                <th>No SKP2K</th>
                <th>Tgl LHP</th>
                <th>Obrik Pemeriksaan</th>
                <th>Temuan</th>
                <th>Rekomendasi</th>
                <th>Nilai Rekomendasi</th>
                <th>Bukti Surat</th>
                <th>Nilai Telah Dibayar</th>
                <th>Sisa Nilai Uang</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('data.test') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'opd.opd_name', name: 'opd.opd_name' },
                { data: 'status.status', name: 'status.status' },
                { data: 'pegawai.name', name: 'pegawai.name' },
                { data: 'penyedia.penyedia_name', name: 'penyedia.penyedia_name' },
                { data: 'no_lhp', name: 'no_lhp' },
                { data: 'no_sktjm', name: 'no_sktjm' },
                { data: 'no_skp2ks', name: 'no_skp2ks' },
                { data: 'no_skp2k', name: 'no_skp2k' },
                { data: 'tgl_lhp', name: 'tgl_lhp' },
                { data: 'obrik_pemeriksaan', name: 'obrik_pemeriksaan' },
                { data: 'temuan', name: 'temuan' },
                { data: 'rekomendasi', name: 'rekomendasi' },
                { data: 'nilai_rekomendasi', name: 'nilai_rekomendasi' },
                { data: 'bukti_surat', name: 'bukti_surat' },
                { data: 'nilai_telah_dibayar', name: 'nilai_telah_dibayar' },
                { data: 'sisa_nilai_uang', name: 'sisa_nilai_uang' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            dom: '<"row mb-3" <"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 text-end"B>>' +
                 '<"row" <"col-sm-12"tr>>' +
                 '<"row" <"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                { extend: 'copy', className: 'btn btn-secondary btn-sm' },
                { extend: 'csv', className: 'btn btn-secondary btn-sm' },
                { extend: 'excel', className: 'btn btn-secondary btn-sm' },
                { extend: 'pdf', className: 'btn btn-secondary btn-sm' },
                { extend: 'print', className: 'btn btn-secondary btn-sm' }
            ],
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    });
</script>

</body>
</html>
