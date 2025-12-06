@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-cash-coin"></i> Kasir - Pembayaran</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow">
    <div class="card-header bg-success text-white">
        <h6 class="m-0 fw-bold">Tagihan Belum Dibayar</h6>
    </div>
    <div class="card-body">
        @if($tagihans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="12%">No Tagihan</th>
                            <th width="20%">Pasien</th>
                            <th width="12%">No RM</th>
                            <th width="12%">Tanggal</th>
                            <th width="15%">Total Biaya</th>
                            <th width="12%">Status</th>
                            <th width="17%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihans as $tagihan)
                        <tr>
                            <td><strong>{{ $tagihan->no_tagihan }}</strong></td>
                            <td>{{ $tagihan->pasien->nama ?? '-' }}</td>
                            <td>{{ $tagihan->pasien->no_rm ?? '-' }}</td>
                            <td>{{ $tagihan->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong class="text-danger">Rp {{ number_format($tagihan->total_biaya, 0, ',', '.') }}</strong></td>
                            <td><span class="badge bg-warning text-dark">Belum Bayar</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payModal{{ $tagihan->id }}">
                                    <i class="bi-cash"></i> Bayar
                                </button>
                            </td>
                        </tr>

                        {{-- Payment Modal --}}
                        <div class="modal fade" id="payModal{{ $tagihan->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Proses Pembayaran</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('kasir.process-payment', $tagihan->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="fw-bold">Pasien:</label>
                                                <p>{{ $tagihan->pasien->nama ?? '-' }} ({{ $tagihan->pasien->no_rm ?? '-' }})</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">No Tagihan:</label>
                                                <p>{{ $tagihan->no_tagihan }}</p>
                                            </div>
                                            <div class="mb-3 p-3 bg-light rounded">
                                                <label class="fw-bold">Total Biaya:</label>
                                                <h4 class="text-danger">Rp {{ number_format($tagihan->total_biaya, 0, ',', '.') }}</h4>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">Metode Pembayaran: <span class="text-danger">*</span></label>
                                                <select name="metode_pembayaran" class="form-select" required>
                                                    <option value="">-- Pilih Metode --</option>
                                                    <option value="Tunai">Tunai</option>
                                                    <option value="Transfer Bank">Transfer Bank</option>
                                                    <option value="Debit Card">Debit Card</option>
                                                    <option value="BPJS">BPJS</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">Jumlah Bayar: <span class="text-danger">*</span></label>
                                                <input type="number" name="total_bayar" class="form-control" min="{{ $tagihan->total_biaya }}" step="0.01" required placeholder="Rp">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi-check-circle"></i> Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Tidak ada tagihan yang menunggu pembayaran.
            </div>
        @endif
    </div>
</div>
@endsection
