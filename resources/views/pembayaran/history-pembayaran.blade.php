@extends('template.header-footer')

@section('content')
<style>
    td, th {
        font-size: 14px;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="card" style="padding: 10px">
            <div class="card-body">
                <h1>History Pembayaran</h1>
                <h5>No LHP: {{ $temuan->no_lhp }}</h5>
                <a href="{{ route('pembayaran-history.pdf') }}" class="btn btn-primary mb-3">Download PDF</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Jumlah Pembayaran</th>
                            <th scope="col">Tanggal Pembayaran</th>
                            <th scope="col">Bukti Pembayaran</th>
                            <th scope="col">Status</th> <!-- Tambahkan kolom status -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            <tr>
                                <td>Rp.{{ number_format($pembayaran->jumlah_pembayaran, 2, ',', '.') }}</td>
                                <td>{{ $pembayaran->tgl_pembayaran }}</td>
                                <td>
                                    @if ($pembayaran->bukti_pembayaran)
                                        <a href="{{ asset('bukti_pembayaran/' . $pembayaran->bukti_pembayaran) }}" target="_blank">View</a>
                                    @else
                                       Tidak Ada
                                    @endif
                                </td>
                                <td>{{ ucfirst($pembayaran->status) }}</td> <!-- Tampilkan status -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <h6>Total Sudah DiBayar: Rp.{{ number_format($totalPaid, 2, ',', '.') }}</h6>
                    <h6>Sisa Yang Harus DiBayar: Rp.{{ number_format($remainingAmount, 2, ',', '.') }}</h6>
                    <h6>Jumlah Bulan Pembayaran: {{ $totalMonths }} bulan</h6>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
