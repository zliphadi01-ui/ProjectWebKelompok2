<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekam Medis Elektronik - RS Polije</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekam Medis Elektronik - RS Polije</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Poppins font (if you don't import in layout, this keeps welcome page consistent) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand-blue: #0d6efd;
            --muted: #6c757d;
            --card-radius: .75rem;
        }
        body{ font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }

        /* Hero: clean gradient background */
        .hero-section{
            background: linear-gradient(135deg, #eaf4ff 0%, #ffffff 100%);
            color: #0b2a44;
            padding: 7rem 0 4rem 0;
            text-align: center;
        }
        .hero-title{ font-size: 3rem; font-weight:700; margin-bottom: .5rem; }
        .hero-lead{ color: var(--muted); font-size:1.125rem; margin-bottom: 1.5rem; }

        /* Feature cards under Fitur Unggulan */
        .features-row{ margin-top: 1.5rem; }
        .feature-card{ border: 0; border-radius: var(--card-radius); transition: transform .18s ease, box-shadow .18s ease; }
        .feature-card:hover{ transform: translateY(-6px); box-shadow: 0 10px 30px rgba(13,110,253,0.12); }
        .feature-icon{ font-size: 2.25rem; color: var(--brand-blue); }
        .feature-title{ font-weight:600; margin-top:.75rem; }
        .feature-desc{ color:var(--muted); font-size:.95rem; }

        .section-title{ text-align:center; margin-bottom:1rem; }
        footer{ background:#0b1a2b; color:#d6e7ff; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}"><i class="bi-hospital-fill me-2"></i>RME RS POLIJE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Portal</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Panduan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">IT Support</a></li>
                </ul>
                <a href="{{ url('/login') }}" class="btn btn-primary ms-lg-3">Login Petugas</a>
            </div>
        </div>
    </nav>

    <!-- HERO (no image; gradient background) -->
    <header class="hero-section">
        <div class="container">
            <h1 class="hero-title">Sistem Rekam Medis Elektronik</h1>
            <p class="hero-lead">Akses dan kelola data medis pasien secara cepat, akurat, dan aman. Silakan masuk untuk memulai sesi Anda.</p>
            <!-- Removed the two center CTAs per spec; navbar login will be used -->
        </div>
    </header>

    <!-- Features section: title + 4 cards (icons moved up under title) -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2 class="fw-bold">Fitur Unggulan Sistem RME</h2>
                <p class="text-muted">Dirancang untuk meningkatkan efisiensi dan akurasi pelayanan medis.</p>
            </div>

            <div class="row features-row g-4">
                <div class="col-md-3">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="feature-icon"><i class="bi-database-fill-check"></i></div>
                        <div class="feature-title">Data Terpusat</div>
                        <div class="feature-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="feature-icon"><i class="bi-speedometer2"></i></div>
                        <div class="feature-title">Akses Cepat</div>
                        <div class="feature-desc">Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh.</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="feature-icon"><i class="bi-shield-lock-fill"></i></div>
                        <div class="feature-title">Keamanan Terjamin</div>
                        <div class="feature-desc">Nulla facilisi. Cras mattis consectetur purus sit amet fermentum.</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card feature-card h-100 p-4 text-center">
                        <div class="feature-icon"><i class="bi-people-fill"></i></div>
                        <div class="feature-title">Manajemen User</div>
                        <div class="feature-desc">Maecenas faucibus mollis interdum. Lorem ipsum dolor sit amet.</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Brief modules (kept compact) -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2 class="fw-bold">Modul Utama Sistem</h2>
                <p class="text-muted">Jelajahi berbagai modul yang dirancang untuk kebutuhan klinis dan administratif.</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><i class="bi-journal-medical text-primary me-2"></i>Modul Rawat Jalan</h5>
                            <p class="text-muted">Kelola antrean, pendaftaran kunjungan, dan asesmen SOAP untuk pasien poliklinik.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><i class="bi-capsule text-primary me-2"></i>Resep Elektronik</h5>
                            <p class="text-muted">Buat dan kelola resep obat secara digital untuk mengurangi kesalahan medis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card service-card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold"><i class="bi-file-earmark-bar-graph-fill text-primary me-2"></i>Pelaporan & Analitik</h5>
                            <p class="text-muted">Hasilkan laporan kunjungan dan data klinis untuk kebutuhan manajemen.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-primary"><i class="bi-hospital-fill me-2"></i>RME KLINIK POLIJE</h5>
                    <p class="text-muted">Sistem Informasi Manajemen Rumah Sakit Terintegrasi.</p>
                </div>
                <div class="col-md-2 offset-md-1 mb-4">
                    <h5 class="fw-bold">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Dashboard</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Panduan Sistem</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Bantuan Teknis</a></li>
                    </ul>
                </div>
                <div class="col-md-4 offset-md-1 mb-4">
                    <h5 class="fw-bold">Kontak IT Support</h5>
                    <p class="text-muted mb-1"><i class="bi-geo-alt-fill me-2"></i>Gedung IT, Politeknik Negeri Jember</p>
                    <p class="text-muted mb-1"><i class="bi-telephone-fill me-2"></i>(0331) 123-456 ext. 2</p>
                    <p class="text-muted mb-1"><i class="bi-envelope-fill me-2"></i>itsupport@rspolije.ac.id</p>
                </div>
            </div>
            <hr>
            <p class="text-center text-muted mb-0">&copy; 2025 Divisi IT RS Polije. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>