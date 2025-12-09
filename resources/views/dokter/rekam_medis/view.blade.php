@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-primary fw-bold mb-0">Rekam Medis Pasien</h2>
        <p class="text-muted mb-0">Pasien: <strong>{{ $pasien->nama }}</strong> ({{ $pasien->no_rm }})</p>
    </div>
    <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-secondary">Kembali</a>
</div>

<!-- Access Expiration Warning -->
@if($activeAccess)
    @php
        $hoursRemaining = $activeAccess->getTimeRemaining();
    @endphp
    @if($hoursRemaining < 2)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Perhatian!</strong> Akses Anda ke rekam medis ini akan segera kadaluarsa ({{ $activeAccess->getExpirationStatus() }}).
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Akses Anda berlaku hingga: {{ $activeAccess->expires_at->format('d M Y, H:i') }} ({{ $activeAccess->getExpirationStatus() }})
        </div>
    @endif
@endif

<div class="row">
    <div class="col-md-3">
        <div class="card shadow border-0 mb-3">
            <div class="card-body text-center">
                <div class="avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="bi-person fs-1 text-secondary"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $pasien->nama }}</h5>
                <p class="text-muted small">{{ $pasien->jenis_kelamin }} | {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Thn</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1 small"><strong>NIK:</strong> {{ $pasien->nik }}</p>
                    <p class="mb-1 small"><strong>BPJS:</strong> {{ $pasien->no_bpjs ?? '-' }}</p>
                    <p class="mb-1 small"><strong>Alamat:</strong> {{ $pasien->alamat }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <ul class="nav nav-tabs mb-3" id="emrTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#rawatJalan" type="button">Rawat Jalan</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rawatInap" type="button">Rawat Inap</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#laboratorium" type="button">Laboratorium</button>
            </li>
        </ul>

        <div class="tab-content">
            {{-- Rawat Jalan --}}
            <div class="tab-pane fade show active" id="rawatJalan">
                @forelse($pemeriksaan as $p)
                <div class="card shadow-sm border-0 mb-3 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-bold text-primary mb-0">Kunjungan Poli</h6>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</small>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 text-nowrap" 
                                        onclick="openEditModal({{ $p->id }}, {{ json_encode($p) }})">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                            </div>
                        </div>
                        <p class="mb-1"><strong>Diagnosa:</strong> {{ $p->diagnosis }} ({{ $p->icd_code }})</p>
                        <div class="bg-light p-2 rounded small">
                            <div><strong class="text-primary">S:</strong> {{ $p->subjective }}</div>
                            <div><strong class="text-success">O:</strong> {{ $p->objective }}</div>
                            <div><strong class="text-warning">A:</strong> {{ $p->assessment }}</div>
                            <div><strong class="text-danger">P:</strong> {{ $p->plan }}</div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-light text-center">Belum ada riwayat rawat jalan.</div>
                @endforelse
            </div>

            {{-- Rawat Inap --}}
            <div class="tab-pane fade" id="rawatInap">
                @forelse($rawatInap as $ri)
                <div class="card shadow-sm border-0 mb-3 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-bold text-warning mb-0">Rawat Inap</h6>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($ri->tanggal_masuk)->format('d M Y') }} - 
                                {{ $ri->tanggal_keluar ? \Carbon\Carbon::parse($ri->tanggal_keluar)->format('d M Y') : 'Sekarang' }}
                            </small>
                        </div>
                        <p class="mb-1"><strong>Kamar:</strong> {{ $ri->kamar }} ({{ $ri->no_kamar }})</p>
                        <p class="mb-2"><strong>Diagnosa Awal:</strong> {{ $ri->diagnosis }}</p>
                        
                        @if($ri->cppt->count() > 0)
                        <div class="accordion" id="acc{{ $ri->id }}">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-2 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#cppt{{ $ri->id }}">
                                        Lihat {{ $ri->cppt->count() }} Catatan CPPT
                                    </button>
                                </h2>
                                <div id="cppt{{ $ri->id }}" class="accordion-collapse collapse" data-bs-parent="#acc{{ $ri->id }}">
                                    <div class="accordion-body p-2">
                                        @foreach($ri->cppt as $cppt)
                                        <div class="border-bottom pb-2 mb-2">
                                            <small class="fw-bold d-block">{{ \Carbon\Carbon::parse($cppt->tanggal)->format('d M H:i') }}</small>
                                            <div class="small">S: {{ $cppt->subjective }} | O: {{ $cppt->objective }} | A: {{ $cppt->assessment }} | P: {{ $cppt->plan }}</div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="alert alert-light text-center">Belum ada riwayat rawat inap.</div>
                @endforelse
            </div>

            {{-- Laboratorium --}}
            <div class="tab-pane fade" id="laboratorium">
                @forelse($labRequests as $lab)
                <div class="card shadow-sm border-0 mb-3 border-start border-4 border-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-bold text-info mb-0">Pemeriksaan Lab</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($lab->created_at)->format('d M Y H:i') }}</small>
                        </div>
                        <p class="mb-1"><strong>Jenis:</strong> {{ implode(', ', $lab->jenis_pemeriksaan) }}</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-{{ $lab->status == 'completed' ? 'success' : 'secondary' }}">{{ $lab->status }}</span></p>
                        @if($lab->hasil)
                        <div class="bg-light p-2 rounded mt-2">
                            <strong>Hasil:</strong><br>
                            {!! nl2br(e($lab->hasil)) !!}
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="alert alert-light text-center">Belum ada riwayat laboratorium.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit SOAP (Single Instance) -->
<div class="modal fade" id="editSoapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSoapForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Subjective (Keluhan)</label>
                        <textarea id="edit_subjective" name="subjective" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Objective (Pemeriksaan Fisik)</label>
                        <textarea id="edit_objective" name="objective" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Assessment (Diagnosa Kerja)</label>
                        <textarea id="edit_assessment" name="assessment" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Plan (Rencana/Terapi)</label>
                        <textarea id="edit_plan" name="plan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Diagnosa Utama</label>
                                <input type="text" id="edit_diagnosis" name="diagnosis" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kode ICD-10</label>
                                <input type="text" id="edit_icd_code" name="icd_code" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, data) {
        // Set Action URL
        const form = document.getElementById('editSoapForm');
        form.action = `/pemeriksaan/update/${id}`;

        // Populate Fields
        document.getElementById('edit_subjective').value = data.subjective || '';
        document.getElementById('edit_objective').value = data.objective || '';
        document.getElementById('edit_assessment').value = data.assessment || '';
        document.getElementById('edit_plan').value = data.plan || '';
        document.getElementById('edit_diagnosis').value = data.diagnosis || '';
        document.getElementById('edit_icd_code').value = data.icd_code || '';

        // Show Modal
        const myModal = new bootstrap.Modal(document.getElementById('editSoapModal'));
        myModal.show();
    }
</script>
        </div>
    </div>
</div>
@endsection
