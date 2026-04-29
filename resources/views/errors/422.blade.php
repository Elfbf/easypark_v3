<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>422 — Data Tidak Dapat Diproses | EasyPark Polije</title>
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
            --v-400: #F59E0B;
            --v-500: #D97706;
            --v-600: #B45309;
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
            background: linear-gradient(150deg, #071433 0%, #1A1200 55%, #221800 100%);
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(245, 158, 11, 0.07) 1px, transparent 1px), linear-gradient(90deg, rgba(245, 158, 11, 0.07) 1px, transparent 1px);
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
            background: rgba(245, 158, 11, 0.15);
            top: -150px;
            right: -100px;
        }

        .o2 {
            width: 380px;
            height: 380px;
            background: rgba(59, 111, 212, 0.15);
            bottom: -100px;
            left: -80px;
            animation-delay: 3s;
        }

        .o3 {
            width: 260px;
            height: 260px;
            background: rgba(232, 80, 58, 0.08);
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

        /* ── Illustration: broken clipboard / form ── */
        .illustration {
            position: relative;
            width: 240px;
            height: 130px;
            margin: 0 auto 36px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        /* Clipboard */
        .clipboard-wrap {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            animation: clipBob 3.5s ease-in-out infinite alternate;
        }

        @keyframes clipBob {
            from {
                transform: translateX(-50%) translateY(0) rotate(-2deg)
            }

            to {
                transform: translateX(-50%) translateY(-8px) rotate(2deg)
            }
        }

        .clipboard {
            width: 96px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(245, 158, 11, 0.35);
            border-radius: 8px;
            padding: 10px 10px 12px;
            position: relative;
        }

        /* Clip at top */
        .clip-top {
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 28px;
            height: 10px;
            background: rgba(245, 158, 11, 0.4);
            border-radius: 4px 4px 0 0;
            border: 1px solid rgba(245, 158, 11, 0.55);
        }

        /* Form fields on clipboard */
        .cf {
            margin-bottom: 7px;
        }

        .cf-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 6px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .cf-input {
            height: 9px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .cf-input.ok {
            border-color: rgba(26, 122, 74, 0.5);
            background: rgba(26, 122, 74, 0.1);
        }

        .cf-input.error {
            border-color: rgba(232, 80, 58, 0.55);
            background: rgba(232, 80, 58, 0.1);
            animation: shakeField .4s ease-in-out infinite alternate;
        }

        .cf-input.warn {
            border-color: rgba(245, 158, 11, 0.5);
            background: rgba(245, 158, 11, 0.08);
        }

        @keyframes shakeField {
            from {
                transform: translateX(-1.5px)
            }

            to {
                transform: translateX(1.5px)
            }
        }

        /* Value fill inside input */
        .cf-fill {
            position: absolute;
            top: 2px;
            left: 4px;
            height: 5px;
            border-radius: 2px;
        }

        .cf-fill.ok {
            width: 55px;
            background: rgba(26, 122, 74, 0.55);
        }

        .cf-fill.err {
            width: 30px;
            background: rgba(232, 80, 58, 0.55);
        }

        .cf-fill.warn {
            width: 42px;
            background: rgba(245, 158, 11, 0.45);
        }

        /* Error dot on field */
        .cf-err-dot {
            position: absolute;
            right: 3px;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(232, 80, 58, 0.8);
            animation: ledBlink .5s ease-in-out infinite;
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

        /* Warning triangle float */
        .warn-float {
            position: absolute;
            top: 0;
            right: 10px;
            animation: wFlt 4s ease-in-out infinite alternate;
            opacity: .55;
        }

        @keyframes wFlt {
            from {
                transform: translateY(0) rotate(-5deg)
            }

            to {
                transform: translateY(-10px) rotate(5deg)
            }
        }

        /* Error count badge */
        .err-count {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(232, 80, 58, 0.9);
            border: 2px solid rgba(7, 20, 51, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 9px;
            font-weight: 800;
            color: #fff;
            animation: popIn .4s cubic-bezier(.34, 1.56, .64, 1) .3s both;
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(.3)
            }

            to {
                opacity: 1;
                transform: scale(1)
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

        /* 422 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.85) 0%, rgba(245, 158, 11, 0.8) 100%);
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
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--v-400);
            box-shadow: 0 0 10px var(--v-400);
            animation: sdPls 1.6s ease-in-out infinite;
        }

        @keyframes sdPls {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 10px var(--v-400)
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

        /* Validation error list */
        .val-panel {
            background: rgba(0, 0, 0, 0.28);
            border: 1px solid rgba(245, 158, 11, 0.18);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 16px;
            text-align: left;
        }

        .val-panel-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(245, 158, 11, 0.55);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .val-panel-title svg {
            width: 12px;
            height: 12px;
        }

        .val-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .val-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .val-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .val-icon.err {
            background: rgba(232, 80, 58, 0.15);
            border: 1px solid rgba(232, 80, 58, 0.3);
        }

        .val-icon.warn {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .val-icon svg {
            width: 10px;
            height: 10px;
        }

        .val-icon.err svg {
            color: rgba(232, 80, 58, 0.9);
        }

        .val-icon.warn svg {
            color: rgba(245, 158, 11, 0.9);
        }

        .val-body {
            flex: 1;
        }

        .val-field {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 10px;
            font-weight: 700;
            color: rgba(245, 158, 11, 0.75);
            background: rgba(245, 158, 11, 0.08);
            border: 1px solid rgba(245, 158, 11, 0.2);
            border-radius: 4px;
            padding: 1px 6px;
            display: inline-block;
            margin-bottom: 3px;
        }

        .val-msg {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.38);
            line-height: 1.4;
        }

        .val-msg strong {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Info strip */
        .info-strip {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: rgba(245, 158, 11, 0.07);
            border: 1px solid rgba(245, 158, 11, 0.18);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 28px;
            text-align: left;
        }

        .info-strip svg {
            width: 15px;
            height: 15px;
            color: var(--v-400);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-strip p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.38);
            line-height: 1.6;
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

        .btn-amber {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 11px;
            background: var(--v-500);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }

        .btn-amber:hover {
            background: var(--v-600);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(180, 83, 9, 0.4);
        }

        .btn-amber svg {
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
            color: var(--v-400);
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

            <!-- Broken clipboard / form illustration -->
            <div class="illustration">

                <!-- Floating warning triangle -->
                <div class="warn-float">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="rgba(245,158,11,0.6)"
                        stroke-width="1.5">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>

                <!-- Clipboard form -->
                <div class="clipboard-wrap">
                    <div class="clipboard">
                        <div class="clip-top"></div>

                        <!-- Error count badge -->
                        <div class="err-count">3</div>

                        <!-- Field 1: OK -->
                        <div class="cf">
                            <div class="cf-label">NIM / ID</div>
                            <div class="cf-input ok">
                                <div class="cf-fill ok"></div>
                            </div>
                        </div>

                        <!-- Field 2: Error -->
                        <div class="cf">
                            <div class="cf-label">No. Plat</div>
                            <div class="cf-input error">
                                <div class="cf-fill err"></div>
                                <div class="cf-err-dot"></div>
                            </div>
                        </div>

                        <!-- Field 3: Warn -->
                        <div class="cf">
                            <div class="cf-label">Jenis Kendaraan</div>
                            <div class="cf-input warn">
                                <div class="cf-fill warn"></div>
                            </div>
                        </div>

                        <!-- Field 4: Error -->
                        <div class="cf" style="margin-bottom:0">
                            <div class="cf-label">Email</div>
                            <div class="cf-input error">
                                <div class="cf-fill err"></div>
                                <div class="cf-err-dot"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="road"></div>
            </div>

            <!-- Status badge -->
            <div class="status-badge">
                <div class="status-dot"></div>
                <span>Validasi Data Gagal</span>
            </div>

            <div class="error-code">422</div>
            <h1 class="error-title">Data Tidak Dapat Diproses</h1>
            <p class="error-sub">
                Seperti formulir parkir yang diisi tidak lengkap atau salah format —
                data yang dikirim sudah diterima server, namun gagal melewati validasi.
            </p>

            <!-- Validation error panel -->
            <div class="val-panel">
                <div class="val-panel-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    Kesalahan Validasi
                </div>

                <div class="val-item">
                    <div class="val-icon err">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                    <div class="val-body">
                        <div class="val-field">nomor_plat</div>
                        <p class="val-msg">Format tidak valid — gunakan format <strong>AB 1234 CD</strong></p>
                    </div>
                </div>

                <div class="val-item">
                    <div class="val-icon err">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                    <div class="val-body">
                        <div class="val-field">email</div>
                        <p class="val-msg">Alamat email tidak valid atau tidak terdaftar di sistem</p>
                    </div>
                </div>

                <div class="val-item">
                    <div class="val-icon warn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                    <div class="val-body">
                        <div class="val-field">jenis_kendaraan</div>
                        <p class="val-msg">Nilai tidak ada dalam pilihan yang tersedia</p>
                    </div>
                </div>
            </div>

            <!-- Info strip -->
            <div class="info-strip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <p>Kembali ke halaman sebelumnya, <strong>periksa kembali semua isian</strong>, lalu kirim ulang.
                    Pastikan format data sesuai dengan petunjuk yang tertera di setiap kolom.</p>
            </div>

            <div class="divider"></div>

            <!-- Suggestions -->
            <p class="suggest-label">Yang bisa Anda lakukan</p>
            <div class="suggest-row">
                <a href="javascript:history.back()" class="suggest-chip">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                    </svg>
                    Perbaiki Isian
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
                <a href="javascript:history.back()" class="btn-amber">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Perbaiki & Kirim Ulang
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
        <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>422
                Unprocessable Entity</span></p>
    </div>

</body>

</html>
