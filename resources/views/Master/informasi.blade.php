@extends('template.header-footer')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data informasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">informasi</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data informasi</h5>
                            <a href="{{ route('informasi.create') }}">
                                <button type="button" class="btn btn-info"><i class="bi bi-person-plus-fill"></i> Tambah informasi</button></a>
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sumber Informasi</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $informasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $informasi->dinas_name }}</td>
                                            <td>{{ $informasi->informations_name }}</td>
                                            <td>
                                                <a href="{{ route('informasi.edit', $informasi->id) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('informasi.destroy', $informasi->id) }}" method="POST" style="display:inline;">
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
@endsection
