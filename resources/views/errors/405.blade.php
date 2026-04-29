<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 — Metode Tidak Diizinkan | EasyPark Polije</title>
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
            --t-400: #14B8A6;
            --t-500: #0D9488;
            --t-700: #0F766E;
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
            background: linear-gradient(150deg, #071433 0%, #041E1C 55%, #062422 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(20, 184, 166, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(20, 184, 166, 0.07) 1px, transparent 1px);
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
            width: 500px;
            height: 500px;
            background: rgba(20, 184, 166, 0.15);
            top: -150px;
            right: -100px;
        }

        .o2 {
            width: 380px;
            height: 380px;
            background: rgba(59, 111, 212, 0.16);
            bottom: -100px;
            left: -80px;
            animation-delay: 3s;
        }

        .o3 {
            width: 260px;
            height: 260px;
            background: rgba(232, 183, 64, 0.07);
            top: 40%;
            left: 38%;
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

        /* ── Illustration: wrong-way sign on road ── */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Wrong-way arrow sign */
        .sign-wrap {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: signBob 3.5s ease-in-out infinite alternate;
        }

        @keyframes signBob {
            from {
                transform: translateX(-50%) translateY(0)
            }

            to {
                transform: translateX(-50%) translateY(-8px)
            }
        }

        .sign-board {
            width: 110px;
            height: 46px;
            background: rgba(232, 80, 58, 0.15);
            border: 2px solid rgba(232, 80, 58, 0.5);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
        }

        /* Crossed arrow */
        .arrow-blocked {
            display: flex;
            align-items: center;
            gap: 4px;
            position: relative;
        }

        .arrow-shaft {
            width: 36px;
            height: 4px;
            background: rgba(255, 255, 255, 0.55);
            border-radius: 2px;
            position: relative;
        }

        .arrow-head {
            width: 0;
            height: 0;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            border-left: 11px solid rgba(255, 255, 255, 0.55);
        }

        /* big X over the arrow */
        .cross-line {
            position: absolute;
            inset: -4px;
            pointer-events: none;
        }

        .cross-line::before,
        .cross-line::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2.5px;
            background: rgba(232, 80, 58, 0.85);
            border-radius: 2px;
        }

        .cross-line::before {
            transform: translateY(-50%) rotate(25deg);
        }

        .cross-line::after {
            transform: translateY(-50%) rotate(-25deg);
        }

        .sign-text {
            font-family: 'Syne', sans-serif;
            font-size: 9px;
            font-weight: 800;
            color: rgba(232, 80, 58, 0.85);
            letter-spacing: .1em;
        }

        .sign-pole {
            width: 5px;
            height: 26px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
        }

        .sign-base {
            width: 26px;
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        /* Method chips on the road, approaching */
        .methods {
            position: absolute;
            bottom: 12px;
            left: 6px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .method-tag {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 8px;
            font-weight: 700;
            border-radius: 4px;
            padding: 2px 6px;
            letter-spacing: .06em;
        }

        .mt-get {
            background: rgba(59, 111, 212, 0.25);
            color: rgba(59, 111, 212, 0.85);
            border: 1px solid rgba(59, 111, 212, 0.35);
        }

        .mt-post {
            background: rgba(20, 184, 166, 0.2);
            color: rgba(20, 184, 166, 0.85);
            border: 1px solid rgba(20, 184, 166, 0.3);
            animation: tagBlink 1.1s ease-in-out infinite;
        }

        .mt-put {
            background: rgba(232, 183, 64, 0.2);
            color: rgba(232, 183, 64, 0.85);
            border: 1px solid rgba(232, 183, 64, 0.3);
        }

        @keyframes tagBlink {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .35
            }
        }

        /* Floating floating forbidden symbol */
        .forbid-float {
            position: absolute;
            top: 2px;
            right: 10px;
            animation: ffFlt 4s ease-in-out infinite alternate;
            opacity: .5;
        }

        @keyframes ffFlt {
            from {
                transform: translateY(0) rotate(-5deg)
            }

            to {
                transform: translateY(-9px) rotate(5deg)
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

        /* Road dashes */
        .road-dash {
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
            height: 2px;
            background: repeating-linear-gradient(90deg,
                    rgba(255, 255, 255, 0.25) 0px, rgba(255, 255, 255, 0.25) 16px,
                    transparent 16px, transparent 32px);
        }

        /* 405 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(20, 184, 166, 0.75) 100%);
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
            background: rgba(20, 184, 166, 0.1);
            border: 1px solid rgba(20, 184, 166, 0.3);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--t-400);
            box-shadow: 0 0 10px var(--t-400);
            animation: sdPls 1.8s ease-in-out infinite;
        }

        @keyframes sdPls {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 10px var(--t-400)
            }

            50% {
                opacity: .3;
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

        /* HTTP method panel */
        .method-panel {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(20, 184, 166, 0.18);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            text-align: left;
        }

        .method-panel-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(20, 184, 166, 0.55);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .method-panel-title svg {
            width: 12px;
            height: 12px;
        }

        .method-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .method-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .method-badge {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 5px;
            letter-spacing: .06em;
            flex-shrink: 0;
            width: 58px;
            text-align: center;
        }

        .mb-del {
            background: rgba(232, 80, 58, 0.18);
            color: rgba(232, 80, 58, 0.9);
            border: 1px solid rgba(232, 80, 58, 0.3);
        }

        .mb-put {
            background: rgba(232, 183, 64, 0.15);
            color: rgba(232, 183, 64, 0.9);
            border: 1px solid rgba(232, 183, 64, 0.3);
        }

        .mb-post {
            background: rgba(20, 184, 166, 0.15);
            color: rgba(20, 184, 166, 0.9);
            border: 1px solid rgba(20, 184, 166, 0.3);
        }

        .mb-get {
            background: rgba(59, 111, 212, 0.2);
            color: rgba(59, 111, 212, 0.9);
            border: 1px solid rgba(59, 111, 212, 0.35);
        }

        .method-desc {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
            flex: 1;
        }

        .method-status {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 100px;
        }

        .ms-blocked {
            background: rgba(232, 80, 58, 0.15);
            color: rgba(232, 80, 58, 0.8);
            border: 1px solid rgba(232, 80, 58, 0.25);
        }

        .ms-allowed {
            background: rgba(26, 122, 74, 0.15);
            color: rgba(39, 160, 107, 0.9);
            border: 1px solid rgba(26, 122, 74, 0.25);
        }

        /* Info strip */
        .info-strip {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(20, 184, 166, 0.07);
            border: 1px solid rgba(20, 184, 166, 0.18);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 28px;
            text-align: left;
        }

        .info-strip svg {
            width: 15px;
            height: 15px;
            color: var(--t-400);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-strip p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.38);
            line-height: 1.55;
        }

        .info-strip strong {
            color: rgba(255, 255, 255, 0.65);
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

        .btn-teal {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--t-500);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-teal:hover {
            background: var(--t-700);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(13, 148, 136, 0.35);
        }

        .btn-teal svg {
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
            color: var(--t-400);
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

            <!-- Wrong-way sign illustration -->
            <div class="illustration">

                <!-- Floating forbidden circle -->
                <div class="forbid-float">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="rgba(20,184,166,0.55)"
                        stroke-width="1.5">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
                    </svg>
                </div>

                <!-- HTTP method tags on the left -->
                <div class="methods">
                    <div class="method-tag mt-get">GET</div>
                    <div class="method-tag mt-post">POST</div>
                    <div class="method-tag mt-put">PUT</div>
                </div>

                <!-- Wrong-way sign -->
                <div class="sign-wrap">
                    <div class="sign-board">
                        <div class="arrow-blocked">
                            <div class="arrow-shaft"></div>
                            <div class="arrow-head"></div>
                            <div class="cross-line"></div>
                        </div>
                        <div class="sign-text">DILARANG</div>
                    </div>
                    <div class="sign-pole"></div>
                    <div class="sign-base"></div>
                </div>

                <div class="road">
                    <div class="road-dash"></div>
                </div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Metode HTTP Tidak Diizinkan</span>
            </div>

            <div class="error-code">405</div>
            <h1 class="error-title">Metode Tidak Diizinkan</h1>
            <p class="error-sub">
                Seperti masuk jalur yang salah di area parkir — permintaan Anda
                menggunakan metode HTTP yang tidak didukung oleh endpoint ini.
            </p>

            <!-- HTTP method panel -->
            <div class="method-panel">
                <div class="method-panel-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 18 22 12 16 6" />
                        <polyline points="8 6 2 12 8 18" />
                    </svg>
                    Status Metode HTTP
                </div>
                <div class="method-row">
                    <div class="method-badge mb-del">DELETE</div>
                    <div class="method-desc">Hapus resource</div>
                    <div class="method-status ms-blocked">Diblokir</div>
                </div>
                <div class="method-row">
                    <div class="method-badge mb-put">PUT</div>
                    <div class="method-desc">Perbarui resource</div>
                    <div class="method-status ms-blocked">Diblokir</div>
                </div>
                <div class="method-row">
                    <div class="method-badge mb-post">POST</div>
                    <div class="method-desc">Kirim data baru</div>
                    <div class="method-status ms-blocked">Diblokir</div>
                </div>
                <div class="method-row">
                    <div class="method-badge mb-get">GET</div>
                    <div class="method-desc">Ambil data / halaman</div>
                    <div class="method-status ms-allowed">Diizinkan</div>
                </div>
            </div>

            <!-- Info strip -->
            <div class="info-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <p>Ini biasanya terjadi karena <strong>pengiriman form duplikat</strong>, link yang sudah kadaluarsa,
                    atau akses langsung ke endpoint API. Coba <strong>kembali ke halaman sebelumnya</strong> dan ulangi
                    aksi Anda.</p>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Yang bisa Anda lakukan</p>
            <div class="suggest-row">
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
            </div>

            <!-- Buttons -->
            <div class="btn-row">
                <a href="javascript:history.back()" class="btn-teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                    </svg>
                    Kembali ke Halaman
                </a>
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
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>405 Method
                Not Allowed</span></p>
    </div>

</body>

</html>
