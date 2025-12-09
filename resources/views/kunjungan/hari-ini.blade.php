@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kunjungan Hari Ini</h1>
    <span class="badge bg-primary fs-6">{{ $tanggal }}</span>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Kunjungan</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">{{ $statistik['total'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi-calendar-check-fill fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Menunggu</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">{{ $statistik['menunggu'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi-hourglass-split fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Sedang Diperiksa</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">{{ $statistik['sedang_diperiksa'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi-activity fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-start-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Selesai</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">{{ $statistik['selesai'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi-check-circle-fill fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h4 class="m-0 fw-bold text-primary">Daftar Kunjungan</h4>
        <a href="{{ route('kunjungan.refresh') }}" class="btn btn-sm btn-warning text-white">
            <i class="bi-arrow-clockwise me-1"></i> Refresh
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('kunjungan.filter') }}" method="POST" class="row mb-3">
            @csrf
            <div class="col-md-4">
                <select name="poliklinik" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Poliklinik</option>
                    @foreach(config('poli.options') as $poli)
                        <option value="{{ $poli }}" {{ request('poliklinik') == $poli ? 'selected' : '' }}>{{ $poli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diperiksa" {{ request('status') == 'Diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Antrean</th>
                        <th>Waktu</th>
                        <th>No. RM</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kunjungan as $k)
                    <tr>
                        <td><span class="badge bg-primary">{{ $k->no_antrian }}</span></td>
                        <td>{{ $k->created_at->format('H:i') }}</td>
                        <td>{{ $k->pasien->no_rm ?? '-' }}</td>
                        <td>{{ $k->pasien->nama ?? '-' }}</td>
                        <td>{{ $k->poli ?? '-' }}</td>
                        <td>
                            @if($k->status == 'Menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($k->status == 'Diperiksa')
                                <span class="badge bg-info">Sedang Diperiksa</span>
                            @elseif($k->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ $k->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if($k->status == 'Menunggu' || $k->status == 'Diperiksa')
                                <a href="{{ route('pemeriksaan.soap', $k->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi-play-fill"></i> Panggil
                                </a>
                            @elseif($k->status == 'Selesai')
                                @php
                                    $pemeriksaan = \App\Models\Pemeriksaan::where('pendaftaran_id', $k->id)->first();
                                @endphp
                                @if($pemeriksaan)
                                    <a href="{{ route('pemeriksaan.print', $pemeriksaan->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Hasil">
                                        <i class="bi-eye-fill"></i> Detail
                                    </a>
                                @else
                                    <span class="text-muted small">Belum ada data</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada kunjungan hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection