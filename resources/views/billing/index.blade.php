@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-receipt"></i> Billing - Semua Tagihan</h1>
</div>

<div class="card shadow">
    <div class="card-header bg-info text-white">
        <h6 class="m-0 fw-bold">Daftar Tagihan & Invoice</h6>
    </div>
    <div class="card-body">
        @if($tagihans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">No Tagihan</th>
                            <th width="18%">Pasien</th>
                            <th width="10%">No RM</th>
                            <th width="12%">Tanggal</th>
                            <th width="13%">Total Biaya</th>
                            <th width="13%">Metode Bayar</th>
                            <th width="12%">Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihans as $tagihan)
                        <tr>
                            <td><strong>{{ $tagihan->no_tagihan }}</strong></td>
                            <td>{{ $tagihan->pasien->nama ?? '-' }}</td>
                            <td>{{ $tagihan->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $tagihan->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($tagihan->total_biaya, 0, ',', '.') }}</td>
                            <td>{{ $tagihan->metode_pembayaran ?? '-' }}</td>
                            <td>
                                @if($tagihan->status_bayar == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($tagihan->status_bayar == 'Dibatalkan')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('billing.detail', $tagihan->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $tagihans->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Belum ada data tagihan.
            </div>
        @endif
    </div>
</div>
@endsection
