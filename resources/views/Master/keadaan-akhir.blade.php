@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">Data Keadaan Akhir Pasien</h3>
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">Daftar Keadaan Akhir</span>
            <a href="#" class="btn btn-sm btn-primary">+ Tambah Data</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>No. RM</th>
                        <th>Tanggal Keluar</th>
                        <th>Keadaan Akhir</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Budi Santoso</td>
                        <td>RM00123</td>
                        <td>20 Oktober 2025</td>
                        <td>Sembuh</td>
                        <td>-</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Siti Aminah</td>
                        <td>RM00124</td>
                        <td>21 Oktober 2025</td>
                        <td>Dirujuk</td>
                        <td>Ke RSUD Kota</td>
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
