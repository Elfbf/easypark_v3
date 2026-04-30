<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Syne:wght@700;800&display=swap"
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
        --success: #12B76A;
        --success-bg: #ECFDF3;
        --warn: #F79009;
        --warn-bg: #FFFAEB;
        --sidebar-w: 260px;
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--n-50);
        color: var(--n-900);
        display: flex;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        width: var(--sidebar-w);
        flex-shrink: 0;
        background: linear-gradient(160deg, #071433 0%, #0C2260 60%, #0E2F7A 100%);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 100;
        transition: transform .3s ease;
        overflow: hidden;
    }

    .sidebar::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(59, 111, 212, 0.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 111, 212, 0.07) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
        animation: gridDrift 20s linear infinite;
    }

    @keyframes gridDrift {
        from { background-position: 0 0; }
        to   { background-position: 40px 40px; }
    }

    .sb-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
    }

    .sb-orb-1 { width: 260px; height: 260px; background: rgba(59, 111, 212, 0.22); top: -80px; right: -60px; }
    .sb-orb-2 { width: 180px; height: 180px; background: rgba(232, 183, 64, 0.10); bottom: 60px; left: -40px; }

    .sb-header {
        position: relative;
        z-index: 1;
        padding: 24px 20px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .sb-logo { display: flex; align-items: center; gap: 10px; }

    .sb-logo-box {
        width: 36px; height: 36px;
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .sb-logo-box svg { width: 20px; height: 20px; }

    .sb-wordmark {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -0.02em;
    }

    .sb-wordmark span { color: var(--g-400); }
    .sb-campus { font-size: 10.5px; color: rgba(255, 255, 255, 0.38); margin-top: 2px; }

    .sb-user {
        position: relative;
        z-index: 1;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sb-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--p-600);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 13px; font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        border: 1.5px solid rgba(255, 255, 255, 0.15);
    }

    .sb-uname { font-size: 13px; font-weight: 600; color: #fff; }
    .sb-urole { font-size: 10.5px; color: rgba(255, 255, 255, 0.42); margin-top: 1px; }

    .sb-badge {
        margin-left: auto;
        background: rgba(232, 183, 64, 0.18);
        border: 1px solid rgba(232, 183, 64, 0.35);
        border-radius: 100px;
        padding: 2px 8px;
        font-size: 10px; font-weight: 600;
        color: var(--g-400);
        white-space: nowrap;
    }

    .sb-nav {
        position: relative;
        z-index: 1;
        flex: 1;
        padding: 16px 12px;
        overflow-y: auto;
    }

    .sb-nav::-webkit-scrollbar { width: 0; }

    .sb-section-label {
        font-size: 10px; font-weight: 600;
        color: rgba(255, 255, 255, 0.28);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 4px 8px 8px;
    }

    .sb-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: background .18s;
        margin-bottom: 2px;
    }

    .sb-item:hover { background: rgba(255, 255, 255, 0.07); }

    .sb-item.active {
        background: rgba(59, 111, 212, 0.25);
        box-shadow: inset 0 0 0 1px rgba(59, 111, 212, 0.40);
    }

    .sb-item svg {
        width: 17px; height: 17px;
        flex-shrink: 0;
        color: rgba(255, 255, 255, 0.42);
        transition: color .18s;
    }

    .sb-item:hover svg,
    .sb-item.active svg { color: rgba(255, 255, 255, 0.90); }

    .sb-item span {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.58);
        font-weight: 500;
        transition: color .18s;
    }

    .sb-item:hover span,
    .sb-item.active span { color: #fff; }

    .sb-badge-count {
        margin-left: auto;
        background: var(--err);
        border-radius: 100px;
        padding: 1px 7px;
        font-size: 10px; font-weight: 600;
        color: #fff;
        line-height: 1.6;
    }

    .sb-footer {
        position: relative;
        z-index: 1;
        padding: 14px 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .status-dot { display: flex; align-items: center; gap: 8px; padding: 8px 12px; }
    .dot-live { width: 7px; height: 7px; border-radius: 50%; background: var(--success); box-shadow: 0 0 8px var(--success); flex-shrink: 0; }
    .status-dot span { font-size: 11.5px; color: rgba(255, 255, 255, 0.42); }

    /* ── MAIN ── */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    /* ── TOPBAR ── */
    .topbar {
        background: #fff;
        border-bottom: 1px solid var(--n-200);
        padding: 0 32px;
        height: 64px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .tb-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13.5px; }
    .tb-breadcrumb .crumb     { color: var(--n-400); }
    .tb-breadcrumb .crumb-sep { color: var(--n-200); }
    .tb-breadcrumb .crumb-cur { color: var(--n-900); font-weight: 600; }
    .tb-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }

    .tb-search {
        display: flex; align-items: center; gap: 8px;
        background: var(--n-50);
        border: 1.5px solid var(--n-200);
        border-radius: 10px;
        padding: 0 14px;
        height: 38px; width: 220px;
        transition: border-color .2s, box-shadow .2s;
    }

    .tb-search:focus-within {
        border-color: var(--p-400);
        box-shadow: 0 0 0 4px rgba(59, 111, 212, 0.10);
    }

    .tb-search svg   { width: 14px; height: 14px; color: var(--n-400); flex-shrink: 0; }
    .tb-search input { border: none; background: none; outline: none; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--n-900); width: 100%; }
    .tb-search input::placeholder { color: var(--n-400); }

    .tb-btn {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: var(--n-50);
        border: 1.5px solid var(--n-200);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background .18s, border-color .18s;
        position: relative;
        flex-shrink: 0;
    }

    .tb-btn:hover { background: var(--n-100); border-color: var(--n-400); }
    .tb-btn svg   { width: 17px; height: 17px; color: var(--n-600); }

    .tb-notif-dot {
        position: absolute; top: 6px; right: 6px;
        width: 7px; height: 7px;
        background: var(--err);
        border-radius: 50%;
        border: 1.5px solid #fff;
    }

    .tb-avatar {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: var(--p-800);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 12px; font-weight: 700;
        color: #fff;
        cursor: pointer; flex-shrink: 0;
        border: 1.5px solid var(--p-600);
    }

    /* ── PAGE ── */
    .page { padding: 32px; flex: 1; }

    .page-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
    }

    .page-title { font-family: 'Syne', sans-serif; font-size: 1.45rem; font-weight: 800; color: var(--n-900); line-height: 1.2; }
    .page-sub   { font-size: 13.5px; color: var(--n-400); margin-top: 4px; }
    .page-head-actions { display: flex; gap: 10px; flex-shrink: 0; }

    .btn-outline {
        height: 38px; padding: 0 18px;
        border: 1.5px solid var(--n-200);
        border-radius: 10px;
        background: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; font-weight: 500;
        color: var(--n-600);
        cursor: pointer;
        display: flex; align-items: center; gap: 7px;
        transition: background .18s, border-color .18s;
    }

    .btn-outline:hover { background: var(--n-50); border-color: var(--n-400); }
    .btn-outline svg   { width: 15px; height: 15px; }

    .sb-logout-btn{
        width:100%;
        border:none;
        background:transparent;
        cursor:pointer;
        text-align:left;
    }

    .lm-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(7, 18, 52, 0.55);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }

        .lm-overlay.show {
            display: flex;
        }

        .lm-box {
            background: #fff;
            border-radius: 18px;
            padding: 32px 28px 24px;
            width: 320px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(7, 18, 52, 0.18);
            animation: lmIn .2s ease;
        }

        @keyframes lmIn {
            from {
                opacity: 0;
                transform: scale(.94) translateY(8px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .lm-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--err-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .lm-icon svg {
            width: 22px;
            height: 22px;
            color: var(--err);
        }

        .lm-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--n-900);
            margin-bottom: 8px;
        }

        .lm-sub {
            font-size: 13px;
            color: var(--n-400);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .lm-actions {
            display: flex;
            gap: 10px;
        }

        .lm-cancel {
            flex: 1;
            height: 40px;
            border: 1.5px solid var(--n-200);
            border-radius: 10px;
            background: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--n-600);
            cursor: pointer;
            transition: background .18s;
        }

        .lm-cancel:hover {
            background: var(--n-50);
        }

        .lm-confirm {
            flex: 1;
            height: 40px;
            border: none;
            border-radius: 10px;
            background: var(--err);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: background .18s, box-shadow .18s;
        }

        .lm-confirm:hover {
            background: #b91c1c;
            box-shadow: 0 4px 14px rgba(217, 45, 32, .3);
        }

    .btn-primary {
        height: 38px; padding: 0 18px;
        border: none; border-radius: 10px;
        background: var(--p-800);
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; font-weight: 600;
        color: #fff;
        cursor: pointer;
        display: flex; align-items: center; gap: 7px;
        transition: background .2s, box-shadow .2s;
    }

    .btn-primary:hover { background: var(--p-900); box-shadow: 0 4px 16px rgba(7, 28, 82, 0.25); }
    .btn-primary svg   { width: 15px; height: 15px; }

    /* ── STATS GRID ── */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }

    .stat-card {
        background: #fff;
        border: 1.5px solid var(--n-200);
        border-radius: 16px;
        padding: 22px 24px;
        position: relative; overflow: hidden;
        transition: border-color .18s, box-shadow .18s;
    }

    .stat-card:hover { border-color: var(--p-200); box-shadow: 0 4px 20px rgba(59, 111, 212, 0.08); }

    .stat-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .stat-card-icon svg { width: 20px; height: 20px; }
    .stat-card-val   { font-family: 'Syne', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--n-900); line-height: 1; margin-bottom: 5px; }
    .stat-card-label { font-size: 12.5px; color: var(--n-400); font-weight: 500; }

    .stat-card-delta {
        position: absolute; top: 18px; right: 18px;
        display: flex; align-items: center; gap: 4px;
        font-size: 11.5px; font-weight: 600;
        padding: 3px 9px; border-radius: 100px;
    }

    .delta-up  { background: var(--success-bg); color: var(--success); }
    .delta-down{ background: var(--err-bg);     color: var(--err); }
    .delta-neu { background: var(--warn-bg);    color: var(--warn); }

    .stat-card-accent { position: absolute; bottom: 0; right: 0; width: 80px; height: 80px; border-radius: 50%; opacity: 0.07; transform: translate(20px, 20px); }

    /* ── CARDS ── */
    .content-grid { display: grid; grid-template-columns: 1fr 360px; gap: 20px; margin-bottom: 20px; }

    .card { background: #fff; border: 1.5px solid var(--n-200); border-radius: 16px; overflow: hidden; }

    .card-header {
        padding: 18px 22px 16px;
        border-bottom: 1px solid var(--n-100);
        display: flex; align-items: center; justify-content: space-between;
    }

    .card-title { font-size: 14.5px; font-weight: 600; color: var(--n-900); }
    .card-sub   { font-size: 12px; color: var(--n-400); margin-top: 2px; }

    .card-action {
        font-size: 12.5px; color: var(--p-600); font-weight: 500;
        cursor: pointer; text-decoration: none;
        display: flex; align-items: center; gap: 4px;
    }

    .card-action:hover { text-decoration: underline; }
    .card-body { padding: 20px 22px; }

    /* ── TABLE ── */
    .data-table   { width: 100%; border-collapse: collapse; }
    .data-table th { font-size: 11.5px; font-weight: 600; color: var(--n-400); text-transform: uppercase; letter-spacing: 0.08em; padding: 0 14px 12px; text-align: left; }
    .data-table td { font-size: 13.5px; color: var(--n-900); padding: 13px 14px; border-top: 1px solid var(--n-100); }
    .data-table tr:hover td { background: var(--n-50); }

    .td-vehicle { display: flex; align-items: center; gap: 10px; }

    .veh-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: var(--p-50);
        border: 1px solid var(--p-100);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .veh-icon svg { width: 16px; height: 16px; color: var(--p-600); }
    .veh-plate    { font-weight: 600; font-size: 13px; }
    .veh-type     { font-size: 11.5px; color: var(--n-400); margin-top: 1px; }

    .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; }
    .badge-in   { background: var(--success-bg); color: var(--success); }
    .badge-out  { background: var(--n-100);       color: var(--n-600); }
    .badge-warn { background: var(--warn-bg);      color: var(--warn); }

    /* ── SLOT MAP ── */
    .slot-map-wrap { padding: 20px 22px; }
    .zone-label    { font-size: 11px; font-weight: 600; color: var(--n-400); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 10px; }
    .slot-row      { display: flex; gap: 7px; margin-bottom: 7px; flex-wrap: wrap; }

    .sl {
        width: 34px; height: 24px;
        border-radius: 5px;
        border: 1.5px solid var(--n-200);
        background: var(--n-50);
        cursor: pointer;
        transition: all .18s;
        font-size: 9px;
        display: flex; align-items: center; justify-content: center;
        color: var(--n-400); font-weight: 600;
    }

    .sl:hover    { transform: scale(1.08); }
    .sl.taken    { background: rgba(59, 111, 212, 0.14); border-color: var(--p-400); color: var(--p-600); }
    .sl.free     { background: rgba(232, 183, 64, 0.12); border-color: var(--g-400); color: var(--g-600); animation: slotPulse 2.2s ease-in-out infinite; }
    .sl.blocked  { background: var(--err-bg); border-color: var(--err); color: var(--err); }

    @keyframes slotPulse { 0%, 100% { opacity: 1; } 50% { opacity: .55; } }

    .slot-legend { display: flex; gap: 16px; margin-top: 12px; }
    .leg-item    { display: flex; align-items: center; gap: 6px; font-size: 11px; color: var(--n-600); }
    .leg-dot     { width: 10px; height: 10px; border-radius: 3px; }

    /* ── MINI STATS ── */
    .mini-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--n-100); border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
    .mini-stat  { background: #fff; padding: 16px; text-align: center; }
    .mini-stat-val   { font-family: 'Syne', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--n-900); }
    .mini-stat-label { font-size: 11px; color: var(--n-400); margin-top: 2px; }

    /* ── CHART ── */
    .chart-area { height: 180px; background: var(--n-50); border-radius: 10px; display: flex; align-items: flex-end; gap: 5px; padding: 16px 16px 0; overflow: hidden; }
    .bar-wrap   { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .bar        { border-radius: 4px 4px 0 0; width: 100%; transition: height .3s ease; cursor: pointer; }
    .bar-label  { font-size: 10px; color: var(--n-400); }

    /* ── BOTTOM GRID ── */
    .bottom-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

    /* ── ALERT BANNER ── */
    .alert-banner {
        background: linear-gradient(135deg, var(--p-50), rgba(232, 183, 64, 0.08));
        border: 1.5px solid var(--p-100);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 20px;
    }

    .alert-banner svg { width: 20px; height: 20px; color: var(--p-600); flex-shrink: 0; }
    .ab-text  { flex: 1; }
    .ab-title { font-size: 13.5px; font-weight: 600; color: var(--p-800); }
    .ab-sub   { font-size: 12.5px; color: var(--p-600); margin-top: 1px; }

    .ab-action {
        font-size: 12.5px; font-weight: 600; color: var(--p-600);
        cursor: pointer; white-space: nowrap; text-decoration: none;
        padding: 7px 14px;
        background: #fff;
        border: 1.5px solid var(--p-200);
        border-radius: 8px;
        transition: background .18s;
    }

    .ab-action:hover { background: var(--p-50); }

    /* ── ACTIVITY LOG ── */
    .activity-list { display: flex; flex-direction: column; gap: 0; }

    .act-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid var(--n-100);
    }

    .act-item:last-child { border-bottom: none; }
    .act-dot-wrap { position: relative; display: flex; flex-direction: column; align-items: center; flex-shrink: 0; padding-top: 2px; }
    .act-dot      { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .act-content  { flex: 1; min-width: 0; }
    .act-title    { font-size: 13px; font-weight: 500; color: var(--n-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .act-meta     { font-size: 11.5px; color: var(--n-400); margin-top: 2px; }
    .act-time     { font-size: 11px; color: var(--n-400); flex-shrink: 0; padding-top: 2px; }

    /* ── ZONE CARDS ── */
    .zone-cards { display: flex; flex-direction: column; gap: 10px; }

    .zone-item { padding: 14px 16px; background: var(--n-50); border-radius: 12px; border: 1.5px solid var(--n-200); }

    .zone-top  { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
    .zone-name { font-size: 13px; font-weight: 600; color: var(--n-900); }
    .zone-count{ font-size: 12px; color: var(--n-400); }

    .progress       { height: 6px; background: var(--n-200); border-radius: 100px; overflow: hidden; }
    .progress-fill  { height: 100%; border-radius: 100px; transition: width .5s ease; }

    /* ── OFFICER LIST ── */
    .officer-list { display: flex; flex-direction: column; gap: 10px; }

    .officer-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px;
        background: var(--n-50);
        border-radius: 12px;
        border: 1px solid var(--n-100);
    }

    .off-av {
        width: 36px; height: 36px;
        border-radius: 9px;
        font-family: 'Syne', sans-serif;
        font-size: 12px; font-weight: 700;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .off-name   { font-size: 13px; font-weight: 600; color: var(--n-900); }
    .off-zone   { font-size: 11.5px; color: var(--n-400); margin-top: 1px; }
    .off-status { margin-left: auto; width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1200px) {
        .stats-grid   { grid-template-columns: repeat(2, 1fr); }
        .content-grid { grid-template-columns: 1fr; }
        .bottom-grid  { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 900px) {
        :root { --sidebar-w: 0px; }
        .sidebar { transform: translateX(-260px); }
        .sidebar.open { transform: translateX(0); width: 260px; }
        .main   { margin-left: 0; }
        .page   { padding: 20px; }
        .bottom-grid { grid-template-columns: 1fr; }
    }
</style>
