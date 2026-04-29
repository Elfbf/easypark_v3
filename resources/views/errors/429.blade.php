<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 — Terlalu Banyak Permintaan | EasyPark Polije</title>
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
            --o-400: #F97316;
            --o-500: #EA6A0A;
            --o-600: #C2510A;
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
            background: linear-gradient(150deg, #071433 0%, #1A0E06 55%, #2A1200 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(249, 115, 22, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(249, 115, 22, 0.07) 1px, transparent 1px);
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
            background: rgba(249, 115, 22, 0.18);
            top: -140px;
            right: -90px;
        }

        .o2 {
            width: 380px;
            height: 380px;
            background: rgba(59, 111, 212, 0.14);
            bottom: -90px;
            left: -70px;
            animation-delay: 3s;
        }

        .o3 {
            width: 260px;
            height: 260px;
            background: rgba(232, 183, 64, 0.08);
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

        /* ── Illustration: portal masuk penuh antrian ── */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Gate / portal */
        .gate-wrap {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .gate-arch {
            width: 90px;
            height: 54px;
            border: 5px solid rgba(249, 115, 22, 0.55);
            border-bottom: none;
            border-radius: 45px 45px 0 0;
            position: relative;
        }

        /* Blinking red light on gate */
        .gate-light {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--o-400);
            box-shadow: 0 0 14px var(--o-400);
            animation: gBlink .7s ease-in-out infinite;
        }

        @keyframes gBlink {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 16px var(--o-400)
            }

            50% {
                opacity: .15;
                box-shadow: none
            }
        }

        .gate-body {
            width: 120px;
            height: 14px;
            background: rgba(249, 115, 22, 0.2);
            border: 1.5px solid rgba(249, 115, 22, 0.4);
            border-top: none;
            border-radius: 0 0 6px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gate-label {
            font-family: 'Syne', sans-serif;
            font-size: 7px;
            font-weight: 700;
            color: rgba(249, 115, 22, 0.7);
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        /* Boom barrier arm */
        .arm-wrap {
            position: absolute;
            top: 30px;
            left: -56px;
            display: flex;
            align-items: center;
            transform-origin: right center;
            animation: armBlock .6s cubic-bezier(.34, 1.56, .64, 1) .2s both;
        }

        @keyframes armBlock {
            from {
                transform: rotate(-80deg)
            }

            to {
                transform: rotate(0deg)
            }
        }

        .arm-pole {
            width: 6px;
            height: 44px;
            background: rgba(249, 115, 22, 0.5);
            border-radius: 3px;
            transform: rotate(90deg);
        }

        .arm-bar {
            width: 60px;
            height: 8px;
            border-radius: 4px;
            background: repeating-linear-gradient(90deg,
                    rgba(249, 115, 22, 0.85) 0px, rgba(249, 115, 22, 0.85) 8px,
                    rgba(255, 255, 255, 0.5) 8px, rgba(255, 255, 255, 0.5) 16px);
        }

        /* Queue cars */
        .cars {
            position: absolute;
            bottom: 8px;
            left: 0;
            display: flex;
            gap: 6px;
            align-items: flex-end;
        }

        .car {
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: carBob 2s ease-in-out infinite alternate;
        }

        .car:nth-child(2) {
            animation-delay: .4s;
        }

        .car:nth-child(3) {
            animation-delay: .8s;
        }

        @keyframes carBob {
            from {
                transform: translateY(0)
            }

            to {
                transform: translateY(-3px)
            }
        }

        .car-body {
            width: 32px;
            height: 14px;
            border-radius: 4px 4px 2px 2px;
            position: relative;
        }

        .car-roof {
            width: 20px;
            height: 8px;
            border-radius: 3px 3px 0 0;
            margin-bottom: -1px;
        }

        .car-wheels {
            display: flex;
            justify-content: space-between;
            width: 28px;
            margin-top: 1px;
        }

        .wheel {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
        }

        /* car colour variants */
        .c1 .car-body {
            background: rgba(59, 111, 212, 0.55);
            border: 1px solid rgba(59, 111, 212, 0.7);
        }

        .c1 .car-roof {
            background: rgba(59, 111, 212, 0.4);
        }

        .c2 .car-body {
            background: rgba(249, 115, 22, 0.45);
            border: 1px solid rgba(249, 115, 22, 0.65);
        }

        .c2 .car-roof {
            background: rgba(249, 115, 22, 0.35);
        }

        .c3 .car-body {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .c3 .car-roof {
            background: rgba(255, 255, 255, 0.08);
        }

        /* Floating speed-limit sign */
        .sign-float {
            position: absolute;
            top: 0;
            right: 8px;
            animation: sFlt 4s ease-in-out infinite alternate;
            opacity: .55;
        }

        @keyframes sFlt {
            from {
                transform: rotate(-6deg) translateY(0)
            }

            to {
                transform: rotate(6deg) translateY(-8px)
            }
        }

        /* Road */
        .road {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: rgba(59, 111, 212, 0.3);
            border-radius: 3px;
        }

        /* 429 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(249, 115, 22, 0.75) 100%);
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
            background: rgba(249, 115, 22, 0.12);
            border: 1px solid rgba(249, 115, 22, 0.3);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--o-400);
            box-shadow: 0 0 10px var(--o-400);
            animation: gBlink .7s ease-in-out infinite;
        }

        .status-badge span {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Cooldown strip */
        .cooldown-strip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 28px;
        }

        .cooldown-strip svg {
            width: 14px;
            height: 14px;
            color: var(--o-400);
            flex-shrink: 0;
        }

        .cooldown-strip p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.4);
        }

        .cooldown-strip strong {
            color: rgba(255, 255, 255, 0.7);
        }

        #cd-num {
            color: var(--o-400);
            font-weight: 700;
            font-size: 14px;
            font-family: 'Syne', sans-serif;
        }

        /* Rate bar */
        .rate-bar-wrap {
            margin-bottom: 28px;
        }

        .rate-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 6px;
        }

        .rate-bar-label span:last-child {
            color: var(--o-400);
            font-weight: 600;
        }

        .rate-bar-bg {
            height: 6px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.08);
            overflow: hidden;
        }

        .rate-bar-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--g-400) 0%, var(--o-400) 70%, #E8503A 100%);
            width: 100%;
            animation: barPulse 1.4s ease-in-out infinite alternate;
        }

        @keyframes barPulse {
            from {
                opacity: 1
            }

            to {
                opacity: .65
            }
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
            cursor: pointer;
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

        .suggest-chip:disabled,
        .suggest-chip.disabled {
            opacity: .35;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-orange {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--o-500);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-orange:hover {
            background: var(--o-600);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(234, 106, 10, 0.35);
        }

        .btn-orange:disabled {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.3);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-orange svg {
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
            color: var(--o-400);
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

            <!-- Gate + queue cars illustration -->
            <div class="illustration">

                <!-- Floating speed/limit sign -->
                <div class="sign-float">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="10" stroke="rgba(249,115,22,0.6)" stroke-width="1.5"
                            fill="rgba(249,115,22,0.08)" />
                        <text x="12" y="16" text-anchor="middle" font-family="Syne,sans-serif" font-size="8"
                            font-weight="800" fill="rgba(249,115,22,0.75)">!</text>
                    </svg>
                </div>

                <!-- Queue of cars -->
                <div class="cars">
                    <div class="car c3">
                        <div class="car-roof"></div>
                        <div class="car-body"></div>
                        <div class="car-wheels">
                            <div class="wheel"></div>
                            <div class="wheel"></div>
                        </div>
                    </div>
                    <div class="car c2">
                        <div class="car-roof"></div>
                        <div class="car-body"></div>
                        <div class="car-wheels">
                            <div class="wheel"></div>
                            <div class="wheel"></div>
                        </div>
                    </div>
                    <div class="car c1">
                        <div class="car-roof"></div>
                        <div class="car-body"></div>
                        <div class="car-wheels">
                            <div class="wheel"></div>
                            <div class="wheel"></div>
                        </div>
                    </div>
                </div>

                <!-- Gate with boom arm -->
                <div class="gate-wrap" style="position:absolute;bottom:8px;right:20px;">
                    <div class="gate-arch">
                        <div class="gate-light"></div>
                        <div class="arm-wrap">
                            <div class="arm-pole"></div>
                            <div class="arm-bar"></div>
                        </div>
                    </div>
                    <div class="gate-body">
                        <span class="gate-label">Portal Ditutup</span>
                    </div>
                </div>

                <div class="road"></div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Batas Permintaan Terlampaui</span>
            </div>

            <div class="error-code">429</div>
            <h1 class="error-title">Terlalu Banyak Permintaan</h1>
            <p class="error-sub">
                Anda telah mengirim terlalu banyak permintaan dalam waktu singkat.
                Seperti portal parkir yang penuh — sistem perlu istirahat sejenak sebelum menerima Anda kembali.
            </p>

            <!-- Rate limit bar -->
            <div class="rate-bar-wrap">
                <div class="rate-bar-label">
                    <span>Kapasitas permintaan</span>
                    <span>Penuh 100%</span>
                </div>
                <div class="rate-bar-bg">
                    <div class="rate-bar-fill"></div>
                </div>
            </div>

            <!-- Cooldown countdown -->
            <div class="cooldown-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <p>Coba lagi dalam <strong><span id="cd-num">60</span> detik</strong></p>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Sementara itu</p>
            <div class="suggest-row">
                <a id="retry-chip" class="suggest-chip disabled">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Coba Lagi
                </a>
                <a href="{{ url('/') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Ke Beranda
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
                @endauth
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <button id="retry-btn" class="btn-orange" disabled onclick="location.reload()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Coba Lagi (<span id="cd-btn">60</span>s)
                </button>
                <a href="{{ url('/') }}" class="btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Ke Beranda
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <div class="error-footer">
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>429 Too Many
                Requests</span></p>
    </div>

    <script>
        let secs = 60;
        const numEl = document.getElementById('cd-num');
        const btnEl = document.getElementById('cd-btn');
        const retryBtn = document.getElementById('retry-btn');
        const retryChip = document.getElementById('retry-chip');

        const timer = setInterval(() => {
            secs--;
            if (numEl) numEl.textContent = secs;
            if (btnEl) btnEl.textContent = secs;
            if (secs <= 0) {
                clearInterval(timer);
                retryBtn.disabled = false;
                retryBtn.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Coba Lagi Sekarang
            `;
                retryChip.classList.remove('disabled');
                retryChip.onclick = () => location.reload();
            }
        }, 1000);
    </script>

</body>

</html>
