@extends('template.header-footer')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Selesai</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITEGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Selesai</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Selesai</h5>
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
                            var table = $('#data-table2').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: '{{ route('temuans.selesai') }}',
                                    data: function(d) {
                                        d.status_id = $('#status_id').val();
                                        d.no_lhp = $('#no_lhp').val();
                                        d.start_date = $('#start_date').val();
                                        d.end_date = $('#end_date').val();
                                        d.opd_id = $('#opd_id').val(); // Added this line
                                    }
                                },
                                columns: [{
                                        data: 'no_lhp',
                                        name: 'no_lhp',
                                        render: function(data, type, row) {
                                            return '<a class="a-none" href="/data/' + row.id + '">' + data +
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
                                    // {
                                    //     data: 'status',
                                    //     name: 'status'
                                    // },

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
                                    // {
                                    //     data: 'rekomendasi',
                                    //     name: 'rekomendasi'
                                    // },
                                    // {
                                    //     data: 'nilai_rekomendasi',
                                    //     name: 'nilai_rekomendasi',
                                    //     render: function(data, type, row) {
                                    //         return formatRupiah(data, 'Rp. ');
                                    //     }
                                    // },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        orderable: false,
                                        searchable: false,
                                        render: function(data, type, row) {
                                            var editButton = '<a href="/data/' + row.id +
                                                '/edit" class="btn btn-sm btn-light mr-1" title="Edit"><i class="bi bi-pencil-square"></i></a>';

                                            var deleteForm = '<form action="/data/' + row.id +
                                                '" method="post" style="display:inline">';
                                            deleteForm += '@csrf';
                                            deleteForm += '@method('DELETE')';
                                            deleteForm +=
                                                '<button type="submit" class="btn btn-sm btn-light" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="bi bi-trash3"></i></button>';
                                            deleteForm += '</form>';
                                            var pembayaranCreateButton = '<a href="' +
                                                '{{ route('pembayaran.create', ':id') }}'.replace(':id', row.id) +
                                                '" class="btn btn-sm btn-light"><i class="bi bi-currency-dollar"></i></a>';
                                            var pembayaranIndexButton = '<a href="' +
                                                '{{ route('pembayaran.index', ':id') }}'.replace(':id', row.id) +
                                                '" class="btn btn-sm btn-light"><i class="bi bi-hourglass-split"></i></a>';


                                            return '<div class="d-flex" style="padding:5px">' + editButton +
                                                deleteForm + pembayaranCreateButton + pembayaranIndexButton +
                                                '</div>';
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

                            $('#opd_id, #no_lhp, #start_date, #end_date').on('change keyup', function() {
                                table.draw();
                            });
                        });
                    </script>
                    <div class="container">
                        <div class="card" style="padding: 10px; background: #739c7e">
                            <div class="row">
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

                        <table id="data-table2" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No LHP</th>
                                    <th>Sumber Informasi</th>
                                    <th>Nama OPD</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Tgl LHP</th>
                                    <th>Obrik Pemeriksaan</th>
                                    <th>Temuan</th>
                                    {{-- <th>Rekomendasi</th> --}}
                                    {{-- <th>Nilai Rekomendasi</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
