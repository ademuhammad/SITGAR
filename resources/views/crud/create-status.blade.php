@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Create Status</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('status.index') }}">Status</a></li>
                    <li class="breadcrumb-item active">Create Status</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create Status</h5>
                            <!-- Form untuk create status -->
                            <form action="{{ route('status.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('status.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                            <!-- End Form untuk create status -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
