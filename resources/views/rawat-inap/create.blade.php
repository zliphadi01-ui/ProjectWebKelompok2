@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Penerimaan Pasien Rawat Inap</h2>
        <a href="{{ route('rawat-inap.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <form action="{{ route('rawat-inap.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pilih Pasien</label>
                        <select name="pasien_id" class="form-select" required>
                            <option value="">-- Cari Pasien --</option>
                            @foreach($pasien as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rm }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya menampilkan 200 pasien teratas.</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pilih Bed Tersedia</label>
                        <select name="bed_id" class="form-select" required>
                            <option value="">-- Pilih Bed --</option>
                            @foreach($beds as $bed)
                                <option value="{{ $bed->id }}" {{ request('bed_id') == $bed->id ? 'selected' : '' }}>
                                    {{ $bed->nama_kamar }} - Bed {{ $bed->no_bed }} (Kelas {{ $bed->kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Diagnosa Awal</label>
                        <textarea name="diagnosis" class="form-control" rows="2" placeholder="Diagnosa masuk..."></textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Catatan Tambahan</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Instruksi awal..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi-save me-2"></i> Simpan & Masukkan Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
