<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Hasil Pemeriksaan - {{ $pemeriksaan->pasien->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; height: auto; float: left; margin-right: 15px; }
        .rs-name { font-size: 20px; font-weight: bold; margin: 0; }
        .rs-address { font-size: 12px; margin: 0; }
        .title { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px; text-transform: uppercase; }
        .table-data tr td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 150px; }
        .signature { margin-top: 50px; text-align: right; margin-right: 50px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-4">
        <div class="no-print mb-4">
            <a href="{{ route('pemeriksaan.index') }}" class="btn btn-secondary">Kembali</a>
            <button onclick="window.print()" class="btn btn-primary">Cetak</button>
        </div>

        <div class="header clearfix">
            <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="Logo" class="logo">
            <div style="float: left;">
                <h1 class="rs-name">RUMAH SAKIT POLIJE</h1>
                <p class="rs-address">Jl. Mastrip PO. BOX 164, Jember - Jawa Timur<br>Telp: (0331) 333532</p>
            </div>
        </div>

        <div class="title">HASIL PEMERIKSAAN MEDIS</div>

        <div class="row">
            <div class="col-6">
                <table class="table-data w-100">
                    <tr>
                        <td class="label">No. RM</td>
                        <td>: {{ $pemeriksaan->pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Pasien</td>
                        <td>: {{ $pemeriksaan->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Lahir / Umur</td>
                        <td>: {{ $pemeriksaan->pasien->tanggal_lahir }} / {{ \Carbon\Carbon::parse($pemeriksaan->pasien->tanggal_lahir)->age }} Thn</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td>: {{ $pemeriksaan->pasien->jenis_kelamin }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table-data w-100">
                    <tr>
                        <td class="label">Tanggal Periksa</td>
                        <td>: {{ $pemeriksaan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Dokter Pemeriksa</td>
                        <td>: {{ Auth::user()->name ?? 'Dokter Jaga' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Poli / Unit</td>
                        <td>: {{ $pemeriksaan->pendaftaran->poli ?? 'Umum' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h5 class="fw-bold mt-3">Tanda Vital</h5>
        <div class="row mb-3">
            <div class="col-3"><strong>TD:</strong> {{ $pemeriksaan->tekanan_darah ?? '-' }} mmHg</div>
            <div class="col-3"><strong>Nadi:</strong> {{ $pemeriksaan->nadi ?? '-' }} x/mnt</div>
            <div class="col-3"><strong>Suhu:</strong> {{ $pemeriksaan->suhu ?? '-' }} °C</div>
            <div class="col-3"><strong>BB:</strong> {{ $pemeriksaan->berat_badan ?? '-' }} Kg</div>
        </div>

        <h5 class="fw-bold mt-3">Catatan Medis (SOAP)</h5>
        <table class="table table-bordered">
            <tr>
                <td class="bg-light fw-bold" width="20%">Subjective (Keluhan)</td>
                <td>{{ $pemeriksaan->subjective }}</td>
            </tr>
            <tr>
                <td class="bg-light fw-bold">Objective (Fisik)</td>
                <td>{{ $pemeriksaan->objective }}</td>
            </tr>
            <tr>
                <td class="bg-light fw-bold">Assessment (Diagnosa)</td>
                <td>
                    <strong>{{ $pemeriksaan->diagnosis }}</strong>
                    @if($pemeriksaan->icd_code) <span class="badge bg-warning text-dark border">{{ $pemeriksaan->icd_code }}</span> @endif
                    <br>
                    <small class="text-muted">{{ $pemeriksaan->assessment }}</small>
                </td>
            </tr>
            <tr>
                <td class="bg-light fw-bold">Plan (Terapi/Tindakan)</td>
                <td>
                    {{ $pemeriksaan->plan }}
                    @if($pemeriksaan->procedure)
                        <div class="mt-2">
                            <strong>Tindakan:</strong> {{ $pemeriksaan->procedure }}
                            @if($pemeriksaan->icd9_code) <span class="badge bg-info text-dark border">{{ $pemeriksaan->icd9_code }}</span> @endif
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <div class="signature">
            <p>Jember, {{ date('d F Y') }}</p>
            <br><br><br>
            <p class="fw-bold">({{ Auth::user()->name ?? 'Dokter Pemeriksa' }})</p>
        </div>

    </div>

</body>
</html>
