@extends('template.header-footer')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create OPD</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('opds.index') }}">OPDs</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create OPD</h5>

            <!-- Horizontal Form -->
            <form method="POST" action="{{ route('opds.store') }}">
                @csrf
                <div class="row mb-3">
                    <label for="opd_name" class="col-sm-2 col-form-label">OPD Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="opd_name" name="opd_name" value="{{ old('opd_name') }}" required>
                        @if ($errors->has('opd_name'))
                            <span class="text-danger">{{ $errors->first('opd_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
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
