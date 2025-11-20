@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pasien Pemeriksaan</h2>
</div>

<div class="card">
    <div class="card-body">
        <p>Halaman daftar pasien untuk pemeriksaan belum terisi — ini placeholder sederhana.</p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>No. RM</th>
                        <th>Umur</th>
                        <th>Poli</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftar_pasien as $item)
                        <tr>
                            <!-- Nomor urut -->
                            <td>{{ $loop->iteration }}</td> 
                            
                            <!-- Data Pasien (dari relasi) -->
                            <!-- Pengecekan 'isset' penting jika relasi 'pasien' null -->
                            <td>{{ $item->pasien->nama ?? $item->nama ?? 'Pasien Tidak Ditemukan' }}</td>
                            <td>{{ $item->pasien->no_rm ?? 'N/A' }}</td>
                            <td>{{ $item->pasien->umur ?? 'N/A' }}</td> <!-- Sesuai dengan <thead> Anda -->
                            
                            <!-- Data Pendaftaran -->
                            <td>{{ $item->poli ?? 'N/A' }}</td> 
                            <td>
                                <!-- Beri warna status yang berbeda-beda -->
                                @if($item->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                @elseif($item->status == 'Diproses')
                                    <span class="badge bg-info text-dark">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>

                            <!-- Tombol Aksi (PENTING) -->
                            <td>
                                <!-- Ini adalah link ke halaman SOAP, mengirimkan ID Pendaftarannya -->
                                <a href="{{ route('pemeriksaan.soap', $item->id) }}" class="btn btn-primary btn-sm">
                                    Mulai Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Ini akan tampil jika $daftar_pasien kosong -->
                        <!-- Pastikan colspan="7" agar sesuai dengan jumlah kolom -->
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pasien yang menunggu pemeriksaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
