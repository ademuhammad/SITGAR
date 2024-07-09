<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Temuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Keseluruhan</h1>
    <table>
        <thead>
            <tr>
                <th>No LHP</th>
                <th>Sumber Informasi</th>
                <th>Nama OPD</th>
                <th>Status</th>
                <th>Tgl LHP</th>
                <th>Obrik Pemeriksaan</th>
                <th>Temuan</th>
                <th>Rekomendasi</th>
                <th>Jumlah Kerugian</th>
                <th>Telah Dibayar</th>
                <th>Sisa Kerugian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->no_lhp }}</td>
                    <td>{{ $item->dinas_name }}</td>
                    <td>{{ $item->opd_name }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->tgl_lhp }}</td>
                    <td>{{ $item->obrik_pemeriksaan }}</td>
                    <td>{{ $item->temuan }}</td>
                    <td>{{ $item->rekomendasi }}</td>
                    <td>Rp {{ number_format($item->nilai_rekomendasi, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->nilai_telah_dibayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->sisa_nilai_uang, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" style="text-align: right;">Total:</th>
                <th>Rp {{ number_format($data->sum('nilai_rekomendasi'), 0, ',', '.') }}</th>
                <th>Rp {{ number_format($data->sum('nilai_telah_dibayar'), 0, ',', '.') }}</th>
                <th>Rp {{ number_format($data->sum('sisa_nilai_uang'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
