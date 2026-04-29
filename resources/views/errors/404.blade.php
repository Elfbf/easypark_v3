<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | EasyPark Polije</title>
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

        /* BG */
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
            background: rgba(59, 111, 212, 0.22);
            top: -150px;
            right: -100px;
        }

        .o2 {
            width: 400px;
            height: 400px;
            background: rgba(232, 183, 64, 0.1);
            bottom: -100px;
            left: -80px;
            animation-delay: 3s;
        }

        .o3 {
            width: 260px;
            height: 260px;
            background: rgba(59, 111, 212, 0.15);
            top: 38%;
            left: 35%;
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

        .nav-campus {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.38);
        }

        /* Main */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 5;
        }

        .error-wrap {
            max-width: 580px;
            width: 100%;
            text-align: center;
            animation: fadeUp .55s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        /* Parking slot illustration */
        .illustration {
            position: relative;
            width: 220px;
            height: 120px;
            margin: 0 auto 36px;
        }

        .road {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: rgba(59, 111, 212, 0.3);
            border-radius: 3px;
        }

        .slot-row {
            display: flex;
            gap: 10px;
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
        }

        .sl {
            width: 52px;
            height: 80px;
            border-radius: 8px;
            border: 1.5px solid rgba(59, 111, 212, 0.35);
            background: rgba(59, 111, 212, 0.07);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 10px;
            font-weight: 700;
            color: rgba(59, 111, 212, 0.4);
        }

        .sl::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: rgba(59, 111, 212, 0.3);
            border-radius: 1px;
        }

        .sl.taken {
            background: rgba(59, 111, 212, 0.18);
            border-color: var(--p-400);
        }

        .sl.taken::before {
            content: '';
            position: absolute;
            inset: 7px;
            border-radius: 4px;
            background: rgba(59, 111, 212, 0.35);
        }

        /* The "missing" slot */
        .sl.missing {
            border: 2px dashed rgba(232, 183, 64, 0.4);
            background: rgba(232, 183, 64, 0.05);
            color: rgba(232, 183, 64, 0.5);
            animation: missingPulse 2s ease-in-out infinite;
        }

        .sl.missing::after {
            background: rgba(232, 183, 64, 0.3);
        }

        @keyframes missingPulse {

            0%,
            100% {
                opacity: 1;
                border-color: rgba(232, 183, 64, 0.4)
            }

            50% {
                opacity: .5;
                border-color: rgba(232, 183, 64, 0.15)
            }
        }

        /* Question mark floating above missing slot */
        .qmark {
            position: absolute;
            top: -32px;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--g-400);
            animation: qFloat 2s ease-in-out infinite alternate;
        }

        @keyframes qFloat {
            from {
                transform: translateX(-50%) translateY(0)
            }

            to {
                transform: translateX(-50%) translateY(-6px)
            }
        }

        /* 404 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(59, 111, 212, 0.7) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            margin-bottom: 12px;
        }

        .error-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 14px;
        }

        .error-sub {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.46);
            line-height: 1.75;
            margin-bottom: 16px;
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
        }

        /* URL strip */
        .url-strip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 14px;
            margin-bottom: 32px;
        }

        .url-strip svg {
            width: 13px;
            height: 13px;
            color: rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .url-strip code {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.35);
            font-family: 'DM Mono', 'Courier New', monospace;
            word-break: break-all;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.07);
            margin-bottom: 28px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Suggestions */
        .suggest-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .suggest-row {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .suggest-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.04);
            font-size: 13px;
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: border-color .2s, color .2s, background .2s;
        }

        .suggest-chip:hover {
            border-color: rgba(255, 255, 255, .3);
            color: #fff;
            background: rgba(255, 255, 255, .08);
        }

        .suggest-chip svg {
            width: 13px;
            height: 13px;
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
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--p-800);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
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

        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--g-400);
            color: var(--p-900);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-gold:hover {
            background: var(--g-300);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(232, 183, 64, 0.25);
        }

        .btn-gold svg {
            width: 16px;
            height: 16px;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            border: 1.5px solid rgba(255, 255, 255, 0.18);
            color: rgba(255, 255, 255, 0.75);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            background: transparent;
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
            <span class="nav-campus">Polije Bondowoso · Kampus 2</span>
        </div>
    </nav>

    <!-- Main -->
    <main>
        <div class="error-wrap">

            <!-- Parking slot illustration -->
            <div class="illustration">
                <div class="slot-row">
                    <div class="sl taken"></div>
                    <div class="sl missing">
                        <div class="qmark">?</div>
                        ???
                    </div>
                    <div class="sl taken"></div>
                </div>
                <div class="road"></div>
            </div>

            <div class="error-code">404</div>
            <h1 class="error-title">Halaman Tidak Ditemukan</h1>
            <p class="error-sub">
                Seperti slot parkir yang tidak terdaftar — halaman yang Anda cari
                tidak ada, sudah dipindahkan, atau URL-nya salah.
            </p>

            <!-- URL yang dicoba diakses -->
            <div class="url-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                </svg>
                <code>{{ request()->url() }}</code>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Mungkin Anda mencari</p>
            <div class="suggest-row">
                <a href="{{ url('/') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Beranda
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="suggest-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="suggest-chip">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Login
                    </a>
                @endauth
                <a href="{{ url('/#faq') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    Bantuan
                </a>
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <a href="javascript:history.back()" class="btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                    </svg>
                    Kembali
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn-gold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Ke Beranda
                    </a>
                @endauth
            </div>

        </div>
    </main>

    <!-- Footer -->
    <div class="error-footer">
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>404 Not
                Found</span></p>
    </div>

</body>

</html>
