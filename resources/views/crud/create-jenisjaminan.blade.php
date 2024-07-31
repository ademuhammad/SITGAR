@extends('template.header-footer')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create OPD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jenistemuan.index') }}">Jenis Jaminan</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Buat Jenis Jaminan</h5>

            <!-- Horizontal Form -->
            <form method="POST" action="{{ route('jenistemuan.store') }}">
                @csrf
                <div class="row mb-3">
                    <label for="jenis_temuan" class="col-sm-2 col-form-label">Jenis Jamninan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jenis_temuan" name="jenis_temuan" value="{{ old('jenis_temuan') }}" required>
                        @if ($errors->has('jenis_temuan'))
                            <span class="text-danger">{{ $errors->first('jenis_temuan') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                        @if ($errors->has('deskripsi'))
                            <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Horizontal Form -->

        </div>
    </div>
</main>
@endsection
