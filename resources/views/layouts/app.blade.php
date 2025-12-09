<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RME - RS Polije</title>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Premium Design System --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body class="{{ isset($bodyClass) ? $bodyClass : '' }}">

    {{-- 1. Sidebar Component --}}
    @include('components.sidebar')

    {{-- 2. Main Content Wrapper --}}
    <div class="main-content">
        
        {{-- 3. Top Navbar Component --}}
        @include('components.navbar')

        {{-- 4. Page Content --}}
        <main class="container-fluid px-4 py-4">
            @yield('content')
        </main>

        {{-- Footer (Optional) --}}
        <footer class="mt-auto py-3 text-center text-muted small">
            &copy; {{ date('Y') }} RME RS Polije. All rights reserved.
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggler Logic
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sidebar-toggled');
            });
        }
        
        // Mobile Auto-Close
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    document.body.classList.remove('sidebar-toggled');
                }
            });
        });
    </script>

    @if(Auth::check() && Auth::user()->role === 'rekam_medis')
    <script>
        // Real-time notification badge for pending requests
        function updatePendingBadge() {
            fetch('{{ route('rekam-medis.api.pending-count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('pendingBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error fetching pending count:', error));
        }

        // Update immediately on load
        updatePendingBadge();

        // Update every 30 seconds
        setInterval(updatePendingBadge, 30000);
    </script>
    @endif

    @stack('scripts')
</body>
</html>
