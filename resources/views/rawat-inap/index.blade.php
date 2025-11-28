@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Rawat Inap (Bangsal)</h2>
    <a href="{{ route('rawat-inap.create') }}" class="btn btn-primary">
        <i class="bi-plus-circle me-2"></i> Terima Pasien Baru
    </a>
</div>

{{-- Stats --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-primary">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Total Bed</h6>
                <h2 class="mb-0 fw-bold">{{ $totalBeds }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-danger">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Terisi (Occupied)</h6>
                <h2 class="mb-0 fw-bold">{{ $occupied }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white bg-success">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Tersedia (Available)</h6>
                <h2 class="mb-0 fw-bold">{{ $available }}</h2>
            </div>
        </div>
    </div>
</div>

{{-- Bed Monitor --}}
<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Monitor Ketersediaan Bed</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($beds as $bed)
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 border-0 shadow-sm {{ $bed->status == 'occupied' ? 'bg-light border-start border-5 border-danger' : 'bg-white border-start border-5 border-success' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge {{ $bed->status == 'occupied' ? 'bg-danger' : 'bg-success' }}">
                                {{ ucfirst($bed->status) }}
                            </span>
                            <small class="text-muted">Kelas {{ $bed->kelas }}</small>
                        </div>
                        <h5 class="card-title fw-bold mb-1">{{ $bed->nama_kamar }}</h5>
                        <p class="card-text text-muted small mb-2">Bed No: {{ $bed->no_bed }}</p>
                        
                        @if($bed->status == 'occupied' && $bed->rawatInap)
                            <div class="mt-3 pt-3 border-top">
                                <p class="mb-1 fw-bold text-truncate">{{ $bed->rawatInap->pasien->nama ?? 'Unknown' }}</p>
                                <small class="d-block text-muted mb-2">Masuk: {{ \Carbon\Carbon::parse($bed->rawatInap->tanggal_masuk)->format('d M H:i') }}</small>
                                <a href="{{ route('rawat-inap.show', $bed->rawatInap->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        @else
                            <div class="mt-3 pt-3 border-top">
                                <span class="d-block text-muted small mb-2">Kosong</span>
                                <a href="{{ route('rawat-inap.create') }}?bed_id={{ $bed->id }}" class="btn btn-sm btn-outline-success w-100">
                                    Isi Bed
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada data bed. Silakan tambahkan master data bed.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
