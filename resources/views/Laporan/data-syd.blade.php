@extends('template.header-footer')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Surat Dipersamakan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Surat Dipersamakan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Surat Dipersamakan</h5>
                    <a href="{{ route('surat-dipersamakan.create') }}" class="btn btn-success mb-3">Tambah Data </a>
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
                    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
                    <script>
                        $(document).ready(function() {
                            var table = $('#data-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: '{{ route('surat-dipersamakan.index') }}',
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
                                    // {
                                    //     data: 'obrik_pemeriksaan',
                                    //     name: 'obrik_pemeriksaan'
                                    // },
                                    {
                                        data: 'temuan',
                                        name: 'temuan',
                                        render: function(data, type, row) {
                                            if (data.length > 70) {
                                                return '<span class="short-text" data-full-text="' + data + '">' +
                                                    data.substring(0, 70) + '...</span>';
                                            }
                                            return data;
                                        }
                                    },
                                    {
                                        data: 'rekomendasi',
                                        name: 'rekomendasi',
                                        render: function(data, type, row) {
                                            if (data.length > 100) {
                                                return '<span class="short-text" data-full-text="' + data + '">' +
                                                    data.substring(0, 100) + '...</span>';
                                            }
                                            return data;
                                        }
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
                                    },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        orderable: false,
                                        searchable: false,
                                        render: function(data, type, row) {
                                            var editButton = '<a href="/sktjm/' + row.id +
                                                '/edit" class="btn btn-sm btn-light mr-1" title="Edit"><i class="bi bi-pencil-square"></i></a>';

                                            var deleteForm = '<form action="/sktjm/' + row.id +
                                                '" method="post" style="display:inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-light" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="bi bi-trash3"></i></button></form>';

                                            var pembayaranCreateUrl = '{{ route('pembayaran.create', ':id') }}'
                                                .replace(':id', row.id);
                                            var pembayaranCreateButton = '<a href="' + pembayaranCreateUrl +
                                                '" class="btn btn-sm btn-light mr-1" title="Create Pembayaran"><i class="bi bi-currency-dollar"></i></a>';

                                            var pembayaranIndexUrl = '{{ route('pembayaran.index', ':id') }}'
                                                .replace(':id', row.id);
                                            var pembayaranIndexButton = '<a href="' + pembayaranIndexUrl +
                                                '" class="btn btn-sm btn-light" title="View Pembayaran"><i class="bi bi-hourglass-split"></i></a>';

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
                                        className: 'btn btn-danger',
                                        orientation: 'landscape', // Set landscape orientation
                                        exportOptions: {
                                            columns: ':not(:last-child)' // Exclude the last column (action)
                                        },
                                        customize: function(doc) {
                                            doc.pageMargins = [20, 20, 20, 20]; // Set custom margins
                                            doc.defaultStyle.fontSize = 8; // Set default font size
                                            doc.styles.tableHeader.fontSize = 10; // Set table header font size
                                        }
                                    },
                                    {
                                        extend: 'print',
                                        text: '<i class="fas fa-print"></i> Print',
                                        className: 'btn btn-primary'
                                    }
                                ]
                            });

                            $('#status_id, #no_lhp, #start_date, #end_date, #opd_id').on('change keyup', function() {
                                table.draw();
                            });
                            $('#data-table tbody').on('click', 'span.short-text', function() {
                                var $this = $(this);
                                var fullText = $this.data('full-text');
                                var isExpanded = $this.hasClass('expanded');

                                if (isExpanded) {
                                    if ($this.closest('td').data('col') === 'temuan') {
                                        $this.html(fullText.substring(0, 70) + '...');
                                    } else {
                                        $this.html(fullText.substring(0, 100) + '...');
                                    }
                                    $this.removeClass('expanded');
                                } else {
                                    $this.html(fullText);
                                    $this.addClass('expanded');
                                }
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
                                    {{-- <th>Obrik Pemeriksaan</th> --}}
                                    <th>Temuan</th>
                                    <th>Rekomendasi</th>
                                    <th>Jumlah Kerugian</th>
                                    <th>Telah Dibayar</th>
                                    <th>Sisa Kerugian</th>
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