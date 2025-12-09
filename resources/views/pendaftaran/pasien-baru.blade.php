@extends('layouts.app')

@push('styles')
<style>
    :root {
        --primary: #0d6efd;
        --success: #17a673;
        --gray: #6c757d;
        --soft-bg: #f8f9fc;
        --border: #e2e8f0;
    }

    body {
        background: var(--soft-bg);
    }

    .registration-card {
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.09);
        border: 1px solid #eef1f5;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary), #0b5ed7);
        color: white;
        padding: 1.35rem;
        font-size: 1.15rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .form-label {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #dc3545;
        margin-left: 4px;
    }

    .form-control, .form-select {
        padding: 0.7rem 1rem;
        border-radius: 7px;
        border: 2px solid var(--border);
        background: #ffffff;
        transition: all 0.25s ease-in-out;
    }

    .form-control:hover, .form-select:hover {
        border-color: #cbd5e1;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        background: #ffffff;
    }

    textarea.form-control {
        min-height: 80px;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary);
        margin: 1.6rem 0 1.1rem;
        padding-bottom: 0.55rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title::before {
        content: "";
        width: 6px;
        height: 20px;
        background: var(--primary);
        border-radius: 4px;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success), #138a5a);
        border: none;
        padding: 0.85rem 2rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        border-radius: 10px;
        transition: all 0.25s ease-in-out;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(23, 166, 115, 0.35);
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .conditional-field {
        display: none;
        background: #f1f5fb;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #d8e2ef;
    }

    .conditional-field.show {
        display: block;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="registration-card card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Pendaftaran Pasien Baru</span>
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm btn-light text-primary shadow-sm">
                Kembali
            </a>
        </div>

        <div class="card-body p-4">
            {{-- Error dari session --}}
            @if(session('error'))
                <div class="alert alert-danger shadow-sm">
                    <i class="bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Error dari validasi --}}
            @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <i class="bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terdapat kesalahan pada form:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pendaftaran.store-baru') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Data Identitas -->
                <div class="section-title">Data Identitas</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama sesuai KTP" value="{{ old('nama') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">NIK</label>
                        <input type="text" name="nik" class="form-control" required pattern="[0-9]{16}" maxlength="16" placeholder="16 digit NIK" value="{{ old('nik') }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat & Kontak -->
                <div class="section-title">Alamat & Kontak</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, Nomor Rumah">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RT/RW</label>
                        <input type="text" name="rt_rw" class="form-control" placeholder="001/002" value="{{ old('rt_rw') }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kota/Kabupaten</label>
                        <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Telepon/HP</label>
                        <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" maxlength="5" value="{{ old('kode_pos') }}">
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="section-title">Kontak Darurat</div>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Nama Keluarga/Penanggung Jawab</label>
                        <input type="text" name="nama_keluarga" class="form-control" placeholder="Nama lengkap" value="{{ old('nama_keluarga') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hubungan</label>
                        <select name="hubungan_keluarga" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Ayah" {{ old('hubungan_keluarga') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                            <option value="Ibu" {{ old('hubungan_keluarga') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                            <option value="Suami" {{ old('hubungan_keluarga') == 'Suami' ? 'selected' : '' }}>Suami</option>
                            <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Saudara" {{ old('hubungan_keluarga') == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Telepon Keluarga</label>
                        <input type="text" name="telepon_keluarga" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon_keluarga') }}">
                    </div>
                </div>

                <!-- Jenis Pembayaran -->
                <div class="section-title">Jenis Pembayaran</div>
                <div class="row mb-3">
                    <div class="col-12 d-flex gap-4 flex-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_pembayaran" id="umum" value="Umum" checked>
                            <label class="form-check-label" for="umum">Umum/Tunai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_pembayaran" id="bpjs" value="BPJS">
                            <label class="form-check-label" for="bpjs">BPJS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_pembayaran" id="asuransi" value="Asuransi">
                            <label class="form-check-label" for="asuransi">Asuransi Swasta</label>
                        </div>
                    </div>
                </div>

                <!-- BPJS Fields -->
                <div class="conditional-field" id="bpjsFields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor BPJS</label>
                            <input type="text" name="no_bpjs" class="form-control" placeholder="13 digit nomor BPJS" value="{{ old('no_bpjs') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Kartu BPJS (Opsional)</label>
                            <input type="file" name="scan_bpjs" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <!-- Asuransi Fields -->
                <div class="conditional-field" id="asuransiFields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Asuransi</label>
                            <input type="text" name="nama_asuransi" class="form-control" placeholder="Contoh: Prudential, Allianz" value="{{ old('nama_asuransi') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Polis</label>
                            <input type="text" name="no_polis" class="form-control" placeholder="Nomor polis asuransi" value="{{ old('no_polis') }}">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Medis -->
                <div class="section-title">Riwayat Medis (Opsional)</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Alergi Obat</label>
                        <textarea name="alergi_obat" class="form-control" rows="2" placeholder="Contoh: Penisilin, Aspirin">{{ old('alergi_obat') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Contoh: Diabetes, Hipertensi">{{ old('riwayat_penyakit') }}</textarea>
                    </div>
                </div>

                <!-- Poli -->
                <div class="section-title">Pilih Poli Tujuan</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label required">Poli Tujuan</label>
                        <select name="poli" class="form-select" required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach($poliList as $poli)
                                <option value="{{ $poli }}" {{ old('poli') == $poli ? 'selected' : '' }}>{{ $poli }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-success btn-lg shadow-sm">
                        Simpan & Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Conditional Payment Fields
    document.querySelectorAll('[name="jenis_pembayaran"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('bpjsFields').classList.remove('show');
            document.getElementById('asuransiFields').classList.remove('show');

            if (this.value === 'BPJS') {
                document.getElementById('bpjsFields').classList.add('show');
            } else if (this.value === 'Asuransi') {
                document.getElementById('asuransiFields').classList.add('show');
            }
        });
    });

    // Initialize on page load if old value exists
    document.addEventListener('DOMContentLoaded', function() {
        const selectedPayment = document.querySelector('[name="jenis_pembayaran"]:checked');
        if (selectedPayment && selectedPayment.value === 'BPJS') {
            document.getElementById('bpjsFields').classList.add('show');
        } else if (selectedPayment && selectedPayment.value === 'Asuransi') {
            document.getElementById('asuransiFields').classList.add('show');
        }
    });
</script>
@endpush
