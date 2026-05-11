<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPark — Rekomendasi Parkir</title>
    <link href="https://fonts.bunny.net/css?family=syne:800|dm-sans:400,600,700" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        html,body{height:100%;overflow:hidden;}
        body{font-family:'DM Sans',sans-serif;background:#F5F7FC;height:100vh;display:flex;flex-direction:column;}

        .header{display:flex;align-items:center;justify-content:space-between;padding:18px 48px;background:#fff;border-bottom:1.5px solid #EBEEF5;flex-shrink:0;}
        .logo{font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;color:#1A4BAD;letter-spacing:-.5px;}
        .logo span{color:#181D35;}
        .clock{font-size:1.05rem;color:#8A93AE;font-weight:600;}
        .back-btn{display:inline-flex;align-items:center;gap:8px;font-size:1rem;color:#8A93AE;text-decoration:none;font-weight:600;transition:color .2s;}
        .back-btn:hover{color:#1A4BAD;}

        .subheader{padding:14px 48px;background:#F5F7FC;border-bottom:1.5px solid #EBEEF5;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
        .subheader-title{font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:#181D35;}
        .subheader-sub{font-size:.95rem;color:#8A93AE;}

        /* ── Countdown bar — hanya muncul kalau ?from=kiosk ── */
        .cd-bar{
            display:none;
            flex-shrink:0;
            background:#1A4BAD;
            padding:10px 48px;
            align-items:center;
            gap:20px;
        }
        .cd-bar.visible{display:flex;}
        .cd-circle{
            width:38px;height:38px;flex-shrink:0;
            border-radius:50%;
            background:rgba(255,255,255,.18);
            font-family:'Syne',sans-serif;
            font-size:1.2rem;font-weight:800;color:#fff;
            display:flex;align-items:center;justify-content:center;
        }
        .cd-label{font-size:.95rem;color:rgba(255,255,255,.85);font-weight:600;flex-shrink:0;}
        .cd-track{flex:1;height:5px;border-radius:100px;background:rgba(255,255,255,.2);overflow:hidden;}
        .cd-fill{height:100%;border-radius:100px;background:#fff;transition:width 1s linear;}
        .cd-skip{
            font-size:.85rem;font-weight:600;color:rgba(255,255,255,.65);
            background:none;border:none;cursor:pointer;
            font-family:'DM Sans',sans-serif;white-space:nowrap;
            transition:color .2s;
        }
        .cd-skip:hover{color:#fff;}

        .main{flex:1;display:grid;grid-template-columns:1fr 1fr;gap:28px;padding:28px 48px;overflow:hidden;}
        .area-card{background:#fff;border:2px solid #EBEEF5;border-radius:24px;display:flex;flex-direction:column;justify-content:space-between;padding:36px 40px;box-shadow:0 4px 24px rgba(26,75,173,.07);}
        .area-type{font-size:14px;font-weight:700;padding:6px 16px;border-radius:100px;display:inline-block;margin-bottom:16px;}
        .type-mobil{background:#E8F0FB;color:#1A4BAD;border:1.5px solid #C0D3F5;}
        .type-motor{background:#ECFDF3;color:#027A48;border:1.5px solid #6CE9A6;}
        .area-name{font-family:'Syne',sans-serif;font-size:2.6rem;font-weight:800;color:#181D35;line-height:1.1;margin-bottom:8px;}
        .area-code{font-size:1rem;color:#8A93AE;margin-bottom:32px;}
        .slot-info{display:flex;align-items:flex-end;gap:16px;margin-bottom:28px;}
        .slot-num{font-family:'Syne',sans-serif;font-size:7rem;font-weight:800;line-height:1;}
        .num-ok{color:#027A48;} .num-warn{color:#92400E;} .num-full{color:#DC2626;}
        .slot-meta{padding-bottom:10px;}
        .slot-total{font-size:1.4rem;color:#B0B8CC;font-weight:600;display:block;margin-bottom:4px;}
        .slot-lbl{font-size:1rem;color:#8A93AE;}
        .progress-wrap{background:#EBEEF5;border-radius:100px;height:14px;margin-bottom:24px;overflow:hidden;}
        .progress-bar{height:100%;border-radius:100px;}
        .bar-ok{background:#12B76A;} .bar-warn{background:#F79009;} .bar-full{background:#DC2626;}
        .card-footer{display:flex;align-items:center;justify-content:space-between;}
        .desc{font-size:1rem;color:#8A93AE;}
        .badge{display:inline-flex;align-items:center;gap:6px;font-size:1rem;font-weight:700;padding:8px 20px;border-radius:100px;}
        .badge-ok{background:#ECFDF3;border:1.5px solid #6CE9A6;color:#027A48;}
        .badge-warn{background:#FFFAEB;border:1.5px solid #FDE68A;color:#92400E;}
        .badge-full{background:#FEF2F2;border:1.5px solid #FECACA;color:#DC2626;}
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Easy<span>Park</span></div>
        <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:#181D35;">Rekomendasi Area Parkir</div>
        <div style="display:flex;align-items:center;gap:24px;">
            <div class="clock" id="clock"></div>
            <a href="{{ url('/user') }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="subheader">
        <span class="subheader-title">Top 2 area parkir paling sepi hari ini</span>
        <span class="subheader-sub">Data diperbarui setiap kali halaman dimuat</span>
    </div>

    {{-- Countdown bar — hanya aktif kalau ?from=kiosk --}}
    <div class="cd-bar" id="cdBar">
        <div class="cd-circle" id="cdNum">5</div>
        <span class="cd-label">Kembali ke halaman utama otomatis...</span>
        <div class="cd-track"><div class="cd-fill" id="cdFill" style="width:100%;"></div></div>
        <button class="cd-skip" onclick="goUser()">Kembali sekarang →</button>
    </div>

    <div class="main">
        @foreach($recommendations as $area)
        @php
            $pct        = $area->capacity > 0 ? ($area->available_count / $area->capacity) * 100 : 0;
            $numClass   = $pct > 50 ? 'num-ok'   : ($pct > 0 ? 'num-warn'   : 'num-full');
            $barClass   = $pct > 50 ? 'bar-ok'   : ($pct > 0 ? 'bar-warn'   : 'bar-full');
            $badgeClass = $pct > 50 ? 'badge-ok' : ($pct > 0 ? 'badge-warn' : 'badge-full');
            $badgeText  = $pct > 50 ? 'Sepi'     : ($pct > 0 ? 'Agak Ramai' : 'Penuh');
            $isMotor    = $area->parkingSlots->first()?->vehicle_type_id === 1;
            $typeLabel  = $isMotor ? 'Motor' : 'Mobil';
            $typeClass  = $isMotor ? 'type-motor' : 'type-mobil';
        @endphp
        <div class="area-card">
            <div>
                <div class="area-type {{ $typeClass }}">{{ $typeLabel }}</div>
                <div class="area-name">{{ $area->name }}</div>
                <div class="area-code">{{ $area->code }} · Kapasitas {{ $area->capacity }} slot</div>
                <div class="slot-info">
                    <div class="slot-num {{ $numClass }}">{{ $area->available_count }}</div>
                    <div class="slot-meta">
                        <span class="slot-total">/ {{ $area->capacity }}</span>
                        <span class="slot-lbl">slot tersedia</span>
                    </div>
                </div>
                <div class="progress-wrap">
                    <div class="progress-bar {{ $barClass }}" style="width:{{ round($pct) }}%"></div>
                </div>
            </div>
            <div class="card-footer">
                <span class="desc">{{ $area->description }}</span>
                <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
            </div>
        </div>
        @endforeach
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

        // ── Countdown — aktif hanya kalau ?from=kiosk ──────────
        const fromKiosk = new URLSearchParams(window.location.search).get('from') === 'kiosk';

        function goUser(){ window.location.href = '{{ url("/user") }}'; }

        if(fromKiosk){
            const bar    = document.getElementById('cdBar');
            const numEl  = document.getElementById('cdNum');
            const fillEl = document.getElementById('cdFill');
            const TOTAL  = 5;
            let sisa     = TOTAL;

            bar.classList.add('visible');

            // Susutkan fill mulai detik pertama
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    fillEl.style.width = ((TOTAL - 1) / TOTAL * 100) + '%';
                });
            });

            const timer = setInterval(() => {
                sisa--;
                numEl.textContent  = sisa;
                fillEl.style.width = (sisa / TOTAL * 100) + '%';
                if(sisa <= 0){ clearInterval(timer); goUser(); }
            }, 1000);
        }
    </script>
</body>
</html>