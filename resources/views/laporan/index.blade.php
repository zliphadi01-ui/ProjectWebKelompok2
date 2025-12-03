@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2>Laporan Klinik</h2>
        <p class="text-muted">Generate laporan berdasarkan periode</p>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form id="reportForm" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="fw-bold">Jenis Laporan</label>
                        <select id="jenis_laporan" name="jenis_laporan" class="form-control" required onchange="updateFormAction()">
                            <option value="">Pilih Jenis</option>
                            <option value="kunjungan">Laporan Kunjungan</option>
                            <option value="diagnosa">Laporan Diagnosa</option>
                            <option value="pendaftaran">Laporan Pendaftaran (Not Implemented)</option>
                            <option value="pembayaran">Laporan Pembayaran (Not Implemented)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-chart-bar"></i> Generate Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Reports -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #3B82F6;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-day fa-3x text-primary mb-3"></i>
                    <h5>Laporan Hari Ini</h5>
                    <p class="text-muted">Laporan kunjungan hari ini</p>
                    <a href="{{ route('laporan.kunjungan', ['start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d')]) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #10B981;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-week fa-3x text-success mb-3"></i>
                    <h5>Laporan Mingguan</h5>
                    <p class="text-muted">Laporan 7 hari terakhir</p>
                    <a href="{{ route('laporan.kunjungan', ['start_date' => date('Y-m-d', strtotime('-7 days')), 'end_date' => date('Y-m-d')]) }}" class="btn btn-success">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card text-center" style="border-left: 5px solid #F59E0B;">
                <div class="card-body py-4">
                    <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
                    <h5>Laporan Bulanan</h5>
                    <p class="text-muted">Laporan bulan ini</p>
                    <a href="{{ route('laporan.kunjungan', ['start_date' => date('Y-m-01'), 'end_date' => date('Y-m-t')]) }}" class="btn btn-warning">
                        <i class="fas fa-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateFormAction() {
        const type = document.getElementById('jenis_laporan').value;
        const form = document.getElementById('reportForm');

        if (type === 'kunjungan') {
            form.action = "{{ route('laporan.kunjungan') }}";
        } else if (type === 'diagnosa') {
            form.action = "{{ route('laporan.diagnosa') }}";
        } else {
            form.action = "#"; // Fallback or handle not implemented
            if(type) alert('Laporan ini belum tersedia.');
        }
    }
</script>
@endpush
@endsection
