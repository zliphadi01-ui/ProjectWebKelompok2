@extends('layouts.app')

@section('content')
<style>
    .judul-biru {
        color: #007bff;
        font-weight: 700;
    }

    .card-custom {
        border: 1.5px solid #007bff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.15);
    }

    .card-header-custom {
        background: #007bff;
        color: white;
        font-weight: 600;
        border-radius: 10px 10px 0 0;
        padding: 12px 20px;
    }

    .list-group-item {
        transition: 0.3s;
        border-left: 4px solid #007bff;
    }

    .list-group-item:hover {
        background-color: rgba(0, 123, 255, 0.08);
        transform: scale(1.01);
    }

    .btn-kontrol {
        background-color: #007bff;
        border: none;
        transition: 0.3s;
    }

    .btn-kontrol:hover {
        background-color: #0056b3;
    }

    .no-rm {
        color: #007bff;
        font-weight: 600;
    }

    .nama-pasien {
        color: #000; 
        font-weight: 600;
    }
</style>

<div class="container mt-4">
    <h3 class="judul-biru">Data Pasien Kontrol</h3>

    <div class="card mt-3 card-custom">
        <div class="card-header-custom">
            Daftar Pasien
        </div>

        <div class="card-body">
            <p class="text-muted">
                Pilih pasien untuk melihat riwayat kontrol atau mendaftar kontrol.
            </p>

            <ul class="list-group">
                @foreach($pasien as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="nama-pasien">{{ $p->nama }}</strong> <br>
                        <small class="no-rm">No. RM: {{ $p->no_rm }}</small>
                    </div>

                    <div>
                        <a href="#" class="btn btn-sm btn-kontrol text-white">
                            Daftar Kontrol
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
@endsection
