@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Laboratorium</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRequestLab">
        <i class="bi-plus-circle me-2"></i> Permintaan Baru
    </button>
</div>

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #4e73df, #224abe);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Total Permintaan</h6>
                        <h2 class="mb-0 fw-bold">{{ $total }}</h2>
                    </div>
                    <i class="bi-clipboard-data fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Selesai Diperiksa</h6>
                        <h2 class="mb-0 fw-bold">{{ $completed }}</h2>
                    </div>
                    <i class="bi-check-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Menunggu Hasil</h6>
                        <h2 class="mb-0 fw-bold">{{ $pending }}</h2>
                    </div>
                    <i class="bi-hourglass-split fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Pemeriksaan Lab</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Dokter Pengirim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $req->created_at->format('H:i') }}</td>
                        <td class="fw-bold">{{ $req->pasien->nama ?? 'Umum' }}</td>
                        <td>
                            @foreach($req->jenis_pemeriksaan as $jenis)
                                <span class="badge bg-info text-dark">{{ $jenis }}</span>
                            @endforeach
                        </td>
                        <td>{{ $req->dokter->name ?? '-' }}</td>
                        <td>
                            @if($req->status == 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($req->status == 'processing')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-secondary">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            @if($req->status != 'completed')
                            <button class="btn btn-sm btn-primary" onclick="openProcessModal({{ $req->id }}, '{{ $req->pasien->nama ?? '-' }}', `{{ $req->hasil }}`)">
                                <i class="bi-play-fill"></i> Proses
                            </button>
                            @else
                            <button class="btn btn-sm btn-outline-primary"><i class="bi-printer"></i> Cetak</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada permintaan laboratorium.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Generic Process Modal --}}
<div class="modal fade" id="modalProcessLab" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProcessLab" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Input Hasil Lab</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Pasien: <strong id="labPasienName">-</strong></p>
                    <div class="mb-3">
                        <label>Hasil Pemeriksaan</label>
                        <textarea name="hasil" id="labHasil" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Hasil</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openProcessModal(id, namaPasien, hasil) {
        document.getElementById('formProcessLab').action = `/laboratorium/${id}`;
        document.getElementById('labPasienName').innerText = namaPasien;
        document.getElementById('labHasil').value = hasil || '';
        
        new bootstrap.Modal(document.getElementById('modalProcessLab')).show();
    }
</script>

{{-- Modal Request Baru --}}
<div class="modal fade" id="modalRequestLab" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('laboratorium.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Permintaan Laboratorium Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih Pasien</label>
                        <select name="pasien_id" class="form-select" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach(\App\Models\Pasien::limit(20)->get() as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rm }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Pemeriksaan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pemeriksaan[]" value="Darah Lengkap">
                            <label class="form-check-label">Darah Lengkap</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pemeriksaan[]" value="Gula Darah">
                            <label class="form-check-label">Gula Darah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pemeriksaan[]" value="Kolesterol">
                            <label class="form-check-label">Kolesterol</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_pemeriksaan[]" value="Urinalisa">
                            <label class="form-check-label">Urinalisa</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
