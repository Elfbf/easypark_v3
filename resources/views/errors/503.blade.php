<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Layanan Sedang Tidak Tersedia | EasyPark Polije</title>
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
            --r-400: #E8503A;
            --r-600: #C73B27;
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
            background: rgba(232, 80, 58, 0.15);
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
            width: 260px;
            height: 260px;
            background: rgba(232, 183, 64, 0.08);
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

        /* Maintenance illustration — barrier + cone */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
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

        /* Barrier */
        .barrier-wrap {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: barrierBob 2.4s ease-in-out infinite alternate;
        }

        @keyframes barrierBob {
            from {
                transform: translateX(-50%) translateY(0)
            }

            to {
                transform: translateX(-50%) translateY(-6px)
            }
        }

        .barrier-pole {
            width: 6px;
            height: 60px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.55) 0%, rgba(255, 255, 255, 0.2) 100%);
            border-radius: 3px;
        }

        .barrier-bar {
            width: 160px;
            height: 16px;
            border-radius: 5px;
            background: repeating-linear-gradient(105deg,
                    rgba(232, 80, 58, 0.85) 0px, rgba(232, 80, 58, 0.85) 20px,
                    rgba(255, 255, 255, 0.75) 20px, rgba(255, 255, 255, 0.75) 40px);
            box-shadow: 0 4px 18px rgba(232, 80, 58, 0.3);
            margin-top: -1px;
            position: relative;
        }

        /* Blinking warning light on bar */
        .warn-light {
            position: absolute;
            top: -7px;
            left: 50%;
            transform: translateX(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--g-400);
            box-shadow: 0 0 10px var(--g-400);
            animation: blink 1s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 12px var(--g-400)
            }

            50% {
                opacity: .2;
                box-shadow: none
            }
        }

        /* Cones */
        .cone {
            position: absolute;
            bottom: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .cone-left {
            left: 14px;
        }

        .cone-right {
            right: 14px;
        }

        .cone-tip {
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 18px solid rgba(232, 183, 64, 0.75);
        }

        .cone-base {
            width: 22px;
            height: 6px;
            border-radius: 3px;
            background: rgba(232, 183, 64, 0.55);
        }

        /* Wrench icon floating */
        .wrench-float {
            position: absolute;
            top: 0;
            right: 10px;
            animation: wFlt 3.5s ease-in-out infinite alternate;
            opacity: .45;
        }

        @keyframes wFlt {
            from {
                transform: rotate(-15deg) translateY(0)
            }

            to {
                transform: rotate(15deg) translateY(-8px)
            }
        }

        /* 503 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(232, 80, 58, 0.65) 100%);
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
            background: rgba(232, 80, 58, 0.12);
            border: 1px solid rgba(232, 80, 58, 0.3);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 28px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--r-400);
            box-shadow: 0 0 10px var(--r-400);
            animation: blink 1s ease-in-out infinite;
        }

        .status-badge span {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Retry countdown */
        .retry-strip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 8px 14px;
            margin-bottom: 28px;
        }

        .retry-strip svg {
            width: 13px;
            height: 13px;
            color: rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .retry-strip p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.35);
            font-family: 'DM Sans', sans-serif;
        }

        .retry-strip strong {
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
            border: none;
            cursor: pointer;
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
            border: none;
            cursor: pointer;
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
            color: var(--r-400);
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

            <!-- Maintenance illustration -->
            <div class="illustration">
                <!-- Traffic cones -->
                <div class="cone cone-left">
                    <div class="cone-tip"></div>
                    <div class="cone-base"></div>
                </div>
                <div class="cone cone-right">
                    <div class="cone-tip"></div>
                    <div class="cone-base"></div>
                </div>
                <!-- Barrier -->
                <div class="barrier-wrap">
                    <div class="barrier-bar">
                        <div class="warn-light"></div>
                    </div>
                    <div class="barrier-pole"></div>
                </div>
                <!-- Floating wrench -->
                <div class="wrench-float">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="rgba(232,80,58,0.6)"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
                <div class="road"></div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Sistem Sedang Dalam Pemeliharaan</span>
            </div>

            <div class="error-code">503</div>
            <h1 class="error-title">Layanan Sedang Tidak Tersedia</h1>
            <p class="error-sub">
                EasyPark sedang dalam proses pemeliharaan atau peningkatan sistem.
                Tim kami sedang bekerja keras untuk memulihkan layanan secepatnya.
            </p>

            <!-- Retry info -->
            <div class="retry-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <p>Halaman ini akan <strong>refresh otomatis</strong> dalam <strong id="countdown">60</strong> detik</p>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Sementara itu</p>
            <div class="suggest-row">
                <a href="javascript:location.reload()" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Coba Muat Ulang
                </a>
                <a href="https://wa.me/62{{ config('app.support_phone', '') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    Hubungi Tim IT
                </a>
                <a href="{{ url('/#status') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Status Sistem
                </a>
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <button onclick="location.reload()" class="btn-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Muat Ulang
                </button>
                <a href="{{ url('/') }}" class="btn-gold">
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
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>503 Service
                Unavailable</span></p>
    </div>

    <script>
        // Auto-refresh countdown
        let secs = 60;
        const el = document.getElementById('countdown');
        const timer = setInterval(() => {
            secs--;
            if (el) el.textContent = secs;
            if (secs <= 0) {
                clearInterval(timer);
                location.reload();
            }
        }, 1000);
    </script>

</body>

</html>
