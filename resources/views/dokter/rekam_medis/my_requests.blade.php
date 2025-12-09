@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Permintaan Saya</h2>
            <p class="text-muted mb-0">Daftar semua permintaan akses rekam medis yang telah Anda ajukan</p>
        </div>
        <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Permintaan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $request->pasien->no_rm }}</span></td>
                                <td>{{ $request->pasien->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($request->requested_at)->format('d M Y, H:i') }}</td>
                                <td>
                                    @if($request->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Menunggu
                                        </span>
                                    @elseif($request->status == 'approved')
                                        @if($request->isExpired())
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>Kadaluarsa
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Disetujui
                                            </span>
                                            <small class="d-block text-success mt-1">
                                                {{ $request->getExpirationStatus() }}
                                            </small>
                                        @endif
                                    @elseif($request->status == 'rejected')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Ditolak
                                        </span>
                                    @elseif($request->status == 'expired')
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Kadaluarsa
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Str::limit($request->keterangan, 50) }}</small>
                                    @if($request->status == 'rejected' && $request->catatan_penolakan)
                                        <div class="alert alert-danger alert-sm mt-2 mb-0 p-2">
                                            <strong>Alasan Penolakan:</strong><br>
                                            {{ $request->catatan_penolakan }}
                                        </div>
                                    @endif
                                    @if($request->status == 'approved' && !$request->isExpired())
                                        <div class="alert alert-success alert-sm mt-2 mb-0 p-2">
                                            <strong>Disetujui oleh:</strong> {{ $request->processedBy->name ?? 'Staff Rekam Medis' }}<br>
                                            <strong>Pada:</strong> {{ \Carbon\Carbon::parse($request->processed_at)->format('d M Y, H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($request->status == 'approved' && !$request->isExpired())
                                        <a href="{{ route('dokter.rekam-medis.view', $request->pasien_id) }}" 
                                           class="btn btn-sm btn-success mb-1">
                                            <i class="bi bi-eye me-1"></i>Lihat Rekam Medis
                                        </a>
                                    @elseif($request->status == 'rejected' || $request->status == 'expired' || $request->isExpired())
                                        <a href="{{ route('dokter.rekam-medis.request', $request->pasien_id) }}" 
                                           class="btn btn-sm btn-primary mb-1">
                                            <i class="bi bi-arrow-repeat me-1"></i>Ajukan Lagi
                                        </a>
                                    @elseif($request->status == 'pending')
                                        <form method="POST" action="{{ route('dokter.rekam-medis.cancel', $request->id) }}" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin membatalkan permintaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle me-1"></i>Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">Anda belum pernah mengajukan permintaan akses rekam medis.</p>
                                    <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-primary mt-2">
                                        Ajukan Permintaan
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
