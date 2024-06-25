<!DOCTYPE html>
<html>
<head>
    <title>Data Temuan</title>
    <style>
        /* Add your PDF styles here */
    </style>
</head>
<body>
    <h1>Data Temuan</h1>

    <h2>SKTJM</h2>
    <table>
        <thead>
            <tr>
                <th>NO LHP</th>
                <th>Sumber Informasi</th>
                <th>Obrik Pemeriksaan</th>
                <th>Nama OPD</th>
                <th>Temuan</th>
                <th>Rekomendasi</th>
                <th>Nilai Rekomendasi (Rp)</th>
                <th>Nilai Telah Dibayar (Rp)</th>
                <th>Sisa Nilai Uang (Rp)</th>
                <th>Status</th>
                <th>Nama PPK</th>
                <th>Nama Penyedia</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($temuans as $temuan)
                <tr>
                    <td>{{ $temuan->no_lhp }}</td>
                    <td>{{ $temuan->informasi->dinas_name }}</td>
                    <td>{{ $temuan->obrik_pemeriksaan }}</td>
                    <td>{{ $temuan->opd->opd_name }}</td>
                    <td>{{ $temuan->temuan }}</td>
                    <td>{{ $temuan->rekomendasi }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                    <td>{{ $temuan->status->status }}</td>
                    <td>{{ $temuan->pegawai->name }}</td>
                    <td>{{ $temuan->penyedia->penyedia_name }}</td>
                    <td>{{ $temuan->tgl_lhp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>SKP2KS</h2>
    <table>
        <thead>
            <tr>
                <th>NO LHP</th>
                <th>Sumber Informasi</th>
                <th>Obrik Pemeriksaan</th>
                <th>Nama OPD</th>
                <th>Temuan</th>
                <th>Rekomendasi</th>
                <th>Nilai Rekomendasi (Rp)</th>
                <th>Nilai Telah Dibayar (Rp)</th>
                <th>Sisa Nilai Uang (Rp)</th>
                <th>Status</th>
                <th>Nama PPK</th>
                <th>Nama Penyedia</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($temuans2 as $temuan)
                <tr>
                    <td>{{ $temuan->no_lhp }}</td>
                    <td>{{ $temuan->informasi->dinas_name }}</td>
                    <td>{{ $temuan->obrik_pemeriksaan }}</td>
                    <td>{{ $temuan->opd->opd_name }}</td>
                    <td>{{ $temuan->temuan }}</td>
                    <td>{{ $temuan->rekomendasi }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                    <td>{{ $temuan->status->status }}</td>
                    <td>{{ $temuan->pegawai->name }}</td>
                    <td>{{ $temuan->penyedia->penyedia_name }}</td>
                    <td>{{ $temuan->tgl_lhp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>SKP2K</h2>
    <table>
        <thead>
            <tr>
                <th>NO LHP</th>
                <th>Sumber Informasi</th>
                <th>Obrik Pemeriksaan</th>
                <th>Nama OPD</th>
                <th>Temuan</th>
                <th>Rekomendasi</th>
                <th>Nilai Rekomendasi (Rp)</th>
                <th>Nilai Telah Dibayar (Rp)</th>
                <th>Sisa Nilai Uang (Rp)</th>
                <th>Status</th>
                <th>Nama PPK</th>
                <th>Nama Penyedia</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($temuans3 as $temuan)
                <tr>
                    <td>{{ $temuan->no_lhp }}</td>
                    <td>{{ $temuan->informasi->dinas_name }}</td>
                    <td>{{ $temuan->obrik_pemeriksaan }}</td>
                    <td>{{ $temuan->opd->opd_name }}</td>
                    <td>{{ $temuan->temuan }}</td>
                    <td>{{ $temuan->rekomendasi }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_rekomendasi, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->nilai_telah_dibayar, 2, ',', '.') }}</td>
                    <td>Rp.{{ number_format($temuan->sisa_nilai_uang, 2, ',', '.') }}</td>
                    <td>{{ $temuan->status->status }}</td>
                    <td>{{ $temuan->pegawai->name }}</td>
                    <td>{{ $temuan->penyedia->penyedia_name }}</td>
                    <td>{{ $temuan->tgl_lhp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
