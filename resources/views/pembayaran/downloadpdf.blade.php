<!DOCTYPE html>
<html>
<head>
    <title>History Pembayaran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>History Pembayaran</h1>
    @if($temuan)
        <h4>No LHP : {{ $temuan->no_lhp }}</h4>
        <h4>Nama Dinas ODP : {{ $temuan->opd->opd_name }}</h4>
    @else
        <h4>No LHP : Tidak Ditemukan</h4>
        <h4>Nama Dinas ODP : Tidak Ditemukan</h4>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Jumlah Pembayaran</th>
                <th scope="col">Tanggal Pembayaran</th>
                {{-- <th scope="col">Bukti Pembayaran</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans as $pembayaran)
                <tr>
                    <td>Rp.{{ number_format($pembayaran->jumlah_pembayaran, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tgl_pembayaran)->translatedFormat('d F Y') }}</td>
                    {{-- <td>
                        @if ($pembayaran->bukti_pembayaran)
                            <a href="{{ asset($pembayaran->bukti_pembayaran) }}" target="_blank">View</a>
                        @else
                            Tidak Ada
                        @endif
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <h3>Total Pembayaran: Rp.{{ number_format($totalPembayaran, 2, ',', '.') }}</h3>
        <h3>Total Nilai Rekomendasi: Rp.{{ number_format($nilaiRekomendasi, 2, ',', '.') }}</h3>
        <h3>Sisa yang Harus Dibayar: Rp.{{ number_format($sisaYangHarusDibayar, 2, ',', '.') }}</h3>
        <h3>Jumlah Bulan Pembayaran: {{ $totalMonths }} bulan</h3>
    </div>
</body>
</html>
