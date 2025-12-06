@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-file-text"></i> Detail Tagihan</h1>
    <a href="{{ route('billing') }}" class="btn btn-secondary">
        <i class="bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    {{-- Bill Info --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 fw-bold">Informasi Tagihan</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">No Tagihan:</td><td class="fw-bold">{{ $tagihan->no_tagihan }}</td></tr>
                    <tr><td class="text-muted">Tanggal:</td><td>{{ $tagihan->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><td class="text-muted">Status:</td><td>
                        @if($tagihan->status_bayar == 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Bayar</span>
                        @endif
                    </td></tr>
                </table>
                
                <hr>
                
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Pasien:</td><td class="fw-bold">{{ $tagihan->pasien->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">No RM:</td><td>{{ $tagihan->pasien->no_rm ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Gender:</td><td>{{ $tagihan->pasien->jenis_kelamin ?? '-' }}</td></tr>
                </table>

                @if($tagihan->status_bayar == 'Lunas')
                <hr>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Metode Bayar:</td><td class="fw-bold">{{ $tagihan->metode_pembayaran }}</td></tr>
                    <tr><td class="text-muted">Tgl Bayar:</td><td>{{ $tagihan->paid_at ? $tagihan->paid_at->format('d/m/Y H:i') : '-' }}</td>  </tr>
                </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Bill Details --}}
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 fw-bold">Rincian Biaya</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($tagihan->details as $detail)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $detail->item_name }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($detail->item_type) }}</span></td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="table-light">
                                <td colspan="5" class="text-end fw-bold">TOTAL BIAYA:</td>
                                <td class="fw-bold text-danger">Rp {{ number_format($tagihan->total_biaya, 0, ',', '.') }}</td>
                            </tr>
                            @if($tagihan->status_bayar == 'Lunas')
                            <tr class="table-success">
                                <td colspan="5" class="text-end fw-bold">DIBAYAR:</td>
                                <td class="fw-bold">Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-info">
                                <td colspan="5" class="text-end fw-bold">KEMBALIAN:</td>
                                <td class="fw-bold">Rp {{ number_format($tagihan->kembalian, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if($tagihan->status_bayar == 'Lunas')
                <div class="mt-3 text-end">
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="bi-printer"></i> Cetak Invoice
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
