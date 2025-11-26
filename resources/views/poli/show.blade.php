@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
            <p class="text-muted mb-0">Daftar antrean pasien untuk {{ $title }} hari ini.</p>
        </div>
        <div class="text-end">
            <div class="small text-muted">Tanggal</div>
            <div class="fw-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">Antrean Pasien</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">No. Antrean</th>
                            <th class="px-4 py-3">Nama Pasien</th>
                            <th class="px-4 py-3">No. RM</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antrean as $pasien)
                            <tr>
                                <td class="px-4 py-3 fw-bold text-primary">{{ $pasien->no_daftar }}</td>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $pasien->nama }}</div>
                                    <div class="small text-muted">{{ $pasien->nik }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $pasien->pasien->no_rm ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $badgeClass = match($pasien->status) {
                                            'Menunggu' => 'bg-warning text-dark',
                                            'Diperiksa' => 'bg-info text-white',
                                            'Selesai' => 'bg-success text-white',
                                            'Dibatalkan' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ $pasien->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @if($pasien->status == 'Menunggu')
                                        <a href="{{ route('pemeriksaan.index') }}" class="btn btn-sm btn-primary rounded-pill">
                                            <i class="bi-stethoscope me-1"></i> Periksa
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-light rounded-pill" disabled>
                                            <i class="bi-check-circle me-1"></i> Selesai
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi-clipboard-x display-4 mb-3 d-block opacity-25"></i>
                                        <span class="fw-bold">Belum ada antrean untuk poli ini.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
