<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPark — Sistem Parkir Pintar Face Recognition & ANPR Polije Bondowoso</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&family=Syne:wght@600;700;800&display=swap"
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
            --g-600: #C9960F;
            --n-50: #F5F7FC;
            --n-100: #EBEEF5;
            --n-200: #D4D9E8;
            --n-400: #8A93AE;
            --n-600: #4A5272;
            --n-900: #181D35;
            --dark: #071433;
            --dark2: #0C1F4A;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            color: var(--n-900);
            overflow-x: hidden;
        }

        /* ===================== NAVBAR ===================== */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 2rem;
            transition: background .3s, box-shadow .3s;
        }

        nav.scrolled {
            background: rgba(7, 20, 51, 0.97);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 24px rgba(0,0,0,0.25);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }

        .nav-logo-box {
            width: 36px; height: 36px;
            background: var(--p-400);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }

        .nav-logo-box svg { width: 22px; height: 22px; }

        .nav-wordmark {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem; font-weight: 700;
            color: #fff; letter-spacing: -.02em;
        }
        .nav-wordmark span { color: var(--g-400); }

        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a {
            font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.7);
            text-decoration: none; transition: color .2s;
        }
        .nav-links a:hover { color: #fff; }

        .nav-cta { display: flex; align-items: center; gap: 10px; }

        .btn-ghost {
            padding: 8px 18px; border-radius: 8px;
            border: 1.5px solid rgba(255,255,255,0.25);
            background: transparent;
            color: rgba(255,255,255,0.85);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: border-color .2s, color .2s;
        }
        .btn-ghost:hover { border-color: rgba(255,255,255,0.6); color: #fff; }

        .btn-nav-primary {
            padding: 9px 20px; border-radius: 8px;
            background: var(--g-400);
            color: var(--p-900);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background .2s, transform .12s;
        }
        .btn-nav-primary:hover { background: var(--g-300); transform: translateY(-1px); }

        .hamburger {
            display: none; flex-direction: column; gap: 5px;
            cursor: pointer; padding: 4px;
        }
        .hamburger span { width: 22px; height: 2px; background: #fff; border-radius: 2px; transition: .3s; }

        /* Mobile menu overlay */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px; left: 0; right: 0;
            background: rgba(7, 20, 51, 0.98);
            backdrop-filter: blur(16px);
            z-index: 99;
            padding: 24px 2rem 32px;
            flex-direction: column;
            gap: 0;
            border-top: 1px solid rgba(255,255,255,0.08);
            transform: translateY(-10px);
            opacity: 0;
            transition: opacity .25s, transform .25s;
        }
        .mobile-menu.open {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }
        .mobile-menu a {
            font-size: 15px; font-weight: 500;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            transition: color .2s;
        }
        .mobile-menu a:hover { color: #fff; }
        .mobile-menu .mob-cta {
            display: flex; flex-direction: column; gap: 10px;
            margin-top: 20px;
        }
        .mobile-menu .btn-ghost,
        .mobile-menu .btn-nav-primary {
            text-align: center; width: 100%; padding: 12px;
        }

        @media(max-width:768px) {
            .nav-links, .nav-cta { display: none; }
            .hamburger { display: flex; }
        }

        /* ===================== HERO ===================== */
        .hero {
            min-height: 100vh;
            background: linear-gradient(150deg, var(--dark) 0%, #0C2260 55%, var(--p-800) 100%);
            position: relative; overflow: hidden;
            display: flex; align-items: center;
            padding: 120px 2rem 80px;
        }

        .hero-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(59,111,212,0.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59,111,212,0.09) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridDrift 30s linear infinite;
        }

        @keyframes gridDrift {
            from { background-position: 0 0 }
            to   { background-position: 60px 60px }
        }

        .hero-orb {
            position: absolute; border-radius: 50%;
            filter: blur(100px);
            animation: breathe 8s ease-in-out infinite alternate;
        }
        .ho1 { width: 500px; height: 500px; background: rgba(59,111,212,0.22); top: -150px; right: -100px; }
        .ho2 { width: 350px; height: 350px; background: rgba(232,183,64,0.12); bottom: -50px; left: -80px; animation-delay: 3s; }

        @keyframes breathe {
            0%   { opacity: .5; transform: scale(1) }
            100% { opacity: 1; transform: scale(1.2) }
        }

        .hero-inner {
            max-width: 1200px; margin: 0 auto; width: 100%;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 60px; align-items: center; position: relative; z-index: 2;
        }
        @media(max-width:900px) { .hero-inner { grid-template-columns: 1fr; } }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(232,183,64,0.12);
            border: 1px solid rgba(232,183,64,0.3);
            border-radius: 100px; padding: 6px 14px; margin-bottom: 24px;
        }
        .hero-badge-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--g-400); box-shadow: 0 0 8px var(--g-400);
            animation: dotPulse 2s ease-in-out infinite;
        }
        @keyframes dotPulse {
            0%,100% { box-shadow: 0 0 8px var(--g-400) }
            50%     { box-shadow: 0 0 16px var(--g-400) }
        }
        .hero-badge span { font-size: 12px; font-weight: 500; color: var(--g-300); letter-spacing: .08em; }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.2rem, 4.5vw, 3.5rem);
            font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 20px;
        }
        .hero-title em { font-style: normal; color: var(--g-400); display: block; }

        /* Tech tags baru */
        .hero-tech-tags {
            display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
        }
        .tech-tag {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 100px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.06);
            font-size: 11.5px; font-weight: 500;
            color: rgba(255,255,255,0.75);
            backdrop-filter: blur(4px);
        }
        .tech-tag svg { width: 13px; height: 13px; }

        .hero-sub {
            font-size: 16px; color: rgba(255,255,255,0.55);
            line-height: 1.75; max-width: 460px; margin-bottom: 36px;
        }

        .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 48px; }

        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 28px; border-radius: 12px;
            background: var(--g-400); color: var(--p-900);
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
            text-decoration: none; transition: background .2s, transform .12s, box-shadow .2s;
        }
        .btn-hero-primary:hover { background: var(--g-300); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,183,64,0.3); }

        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 28px; border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.85);
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 500;
            text-decoration: none; transition: border-color .2s, color .2s, background .2s;
        }
        .btn-hero-secondary:hover { border-color: rgba(255,255,255,0.5); color: #fff; background: rgba(255,255,255,0.07); }

        .btn-hero-primary svg, .btn-hero-secondary svg { width: 18px; height: 18px; }

        .hero-mini-stats {
            display: flex; gap: 28px; padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .hms-num { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 700; color: #fff; }
        .hms-label { font-size: 12px; color: rgba(255,255,255,0.38); margin-top: 2px; }

        /* Hero visual */
        .hero-visual { position: relative; }

        .mockup-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 24px;
            backdrop-filter: blur(12px);
            animation: cardFloat 4s ease-in-out infinite alternate;
        }
        @keyframes cardFloat {
            from { transform: translateY(0) }
            to   { transform: translateY(-12px) }
        }

        .mockup-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .mockup-title { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: rgba(255,255,255,0.9); }
        .mockup-live { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #4ade80; }
        .mockup-live span { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; animation: dotPulse 1.5s infinite; }

        .zone-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 20px; }
        .zone-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 14px; }
        .zone-name { font-size: 11px; color: rgba(255,255,255,0.5); margin-bottom: 6px; }
        .zone-num { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 700; }
        .zone-num.full  { color: #f87171; }
        .zone-num.mid   { color: var(--g-400); }
        .zone-num.avail { color: #4ade80; }
        .zone-sub { font-size: 10px; color: rgba(255,255,255,0.35); margin-top: 3px; }

        /* ANPR scan bar baru */
        .anpr-bar {
            display: flex; align-items: center; gap: 10px;
            background: rgba(59,111,212,0.15);
            border: 1px solid rgba(59,111,212,0.3);
            border-radius: 10px; padding: 10px 14px;
            margin-bottom: 12px;
        }
        .anpr-icon { font-size: 16px; }
        .anpr-info { flex: 1; }
        .anpr-plate {
            font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700;
            color: #fff; letter-spacing: .08em;
        }
        .anpr-meta { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .anpr-status {
            font-size: 10px; font-weight: 600; padding: 3px 8px;
            border-radius: 100px; background: rgba(74,222,128,0.15); color: #4ade80;
        }

        .slot-bar { margin-bottom: 16px; }
        .slot-bar-label { display: flex; justify-content: space-between; font-size: 12px; color: rgba(255,255,255,0.5); margin-bottom: 6px; }
        .slot-bar-track { height: 8px; background: rgba(255,255,255,0.1); border-radius: 100px; overflow: hidden; }
        .slot-bar-fill { height: 100%; border-radius: 100px; transition: width 1s ease; }
        .fill-red    { background: linear-gradient(90deg, #ef4444, #f87171); }
        .fill-yellow { background: linear-gradient(90deg, var(--g-600), var(--g-400)); }
        .fill-green  { background: linear-gradient(90deg, #16a34a, #4ade80); }

        .mockup-footer { display: flex; gap: 8px; }
        .mf-chip { flex: 1; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.07); display: flex; align-items: center; justify-content: center; font-size: 11px; color: rgba(255,255,255,0.5); }

        .float-card {
            position: absolute;
            background: rgba(14,47,122,0.9);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px; padding: 10px 14px;
            backdrop-filter: blur(12px);
            animation: floatCard 3s ease-in-out infinite alternate;
        }
        .fc1 { bottom: -20px; left: -30px; animation-delay: .5s; }
        .fc2 { top: -16px; right: -20px; animation-delay: 1.2s; }
        @keyframes floatCard {
            from { transform: translateY(0) rotate(-1deg) }
            to   { transform: translateY(-8px) rotate(1deg) }
        }
        .float-card p    { font-size: 11px; color: rgba(255,255,255,0.5); margin-bottom: 2px; }
        .float-card strong { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #fff; }
        .float-card .badge { display: inline-block; padding: 2px 8px; border-radius: 100px; font-size: 10px; font-weight: 600; margin-top: 3px; }
        .badge-green  { background: rgba(74,222,128,0.15); color: #4ade80; }
        .badge-yellow { background: rgba(232,183,64,0.15); color: var(--g-400); }

        /* ===================== SECTION BASE ===================== */
        section { padding: 96px 2rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }

        .section-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--p-50); border: 1px solid var(--p-100);
            border-radius: 100px; padding: 5px 14px; margin-bottom: 16px;
            font-size: 12px; font-weight: 600; color: var(--p-600);
            letter-spacing: .06em; text-transform: uppercase;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800; color: var(--n-900);
            line-height: 1.15; margin-bottom: 16px;
        }
        .section-title em { font-style: normal; color: var(--p-600); }

        .section-sub { font-size: 16px; color: var(--n-400); line-height: 1.75; max-width: 520px; }

        .text-center { text-align: center; }
        .text-center .section-sub { margin: 0 auto; }

        /* ===================== STATS BAND ===================== */
        .stats-band { background: var(--p-800); padding: 60px 2rem; }
        .stats-band-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4,1fr); gap: 32px;
        }
        @media(max-width:768px) { .stats-band-inner { grid-template-columns: repeat(2,1fr); } }

        .stat-item { text-align: center; }
        .stat-num { font-family: 'Syne', sans-serif; font-size: 2.4rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
        .stat-num span { color: var(--g-400); }
        .stat-label { font-size: 14px; color: rgba(255,255,255,0.5); }

        /* ===================== FEATURES ===================== */
        .features { background: var(--n-50); }
        .features-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-top: 56px; }
        @media(max-width:900px) { .features-grid { grid-template-columns: repeat(2,1fr); } }
        @media(max-width:560px) { .features-grid { grid-template-columns: 1fr; } }

        .feat-card {
            background: #fff; border-radius: 18px; padding: 28px;
            border: 1.5px solid var(--n-100);
            transition: border-color .2s, transform .2s, box-shadow .2s;
            position: relative; overflow: hidden;
        }
        .feat-card:hover { border-color: var(--p-200); transform: translateY(-4px); box-shadow: 0 16px 40px rgba(14,47,122,0.08); }
        .feat-card::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, var(--p-50) 0%, transparent 60%);
            opacity: 0; transition: opacity .3s;
        }
        .feat-card:hover::before { opacity: 1; }

        .feat-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: var(--p-50);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px; transition: background .2s;
        }
        .feat-card:hover .feat-icon { background: var(--p-100); }
        .feat-icon svg { width: 24px; height: 24px; color: var(--p-800); }

        .feat-badge-new {
            position: absolute; top: 16px; right: 16px;
            background: var(--g-400); color: var(--p-900);
            font-size: 10px; font-weight: 700;
            padding: 3px 9px; border-radius: 100px;
            letter-spacing: .04em;
        }

        .feat-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--n-900); margin-bottom: 10px; }
        .feat-desc  { font-size: 14px; color: var(--n-400); line-height: 1.7; }

        .feat-card.highlighted {
            background: var(--p-800); border-color: var(--p-800);
        }
        .feat-card.highlighted .feat-icon { background: rgba(255,255,255,0.12); }
        .feat-card.highlighted .feat-icon svg { color: var(--g-400); }
        .feat-card.highlighted .feat-title { color: #fff; }
        .feat-card.highlighted .feat-desc  { color: rgba(255,255,255,0.55); }
        .feat-card.highlighted::before { display: none; }
        .feat-card.highlighted:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(14,47,122,0.25); }

        /* ===================== HOW IT WORKS ===================== */
        .how { background: #fff; }
        .how-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; margin-top: 64px; }
        @media(max-width:900px) { .how-grid { grid-template-columns: 1fr; gap: 48px; } }

        .steps-list { display: flex; flex-direction: column; gap: 0; }

        .how-step { display: flex; gap: 20px; padding-bottom: 36px; position: relative; }
        .how-step:last-child { padding-bottom: 0; }
        .how-step::before {
            content: ''; position: absolute; left: 19px; top: 44px; bottom: 0;
            width: 2px; background: var(--n-100);
        }
        .how-step:last-child::before { display: none; }

        .step-circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--p-50); border: 2px solid var(--p-100);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--p-800);
            transition: background .3s, border-color .3s;
        }
        .how-step:hover .step-circle { background: var(--p-800); border-color: var(--p-800); color: #fff; }

        .step-content { padding-top: 8px; }
        .step-content h4 { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: var(--n-900); margin-bottom: 6px; }
        .step-content p  { font-size: 14px; color: var(--n-400); line-height: 1.7; }

        /* How visual */
        .how-visual { position: relative; }
        .how-phone {
            background: linear-gradient(135deg, var(--p-800) 0%, var(--p-900) 100%);
            border-radius: 28px; padding: 28px 22px;
            box-shadow: 0 24px 64px rgba(14,47,122,0.3);
            max-width: 320px; margin: 0 auto;
        }
        .phone-notch { width: 60px; height: 6px; background: rgba(255,255,255,0.15); border-radius: 3px; margin: 0 auto 24px; }

        .phone-status { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .phone-status span { font-size: 11px; color: rgba(255,255,255,0.5); }

        .phone-app-title { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 18px; }

        /* Face scan visual */
        .face-scan-box {
            background: rgba(59,111,212,0.12);
            border: 1px dashed rgba(59,111,212,0.4);
            border-radius: 14px; padding: 18px;
            text-align: center; margin-bottom: 14px;
            position: relative; overflow: hidden;
        }
        .face-scan-box::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 2px; background: var(--p-400);
            animation: scanLine 2s ease-in-out infinite;
        }
        @keyframes scanLine {
            0%   { top: 0; opacity: 1; }
            50%  { top: 100%; opacity: .5; }
            100% { top: 0; opacity: 1; }
        }
        .face-icon { font-size: 36px; margin-bottom: 8px; }
        .face-label { font-size: 11px; color: rgba(255,255,255,0.45); }
        .face-id { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700; color: var(--p-200); margin-top: 4px; }

        .phone-anpr {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; padding: 10px 12px;
            display: flex; align-items: center; gap: 10px; margin-bottom: 14px;
        }
        .phone-anpr-icon { font-size: 18px; }
        .phone-anpr-plate {
            font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
            color: #fff; letter-spacing: .1em;
        }
        .phone-anpr-meta { font-size: 10px; color: rgba(255,255,255,0.4); }
        .phone-anpr-ok {
            margin-left: auto; font-size: 10px; font-weight: 600;
            padding: 3px 8px; border-radius: 100px;
            background: rgba(74,222,128,0.15); color: #4ade80;
        }

        .phone-slot-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 7px; margin-bottom: 14px; }
        .ps { height: 38px; border-radius: 7px; border: 1.5px solid; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 600; }
        .ps.t { background: rgba(59,111,212,0.2); border-color: var(--p-400); color: var(--p-200); }
        .ps.f { background: rgba(74,222,128,0.12); border-color: #4ade80; color: #4ade80; animation: slotBlink 2.5s ease-in-out infinite; }
        @keyframes slotBlink { 0%,100% { opacity:1 } 50% { opacity:.45 } }

        .phone-legend { display: flex; gap: 12px; }
        .leg { display: flex; align-items: center; gap: 5px; font-size: 11px; color: rgba(255,255,255,0.45); }
        .leg-dot { width: 8px; height: 8px; border-radius: 2px; }
        .leg-dot.t { background: var(--p-400); }
        .leg-dot.f { background: #4ade80; }

        .phone-btn {
            margin-top: 16px; width: 100%; height: 42px;
            background: var(--g-400); border-radius: 10px; border: none;
            font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--p-900); cursor: pointer;
        }

        /* ===================== STATS SECTION ===================== */
        .stats-section { background: var(--n-50); }
        .stats-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; margin-top: 56px; }
        @media(max-width:900px) { .stats-cards { grid-template-columns: repeat(2,1fr); } }

        .stat-card {
            background: #fff; border-radius: 16px; padding: 28px;
            border: 1.5px solid var(--n-100); text-align: center;
            transition: border-color .2s, transform .2s;
        }
        .stat-card:hover { border-color: var(--p-200); transform: translateY(-3px); }

        .stat-card-icon { width: 44px; height: 44px; border-radius: 12px; background: var(--p-50); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .stat-card-icon svg { width: 22px; height: 22px; color: var(--p-800); }
        .stat-card-num { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; color: var(--n-900); margin-bottom: 4px; }
        .stat-card-num span { color: var(--p-600); }
        .stat-card-label { font-size: 13px; color: var(--n-400); }

        /* ===================== TECH SPEC SECTION ===================== */
        .tech-spec { background: #fff; }
        .tech-spec-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-top: 56px; align-items: center; }
        @media(max-width:900px) { .tech-spec-grid { grid-template-columns: 1fr; } }

        .spec-list { display: flex; flex-direction: column; gap: 16px; }
        .spec-item {
            display: flex; align-items: flex-start; gap: 16px;
            padding: 20px; border-radius: 14px;
            border: 1.5px solid var(--n-100);
            transition: border-color .2s, background .2s;
        }
        .spec-item:hover { border-color: var(--p-200); background: var(--p-50); }
        .spec-num {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--p-800); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700;
            flex-shrink: 0;
        }
        .spec-text h4 { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--n-900); margin-bottom: 4px; }
        .spec-text p  { font-size: 13px; color: var(--n-400); line-height: 1.6; }

        .tech-visual {
            background: linear-gradient(135deg, var(--p-800), var(--p-900));
            border-radius: 24px; padding: 32px;
            position: relative; overflow: hidden;
        }
        .tech-visual::before {
            content: '';
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(59,111,212,0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(59,111,212,0.15) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .tv-inner { position: relative; z-index: 1; }
        .tv-title { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.6); letter-spacing: .08em; text-transform: uppercase; margin-bottom: 20px; }

        .tv-cam-row { display: flex; gap: 12px; margin-bottom: 16px; }
        .tv-cam {
            flex: 1; background: rgba(0,0,0,0.3); border-radius: 12px;
            padding: 14px; border: 1px solid rgba(255,255,255,0.1);
        }
        .tv-cam-label { font-size: 10px; color: rgba(255,255,255,0.4); margin-bottom: 8px; }
        .tv-cam-icon { font-size: 24px; margin-bottom: 6px; }
        .tv-cam-status { font-size: 10px; font-weight: 600; color: #4ade80; }

        .tv-result {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 14px;
            margin-bottom: 12px;
        }
        .tv-result-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
        .tv-result-row:last-child { margin-bottom: 0; }
        .tv-result-label { font-size: 11px; color: rgba(255,255,255,0.4); }
        .tv-result-val { font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700; color: #fff; }
        .tv-result-val.green { color: #4ade80; }
        .tv-result-val.yellow { color: var(--g-400); }

        .tv-acc-row { display: flex; gap: 10px; }
        .tv-acc {
            flex: 1; background: rgba(255,255,255,0.05); border-radius: 10px;
            padding: 12px; text-align: center;
        }
        .tv-acc-num { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 800; color: #fff; }
        .tv-acc-num span { color: var(--g-400); }
        .tv-acc-label { font-size: 10px; color: rgba(255,255,255,0.4); margin-top: 2px; }

        /* ===================== FAQ ===================== */
        .faq { background: var(--n-50); }
        .faq-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 80px; align-items: start; margin-top: 56px; }
        @media(max-width:900px) { .faq-grid { grid-template-columns: 1fr; gap: 40px; } }

        .faq-sidebar h3 { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--n-900); margin-bottom: 12px; }
        .faq-sidebar p  { font-size: 14px; color: var(--n-400); line-height: 1.7; margin-bottom: 24px; }

        .faq-contact {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 18px; background: var(--p-50);
            border: 1px solid var(--p-100); border-radius: 12px;
            text-decoration: none; transition: background .2s;
        }
        .faq-contact:hover { background: var(--p-100); }
        .faq-contact svg { width: 18px; height: 18px; color: var(--p-800); }
        .faq-contact span { font-size: 13.5px; font-weight: 500; color: var(--p-800); }

        .faq-list { display: flex; flex-direction: column; gap: 8px; }
        .faq-item { border: 1.5px solid var(--n-100); border-radius: 14px; overflow: hidden; transition: border-color .2s; }
        .faq-item.open { border-color: var(--p-200); }

        .faq-q { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; cursor: pointer; user-select: none; }
        .faq-q span { font-size: 15px; font-weight: 500; color: var(--n-900); }
        .faq-q svg  { width: 18px; height: 18px; color: var(--n-400); transition: transform .3s, color .3s; flex-shrink: 0; }
        .faq-item.open .faq-q svg  { transform: rotate(45deg); color: var(--p-600); }
        .faq-item.open .faq-q span { color: var(--p-800); }

        .faq-a { max-height: 0; overflow: hidden; transition: max-height .35s ease, padding .35s; }
        .faq-item.open .faq-a { max-height: 220px; }
        .faq-a p { padding: 0 22px 18px; font-size: 14px; color: var(--n-400); line-height: 1.75; }

        /* ===================== CTA BAND ===================== */
        .cta-band {
            background: linear-gradient(135deg, var(--p-800) 0%, var(--p-900) 100%);
            padding: 96px 2rem; position: relative; overflow: hidden;
        }
        .cta-band-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(59,111,212,0.12) 1px, transparent 1px), linear-gradient(90deg, rgba(59,111,212,0.12) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .cta-band-orb { position: absolute; width: 400px; height: 400px; border-radius: 50%; background: rgba(59,111,212,0.2); filter: blur(80px); right: -100px; top: -100px; }

        .cta-inner { max-width: 700px; margin: 0 auto; text-align: center; position: relative; z-index: 2; }
        .cta-title { font-family: 'Syne', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 16px; }
        .cta-title em { font-style: normal; color: var(--g-400); }
        .cta-sub { font-size: 16px; color: rgba(255,255,255,0.55); line-height: 1.7; margin-bottom: 36px; }

        .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .btn-cta-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 15px 32px; border-radius: 12px;
            background: var(--g-400); color: var(--p-900);
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 600;
            text-decoration: none; transition: background .2s, transform .12s, box-shadow .2s;
        }
        .btn-cta-primary:hover { background: var(--g-300); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,183,64,0.3); }

        .btn-cta-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 15px 32px; border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.85);
            font-family: 'DM Sans', sans-serif; font-size: 15px; font-weight: 500;
            text-decoration: none; transition: border-color .2s, color .2s, background .2s;
        }
        .btn-cta-secondary:hover { border-color: rgba(255,255,255,.55); color: #fff; background: rgba(255,255,255,0.07); }

        /* ===================== FOOTER ===================== */
        footer { background: var(--dark); padding: 64px 2rem 32px; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }

        .footer-top {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px; padding-bottom: 48px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        @media(max-width:900px) { .footer-top { grid-template-columns: 1fr 1fr; gap: 36px; } }
        @media(max-width:560px) { .footer-top { grid-template-columns: 1fr; } }

        .footer-logo { display: flex; align-items: center; gap: 9px; margin-bottom: 14px; }
        .footer-logo-box { width: 34px; height: 34px; background: var(--p-400); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .footer-logo-box svg { width: 20px; height: 20px; }
        .footer-wordmark { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: #fff; }
        .footer-wordmark span { color: var(--g-400); }

        .footer-desc { font-size: 13.5px; color: rgba(255,255,255,0.38); line-height: 1.75; max-width: 260px; margin-bottom: 20px; }

        .footer-polije {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 14px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        .footer-polije svg { width: 18px; height: 18px; color: rgba(255,255,255,0.4); }
        .footer-polije p { font-size: 11.5px; color: rgba(255,255,255,0.45); line-height: 1.4; }
        .footer-polije p strong { color: rgba(255,255,255,0.7); display: block; font-size: 12px; }

        .footer-col h4 { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: rgba(255,255,255,0.8); margin-bottom: 16px; letter-spacing: .04em; text-transform: uppercase; }
        .footer-col a { display: block; font-size: 13.5px; color: rgba(255,255,255,0.38); text-decoration: none; margin-bottom: 10px; transition: color .2s; }
        .footer-col a:hover { color: rgba(255,255,255,0.8); }

        .footer-bottom { display: flex; align-items: center; justify-content: space-between; padding-top: 28px; flex-wrap: wrap; gap: 12px; }
        .footer-bottom p { font-size: 12.5px; color: rgba(255,255,255,0.28); }
        .footer-bottom p span { color: var(--g-400); }

        .footer-socials { display: flex; gap: 10px; }
        .social-btn { width: 34px; height: 34px; border-radius: 8px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .2s; }
        .social-btn:hover { background: rgba(255,255,255,0.12); }
        .social-btn svg { width: 16px; height: 16px; color: rgba(255,255,255,0.5); }

        /* ===================== SCROLL REVEAL ===================== */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .6s ease, transform .6s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }
        .reveal-delay-5 { transition-delay: .5s; }
    </style>
</head>

<body>

    <!-- =================== NAVBAR =================== -->
    <nav id="navbar">
        <div class="nav-inner">
            <a class="nav-logo" href="#">
                <div class="nav-logo-box">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9"/>
                        <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5"/>
                        <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75"/>
                    </svg>
                </div>
                <span class="nav-wordmark">Easy<span>Park</span></span>
            </a>
            <div class="nav-links">
                <a href="#fitur">Fitur</a>
                <a href="#teknologi">Teknologi</a>
                <a href="#cara-pakai">Cara Pakai</a>
                <a href="#statistik">Statistik</a>
                <a href="#faq">FAQ</a>
            </div>
            <div class="nav-cta">
                <a href="/login" class="btn-ghost">Masuk</a>
                <a href="/login" class="btn-nav-primary">Gunakan Sekarang</a>
            </div>
            <div class="hamburger" onclick="toggleMenu()" id="hamburger">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#fitur" onclick="toggleMenu()">Fitur</a>
        <a href="#teknologi" onclick="toggleMenu()">Teknologi</a>
        <a href="#cara-pakai" onclick="toggleMenu()">Cara Pakai</a>
        <a href="#statistik" onclick="toggleMenu()">Statistik</a>
        <a href="#faq" onclick="toggleMenu()">FAQ</a>
        <div class="mob-cta">
            <a href="/login" class="btn-ghost">Masuk</a>
            <a href="/login" class="btn-nav-primary">Gunakan Sekarang</a>
        </div>
    </div>

    <!-- =================== HERO =================== -->
    <section class="hero" id="hero">
        <div class="hero-grid"></div>
        <div class="hero-orb ho1"></div>
        <div class="hero-orb ho2"></div>

        <div class="hero-inner">
            <!-- Left copy -->
            <div>
                <div class="hero-badge">
                    <div class="hero-badge-dot"></div>
                    <span>Politeknik Negeri Jember · Kampus 2 Bondowoso</span>
                </div>
                <h1 class="hero-title">
                    Sistem Parkir Pintar
                    <em>Face Recognition & ANPR</em>
                </h1>
                <!-- Tech tags -->
                <div class="hero-tech-tags">
                    <span class="tech-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/><path d="M6 20v-1a6 6 0 0 1 12 0v1"/>
                            <path d="M2 12h2M20 12h2M12 2v2M12 20v2"/>
                        </svg>
                        Face Recognition
                    </span>
                    <span class="tech-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="10" rx="2"/>
                            <path d="M7 11h.01M11 11h2M16 11h.01"/>
                        </svg>
                        ANPR Otomatis
                    </span>
                    <span class="tech-tag">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/>
                        </svg>
                        CCTV Real-Time
                    </span>
                </div>
                <p class="hero-sub">
                    EasyPark mengintegrasikan teknologi <strong style="color:rgba(255,255,255,0.85)">Face Recognition</strong> dan
                    <strong style="color:rgba(255,255,255,0.85)">Automatic Number Plate Recognition (ANPR)</strong> untuk sistem
                    parkir otomatis tanpa kartu — cukup wajah dan plat nomor kendaraan Anda.
                </p>
                <div class="hero-btns">
                    <a href="/login" class="btn-hero-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Masuk ke Sistem
                    </a>
                    <a href="#cara-pakai" class="btn-hero-secondary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polygon points="10 8 16 12 10 16 10 8"/>
                        </svg>
                        Lihat Cara Pakai
                    </a>
                </div>
                <div class="hero-mini-stats">
                    <div class="hms">
                        <div class="hms-num">200+</div>
                        <div class="hms-label">Slot Parkir</div>
                    </div>
                    <div class="hms">
                        <div class="hms-num">98%</div>
                        <div class="hms-label">Akurasi ANPR</div>
                    </div>
                    <div class="hms">
                        <div class="hms-num">99%</div>
                        <div class="hms-label">Akurasi Face</div>
                    </div>
                    <div class="hms">
                        <div class="hms-num">24/7</div>
                        <div class="hms-label">Monitoring</div>
                    </div>
                </div>
            </div>

            <!-- Right visual -->
            <div class="hero-visual">
                <div class="mockup-card">
                    <div class="mockup-header">
                        <span class="mockup-title">Dashboard EasyPark — Polije Bondowoso</span>
                        <div class="mockup-live"><span></span> Live</div>
                    </div>

                    <!-- ANPR scan bar -->
                    <div class="anpr-bar">
                        <div class="anpr-icon">📷</div>
                        <div class="anpr-info">
                            <div class="anpr-plate">P 1234 AB</div>
                            <div class="anpr-meta">ANPR terdeteksi · Zona A · 08:42</div>
                        </div>
                        <div class="anpr-status">✓ Terdaftar</div>
                    </div>

                    <div class="zone-grid">
                        <div class="zone-card">
                            <div class="zone-name">Zona A</div>
                            <div class="zone-num full">87%</div>
                            <div class="zone-sub">Hampir penuh</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Zona B</div>
                            <div class="zone-num mid">54%</div>
                            <div class="zone-sub">Sebagian terisi</div>
                        </div>
                        <div class="zone-card">
                            <div class="zone-name">Zona C</div>
                            <div class="zone-num avail">23%</div>
                            <div class="zone-sub">Tersedia banyak</div>
                        </div>
                    </div>
                    <div class="slot-bar">
                        <div class="slot-bar-label"><span>Zona A · 78/90 slot</span><span>87%</span></div>
                        <div class="slot-bar-track"><div class="slot-bar-fill fill-red" style="width:87%"></div></div>
                    </div>
                    <div class="slot-bar">
                        <div class="slot-bar-label"><span>Zona B · 43/80 slot</span><span>54%</span></div>
                        <div class="slot-bar-track"><div class="slot-bar-fill fill-yellow" style="width:54%"></div></div>
                    </div>
                    <div class="slot-bar">
                        <div class="slot-bar-label"><span>Zona C · 7/30 slot</span><span>23%</span></div>
                        <div class="slot-bar-track"><div class="slot-bar-fill fill-green" style="width:23%"></div></div>
                    </div>
                    <div class="mockup-footer">
                        <div class="mf-chip">📅 Rabu, 29 Apr</div>
                        <div class="mf-chip">🕐 Update: 08:42</div>
                        <div class="mf-chip">🟢 Sistem Normal</div>
                    </div>
                </div>

                <div class="float-card fc1">
                    <p>ANPR terdeteksi hari ini</p>
                    <strong>1.248 kendaraan</strong>
                    <div><span class="badge badge-green">↑ +12 dari kemarin</span></div>
                </div>
                <div class="float-card fc2">
                    <p>Face Recognition aktif</p>
                    <strong>99.1% akurasi</strong>
                    <div><span class="badge badge-yellow">Zona B & C</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== STATS BAND =================== -->
    <div class="stats-band">
        <div class="stats-band-inner">
            <div class="stat-item reveal">
                <div class="stat-num">200<span>+</span></div>
                <div class="stat-label">Total Slot Parkir</div>
            </div>
            <div class="stat-item reveal reveal-delay-1">
                <div class="stat-num">
                    @if ($activeUsers >= 1000)
                        {{ number_format($activeUsers / 1000, 1) }}<span>rb+</span>
                    @else
                        {{ $activeUsers }}<span>+</span>
                    @endif
                </div>
                <div class="stat-label">Pengguna Terdaftar</div>
            </div>
            <div class="stat-item reveal reveal-delay-2">
                <div class="stat-num">98<span>%</span></div>
                <div class="stat-label">Akurasi ANPR</div>
            </div>
            <div class="stat-item reveal reveal-delay-3">
                <div class="stat-num">99<span>%</span></div>
                <div class="stat-label">Akurasi Face Recognition</div>
            </div>
        </div>
    </div>

    <!-- =================== FEATURES =================== -->
    <section class="features" id="fitur">
        <div class="section-inner">
            <div class="text-center reveal">
                <div class="section-eyebrow">✦ Fitur Unggulan</div>
                <h2 class="section-title">Teknologi parkir pintar<br>dalam <em>satu platform</em></h2>
                <p class="section-sub">Menggabungkan Face Recognition dan ANPR dengan manajemen parkir digital — dirancang khusus untuk kampus Polije Bondowoso.</p>
            </div>
            <div class="features-grid">

                <!-- Face Recognition -->
                <div class="feat-card highlighted reveal reveal-delay-1">
                    <span class="feat-badge-new">UTAMA</span>
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M6 20v-1a6 6 0 0 1 12 0v1"/>
                            <path d="M2 12h2M20 12h2M12 2v2"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">Face Recognition</h3>
                    <p class="feat-desc">Identifikasi pengguna secara otomatis lewat kamera saat masuk/keluar area parkir. Akurasi hingga 99% tanpa perlu kartu atau aplikasi tambahan.</p>
                </div>

                <!-- ANPR -->
                <div class="feat-card highlighted reveal reveal-delay-2">
                    <span class="feat-badge-new">UTAMA</span>
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="10" rx="2"/>
                            <path d="M7 12h.01M11 12h2M16 12h.01"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">ANPR Otomatis</h3>
                    <p class="feat-desc">Kamera ANPR membaca plat nomor kendaraan secara real-time. Sistem mencocokkan data dengan database terdaftar dalam hitungan detik.</p>
                </div>

                <!-- Monitoring Real-Time -->
                <div class="feat-card reveal reveal-delay-3">
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">Monitoring Real-Time</h3>
                    <p class="feat-desc">Pantau ketersediaan slot parkir di Zona A, B, dan C secara langsung — diperbarui otomatis setiap kendaraan terdeteksi masuk atau keluar.</p>
                </div>

                <!-- Pendaftaran Kendaraan -->
                <div class="feat-card reveal reveal-delay-1">
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M9 9h6M9 12h6M9 15h4"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">Pendaftaran Kendaraan & Wajah</h3>
                    <p class="feat-desc">Daftarkan plat nomor dan foto wajah melalui dashboard. Data diverifikasi admin sebelum diaktifkan ke sistem pengenalan otomatis.</p>
                </div>

                <!-- Pembayaran Digital -->
                <div class="feat-card reveal reveal-delay-2">
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">Pembayaran Digital</h3>
                    <p class="feat-desc">Retribusi parkir dihitung otomatis berdasarkan durasi dan dicatat sistem. Bayar secara cashless langsung dari dashboard pengguna.</p>
                </div>

                <!-- Laporan & Rekap -->
                <div class="feat-card reveal reveal-delay-3">
                    <div class="feat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <h3 class="feat-title">Laporan & Log Aktivitas</h3>
                    <p class="feat-desc">Admin dapat mengunduh laporan harian/mingguan lengkap dengan log deteksi ANPR, rekam Face Recognition, dan riwayat transaksi.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- =================== TEKNOLOGI =================== -->
    <section class="tech-spec" id="teknologi">
        <div class="section-inner">
            <div class="reveal">
                <div class="section-eyebrow">✦ Spesifikasi Teknologi</div>
                <h2 class="section-title">Dua teknologi utama<br>yang bekerja <em>bersama</em></h2>
                <p class="section-sub">Face Recognition dan ANPR diintegrasikan langsung ke pintu masuk/keluar kampus untuk proses deteksi otomatis tanpa interaksi manual.</p>
            </div>
            <div class="tech-spec-grid">
                <div class="spec-list reveal reveal-delay-1">
                    <div class="spec-item">
                        <div class="spec-num">FR</div>
                        <div class="spec-text">
                            <h4>Face Recognition — Identifikasi Pengguna</h4>
                            <p>Kamera mendeteksi wajah sivitas akademika yang sudah terdaftar. Sistem memverifikasi identitas secara real-time dan membuka akses parkir otomatis.</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-num">NP</div>
                        <div class="spec-text">
                            <h4>ANPR — Pembacaan Plat Nomor</h4>
                            <p>Kamera ANPR menangkap dan membaca plat nomor kendaraan saat melintas di gate. Data dicocokkan dengan database kendaraan terdaftar dalam &lt;2 detik.</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-num">DB</div>
                        <div class="spec-text">
                            <h4>Database Terpusat</h4>
                            <p>Semua data wajah, plat nomor, dan riwayat akses tersimpan terpusat dan dapat diakses admin melalui dashboard dengan kontrol akses berbasis peran.</p>
                        </div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-num">GT</div>
                        <div class="spec-text">
                            <h4>Sistem Gate Otomatis</h4>
                            <p>Palang parkir terbuka secara otomatis setelah wajah atau plat nomor terverifikasi. Tidak perlu kartu parkir atau interaksi dengan petugas.</p>
                        </div>
                    </div>
                </div>

                <div class="tech-visual reveal reveal-delay-2">
                    <div class="tv-inner">
                        <div class="tv-title">Live Detection Feed</div>

                        <div class="tv-cam-row">
                            <div class="tv-cam">
                                <div class="tv-cam-label">Kamera Face Recognition</div>
                                <div class="tv-cam-icon">😊</div>
                                <div class="tv-cam-status">● Aktif · Gate A</div>
                            </div>
                            <div class="tv-cam">
                                <div class="tv-cam-label">Kamera ANPR</div>
                                <div class="tv-cam-icon">📷</div>
                                <div class="tv-cam-status">● Aktif · Gate A</div>
                            </div>
                        </div>

                        <div class="tv-result">
                            <div class="tv-result-row">
                                <span class="tv-result-label">Plat Terdeteksi</span>
                                <span class="tv-result-val">P 5678 CD</span>
                            </div>
                            <div class="tv-result-row">
                                <span class="tv-result-label">Status Kendaraan</span>
                                <span class="tv-result-val green">✓ Terdaftar</span>
                            </div>
                            <div class="tv-result-row">
                                <span class="tv-result-label">Face Match</span>
                                <span class="tv-result-val green">✓ Terverifikasi (99.3%)</span>
                            </div>
                            <div class="tv-result-row">
                                <span class="tv-result-label">Gate Status</span>
                                <span class="tv-result-val yellow">⟶ Membuka...</span>
                            </div>
                        </div>

                        <div class="tv-acc-row">
                            <div class="tv-acc">
                                <div class="tv-acc-num">98<span>%</span></div>
                                <div class="tv-acc-label">Akurasi ANPR</div>
                            </div>
                            <div class="tv-acc">
                                <div class="tv-acc-num">99<span>%</span></div>
                                <div class="tv-acc-label">Akurasi Face</div>
                            </div>
                            <div class="tv-acc">
                                <div class="tv-acc-num">&lt;2<span>s</span></div>
                                <div class="tv-acc-label">Waktu Deteksi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== HOW IT WORKS =================== -->
    <section class="how" id="cara-pakai">
        <div class="section-inner">
            <div class="reveal">
                <div class="section-eyebrow">✦ Cara Pakai</div>
                <h2 class="section-title">Masuk parkir dalam <em>4 langkah</em> otomatis</h2>
                <p class="section-sub">Tidak perlu kartu parkir. Cukup daftarkan wajah dan plat kendaraan — sistem bekerja otomatis setiap hari.</p>
            </div>
            <div class="how-grid">
                <div class="steps-list reveal reveal-delay-1">
                    <div class="how-step">
                        <div class="step-circle">1</div>
                        <div class="step-content">
                            <h4>Daftar & Verifikasi Akun</h4>
                            <p>Buat akun menggunakan NIM (mahasiswa) atau ID karyawan. Verifikasi melalui email kampus Anda. Proses selesai dalam beberapa menit.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <div class="step-circle">2</div>
                        <div class="step-content">
                            <h4>Daftarkan Wajah & Plat Kendaraan</h4>
                            <p>Upload foto wajah dan masukkan nomor plat kendaraan. Admin memverifikasi data Anda untuk dimasukkan ke sistem ANPR dan Face Recognition.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <div class="step-circle">3</div>
                        <div class="step-content">
                            <h4>Deteksi Otomatis di Gate</h4>
                            <p>Saat masuk kampus, kamera ANPR membaca plat kendaraan dan kamera FR memverifikasi wajah Anda. Gate terbuka otomatis jika data cocok — tanpa berhenti lama.</p>
                        </div>
                    </div>
                    <div class="how-step">
                        <div class="step-circle">4</div>
                        <div class="step-content">
                            <h4>Riwayat & Tagihan Otomatis</h4>
                            <p>Setiap sesi parkir tercatat otomatis di dashboard. Durasi dihitung, retribusi muncul langsung, dan bisa dibayar secara digital kapan saja.</p>
                        </div>
                    </div>
                </div>

                <div class="how-visual reveal reveal-delay-2">
                    <div class="how-phone">
                        <div class="phone-notch"></div>
                        <div class="phone-status">
                            <span>EasyPark</span>
                            <span>🟢 Online</span>
                        </div>
                        <div class="phone-app-title">Gate A — Deteksi Aktif</div>

                        <!-- Face scan box -->
                        <div class="face-scan-box">
                            <div class="face-icon">😊</div>
                            <div class="face-label">Face Recognition</div>
                            <div class="face-id">Ahmad Rizki · NIM 2341234 · ✓ Match</div>
                        </div>

                        <!-- ANPR row -->
                        <div class="phone-anpr">
                            <div class="phone-anpr-icon">📷</div>
                            <div>
                                <div class="phone-anpr-plate">P 1234 AB</div>
                                <div class="phone-anpr-meta">ANPR · Honda Vario · Putih</div>
                            </div>
                            <div class="phone-anpr-ok">✓ OK</div>
                        </div>

                        <div class="phone-slot-grid">
                            <div class="ps t">C01</div>
                            <div class="ps t">C02</div>
                            <div class="ps f">C03</div>
                            <div class="ps t">C04</div>
                            <div class="ps f">C05</div>
                            <div class="ps t">C06</div>
                            <div class="ps t">C07</div>
                            <div class="ps f">C08</div>
                        </div>
                        <div class="phone-legend">
                            <div class="leg"><div class="leg-dot t"></div>Terisi</div>
                            <div class="leg"><div class="leg-dot f"></div>Kosong</div>
                        </div>
                        <button class="phone-btn">Lihat Semua Zona →</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== STATISTIK =================== -->
    <section class="stats-section" id="statistik">
        <div class="section-inner">
            <div class="text-center reveal">
                <div class="section-eyebrow">✦ Statistik Sistem</div>
                <h2 class="section-title">Performa nyata <em>EasyPark</em></h2>
                <p class="section-sub">Data performa sistem Face Recognition dan ANPR di area Kampus 2 Bondowoso Politeknik Negeri Jember.</p>
            </div>
            <div class="stats-cards">
                <div class="stat-card reveal reveal-delay-1">
                    <div class="stat-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="3" width="15" height="13" rx="2"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                    </div>
                    <div class="stat-card-num">200<span>+</span></div>
                    <div class="stat-card-label">Slot Parkir Tersedia</div>
                </div>
                <div class="stat-card reveal reveal-delay-2">
                    <div class="stat-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="stat-card-num">
                        @if ($activeUsers >= 1000)
                            {{ number_format($activeUsers / 1000, 1) }}<span>rb</span>
                        @else
                            {{ $activeUsers }}
                        @endif
                    </div>
                    <div class="stat-card-label">Pengguna Terdaftar</div>
                </div>
                <div class="stat-card reveal reveal-delay-3">
                    <div class="stat-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M6 20v-1a6 6 0 0 1 12 0v1"/>
                            <path d="M2 12h2M20 12h2"/>
                        </svg>
                    </div>
                    <div class="stat-card-num">99<span>%</span></div>
                    <div class="stat-card-label">Akurasi Face Recognition</div>
                </div>
                <div class="stat-card reveal reveal-delay-4">
                    <div class="stat-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="10" rx="2"/>
                            <path d="M7 12h.01M11 12h2M16 12h.01"/>
                        </svg>
                    </div>
                    <div class="stat-card-num">98<span>%</span></div>
                    <div class="stat-card-label">Akurasi ANPR</div>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== FAQ =================== -->
    <section class="faq" id="faq">
        <div class="section-inner">
            <div class="reveal">
                <div class="section-eyebrow">✦ FAQ</div>
                <h2 class="section-title">Pertanyaan yang <em>sering ditanyakan</em></h2>
            </div>
            <div class="faq-grid">
                <div class="faq-sidebar reveal reveal-delay-1">
                    <h3>Ada pertanyaan lain?</h3>
                    <p>Jika pertanyaan Anda tidak ada di sini, hubungi pengelola sistem EasyPark melalui UPT TIK Polije Bondowoso.</p>
                    <a href="mailto:tik@polije.ac.id" class="faq-contact">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <span>Hubungi UPT TIK Polije</span>
                    </a>
                </div>
                <div class="faq-list reveal reveal-delay-2">
                    <div class="faq-item open">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Bagaimana cara kerja Face Recognition di sistem EasyPark?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Kamera Face Recognition dipasang di gate masuk dan keluar kampus. Saat Anda mendekat, sistem secara otomatis mendeteksi dan mencocokkan wajah Anda dengan data yang telah didaftarkan. Jika cocok, palang parkir terbuka otomatis dalam kurang dari 2 detik.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Bagaimana ANPR membaca plat nomor kendaraan saya?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Kamera ANPR (Automatic Number Plate Recognition) menggunakan algoritma computer vision untuk membaca karakter pada plat nomor kendaraan secara otomatis. Sistem kemudian mencocokkan hasil pembacaan dengan database kendaraan terdaftar dalam waktu kurang dari 2 detik.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Apakah saya tetap bisa masuk jika wajah tidak terdeteksi?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Jika Face Recognition gagal mendeteksi (misalnya karena kondisi cahaya), ANPR tetap berjalan sebagai backup. Petugas parkir juga selalu standby di pos jaga untuk membantu verifikasi manual jika diperlukan.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Bagaimana cara mendaftarkan wajah dan kendaraan?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Setelah login ke dashboard, buka menu "Kendaraan Saya" untuk mendaftarkan plat nomor dan upload foto wajah Anda. Data akan diverifikasi oleh admin dalam 1×24 jam sebelum aktif di sistem ANPR dan Face Recognition.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Apakah data wajah saya aman tersimpan di sistem?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Data biometrik wajah disimpan dalam format terenkripsi di server internal kampus dan hanya digunakan untuk keperluan verifikasi parkir. Data tidak dibagikan ke pihak ketiga dan hanya dapat diakses oleh admin sistem dengan otorisasi resmi.</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q" onclick="toggleFaq(this)">
                            <span>Apakah ada biaya untuk menggunakan EasyPark?</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        <div class="faq-a">
                            <p>Penggunaan platform EasyPark gratis untuk seluruh sivitas akademika Polije Bondowoso. Biaya yang ada hanya retribusi parkir sesuai tarif resmi kampus yang dibayarkan secara digital melalui fitur pembayaran di dalam sistem.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =================== CTA BAND =================== -->
    <section class="cta-band">
        <div class="cta-band-grid"></div>
        <div class="cta-band-orb"></div>
        <div class="cta-inner reveal">
            <h2 class="cta-title">Parkir otomatis dengan<br><em>Face Recognition & ANPR</em></h2>
            <p class="cta-sub">
                Bergabung dengan lebih dari
                <strong>{{ number_format($activeUsers) }}</strong>
                pengguna aktif Polije Bondowoso yang sudah menikmati kemudahan parkir tanpa kartu bersama EasyPark.
            </p>
            <div class="cta-btns">
                <a href="/login" class="btn-cta-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk Sekarang
                </a>
                <a href="#teknologi" class="btn-cta-secondary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Pelajari Teknologi
                </a>
            </div>
        </div>
    </section>

    <!-- =================== FOOTER =================== -->
    <footer>
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="footer-logo-box">
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9"/>
                                <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5"/>
                                <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75"/>
                            </svg>
                        </div>
                        <span class="footer-wordmark">Easy<span>Park</span></span>
                    </div>
                    <p class="footer-desc">Sistem parkir pintar berbasis Face Recognition dan ANPR yang dirancang khusus untuk Politeknik Negeri Jember Kampus 2 Bondowoso.</p>
                    <div class="footer-polije">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                        <p><strong>Politeknik Negeri Jember</strong>Kampus 2 — Bondowoso, Jawa Timur</p>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Sistem</h4>
                    <a href="/login">Login</a>
                    <a href="/register">Daftar</a>
                    <a href="#">Dashboard</a>
                    <a href="#">Kendaraan Saya</a>
                </div>
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <a href="#fitur">Fitur</a>
                    <a href="#teknologi">Teknologi</a>
                    <a href="#cara-pakai">Cara Pakai</a>
                    <a href="#faq">FAQ</a>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <a href="mailto:tik@polije.ac.id">tik@polije.ac.id</a>
                    <a href="#">UPT TIK Polije</a>
                    <a href="#">Pos Petugas Parkir</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025 EasyPark · Politeknik Negeri Jember Kampus 2 Bondowoso · Pengembangan Sistem Parkir Pintar berbasis Face Recognition & ANPR · Dibuat dengan <span>♥</span> oleh Tim TIK</p>
                <div class="footer-socials">
                    <div class="social-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></div>
                    <div class="social-btn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        /* Navbar scroll */
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
        nav.classList.add('scrolled');

        /* Mobile menu */
        let menuOpen = false;
        function toggleMenu() {
            menuOpen = !menuOpen;
            const menu = document.getElementById('mobileMenu');
            const ham  = document.getElementById('hamburger');
            menu.classList.toggle('open', menuOpen);
            const spans = ham.querySelectorAll('span');
            if (menuOpen) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '';
                spans[2].style.transform = '';
            }
        }

        /* Scroll reveal */
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
            });
        }, { threshold: 0.12 });
        reveals.forEach(r => observer.observe(r));

        /* FAQ accordion */
        function toggleFaq(btn) {
            const item   = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        }

        /* Slot bar animation */
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelectorAll('.slot-bar-fill').forEach(b => {
                    const w = b.style.width;
                    b.style.width = '0';
                    setTimeout(() => { b.style.width = w; }, 200);
                });
            }, 500);
        });
    </script>
</body>
</html>