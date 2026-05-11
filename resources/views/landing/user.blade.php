<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPark</title>
    <link href="https://fonts.bunny.net/css?family=syne:800|dm-sans:400,600,700" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        html,body{height:100%;overflow:hidden;}
        body{
            font-family:'DM Sans',sans-serif;
            background:#F5F7FC;
            height:100vh;
            display:flex;
            flex-direction:column;
        }

        .header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:18px 48px;
            background:#fff;
            border-bottom:1.5px solid #EBEEF5;
            flex-shrink:0;
        }
        .logo{
            font-family:'Syne',sans-serif;
            font-size:2rem;font-weight:800;
            color:#1A4BAD;letter-spacing:-.5px;
        }
        .logo span{color:#181D35;}
        .clock{font-size:1.05rem;color:#8A93AE;font-weight:600;}
        .status-dot{display:flex;align-items:center;gap:8px;font-size:1rem;color:#027A48;font-weight:600;}
        .dot{width:10px;height:10px;border-radius:50%;background:#12B76A;animation:dotPulse 1.5s infinite;}

        .main{
            flex:1;
            display:grid;
            grid-template-columns:1fr 1fr;
            overflow:hidden;
        }

        .left{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:40px 48px;
            border-right:1.5px solid #EBEEF5;
            background:#fff;
        }

        .cam-wrap{
            position:relative;
            width:280px;height:280px;
            border:3px solid #3B6FD4;
            border-radius:20px;
            background:#EEF3FC;
            display:flex;align-items:center;justify-content:center;
            overflow:hidden;
            margin-bottom:28px;
        }
        .corner{position:absolute;width:24px;height:24px;border-color:#1A4BAD;border-style:solid;border-width:0;}
        .corner.tl{top:8px;left:8px;border-top-width:4px;border-left-width:4px;border-radius:3px 0 0 0;}
        .corner.tr{top:8px;right:8px;border-top-width:4px;border-right-width:4px;border-radius:0 3px 0 0;}
        .corner.bl{bottom:8px;left:8px;border-bottom-width:4px;border-left-width:4px;border-radius:0 0 0 3px;}
        .corner.br{bottom:8px;right:8px;border-bottom-width:4px;border-right-width:4px;border-radius:0 0 3px 0;}
        .face-icon{
            width:110px;height:110px;border-radius:50%;
            background:#E8F0FB;
            display:flex;align-items:center;justify-content:center;
            animation:facePulse 1.8s ease-in-out infinite;
        }
        .scan-line{
            position:absolute;left:0;right:0;height:3px;
            background:linear-gradient(90deg,transparent,#1A4BAD,transparent);
            animation:scanMove 2s ease-in-out infinite;opacity:.8;
        }
        .cam-title{
            font-family:'Syne',sans-serif;
            font-size:1.5rem;font-weight:800;color:#8A93AE;text-align:center;
        }

        .right{
            display:flex;flex-direction:column;justify-content:center;
            padding:40px 48px;background:#F5F7FC;
        }
        .right-title{
            font-family:'Syne',sans-serif;
            font-size:2.4rem;font-weight:800;color:#181D35;
            line-height:1.2;margin-bottom:12px;
        }
        .right-sub{font-size:1.15rem;color:#8A93AE;line-height:1.6;margin-bottom:32px;}

        .steps{display:flex;flex-direction:column;gap:14px;margin-bottom:36px;}
        .step-item{
            display:flex;align-items:center;gap:18px;
            background:#fff;border:1.5px solid #EBEEF5;border-radius:14px;
            padding:16px 20px;font-size:1.1rem;color:#5A6378;
        }
        .step-num{
            width:40px;height:40px;border-radius:50%;
            background:#E8F0FB;color:#1A4BAD;
            font-size:1.1rem;font-weight:700;
            display:flex;align-items:center;justify-content:center;flex-shrink:0;
        }

        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:12px;
            width:100%;padding:1.2rem 2rem;border-radius:14px;
            background:#1A4BAD;color:#fff;border:none;cursor:pointer;
            font-size:1.3rem;font-weight:700;font-family:'DM Sans',sans-serif;
            text-decoration:none;transition:background .2s;
        }
        .btn:hover{background:#153d94;}

        .notice{
            display:flex;align-items:center;gap:12px;
            background:#FFFAEB;border:1.5px solid #FEF0C7;border-radius:12px;
            padding:14px 18px;font-size:1rem;color:#92400E;margin-top:16px;
        }

        @keyframes facePulse{0%,100%{opacity:.6;transform:scale(1)}50%{opacity:1;transform:scale(1.06)}}
        @keyframes scanMove{0%,100%{top:8px}50%{top:calc(100% - 12px)}}
        @keyframes dotPulse{0%,100%{opacity:1}50%{opacity:.3}}
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Easy<span>Park</span></div>
        <div class="status-dot"><div class="dot"></div> Kiosk Aktif</div>
        <div class="clock" id="clock"></div>
    </div>

    <div class="main">
        <div class="left">
            <div class="cam-wrap">
                <div class="corner tl"></div>
                <div class="corner tr"></div>
                <div class="corner bl"></div>
                <div class="corner br"></div>
                <div class="face-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="1.5" width="56" height="56">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
                <div class="scan-line"></div>
            </div>
            <div class="cam-title">Arahkan wajah ke sini</div>
        </div>

        <div class="right">
            <div class="right-title">Hadapkan wajah<br>ke kamera</div>
            <div class="right-sub">Pastikan wajah Anda terlihat jelas sebelum memasuki area parkir</div>

            <div class="steps">
                <div class="step-item"><div class="step-num">1</div><span>Berdiri di depan kiosk parkir</span></div>
                <div class="step-item"><div class="step-num">2</div><span>Hadapkan wajah ke kamera selama 3 detik</span></div>
                <div class="step-item"><div class="step-num">3</div><span>Masukkan plat nomor kendaraan</span></div>
            </div>

            <a href="{{ url('/user/cek-slot') }}" class="btn">
                Lihat Rekomendasi Parkir
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" width="22" height="22">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>

            <div class="notice">
                <svg viewBox="0 0 24 24" fill="none" stroke="#92400E" stroke-width="2" width="24" height="24" style="flex-shrink:0;">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Verifikasi wajah wajib dilakukan di kiosk sebelum parkir
            </div>
        </div>
    </div>

    <script>
        // ── Clock ──────────────────────────────────────────────
        function tick(){
            const now = new Date();
            document.getElementById('clock').textContent =
                now.toLocaleDateString('id-ID',{weekday:'long',day:'2-digit',month:'long',year:'numeric'})
                + ' · ' + now.toLocaleTimeString('id-ID');
        }
        tick(); setInterval(tick, 1000);

        // ── Polling kiosk status ───────────────────────────────
        // Setiap 2 detik cek apakah kiosk baru saja konfirmasi.
        // Kalau iya, pindah ke halaman rekomendasi (cek-slot).
        let pollActive = true;

        function pollKioskStatus(){
            if(!pollActive) return;

            fetch('{{ url("/user/kiosk-status") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                if(data.triggered){
                    pollActive = false; // stop polling
                    window.location.href = '{{ url("/user/cek-slot") }}?from=kiosk';
                }
            })
            .catch(() => {/* abaikan error jaringan, lanjut polling */});
        }

        // Mulai polling tiap 2 detik
        setInterval(pollKioskStatus, 2000);
    </script>
</body>
</html>