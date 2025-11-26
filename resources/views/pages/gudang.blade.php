@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">Stok Obat & Farmasi</h2>
    <div>
        <button class="btn btn-outline-primary me-2"><i class="bi-download me-2"></i> Export Excel</button>
        <button class="btn btn-primary"><i class="bi-plus-circle me-2"></i> Tambah Obat</button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-primary">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Total Item Obat</div>
                <div class="h3 fw-bold text-gray-800">1,240</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-danger">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Stok Menipis (< 10)</div>
                <div class="h3 fw-bold text-danger">5</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <div class="text-muted small text-uppercase fw-bold">Kadaluarsa < 3 Bulan</div>
                <div class="h3 fw-bold text-warning">12</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Stok Obat</h6>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control form-control-sm" placeholder="Cari nama obat...">
            <button class="btn btn-primary btn-sm"><i class="bi-search"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga Jual</th>
                        <th>Exp. Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>OBT-001</td>
                        <td class="fw-bold">Paracetamol 500mg</td>
                        <td>Tablet</td>
                        <td><span class="text-success fw-bold">1,500</span></td>
                        <td>Strip</td>
                        <td>Rp 5.000</td>
                        <td>2025-12-31</td>
                        <td>
                            <button class="btn btn-sm btn-light text-primary"><i class="bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>OBT-002</td>
                        <td class="fw-bold">Amoxicillin 500mg</td>
                        <td>Kapsul</td>
                        <td><span class="text-success fw-bold">850</span></td>
                        <td>Strip</td>
                        <td>Rp 8.500</td>
                        <td>2024-10-15</td>
                        <td>
                            <button class="btn btn-sm btn-light text-primary"><i class="bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>OBT-003</td>
                        <td class="fw-bold">OBH Combi Anak</td>
                        <td>Sirup</td>
                        <td><span class="text-danger fw-bold">5</span></td>
                        <td>Botol</td>
                        <td>Rp 15.000</td>
                        <td>2026-01-20</td>
                        <td>
                            <button class="btn btn-sm btn-light text-primary"><i class="bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>OBT-004</td>
                        <td class="fw-bold">Betadine 30ml</td>
                        <td>Cair</td>
                        <td><span class="text-success fw-bold">45</span></td>
                        <td>Botol</td>
                        <td>Rp 25.000</td>
                        <td>2027-05-05</td>
                        <td>
                            <button class="btn btn-sm btn-light text-primary"><i class="bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi-trash"></i></button>
                        </td>
                    </tr>
                     <tr>
                        <td>OBT-005</td>
                        <td class="fw-bold">Vitamin C IPI</td>
                        <td>Tablet</td>
                        <td><span class="text-warning fw-bold">12</span></td>
                        <td>Botol</td>
                        <td>Rp 7.000</td>
                        <td>2024-08-01</td>
                        <td>
                            <button class="btn btn-sm btn-light text-primary"><i class="bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger"><i class="bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <nav>
                <ul class="pagination pagination-sm">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
