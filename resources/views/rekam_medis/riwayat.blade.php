@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-primary fw-bold mb-0">Riwayat Medis (EMR)</h2>
        <p class="text-muted mb-0">Pasien: <strong>{{ $pasien->nama }}</strong> ({{ $pasien->no_rm }})</p>
    </div>
    <a href="{{ route('rekam-medis.pasien') }}" class="btn btn-secondary">Kembali</a>
</div>

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
                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</small>
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
                        <p class="mb-1"><strong>Jenis:</strong> {{ $lab->jenis_pemeriksaan }}</p>
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
@endsection
