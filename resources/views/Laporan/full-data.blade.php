@extends('template.header-footer')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Temuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Temuan</li>
                    <li class="breadcrumb-item active">Keseluruhan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Keseluruhan</h5>
                    {{-- <a href="{{ route('sktjm.create') }}" class="btn btn-primary mb-3">Tambah Data SKTJM</a> --}}

                    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            var table = $('#data-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: '{{ route('data.alldata') }}',
                                    data: function(d) {
                                        d.opd_id = $('#opd_id').val();
                                        d.status_id = $('#status_id').val();
                                        d.no_lhp = $('#no_lhp').val();
                                        d.start_date = $('#start_date').val();
                                        d.end_date = $('#end_date').val();
                                    }
                                },
                                columns: [{
                                        data: 'no_lhp',
                                        name: 'no_lhp',
                                        render: function(data, type, row) {
                                            return '<a class="a-none" href="/data/' + row.id + '">' + data + '</a>';
                                        }
                                    },
                                    {
                                        data: 'dinas_name',
                                        name: 'dinas_name'
                                    },
                                    {
                                        data: 'opd_name',
                                        name: 'opd_name'
                                    },
                                    {
                                        data: 'status',
                                        name: 'status',
                                        render: function(data, type, row) {
                                            let badgeClass = 'badge bg-secondary';
                                            if (data.toLowerCase() === 'selesai') {
                                                badgeClass = 'badge bg-success';
                                            } else if (data.toLowerCase() === 'dalam proses') {
                                                badgeClass = 'badge bg-warning';
                                            }
                                            return '<span class="' + badgeClass + '">' + data + '</span>';
                                        }
                                    },
                                    {
                                        data: 'tgl_lhp',
                                        name: 'tgl_lhp'
                                    },
                                    {
                                        data: 'obrik_pemeriksaan',
                                        name: 'obrik_pemeriksaan'
                                    },
                                    {
                                        data: 'temuan',
                                        name: 'temuan'
                                    },
                                    {
                                        data: 'rekomendasi',
                                        name: 'rekomendasi'
                                    },
                                    {
                                        data: 'nilai_rekomendasi',
                                        name: 'nilai_rekomendasi',
                                        render: function(data, type, row) {
                                            return 'Rp ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        }
                                    },
                                    {
                                        data: 'nilai_telah_dibayar',
                                        name: 'nilai_telah_dibayar',
                                        render: function(data, type, row) {
                                            return 'Rp ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        }
                                    },
                                    {
                                        data: 'sisa_nilai_uang',
                                        name: 'sisa_nilai_uang',
                                        render: function(data, type, row) {
                                            return 'Rp ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                        }
                                    }
                                ],
                                dom: 'Bfrtip',
                                buttons: [{
                                        extend: 'csv',
                                        text: '<i class="fas fa-file-csv"></i> CSV',
                                        className: 'btn btn-success',
                                        action: function(e, dt, button, config) {
                                            var params = $.param(table.ajax.params());
                                            window.location = '{{ route('data.exportCSV') }}?' + params;
                                        }
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<i class="fas fa-file-excel"></i> Excel',
                                        className: 'btn btn-success',
                                        action: function(e, dt, button, config) {
                                            var params = $.param(table.ajax.params());
                                            window.location = '{{ route('data.exportExcel') }}?' + params;
                                        }
                                    },
                                    {
                                        extend: 'pdf',
                                        text: '<i class="fas fa-file-pdf"></i> PDF',
                                        className: 'btn btn-danger',
                                        action: function(e, dt, button, config) {
                                            var params = $.param(table.ajax.params());
                                            window.location = '{{ route('data.exportPDF') }}?' + params;
                                        }
                                    }

                                ],
                                lengthMenu: [10, 25, 50, 75, 100], // menentukan pilihan jumlah entri per halaman
                                pageLength: 10, // jumlah entri per halaman default
                                drawCallback: function(settings) {
                                    console.log(
                                        'DataTables has been redrawn'
                                    ); // Tambahkan ini untuk memastikan drawCallback dipanggil
                                    var api = this.api();
                                    var totalNilaiRekomendasi = api.column(8).data().reduce(function(a, b) {
                                        return a + parseFloat(b.replace(/Rp|,/g, ''));
                                    }, 0);
                                    var totalNilaiTelahDibayar = api.column(9).data().reduce(function(a, b) {
                                        return a + parseFloat(b.replace(/Rp|,/g, ''));
                                    }, 0);
                                    var totalSisaNilaiUang = api.column(10).data().reduce(function(a, b) {
                                        return a + parseFloat(b.replace(/Rp|,/g, ''));
                                    }, 0);

                                    $('#total-nilai-rekomendasi').text('Rp ' + totalNilaiRekomendasi.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, "."));
                                    $('#total-nilai-telah-dibayar').text('Rp ' + totalNilaiTelahDibayar.toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                    $('#total-sisa-nilai-uang').text('Rp ' + totalSisaNilaiUang.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, "."));
                                }
                            });

                            $('#status_id, #no_lhp, #start_date, #end_date, #opd_id').on('change keyup', function() {
                                table.draw();
                            });
                        });
                    </script>

                    <div class="container">
                        <div class="card" style="padding: 10px; background: #c6dff6">
                            <!-- Filter Form -->
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="status_id">Filter Status:</label>
                                        <select id="status_id" class="form-control">
                                            <option value="">All</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="no_lhp">Filter No LHP:</label>
                                        <input type="text" id="no_lhp" class="form-control"
                                            placeholder="Search No LHP">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="opd_id">Filter OPD:</label>
                                            <select id="opd_id" class="form-control">
                                                <option value="">All</option>
                                                @foreach ($opds as $opd)
                                                    <option value="{{ $opd->id }}">{{ $opd->opd_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="start_date">Filter Tanggal LHP Mulai:</label>
                                        <input type="date" id="start_date" class="form-control" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="end_date">Filter Tanggal LHP Selesai:</label>
                                        <input type="date" id="end_date" class="form-control" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="data-table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No LHP</th>
                                    <th>Sumber Informasi</th>
                                    <th>Nama OPD</th>
                                    <th>Status</th>
                                    <th>Tgl LHP</th>
                                    <th>Obrik Pemeriksaan</th>
                                    <th>Temuan</th>
                                    <th>Rekomendasi</th>
                                    <th>Jumlah Kerugian</th>
                                    <th>Telah Dibayar</th>
                                    <th>Sisa Kerugian</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="8" style="text-align: right;">Total:</th>
                                    <th id="total-nilai-rekomendasi">{{ $totalNilaiRekomendasi ?? '0' }}</th>
                                    <th id="total-nilai-telah-dibayar">{{ $totalNilaiTelahDibayar ?? '0' }}</th>
                                    <th id="total-sisa-nilai-uang">{{ $totalSisaNilaiUang ?? '0' }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
