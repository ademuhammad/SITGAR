@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Status</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('status.index') }}">Status</a></li>
                    <li class="breadcrumb-item active">Data Status</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Status</h5>

                            <!-- Button Tambah -->
                            <a href="{{ route('status.create') }}" class="btn btn-info mb-3"><i class="bi bi-person-plus-fill"></i> Tambah Status</a>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $status)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $status->status }}</td>
                                            <td>{{ $status->description }}</td>
                                            <td>
                                                <a href="{{ route('status.edit', $status->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('status.destroy', $status->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this status?')">Delete</button>
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
@endsection
