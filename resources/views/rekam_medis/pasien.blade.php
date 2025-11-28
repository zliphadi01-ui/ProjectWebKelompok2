@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Data Pasien (EMR)</h2>
    <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('rekam-medis.pasien') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama, No RM, atau NIK..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="bi-search"></i> Cari</button>
        </form>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Tgl Lahir / Umur</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasien as $p)
                    <tr>
                        <td class="fw-bold text-primary">{{ $p->no_rm }}</td>
                        <td class="fw-bold">{{ $p->nama }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>
                            {{ $p->tanggal_lahir }} <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} Thn</small>
                        </td>
                        <td>{{ Str::limit($p->alamat, 30) }}</td>
                        <td class="text-end">
                            <a href="{{ route('rekam-medis.riwayat', $p->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="bi-clock-history me-1"></i> Lihat Riwayat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            Data pasien tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $pasien->withQueryString()->links() }}
    </div>
</div>
@endsection
