@extends('layouts.app')
@push('styles')
<style>
    :root{ --rme-accent:#0d6efd; --rme-accent-2:#0b5ed7; --rme-muted:#6c757d; }
    /* Card and header */
    .card { border-radius: 12px; box-shadow: 0 6px 20px rgba(15,23,42,0.06); }
    .card-header { background: linear-gradient(90deg,var(--rme-accent),var(--rme-accent-2)); color: #fff !important; font-weight: 700; font-size: 1.05rem; border-top-left-radius:12px; border-top-right-radius:12px; }

    /* Inputs and selects */
    .form-control, .form-select { font-size: 1rem; padding: .72rem .75rem; border-radius: 8px; }
    label { font-weight: 600; color: #222; font-size: .98rem; }

    /* Buttons */
    .btn-success { background: linear-gradient(180deg,#17a673,#138a5a); border: none; box-shadow: none; padding: .55rem 1.05rem; font-weight:600; }
    .btn-outline-secondary { border-radius: 8px; padding: .45rem .7rem; }

    /* Result list */
    #pasien_results { border-radius: 8px; border: 1px solid rgba(13,110,253,0.08); }
    #pasien_results .list-group-item { transition: background .12s, transform .06s; font-size: .96rem; padding: .6rem .9rem; }
    #pasien_results .list-group-item:hover { background: rgba(13,110,253,0.06); transform: translateY(-2px); }

    /* Slightly larger card body spacing */
    .card-body { padding: 1.3rem; }

    @media (max-width: 576px) {
        .form-control, .form-select { font-size: .95rem; }
        .card { margin: 0 8px; }
    }
</style>
@endpush
@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">Form Pendaftaran Pasien Baru</div>
    <div class="card-body">
        <form action="{{ route('pendaftaran.store-baru') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Link ke Pasien yang Sudah Ada</label>
                <div class="d-flex gap-2">
                    <input type="search" id="pasien_search" class="form-control" placeholder="Cari pasien (nama atau No. RM)...">
                    <button type="button" id="pasien_clear" class="btn btn-outline-secondary">Clear</button>
                </div>
                <ul id="pasien_results" class="list-group mt-2" style="display:none; max-height:240px; overflow:auto;"></ul>
                <input type="hidden" name="pasien_id" id="pasien_id" value="">
            </div>
            <div class="mb-3">
                <label>Nama Pasien</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" 
                    placeholder="Masukkan 16 digit NIK..."

                    required 
                    pattern="[0-9]{16}"
                    maxlength="16"
                    minlength="16"
                    title="NIK harus terdiri dari 16 angka."
                >
                <!-- Browser sekarang akan otomatis error jika user mengetik kurang atau lebih dari 16 angka -->
            </div>
            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                    <option value="L">Laki-Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control">
            </div>
            <div class="mb-3">
                <label>Poli Tujuan</label>
                <select name="poli" id="poli" class="form-select">
                    <option value="">-- Pilih Poli --</option>
                    @foreach($poliList as $poli)
                        <option value="{{ $poli }}">{{ $poli }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Daftarkan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
        var search = document.getElementById('pasien_search');
        var clearBtn = document.getElementById('pasien_clear');
        var results = document.getElementById('pasien_results');
        var hidden = document.getElementById('pasien_id');
        var nameFld = document.getElementById('nama');
        var tglFld = document.getElementById('tanggal_lahir');
        var telFld = document.getElementById('telepon');
        var jenisFld = document.getElementById('jenis_kelamin');

        // pasien data from server
        var pasienData = @json($pasienData ?? []);

        function clearFields(){
            hidden.value = '';
            if(nameFld) nameFld.value = '';
            if(tglFld) tglFld.value = '';
            if(telFld) telFld.value = '';
            if(jenisFld) jenisFld.value = 'L';
            if(search) search.value = '';
            results.innerHTML = '';
            results.style.display = 'none';
        }

        function renderResults(list){
            results.innerHTML = '';
            if(!list.length){ results.style.display = 'none'; return; }
            list.forEach(function(p){
                var li = document.createElement('li');
                li.className = 'list-group-item list-group-item-action';
                li.style.cursor = 'pointer';
                li.textContent = p.no_rm + ' - ' + p.nama + (p.telepon ? ' ('+p.telepon+')' : '');
                li.dataset.id = p.id;
                li.dataset.nama = p.nama;
                li.dataset.tgl = p.tanggal_lahir;
                li.dataset.telp = p.telepon;
                li.dataset.jenis = p.jenis_kelamin;
                li.addEventListener('click', function(){
                    hidden.value = this.dataset.id;
                    if(nameFld) nameFld.value = this.dataset.nama || '';
                    if(tglFld) tglFld.value = this.dataset.tgl || '';
                    if(telFld) telFld.value = this.dataset.telp || '';
                    if(jenisFld) jenisFld.value = this.dataset.jenis || 'L';
                    results.innerHTML = '';
                    results.style.display = 'none';
                });
                results.appendChild(li);
            });
            results.style.display = 'block';
        }

        if(clearBtn){
            clearBtn.addEventListener('click', function(){ clearFields(); });
        }

        if(search){
            search.addEventListener('input', function(e){
                var q = (e.target.value||'').toLowerCase().trim();
                if(!q){ renderResults([]); return; }
                var filtered = pasienData.filter(function(p){
                    var text = (p.no_rm + ' ' + p.nama).toLowerCase();
                    return text.indexOf(q) !== -1;
                });
                renderResults(filtered.slice(0,50));
            });
        }

    })();
</script>
@endpush
