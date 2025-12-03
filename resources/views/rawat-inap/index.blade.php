@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold text-dark mb-1">Rawat Inap</h2>
        <p class="text-muted mb-0">Monitor ketersediaan kamar dan pasien</p>
    </div>
    <a href="{{ route('rawat-inap.create') }}" class="btn btn-dark rounded-pill px-4">
        <i class="bi-plus-lg me-2"></i>Pasien Baru
    </a>
</div>

{{-- Minimalist Stats --}}
<div class="row mb-5 g-4">
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-4 shadow-sm border h-100 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="text-muted text-uppercase small fw-bold tracking-wider mb-1">Total Bed</h6>
                    <h1 class="display-4 fw-bold text-dark mb-0">{{ $totalBeds }}</h1>
                </div>
                <div class="p-2 bg-light rounded-circle text-dark">
                    <i class="bi-hospital fs-4"></i>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-dark" role="progressbar" style="width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-4 shadow-sm border h-100 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="text-muted text-uppercase small fw-bold tracking-wider mb-1">Terisi</h6>
                    <h1 class="display-4 fw-bold text-danger mb-0">{{ $occupied }}</h1>
                </div>
                <div class="p-2 bg-danger-subtle rounded-circle text-danger">
                    <i class="bi-person-fill-lock fs-4"></i>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalBeds > 0 ? ($occupied/$totalBeds)*100 : 0 }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-4 bg-white rounded-4 shadow-sm border h-100 d-flex flex-column justify-content-between">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h6 class="text-muted text-uppercase small fw-bold tracking-wider mb-1">Tersedia</h6>
                    <h1 class="display-4 fw-bold text-success mb-0">{{ $available }}</h1>
                </div>
                <div class="p-2 bg-success-subtle rounded-circle text-success">
                    <i class="bi-check-lg fs-4"></i>
                </div>
            </div>
            <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalBeds > 0 ? ($available/$totalBeds)*100 : 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

{{-- Clean Bed Monitor --}}
<div class="mb-4">
    <h5 class="fw-bold text-dark mb-4">Status Kamar</h5>
    <div class="row g-4">
        @forelse($beds as $bed)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative group-hover-effect">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge rounded-pill {{ $bed->status == 'occupied' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-3 py-2 mb-2">
                                {{ $bed->status == 'occupied' ? 'Terisi' : 'Tersedia' }}
                            </span>
                            <h5 class="fw-bold text-dark mb-0">{{ $bed->nama_kamar }}</h5>
                            <small class="text-muted">Kelas {{ $bed->kelas }} • Bed {{ $bed->no_bed }}</small>
                        </div>
                        @if($bed->gender == 'L')
                            <i class="bi-gender-male text-primary fs-5" title="Laki-laki"></i>
                        @elseif($bed->gender == 'P')
                            <i class="bi-gender-female text-danger fs-5" title="Perempuan"></i>
                        @else
                            <i class="bi-gender-ambiguous text-secondary fs-5" title="Campur"></i>
                        @endif
                    </div>

                    @if($bed->status == 'occupied' && $bed->rawatInap)
                        <div class="mt-4 pt-3 border-top border-light">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi-person text-secondary"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 text-truncate fw-semibold">{{ $bed->rawatInap->pasien->nama ?? 'Unknown' }}</h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        {{ \Carbon\Carbon::parse($bed->rawatInap->tanggal_masuk)->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            <a href="{{ route('rawat-inap.show', $bed->rawatInap->id) }}" class="btn btn-outline-dark btn-sm w-100 rounded-pill">
                                Detail Pasien
                            </a>
                        </div>
                    @else
                        <div class="mt-4 pt-3 border-top border-light">
                            <p class="text-muted small mb-3">Kamar ini siap digunakan.</p>
                            <a href="{{ route('rawat-inap.create') }}?bed_id={{ $bed->id }}" class="btn btn-light btn-sm w-100 rounded-pill text-primary fw-semibold">
                                <i class="bi-plus-circle me-1"></i> Isi Bed
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="bi-inbox fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">Belum ada data bed.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.1em; }
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .text-danger { color: #ef4444 !important; }
    .text-success { color: #22c55e !important; }
    .group-hover-effect { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .group-hover-effect:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
</style>
@endsection
