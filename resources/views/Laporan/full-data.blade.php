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
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

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
                                        name: 'obrik_pemeriksaan',
                                        render: function(data, type, row) {
                                            if (data.length > 70) {
                                                return '<span class="short-text" data-full-text="' + data + '">' +
                                                    data.substring(0, 70) + '...</span>';
                                            }
                                            return data;
                                        }
                                    },
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
                                    }
                                ],
                                dom: '<"top"lfB>rt<"bottom"ip><"clear">',
                                buttons: [
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
                                        orientation: 'landscape',
                                        exportOptions: {
                                            columns: ':not(:last-child)'
                                        },
                                        customize: function(doc) {
                                            doc.pageMargins = [20, 20, 20, 20];
                                            doc.defaultStyle.fontSize = 8;
                                            doc.styles.tableHeader.fontSize = 10;
                                        }
                                    }
                                ],
                                lengthMenu: [
                                    [10, 25, 50, -1],
                                    ['10', '25', '50', 'Semua']
                                ],
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
                        {{-- <div class="card" style="padding: 10px; background: #c6dff6"> --}}
                        <!-- Filter Form -->
                        <div class="row pb-3">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status_id">Status:</label>
                                    <select id="status_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="no_lhp">No LHP:</label>
                                    <input type="text" id="no_lhp" class="form-control" placeholder="Search No LHP">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="opd_id">OPD:</label>
                                    <select id="opd_id" class="form-control">
                                        <option value="">All</option>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}">{{ $opd->opd_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Tanggal LHP Mulai:</label>
                                    <input type="date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">Tanggal LHP Selesai:</label>
                                    <input type="date" id="end_date" class="form-control">
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
    <style>
        .dataTables_wrapper .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .dataTables_length {
            order: 1;
            margin-right: auto;
        }

        .dt-buttons {
            order: 2;
            text-align: center;
            flex: 1 1 auto;
            display: flex;
            justify-content: center;
        }

        .dataTables_filter {
            order: 3;
            margin-left: auto;
        }

        .dataTables_length,
        .dataTables_filter {
            padding: 10px 0;
        }

        .dt-buttons .btn {
            margin: 5px;
        }
    </style>
@endsection
