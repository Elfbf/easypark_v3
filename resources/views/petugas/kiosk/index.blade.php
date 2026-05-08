@extends('layouts.app')

@section('title', 'Kiosk Parkir')
@section('page_title', 'Kiosk Parkir')

@section('content')
<style>
*{box-sizing:border-box;}
.kscreen{display:none}
.kscreen.active{display:block}

/* ── Alert / Notice ───────────────────────────────────────── */
.notice-box{
    padding:11px 14px;border-radius:9px;background:#FFFAEB;border:1px solid #FEF0C7;
    display:flex;align-items:flex-start;gap:9px;font-size:12px;color:#92400E;line-height:1.5
}

/* ── Step Bar ─────────────────────────────────────────────── */
.step-bar{display:flex;align-items:center;gap:10px;margin-bottom:18px}
.steps{display:flex;align-items:center}
.step{width:9px;height:9px;border-radius:50%;background:#EBEEF5;border:1.5px solid #D4D9E8;transition:background .3s,border-color .3s}
.step.done{background:#1A4BAD;border-color:#1A4BAD}
.step-line{width:26px;height:2px;background:#EBEEF5;transition:background .3s}
.step-line.done{background:#1A4BAD}

/* ── Buttons ──────────────────────────────────────────────── */
.btn-row{display:flex;gap:9px;justify-content:center;margin-top:14px;flex-wrap:wrap}
.btn-prim{
    display:inline-flex;align-items:center;gap:6px;padding:.58rem 1.3rem;
    border-radius:10px;background:#1A4BAD;color:#fff;border:none;cursor:pointer;
    font-size:13px;font-weight:600;font-family:'DM Sans',sans-serif;transition:background .2s
}
.btn-prim:hover{background:#153d94}
.btn-prim:disabled{background:#9BAFD4;cursor:not-allowed}
.btn-out{
    display:inline-flex;align-items:center;gap:6px;padding:.58rem 1.1rem;
    border-radius:10px;background:#fff;color:#8A93AE;border:1.5px solid #EBEEF5;
    cursor:pointer;font-size:13px;font-family:'DM Sans',sans-serif;transition:border-color .2s,background .2s
}
.btn-out:hover{border-color:#D4D9E8;background:#F5F7FC}
.btn-danger{
    display:inline-flex;align-items:center;gap:6px;padding:.6rem 1.2rem;
    border-radius:10px;background:#DC2626;color:#fff;border:none;
    cursor:pointer;font-size:13px;font-weight:600;font-family:'DM Sans',sans-serif;transition:background .2s
}
.btn-danger:hover{background:#B91C1C}
.btn-allow{
    display:inline-flex;align-items:center;gap:6px;padding:.6rem 1.2rem;
    border-radius:10px;background:#027A48;color:#fff;border:none;
    cursor:pointer;font-size:13px;font-weight:600;font-family:'DM Sans',sans-serif;transition:background .2s
}
.btn-allow:hover{background:#065F46}

/* ── Screen Typography ────────────────────────────────────── */
.screen-title{font-family:'Syne',sans-serif;font-size:1.25rem;font-weight:800;color:#181D35;margin-bottom:5px}
.screen-sub{font-size:13px;color:#8A93AE;margin-bottom:18px;line-height:1.5}

/* ── Camera / Scan Box ────────────────────────────────────── */
.cam-box{
    border-radius:12px;border:2px solid #3B6FD4;background:#fff;
    position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center
}
.corner{position:absolute;width:16px;height:16px;border-color:#1A4BAD;border-style:solid;border-width:0}
.corner.tl{top:6px;left:6px;border-top-width:2.5px;border-left-width:2.5px;border-radius:2px 0 0 0}
.corner.tr{top:6px;right:6px;border-top-width:2.5px;border-right-width:2.5px;border-radius:0 2px 0 0}
.corner.bl{bottom:6px;left:6px;border-bottom-width:2.5px;border-left-width:2.5px;border-radius:0 0 0 2px}
.corner.br{bottom:6px;right:6px;border-bottom-width:2.5px;border-right-width:2.5px;border-radius:0 0 2px 0}
.scan-line{
    position:absolute;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,#1A4BAD,transparent);
    animation:scanMove 2s ease-in-out infinite;opacity:.8
}

/* ── Plate Display ────────────────────────────────────────── */
.plate-display{
    font-family:monospace;font-size:20px;font-weight:700;letter-spacing:.14em;
    text-align:center;text-transform:uppercase;color:#181D35;
    background:#F5F7FC;border-radius:6px;padding:6px 18px;border:1.5px dashed #D4D9E8;
    display:inline-block;min-width:160px;
}
.plate-display.valid  {color:#1A4BAD;border-color:#3B6FD4;background:#EEF3FC}
.plate-display.invalid{color:#DC2626;border-color:#FECACA;background:#FEF2F2}

/* ── Plate Input ──────────────────────────────────────────── */
.plate-input{
    font-family:monospace;font-size:22px;font-weight:700;letter-spacing:.12em;
    text-align:center;text-transform:uppercase;padding:.65rem 1.1rem;
    border:1.5px solid #D4D9E8;border-radius:10px;background:#fff;color:#181D35;
    width:100%;max-width:260px;outline:none;transition:border-color .2s;
    display:block;margin:0 auto
}
.plate-input:focus{border-color:#3B6FD4}
.plate-input.valid  {border-color:#6CE9A6}
.plate-input.invalid{border-color:#FECACA}

/* ── Plate hint ───────────────────────────────────────────── */
.plate-hint{display:flex;align-items:center;justify-content:center;gap:6px;font-size:11px;color:#8A93AE;margin:.4rem 0 1.2rem}
.plate-part{padding:2px 7px;border-radius:4px;font-family:monospace;font-weight:700;font-size:11px}
.plate-part.a{background:#E8F0FB;color:#1A4BAD}
.plate-part.n{background:#ECFDF3;color:#027A48}
.plate-part.s{background:#FFF7ED;color:#C2410C}

/* ── Retry bar ────────────────────────────────────────────── */
.retry-bar{
    display:flex;align-items:center;justify-content:center;gap:6px;
    padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;margin-bottom:10px;
    border:1.5px solid
}
.retry-bar.r1{background:#EFF6FF;border-color:#BFDBFE;color:#1E40AF}
.retry-bar.r2{background:#FFFAEB;border-color:#FDE68A;color:#92400E}
.retry-bar.r3{background:#FEF2F2;border-color:#FECACA;color:#DC2626}

/* ── Info Card ────────────────────────────────────────────── */
.info-card{border:1.5px solid #EBEEF5;border-radius:11px;overflow:hidden;margin-bottom:14px}
.info-card-head{
    padding:13px 18px;background:#E8F0FB;border-bottom:1px solid #C0D3F5;
    display:flex;align-items:center;gap:10px
}
.head-avatar{
    width:32px;height:32px;border-radius:50%;background:#C0D3F5;
    display:flex;align-items:center;justify-content:center;flex-shrink:0
}
.info-row{display:flex;align-items:center;padding:11px 18px;border-bottom:1px solid #EBEEF5}
.info-row:last-child{border-bottom:none}
.info-row.alt{background:#FAFBFD}
.info-lbl{font-size:12.5px;color:#8A93AE;width:130px;flex-shrink:0}
.info-val{font-size:14px;color:#181D35;font-weight:500}
.info-val.mono{font-family:monospace;letter-spacing:.07em}
.info-val.small{font-size:12px;font-weight:400}

/* ── Officer Confirm Box ──────────────────────────────────── */
.officer-box{
    background:#fff;border:2px solid #1A4BAD;border-radius:14px;
    padding:20px 22px;margin-bottom:16px;
    box-shadow:0 4px 20px rgba(26,75,173,.12)
}
.officer-title{
    font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;
    color:#181D35;margin-bottom:6px;display:flex;align-items:center;gap:8px
}
.officer-badge{
    font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:100px;
    background:#1A4BAD;color:#fff;
}
.officer-reason{
    font-size:12.5px;color:#5A6378;line-height:1.6;
    padding:10px 14px;background:#F5F7FC;border-radius:8px;margin:10px 0;
    border-left:3px solid #3B6FD4
}

/* ── Badges ───────────────────────────────────────────────── */
.badge-green {display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:100px;background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48}
.badge-blue  {display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:100px;background:#E8F0FB;border:1px solid #C0D3F5;color:#1A4BAD}
.badge-yellow{display:inline-flex;align-items:center;gap:4px;font-size:11.5px;font-weight:600;padding:3px 9px;border-radius:100px;background:#FFFAEB;border:1px solid #FDE68A;color:#92400E}

/* ── Face banner ──────────────────────────────────────────── */
.face-banner{
    padding:14px 16px;border-radius:10px;margin-bottom:14px;
    display:flex;align-items:flex-start;gap:12px;border:1.5px solid;animation:slideIn .3s ease
}
.face-banner.match   {background:#ECFDF3;border-color:#6CE9A6}
.face-banner.no-match{background:#FEF2F2;border-color:#FECACA}
.face-banner .ficon{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.face-banner.match    .ficon{background:#D1FAE5}
.face-banner.no-match .ficon{background:#FEE2E2}
.face-banner .ftitle{font-weight:700;font-size:13px;margin-bottom:2px}
.face-banner.match    .ftitle{color:#027A48}
.face-banner.no-match .ftitle{color:#DC2626}
.face-banner .fdesc{font-size:11.5px;line-height:1.5}
.face-banner.match    .fdesc{color:#065F46}
.face-banner.no-match .fdesc{color:#991B1B}

/* ── Aksi ─────────────────────────────────────────────────── */
.aksi-masuk {display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;padding:4px 12px;border-radius:100px;background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48}
.aksi-keluar{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:700;padding:4px 12px;border-radius:100px;background:#FFF7ED;border:1px solid #FED7AA;color:#C2410C}

/* ── Animations ───────────────────────────────────────────── */
@keyframes scanMove {0%,100%{top:8px}50%{top:calc(100% - 10px)}}
@keyframes facePulse{0%,100%{opacity:.5;transform:scale(1)}50%{opacity:1;transform:scale(1.04)}}
@keyframes spin     {to{transform:rotate(360deg)}}
@keyframes dotPulse {0%,100%{opacity:1}50%{opacity:.3}}
@keyframes slideIn  {from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulseRing{0%,100%{box-shadow:0 0 0 0 rgba(26,75,173,.3)}50%{box-shadow:0 0 0 8px rgba(26,75,173,0)}}
</style>

{{-- Breadcrumb --}}
<nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
    <a href="{{ route('dashboard') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
    <span style="color:#D4D9E8;">/</span>
    <a href="{{ route('petugas.dashboard') }}" style="color:#8A93AE;text-decoration:none;">Petugas</a>
    <span style="color:#D4D9E8;">/</span>
    <span style="color:#181D35;font-weight:600;">Kiosk Parkir</span>
</nav>

<div class="card" style="padding:0;overflow:hidden;border-radius:14px;border:1.5px solid #EBEEF5;box-shadow:0 1px 4px rgba(0,0,0,.06);">

    {{-- Header --}}
    <div style="padding:12px 24px;border-bottom:1px solid #EBEEF5;display:flex;align-items:center;justify-content:space-between;background:#fff;">
        <div style="display:flex;align-items:center;gap:8px;">
            <span style="width:7px;height:7px;border-radius:50%;background:#12B76A;display:inline-block;animation:dotPulse 1.5s infinite;"></span>
            <span style="font-size:12px;color:#027A48;font-weight:600;">Kiosk Aktif</span>
        </div>
        <span style="font-size:11.5px;color:#8A93AE;" id="liveClock"></span>
    </div>

    {{-- Body --}}
    <div style="padding:40px 24px;background:#F5F7FC;min-height:640px;display:flex;align-items:center;justify-content:center;">
    <div style="width:100%;max-width:520px;">

    {{-- ══════════════════════════
         S1 · Scan Plat
    ══════════════════════════ --}}
    <div class="kscreen active" id="s1">
        <div style="text-align:center;margin-bottom:6px;">
            <div class="screen-title">Scan Plat Nomor</div>
            <div class="screen-sub">Arahkan kamera ke plat atau ketik manual di bawah</div>
        </div>

        {{-- Retry bar plat (muncul setelah gagal 1x) --}}
        <div id="plateRetryBar" style="display:none;" class="retry-bar r1"></div>

        <div class="cam-box" style="width:300px;height:130px;margin:0 auto 16px;">
            <div class="corner tl"></div><div class="corner tr"></div>
            <div class="corner bl"></div><div class="corner br"></div>
            <div id="ocrPreview" class="plate-display">– – – –</div>
            <div class="scan-line"></div>
        </div>

        <div class="plate-hint">
            <span class="plate-part a">AB</span>
            <span style="color:#D4D9E8;font-weight:700;">·</span>
            <span class="plate-part n">1234</span>
            <span style="color:#D4D9E8;font-weight:700;">·</span>
            <span class="plate-part s">CD</span>
            <span style="color:#B0B8CC;margin-left:4px;">Format plat Indonesia</span>
        </div>

        <input type="text" id="plateInput" class="plate-input" placeholder="B 1234 XYZ"
               maxlength="12" oninput="onPlateInput(this)">
        <div id="plateValidMsg" style="text-align:center;font-size:11.5px;color:#8A93AE;margin:.4rem 0 1.2rem;">
            1–2 huruf · 1–4 angka · 1–3 huruf
        </div>

        <div class="btn-row">
            <button class="btn-prim" id="btnVerif" onclick="submitPlate()" disabled>Verifikasi →</button>
        </div>

        <div class="notice-box" style="margin-top:18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#92400E" stroke-width="2" style="width:15px;height:15px;flex-shrink:0;margin-top:1px;">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>Hubungi petugas jika terjadi kendala pada sistem</span>
        </div>
    </div>

    {{-- ══════════════════════════
         S-Loading
    ══════════════════════════ --}}
    <div class="kscreen" id="sLoading" style="text-align:center;padding:4rem 0;">
        <div style="width:46px;height:46px;border:3px solid #E8F0FB;border-top-color:#1A4BAD;border-radius:50%;animation:spin .9s linear infinite;margin:0 auto 18px;"></div>
        <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;margin-bottom:5px;" id="loadingTitle">Memverifikasi...</div>
        <div style="font-size:12.5px;color:#8A93AE;" id="loadingSub">Mohon tunggu sebentar</div>
    </div>

    {{-- ══════════════════════════
         S-Wajah · Scan wajah
    ══════════════════════════ --}}
    <div class="kscreen" id="sWajah">
        <div class="step-bar">
            <button class="btn-out" style="padding:5px 10px;font-size:12px;" onclick="resetKiosk()">← Ulangi</button>
            <div class="steps">
                <div class="step done"></div><div class="step-line done"></div>
                <div class="step done"></div><div class="step-line"></div>
                <div class="step"></div>
            </div>
        </div>
        <div style="text-align:center;">
            <div class="screen-title">Verifikasi Wajah</div>
            <div class="screen-sub" id="wajahSub">Hadapkan wajah ke kamera</div>

            {{-- Retry bar wajah --}}
            <div id="faceRetryBar" style="display:none;margin-bottom:10px;" class="retry-bar r1"></div>

            <div class="cam-box" style="width:220px;height:220px;margin:0 auto 16px;">
                <div class="corner tl"></div><div class="corner tr"></div>
                <div class="corner bl"></div><div class="corner br"></div>
                <div style="width:72px;height:72px;border-radius:50%;background:#E8F0FB;display:flex;align-items:center;justify-content:center;animation:facePulse 1.8s ease-in-out infinite;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="1.5" style="width:34px;height:34px;">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                </div>
                <div class="scan-line"></div>
            </div>

            <div style="background:#fff;border:1.5px solid #EBEEF5;border-radius:9px;padding:10px 16px;margin-bottom:14px;font-size:12.5px;display:flex;gap:14px;justify-content:center;">
                <span style="color:#8A93AE;">Plat: <strong id="wajahPlat" style="color:#181D35;font-family:monospace;"></strong></span>
                <span style="color:#D4D9E8;">|</span>
                <span style="color:#8A93AE;">Nama: <strong id="wajahNama" style="color:#181D35;"></strong></span>
            </div>

            <div class="btn-row">
                <button class="btn-out" onclick="resetKiosk()">Batal</button>
                <button class="btn-prim" id="btnFace" onclick="doFaceScan()">Ambil Foto</button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════
         S-Konfirm · Sukses verifikasi (terdaftar + cocok / no-face)
    ══════════════════════════ --}}
    <div class="kscreen" id="sKonfirm">
        <div class="step-bar">
            <button class="btn-out" style="padding:5px 10px;font-size:12px;" onclick="resetKiosk()">← Ulangi</button>
            <div class="steps">
                <div class="step done"></div><div class="step-line done"></div>
                <div class="step done"></div><div class="step-line done"></div>
                <div class="step done"></div>
            </div>
        </div>

        <div id="faceBannerKonfirm"></div>

        <div class="info-card">
            <div class="info-card-head">
                <div class="head-avatar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2" style="width:16px;height:16px;">
                        <path d="M22 10L12 4 2 10l10 6 10-6z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div>
                    <div style="font-size:12.5px;font-weight:700;color:#1A4BAD;">Mahasiswa Terdaftar</div>
                    <div id="konfirmNama" style="font-size:11px;color:#3B6FD4;">-</div>
                </div>
            </div>
            <div class="info-row">    <div class="info-lbl">Plat Nomor</div>     <div id="konfirmPlat"  class="info-val mono"></div></div>
            <div class="info-row alt"><div class="info-lbl">NIM / NIP</div>      <div id="konfirmNim"   class="info-val"></div></div>
            <div class="info-row">    <div class="info-lbl">Warna</div>          <div id="konfirmWarna" class="info-val"></div></div>
            <div class="info-row alt"><div class="info-lbl">Aksi</div>           <div id="konfirmAksi"></div></div>
            <div class="info-row">    <div class="info-lbl">Verifikasi Wajah</div><div id="konfirmFace"></div></div>
            <div class="info-row alt"><div class="info-lbl">Waktu</div>          <div id="konfirmTime"  class="info-val mono small"></div></div>
        </div>

        <div class="btn-row">
            <button class="btn-danger" onclick="resetKiosk()">✕ Tolak</button>
            <button class="btn-prim" id="btnKonfirm" onclick="confirmAction()">✓ Izinkan</button>
        </div>
    </div>

    {{-- ══════════════════════════
         S-Officer · Semua kasus gagal → konfirmasi petugas
         (plat 3x tak ditemukan, plat tidak terdaftar, muka tidak cocok)
    ══════════════════════════ --}}
    <div class="kscreen" id="sOfficer">
        <div class="step-bar">
            <button class="btn-out" style="padding:5px 10px;font-size:12px;" onclick="resetKiosk()">← Ulangi Scan</button>
        </div>

        {{-- Officer confirmation box --}}
        <div class="officer-box">
            <div class="officer-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2" style="width:18px;height:18px;">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Konfirmasi Petugas
                <span class="officer-badge">Diperlukan</span>
            </div>
            <div id="officerReason" class="officer-reason"></div>

            {{-- Info ringkas --}}
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:10px;">
                <div style="flex:1;min-width:130px;background:#F5F7FC;border-radius:8px;padding:9px 12px;">
                    <div style="font-size:11px;color:#8A93AE;margin-bottom:2px;">Plat Nomor</div>
                    <div id="officerPlat" style="font-family:monospace;font-size:15px;font-weight:700;color:#181D35;letter-spacing:.1em;"></div>
                </div>
                <div style="flex:1;min-width:130px;background:#F5F7FC;border-radius:8px;padding:9px 12px;">
                    <div style="font-size:11px;color:#8A93AE;margin-bottom:2px;">Aksi</div>
                    <div id="officerAksi"></div>
                </div>
                <div style="flex:1;min-width:130px;background:#F5F7FC;border-radius:8px;padding:9px 12px;">
                    <div style="font-size:11px;color:#8A93AE;margin-bottom:2px;">Status</div>
                    <div id="officerStatus"></div>
                </div>
            </div>
        </div>

        <div style="text-align:center;font-size:12px;color:#8A93AE;margin-bottom:14px;">
            Petugas memiliki wewenang penuh untuk mengizinkan atau menolak akses
        </div>

        <div class="btn-row">
            <button class="btn-danger" onclick="resetKiosk()">✕ Tolak Akses</button>
            <button class="btn-allow" id="btnOfficerAllow" onclick="confirmAction()">✓ Izinkan Akses</button>
        </div>
    </div>

    {{-- ══════════════════════════
         S-Success
    ══════════════════════════ --}}
    <div class="kscreen" id="sSuccess" style="text-align:center;">
        <div id="successIconWrap" style="width:58px;height:58px;border-radius:50%;background:#ECFDF3;border:1.5px solid #6CE9A6;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#027A48" stroke-width="2.5" style="width:26px;height:26px;">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:800;color:#181D35;margin-bottom:5px;" id="successTitle">Berhasil!</div>
        <div style="font-size:13px;color:#8A93AE;margin-bottom:20px;" id="successSub"></div>
        <div style="padding:14px 22px;background:#fff;border:1.5px solid #EBEEF5;border-radius:11px;display:inline-block;margin-bottom:20px;">
            <div style="font-size:11px;color:#8A93AE;margin-bottom:4px;">Nomor Record</div>
            <div id="ticketNum" style="font-family:monospace;font-size:22px;font-weight:700;color:#181D35;letter-spacing:.1em;"></div>
            <div id="ticketTime" style="font-size:11px;color:#8A93AE;margin-top:4px;"></div>
        </div>
        <div><button onclick="resetKiosk()" class="btn-prim" style="margin:0 auto;">Selesai — Kembali ke Awal</button></div>
        <div style="margin-top:14px;font-size:11.5px;color:#D4D9E8;" id="autoResetLabel"></div>
    </div>

    </div>{{-- /.max-w --}}
    </div>{{-- /.body --}}
</div>{{-- /.card --}}

<script>
// ── State ──────────────────────────────────────────────────────
let foundData    = null;
let faceVerified = null;   // null | true | false
let faceRetry    = 0;
let plateRetry   = 0;
const MAX_RETRY  = 3;
let scanInterval = null;
let autoReset    = null;

// Reason yang akan dikirim ke server saat officer confirm
// agar bisa di-log (opsional)
let officerReason = '';

// ── Format / validasi plat ─────────────────────────────────────
// 1–2 huruf, 1–4 angka, 1–3 huruf; spasi opsional
const PLATE_RE = /^([A-Z]{1,2})\s*(\d{1,4})\s*([A-Z]{1,3})$/;

function validatePlate(raw){
    return PLATE_RE.test(raw.replace(/\s+/g,'').toUpperCase());
}
function formatPlate(raw){
    const m = raw.replace(/\s+/g,'').toUpperCase().match(PLATE_RE);
    return m ? (m[1]+' '+m[2]+' '+m[3]) : raw.toUpperCase();
}

// ── Live clock ─────────────────────────────────────────────────
(function(){
    const el = document.getElementById('liveClock');
    function tick(){
        const now = new Date();
        el.textContent = now.toLocaleDateString('id-ID',{weekday:'long',day:'2-digit',month:'long',year:'numeric'})
            +' · '+now.toLocaleTimeString('id-ID');
    }
    tick(); setInterval(tick,1000);
})();

function nowStr(){
    return new Date().toLocaleString('id-ID',{day:'2-digit',month:'long',year:'numeric',hour:'2-digit',minute:'2-digit'});
}

// ── Screen ─────────────────────────────────────────────────────
function showScreen(id){
    document.querySelectorAll('.kscreen').forEach(s=>s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}
function showLoading(title='Memverifikasi...', sub='Mohon tunggu sebentar'){
    document.getElementById('loadingTitle').textContent = title;
    document.getElementById('loadingSub').textContent   = sub;
    showScreen('sLoading');
}

// ── Plate input ────────────────────────────────────────────────
function onPlateInput(el){
    el.value = el.value.toUpperCase();
    const val = el.value.trim();
    const ok  = validatePlate(val);
    const btn = document.getElementById('btnVerif');
    const msg = document.getElementById('plateValidMsg');
    const prv = document.getElementById('ocrPreview');

    el.classList.toggle('valid',   ok && val.length>0);
    el.classList.toggle('invalid', !ok && val.length>2);

    if(ok){
        prv.textContent = formatPlate(val);
        prv.className   = 'plate-display valid';
        msg.textContent = '✓ Format plat valid';
        msg.style.color = '#027A48';
        btn.disabled    = false;
    } else {
        prv.textContent = val.length ? val : '– – – –';
        prv.className   = 'plate-display'+(val.length>2?' invalid':'');
        msg.textContent = val.length>2 ? '✗ Format tidak valid — contoh: B 1234 XYZ' : '1–2 huruf · 1–4 angka · 1–3 huruf';
        msg.style.color = val.length>2 ? '#DC2626' : '#8A93AE';
        btn.disabled    = true;
    }
}

// ── OCR Polling ────────────────────────────────────────────────
function startPolling(){
    stopPolling();
    scanInterval = setInterval(()=>{
        fetch('/petugas/kiosk/cek-plat')
        .then(r=>r.json())
        .then(data=>{
            if(data.status==='collecting' && data.plat){
                const inp = document.getElementById('plateInput');
                if(inp && document.activeElement!==inp){
                    inp.value = data.plat;
                    onPlateInput(inp);
                }
            } else if(data.status==='found'||data.status==='tamu'){
                stopPolling();
                foundData = data;
                processResult(data);
            }
        })
        .catch(console.error);
    },1200);
}
function stopPolling(){
    if(scanInterval){clearInterval(scanInterval);scanInterval=null;}
}

// ── Submit plat ────────────────────────────────────────────────
function submitPlate(){
    const raw = document.getElementById('plateInput').value.trim();
    if(!validatePlate(raw)) return;

    stopPolling();
    const plat = formatPlate(raw);
    showLoading('Memverifikasi plat '+plat+'...','Mencari data kendaraan dalam database');

    fetch('/petugas/kiosk/scan-plat',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content
        },
        body:JSON.stringify({plat, manual:true})
    })
    .then(r=>r.json())
    .then(data=>{
        foundData = data;
        processResult(data);
    })
    .catch(()=>{showScreen('s1');alert('Gagal terhubung ke server.');});
}

// ── Process result ─────────────────────────────────────────────
function processResult(data){
    const aksi = data.aksi ?? 'masuk';

    if(data.status==='tamu'){
        if(aksi === 'keluar'){
            // Ada record parkir aktif tapi tidak terdaftar → langsung officer
            goOfficer(
                data.plat,
                aksi,
                'tamu-not-found',
                `Plat <strong>${data.plat}</strong> tercatat sedang parkir namun tidak terdaftar dalam database.`
            );
        } else {
            // Masuk, tidak terdaftar — cek retry
            plateRetry++;
            updatePlateRetryBar();

            if(plateRetry >= MAX_RETRY){
                goOfficer(
                    data.plat,
                    aksi,
                    'tamu-not-found',
                    `Plat <strong>${data.plat}</strong> tidak ditemukan dalam database setelah ${MAX_RETRY} percobaan.`
                );
            } else {
                showScreen('s1');
                startPolling();
            }
        }

    } else if(data.status==='found'){
        // Reset retry plat karena ketemu
        plateRetry = 0;
        updatePlateRetryBar();

        if(data.has_face && aksi==='masuk'){
            openFaceScan(data);
        } else if(data.has_face && aksi==='keluar'){
            openFaceScan(data);
        } else {
            // Tidak ada foto wajah → konfirmasi petugas
            goOfficer(
                data.plat,
                aksi,
                'no-face',
                `Kendaraan <strong>${data.plat}</strong> terdaftar atas nama <strong>${data.mahasiswa?.nama??'-'}</strong>, namun foto wajah belum tersedia dalam sistem.`,
                data
            );
        }
    }
}

// ── Plate retry bar ────────────────────────────────────────────
function updatePlateRetryBar(){
    const bar  = document.getElementById('plateRetryBar');
    const sisa = MAX_RETRY - plateRetry;

    if(plateRetry===0){bar.style.display='none';return;}

    bar.style.display = 'flex';
    bar.className     = 'retry-bar '+(plateRetry===1?'r1':plateRetry===2?'r2':'r3');
    bar.innerHTML     = `⚠ Plat tidak ditemukan (percobaan ${plateRetry}/${MAX_RETRY}) — sisa ${sisa} kali sebelum konfirmasi petugas`;
}

// ── Face scan ──────────────────────────────────────────────────
function openFaceScan(data){
    faceRetry    = 0;
    faceVerified = null;
    document.getElementById('wajahPlat').textContent = data.plat;
    document.getElementById('wajahNama').textContent = data.mahasiswa?.nama??'-';
    document.getElementById('wajahSub').textContent  = (data.aksi==='keluar')
        ? 'Verifikasi wajah sebelum keluar' : 'Hadapkan wajah ke kamera';
    updateFaceRetryBar();
    showScreen('sWajah');
}

function doFaceScan(){
    showLoading('Memindai wajah...','Mencocokkan dengan data terdaftar');

    // TODO: ganti setTimeout ini dengan fetch ke API face recognition asli
    setTimeout(()=>{
        const isMatch = Math.random()>0.35; // simulasi — hapus saat pakai API asli
        handleFaceResult(isMatch);
    },12000); // 12 detik — cukup untuk API face recognition proses
}

function handleFaceResult(isMatch){
    faceVerified = isMatch;

    if(isMatch){
        // Langsung ke konfirmasi normal dengan banner hijau
        showKonfirm(foundData, true);
        return;
    }

    // Tidak cocok
    faceRetry++;
    updateFaceRetryBar();

    if(faceRetry>=MAX_RETRY){
        // Habis retry → konfirmasi petugas
        goOfficer(
            foundData.plat,
            foundData.aksi??'masuk',
            'face-fail',
            `Verifikasi wajah gagal sebanyak ${MAX_RETRY} kali untuk kendaraan <strong>${foundData.plat}</strong> atas nama <strong>${foundData.mahasiswa?.nama??'-'}</strong>.`,
            foundData
        );
    } else {
        // Kembali ke layar wajah, coba lagi
        showScreen('sWajah');
    }
}

function updateFaceRetryBar(){
    const bar  = document.getElementById('faceRetryBar');
    const sisa = MAX_RETRY - faceRetry;

    if(faceRetry===0){bar.style.display='none';return;}

    bar.style.display = 'flex';
    bar.className     = 'retry-bar '+(faceRetry===1?'r1':faceRetry===2?'r2':'r3');
    bar.innerHTML     = `⚠ Wajah tidak cocok (percobaan ${faceRetry}/${MAX_RETRY}) — sisa ${sisa} kali`;
}

// ── Tampil konfirmasi normal (terdaftar + cocok) ───────────────
function showKonfirm(data, faceMatch){
    const aksi = data.aksi??'masuk';

    document.getElementById('konfirmNama').textContent  = data.mahasiswa?.nama??'-';
    document.getElementById('konfirmNim').textContent   = data.mahasiswa?.nim_nip??'-';
    document.getElementById('konfirmPlat').textContent  = data.plat;
    document.getElementById('konfirmWarna').textContent = data.kendaraan?.warna??'-';
    document.getElementById('konfirmTime').textContent  = nowStr();
    document.getElementById('konfirmAksi').innerHTML    = aksi==='masuk'
        ? '<span class="aksi-masuk">↓ Masuk</span>'
        : '<span class="aksi-keluar">↑ Keluar</span>';

    document.getElementById('btnKonfirm').textContent = aksi==='masuk'?'✓ Izinkan Masuk':'✓ Izinkan Keluar';

    // Banner wajah
    const banner = document.getElementById('faceBannerKonfirm');
    const faceEl = document.getElementById('konfirmFace');

    if(faceMatch===true){
        banner.innerHTML=`<div class="face-banner match">
            <div class="ficon"><svg viewBox="0 0 24 24" fill="none" stroke="#027A48" stroke-width="2.5" style="width:20px;height:20px;"><polyline points="20 6 9 17 4 12"/></svg></div>
            <div><div class="ftitle">Wajah Cocok!</div><div class="fdesc">Identitas terverifikasi. Silakan konfirmasi.</div></div>
        </div>`;
        faceEl.innerHTML='<span class="badge-green">✓ Terverifikasi</span>';
    } else {
        banner.innerHTML='';
        faceEl.innerHTML='<span class="badge-yellow">⚠ Dilewati</span>';
    }

    showScreen('sKonfirm');
}

// ── Officer screen ─────────────────────────────────────────────
// type: 'tamu-not-found' | 'no-face' | 'face-fail'
function goOfficer(plat, aksi, type, reason, data=null){
    officerReason = reason;

    if(data) foundData = {...(foundData??{}), ...data, plat, aksi};
    else if(foundData) foundData = {...foundData, plat, aksi};
    else foundData = {plat, aksi, status:'tamu'};

    document.getElementById('officerPlat').textContent = plat;
    document.getElementById('officerReason').innerHTML = reason;
    document.getElementById('officerAksi').innerHTML   = aksi==='masuk'
        ? '<span class="aksi-masuk">↓ Masuk</span>'
        : '<span class="aksi-keluar">↑ Keluar</span>';

    let statusHtml = '';
    if(type==='tamu-not-found') statusHtml = '<span class="badge-yellow">Tidak Terdaftar</span>';
    else if(type==='no-face')   statusHtml = '<span class="badge-yellow">Wajah Belum Ada</span>';
    else if(type==='face-fail') statusHtml = '<span class="badge-yellow">Wajah Gagal</span>';
    document.getElementById('officerStatus').innerHTML = statusHtml;

    document.getElementById('btnOfficerAllow').textContent = aksi==='masuk'?'✓ Izinkan Masuk':'✓ Izinkan Keluar';

    showScreen('sOfficer');
}

// ── Confirm action ─────────────────────────────────────────────
function confirmAction(){
    if(!foundData) return;
    const aksi = foundData.aksi??'masuk';
    showLoading(
        aksi==='masuk'?'Mencatat masuk...':'Mencatat keluar...',
        'Mohon tunggu sebentar'
    );

    if(aksi==='keluar' && foundData.record_id){
        fetch('/petugas/kiosk/konfirmasi-keluar',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken()},
            body:JSON.stringify({record_id:foundData.record_id})
        })
        .then(r=>r.json())
        .then(res=>showSuccess(res,'keluar'))
        .catch(()=>{showScreen('sOfficer');alert('Gagal mencatat keluar.');});
    } else {
        const role = (!foundData.mahasiswa)?'tamu':'mahasiswa';
        fetch('/petugas/kiosk/konfirmasi-masuk',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken()},
            body:JSON.stringify({
                plate_number:  foundData.plat,
                role:          role,
                face_verified: faceVerified
            })
        })
        .then(r=>r.json())
        .then(res=>showSuccess(res,'masuk'))
        .catch(()=>{showScreen('sOfficer');alert('Gagal mencatat masuk.');});
    }
}

function csrfToken(){
    return document.querySelector('meta[name=csrf-token]').content;
}

// ── Success ────────────────────────────────────────────────────
function showSuccess(res, aksi){
    const kel = aksi==='keluar';
    document.getElementById('successTitle').textContent = kel?'✓ Kendaraan Berhasil Keluar!':'✓ Kendaraan Berhasil Masuk!';
    document.getElementById('successSub').textContent   = kel?'Catatan parkir ditutup. Terima kasih!':'Catatan parkir dibuat. Selamat datang!';
    document.getElementById('ticketNum').textContent    = '#'+String(res.record_id).padStart(6,'0');
    document.getElementById('ticketTime').textContent   = kel
        ? 'Keluar: '+new Date(res.exit_time??new Date()).toLocaleString('id-ID')
        : 'Masuk: ' +new Date(res.entry_time??new Date()).toLocaleString('id-ID');

    const wrap = document.getElementById('successIconWrap');
    if(kel){
        wrap.style.background='#FFF7ED';wrap.style.borderColor='#FED7AA';
        wrap.querySelector('svg').style.stroke='#C2410C';
    } else {
        wrap.style.background='#ECFDF3';wrap.style.borderColor='#6CE9A6';
        wrap.querySelector('svg').style.stroke='#027A48';
    }
    showScreen('sSuccess');

    let sisa=15;
    const lbl=document.getElementById('autoResetLabel');
    lbl.textContent=`Kembali ke awal dalam ${sisa} detik...`;
    autoReset=setInterval(()=>{
        sisa--;
        lbl.textContent=`Kembali ke awal dalam ${sisa} detik...`;
        if(sisa<=0){clearInterval(autoReset);resetKiosk();}
    },1000);
}

// ── Reset ──────────────────────────────────────────────────────
function resetKiosk(){
    stopPolling();
    if(autoReset){clearInterval(autoReset);autoReset=null;}
    foundData=null; faceVerified=null; faceRetry=0; plateRetry=0; officerReason='';

    const inp=document.getElementById('plateInput');
    inp.value=''; inp.className='plate-input';
    document.getElementById('ocrPreview').textContent='– – – –';
    document.getElementById('ocrPreview').className='plate-display';
    document.getElementById('plateValidMsg').textContent='1–2 huruf · 1–4 angka · 1–3 huruf';
    document.getElementById('plateValidMsg').style.color='#8A93AE';
    document.getElementById('btnVerif').disabled=true;
    document.getElementById('plateRetryBar').style.display='none';
    document.getElementById('faceRetryBar').style.display='none';

    const wrap=document.getElementById('successIconWrap');
    wrap.style.background='#ECFDF3';wrap.style.borderColor='#6CE9A6';
    wrap.querySelector('svg').style.stroke='#027A48';

    showScreen('s1');
    startPolling();
}

// ── Init ───────────────────────────────────────────────────────
startPolling();
</script>
@endsection