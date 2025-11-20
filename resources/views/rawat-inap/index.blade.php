@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Rawat Inap</h3>
    <a href="{{ route('rawat-inap.create') }}" class="btn btn-primary">Tambah Rawat Inap</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pasien</th>
                    <th>Kamar</th>
                    <th>No Kamar</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $item->pasien?->nama ?? '-' }}</td>
                        <td>{{ $item->kamar }}</td>
                        <td>{{ $item->no_kamar }}</td>
                        <td>{{ $item->tanggal_masuk }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('rawat-inap.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <a href="{{ route('rawat-inap.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('rawat-inap.destroy', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada data rawat inap</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection
