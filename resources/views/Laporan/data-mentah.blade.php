@extends('template.header-footer')

@section('content')
    <style>
        .th-width {
            width: 150px;
            text-align: center;
        }

        .th-width2 {
            width: 200px;
        }

        th,
        td {

            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        th {
            text-align: center;
            vertical-align: middle;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        #status_id,
        #no_lhp,
        #start_date,
        #end_date {
            max-width: 300px;
        }

        .dt-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
        }

        .dt-button:hover {
            background-color: #45a049;
        }

        .card-body {
            overflow-x: auto;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 5px;
            padding: 5px;
            margin-left: 0.5em;
        }
        a {
            text-decoration: none;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Temuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Temuan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Temuan</h5>
                    <a href="{{ route('data.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
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
                        function formatRupiah(angka, prefix) {
                            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                                split = number_string.split(','),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }

                            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                        }

                        $(document).ready(function() {
                            var table = $('#data-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: '{{ route('data.index') }}',
                                    data: function(d) {
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
                                            return '<a href="/data/' + encodeURIComponent(data) + '">' + data +
                                                '</a>';
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
                                        name: 'status'
                                    },
                                    {
                                        data: 'pegawai_name',
                                        name: 'pegawai_name'
                                    },
                                    {
                                        data: 'penyedia_name',
                                        name: 'penyedia_name'
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
                                            return formatRupiah(data, 'Rp. ');
                                        }
                                    }
                                ],
                                dom: 'Bfrtip',
                                buttons: [{
                                        extend: 'csv',
                                        text: '<i class="fas fa-file-csv"></i> CSV',
                                        className: 'btn btn-success'
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<i class="fas fa-file-excel"></i> Excel',
                                        className: 'btn btn-success'
                                    },
                                    {
                                        extend: 'pdf',
                                        text: '<i class="fas fa-file-pdf"></i> PDF',
                                        className: 'btn btn-danger'
                                    },
                                    {
                                        extend: 'print',
                                        text: '<i class="fas fa-print"></i> Print',
                                        className: 'btn btn-primary'
                                    }
                                ]
                            });

                            $('#status_id, #no_lhp, #start_date, #end_date').on('change keyup', function() {
                                table.draw();
                            });
                        });
                    </script>

                    <div class="container">
                        <div class="card" style="padding: 10px; background: #c6dff6">
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
                                    <th>Nama Pegawai</th>
                                    <th>Nama Penyedia</th>
                                    <th>Tgl LHP</th>
                                    <th>Obrik Pemeriksaan</th>
                                    <th>Temuan</th>
                                    <th>Rekomendasi</th>
                                    <th>Nilai Rekomendasi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
