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
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Top 10 Diagnosa (ICD-10)</h6>
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-sm btn-success">
                <i class="bi-printer me-1"></i>Print Laporan
            </button>
            <button onclick="exportToExcel()" class="btn btn-sm btn-primary">
                <i class="bi-file-earmark-excel me-1"></i>Export Excel
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="reportTable">
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

@push('scripts')
<script>
// Export table to Excel
function exportToExcel() {
    const table = document.getElementById('reportTable');
    let html = table.outerHTML;
    
    // Create download link
    const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
    const downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    const startDate = '{{ $startDate }}';
    const endDate = '{{ $endDate }}';
    downloadLink.href = url;
    downloadLink.download = `Laporan_Morbiditas_${startDate}_to_${endDate}.xls`;
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Print styles
const style = document.createElement('style');
style.innerHTML = `
    @media print {
        .sidebar, .navbar, .btn-group, .card-header .btn-group, nav, footer, .btn-secondary {
            display: none !important;
        }
        .main-content {
            margin: 0 !important;
            padding: 20px !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table {
            font-size: 12px;
        }
        .progress {
            display: none;
        }
        @page {
            margin: 1cm;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
