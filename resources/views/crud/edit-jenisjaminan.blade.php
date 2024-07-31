@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit OPD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('opds.index') }}">OPDs</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit OPD</h5>

            <!-- Horizontal Form -->
            <form method="POST" action="{{ route('jenistemuan.update', $jenistemuan->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="jenis_temuan" class="col-sm-2 col-form-label">Jenis Jaminan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jenis_temuan" name="jenis_temuan" value="{{ $jenistemuan->jenis_temuan }}" required>
                        @if ($errors->has('jenis_temuan'))
                            <span class="text-danger">{{ $errors->first('jenis_temuan') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $jenistemuan->deskripsi }}</textarea>
                        @if ($errors->has('deskripsi'))
                            <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
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
