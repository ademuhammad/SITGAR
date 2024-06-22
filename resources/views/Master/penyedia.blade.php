@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Penyedia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Penyedia</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Penyedia</h5>
                            <a href="{{ route('penyedia.create') }}" class="btn btn-info mb-3"><i class="bi bi-person-plus-fill"></i> Tambah Penyedia</a>
                            <!-- Table with stripped rows -->
                            <table class="table datatable3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Penyedia</th>
                                        <th>Alamat Penyedia</th>
                                        <th>Izin Penyedia</th>
                                        <th>Informasi Lainnya</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $penyedia)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $penyedia->penyedia_name }}</td>
                                            <td>{{ $penyedia->penyedia_address }}</td>
                                            <td>{{ $penyedia->penyedia_izin }}</td>
                                            <td>{{ $penyedia->penyedia_information }}</td>
                                            <td>
                                                <a href="{{ route('penyedia.edit', $penyedia->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('penyedia.destroy', $penyedia->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this Penyedia?')">Delete</button>
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
