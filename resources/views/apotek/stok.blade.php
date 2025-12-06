@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-boxes"></i> Stok Obat</h1>
</div>

<div class="card shadow">
    <div class="card-header bg-primary text-white py-3">
        <h6 class="m-0 fw-bold">Daftar Obat & Stok</h6>
    </div>
    <div class="card-body">
        @if($obats->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">Kode Obat</th>
                            <th width="30%">Nama Obat</th>
                            <th width="12%">Kategori</th>
                            <th width="10%">Stok</th>
                            <th width="8%">Satuan</th>
                            <th width="12%">Harga Jual</th>
                            <th width="11%">Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($obats as $index => $obat)
                        <tr class="{{ $obat->stok <= 10 ? 'table-warning' : ($obat->stok == 0 ? 'table-danger' : '') }}">
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $obat->kode_obat }}</strong></td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->kategori ?? '-' }}</td>
                            <td>
                                <strong class="{{ $obat->stok == 0 ? 'text-danger' : ($obat->stok <= 10 ? 'text-warning' : 'text-success') }}">
                                    {{ $obat->stok }}
                                </strong>
                            </td>
                            <td>{{ $obat->satuan }}</td>
                            <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                @if($obat->expired_date)
                                    {{ \Carbon\Carbon::parse($obat->expired_date)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <div class="alert alert-info">
                    <i class="bi-info-circle"></i> 
                    <strong>Keterangan:</strong>
                    <span class="badge bg-danger">Merah</span> = Stok habis | 
                    <span class="badge bg-warning text-dark">Kuning</span> = Stok menipis (≤10)
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Belum ada data obat. Silakan tambahkan melalui seeder atau manual.
            </div>
        @endif
    </div>
</div>
@endsection
