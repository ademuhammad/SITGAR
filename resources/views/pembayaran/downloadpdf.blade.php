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
    <table>
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
                    <td>Rp.{{ $pembayaran->tgl_pembayaran }}</td>
                    <td>
                        @if ($pembayaran->bukti_pembayaran)
                            <a href="{{ asset($pembayaran->bukti_pembayaran) }}" target="_blank">View</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>SITGAR</span></strong> Apps
        </div>

    </footer><!-- End Footer -->
</body>
</html>
