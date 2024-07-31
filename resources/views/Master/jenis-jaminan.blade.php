@extends('template.header-footer')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data OPD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">OPD</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data OPD</h5>
                        <a href="{{ route('jenistemuan.create') }}">
                            <button type="button" class="btn btn-success mb-2"><i class="bi bi-person-plus-fill"></i> Tambah Jenis Jaminan</button></a>
                        <!-- Table with stripped rows -->
                        <table id="opdTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Jamainan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisjaminan as $jaminan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jaminan->jenis_temuan }}</td>
                                        <td>{{ $jaminan->deskripsi }}</td>
                                        <td>
                                            <a href="{{ route('jenistemuan.edit', $jaminan->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('jenistemuan.destroy', $jaminan->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

<!-- Custom CSS to color each column -->


<!-- Initialize DataTables with print button -->

<!-- Initialize DataTables with print and export buttons, excluding the Aksi column -->
<script>
$(document).ready(function() {
    $('#opdTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});
</script>
@endsection
