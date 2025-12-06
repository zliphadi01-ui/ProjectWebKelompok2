@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="bi-prescription2"></i> Detail Resep</h1>
    <a href="{{ route('apotek') }}" class="btn btn-secondary">
        <i class="bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    {{-- Patient & Doctor Info --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 fw-bold"><i class="bi-person-circle"></i> Informasi Pasien</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Nama:</td><td class="fw-bold">{{ $resep->pasien->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">No RM:</td><td class="fw-bold">{{ $resep->pasien->no_rm ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Gender:</td><td>{{ $resep->pasien->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Umur:</td><td>{{ $resep->pasien->tanggal_lahir ? \Carbon\Carbon::parse($resep->pasien->tanggal_lahir)->age . ' Tahun' : '-' }}</td></tr>
                </table>
                
                <hr>
                
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted">Dokter:</td><td class="fw-bold">{{ $resep->dokter->name ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Tanggal:</td><td>{{ $resep->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><td class="text-muted">No Resep:</td><td class="fw-bold text-primary">RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Medication List --}}
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h6 class="m-0 fw-bold"><i class="bi-capsule"></i> Daftar Obat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Dosis</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($resep->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $detail->obat->nama_obat ?? '-' }}</strong></td>
                                <td>{{ $detail->dosis }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @php $total += $detail->subtotal; @endphp
                            @endforeach
                            <tr class="table-light">
                                <td colspan="5" class="text-end fw-bold">TOTAL:</td>
                                <td class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Status Update Form --}}
                <div class="mt-4 p-3 bg-light border rounded">
                    <h6 class="fw-bold mb-3"><i class="bi-clipboard-check"></i> Update Status Resep</h6>
                    <form action="{{ route('apotek.resep.updateStatus', $resep->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="fw-bold">Status Saat Ini:</label>
                            @if($resep->status == 'Menunggu')
                                <span class="badge bg-warning text-dark ms-2">Menunggu</span>
                            @elseif($resep->status == 'Diproses')
                                <span class="badge bg-info ms-2">Diproses</span>
                            @else
                                <span class="badge bg-success ms-2">Selesai</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Ubah Status:</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Menunggu" {{ $resep->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diproses" {{ $resep->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $resep->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi-check-circle"></i> Update Status
                            </button>
                            @if($resep->status != 'Selesai')
                            <button type="button" class="btn btn-success" onclick="document.querySelector('select[name=status]').value='Selesai'; this.closest('form').submit();">
                                <i class="bi-check2-all"></i> Tandai Selesai
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
