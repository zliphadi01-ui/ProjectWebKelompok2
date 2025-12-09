<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemeriksaan Laboratorium</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .no-border td { border: none; padding: 5px; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>RUMAH SAKIT UMUM SIREMIK</h2>
        <p>Jl. Mastrip No. 123, Jember, Jawa Timur</p>
        <p>Telp: (0331) 123456 | Email: info@siremik-polije.com</p>
    </div>

    <h3 style="text-align: center;">HASIL PEMERIKSAAN LABORATORIUM</h3>

    <table class="no-border">
        <tr>
            <td width="20%">Nama Pasien</td>
            <td width="2%">:</td>
            <td>{{ $request->pasien->nama ?? '-' }}</td>
            <td width="20%">No. RM</td>
            <td width="2%">:</td>
            <td>{{ $request->pasien->no_rm ?? '-' }}</td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td>{{ $request->pasien->umur ?? '-' }} Tahun</td>
            <td>Tanggal Periksa</td>
            <td>:</td>
            <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td>Dokter Pengirim</td>
            <td>:</td>
            <td>{{ $request->dokter->name ?? '-' }}</td>
            <td>Poli</td>
            <td>:</td>
            <td>Umum</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="background-color: #f2f2f2;">Jenis Pemeriksaan</th>
                <th style="background-color: #f2f2f2;">Hasil</th>
                <th style="background-color: #f2f2f2;">Nilai Rujukan</th>
                <th style="background-color: #f2f2f2;">Satuan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($request->jenis_pemeriksaan as $jenis)
                            <li>{{ $jenis }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="vertical-align: top;">
                    {!! nl2br(e($request->hasil)) !!}
                </td>
                <td style="vertical-align: top;">-</td>
                <td style="vertical-align: top;">-</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Jember, {{ date('d F Y') }}</p>
        <p>Petugas Laboratorium</p>
        <br><br><br>
        <p><strong>{{ Auth::user()->name }}</strong></p>
    </div>

</body>
</html>
