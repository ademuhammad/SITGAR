@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Status</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('status.index') }}">Status</a></li>
                    <li class="breadcrumb-item active">Edit Status</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Status</h5>
                            <!-- Form untuk edit status -->
                            <form action="{{ route('status.update', $status->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" value="{{ $status->status }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $status->description }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('status.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                            <!-- End Form untuk edit status -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
