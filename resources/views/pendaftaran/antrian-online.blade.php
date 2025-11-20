@extends('layouts.app')
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">Antrian Online</div>
    <div class="card-body">
        @if($antrian->isEmpty())
            <p>Tidak ada pasien dalam antrian.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Daftar</th>
                        <th>Nama</th>
                        <th>Poli</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($antrian as $a)
                    <tr>
                        <td>{{ $a->no_daftar }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->poli }}</td>
                        <td>{{ $a->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
