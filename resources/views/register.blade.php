<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Pasien Baru - RME RS Polije</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 1rem;
            overflow: hidden;
        }
        .info-panel {
            background: linear-gradient(135deg, #0d6efd, #0d47a1);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .info-panel img {
            max-width: 80%;
            margin: 0 auto 2rem auto;
        }
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(.85) translateY(-.8rem) translateX(.15rem);
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="form-container shadow-lg">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex info-panel">
                    <div class="text-center">
                        <img src="https://images.pexels.com/photos/4033148/pexels-photo-4033148.jpeg" alt="Ilustrasi Dokter">
                        <h2 class="h1 mb-3">Pendaftaran Pasien Baru</h2>
                        <p class="lead">Gunakan formulir ini untuk mendaftarkan pasien baru ke dalam sistem RME.</p>
                        <p>Pastikan semua data diisi sesuai dengan kartu identitas pasien untuk menjaga akurasi rekam medis.</p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="p-4 p-md-5">
                        
                        <div class="d-flex justify-content-between align-items-center mb-5">
                             <h2 class="mb-0">Formulir Pendaftaran Pasien</h2>
                             <a href="{{ url('/') }}" class="btn-close" aria-label="Close"></a>
                        </div>
                        
                        <form id="form-pendaftaran-lengkap" method="POST" action="{{ url('/register/process') }}">
                            @csrf
                            
                            <h5 class="pb-2 mb-4 border-bottom">Informasi Pribadi Pasien</h5>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nik" placeholder="NIK" required>
                                <label for="nik">NIK (Nomor Induk Kependudukan)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                                <label for="nama">Nama Lengkap Sesuai KTP</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir" required>
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="tgl_lahir" placeholder="Tanggal Lahir" required>
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="jenis_kelamin" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="goldar">
                                            <option value="" disabled selected>Pilih...</option>
                                            <option>A</option> <option>B</option> <option>AB</option> <option>O</option>
                                        </select>
                                        <label for="goldar">Golongan Darah</label>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4 pb-2 mb-4 border-bottom">Alamat & Kontak</h5>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Alamat Jalan" id="alamat" style="height: 100px" required></textarea>
                                <label for="alamat">Alamat (Nama Jalan, Gedung)</label>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="kota" placeholder="Kota/Kabupaten" required>
                                        <label for="kota">Kota/Kabupaten</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="kodepos" placeholder="Kode Pos">
                                        <label for="kodepos">Kode Pos</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="telepon" placeholder="Nomor Telepon" required>
                                <label for="telepon">Nomor Telepon / HP Aktif</label>
                            </div>

                            <h5 class="mt-4 pb-2 mb-4 border-bottom">Detail Kunjungan & Pembayaran</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="poliklinik" required>
                                            <option value="" disabled selected>Pilih Poli...</option>
                                            <option>Poli Umum</option>
                                            <option>Poli Gigi</option>
                                            <option>Poli Penyakit Dalam</option>
                                        </select>
                                        <label for="poliklinik">Poliklinik Tujuan</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="jenis_pembayaran" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            <option value="Umum">Umum</option>
                                            <option value="BPJS">BPJS</option>
                                            <option value="Swasta">Asuransi Swasta</option>
                                        </select>
                                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                    </div>
                                </div>
                            </div>

                            <div id="nomorAsuransiContainer" class="form-floating mb-3" style="display: none;">
                                <input type="text" class="form-control" id="nomor_asuransi" placeholder="Nomor BPJS / Asuransi">
                                <label for="nomor_asuransi">Nomor BPJS / Asuransi</label>
                            </div>

                            <div class="mb-3">
                                <label for="upload_ktp" class="form-label">Unggah Foto KTP/KIA (Opsional)</label>
                                <input class="form-control" type="file" id="upload_ktp">
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" role="switch" id="persetujuan" required>
                                <label class="form-check-label" for="persetujuan">Petugas menyatakan data telah diverifikasi sesuai dengan identitas pasien.</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <i class="bi-person-plus-fill me-2"></i>Daftarkan Pasien
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('jenis_pembayaran').addEventListener('change', function () {
            const container = document.getElementById('nomorAsuransiContainer');
            if (this.value === 'BPJS' || this.value === 'Swasta') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        });
    </script>
</body>
</html>