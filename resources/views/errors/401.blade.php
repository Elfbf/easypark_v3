<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 — Akses Tidak Diizinkan | EasyPark Polije</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --p-50:#E8F0FB; --p-100:#C0D3F5; --p-200:#93B3EE; --p-400:#3B6FD4;
            --p-600:#1A4BAD; --p-800:#0E2F7A; --p-900:#071C52;
            --g-300:#F5CE6E; --g-400:#E8B740;
            --n-50:#F5F7FC; --n-100:#EBEEF5; --n-200:#D4D9E8;
            --n-400:#8A93AE; --n-600:#4A5272; --n-900:#181D35;
            --c-400:#06B6D4; --c-500:#0EA5C9; --c-700:#0E7490;
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
        .bg-layer { position: fixed; inset: 0; z-index: 0; }
        .bg-gradient { position: absolute; inset: 0; background: linear-gradient(150deg, #071433 0%, #04182E 55%, #062038 100%); }
        .bg-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(6,182,212,0.07) 1px,transparent 1px), linear-gradient(90deg,rgba(6,182,212,0.07) 1px,transparent 1px);
            background-size: 60px 60px;
            animation: gridDrift 30s linear infinite;
        }
        @keyframes gridDrift { from{background-position:0 0} to{background-position:60px 60px} }
        .orb { position: absolute; border-radius: 50%; filter: blur(110px); animation: breathe 8s ease-in-out infinite alternate; }
        .o1 { width: 500px; height: 500px; background: rgba(6,182,212,0.16); top: -150px; left: -100px; }
        .o2 { width: 380px; height: 380px; background: rgba(59,111,212,0.18); bottom: -100px; right: -80px; animation-delay: 3s; }
        .o3 { width: 260px; height: 260px; background: rgba(232,183,64,0.07); top: 40%; left: 38%; animation-delay: 5s; }
        @keyframes breathe { 0%{opacity:.5;transform:scale(1)} 100%{opacity:1;transform:scale(1.2)} }

        /* Navbar */
        nav {
            position: relative; z-index: 10;
            padding: 0 2rem;
            background: rgba(7,20,51,0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .nav-inner { max-width: 1200px; margin: 0 auto; height: 64px; display: flex; align-items: center; justify-content: space-between; }
        .nav-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; }
        .nav-logo-box { width: 34px; height: 34px; background: var(--p-400); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .nav-logo-box svg { width: 20px; height: 20px; }
        .nav-wordmark { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; letter-spacing: -.02em; }
        .nav-wordmark span { color: var(--g-400); }
        .nav-campus { font-size: 12px; color: rgba(255,255,255,0.38); }

        /* Main */
        main {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 2rem; position: relative; z-index: 5;
        }

        .error-wrap {
            max-width: 580px; width: 100%; text-align: center;
            animation: fadeUp .55s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes fadeUp { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }

        /* ── Illustration: ID card scanner denied ── */
        .illustration {
            position: relative;
            width: 240px; height: 130px;
            margin: 0 auto 36px;
            display: flex; align-items: flex-end; justify-content: center;
        }

        /* Scanner device */
        .scanner-wrap {
            position: absolute;
            bottom: 8px; right: 22px;
            display: flex; flex-direction: column; align-items: center;
        }
        .scanner-head {
            width: 42px; height: 56px;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(6,182,212,0.35);
            border-radius: 8px;
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 5px;
            position: relative; overflow: hidden;
        }
        /* Scan line sweep */
        .scan-line {
            position: absolute; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, transparent, rgba(6,182,212,0.7), transparent);
            animation: scanSwp 1.8s ease-in-out infinite;
        }
        @keyframes scanSwp { 0%{top:6px;opacity:0} 20%{opacity:1} 80%{opacity:1} 100%{top:48px;opacity:0} }

        .scanner-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: rgba(232,80,58,0.85);
            box-shadow: 0 0 12px rgba(232,80,58,0.8);
            animation: denyBlink .5s ease-in-out infinite;
        }
        @keyframes denyBlink { 0%,100%{opacity:1;box-shadow:0 0 14px rgba(232,80,58,0.8)} 50%{opacity:.15;box-shadow:none} }

        .scanner-label-txt {
            font-family: 'Syne', sans-serif; font-size: 6px; font-weight: 700;
            color: rgba(232,80,58,0.75); letter-spacing: .12em;
        }
        .scanner-pole {
            width: 5px; height: 22px;
            background: rgba(255,255,255,0.15); border-radius: 3px;
        }
        .scanner-base {
            width: 28px; height: 6px;
            background: rgba(255,255,255,0.1);
            border-radius: 3px;
        }

        /* ID card */
        .card-wrap {
            position: absolute;
            bottom: 30px; left: 16px;
            animation: cardSwipe 3.5s ease-in-out infinite;
        }
        @keyframes cardSwipe {
            0%   { transform: translate(0,0) rotate(-12deg); opacity: 1; }
            35%  { transform: translate(44px, -12px) rotate(-6deg); opacity: 1; }
            50%  { transform: translate(46px, -10px) rotate(-4deg); opacity: 1; }
            65%  { transform: translate(28px, 4px) rotate(-10deg); opacity: .7; }
            100% { transform: translate(0,0) rotate(-12deg); opacity: 1; }
        }
        .id-card {
            width: 58px; height: 38px;
            background: rgba(59,111,212,0.18);
            border: 1.5px solid rgba(59,111,212,0.45);
            border-radius: 6px; padding: 5px 7px;
            position: relative;
        }
        .id-photo {
            width: 12px; height: 14px;
            background: rgba(59,111,212,0.45);
            border-radius: 2px; float: left; margin-right: 5px;
        }
        .id-lines { display: flex; flex-direction: column; gap: 3px; margin-top: 1px; }
        .id-line {
            height: 2.5px; border-radius: 2px;
            background: rgba(255,255,255,0.2);
        }
        .id-line.short { width: 18px; }
        .id-line.long  { width: 28px; }
        /* denied X overlay */
        .id-deny {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 800;
            color: rgba(232,80,58,0.8);
            animation: denyPop .4s cubic-bezier(.34,1.56,.64,1) .5s both;
        }
        @keyframes denyPop { from{opacity:0;transform:scale(.3)} to{opacity:1;transform:scale(1)} }

        /* Floating padlock */
        .lock-float {
            position: absolute; top: 2px; right: 8px;
            animation: lkFlt 4s ease-in-out infinite alternate; opacity: .5;
        }
        @keyframes lkFlt { from{transform:translateY(0) rotate(-6deg)} to{transform:translateY(-10px) rotate(6deg)} }

        /* Road */
        .road {
            position: absolute; bottom: 0; left: 0; right: 0; height: 6px;
            background: rgba(59,111,212,0.3); border-radius: 3px;
        }

        /* 401 */
        .error-code {
            font-family: 'Syne', sans-serif;
            font-size: 7rem; font-weight: 800;
            line-height: 1; letter-spacing: -.05em;
            color: transparent;
            background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(6,182,212,0.75) 100%);
            -webkit-background-clip: text; background-clip: text;
            margin-bottom: 12px;
        }
        .error-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem; font-weight: 700;
            color: #fff; margin-bottom: 14px;
        }
        .error-sub {
            font-size: 15px; color: rgba(255,255,255,0.46);
            line-height: 1.75; margin-bottom: 16px;
            max-width: 420px; margin-left: auto; margin-right: auto;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(6,182,212,0.1);
            border: 1px solid rgba(6,182,212,0.3);
            border-radius: 100px; padding: 7px 16px;
            margin-bottom: 20px;
        }
        .status-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--c-400); box-shadow: 0 0 10px var(--c-400);
            animation: sdPls 1.6s ease-in-out infinite;
        }
        @keyframes sdPls { 0%,100%{opacity:1;box-shadow:0 0 10px var(--c-400)} 50%{opacity:.3;box-shadow:none} }
        .status-badge span { font-size: 12px; font-weight: 500; color: rgba(255,255,255,0.6); letter-spacing: .06em; text-transform: uppercase; }

        /* Auth info strip */
        .auth-strip {
            display: flex; align-items: flex-start; gap: 12px;
            background: rgba(6,182,212,0.07);
            border: 1px solid rgba(6,182,212,0.2);
            border-radius: 10px; padding: 13px 16px;
            margin-bottom: 28px; text-align: left;
        }
        .auth-strip svg { width: 16px; height: 16px; color: var(--c-400); flex-shrink: 0; margin-top: 1px; }
        .auth-strip-body { flex: 1; }
        .auth-strip-title { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 3px; }
        .auth-strip-sub   { font-size: 12px; color: rgba(255,255,255,0.38); line-height: 1.55; }

        /* Access checklist */
        .check-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 28px; }
        .check-item {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 9px; padding: 10px 14px;
        }
        .check-icon {
            width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .check-icon.pass { background: rgba(26,122,74,0.2); border: 1px solid rgba(26,122,74,0.35); }
        .check-icon.fail { background: rgba(232,80,58,0.15); border: 1px solid rgba(232,80,58,0.3); }
        .check-icon.warn { background: rgba(232,183,64,0.12); border: 1px solid rgba(232,183,64,0.3); }
        .check-icon svg { width: 13px; height: 13px; }
        .check-icon.pass svg { color: #27a06b; }
        .check-icon.fail svg { color: rgba(232,80,58,0.9); }
        .check-icon.warn svg { color: var(--g-400); }
        .check-text { flex: 1; text-align: left; }
        .check-text p:first-child { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.75); }
        .check-text p:last-child  { font-size: 11.5px; color: rgba(255,255,255,0.3); margin-top: 1px; }

        /* Divider */
        .divider { height: 1px; background: rgba(255,255,255,0.07); margin-bottom: 28px; max-width: 320px; margin-left: auto; margin-right: auto; }

        /* Suggestions */
        .suggest-label { font-size: 12px; color: rgba(255,255,255,0.3); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 12px; }
        .suggest-row { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; margin-bottom: 28px; }
        .suggest-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 100px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.04);
            font-size: 13px; color: rgba(255,255,255,0.55);
            text-decoration: none; cursor: pointer;
            transition: border-color .2s, color .2s, background .2s;
        }
        .suggest-chip:hover { border-color: rgba(255,255,255,.3); color: #fff; background: rgba(255,255,255,.08); }
        .suggest-chip svg { width: 13px; height: 13px; }

        /* Buttons */
        .btn-row { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn-cyan {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 26px; border-radius: 11px;
            background: var(--c-500); color: #fff;
            font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: background .2s, transform .12s, box-shadow .2s;
        }
        .btn-cyan:hover { background: var(--c-700); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(14,165,201,0.35); }
        .btn-cyan svg { width: 16px; height: 16px; }
        .btn-gold {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 26px; border-radius: 11px;
            background: var(--g-400); color: var(--p-900);
            font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
            text-decoration: none;
            transition: background .2s, transform .12s, box-shadow .2s;
        }
        .btn-gold:hover { background: var(--g-300); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(232,183,64,0.25); }
        .btn-gold svg { width: 16px; height: 16px; }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 26px; border-radius: 11px;
            border: 1.5px solid rgba(255,255,255,0.18); color: rgba(255,255,255,0.75);
            font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500;
            text-decoration: none; background: transparent; cursor: pointer;
            transition: border-color .2s, color .2s, background .2s;
        }
        .btn-secondary:hover { border-color: rgba(255,255,255,.45); color: #fff; background: rgba(255,255,255,.06); }
        .btn-secondary svg { width: 16px; height: 16px; }

        /* Footer */
        .error-footer {
            position: relative; z-index: 5;
            padding: 16px 2rem; text-align: center;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .error-footer p { font-size: 12px; color: rgba(255,255,255,0.2); }
        .error-footer span { color: var(--c-400); }
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
                    <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9"/>
                    <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5"/>
                    <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75"/>
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

        <!-- ID card scanner illustration -->
        <div class="illustration">

            <!-- Floating padlock -->
            <div class="lock-float">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(6,182,212,0.55)" stroke-width="1.5">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            <!-- ID card being swiped -->
            <div class="card-wrap">
                <div class="id-card">
                    <div class="id-photo"></div>
                    <div class="id-lines">
                        <div class="id-line long"></div>
                        <div class="id-line short"></div>
                    </div>
                    <div class="id-deny">✕</div>
                </div>
            </div>

            <!-- Scanner -->
            <div class="scanner-wrap">
                <div class="scanner-head">
                    <div class="scan-line"></div>
                    <div class="scanner-dot"></div>
                    <div class="scanner-label-txt">DENIED</div>
                </div>
                <div class="scanner-pole"></div>
                <div class="scanner-base"></div>
            </div>

            <div class="road"></div>
        </div>

        <!-- Status badge -->
        <div class="status-badge">
            <div class="status-dot"></div>
            <span>Autentikasi Diperlukan</span>
        </div>

        <div class="error-code">401</div>
        <h1 class="error-title">Akses Tidak Diizinkan</h1>
        <p class="error-sub">
            Seperti kartu akses yang ditolak di pintu masuk parkir —
            Anda perlu login terlebih dahulu untuk mengakses halaman ini.
        </p>

        <!-- Auth info strip -->
        <div class="auth-strip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div class="auth-strip-body">
                <p class="auth-strip-title">Sesi tidak terdeteksi</p>
                <p class="auth-strip-sub">Halaman ini memerlukan autentikasi yang valid. Silakan login dengan akun EasyPark Anda untuk melanjutkan.</p>
            </div>
        </div>

        <!-- Access checklist -->
        <div class="check-list">
            <div class="check-item">
                <div class="check-icon fail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <div class="check-text">
                    <p>Sesi Login</p>
                    <p>Tidak ada sesi aktif yang terdeteksi</p>
                </div>
            </div>
            <div class="check-item">
                <div class="check-icon warn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div class="check-text">
                    <p>Hak Akses</p>
                    <p>Perlu verifikasi identitas terlebih dahulu</p>
                </div>
            </div>
            <div class="check-item">
                <div class="check-icon pass">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="check-text">
                    <p>Koneksi Server</p>
                    <p>Server EasyPark aktif dan berjalan normal</p>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Suggestions -->
        <p class="suggest-label">Langkah selanjutnya</p>
        <div class="suggest-row">
            <a href="{{ route('login') }}" class="suggest-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Login
            </a>
            <a href="{{ url('/') }}" class="suggest-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Ke Beranda
            </a>
            <a href="javascript:history.back()" class="suggest-chip">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M5 12l7 7M5 12l7-7"/></svg>
                Kembali
            </a>
        </div>

        <!-- Buttons -->
        <div class="btn-row">
            <a href="{{ route('login') }}" class="btn-cyan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Login Sekarang
            </a>
            <a href="{{ url('/') }}" class="btn-secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Ke Beranda
            </a>
        </div>

    </div>
</main>

<!-- Footer -->
<div class="error-footer">
    <p>© {{ date('Y') }} EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Kode Error: <span>401 Unauthorized</span></p>
</div>

</body>
</html>