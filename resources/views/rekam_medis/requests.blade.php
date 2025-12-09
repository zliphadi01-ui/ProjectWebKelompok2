@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Permintaan Akses Rekam Medis</h2>
            <p class="text-muted mb-0">Kelola permintaan akses dari dokter</p>
        </div>
        <a href="{{ route('rekam-medis.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'all' ? 'active' : '' }}" href="{{ route('rekam-medis.requests', ['filter' => 'all']) }}">
                Semua ({{ $allCount }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'pending' ? 'active' : '' }}" href="{{ route('rekam-medis.requests', ['filter' => 'pending']) }}">
                Menunggu{{ $pendingCount > 0 ? " ({$pendingCount})" : '' }}
                @if($pendingCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">!</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'approved' ? 'active' : '' }}" href="{{ route('rekam-medis.requests', ['filter' => 'approved']) }}">
                Disetujui ({{ $approvedCount }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'expired' ? 'active' : '' }}" href="{{ route('rekam-medis.requests', ['filter' => 'expired']) }}">
                Kadaluarsa ({{ $expiredCount }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $filter == 'rejected' ? 'active' : '' }}" href="{{ route('rekam-medis.requests', ['filter' => 'rejected']) }}">
                Ditolak ({{ $rejectedCount }})
            </a>
        </li>
    </ul>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Dokter</th>
                            <th>Pasien (No. RM)</th>
                            <th>Tanggal Permintaan</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td>{{ $request->dokter->name }}</td>
                                <td>
                                    <strong>{{ $request->pasien->nama }}</strong><br>
                                    <small class="text-muted">{{ $request->pasien->no_rm }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($request->requested_at)->format('d M Y, H:i') }}</td>
                                <td>
                                    <small>{{ \Str::limit($request->keterangan, 80) }}</small>
                                </td>
                                <td>
                                    @if($request->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($request->status == 'approved')
                                        @if($request->isExpired())
                                            <span class="badge bg-secondary">Kadaluarsa</span>
                                        @else
                                            <span class="badge bg-success">Disetujui</span>
                                            <small class="d-block text-muted">
                                                {{ $request->getExpirationStatus() }}
                                            </small>
                                        @endif
                                    @elseif($request->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($request->status == 'expired')
                                        <span class="badge bg-secondary">Kadaluarsa</span>
                                    @endif
                                </td>
                                <td>
                                    @if($request->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-success mb-1" 
                                                data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                            <i class="bi bi-check-circle me-1"></i>Setujui
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                            <i class="bi bi-x-circle me-1"></i>Tolak
                                        </button>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Setujui Permintaan Akses</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('rekam-medis.requests.approve', $request->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Akses akan berlaku selama <strong>24 jam</strong> sejak persetujuan ini.
                                                </div>
                                                <p><strong>Dokter:</strong> {{ $request->dokter->name }}</p>
                                                <p><strong>Pasien:</strong> {{ $request->pasien->nama }} ({{ $request->pasien->no_rm }})</p>
                                                <p><strong>Alasan:</strong><br>{{ $request->keterangan }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check-circle me-1"></i>Setujui Permintaan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Permintaan Akses</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('rekam-medis.requests.reject', $request->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p><strong>Dokter:</strong> {{ $request->dokter->name }}</p>
                                                <p><strong>Pasien:</strong> {{ $request->pasien->nama }} ({{ $request->pasien->no_rm }})</p>
                                                <p><strong>Alasan Dokter:</strong><br>{{ $request->keterangan }}</p>
                                                <hr>
                                                <div class="mb-3">
                                                    <label for="catatan_penolakan{{ $request->id }}" class="form-label fw-bold">
                                                        Alasan Penolakan <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea 
                                                        class="form-control" 
                                                        id="catatan_penolakan{{ $request->id }}" 
                                                        name="catatan_penolakan" 
                                                        rows="3" 
                                                        required
                                                        placeholder="Jelaskan alasan penolakan permintaan ini..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Tolak Permintaan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    @if($filter == 'all')
                                        <p class="text-muted">Belum ada permintaan akses rekam medis.</p>
                                    @else
                                        <p class="text-muted">Tidak ada permintaan dengan status "{{ ucfirst($filter) }}".</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="mt-3">
                    {{ $requests->appends(['filter' => $filter])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prevent modals from auto-showing on page load
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', cleanupModals);
    } else {
        cleanupModals();
    }
    
    function cleanupModals() {
        // Ensure all modals start hidden
        const modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            // Remove show class if accidentally added
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        });
        
        // Remove any leftover backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Reset body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
})();
</script>
@endpush
@endsection
