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
</body>
</html>
