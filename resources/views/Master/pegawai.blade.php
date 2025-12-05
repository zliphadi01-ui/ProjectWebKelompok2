@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Manajemen Pegawai</h2>
            <p class="text-muted mb-0">Kelola akun pengguna dan hak akses sistem</p>
        </div>
        <button class="btn btn-primary px-4 hover-scale" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi-plus-lg me-2"></i>Tambah Pegawai
        </button>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Staff Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi-people-fill text-primary me-2"></i>Daftar Pegawai
            </h5>
            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                {{ $users->count() }} Pengguna
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold" style="width: 60px;">No</th>
                            <th class="py-3 text-muted fw-semibold">Nama</th>
                            <th class="py-3 text-muted fw-semibold">Email</th>
                            <th class="py-3 text-muted fw-semibold" style="width: 150px;">Role</th>
                            <th class="py-3 text-muted fw-semibold" style="width: 120px;">Status</th>
                            <th class="py-3 text-muted fw-semibold text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary-subtle text-primary me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="bi-envelope text-muted me-2"></i>
                                <span class="text-dark">{{ $user->email }}</span>
                            </td>
                            <td>
                                @php
                                    $roleBadge = match($user->role) {
                                        'admin' => 'bg-danger',
                                        'dokter' => 'bg-success',
                                        'pendaftaran' => 'bg-info',
                                        'apotek' => 'bg-warning text-dark',
                                        'kasir' => 'bg-primary',
                                        'perawat' => 'bg-info',
                                        'pasien' => 'bg-secondary',
                                        'rekam_medis' => 'bg-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $roleBadge }} px-3 py-2">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    <i class="bi-check-circle me-1"></i>Aktif
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning px-3 btn-edit" 
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}"
                                    title="Edit">
                                    <i class="bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger px-3 btn-delete" 
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    title="Hapus">
                                    <i class="bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi-people display-4 text-muted opacity-25"></i>
                                <p class="text-muted mt-3">Belum ada data pegawai</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('master-data.pegawai.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary border-0">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi-person-plus me-2"></i>Tambah Pegawai Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="nama@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="" disabled selected>Pilih Role...</option>
                            <option value="admin">Admin</option>
                            <option value="dokter">Dokter</option>
                            <option value="pendaftaran">Pendaftaran</option>
                            <option value="apotek">Apotek</option>
                            <option value="kasir">Kasir</option>
                            <option value="rekam_medis">Rekam Medis</option>
                        </select>
                        <small class="text-muted">Role menentukan hak akses pengguna dalam sistem</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 5 karakter" required minlength="5">
                        <small class="text-muted">Password minimal 5 karakter</small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi-pencil-square text-primary me-2"></i>Edit Pegawai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" id="edit_role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="dokter">Dokter</option>
                            <option value="perawat">Perawat</option>
                            <option value="pendaftaran">Pendaftaran</option>
                            <option value="apotek">Apotek</option>
                            <option value="kasir">Kasir</option>
                            <option value="pasien">Pasien</option>
                            <option value="rekam_medis">Rekam Medis</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 5 karakter">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger border-0">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus pegawai <strong id="delete_name"></strong>?</p>
                    <p class="text-danger small mt-2 mb-0">
                        <i class="bi-info-circle me-1"></i>
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi-trash me-2"></i>Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Edit Modal Handler
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const email = this.dataset.email;
        const role = this.dataset.role;
        
        // Set form action
        document.getElementById('editForm').action = `/master-data/pegawai/${id}`;
        
        // Populate fields
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});

// Delete Modal Handler
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        
        // Set form action
        document.getElementById('deleteForm').action = `/master-data/pegawai/${id}`;
        
        // Set name
        document.getElementById('delete_name').textContent = name;
        
        // Show modal
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});
</script>
@endpush
