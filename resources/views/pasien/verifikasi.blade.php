@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-title">Verifikasi Pasien</h1>
    </div>

    <div class="card modern-card shadow-sm">
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger modern-alert">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success modern-alert">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $p->no_rm }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->tanggal_lahir }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pasien.show', ['id' => $p->id]) }}" class="btn btn-sm btn-info btn-modern">Lihat</a>
                                    <a href="{{ route('pasien.edit', ['id' => $p->id]) }}" class="btn btn-sm btn-warning btn-modern">Edit</a>
                                    <form action="{{ route('pasien.destroy', ['id' => $p->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus pasien ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-modern">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada pasien untuk diverifikasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ CSS KHUSUS HALAMAN INI --}}
    <style>
        .text-title {
            color: #40407a;
            font-weight: 700;
        }

        .modern-card {
            border-radius: 16px;
            border: none;
            background: #ffffff;
        }

        .modern-alert {
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .modern-table thead {
            background-color: #40407a;
            color: #ffffff;
        }

        .modern-table th {
            font-weight: 600;
            border: none !important;
            padding: 14px;
        }

        .modern-table td {
            vertical-align: middle;
            padding: 12px;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background-color: rgba(64,64,122,0.06);
        }

        .btn-modern {
            border-radius: 8px;
            font-weight: 500;
            padding: 4px 10px;
        }

        .btn-info {
            background-color: #40407a;
            border-color: #40407a;
            color: #fff;
        }

        .btn-info:hover {
            background-color: #2f2f66;
            border-color: #2f2f66;
            color: #fff;
        }
    </style>
@endsection
