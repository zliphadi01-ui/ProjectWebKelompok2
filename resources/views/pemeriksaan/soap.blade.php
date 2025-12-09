@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Medis (SOAP)</h1>
    <a href="{{ route('kunjungan.hari-ini') }}" class="btn btn-secondary">
        <i class="bi-arrow-left me-1"></i> Kembali
    </a>
</div>

{{-- 1. BLOK ERROR VALIDASI (PENTING AGAR TAU KENAPA GAGAL) --}}
@if ($errors->any())
    <div class="alert alert-danger shadow-sm border-left-danger">
        <h6 class="font-weight-bold"><i class="bi bi-exclamation-triangle-fill"></i> Gagal Menyimpan!</h6>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    {{-- KOLOM KIRI: DATA PASIEN --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-info text-white py-3">
                <h6 class="m-0 fw-bold"><i class="bi bi-person-circle"></i> Data Pasien</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('adminlte/dist/assets/img/avatar.png') }}" class="img-fluid rounded-circle" style="width: 80px;">
                    <h5 class="mt-2 fw-bold">{{ $pasien->nama ?? 'Nama Tidak Diketahui' }}</h5>
                    <span class="badge bg-primary">{{ $pasien->no_rm ?? '-' }}</span>
                </div>
                <hr>
                <table class="table table-sm table-borderless" style="font-size: 0.9rem;">
                    <tr><td class="text-muted">Gender:</td><td class="fw-bold">{{ $pasien->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Umur:</td><td class="fw-bold">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age ?? '-' }} Tahun</td></tr>
                    <tr><td class="text-muted">Alergi:</td><td class="text-danger fw-bold">{{ $pasien->alergi ?? 'Tidak Ada' }}</td></tr>
                    <tr><td class="text-muted">Alamat:</td><td>{{Str::limit($pasien->alamat ?? '-', 30)}}</td></tr>
                </table>
                <button type="button" class="btn btn-info btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal">
                    <i class="bi bi-clock-history me-1"></i>Lihat Riwayat Rekam Medis
                </button>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: FORM SOAP --}}
    <div class="col-md-8">
        <form action="{{ route('pemeriksaan.store') }}" method="POST">
            @csrf
            {{-- Input Hidden --}}
            <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id ?? '' }}">
            <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">

            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3 border-bottom-primary">
                    <h6 class="m-0 fw-bold text-primary">Rekam Medis (SOAP)</h6>
                </div>
                <div class="card-body">
                    
                    {{-- SUBJECTIVE --}}
                    <div class="mb-3">
                        <label class="fw-bold text-primary">S - Subjective (Keluhan)</label>
                        <textarea name="subjective" class="form-control" rows="3" placeholder="Keluhan pasien..." required>{{ old('subjective') }}</textarea>
                    </div>

                    {{-- OBJECTIVE --}}
                    <div class="mb-3">
                        <label class="fw-bold text-success">O - Objective (Pemeriksaan Fisik)</label>
                        
                        <div class="row g-2 mb-2 bg-light p-2 rounded border">
                            <div class="col-6 col-md-3">
                                <label class="small">Tensi (mmHg)</label>
                                <input type="text" name="tekanan_darah" class="form-control form-control-sm" placeholder="120/80" value="{{ old('tekanan_darah') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Nadi (/mnt)</label>
                                <input type="text" name="nadi" class="form-control form-control-sm" placeholder="80" value="{{ old('nadi') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Suhu (°C)</label>
                                <input type="text" name="suhu" class="form-control form-control-sm" placeholder="36" value="{{ old('suhu') }}">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small">Berat (Kg)</label>
                                <input type="text" name="berat_badan" class="form-control form-control-sm" placeholder="60" value="{{ old('berat_badan') }}">
                            </div>
                        </div>

                        <textarea name="objective" class="form-control" rows="3" placeholder="Hasil pemeriksaan fisik..." required>{{ old('objective') }}</textarea>
                    </div>

                    {{-- ASSESSMENT --}}
                    <div class="mb-3">
                        <label class="fw-bold text-warning">A - Assessment (Diagnosa)</label>
                        
                        {{-- ICD-10 Search --}}
                        <div class="input-group mb-2 position-relative">
                            <span class="input-group-text bg-warning text-white" style="width: 80px;">ICD-10</span>
                            <input type="text" id="icd_search" name="icd_code" class="form-control" placeholder="Ketik Kode atau Nama Penyakit..." value="{{ old('icd_code') }}" autocomplete="off">
                            <div id="icd_results" class="list-group position-absolute w-100 shadow" style="top: 100%; z-index: 1000; display: none; max-height: 200px; overflow-y: auto;"></div>
                        </div>
                        <input type="text" id="diagnosis_input" name="diagnosis" class="form-control mb-3 fw-bold" placeholder="Nama Diagnosa Utama (Wajib)" required value="{{ old('diagnosis') }}">

                        {{-- ICD-9 Search (NEW) --}}
                        <div class="input-group mb-2 position-relative">
                            <span class="input-group-text bg-info text-white" style="width: 80px;">ICD-9</span>
                            <input type="text" id="icd9_search" name="icd9_code" class="form-control" placeholder="Ketik Kode atau Nama Tindakan..." value="{{ old('icd9_code') }}" autocomplete="off">
                            <div id="icd9_results" class="list-group position-absolute w-100 shadow" style="top: 100%; z-index: 1000; display: none; max-height: 200px; overflow-y: auto;"></div>
                        </div>
                        <input type="text" id="procedure_input" name="procedure" class="form-control mb-2" placeholder="Nama Tindakan/Prosedur (Opsional)" value="{{ old('procedure') }}">

                        <script>
                            // --- ICD-10 LOGIC ---
                            const icdInput = document.getElementById('icd_search');
                            const resultsDiv = document.getElementById('icd_results');
                            const diagnosisInput = document.getElementById('diagnosis_input');

                            icdInput.addEventListener('input', async function() {
                                const query = this.value;
                                if (query.length < 2) {
                                    resultsDiv.style.display = 'none';
                                    return;
                                }
                                try {
                                    const res = await fetch(`{{ route('icd10.search') }}?q=${query}`);
                                    const data = await res.json();
                                    resultsDiv.innerHTML = '';
                                    if (data.length > 0) {
                                        data.forEach(item => {
                                            const a = document.createElement('a');
                                            a.classList.add('list-group-item', 'list-group-item-action');
                                            a.href = '#';
                                            a.innerHTML = `<strong>${item.code}</strong> - ${item.name}`;
                                            a.onclick = (e) => {
                                                e.preventDefault();
                                                icdInput.value = item.code;
                                                diagnosisInput.value = item.name;
                                                resultsDiv.style.display = 'none';
                                            };
                                            resultsDiv.appendChild(a);
                                        });
                                        resultsDiv.style.display = 'block';
                                    } else { resultsDiv.style.display = 'none'; }
                                } catch (e) { console.error('Error fetching ICD-10:', e); }
                            });

                            // --- ICD-9 LOGIC ---
                            const icd9Input = document.getElementById('icd9_search');
                            const icd9ResultsDiv = document.getElementById('icd9_results');
                            const procedureInput = document.getElementById('procedure_input');

                            icd9Input.addEventListener('input', async function() {
                                const query = this.value;
                                if (query.length < 2) {
                                    icd9ResultsDiv.style.display = 'none';
                                    return;
                                }
                                try {
                                    const res = await fetch(`{{ route('icd9.search') }}?q=${query}`);
                                    const data = await res.json();
                                    icd9ResultsDiv.innerHTML = '';
                                    if (data.length > 0) {
                                        data.forEach(item => {
                                            const a = document.createElement('a');
                                            a.classList.add('list-group-item', 'list-group-item-action');
                                            a.href = '#';
                                            a.innerHTML = `<strong>${item.code}</strong> - ${item.name}`;
                                            a.onclick = (e) => {
                                                e.preventDefault();
                                                icd9Input.value = item.code;
                                                procedureInput.value = item.name;
                                                icd9ResultsDiv.style.display = 'none';
                                            };
                                            icd9ResultsDiv.appendChild(a);
                                        });
                                        icd9ResultsDiv.style.display = 'block';
                                    } else { icd9ResultsDiv.style.display = 'none'; }
                                } catch (e) { console.error('Error fetching ICD-9:', e); }
                            });

                            // Hide results when clicking outside
                            document.addEventListener('click', function(e) {
                                if (!icdInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                                    resultsDiv.style.display = 'none';
                                }
                                if (!icd9Input.contains(e.target) && !icd9ResultsDiv.contains(e.target)) {
                                    icd9ResultsDiv.style.display = 'none';
                                }
                            });
                        </script>
                        
                        <textarea name="assessment" class="form-control" rows="2" placeholder="Catatan tambahan diagnosa (Opsional)">{{ old('assessment') }}</textarea>
                    </div>

                    {{-- PLAN --}}
                    <div class="mb-3">
                        <label class="fw-bold text-info">P - Plan (Rencana/Terapi)</label>
                        <textarea name="plan" class="form-control" rows="3" placeholder="Rencana pengobatan & resep..." required>{{ old('plan') }}</textarea>
                    </div>

                    {{-- PEMBERIAN OBAT --}}
                    <div class="mb-3">
                        <label class="fw-bold text-danger"><i class="bi-prescription2"></i> Pemberian Obat (Resep)</label>
                        <small class="text-muted d-block mb-2">Harga obat akan terisi otomatis dari sistem inventory</small>
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="obatTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="40%">Nama Obat</th>
                                                <th width="25%">Dosis</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="15%">Harga (Auto)</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="obatTableBody">
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" id="addObatBtn">
                                    <i class="bi-plus-circle"></i> Tambah Obat
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        let obatRowCounter = 0;

                        // Add new row
                        document.getElementById('addObatBtn').addEventListener('click', function() {
                            obatRowCounter++;
                            const tbody = document.getElementById('obatTableBody');
                            const row = document.createElement('tr');
                            row.id = `obat-row-${obatRowCounter}`;
                            row.innerHTML = `
                                <td>
                                    <input type="hidden" name="obat[${obatRowCounter}][obat_id]" class="obat-id-input" required>
                                    <input type="text" class="form-control form-control-sm obat-search" 
                                           placeholder="Ketik nama obat..." 
                                           data-row="${obatRowCounter}" 
                                           autocomplete="off" required>
                                    <div class="obat-results position-absolute bg-white border shadow-sm" 
                                         id="obat-results-${obatRowCounter}" 
                                         style="display: none; z-index: 1000; max-height: 150px; overflow-y: auto; width: 90%;"></div>
                                </td>
                                <td><input type="text" name="obat[${obatRowCounter}][dosis]" class="form-control form-control-sm" placeholder="3x1" required></td>
                                <td><input type="number" name="obat[${obatRowCounter}][jumlah]" class="form-control form-control-sm" min="1" value="1" required></td>
                                <td><input type="number" name="obat[${obatRowCounter}][harga_satuan]" class="form-control form-control-sm harga-input" readonly></td>
                                <td><button type="button" class="btn btn-sm btn-danger delete-obat-btn" data-row="${obatRowCounter}"><i class="bi-trash"></i></button></td>
                            `;
                            tbody.appendChild(row);

                            // Attach search event to the new row
                            attachObatSearch(obatRowCounter);
                            attachDeleteEvent(obatRowCounter);
                        });

                        // Search obat function
                        function attachObatSearch(rowId) {
                            const searchInput = document.querySelector(`[data-row="${rowId}"]`);
                            const resultsDiv = document.getElementById(`obat-results-${rowId}`);
                            const obatIdInput = searchInput.parentElement.querySelector('.obat-id-input');
                            const hargaInput = searchInput.closest('tr').querySelector('.harga-input');

                            searchInput.addEventListener('input', async function() {
                                const query = this.value;
                                if (query.length < 2) {
                                    resultsDiv.style.display = 'none';
                                    return;
                                }

                                try {
                                    const res = await fetch(`/api/obat/search?q=${query}`);
                                    const data = await res.json();
                                    resultsDiv.innerHTML = '';
                                    
                                    if (data.length > 0) {
                                        data.forEach(obat => {
                                            const div = document.createElement('div');
                                            div.classList.add('p-2', 'border-bottom', 'cursor-pointer');
                                            div.style.cursor = 'pointer';
                                            div.innerHTML = `<strong>${obat.nama_obat}</strong> <small class="text-muted">(Stok: ${obat.stok})</small><br><small>Rp ${obat.harga_jual}</small>`;
                                            div.onclick = () => {
                                                searchInput.value = obat.nama_obat;
                                                obatIdInput.value = obat.id;
                                                hargaInput.value = obat.harga_jual;
                                                resultsDiv.style.display = 'none';
                                            };
                                            resultsDiv.appendChild(div);
                                        });
                                        resultsDiv.style.display = 'block';
                                    } else {
                                        resultsDiv.style.display = 'none';
                                    }
                                } catch (e) {
                                    console.error('Error fetching obat:', e);
                                }
                            });

                            // Hide results when clicking outside
                            document.addEventListener('click', function(e) {
                                if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                                    resultsDiv.style.display = 'none';
                                }
                            });
                        }

                        // Delete row function
                        function attachDeleteEvent(rowId) {
                            const deleteBtn = document.querySelector(`[data-row="${rowId}"].delete-obat-btn`);
                            deleteBtn.addEventListener('click', function() {
                                const row = document.getElementById(`obat-row-${rowId}`);
                                row.remove();
                            });
                        }
                    </script>

                    {{-- TINDAK LANJUT --}}

                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark"><i class="bi-arrow-right-circle"></i> Tindak Lanjut</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Keputusan</label>
                                    <select name="tindak_lanjut" class="form-select" required>
                                        <option value="Pulang" {{ old('tindak_lanjut') == 'Pulang' ? 'selected' : '' }}>Pulang (Selesai)</option>
                                        <option value="Rawat Inap" {{ old('tindak_lanjut') == 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                                        <option value="Rujuk" {{ old('tindak_lanjut') == 'Rujuk' ? 'selected' : '' }}>Rujuk ke RS Lain</option>
                                        <option value="Kontrol" {{ old('tindak_lanjut') == 'Kontrol' ? 'selected' : '' }}>Kontrol Ulang</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small fw-bold">Keterangan Tambahan</label>
                                    <input type="text" name="keterangan_tindak_lanjut" class="form-control" placeholder="Cth: Rujuk ke RSUD Soebandi..." value="{{ old('keterangan_tindak_lanjut') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                    <button type="submit" name="action" value="save" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Saja
                    </button>
                    <button type="submit" name="action" value="print" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Simpan & Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('pemeriksaan._modal_history')
@endsection