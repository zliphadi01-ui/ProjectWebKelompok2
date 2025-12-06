@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-prescription2"></i> Apotek - Daftar Resep</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow">
    <div class="card-header bg-danger text-white py-3">
        <h6 class="m-0 fw-bold">Resep Menunggu & Diproses</h6>
    </div>
    <div class="card-body">
        @if($reseps->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="12%">No Resep</th>
                            <th width="20%">Pasien</th>
                            <th width="15%">No RM</th>
                            <th width="18%">Dokter</th>
                            <th width="12%">Tanggal</th>
                            <th width="10%">Status</th>
                            <th width="8%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reseps as $index => $resep)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $resep->pasien->nama ?? '-' }}</td>
                            <td>{{ $resep->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $resep->dokter->name ?? '-' }}</td>
                            <td>{{ $resep->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($resep->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($resep->status == 'Diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('apotek.resep.detail', $resep->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Belum ada resep yang menunggu atau sedang diproses.
            </div>
        @endif
    </div>
</div>
@endsection
