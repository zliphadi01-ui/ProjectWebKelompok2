@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="bi-hospital-fill me-2"></i>Instalasi Gawat Darurat (IGD)</h2>
    <a href="{{ route('igd.create') }}" class="btn btn-primary btn-lg shadow-sm">
        <i class="bi-plus-circle me-2"></i> Terima Pasien Darurat
    </a>
</div>

<div class="row g-4">
    {{-- Queue Column --}}
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Antrian Triase & Penanganan</h5>
                <span class="badge bg-light text-primary border">{{ $igdPatients->count() }} Pasien</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center">Prioritas</th>
                                <th>Waktu Masuk</th>
                                <th>Pasien</th>
                                <th>Keluhan / Tanda Vital</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($igdPatients as $p)
                            @php
                                $color = 'secondary';
                                $label = 'Belum Triase';
                                if($p->triage) {
                                    $color = match($p->triage->kategori) {
                                        'Merah' => 'danger',
                                        'Kuning' => 'warning',
                                        'Hijau' => 'success',
                                        'Hitam' => 'dark',
                                        default => 'secondary'
                                    };
                                    $label = $p->triage->kategori;
                                }
                            @endphp
                            <tr class="{{ $label == 'Merah' ? 'table-danger' : '' }}">
                                <td class="text-center">
                                    <span class="badge bg-{{ $color }} fs-6 px-3 py-2 rounded-pill">{{ $label }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $p->created_at->format('H:i') }}</div>
                                    <small class="text-muted">{{ $p->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $p->nama }}</div>
                                    <div class="small text-muted">RM: {{ $p->pasien->no_rm ?? '-' }} | {{ $p->jenis_kelamin }} | {{ $p->pasien->umur ?? '-' }} Thn</div>
                                </td>
                                <td>
                                    @if($p->triage)
                                        <div class="small"><strong>TD:</strong> {{ $p->triage->tensi ?? '-' }} | <strong>N:</strong> {{ $p->triage->nadi ?? '-' }}</div>
                                        <div class="small"><strong>SPO2:</strong> {{ $p->triage->spo2 ?? '-' }}%</div>
                                    @else
                                        <span class="text-muted fst-italic">Menunggu Triase...</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $p->status }}</span>
                                </td>
                                <td class="text-end">
                                    @if(!$p->triage)
                                        <a href="{{ route('igd.triase', $p->id) }}" class="btn btn-info btn-sm text-white">
                                            <i class="bi-clipboard-pulse me-1"></i> Lakukan Triase
                                        </a>
                                    @else
                                        <a href="{{ route('pemeriksaan.create', ['pendaftaran_id' => $p->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="bi-stethoscope me-1"></i> Periksa
                                        </a>
                                    @endif
                                    <button class="btn btn-danger btn-sm ms-1 btn-delete" 
                                        data-id="{{ $p->id }}"
                                        data-name="{{ $p->nama }}">
                                        <i class="bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi-heart-pulse display-4 d-block mb-3 opacity-25"></i>
                                    Tidak ada pasien di IGD saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Single Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi-exclamation-triangle me-2"></i>Hapus Pasien IGD
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Apakah Anda yakin ingin menghapus pasien <strong id="delete_name"></strong> dari antrian IGD?</p>
                    <p class="text-danger small mb-0">
                        <i class="bi-info-circle me-1"></i>Data triase dan riwayat akan ikut terhapus.
                    </p>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi-trash me-1"></i>Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Delete Modal Handler
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        
        // Set form action
        document.getElementById('deleteForm').action = `/igd/${id}`;
        
        // Set patient name
        document.getElementById('delete_name').textContent = name;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});
</script>
@endpush
