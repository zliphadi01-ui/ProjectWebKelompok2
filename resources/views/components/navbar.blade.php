<nav class="navbar navbar-expand navbar-light navbar-glass">
    {{-- Sidebar Toggle (Mobile) --}}
    <button id="sidebarToggle" class="btn btn-link d-lg-none rounded-circle me-3 text-primary">
        <i class="bi-list fs-3"></i>
    </button>

    {{-- Date / Time or Breadcrumb (Optional) --}}
    <div class="d-none d-md-block">
        <span class="text-muted small fw-medium">
            <i class="bi-calendar-event me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}
        </span>
    </div>

    <ul class="navbar-nav ms-auto align-items-center">
        {{-- Notifications (Placeholder) --}}
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative text-gray-500" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
                <i class="bi-bell fs-5"></i>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem; padding: 0.25em 0.4em;">3+</span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header text-uppercase text-muted fw-bold small">Notifikasi</h6>
                <a class="dropdown-item small text-muted text-center" href="#">Tidak ada notifikasi baru</a>
            </div>
        </li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                <div class="d-none d-lg-block text-end lh-1">
                    <div class="fw-bold text-dark small">{{ Auth::check() ? Auth::user()->name : (session('user') ?? 'Petugas') }}</div>
                    <div class="text-muted" style="font-size: 0.7rem;">{{ Auth::check() ? ucfirst(Auth::user()->role) : 'Staff' }}</div>
                </div>
                <img class="avatar" src="{{
                    (Auth::check() && Auth::user()->profile_photo_url) ? Auth::user()->profile_photo_url :
                    (Auth::check() && isset(Auth::user()->avatar) ? asset('storage/' . Auth::user()->avatar) : 'https://images.pexels.com/photos/771742/pexels-photo-771742.jpeg')
                }}" alt="Profile">
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 animated--fade-in-up">
                <a class="dropdown-item py-2" href="{{ url('/profile') }}">
                    <i class="bi-person me-2 text-primary"></i> Profil Saya
                </a>
                <a class="dropdown-item py-2" href="{{ url('/pengaturan') }}">
                    <i class="bi-gear me-2 text-primary"></i> Pengaturan
                </a>
                <div class="dropdown-divider my-1"></div>
                <a class="dropdown-item py-2 text-danger fw-bold" href="{{ url('/logout') }}">
                    <i class="bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
