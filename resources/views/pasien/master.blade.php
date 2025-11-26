@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-primary fw-bold mb-0">Master Data Pasien</h2>
        <p class="text-muted mb-0">Kelola seluruh data rekam medis pasien.</p>
    </div>
    <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-lg shadow-sm">
        <i class="bi-person-plus-fill me-2"></i> Tambah Pasien Baru
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('pasien.master') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 bg-light" placeholder="Cari Nama, No. RM, atau NIK..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select bg-light">
                    <option value="">Semua Gender</option>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select bg-light">
                    <option value="newest">Terbaru Ditambahkan</option>
                    <option value="name_asc">Nama (A-Z)</option>
                    <option value="name_desc">Nama (Z-A)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4 py-3">Pasien</th>
                        <th>No. RM / NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasien as $p)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $p->nama }}</h6>
                                    <small class="text-muted">Terdaftar: {{ $p->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">{{ $p->no_rm }}</div>
                            <small class="text-muted">{{ $p->nik ?? '-' }}</small>
                        </td>
                        <td>
                            @if($p->jenis_kelamin == 'L')
                                <span class="badge bg-info bg-opacity-10 text-info"><i class="bi-gender-male me-1"></i> Laki-Laki</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger"><i class="bi-gender-female me-1"></i> Perempuan</span>
                            @endif
                        </td>
                        <td>
                            {{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d M Y') : '-' }}
                            <br>
                            <small class="text-muted">
                                ({{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->age . ' Thn' : '-' }})
                            </small>
                        </td>
                        <td class="text-truncate" style="max-width: 200px;">
                            {{ $p->alamat ?? '-' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li><a class="dropdown-item" href="{{ route('pasien.show', $p->id) }}"><i class="bi-eye me-2 text-primary"></i> Detail</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pasien.edit', $p->id) }}"><i class="bi-pencil me-2 text-warning"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('pasien.destroy', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus pasien ini?')">
                                                <i class="bi-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi-people fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada data pasien.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $pasien->links() }}
    </div>
</div>
@endsection
