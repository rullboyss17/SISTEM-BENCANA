<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | SIPENKORBAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0c224a;
            --secondary-color: #2a5298;
            --accent-color: #df5361;
            --bg-soft: #f5f7fb;
        }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(12,34,74,0.95) 0%, rgba(42,82,152,0.9) 50%, rgba(223,83,97,0.75) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #111827;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .login-shell {
            width: min(1100px, 100%);
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }
        .login-hero {
            background: linear-gradient(160deg, rgba(12,34,74,0.95), rgba(42,82,152,0.9));
            color: white;
            padding: 2.25rem;
            position: relative;
        }
        .login-hero h1 { font-weight: 800; margin-bottom: 0.75rem; }
        .login-hero p { color: rgba(255,255,255,0.85); }
        .hero-badges span {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 999px;
            padding: 0.4rem 0.85rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
            color: white;
        }
        .login-card {
            padding: 2.25rem;
            background: var(--bg-soft);
        }
        .card-inner {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(42,82,152,0.15);
        }
        .btn-primary {
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            border: none;
            font-weight: 600;
        }
        .btn-primary:hover { filter: brightness(1.05); }
        .brand-mini {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            margin-bottom: 1rem;
        }
        .brand-mini i {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .error-box, .status-box {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }
        .error-box { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .status-box { background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; }
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .login-hero { padding: 1.75rem; }
            .login-card { padding: 1.75rem; }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <div class="login-hero">
            <a class="brand-mini" href="{{ route('dashboard') }}">
                <i class="fas fa-life-ring"></i>
                <span>SIPENKORBAN</span>
            </a>
            <h1>Selamat datang kembali</h1>
            <p>Sistem Pendataan Korban Bencana membantu petugas mencatat dan memantau kondisi korban secara cepat dan terstruktur.</p>
            <div class="hero-badges mt-3">
                <span><i class="fas fa-shield-alt"></i> Aman & Terlindungi</span>
                <span><i class="fas fa-bolt"></i> Cepat Dipakai</span>
                <span><i class="fas fa-mobile-alt"></i> Responsif</span>
            </div>
        </div>

        <div class="login-card d-flex align-items-center">
            <div class="card-inner w-100">
                <h5 class="fw-bold mb-3">Masuk sebagai Petugas</h5>
                <p class="text-muted mb-4">Gunakan akun terdaftar untuk melanjutkan.</p>

                @if (session('status'))
                    <div class="status-box">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="error-box">
                        <div class="fw-semibold mb-1">Ada yang perlu dicek:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa password?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
