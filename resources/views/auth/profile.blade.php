@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Profil Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <img src="{{ session('user_photo') ?? ($user->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode(session('user') ?? 'User')) }}" alt="Profile" class="img-fluid rounded-circle mb-3" style="width:140px;height:140px;object-fit:cover">
                <h5>{{ session('user') ?? ($user->name ?? 'User') }}</h5>
                <p class="text-muted">Edit foto profil Anda di bawah</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-3">
                <form action="{{ url('/profile/photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Unggah Foto Profil</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                    </div>
                    <button class="btn btn-primary">Unggah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
