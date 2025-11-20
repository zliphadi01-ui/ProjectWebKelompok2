@extends('layouts.app')

@section('content')
    <h1 class="mb-4">BPJS</h1>

    <div class="card">
        <div class="card-body">
            <p>Halaman BPJS placeholder. Data ringkasan:</p>
            <ul>
                <li>Jumlah pasien: {{ $counts['pasien'] ?? 'n/a' }}</li>
            </ul>
        </div>
    </div>
@endsection
