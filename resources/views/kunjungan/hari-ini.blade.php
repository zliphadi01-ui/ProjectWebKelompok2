@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kunjungan Hari Ini</h1>
    <span class="badge bg-primary fs-6">{{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}</span>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-start-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Kunjungan</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">45</div>
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
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Menunggu</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">12</div>
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
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Sedang Diperiksa</div>
                        <div class="h4 mb-0 fw-bold text-gray-800">3</div>
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
                        <div class="h4 mb-0 fw-bold text-gray-800">30</div>
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
        <h6 class="m-0 fw-bold text-primary">Daftar Kunjungan</h6>
        <button class="btn btn-sm btn-success">
            <i class="bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <select class="form-select">
                    <option value="">Semua Poliklinik</option>
                    <option>Poli Umum</option>
                    <option>Poli Gigi</option>
                    <option>Poli Anak</option>
                    <option>Poli Kebidanan</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diperiksa">Sedang Diperiksa</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
        </div>

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
                    <tr>
                        <td><span class="badge bg-primary">A-01</span></td>
                        <td>08:15</td>
                        <td>12-34-56</td>
                        <td>Budi Santoso</td>
                        <td>Poli Umum</td>
                        <td><span class="badge bg-warning">Menunggu</span></td>
                        <td>
                            <a href="{{ url('/pemeriksaan/soap') }}" class="btn btn-sm btn-primary">
                                <i class="bi-play-fill"></i> Panggil
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-primary">G-01</span></td>
                        <td>08:22</td>
                        <td>11-22-33</td>
                        <td>Citra Lestari</td>
                        <td>Poli Gigi</td>
                        <td><span class="badge bg-info">Sedang Diperiksa</span></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled>
                                <i class="bi-play-fill"></i> Panggil
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-primary">A-02</span></td>
                        <td>08:30</td>
                        <td>22-11-44</td>
                        <td>Ahmad Rizki</td>
                        <td>Poli Umum</td>
                        <td><span class="badge bg-warning">Menunggu</span></td>
                        <td>
                            <a href="{{ url('/pemeriksaan/soap') }}" class="btn btn-sm btn-primary">
                                <i class="bi-play-fill"></i> Panggil
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-primary">U-01</span></td>
                        <td>08:45</td>
                        <td>33-55-77</td>
                        <td>Siti Nurhaliza</td>
                        <td>Poli Umum</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <button class="btn btn-sm btn-info" title="Lihat Hasil">
                                <i class="bi-eye-fill"></i> Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection