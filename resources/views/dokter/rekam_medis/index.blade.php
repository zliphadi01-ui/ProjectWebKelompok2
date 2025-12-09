@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Rekam Medis Pasien</h2>
            <p class="text-muted mb-0">Dashboard akses rekam medis untuk dokter</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($soonToExpire->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Anda memiliki {{ $soonToExpire->count() }} akses yang akan segera kadaluarsa (kurang dari 2 jam).
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="bi bi-file-medical text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">Total Permintaan</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalRequests }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">Akses Aktif</h6>
                            <h3 class="mb-0 fw-bold text-success">{{ $activeAccess }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">Menunggu</h6>
                            <h3 class="mb-0 fw-bold text-warning">{{ $pendingRequests }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary bg-opacity-10 rounded p-3">
                                <i class="bi bi-x-circle text-secondary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0 small">Kadaluarsa</h6>
                            <h3 class="mb-0 fw-bold text-secondary">{{ $expiredRequests }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Aksi Cepat</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-primary">
                            <i class="bi bi-people me-2"></i>Lihat Daftar Pasien
                        </a>
                        <a href="{{ route('dokter.rekam-medis.my-requests') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list-check me-2"></i>Permintaan Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Access List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0">Pasien dengan Akses Aktif</h5>
                </div>
                <div class="card-body">
                    @if($approvedPatients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status Akses</th>
                                        <th>Kadaluarsa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedPatients as $request)
                                        <tr>
                                            <td><span class="badge bg-light text-dark">{{ $request->pasien->no_rm }}</span></td>
                                            <td>{{ $request->pasien->nama }}</td>
                                            <td>{{ $request->pasien->jenis_kelamin }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Aktif
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $hoursRemaining = $request->getTimeRemaining();
                                                @endphp
                                                @if($hoursRemaining < 2)
                                                    <span class="text-danger fw-bold">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ $request->getExpirationStatus() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ $request->getExpirationStatus() }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('dokter.rekam-medis.view', $request->pasien_id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye me-1"></i>Lihat Rekam Medis
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada akses aktif ke rekam medis pasien.</p>
                            <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-primary mt-2">
                                Ajukan Permintaan Akses
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
