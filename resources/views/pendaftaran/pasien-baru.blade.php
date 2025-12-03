@extends('layouts.app')

@push('styles')
<style>
    :root {
        --primary: #0d6efd;
        --success: #17a673;
        --gray: #6c757d;
    }

    .registration-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary), #0b5ed7);
        color: white;
        padding: 1.25rem;
        font-weight: 700;
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
        padding: 0.65rem 0.9rem;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 1.5rem 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .section-title:first-child {
        margin-top: 0;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success), #138a5a);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 166, 115, 0.3);
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .conditional-field {
        display: none;
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
            <a href="{{ route('pendaftaran.index') }}" class="btn btn-sm btn-light text-primary">
                Kembali
            </a>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('pendaftaran.store-baru') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Data Identitas -->
                <div class="section-title">Data Identitas</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama sesuai KTP" value="{{ old('nama') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">NIK</label>
                        <input type="text" name="nik" class="form-control" required pattern="[0-9]{16}" maxlength="16" placeholder="16 digit NIK" value="{{ old('nik') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Golongan Darah</label>
                        <select name="golongan_darah" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">Pilih</option>
                            <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}">
                    </div>
                </div>

                <!-- Alamat & Kontak -->
                <div class="section-title">Alamat & Kontak</div>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, Nomor Rumah">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RT/RW</label>
                        <input type="text" name="rt_rw" class="form-control" placeholder="001/002" value="{{ old('rt_rw') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kota/Kabupaten</label>
                        <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon/HP</label>
                        <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" maxlength="5" value="{{ old('kode_pos') }}">
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="section-title">Kontak Darurat</div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Nama Keluarga/Penanggung Jawab</label>
                        <input type="text" name="nama_keluarga" class="form-control" placeholder="Nama lengkap" value="{{ old('nama_keluarga') }}">
                    </div>
                    <div class="col-md-3 mb-3">
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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telepon Keluarga</label>
                        <input type="text" name="telepon_keluarga" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('telepon_keluarga') }}">
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="section-title">Jenis Pembayaran</div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="umum" value="Umum" checked>
                                    <label class="form-check-label" for="umum">Umum/Tunai</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="bpjs" value="BPJS">
                                    <label class="form-check-label" for="bpjs">BPJS</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="asuransi" value="Asuransi">
                                    <label class="form-check-label" for="asuransi">Asuransi Swasta</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BPJS Fields -->
                <div class="conditional-field" id="bpjsFields">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor BPJS</label>
                            <input type="text" name="no_bpjs" class="form-control" placeholder="13 digit nomor BPJS" value="{{ old('no_bpjs') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Kartu BPJS (Opsional)</label>
                            <input type="file" name="scan_bpjs" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <!-- Asuransi Fields -->
                <div class="conditional-field" id="asuransiFields">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Asuransi</label>
                            <input type="text" name="nama_asuransi" class="form-control" placeholder="Contoh: Prudential, Allianz" value="{{ old('nama_asuransi') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Polis</label>
                            <input type="text" name="no_polis" class="form-control" placeholder="Nomor polis asuransi" value="{{ old('no_polis') }}">
                        </div>
                    </div>
                </div>

                <!-- Riwayat Medis -->
                <div class="section-title">Riwayat Medis (Opsional)</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alergi Obat</label>
                        <textarea name="alergi_obat" class="form-control" rows="2" placeholder="Contoh: Penisilin, Aspirin">{{ old('alergi_obat') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Contoh: Diabetes, Hipertensi">{{ old('riwayat_penyakit') }}</textarea>
                    </div>
                </div>

                <!-- Poli -->
                <div class="section-title">Pilih Poli Tujuan</div>
                <div class="row">
                    <div class="col-md-12 mb-3">
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
                    <button type="submit" class="btn btn-success btn-lg">
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
