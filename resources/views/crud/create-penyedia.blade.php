@extends('template.header-footer')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Create Penyedia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('penyedia.index') }}">SITGAR</a></li>
                    <li class="breadcrumb-item">Create</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create Penyedia</h5>
                            <form action="{{ route('penyedia.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="penyedia_name" class="form-label">Nama Penyedia</label>
                                    <input type="text" class="form-control" id="penyedia_name" name="penyedia_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penyedia_address" class="form-label">Alamat Penyedia</label>
                                    <input type="text" class="form-control" id="penyedia_address" name="penyedia_address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penyedia_izin" class="form-label">Izin Penyedia</label>
                                    <input type="text" class="form-control" id="penyedia_izin" name="penyedia_izin" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penyedia_information" class="form-label">Informasi Lainnya</label>
                                    <textarea class="form-control" id="penyedia_information" name="penyedia_information"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
