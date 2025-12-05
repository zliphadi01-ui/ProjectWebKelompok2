@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Pengaturan Akun</h2>
            <p class="text-muted mb-0">Kelola informasi akun dan keamanan Anda</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi-exclamation-circle me-2"></i>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi-person-circle text-primary me-2"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pengaturan.update-profile') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', Auth::user()->name) }}" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', Auth::user()->email) }}" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                value="{{ ucfirst(Auth::user()->role) }}" 
                                disabled
                            >
                            <small class="text-muted">Role tidak dapat diubah sendiri</small>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi-shield-lock text-primary me-2"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pengaturan.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Password Lama <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="current_password" 
                                name="current_password" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="new_password" 
                                name="new_password" 
                                required
                            >
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                required
                            >
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi-key me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
