<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — EasyPark Polije Bondowoso</title>
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
            --g-400: #E8B740;
            --g-600: #C9960F;
            --n-50: #F5F7FC;
            --n-100: #EBEEF5;
            --n-200: #D4D9E8;
            --n-400: #8A93AE;
            --n-600: #4A5272;
            --n-900: #181D35;
            --err: #D92D20;
            --err-bg: #FEF3F2;
            --err-border: #FECDCA;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #071433;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* LEFT */
        .left-panel {
            display: none;
            flex: 1;
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
        }

        @media (min-width: 1024px) {
            .left-panel {
                display: flex;
            }
        }

        .left-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(150deg, #071433 0%, #0C2260 55%, #0E2F7A 100%);
        }

        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(59, 111, 212, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 111, 212, 0.1) 1px, transparent 1px);
            background-size: 56px 56px;
            animation: gridDrift 24s linear infinite;
        }

        @keyframes gridDrift {
            from { background-position: 0 0; }
            to   { background-position: 56px 56px; }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            animation: breathe 7s ease-in-out infinite alternate;
        }

        .orb-1 {
            width: 420px;
            height: 420px;
            background: rgba(59, 111, 212, 0.28);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: rgba(232, 183, 64, 0.15);
            bottom: 80px;
            right: -60px;
            animation-delay: 2.5s;
        }

        .orb-3 {
            width: 220px;
            height: 220px;
            background: rgba(59, 111, 212, 0.18);
            top: 45%;
            left: 38%;
            animation-delay: 4.5s;
        }

        @keyframes breathe {
            0%   { opacity: 0.5; transform: scale(1); }
            100% { opacity: 1;   transform: scale(1.18); }
        }

        .park-scene {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .park-wrapper {
            transform: perspective(900px) rotateX(22deg) rotateZ(-7deg);
            animation: sceneLift 4s ease-in-out infinite alternate;
        }

        @keyframes sceneLift {
            from { transform: perspective(900px) rotateX(22deg) rotateZ(-7deg) translateY(0); }
            to   { transform: perspective(900px) rotateX(22deg) rotateZ(-7deg) translateY(-14px); }
        }

        .park-road {
            width: 340px;
            height: 6px;
            background: rgba(59, 111, 212, 0.3);
            border-radius: 3px;
            margin-bottom: 14px;
        }

        .park-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .slot {
            width: 80px;
            height: 52px;
            border-radius: 6px;
            border: 1.5px solid rgba(59, 111, 212, 0.35);
            background: rgba(59, 111, 212, 0.07);
            position: relative;
        }

        .slot::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 55%;
            height: 2px;
            background: rgba(59, 111, 212, 0.35);
            border-radius: 1px;
        }

        .slot.taken {
            background: rgba(59, 111, 212, 0.2);
            border-color: var(--p-400);
        }

        .slot.taken::before {
            content: '';
            position: absolute;
            inset: 7px;
            border-radius: 3px;
            background: rgba(59, 111, 212, 0.38);
        }

        .slot.free {
            background: rgba(232, 183, 64, 0.1);
            border-color: var(--g-400);
            animation: slotBlink 2.2s ease-in-out infinite;
        }

        .slot.free::after {
            background: rgba(232, 183, 64, 0.45);
        }

        @keyframes slotBlink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.45; }
        }

        .left-content {
            position: relative;
            z-index: 10;
        }

        .polije-mark {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .polije-emblem {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .polije-emblem svg { width: 28px; height: 28px; }

        .polije-name p:first-child {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .polije-name p:last-child {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.42);
            margin-top: 2px;
        }

        .campus-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: rgba(59, 111, 212, 0.18);
            border: 1px solid rgba(59, 111, 212, 0.32);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 26px;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--g-400);
            box-shadow: 0 0 10px var(--g-400);
        }

        .campus-badge span {
            font-size: 11px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .left-heading {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.9rem, 2.8vw, 2.7rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.18;
            margin-bottom: 14px;
        }

        .left-heading em {
            font-style: normal;
            color: var(--g-400);
        }

        .left-sub {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.46);
            line-height: 1.75;
            max-width: 340px;
            margin-bottom: 36px;
        }

        .stats-row { display: flex; gap: 28px; }

        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .stat-label {
            font-size: 11.5px;
            color: rgba(255, 255, 255, 0.36);
            margin-top: 2px;
        }

        /* RIGHT */
        .right-panel {
            width: 100%;
            background: var(--n-50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            position: relative;
            overflow-y: auto;
        }

        @media (min-width: 1024px) {
            .right-panel {
                width: 560px;
                flex-shrink: 0;
            }
        }

        .right-inner {
            width: 100%;
            max-width: 460px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 36px;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: var(--p-800);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box svg { width: 24px; height: 24px; }

        .logo-wordmark {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--n-900);
            letter-spacing: -0.02em;
        }

        .logo-wordmark span { color: var(--p-600); }

        .logo-sep {
            width: 1px;
            height: 22px;
            background: var(--n-200);
            margin: 0 2px;
        }

        .logo-campus {
            font-size: 11.5px;
            color: var(--n-400);
            line-height: 1.35;
        }

        .logo-campus strong {
            display: block;
            color: var(--n-600);
            font-weight: 600;
            font-size: 12px;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.8rem 2.5rem;
            box-shadow: 0 4px 32px rgba(14, 47, 122, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        .form-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--n-900);
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--n-400);
            line-height: 1.55;
            margin-bottom: 28px;
        }

        /* Fields */
        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--n-600);
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; }

        .i-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--n-400);
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap input {
            width: 100%;
            height: 52px;
            padding: 0 46px;
            border: 1.5px solid var(--n-200);
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14.5px;
            color: var(--n-900);
            background: var(--n-50);
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .input-wrap input.is-error {
            border-color: var(--err);
            background: var(--err-bg);
        }

        .input-wrap input.is-error:focus {
            border-color: var(--err);
            box-shadow: 0 0 0 4px rgba(217, 45, 32, 0.1);
        }

        .input-wrap input::placeholder { color: #B3BBCC; }

        .input-wrap input:focus {
            border-color: var(--p-400);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 111, 212, 0.1);
        }

        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--n-400);
            transition: color 0.2s;
        }

        .eye-btn:hover { color: var(--n-600); }

        /* Error message */
        .err-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 6px;
            font-size: 12px;
            color: var(--err);
        }

        .err-msg svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* Global error alert */
        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--err-bg);
            border: 1px solid var(--err-border);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
        }

        .alert-error svg {
            width: 15px;
            height: 15px;
            color: var(--err);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error p {
            font-size: 12.5px;
            color: var(--err);
            line-height: 1.5;
        }

        .flex-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .check-label input {
            width: 15px;
            height: 15px;
            accent-color: var(--p-600);
            cursor: pointer;
        }

        .check-label span {
            font-size: 13px;
            color: var(--n-600);
        }

        .forgot-link {
            font-size: 13px;
            color: var(--p-600);
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-link:hover { text-decoration: underline; }

        .btn-submit {
            width: 100%;
            height: 52px;
            background: var(--p-800);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            letter-spacing: 0.01em;
            transition: background 0.2s, transform 0.12s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--p-900);
            box-shadow: 0 8px 28px rgba(7, 28, 82, 0.32);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .info-strip {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--p-50);
            border: 1px solid var(--p-100);
            border-radius: 10px;
            padding: 11px 14px;
            margin-top: 18px;
        }

        .info-strip svg {
            width: 15px;
            height: 15px;
            color: var(--p-600);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-strip p {
            font-size: 12.5px;
            color: var(--p-800);
            line-height: 1.5;
        }

        .ai { animation: fadeUp 0.5s ease both; }
        .ai:nth-child(1) { animation-delay: 0.04s; }
        .ai:nth-child(2) { animation-delay: 0.09s; }
        .ai:nth-child(3) { animation-delay: 0.14s; }
        .ai:nth-child(4) { animation-delay: 0.19s; }
        .ai:nth-child(5) { animation-delay: 0.24s; }
        .ai:nth-child(6) { animation-delay: 0.29s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="left-bg"></div>
        <div class="grid-overlay"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="park-scene">
            <div class="park-wrapper">
                <div class="park-road"></div>
                <div class="park-row">
                    <div class="slot taken"></div>
                    <div class="slot free"></div>
                    <div class="slot taken"></div>
                    <div class="slot taken"></div>
                </div>
                <div class="park-road"></div>
                <div class="park-row">
                    <div class="slot taken"></div>
                    <div class="slot taken"></div>
                    <div class="slot free"></div>
                    <div class="slot taken"></div>
                </div>
            </div>
        </div>

        <div class="left-content">
            <div class="polije-mark">
                <div class="polije-emblem">
                    <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2L3 7.5v6.5c0 5.5 4.7 9.8 11 11 6.3-1.2 11-5.5 11-11V7.5L14 2z"
                            stroke="rgba(255,255,255,0.75)" stroke-width="1.5" fill="rgba(255,255,255,0.07)" />
                        <path d="M9 14h10M14 10v8" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div class="polije-name">
                    <p>Politeknik Negeri Jember</p>
                    <p>Kampus 2 — Bondowoso</p>
                </div>
            </div>

            <div class="campus-badge">
                <div class="badge-dot"></div>
                <span>Sistem Parkir Aktif</span>
            </div>

            <h1 class="left-heading">Kelola parkir kampus<br>lebih <em>tertib & aman</em></h1>
            <p class="left-sub">Platform manajemen parkir digital untuk sivitas akademika Polije Bondowoso — pantau
                slot, catat kendaraan, dan kendalikan akses secara real-time.</p>

            <div class="stats-row">
                <div>
                    <div class="stat-num">3 Zona</div>
                    <div class="stat-label">Area Parkir</div>
                </div>
                <div>
                    <div class="stat-num">200+</div>
                    <div class="stat-label">Slot Terdaftar</div>
                </div>
                <div>
                    <div class="stat-num">Real-Time</div>
                    <div class="stat-label">Monitoring</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="right-inner">

            <div class="logo-row">
                <div class="logo-box">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9" />
                        <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5" />
                        <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75" />
                    </svg>
                </div>
                <span class="logo-wordmark">Easy<span>Park</span></span>
                <div class="logo-sep"></div>
                <div class="logo-campus">
                    <strong>Polije Bondowoso</strong>
                    Kampus 2
                </div>
            </div>

            <div class="form-card">
                <div class="ai">
                    <h2 class="form-title">Masuk ke Sistem 👋</h2>
                    <p class="form-subtitle">Masukkan kredensial akun Anda untuk melanjutkan</p>
                </div>

                {{-- Global session error --}}
                @if (session('error'))
                    <div class="alert-error ai">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field ai">
                        <label for="identifier">Email / ID Pengguna</label>
                        <div class="input-wrap">
                            <svg class="i-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M20 21a8 8 0 10-16 0" />
                            </svg>
                            <input type="text"
                                id="identifier"
                                name="identifier"
                                value="{{ old('identifier') }}"
                                placeholder="Masukkan email atau ID pengguna"
                                class="{{ $errors->has('identifier') ? 'is-error' : '' }}"
                                autocomplete="username"
                                required>
                        </div>
                        @error('identifier')
                            <div class="err-msg">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="field ai">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <svg class="i-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                class="{{ $errors->has('password') ? 'is-error' : '' }}"
                                autocomplete="current-password"
                                required>
                            <button type="button" class="eye-btn" onclick="togglePwd(this)" aria-label="Toggle password">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:16px;height:16px;">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="err-msg">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex-row ai">
                        <label class="check-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>
                        <a href="forgot-password" class="forgot-link">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-submit ai">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width:18px;height:18px;">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Masuk ke Sistem
                    </button>

                    <div class="info-strip ai">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p>Gunakan email atau ID yang telah diberikan oleh pengelola sistem parkir kampus.</p>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function togglePwd(btn) {
            const input = btn.closest('.input-wrap').querySelector('input');
            const icon = btn.querySelector('svg');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>

</body>

</html>