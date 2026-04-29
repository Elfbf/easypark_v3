<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | EasyPark Polije</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Syne:wght@700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --p-50: #E8F0FB;
            --p-100: #C0D3F5;
            --p-200: #93B3EE;
            --p-400: #3B6FD4;
            --p-600: #1A4BAD;
            --p-800: #0E2F7A;
            --p-900: #071C52;
            --g-300: #F5CE6E;
            --g-400: #E8B740;
            --r-50: #FEF2F2;
            --r-100: #FEE2E2;
            --r-400: #F87171;
            --r-600: #DC2626;
            --r-800: #991B1B;
            --n-50: #F5F7FC;
            --n-100: #EBEEF5;
            --n-200: #D4D9E8;
            --n-400: #8A93AE;
            --n-600: #4A5272;
            --n-900: #181D35;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #071433;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* BG effects */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
        }

        .bg-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(150deg, #071433 0%, #0C2260 55%, #0E2F7A 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(59, 111, 212, 0.09) 1px, transparent 1px), linear-gradient(90deg, rgba(59, 111, 212, 0.09) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridDrift 30s linear infinite;
        }

        @keyframes gridDrift {
            from {
                background-position: 0 0
            }

            to {
                background-position: 60px 60px
            }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            animation: breathe 8s ease-in-out infinite alternate;
        }

        .o1 {
            width: 500px;
            height: 500px;
            background: rgba(220, 38, 38, 0.12);
            top: -150px;
            right: -100px;
        }

        .o2 {
            width: 400px;
            height: 400px;
            background: rgba(59, 111, 212, 0.18);
            bottom: -100px;
            left: -80px;
            animation-delay: 3s;
        }

        .o3 {
            width: 250px;
            height: 250px;
            background: rgba(220, 38, 38, 0.08);
            top: 40%;
            left: 40%;
            animation-delay: 5s;
        }

        @keyframes breathe {
            0% {
                opacity: .5;
                transform: scale(1)
            }

            100% {
                opacity: 1;
                transform: scale(1.2)
            }
        }

        /* Navbar */
        nav {
            position: relative;
            z-index: 10;
            padding: 0 2rem;
            background: rgba(7, 20, 51, 0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
        }

        .nav-logo-box {
            width: 34px;
            height: 34px;
            background: var(--p-400);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logo-box svg {
            width: 20px;
            height: 20px;
        }

        .nav-wordmark {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.02em;
        }

        .nav-wordmark span {
            color: var(--g-400);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-campus {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.38);
        }

        /* Main content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 5;
        }

        .error-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            backdrop-filter: blur(20px);
            max-width: 520px;
            width: 100%;
            text-align: center;
            animation: cardIn .5s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: scale(.9) translateY(20px)
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0)
            }
        }

        /* Lock icon */
        .error-icon-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 28px;
        }

        .error-icon-pulse {
            position: absolute;
            inset: -12px;
            border-radius: 50%;
            border: 1.5px solid rgba(220, 38, 38, 0.25);
            animation: ripple 2s ease-out infinite;
        }

        .error-icon-pulse:nth-child(2) {
            inset: -24px;
            animation-delay: .6s;
        }

        @keyframes ripple {
            0% {
                opacity: .8;
                transform: scale(.8)
            }

            100% {
                opacity: 0;
                transform: scale(1)
            }
        }

        .error-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.12);
            border: 2px solid rgba(220, 38, 38, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .error-icon svg {
            width: 44px;
            height: 44px;
            color: var(--r-400);
        }

        /* 403 label */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 5rem;
            font-weight: 800;
            color: transparent;
            background: linear-gradient(135deg, rgba(248, 113, 113, 0.9) 0%, rgba(220, 38, 38, 0.7) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            line-height: 1;
            margin-bottom: 8px;
            letter-spacing: -.04em;
        }

        .error-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
        }

        .error-sub {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.48);
            line-height: 1.75;
            margin-bottom: 28px;
        }

        /* Role badge */
        .role-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.25);
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 28px;
        }

        .role-info svg {
            width: 15px;
            height: 15px;
            color: var(--r-400);
            flex-shrink: 0;
        }

        .role-info p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        .role-info strong {
            color: var(--r-400);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin-bottom: 24px;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 11px;
            background: var(--p-800);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-primary:hover {
            background: var(--p-900);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(7, 28, 82, 0.4);
        }

        .btn-primary svg {
            width: 16px;
            height: 16px;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 11px;
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            color: rgba(255, 255, 255, 0.75);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            background: transparent;
            cursor: pointer;
            transition: border-color .2s, color .2s, background .2s;
        }

        .btn-secondary:hover {
            border-color: rgba(255, 255, 255, .45);
            color: #fff;
            background: rgba(255, 255, 255, .06);
        }

        .btn-secondary svg {
            width: 16px;
            height: 16px;
        }

        /* Footer */
        .error-footer {
            position: relative;
            z-index: 5;
            padding: 16px 2rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .error-footer p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.2);
        }

        .error-footer span {
            color: var(--g-400);
        }
    </style>
</head>

<body>

    <div class="bg-layer">
        <div class="bg-gradient"></div>
        <div class="bg-grid"></div>
        <div class="orb o1"></div>
        <div class="orb o2"></div>
        <div class="orb o3"></div>
    </div>

    <!-- Navbar -->
    <nav>
        <div class="nav-inner">
            <a class="nav-logo" href="{{ url('/') }}">
                <div class="nav-logo-box">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9" />
                        <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5" />
                        <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75" />
                    </svg>
                </div>
                <span class="nav-wordmark">Easy<span>Park</span></span>
            </a>
            <div class="nav-right">
                <span class="nav-campus">Polije Bondowoso · Kampus 2</span>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <main>
        <div class="error-card">

            <!-- Icon -->
            <div class="error-icon-wrap">
                <div class="error-icon-pulse"></div>
                <div class="error-icon-pulse"></div>
                <div class="error-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        <circle cx="12" cy="16" r="1.5" fill="currentColor" stroke="none" />
                    </svg>
                </div>
            </div>

            <div class="error-code">403</div>
            <h1 class="error-title">Akses Ditolak</h1>
            <p class="error-sub">
                Anda tidak memiliki izin untuk mengakses halaman ini.
                Setiap peran hanya dapat mengakses area yang sesuai dengan hak aksesnya.
            </p>

            <!-- Role info -->
            <div class="role-info">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                @auth
                    <p>Anda login sebagai <strong>{{ ucfirst(Auth::user()->role->name) }}</strong> — halaman ini tidak
                        tersedia untuk peran Anda.</p>
                @else
                    <p>Anda belum login atau sesi telah berakhir.</p>
                @endauth
            </div>

            <div class="divider"></div>

            <!-- Buttons -->
            <div class="btn-row">
                @auth
                    <a href="{{ url()->previous() }}" class="btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Ke Dashboard Saya
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Halaman Utama
                    </a>
                    <a href="{{ route('login') }}" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Login Ulang
                    </a>
                @endauth
            </div>

        </div>
    </main>

    <!-- Footer -->
    <div class="error-footer">
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>403
                Forbidden</span></p>
    </div>

</body>

</html>
