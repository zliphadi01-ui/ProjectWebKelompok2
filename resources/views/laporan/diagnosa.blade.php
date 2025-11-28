@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Laporan 10 Besar Penyakit (Morbiditas)</h2>
    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.diagnosa') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100"><i class="bi-filter me-2"></i> Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary">Top 10 Diagnosa (ICD-10)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px;">Rank</th>
                        <th>Kode ICD-10</th>
                        <th>Nama Penyakit (Diagnosa)</th>
                        <th class="text-center">Jumlah Kasus</th>
                        <th style="width: 30%;">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php $max = $topDiagnosa->first()->total ?? 1; @endphp
                    @forelse($topDiagnosa as $index => $d)
                    <tr>
                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                        <td><span class="badge bg-info text-dark">{{ $d->icd_code }}</span></td>
                        <td>{{ $d->diagnosis }}</td>
                        <td class="text-center fw-bold">{{ $d->total }}</td>
                        <td>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($d->total / $max) * 100 }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi-clipboard-x display-4 d-block mb-3 opacity-25"></i>
                            Belum ada data diagnosa pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
