@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="bi-house-heart-fill me-2"></i> Rawat Inap</h2>
    <a href="{{ route('rawat-inap.create') }}" class="btn btn-primary rounded-pill"><i class="bi-plus-circle me-2"></i> Tambah Pasien</a>
</div>

{{-- STATS CARDS --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Total Pasien Dirawat</h6>
                <h2 class="mb-0 fw-bold">{{ $items->total() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #6610f2, #520dc2);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Kamar Terisi</h6>
                <h2 class="mb-0 fw-bold">{{ $items->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #198754, #146c43);">
            <div class="card-body">
                <h6 class="text-uppercase mb-1 opacity-75">Kamar Tersedia</h6>
                <h2 class="mb-0 fw-bold">12</h2> {{-- Placeholder --}}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #ffc107, #cc9a06);">
            <div class="card-body text-dark">
                <h6 class="text-uppercase mb-1 opacity-75">Rencana Pulang</h6>
                <h2 class="mb-0 fw-bold">2</h2> {{-- Placeholder --}}
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm border-left-success fade show" role="alert">
        <i class="bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary">Daftar Pasien Rawat Inap</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Pasien</th>
                        <th>Kamar</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i => $item)
                        <tr>
                            <td class="ps-4">{{ $items->firstItem() + $i }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->pasien?->nama ?? '-' }}</div>
                                <small class="text-muted">{{ $item->pasien?->no_rm ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $item->kamar }}</span>
                                <span class="text-muted small ms-1">No. {{ $item->no_kamar }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y, H:i') }}</td>
                            <td>
                                @php
                                    $statusClass = match($item->status) {
                                        'Dirawat' => 'bg-primary',
                                        'Pulang' => 'bg-success',
                                        'Rujuk' => 'bg-warning text-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('rawat-inap.show', $item->id) }}" class="btn btn-sm btn-outline-info rounded-pill" title="Lihat"><i class="bi-eye"></i></a>
                                <a href="{{ route('rawat-inap.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill" title="Edit"><i class="bi-pencil"></i></a>
                                <form action="{{ route('rawat-inap.destroy', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data rawat inap ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Hapus"><i class="bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi-clipboard-x display-4 mb-3 d-block opacity-25"></i>
                                    <span class="fw-bold">Belum ada data rawat inap.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($items->hasPages())
        <div class="card-footer bg-white">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
