<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login RME Polije</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 350px;">
        <h4 class="text-center mb-3">Login RME</h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="loginForm" method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username atau Email</label>
                <input type="text" id="username" name="username" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div id="loginAlert" class="alert d-none" role="alert"></div>

            <button type="submit" id="loginBtn" class="btn btn-primary w-100">Masuk</button>
            
            <div class="mt-3 text-center">
                <small class="text-muted">Dev login: test@example.com / password</small>
            </div>
        </form>




        <script>
            const form = document.getElementById('loginForm');
            const alertBox = document.getElementById('loginAlert');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                alertBox.classList.add('d-none');
                const data = new FormData(form);
                const token = document.querySelector('input[name="_token"]').value;
                const res = await fetch('/login', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: data
                });
                if (res.ok) {
                    const json = await res.json();
                    if (json.redirect) {
                        window.location.href = json.redirect;
                    } else {
                        window.location.reload();
                    }
                } else {
                    const json = await res.json().catch(() => ({ message: 'Login gagal' }));
                    alertBox.classList.remove('d-none');
                    alertBox.classList.remove('alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.textContent = json.message || 'Username atau password salah';
                }
            });
        </script>
    </div>
</body>
</html>
