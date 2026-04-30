<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password — EasyPark Polije Bondowoso</title>
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
            --n-50: #F5F7FC;
            --n-100: #EBEEF5;
            --n-200: #D4D9E8;
            --n-400: #8A93AE;
            --n-600: #4A5272;
            --n-900: #181D35;
            --s-50: #EAFAF3;
            --s-100: #C2F0DC;
            --s-600: #1A7A4A;
            --e-50: #FEF2F2;
            --e-100: #FED7D7;
            --e-600: #DC2626;
        }

        .iw input.error {
            border-color: var(--e-600);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .otp-row input.error {
            border-color: var(--e-600);
            background: var(--e-50);
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 16px;
            font-size: 12.5px;
            line-height: 1.5;
            animation: fdup .3s ease both;
        }

        .alert-error {
            background: var(--e-50);
            border: 1px solid var(--e-100);
            color: var(--e-600);
        }

        .alert-success {
            background: var(--s-50);
            border: 1px solid var(--s-100);
            color: var(--s-600);
        }

        .alert svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .spin {
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            flex-shrink: 0;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #071433;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* LEFT */
        .lp {
            display: none;
            flex: 1;
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
        }

        @media(min-width:1024px) {
            .lp {
                display: flex;
            }
        }

        .lp-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(150deg, #071433 0%, #0C2260 55%, #0E2F7A 100%);
        }

        .grid {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(59, 111, 212, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(59, 111, 212, 0.1) 1px, transparent 1px);
            background-size: 56px 56px;
            animation: gridD 24s linear infinite;
        }

        @keyframes gridD {
            from {
                background-position: 0 0
            }

            to {
                background-position: 56px 56px
            }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            animation: brth 7s ease-in-out infinite alternate;
        }

        .o1 {
            width: 420px;
            height: 420px;
            background: rgba(59, 111, 212, 0.28);
            top: -100px;
            left: -100px;
        }

        .o2 {
            width: 300px;
            height: 300px;
            background: rgba(232, 183, 64, 0.15);
            bottom: 80px;
            right: -60px;
            animation-delay: 2.5s;
        }

        .o3 {
            width: 220px;
            height: 220px;
            background: rgba(59, 111, 212, 0.18);
            top: 45%;
            left: 38%;
            animation-delay: 4.5s;
        }

        @keyframes brth {
            0% {
                opacity: .5;
                transform: scale(1)
            }

            100% {
                opacity: 1;
                transform: scale(1.18)
            }
        }

        /* Lock illustration */
        .lock-scene {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pr1,
        .pr2,
        .pr3 {
            position: absolute;
            border-radius: 50%;
            border: 1.5px solid rgba(59, 111, 212, 0.22);
            animation: pring 3s ease-out infinite;
        }

        .pr1 {
            width: 200px;
            height: 200px;
        }

        .pr2 {
            width: 290px;
            height: 290px;
            animation-delay: 1s;
        }

        .pr3 {
            width: 380px;
            height: 380px;
            animation-delay: 2s;
        }

        @keyframes pring {
            0% {
                opacity: .8;
                transform: scale(.7)
            }

            100% {
                opacity: 0;
                transform: scale(1)
            }
        }

        .lock-wrap {
            animation: lkflt 4s ease-in-out infinite alternate;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes lkflt {
            from {
                transform: translateY(0)
            }

            to {
                transform: translateY(-16px)
            }
        }

        .lock-arch {
            width: 88px;
            height: 52px;
            border: 7px solid rgba(59, 111, 212, 0.55);
            border-bottom: none;
            border-radius: 44px 44px 0 0;
        }

        .lock-body {
            width: 128px;
            height: 98px;
            background: rgba(59, 111, 212, 0.15);
            border: 2px solid rgba(59, 111, 212, 0.45);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -1px;
        }

        .lock-kh {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(59, 111, 212, 0.65);
            position: relative;
        }

        .lock-kh::after {
            content: '';
            position: absolute;
            top: 13px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 18px;
            background: rgba(59, 111, 212, 0.65);
            border-radius: 0 0 4px 4px;
        }

        .key-float {
            position: absolute;
            top: 28%;
            right: 18%;
            animation: kflt 6s ease-in-out infinite alternate;
            opacity: .45;
        }

        @keyframes kflt {
            from {
                transform: translate(0, 0) rotate(-15deg)
            }

            to {
                transform: translate(20px, -20px) rotate(15deg)
            }
        }

        /* Left copy */
        .lc {
            position: relative;
            z-index: 10;
        }

        .pmk {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }

        .pem {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pem svg {
            width: 28px;
            height: 28px;
        }

        .pnm p:first-child {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        .pnm p:last-child {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 2px;
        }

        .cbdg {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: rgba(59, 111, 212, 0.18);
            border: 1px solid rgba(59, 111, 212, 0.32);
            border-radius: 100px;
            padding: 7px 16px;
            margin-bottom: 26px;
        }

        .bdot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--g-400);
            box-shadow: 0 0 10px var(--g-400);
        }

        .cbdg span {
            font-size: 11px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .lh {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.9rem, 2.8vw, 2.7rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.18;
            margin-bottom: 14px;
        }

        .lh em {
            font-style: normal;
            color: var(--g-400);
        }

        .ls {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.46);
            line-height: 1.75;
            max-width: 340px;
            margin-bottom: 36px;
        }

        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .stp {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .snum {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(59, 111, 212, 0.25);
            border: 1px solid rgba(59, 111, 212, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.8);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .stxt p:first-child {
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
        }

        .stxt p:last-child {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.38);
            margin-top: 2px;
        }

        /* RIGHT */
        .rp {
            width: 100%;
            background: var(--n-50);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            position: relative;
            overflow-y: auto;
        }

        @media(min-width:1024px) {
            .rp {
                width: 560px;
                flex-shrink: 0;
            }
        }

        .ri {
            width: 100%;
            max-width: 460px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
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

        .logo-box svg {
            width: 24px;
            height: 24px;
        }

        .lw {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--n-900);
            letter-spacing: -.02em;
        }

        .lw span {
            color: var(--p-600);
        }

        .lsep {
            width: 1px;
            height: 22px;
            background: var(--n-200);
            margin: 0 2px;
        }

        .lcamp {
            font-size: 11.5px;
            color: var(--n-400);
            line-height: 1.35;
        }

        .lcamp strong {
            display: block;
            color: var(--n-600);
            font-weight: 600;
            font-size: 12px;
        }

        .back-lnk {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--n-400);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .18s;
        }

        .back-lnk:hover {
            color: var(--p-600);
        }

        .back-lnk svg {
            width: 15px;
            height: 15px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2.8rem 2.5rem;
            box-shadow: 0 4px 32px rgba(14, 47, 122, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        /* Step indicator */
        .si {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 24px;
        }

        .sd {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 12px;
            font-weight: 600;
            background: var(--n-100);
            color: var(--n-400);
            border: 1.5px solid var(--n-200);
            transition: all .3s;
            flex-shrink: 0;
        }

        .sd.done {
            background: var(--p-600);
            color: #fff;
            border-color: var(--p-600);
        }

        .sd.active {
            background: var(--p-50);
            color: var(--p-800);
            border-color: var(--p-600);
            font-weight: 700;
        }

        .sd.done svg {
            width: 12px;
            height: 12px;
        }

        .sl {
            flex: 1;
            height: 2px;
            background: var(--n-200);
            margin: 0 4px;
            transition: background .3s;
        }

        .sl.done {
            background: var(--p-600);
        }

        .slr {
            display: flex;
            justify-content: space-between;
            margin-bottom: 22px;
            margin-top: -18px;
        }

        .slb {
            font-size: 11px;
            color: var(--n-400);
            text-align: center;
            flex: 1;
        }

        .slb.active {
            color: var(--p-600);
            font-weight: 500;
        }

        .view {
            display: none;
        }

        .view.active {
            display: block;
        }

        .ft {
            font-family: 'Syne', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--n-900);
            margin-bottom: 5px;
        }

        .fsub {
            font-size: 14px;
            color: var(--n-400);
            line-height: 1.55;
            margin-bottom: 24px;
        }

        /* Role chips */
        .chips {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .chip {
            padding: 7px 16px;
            border-radius: 100px;
            border: 1.5px solid var(--n-200);
            background: var(--n-50);
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--n-600);
            cursor: pointer;
            transition: all .18s;
        }

        .chip:hover {
            border-color: var(--p-200);
            background: var(--p-50);
            color: var(--p-800);
        }

        .chip.active {
            border-color: var(--p-600);
            background: var(--p-50);
            color: var(--p-800);
            font-weight: 600;
        }

        .fld {
            margin-bottom: 18px;
        }

        .fld label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--n-600);
            margin-bottom: 6px;
        }

        .iw {
            position: relative;
        }

        .iic {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--n-400);
            pointer-events: none;
            transition: color .2s;
        }

        .iw input {
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
            transition: border-color .2s, background .2s, box-shadow .2s;
        }

        .iw input::placeholder {
            color: #B3BBCC;
        }

        .iw input:focus {
            border-color: var(--p-400);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 111, 212, 0.1);
        }

        .eyb {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--n-400);
            transition: color .2s;
        }

        .eyb:hover {
            color: var(--n-600);
        }

        /* OTP — FIXED: kotak tetap kecil, tidak melebar */
        .otp-row {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .otp-row input {
            flex: 0 0 48px;
            width: 48px;
            height: 52px;
            border: 1.5px solid var(--n-200);
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--n-900);
            background: var(--n-50);
            outline: none;
            text-align: center;
            caret-color: var(--p-600);
            transition: border-color .2s, background .2s, box-shadow .2s;
        }

        .otp-row input:focus {
            border-color: var(--p-400);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59, 111, 212, 0.1);
        }

        .otp-row input.filled {
            border-color: var(--p-600);
            background: var(--p-50);
            color: var(--p-800);
        }

        /* Strength */
        .pws {
            margin-top: 8px;
            margin-bottom: 6px;
        }

        .pwsb {
            display: flex;
            gap: 4px;
            margin-bottom: 5px;
        }

        .pwb {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: var(--n-200);
            transition: background .3s;
        }

        .pwb.weak {
            background: #E24B4A;
        }

        .pwb.medium {
            background: var(--g-400);
        }

        .pwb.strong {
            background: #27a06b;
        }

        .pwst {
            font-size: 11.5px;
            color: var(--n-400);
        }

        /* Resend */
        .rsr {
            text-align: center;
            margin-bottom: 20px;
        }

        .rsr p {
            font-size: 13px;
            color: var(--n-400);
        }

        .rsbtn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--p-600);
            font-weight: 600;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            padding: 0;
        }

        .rsbtn:hover {
            text-decoration: underline;
        }

        .rsbtn:disabled {
            color: var(--n-400);
            cursor: not-allowed;
            text-decoration: none;
        }

        .cntd {
            font-weight: 600;
            color: var(--p-600);
        }

        /* Info strip */
        .is {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--p-50);
            border: 1px solid var(--p-100);
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 20px;
        }

        .is svg {
            width: 15px;
            height: 15px;
            color: var(--p-600);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .is p {
            font-size: 12.5px;
            color: var(--p-800);
            line-height: 1.5;
        }

        /* Success */
        .sic {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--s-50);
            border: 2px solid var(--s-100);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: spop .4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes spop {
            from {
                opacity: 0;
                transform: scale(.5)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        .sic svg {
            width: 32px;
            height: 32px;
            color: var(--s-600);
        }

        .stl {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--n-900);
            text-align: center;
            margin-bottom: 8px;
        }

        .ssb {
            font-size: 14px;
            color: var(--n-400);
            text-align: center;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        /* Buttons */
        .btn {
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
            letter-spacing: .01em;
            transition: background .2s, transform .12s, box-shadow .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            background: var(--p-900);
            box-shadow: 0 8px 28px rgba(7, 28, 82, 0.32);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .btn:disabled {
            background: var(--n-200);
            color: var(--n-400);
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .btn2 {
            width: 100%;
            height: 48px;
            background: none;
            color: var(--p-600);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border: 1.5px solid var(--p-200);
            border-radius: 12px;
            cursor: pointer;
            transition: background .2s, border-color .2s;
            margin-top: 10px;
        }

        .btn2:hover {
            background: var(--p-50);
            border-color: var(--p-400);
        }

        /* Animate */
        .ai {
            animation: fdup .45s ease both;
        }

        .ai:nth-child(1) {
            animation-delay: .04s;
        }

        .ai:nth-child(2) {
            animation-delay: .09s;
        }

        .ai:nth-child(3) {
            animation-delay: .14s;
        }

        .ai:nth-child(4) {
            animation-delay: .19s;
        }

        .ai:nth-child(5) {
            animation-delay: .24s;
        }

        .ai:nth-child(6) {
            animation-delay: .29s;
        }

        @keyframes fdup {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }
    </style>
</head>

<body>

    <!-- LEFT -->
    <div class="lp">
        <div class="lp-bg"></div>
        <div class="grid"></div>
        <div class="orb o1"></div>
        <div class="orb o2"></div>
        <div class="orb o3"></div>

        <div class="lock-scene">
            <div class="pr1"></div>
            <div class="pr2"></div>
            <div class="pr3"></div>
            <div class="lock-wrap">
                <div class="lock-arch"></div>
                <div class="lock-body">
                    <div class="lock-kh"></div>
                </div>
            </div>
            <div class="key-float">
                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(59,111,212,0.65)"
                    stroke-width="1.5">
                    <circle cx="7.5" cy="15.5" r="5.5" />
                    <path d="M21 2l-9.6 9.6M15.5 7.5l3 3M13 10l3 3" />
                </svg>
            </div>
        </div>

        <div class="lc">
            <div class="pmk">
                <div class="pem">
                    <svg viewBox="0 0 28 28" fill="none">
                        <path d="M14 2L3 7.5v6.5c0 5.5 4.7 9.8 11 11 6.3-1.2 11-5.5 11-11V7.5L14 2z"
                            stroke="rgba(255,255,255,0.75)" stroke-width="1.5" fill="rgba(255,255,255,0.07)" />
                        <path d="M9 14h10M14 10v8" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div class="pnm">
                    <p>Politeknik Negeri Jember</p>
                    <p>Kampus 2 — Bondowoso</p>
                </div>
            </div>
            <div class="cbdg">
                <div class="bdot"></div><span>Pemulihan Akun</span>
            </div>
            <h1 class="lh">Lupa password?<br><em>Kami bantu</em> pulihkan</h1>
            <p class="ls">Ikuti tiga langkah mudah untuk mengatur ulang password akun EasyPark Anda dengan aman.</p>
            <div class="steps-list">
                <div class="stp">
                    <div class="snum">1</div>
                    <div class="stxt">
                        <p>Verifikasi Identitas</p>
                        <p>Masukkan email atau NIM/ID terdaftar</p>
                    </div>
                </div>
                <div class="stp">
                    <div class="snum">2</div>
                    <div class="stxt">
                        <p>Kode OTP</p>
                        <p>Cek email untuk kode 6 digit</p>
                    </div>
                </div>
                <div class="stp">
                    <div class="snum">3</div>
                    <div class="stxt">
                        <p>Password Baru</p>
                        <p>Buat password yang kuat dan aman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="rp">
        <div class="ri">

            <div class="logo-row">
                <div class="logo-box">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9" />
                        <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5" />
                        <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75" />
                    </svg>
                </div>
                <span class="lw">Easy<span>Park</span></span>
                <div class="lsep"></div>
                <div class="lcamp"><strong>Polije Bondowoso</strong>Kampus 2</div>
            </div>

            <a href="/login" class="back-lnk">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7 7M5 12l7-7" />
                </svg>
                Kembali ke halaman login
            </a>

            <div class="card">

                <!-- Step indicator -->
                <div class="si" id="stepInd">
                    <div class="sd active" id="d1">1</div>
                    <div class="sl" id="l1"></div>
                    <div class="sd" id="d2">2</div>
                    <div class="sl" id="l2"></div>
                    <div class="sd" id="d3">3</div>
                </div>
                <div class="slr" id="slrow">
                    <div class="slb active" id="lb1">Identitas</div>
                    <div class="slb" id="lb2">Kode OTP</div>
                    <div class="slb" id="lb3">Password Baru</div>
                </div>

                <!-- VIEW 1 -->
                <div class="view active" id="v1">
                    <div id="alert1"></div> {{-- ← tambah ini --}}
                    <div class="ai">
                        <h2 class="ft">Verifikasi identitas 🔑</h2>
                        <p class="fsub">Pilih peran Anda dan masukkan email atau ID yang terdaftar di sistem</p>
                    </div>
                    <div class="ai">
                        <p style="font-size:13px;font-weight:500;color:var(--n-600);margin-bottom:10px;">Saya adalah
                        </p>
                        <div class="chips">
                            <button class="chip active" data-role="mahasiswa"
                                onclick="pickChip(this)">Mahasiswa</button>
                            <button class="chip" data-role="petugas" onclick="pickChip(this)">Petugas</button>
                            <button class="chip" data-role="admin" onclick="pickChip(this)">Admin</button>
                        </div>
                    </div>
                    <div class="fld ai">
                        <label id="lbl_id" for="ident">Email / NIM Mahasiswa</label>
                        <div class="iw">
                            <svg class="iic" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <input type="text" id="ident" placeholder="Masukkan email atau NIM Anda">
                        </div>
                    </div>
                    <div class="is ai">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <p id="info1">Kode OTP akan dikirimkan ke email yang terdaftar sesuai NIM Anda di SIAKAD.
                        </p>
                    </div>
                    <button class="btn ai" id="btnSendOtp" onclick="sendOtp()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .82h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.68a16 16 0 006.29 6.29l1.42-1.42a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                        </svg>
                        Kirim Kode OTP
                    </button>
                </div>

                <!-- VIEW 2 -->
                <div class="view" id="v2">
                    <div id="alert2"></div> {{-- ← tambah ini --}}
                    <div class="ai">
                        <h2 class="ft">Masukkan kode OTP 📩</h2>
                        <p class="fsub">Kode 6 digit telah dikirim ke email Anda. Berlaku selama <strong>5
                                menit</strong>.</p>
                    </div>
                    <div class="otp-row ai">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                        <input type="text" maxlength="1" class="oi" inputmode="numeric">
                    </div>
                    <div class="rsr ai">
                        <p>Tidak menerima kode?&nbsp;
                            <button class="rsbtn" id="rsBtn" disabled onclick="resendOtp()">Kirim ulang (<span
                                    class="cntd" id="cd">60</span>s)</button>
                        </p>
                    </div>
                    <button class="btn ai" id="vBtn" onclick="verifyOtp()" disabled>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Verifikasi Kode
                    </button>
                    <button class="btn2" onclick="go(1)">Ubah email / NIM</button>
                </div>

                <!-- VIEW 3 -->
                <div class="view" id="v3">
                    <div id="alert3"></div> {{-- ← tambah ini --}}
                    <div class="ai">
                        <h2 class="ft">Buat password baru 🔒</h2>
                        <p class="fsub">Password harus minimal 8 karakter, mengandung huruf kapital dan angka</p>
                    </div>
                    <div class="fld ai">
                        <label for="npw">Password Baru</label>
                        <div class="iw">
                            <svg class="iic" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="npw" placeholder="Minimal 8 karakter"
                                oninput="chkStr(this.value)">
                            <button type="button" class="eyb" onclick="togPw(this)"><svg viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:16px;height:16px;">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg></button>
                        </div>
                        <div class="pws">
                            <div class="pwsb">
                                <div class="pwb" id="b1"></div>
                                <div class="pwb" id="b2"></div>
                                <div class="pwb" id="b3"></div>
                                <div class="pwb" id="b4"></div>
                            </div>
                            <p class="pwst" id="sttxt">Masukkan password untuk melihat kekuatannya</p>
                        </div>
                    </div>
                    <div class="fld ai">
                        <label for="cpw">Konfirmasi Password</label>
                        <div class="iw">
                            <svg class="iic" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            <input type="password" id="cpw" placeholder="Ulangi password baru">
                            <button type="button" class="eyb" onclick="togPw(this)"><svg viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:16px;height:16px;">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg></button>
                        </div>
                    </div>
                    <button class="btn ai" id="btnSavePass" onclick="savePassword()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14a2 2 0 01-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Password Baru
                    </button>
                </div>

                <!-- VIEW 4: Sukses -->
                <div class="view" id="v4">
                    <div style="text-align:center;padding:1rem 0 .5rem;">
                        <div class="sic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg></div>
                        <h2 class="stl">Password Berhasil Diubah!</h2>
                        <p class="ssb">Password akun EasyPark Anda telah diperbarui. Silakan login kembali
                            menggunakan password baru Anda.</p>
                        <a href="/login" style="text-decoration:none;">
                            <button class="btn" style="max-width:280px;margin:0 auto;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:18px;height:18px;">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                    <polyline points="10 17 15 12 10 7" />
                                    <line x1="15" y1="12" x2="3" y2="12" />
                                </svg>
                                Kembali Login
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        const chipCfg = {
            mahasiswa: {
                label: 'Email / NIM Mahasiswa',
                ph: 'Masukkan email atau NIM',
                info: 'Kode OTP dikirim ke email yang terdaftar sesuai NIM di SIAKAD.'
            },
            petugas: {
                label: 'Email / ID Petugas',
                ph: 'Masukkan email atau ID petugas',
                info: 'Kode OTP dikirim ke email yang didaftarkan saat registrasi akun petugas.'
            },
            admin: {
                label: 'Email Admin',
                ph: 'Masukkan email admin',
                info: 'Hubungi UPT TIK Polije jika tidak punya akses ke email admin terdaftar.'
            }
        };

        function pickChip(b) {
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            b.classList.add('active');
            const cfg = chipCfg[b.dataset.role];
            document.getElementById('lbl_id').textContent = cfg.label;
            document.getElementById('ident').placeholder = cfg.ph;
            document.getElementById('info1').textContent = cfg.info;
        }

        function go(n) {
            [1, 2, 3, 4].forEach(i => document.getElementById('v' + i).classList.remove('active'));
            document.getElementById('v' + n).classList.add('active');
            updStep(n);
            if (n === 2) {
                startCD();
                initOTP();
            }
        }

        function updStep(n) {
            for (let i = 1; i <= 3; i++) {
                const d = document.getElementById('d' + i),
                    l = document.getElementById('lb' + i);
                d.classList.remove('active', 'done');
                l.classList.remove('active');
                if (i < n) {
                    d.classList.add('done');
                    d.innerHTML =
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>';
                } else if (i === n) {
                    d.classList.add('active');
                    d.textContent = i;
                    l.classList.add('active');
                } else {
                    d.textContent = i;
                }
            }
            for (let i = 1; i <= 2; i++) document.getElementById('l' + i).classList.toggle('done', i < n);
        }

        // ── Alert helpers ──
        function showAlert(zone, type, msg) {
            const icon = type === 'error' ?
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' :
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
            document.getElementById(zone).innerHTML =
                `<div class="alert alert-${type}">${icon}<span>${msg}</span></div>`;
        }

        function clearAlert(zone) {
            document.getElementById(zone).innerHTML = '';
        }

        // ── Loading state ──
        function setLoading(btn, loading, orig) {
            btn.disabled = loading;
            btn.innerHTML = loading ? '<div class="spin"></div> Memproses...' : orig;
        }

        // ── STEP 1: Kirim OTP ──
        async function sendOtp() {
            clearAlert('alert1');
            const email = document.getElementById('ident').value.trim();
            if (!email) {
                showAlert('alert1', 'error', 'Email / NIM tidak boleh kosong.');
                document.getElementById('ident').classList.add('error');
                return;
            }
            document.getElementById('ident').classList.remove('error');

            const btn = document.getElementById('btnSendOtp'),
                orig = btn.innerHTML;
            setLoading(btn, true, orig);

            try {
                const res = await fetch('{{ route('password.email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email
                    })
                });
                const data = await res.json();
                if (res.ok) {
                    go(2);
                } else {
                    showAlert('alert1', 'error', data.errors?.email?.[0] ?? data.message ?? 'Terjadi kesalahan.');
                }
            } catch {
                showAlert('alert1', 'error', 'Koneksi gagal, periksa jaringan Anda.');
            } finally {
                setLoading(btn, false, orig);
            }
        }

        function initOTP() {
            const ins = document.querySelectorAll('.oi');
            ins.forEach((inp, idx) => {
                inp.value = '';
                inp.classList.remove('filled', 'error');
                inp.oninput = function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1);
                    if (this.value.length === 1) {
                        this.classList.add('filled');
                        if (idx < ins.length - 1) ins[idx + 1].focus();
                    } else this.classList.remove('filled');
                    document.getElementById('vBtn').disabled = [...ins].some(i => i.value.length !== 1);
                };
                inp.onkeydown = function(e) {
                    if (e.key === 'Backspace' && !this.value && idx > 0) {
                        ins[idx - 1].focus();
                        ins[idx - 1].value = '';
                        ins[idx - 1].classList.remove('filled');
                    }
                };
                inp.onpaste = function(e) {
                    e.preventDefault();
                    const p = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                    [...p].slice(0, 6).forEach((ch, i) => {
                        if (ins[i]) {
                            ins[i].value = ch;
                            ins[i].classList.add('filled');
                        }
                    });
                    ins[Math.min(p.length, 5)].focus();
                    document.getElementById('vBtn').disabled = [...ins].some(i => i.value.length !== 1);
                };
            });
            ins[0].focus();
        }

        let cdTimer;

        function startCD() {
            clearInterval(cdTimer);
            let s = 60;
            const btn = document.getElementById('rsBtn'),
                el = () => document.getElementById('cd');
            btn.disabled = true;
            btn.innerHTML = 'Kirim ulang (<span class="cntd" id="cd">' + s + '</span>s)';
            cdTimer = setInterval(() => {
                s--;
                if (el()) el().textContent = s;
                if (s <= 0) {
                    clearInterval(cdTimer);
                    btn.disabled = false;
                    btn.textContent = 'Kirim ulang kode';
                }
            }, 1000);
        }

        // ── Resend OTP ──
        async function resendOtp() {
            clearAlert('alert2');
            const email = document.getElementById('ident').value.trim();
            try {
                const res = await fetch('{{ route('password.email') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email
                    })
                });
                if (res.ok) {
                    showAlert('alert2', 'success', 'Kode OTP baru telah dikirim ke email Anda.');
                    startCD();
                } else {
                    showAlert('alert2', 'error', 'Gagal mengirim ulang kode, coba beberapa saat lagi.');
                }
            } catch {
                showAlert('alert2', 'error', 'Koneksi gagal.');
            }
        }

        // ── STEP 2: Verifikasi OTP ──
        async function verifyOtp() {
            clearAlert('alert2');
            const ins = document.querySelectorAll('.oi');
            const otp = [...ins].map(i => i.value).join('');

            const btn = document.getElementById('vBtn'),
                orig = btn.innerHTML;
            setLoading(btn, true, orig);

            try {
                const res = await fetch('{{ route('password.otp.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        otp
                    })
                });
                const data = await res.json();
                if (res.ok) {
                    go(3);
                } else {
                    showAlert('alert2', 'error', data.errors?.otp?.[0] ?? data.message ?? 'Kode OTP tidak valid.');
                    ins.forEach(i => {
                        i.classList.remove('filled');
                        i.classList.add('error');
                    });
                }
            } catch {
                showAlert('alert2', 'error', 'Koneksi gagal, periksa jaringan Anda.');
            } finally {
                setLoading(btn, false, orig);
            }
        }

        // ── STEP 3: Simpan Password ──
        async function savePassword() {
            clearAlert('alert3');
            const password = document.getElementById('npw').value;
            const password_confirmation = document.getElementById('cpw').value;

            if (password !== password_confirmation) {
                showAlert('alert3', 'error', 'Konfirmasi password tidak cocok.');
                document.getElementById('cpw').classList.add('error');
                return;
            }
            document.getElementById('cpw').classList.remove('error');

            const btn = document.getElementById('btnSavePass'),
                orig = btn.innerHTML;
            setLoading(btn, true, orig);

            try {
                const res = await fetch('{{ route('password.reset.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        password,
                        password_confirmation
                    })
                });
                const data = await res.json();
                if (res.ok) {
                    document.getElementById('stepInd').style.display = 'none';
                    document.getElementById('slrow').style.display = 'none';
                    [1, 2, 3].forEach(i => document.getElementById('v' + i).classList.remove('active'));
                    document.getElementById('v4').classList.add('active');
                } else {
                    showAlert('alert3', 'error', data.errors?.password?.[0] ?? data.message ??
                        'Gagal menyimpan password.');
                }
            } catch {
                showAlert('alert3', 'error', 'Koneksi gagal, periksa jaringan Anda.');
            } finally {
                setLoading(btn, false, orig);
            }
        }

        function chkStr(v) {
            const bs = [1, 2, 3, 4].map(i => document.getElementById('b' + i));
            const t = document.getElementById('sttxt');
            bs.forEach(b => b.className = 'pwb');
            if (!v) {
                t.textContent = 'Masukkan password untuk melihat kekuatannya';
                t.style.color = '';
                return;
            }
            let sc = 0;
            if (v.length >= 8) sc++;
            if (/[A-Z]/.test(v)) sc++;
            if (/[0-9]/.test(v)) sc++;
            if (/[^A-Za-z0-9]/.test(v)) sc++;
            const cls = ['weak', 'weak', 'medium', 'strong'],
                labs = ['Sangat lemah', 'Lemah', 'Sedang', 'Kuat'],
                cols = ['#E24B4A', '#E24B4A', '#E8B740', '#27a06b'];
            for (let i = 0; i < sc; i++) bs[i].className = 'pwb ' + cls[sc - 1];
            t.textContent = 'Kekuatan: ' + labs[sc - 1];
            t.style.color = cols[sc - 1];
        }

        function togPw(btn) {
            const inp = btn.closest('.iw').querySelector('input'),
                ic = btn.querySelector('svg');
            if (inp.type === 'password') {
                inp.type = 'text';
                ic.innerHTML =
                    '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                inp.type = 'password';
                ic.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // ── Auto-fill OTP dari link email ──
        const params = new URLSearchParams(window.location.search);
        const otpParam = params.get('otp');
        if (otpParam && otpParam.length === 6) {
            go(2);
            setTimeout(() => {
                const ins = document.querySelectorAll('.oi');
                [...otpParam].forEach((ch, i) => {
                    if (ins[i]) {
                        ins[i].value = ch;
                        ins[i].classList.add('filled');
                    }
                });
                document.getElementById('vBtn').disabled = false;
            }, 300);
        }
    </script>
</body>

</html>
