@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Status</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tgr.index') }}">TGR</a></li>
                    <li class="breadcrumb-item active">Edit TGR</li>
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
                            <form action="{{ route('tgr.update', $tgr->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="tgr_name" class="form-label">Nama Status TGR</label>
                                    <input type="text" class="form-control" id="tgr_name" name="tgr_name" value="{{ $tgr->tgr_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ $tgr->description }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('tgr.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                            <!-- End Form untuk edit status -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
