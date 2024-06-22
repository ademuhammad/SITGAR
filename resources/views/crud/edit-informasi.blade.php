@extends('template.header-footer')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit informasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}">informasi</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Informasi</h5>

                <!-- Horizontal Form -->
                <form method="POST" action="{{ route('informasi.update', $informasi->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="dinas_name" class="col-sm-2 col-form-label">Nama Dinas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dinas_name" name="dinas_name" value="{{ $informasi->dinas_name }}" required>
                            @if ($errors->has('dinas_name'))
                                <span class="text-danger">{{ $errors->first('dinas_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="informations_name" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="informations_name" name="informations_name">{{ $informasi->informations_name }}</textarea>
                            @if ($errors->has('informations_name'))
                                <span class="text-danger">{{ $errors->first('informations_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Horizontal Form -->

            </div>
        </div>
    </main>
@endsection
