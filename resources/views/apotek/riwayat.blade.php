@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-clock-history"></i> Riwayat Resep</h1>
</div>

<div class="card shadow">
    <div class="card-header bg-success text-white py-3">
        <h6 class="m-0 fw-bold">Resep yang Sudah Selesai</h6>
    </div>
    <div class="card-body">
        @if($reseps->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="8%">No Resep</th>
                            <th width="20%">Pasien</th>
                            <th width="12%">No RM</th>
                            <th width="18%">Dokter</th>
                            <th width="12%">Tgl Resep</th>
                            <th width="12%">Tgl Selesai</th>
                            <th width="10%">Status</th>
                            <th width="8%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reseps as $resep)
                        <tr>
                            <td><strong>RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $resep->pasien->nama ?? '-' }}</td>
                            <td>{{ $resep->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $resep->dokter->name ?? '-' }}</td>
                            <td>{{ $resep->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $resep->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                            <td>
                                <a href="{{ route('apotek.resep.detail', $resep->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $reseps->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Belum ada riwayat resep yang diselesaikan.
            </div>
        @endif
    </div>
</div>
@endsection
