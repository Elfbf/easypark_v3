<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 — Sesi Halaman Kedaluwarsa | EasyPark Polije</title>
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
            --a-400: #A855F7;
            --a-600: #7C3AED;
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
            background: linear-gradient(150deg, #071433 0%, #0C1F55 55%, #150A3A 100%);
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
            width: 480px;
            height: 480px;
            background: rgba(168, 85, 247, 0.18);
            top: -140px;
            right: -80px;
        }

        .o2 {
            width: 380px;
            height: 380px;
            background: rgba(59, 111, 212, 0.18);
            bottom: -90px;
            left: -70px;
            animation-delay: 3s;
        }

        .o3 {
            width: 260px;
            height: 260px;
            background: rgba(232, 183, 64, 0.07);
            top: 40%;
            left: 36%;
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

        /* Hourglass / expired ticket illustration */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Parking ticket */
        .ticket-wrap {
            position: relative;
            animation: tiltFlt 3.5s ease-in-out infinite alternate;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes tiltFlt {
            from {
                transform: rotate(-4deg) translateY(0)
            }

            to {
                transform: rotate(4deg) translateY(-10px)
            }
        }

        .ticket {
            width: 130px;
            background: rgba(255, 255, 255, 0.07);
            border: 1.5px solid rgba(168, 85, 247, 0.35);
            border-radius: 10px;
            padding: 10px 14px;
            position: relative;
            overflow: hidden;
        }

        /* Zigzag tear bottom */
        .ticket::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 8px;
            background: repeating-linear-gradient(90deg,
                    transparent 0px, transparent 6px,
                    #071433 6px, #071433 12px);
            clip-path: polygon(0 100%, 4% 0, 8% 100%, 12% 0, 16% 100%, 20% 0, 24% 100%, 28% 0, 32% 100%, 36% 0, 40% 100%, 44% 0, 48% 100%, 52% 0, 56% 100%, 60% 0, 64% 100%, 68% 0, 72% 100%, 76% 0, 80% 100%, 84% 0, 88% 100%, 92% 0, 96% 100%, 100% 0, 100% 100%);
        }

        .ticket-header {
            font-family: 'Syne', sans-serif;
            font-size: 9px;
            font-weight: 700;
            color: rgba(168, 85, 247, 0.6);
            letter-spacing: .1em;
            text-transform: uppercase;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            padding-bottom: 6px;
            margin-bottom: 8px;
            text-align: left;
        }

        .ticket-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .ticket-lbl {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.3);
        }

        .ticket-val {
            font-size: 9px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
        }

        .ticket-val.expired {
            color: rgba(232, 80, 58, 0.8);
        }

        .ticket-barcode {
            margin-top: 8px;
            display: flex;
            gap: 2px;
            justify-content: center;
            padding-bottom: 12px;
        }

        .bar {
            height: 18px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 1px;
        }

        /* X stamp overlay */
        .stamp {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .stamp-text {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: rgba(232, 80, 58, 0.75);
            border: 2px solid rgba(232, 80, 58, 0.5);
            border-radius: 6px;
            padding: 2px 8px;
            transform: rotate(-18deg);
            letter-spacing: .1em;
            animation: stampPop .5s cubic-bezier(.34, 1.56, .64, 1) .3s both;
        }

        @keyframes stampPop {
            from {
                opacity: 0;
                transform: rotate(-18deg) scale(.4)
            }

            to {
                opacity: 1;
                transform: rotate(-18deg) scale(1)
            }
        }

        /* Floating clock */
        .clock-float {
            position: absolute;
            top: 2px;
            right: 20px;
            animation: cFlt 4s ease-in-out infinite alternate;
            opacity: .5;
        }

        @keyframes cFlt {
            from {
                transform: translateY(0) rotate(-8deg)
            }

            to {
                transform: translateY(-10px) rotate(8deg)
            }
        }

        /* Road base */
        .road {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: rgba(59, 111, 212, 0.3);
            border-radius: 3px;
        }

        /* 419 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(168, 85, 247, 0.7) 100%);
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

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(168, 85, 247, 0.12);
            border: 1px solid rgba(168, 85, 247, 0.3);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--a-400);
            box-shadow: 0 0 10px var(--a-400);
            animation: sdPulse 2s ease-in-out infinite;
        }

        @keyframes sdPulse {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 10px var(--a-400)
            }

            50% {
                opacity: .4;
                box-shadow: none
            }
        }

        .status-badge span {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Info strip */
        .info-strip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 14px;
            margin-bottom: 28px;
        }

        .info-strip svg {
            width: 13px;
            height: 13px;
            color: rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .info-strip p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.35);
        }

        .info-strip strong {
            color: rgba(255, 255, 255, 0.6);
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
            cursor: pointer;
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

        .btn-purple {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--a-600);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-purple:hover {
            background: var(--a-400);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(124, 58, 237, 0.35);
        }

        .btn-purple svg {
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
            color: var(--a-400);
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

            <!-- Expired parking ticket illustration -->
            <div class="illustration">
                <div class="clock-float">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(168,85,247,0.55)"
                        stroke-width="1.5">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                        <!-- X over clock -->
                        <line x1="4" y1="4" x2="20" y2="20" stroke="rgba(232,80,58,0.5)"
                            stroke-width="1.5" />
                    </svg>
                </div>
                <div class="ticket-wrap">
                    <div class="ticket">
                        <div class="ticket-header">EasyPark · Tiket Sesi</div>
                        <div class="ticket-row">
                            <span class="ticket-lbl">Status</span>
                            <span class="ticket-val expired">KEDALUWARSA</span>
                        </div>
                        <div class="ticket-row">
                            <span class="ticket-lbl">Token</span>
                            <span class="ticket-val">••••••••</span>
                        </div>
                        <div class="ticket-row">
                            <span class="ticket-lbl">Berlaku</span>
                            <span class="ticket-val expired">Habis</span>
                        </div>
                        <div class="ticket-barcode">
                            <div class="bar" style="width:3px"></div>
                            <div class="bar" style="width:5px"></div>
                            <div class="bar" style="width:2px"></div>
                            <div class="bar" style="width:4px"></div>
                            <div class="bar" style="width:3px"></div>
                            <div class="bar" style="width:6px"></div>
                            <div class="bar" style="width:2px"></div>
                            <div class="bar" style="width:4px"></div>
                            <div class="bar" style="width:5px"></div>
                            <div class="bar" style="width:2px"></div>
                            <div class="bar" style="width:3px"></div>
                            <div class="bar" style="width:4px"></div>
                        </div>
                        <div class="stamp">
                            <div class="stamp-text">EXPIRED</div>
                        </div>
                    </div>
                </div>
                <div class="road"></div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Token Keamanan Kedaluwarsa</span>
            </div>

            <div class="error-code">419</div>
            <h1 class="error-title">Sesi Halaman Kedaluwarsa</h1>
            <p class="error-sub">
                Token keamanan (CSRF) untuk sesi ini sudah habis masa berlakunya.
                Ini biasanya terjadi karena halaman dibiarkan terlalu lama tanpa aktivitas.
            </p>

            <!-- Info strip -->
            <div class="info-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <p>Klik <strong>Muat Ulang Halaman</strong> untuk mendapatkan token baru, lalu coba lagi</p>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Yang bisa Anda lakukan</p>
            <div class="suggest-row">
                <a onclick="location.reload()" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Muat Ulang Halaman
                </a>
                <a href="{{ url()->previous() }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                    </svg>
                    Halaman Sebelumnya
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
                        Login Ulang
                    </a>
                @endauth
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <button onclick="location.reload()" class="btn-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Muat Ulang Halaman
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" />
                            <rect x="14" y="3" width="7" height="7" />
                            <rect x="3" y="14" width="7" height="7" />
                            <rect x="14" y="14" width="7" height="7" />
                        </svg>
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary">
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
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>419 Page
                Expired</span></p>
    </div>

</body>

</html>
