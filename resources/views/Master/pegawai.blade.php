@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">Data Pegawai</h3>
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">Daftar Pegawai</span>
            <a href="#" class="btn btn-sm btn-primary">+ Tambah Pegawai</a>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Profesi</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dr. Andi Pratama</td>
                        <td>19870203</td>
                        <td>Dokter Umum</td>
                        <td>Poli Umum</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Nurse Lestari</td>
                        <td>19910215</td>
                        <td>Perawat</td>
                        <td>UGD</td>
                        <td><span class="badge bg-secondary">Cuti</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
