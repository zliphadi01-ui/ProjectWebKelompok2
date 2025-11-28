@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-primary fw-bold mb-0">{{ $item->pasien->nama }}</h2>
        <p class="text-muted mb-0">RM: {{ $item->pasien->no_rm }} | Bed: {{ $item->bed->nama_kamar ?? '-' }} ({{ $item->bed->no_bed ?? '-' }})</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('rawat-inap.index') }}" class="btn btn-secondary">Kembali</a>
        @if($item->status == 'Dirawat')
        <form action="{{ route('rawat-inap.discharge', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memulangkan pasien ini? Bed akan menjadi kosong.');">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger">
                <i class="bi-box-arrow-right me-2"></i> Pulangkan Pasien
            </button>
        </form>
        @endif
    </div>
</div>

<div class="row">
    {{-- Info Pasien --}}
    <div class="col-md-3 mb-4">
        <div class="card shadow border-0 mb-3">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 fw-bold">Info Pasien</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>Gender:</strong> {{ $item->pasien->jenis_kelamin }}</li>
                    <li class="mb-2"><strong>Tgl Lahir:</strong> {{ $item->pasien->tanggal_lahir }}</li>
                    <li class="mb-2"><strong>Masuk:</strong> {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y H:i') }}</li>
                    <li class="mb-2"><strong>Status:</strong> <span class="badge bg-{{ $item->status == 'Dirawat' ? 'primary' : 'secondary' }}">{{ $item->status }}</span></li>
                </ul>
            </div>
        </div>
        
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark">
                <h6 class="m-0 fw-bold">Diagnosa Awal</h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $item->diagnosis ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- CPPT (Catatan Perkembangan Pasien Terintegrasi) --}}
    <div class="col-md-9">
        <div class="card shadow border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 fw-bold text-primary">CPPT (Catatan Perkembangan Pasien Terintegrasi)</h6>
                @if($item->status == 'Dirawat')
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCppt">
                    <i class="bi-plus-circle me-1"></i> Tambah Catatan (Visite)
                </button>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 15%;">Waktu / PPA</th>
                                <th>Catatan (SOAP)</th>
                                <th style="width: 20%;">Instruksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($item->cppt as $cppt)
                            <tr>
                                <td>
                                    <small class="fw-bold d-block">{{ \Carbon\Carbon::parse($cppt->tanggal)->format('d M Y H:i') }}</small>
                                    <span class="badge bg-info text-dark">{{ $cppt->dokter->name ?? 'Dokter' }}</span>
                                </td>
                                <td>
                                    <div class="mb-1"><strong class="text-primary">S:</strong> {{ $cppt->subjective }}</div>
                                    <div class="mb-1"><strong class="text-success">O:</strong> {{ $cppt->objective }}</div>
                                    <div class="mb-1"><strong class="text-warning">A:</strong> {{ $cppt->assessment }}</div>
                                    <div class="mb-0"><strong class="text-danger">P:</strong> {{ $cppt->plan }}</div>
                                </td>
                                <td>
                                    {{ $cppt->instruksi_ppa ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Belum ada catatan CPPT.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Add CPPT --}}
<div class="modal fade" id="modalCppt" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('rawat-inap.cppt.store', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan Perkembangan (Visite)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold text-primary">S - Subjective</label>
                        <textarea name="subjective" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-success">O - Objective</label>
                        <textarea name="objective" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-warning">A - Assessment</label>
                        <textarea name="assessment" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-danger">P - Plan</label>
                        <textarea name="plan" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Instruksi PPA (Opsional)</label>
                        <textarea name="instruksi_ppa" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
