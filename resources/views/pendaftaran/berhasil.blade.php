@extends('layouts.app') {{-- Pastikan Anda sudah punya file layout utama --}}

@section('content')
    <div class="container text-center py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <i class="bi-check-circle-fill text-success" style="font-size: 6rem;"></i>
                <h1 class="display-4 fw-bold mt-4">Pendaftaran Berhasil!</h1>
                <p class="lead text-muted">
                    Terima kasih, data Anda telah kami terima dan akan segera diproses oleh tim kami.
                </p>
                <hr class="my-4">
                <p>
                    Mohon periksa email atau nomor telepon Anda secara berkala untuk mendapatkan konfirmasi jadwal dan nomor antrean.
                </p>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg mt-3">
                    <i class="bi-house-door-fill me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection