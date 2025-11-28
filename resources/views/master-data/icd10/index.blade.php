@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="bi-journal-medical me-2"></i> Master Data ICD-10</h2>
    <div>
        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi-file-earmark-spreadsheet me-2"></i> Import CSV
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi-plus-circle me-2"></i> Tambah Manual
        </button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success shadow-sm border-left-success fade show" role="alert">
        <i class="bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger shadow-sm border-left-danger fade show" role="alert">
        <i class="bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Daftar Kode Penyakit (ICD-10)</h6>
        <form action="{{ route('master-data.icd10.index') }}" method="GET" class="d-flex">
            <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari Kode / Nama..." value="{{ $query }}">
            <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi-search"></i></button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 150px;">Kode</th>
                        <th>Nama Penyakit</th>
                        <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($codes as $code)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $code->code }}</td>
                            <td>{{ $code->name }}</td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-warning rounded-pill" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal{{ $code->id }}">
                                    <i class="bi-pencil"></i>
                                </button>
                                <form action="{{ route('master-data.icd10.destroy', $code->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus kode {{ $code->code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        {{-- EDIT MODAL --}}
                        <div class="modal fade" id="editModal{{ $code->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit ICD-10</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('master-data.icd10.update', $code->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Kode ICD-10</label>
                                                <input type="text" name="code" class="form-control" value="{{ $code->code }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Penyakit</label>
                                                <input type="text" name="name" class="form-control" value="{{ $code->name }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi-clipboard-x display-4 mb-3 d-block opacity-25"></i>
                                    <span class="fw-bold">Data tidak ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($codes->hasPages())
        <div class="card-footer bg-white">
            {{ $codes->appends(['q' => $query])->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah ICD-10 Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('master-data.icd10.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode ICD-10</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: A00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Penyakit</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Cholera" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- IMPORT MODAL --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import CSV ICD-10</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('master-data.icd10.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <small>
                            <i class="bi-info-circle-fill me-1"></i> Format file CSV harus memiliki 2 kolom: <strong>Code</strong> dan <strong>Name</strong>.
                            <br>Baris pertama (Header) akan diabaikan jika bernama "Code" atau "Kode".
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih File CSV</label>
                        <input type="file" name="file" class="form-control" accept=".csv, .txt" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
