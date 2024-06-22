@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Pegawai</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">SITGAR</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                    <li class="breadcrumb-item active">Edit Pegawai</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Pegawai</h5>
                            <!-- Form untuk edit pegawai -->
                            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="{{ $pegawai->nip }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $pegawai->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $pegawai->jabatan }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="golongan" class="form-label">Golongan</label>
                                    <input type="text" class="form-control" id="golongan" name="golongan" value="{{ $pegawai->golongan }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="opd_id" class="form-label">Asal OPD</label>
                                    <select class="form-control" id="opd_id" name="opd_id" required>
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}" {{ $pegawai->opd_id == $opd->id ? 'selected' : '' }}>{{ $opd->opd_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                            <!-- End Form untuk edit pegawai -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
