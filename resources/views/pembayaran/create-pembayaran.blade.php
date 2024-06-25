@extends('template.header-footer')

@section('content')
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h1>Tambah Pembayaran</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('pembayaran.store', $temuan->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="form-group">
                        <label for="jumlah_pembayaran">Jumlah Pembayaran</label>
                        <input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{ old('jumlah_pembayaran') }}">
                    </div>
                    <div class="form-group">
                        <label for="tgl_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tgl_pembayaran" name="tgl_pembayaran" value="{{ old('tgl_pembayaran') }}">
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran (PDF)</label>
                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
