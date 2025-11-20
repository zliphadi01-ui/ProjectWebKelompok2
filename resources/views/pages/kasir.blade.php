@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Kasir</h1>

    <div class="card">
        <div class="card-body">
            <p>Halaman Kasir placeholder. Data ringkasan:</p>
            <ul>
                <li>Jumlah pendaftaran: {{ $counts['pendaftaran'] ?? 'n/a' }}</li>
            </ul>
        </div>
    </div>
@endsection
