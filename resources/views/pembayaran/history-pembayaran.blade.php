@extends('template.header-footer')

@section('content')
<style>
    td, th {
        font-size: 14px;
    }
    span {
        font-weight: bold;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="card" style="padding: 10px">
            <div class="card-body">
                <h1>History Pembayaran</h1>
                <h5>No LHP: {{ $temuan->no_lhp }}</h5>
                <a href="{{ route('pembayaran-history.pdf') }}" class="btn btn-success mb-3">Download PDF</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Jumlah Pembayaran</th>
                            <th scope="col">Tanggal Pembayaran</th>
                            <th scope="col">Bukti Pembayaran</th>
                            <th scope="col">Status</th>
                            <th scope="col">Keterangan</th> <!-- New column for keterangan -->
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
                                <td>{{ ucfirst($pembayaran->status) }}</td>
                                <td>{{ $pembayaran->keterangan ?? 'Tidak ada keterangan' }}</td> <!-- Display keterangan -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <h6>Total Sudah DiBayar:  <span>Rp. {{ number_format($totalPaid, 2, ',', '.') }}</span></h6>
                    <h6>Sisa Yang Harus DiBayar: <span>Rp.{{ number_format($remainingAmount, 2, ',', '.') }}</span></h6>
                    <h6>Jumlah Bulan Pembayaran:<span> {{ $totalMonths }} bulan </span> </h6>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
