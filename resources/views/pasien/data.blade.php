@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Pasien</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pasien</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pasien
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('pasien.data') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="q" class="form-control"
                                   placeholder="Cari nama, No. RM, atau NIK..."
                                   value="{{ request('q') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('pasien.data') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="10%">No. RM</th>
                            <th width="25%">Nama Pasien</th>
                            <th width="15%">NIK</th>
                            <th width="15%">Tanggal Lahir</th>
                            <th width="10%">Jenis Kelamin</th>
                            <th width="15%">Telepon</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien ?? [] as $p)
                        <tr>
                            <td><strong class="text-primary">{{ $p->no_rm }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                         style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($p->nama ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $p->nama }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $p->nik ?? '-' }}</td>
                            <td>{{ $p->tanggal_lahir ? date('d/m/Y', strtotime($p->tanggal_lahir)) : '-' }}</td>
                            <td>
                                @if($p->jenis_kelamin == 'L')
                                <span class="badge bg-info">Laki-laki</span>
                                @else
                                <span class="badge bg-danger">Perempuan</span>
                                @endif
                            </td>
                            <td>{{ $p->telepon ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pasien.edit', $p->id) }}" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users-slash fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Tidak Ada Data Pasien</h5>
                                <p class="text-muted">Silakan tambah pasien baru</p>
                                <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Pasien
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($pasien) && $pasien->hasPages())
            <div class="mt-4">
                {{ $pasien->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
