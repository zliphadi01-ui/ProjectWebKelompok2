@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Medis (SOAP)</h1>
    <a href="javascript:(history.length>1?history.back():window.location.href='{{ url('/dashboard') }}')" class="btn btn-secondary">
        <i class="bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="m-0">Data Pasien</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="150" class="fw-bold">No. RM</td>
                        <td>: <span class="text-primary fw-bold">{{ $pasien->no_rm ?? '-' }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nama</td>
                        <td>: <strong>{{ $pasien->nama ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Jenis Kelamin</td>
                        <td>: {{ $pasien->jenis_kelamin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Golongan Darah</td>
                        <td>: {{ $pasien->golongan_darah ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="150" class="fw-bold">Tanggal Lahir</td>
                        <td>: {{ $pasien->tanggal_lahir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Alamat</td>
                        <td>: {{ $pasien->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">No. Telepon</td>
                        <td>: {{ $pasien->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Alergi</td>
                        <td>: <span class="text-danger">{{ $pasien->alergi ?? '-' }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 fw-bold text-primary">Form SOAP - Catatan Medis</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pemeriksaan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id ?? '' }}">
            <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">
            
            {{-- SUBJECTIVE --}}
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 32px; height: 32px; font-weight: bold;">S</div>
                    <label class="form-label fw-bold mb-0">Subjective - Keluhan Pasien</label>
                </div>
                <textarea class="form-control" name="subjective" rows="3" 
                          placeholder="Keluhan yang disampaikan pasien (anamnesis)..." required></textarea>
                <small class="text-muted">Contoh: Pasien mengeluh demam sejak 3 hari yang lalu, disertai batuk dan pilek</small>
            </div>

            {{-- OBJECTIVE --}}
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 32px; height: 32px; font-weight: bold;">O</div>
                    <label class="form-label fw-bold mb-0">Objective - Hasil Pemeriksaan</label>
                </div>
                
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Tanda Vital</h6>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label small">Tekanan Darah</label>
                                <div class="input-group input-group-sm">
                                   <input type="text" class="form-control" name="tekanan_darah" placeholder="120/80">
                                    <span class="input-group-text">mmHg</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Nadi</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="nadi" placeholder="80">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Suhu</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="suhu" placeholder="36.5">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Pernapasan</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="20">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-3">
                                <label class="form-label small">Berat Badan</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="berat_badan" placeholder="70">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Tinggi Badan</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="170">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Saturasi O2</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="98">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <textarea class="form-control" name="objective" rows="3" 
                          placeholder="Hasil pemeriksaan fisik dan penunjang..." required></textarea>
                <small class="text-muted">Contoh: Kepala/Leher: tidak ada kelainan. Thorax: suara napas vesikuler, ronki (+/+)</small>
            </div>

            {{-- ASSESSMENT --}}
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 32px; height: 32px; font-weight: bold;">A</div>
                    <label class="form-label fw-bold mb-0">Assessment - Diagnosis</label>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label small">Kode ICD-10</label>
                        <input type="text" class="form-control" name="icd_code" placeholder="Contoh: J06.9">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label small">Nama Diagnosis</label>
                        <input type="text" class="form-control" name="diagnosis" 
                               placeholder="Contoh: Infeksi saluran pernapasan akut" required>
                    </div>
                </div>
                
                <textarea class="form-control" name="assessment" rows="2" 
                          placeholder="Catatan tambahan diagnosis..."></textarea>
            </div>

            {{-- PLAN --}}
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                         style="width: 32px; height: 32px; font-weight: bold;">P</div>
                    <label class="form-label fw-bold mb-0">Plan - Rencana Tindakan</label>
                </div>
                
                <div class="card bg-light mb-2">
                    <div class="card-body">
                        <h6 class="card-title">Resep Obat</h6>
                        <div id="resepContainer">
                            <div class="row g-2 mb-2 resep-item">
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" placeholder="Nama Obat">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Dosis">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control form-control-sm" placeholder="Jumlah">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm">
                                        <option>Tablet</option>
                                        <option>Kapsul</option>
                                        <option>Sirup</option>
                                        <option>Salep</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="this.parentElement.parentElement.remove()">
                                        <i class="bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="tambahResep()">
                            <i class="bi-plus-circle me-1"></i> Tambah Obat
                        </button>
                    </div>
                </div>
                
                <textarea class="form-control" name="plan" rows="3" 
                          placeholder="Rencana pengobatan, edukasi, dan tindak lanjut..." required></textarea>
                <small class="text-muted">Contoh: Istirahat cukup, minum air putih banyak, kontrol 3 hari lagi jika keluhan tidak membaik</small>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi-save-fill me-1"></i> Simpan SOAP
                </button>
                <button type="submit" formaction="{{ route('pemeriksaan.store-print') }}" formmethod="post" class="btn btn-info px-4">
                    <i class="bi-printer-fill me-1"></i> Simpan & Cetak
                </button>
                <button type="reset" class="btn btn-secondary px-4">
                    <i class="bi-x-circle-fill me-1"></i> Reset
                </button>
                <a href="javascript:(history.length>1?history.back():window.location.href='{{ url('/dashboard') }}')" class="btn btn-outline-secondary px-4">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function tambahResep() {
    const container = document.getElementById('resepContainer');
    const newItem = `
        <div class="row g-2 mb-2 resep-item">
            <div class="col-md-5">
                <input type="text" class="form-control form-control-sm" placeholder="Nama Obat">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" placeholder="Dosis">
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control form-control-sm" placeholder="Jumlah">
            </div>
            <div class="col-md-2">
                <select class="form-select form-select-sm">
                    <option>Tablet</option>
                    <option>Kapsul</option>
                    <option>Sirup</option>
                    <option>Salep</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger w-100" onclick="this.parentElement.parentElement.remove()">
                    <i class="bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newItem);
}
</script>
@endpush