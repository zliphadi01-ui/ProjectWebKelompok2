
<!-- Medical History Modal -->
<div class="modal fade" id="medicalHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-file-medical"></i> Riwayat Rekam Medis - {{ $pasien->nama }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#historyRJ">Rawat Jalan</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historyRI">Rawat Inap</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historyLab">Lab</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="historyRJ">
                        @forelse($pemeriksaanHistory as $p)
                        <div class="card mb-2 border-start border-primary border-3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-primary mb-2">Kunjungan Poli</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</small>
                                </div>
                                <p class="mb-1"><strong>Diagnosa:</strong> {{ $p->diagnosis }}</p>
                                <div class="bg-light p-2 rounded small">
                                    <div><strong>S:</strong> {{ $p->subjective }}</div>
                                    <div><strong>O:</strong> {{ $p->objective }}</div>
                                    <div><strong>P:</strong> {{ $p->plan }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-light text-center">Belum ada riwayat rawat jalan</div>
                        @endforelse
                    </div>

                    <div class="tab-pane fade" id="historyRI">
                        @forelse($rawatInapHistory as $ri)
                        <div class="card mb-2 border-start border-warning border-3">
                            <div class="card-body p-3">
                                <p class="mb-1"><strong>Kamar:</strong> {{ $ri->kamar }} ({{ $ri->no_kamar }})</p>
                                <p class="mb-0"><strong>Diagnosa:</strong> {{ $ri->diagnosis }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-light text-center">Belum ada riwayat rawat inap</div>
                        @endforelse
                    </div>

                    <div class="tab-pane fade" id="historyLab">
                        @forelse($labHistory as $lab)
                        <div class="card mb-2 border-start border-info border-3">
                            <div class="card-body p-3">
                                <p class="mb-1"><strong>Jenis:</strong> {{ $lab->jenis_pemeriksaan }}</p>
                                @if($lab->hasil)
                                <div class="bg-light p-2 rounded small mt-2">
                                    <strong>Hasil:</strong><br>
                                    {!! nl2br(e($lab->hasil)) !!}
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-light text-center">Belum ada riwayat laboratorium</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
