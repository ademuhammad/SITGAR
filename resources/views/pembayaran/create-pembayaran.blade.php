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
                        <label for="jumlah_pembayaran_display">Jumlah Pembayaran</label>
                        <input type="text" class="form-control" id="jumlah_pembayaran_display" oninput="formatRupiah(this)">
                        <input type="hidden" id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{ old('jumlah_pembayaran') }}">
                    </div>
                    <div class="form-group">
                        <label for="tgl_pembayaran">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tgl_pembayaran" name="tgl_pembayaran" value="{{ old('tgl_pembayaran') }}">
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran (PDF/Image)</label>
                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran">
                    </div>
                    <div class="form-group">
                        <label for="remainingAmount">Sisa yang masih harus dibayar:</label>
                        <input type="text" class="form-control" id="remainingAmount" name="remainingAmount" value="{{ number_format($remainingAmount, 0, ',', '.') }}" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    function formatRupiah(element) {
        let value = element.value.replace(/[^,\d]/g, '').toString();
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        element.value = 'Rp ' + rupiah;

        // Update the hidden input with the numerical value
        document.getElementById('jumlah_pembayaran').value = value.replace(/[^,\d]/g, '');
    }
</script>
@endsection
