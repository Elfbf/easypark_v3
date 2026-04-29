<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Kesalahan Server | EasyPark Polije</title>
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
            --e-400: #E8503A;
            --e-500: #D4412C;
            --e-600: #B83020;
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
            background: linear-gradient(150deg, #071433 0%, #1C0808 55%, #2A0A0A 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(232, 80, 58, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(232, 80, 58, 0.07) 1px, transparent 1px);
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
            filter: blur(110px);
            animation: breathe 8s ease-in-out infinite alternate;
        }

        .o1 {
            width: 520px;
            height: 520px;
            background: rgba(232, 80, 58, 0.2);
            top: -160px;
            left: -100px;
        }

        .o2 {
            width: 400px;
            height: 400px;
            background: rgba(59, 111, 212, 0.14);
            bottom: -100px;
            right: -80px;
            animation-delay: 3s;
        }

        .o3 {
            width: 280px;
            height: 280px;
            background: rgba(232, 183, 64, 0.07);
            top: 42%;
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

        /* ── Illustration: crashed server / smoking machine ── */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Server unit */
        .server-wrap {
            position: relative;
            animation: sShk 0.18s ease-in-out infinite alternate;
        }

        @keyframes sShk {
            from {
                transform: translateX(-1px)
            }

            to {
                transform: translateX(1px)
            }
        }

        .server {
            width: 100px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(232, 80, 58, 0.35);
            border-radius: 10px;
            overflow: hidden;
        }

        .server-unit {
            padding: 6px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .server-unit:last-child {
            border-bottom: none;
        }

        .unit-led {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .led-off {
            background: rgba(255, 255, 255, 0.15);
        }

        .led-err {
            background: var(--e-400);
            box-shadow: 0 0 8px var(--e-400);
            animation: ledBlink .5s ease-in-out infinite;
        }

        .led-warn {
            background: var(--g-400);
            box-shadow: 0 0 8px var(--g-400);
            animation: ledBlink .9s ease-in-out infinite;
        }

        @keyframes ledBlink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .1
            }
        }

        .unit-bar-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .unit-bar {
            height: 3px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.1);
        }

        .unit-bar.err {
            background: rgba(232, 80, 58, 0.5);
        }

        .unit-bar.short {
            width: 60%;
        }

        .unit-bar.med {
            width: 80%;
        }

        /* Smoke puffs */
        .smokes {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .smoke {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(200, 200, 200, 0.25);
            animation: smokeDrift 2s ease-out infinite;
        }

        .smoke:nth-child(2) {
            animation-delay: .5s;
            width: 8px;
            height: 8px;
        }

        .smoke:nth-child(3) {
            animation-delay: 1s;
            width: 6px;
            height: 6px;
        }

        @keyframes smokeDrift {
            0% {
                opacity: .7;
                transform: translateY(0) scale(1);
            }

            100% {
                opacity: 0;
                transform: translateY(-30px) scale(2.5);
            }
        }

        /* Floating error code chip */
        .err-chip-float {
            position: absolute;
            top: 4px;
            right: 10px;
            animation: ecFlt 3s ease-in-out infinite alternate;
            opacity: .65;
        }

        @keyframes ecFlt {
            from {
                transform: translateY(0) rotate(-4deg)
            }

            to {
                transform: translateY(-8px) rotate(4deg)
            }
        }

        .err-chip {
            background: rgba(232, 80, 58, 0.15);
            border: 1px solid rgba(232, 80, 58, 0.4);
            border-radius: 6px;
            padding: 3px 8px;
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 9px;
            font-weight: 700;
            color: rgba(232, 80, 58, 0.9);
            letter-spacing: .08em;
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

        /* 500 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(232, 80, 58, 0.75) 100%);
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
            border: 1px solid rgba(232, 80, 58, 0.32);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--e-400);
            box-shadow: 0 0 10px var(--e-400);
            animation: ledBlink .5s ease-in-out infinite;
        }

        .status-badge span {
            font-size: 12px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Traceback / log strip */
        .log-strip {
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(232, 80, 58, 0.2);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 28px;
            text-align: left;
            font-family: 'DM Mono', 'Courier New', monospace;
        }

        .log-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(232, 80, 58, 0.6);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .log-title::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--e-400);
            box-shadow: 0 0 8px var(--e-400);
            display: inline-block;
            animation: ledBlink .5s ease-in-out infinite;
        }

        .log-line {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
            line-height: 1.8;
        }

        .log-line .kw {
            color: rgba(232, 80, 58, 0.7);
        }

        .log-line .fn {
            color: rgba(59, 111, 212, 0.7);
        }

        .log-line .str {
            color: rgba(232, 183, 64, 0.6);
        }

        .log-line .dim {
            color: rgba(255, 255, 255, 0.12);
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

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-red {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--e-500);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
            text-decoration: none;
        }

        .btn-red:hover {
            background: var(--e-600);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(184, 48, 32, 0.4);
        }

        .btn-red svg {
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
            color: var(--e-400);
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

            <!-- Smoking server illustration -->
            <div class="illustration">

                <!-- Floating error chip -->
                <div class="err-chip-float">
                    <div class="err-chip">INTERNAL_ERROR</div>
                </div>

                <div class="server-wrap">
                    <!-- Smoke puffs -->
                    <div class="smokes">
                        <div class="smoke"></div>
                        <div class="smoke"></div>
                        <div class="smoke"></div>
                    </div>

                    <div class="server">
                        <div class="server-unit">
                            <div class="unit-led led-err"></div>
                            <div class="unit-bar-wrap">
                                <div class="unit-bar err med"></div>
                                <div class="unit-bar short"></div>
                            </div>
                        </div>
                        <div class="server-unit">
                            <div class="unit-led led-warn"></div>
                            <div class="unit-bar-wrap">
                                <div class="unit-bar med"></div>
                                <div class="unit-bar err short"></div>
                            </div>
                        </div>
                        <div class="server-unit">
                            <div class="unit-led led-off"></div>
                            <div class="unit-bar-wrap">
                                <div class="unit-bar short"></div>
                                <div class="unit-bar med"></div>
                            </div>
                        </div>
                        <div class="server-unit">
                            <div class="unit-led led-err"></div>
                            <div class="unit-bar-wrap">
                                <div class="unit-bar err"></div>
                                <div class="unit-bar short"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="road"></div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Kesalahan Internal Server</span>
            </div>

            <div class="error-code">500</div>
            <h1 class="error-title">Ups, Ada yang Salah di Server</h1>
            <p class="error-sub">
                Terjadi kesalahan yang tidak terduga pada server EasyPark.
                Tim teknis kami sudah otomatis diberitahu dan sedang menangani masalah ini.
            </p>

            <!-- Fake traceback log -->
            <div class="log-strip">
                <div class="log-title">Server Log</div>
                <div class="log-line"><span class="kw">ERROR</span> <span
                        class="dim">[{{ now()->format('Y-m-d H:i:s') }}]</span></div>
                <div class="log-line"><span class="fn">Illuminate\Foundation\Exceptions</span></div>
                <div class="log-line"><span class="kw">Uncaught</span> <span
                        class="str">InternalServerException</span></div>
                <div class="log-line"><span class="dim">#0 request() → handle() → render()</span></div>
                <div class="log-line"><span class="kw">→</span> Tim IT telah diberitahu secara otomatis</div>
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
                    Muat Ulang
                </a>
                <a href="javascript:history.back()" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ url('/') }}" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Ke Beranda
                </a>
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <button onclick="location.reload()" class="btn-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10" />
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                    </svg>
                    Coba Muat Ulang
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
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>500 Internal
                Server Error</span></p>
    </div>

</body>

</html>
