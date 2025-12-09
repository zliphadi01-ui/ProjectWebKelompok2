@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Ajukan Akses Rekam Medis</h2>
            <p class="text-muted mb-0">Isi form di bawah untuk mengajukan akses ke rekam medis pasien</p>
        </div>
        <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Patient Info -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-person me-2"></i>Informasi Pasien</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person fs-1 text-secondary"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $pasien->nama }}</h5>
                        <p class="text-muted small mb-0">{{ $pasien->jenis_kelamin }} | {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</p>
                    </div>
                    <hr>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted"><strong>No. RM:</strong></td>
                            <td>{{ $pasien->no_rm }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><strong>NIK:</strong></td>
                            <td>{{ $pasien->nik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><strong>Tanggal Lahir:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><strong>Telepon:</strong></td>
                            <td>{{ $pasien->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><strong>Alamat:</strong></td>
                            <td>{{ $pasien->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Request Form -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 fw-bold">Formulir Permintaan Akses</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dokter.rekam-medis.submit') }}">
                        @csrf
                        <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Informasi:</strong> Setelah permintaan Anda disetujui oleh staff rekam medis, 
                            akses akan berlaku selama <strong>24 jam</strong> sejak persetujuan.
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">
                                Alasan Permintaan Akses <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                class="form-control @error('keterangan') is-invalid @enderror" 
                                id="keterangan" 
                                name="keterangan" 
                                rows="5" 
                                placeholder="Jelaskan alasan Anda memerlukan akses ke rekam medis pasien ini..."
                                required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Maksimal 500 karakter. Jelaskan secara singkat dan jelas mengapa Anda memerlukan akses.
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Kirim Permintaan
                            </button>
                            <a href="{{ route('dokter.rekam-medis.patients') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="card border-warning border-2 mt-3">
                <div class="card-body">
                    <h6 class="text-warning fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>Perhatian
                    </h6>
                    <ul class="mb-0 small">
                        <li>Permintaan Anda akan ditinjau oleh staff rekam medis</li>
                        <li>Pastikan alasan yang Anda berikan relevan dan jelas</li>
                        <li>Akses yang disetujui hanya berlaku selama 24 jam</li>
                        <li>Anda dapat melihat status permintaan di menu "Permintaan Saya"</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
