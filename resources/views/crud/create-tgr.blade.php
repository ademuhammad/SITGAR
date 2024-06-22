@extends('template.header-footer')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create TGR Status</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tgr.index') }}">TGR</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create TGR Status</h5>

            <!-- Horizontal Form -->
            <form method="POST" action="{{ route('tgr.store') }}">
                @csrf
                <div class="row mb-3">
                    <label for="tgr_name" class="col-sm-2 col-form-label">TGR Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tgr_name" name="tgr_name" value="{{ old('tgr_name') }}" required>
                        @if ($errors->has('tgr_name'))
                            <span class="text-danger">{{ $errors->first('tgr_name') }}</span>
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
