@extends('template.header-footer')

@section('content')
<style>
    td , th{
        font-size: 14px;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="card" style="padding: 10px">
            <div class="card-body" >
                <h1>History Pembayaran</h1>
                <h5>No LHP : {{ $temuan->no_lhp }} </h5>
                {{-- <h4>Nama Dinas ODP : {{ $temuan->opd->opd_name }} </h4> --}}
                <a href="{{ route('pembayaran-history.pdf') }}" class="btn btn-primary mb-3">Download PDF</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Jumlah Pembayaran</th>
                            <th scope="col">Tanggal Pembayaran</th>
                            <th scope="col">Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pembayaran)
                            <tr>
                                <td>Rp.{{ number_format($pembayaran->jumlah_pembayaran, 2, ',', '.') }}</td>
                                <td>{{ $pembayaran->tgl_pembayaran }}</td>
                                <td>
                                    @if ($pembayaran->bukti_pembayaran)
                                        <a href="{{ asset($pembayaran->bukti_pembayaran) }}" target="_blank">View</a>
                                    @else
                                       Tidak Ada
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection
