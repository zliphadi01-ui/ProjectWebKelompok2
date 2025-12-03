@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-search"></i> Pencarian Pasien</h4>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="{{ route('pasien.pencarian') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Cari (Nama, No RM, NIK)</label>
                                <input type="text" name="q" class="form-control"
                                       placeholder="Masukkan Nama, No RM, atau NIK" value="{{ request('q') }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search"></i> Cari Pasien
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            @if(isset($results))
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Hasil Pencarian ({{ count($results) }} pasien)</h5>
                </div>
                <div class="card-body">
                    @forelse($results as $p)
                    <div class="card mb-3 border">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h5 class="mb-1">{{ $p->nama }}</h5>
                                    <p class="mb-0 text-muted">
                                        <strong>No. RM:</strong> {{ $p->no_rm }} |
                                        <strong>NIK:</strong> {{ $p->nik }} |
                                        <strong>TTL:</strong> {{ date('d/m/Y', strtotime($p->tanggal_lahir)) }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('pendaftaran.create-baru') }}?pasien_id={{ $p->id }}" class="btn btn-success">
                                        <i class="fas fa-calendar-plus"></i> Daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">Pasien Tidak Ditemukan</h5>
                        <p class="text-muted">Silakan gunakan kriteria pencarian yang berbeda</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
