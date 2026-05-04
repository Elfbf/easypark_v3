@extends('layouts.app')

@section('title', 'Scan Masuk Parkir')
@section('page_title', 'Scan Masuk Parkir')

@section('content')

<style>
/* ── Screens ── */
.kscreen        { display: none; }
.kscreen.active { display: block; }

/* ── Role buttons ── */
.role-btn {
    flex: 1; min-width: 180px; max-width: 220px;
    padding: 1.6rem 1.2rem; border-radius: 14px;
    border: 1.5px solid #D4D9E8; background: #fff;
    cursor: pointer; display: flex; flex-direction: column;
    align-items: center; gap: 9px;
    transition: border-color .2s, background .2s, transform .15s;
}
.role-btn:hover {
    border-color: #1A4BAD; background: #EEF3FC;
    transform: translateY(-2px);
}
.role-icon {
    width: 62px; height: 62px; border-radius: 50%;
    background: #E8F0FB; border: 1.5px solid #C0D3F5;
    display: flex; align-items: center; justify-content: center;
}
.role-label {
    font-family: 'Syne', sans-serif; font-size: 15px;
    font-weight: 700; color: #181D35; margin-bottom: 3px;
}
.role-desc { font-size: 12px; color: #8A93AE; line-height: 1.4; }

/* ── Notice box ── */
.notice-box {
    padding: 11px 14px; border-radius: 9px;
    background: #FFFAEB; border: 1px solid #FEF0C7;
    display: flex; align-items: flex-start; gap: 9px;
    font-size: 12px; color: #92400E; line-height: 1.5;
}

/* ── Step bar ── */
.step-bar {
    display: flex; align-items: center; gap: 10px; margin-bottom: 18px;
}
.steps { display: flex; align-items: center; }
.step {
    width: 9px; height: 9px; border-radius: 50%;
    background: #EBEEF5; border: 1.5px solid #D4D9E8;
    transition: background .3s, border-color .3s;
}
.step.done  { background: #1A4BAD; border-color: #1A4BAD; }
.step-line  { width: 26px; height: 2px; background: #EBEEF5; transition: background .3s; }
.step-line.done { background: #1A4BAD; }

/* ── Back button ── */
.back-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px; border-radius: 8px; font-size: 12px;
    color: #8A93AE; border: 1.5px solid #EBEEF5; background: #fff;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: border-color .2s, background .2s;
}
.back-btn:hover { border-color: #D4D9E8; background: #F5F7FC; }

/* ── Screen typography ── */
.screen-title {
    font-family: 'Syne', sans-serif; font-size: 1.25rem;
    font-weight: 800; color: #181D35; margin-bottom: 5px;
}
.screen-sub {
    font-size: 13px; color: #8A93AE;
    margin-bottom: 18px; line-height: 1.5;
}

/* ── Camera box ── */
.cam-box {
    border-radius: 12px; border: 2px solid #3B6FD4;
    background: #fff; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.corner { position: absolute; width: 16px; height: 16px; border-color: #1A4BAD; border-style: solid; border-width: 0; }
.corner.tl { top:6px; left:6px;    border-top-width:2.5px; border-left-width:2.5px;   border-radius:2px 0 0 0; }
.corner.tr { top:6px; right:6px;   border-top-width:2.5px; border-right-width:2.5px;  border-radius:0 2px 0 0; }
.corner.bl { bottom:6px; left:6px;  border-bottom-width:2.5px; border-left-width:2.5px;  border-radius:0 0 0 2px; }
.corner.br { bottom:6px; right:6px; border-bottom-width:2.5px; border-right-width:2.5px; border-radius:0 0 2px 0; }
.scan-line {
    position: absolute; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, #1A4BAD, transparent);
    animation: scanMove 2s ease-in-out infinite; opacity: .8;
}

/* ── Plate input ── */
.plate-input {
    font-family: monospace; font-size: 22px; font-weight: 700;
    letter-spacing: .12em; text-align: center; text-transform: uppercase;
    padding: .65rem 1.1rem; border: 1.5px solid #D4D9E8; border-radius: 10px;
    background: #fff; color: #181D35; width: 260px; outline: none;
    transition: border-color .2s; display: block; margin: 0 auto;
}
.plate-input:focus { border-color: #3B6FD4; }

/* ── Buttons ── */
.btn-row { display: flex; gap: 9px; justify-content: center; margin-top: 14px; }

.btn-prim {
    display: inline-flex; align-items: center; gap: 6px;
    padding: .58rem 1.3rem; border-radius: 10px;
    background: #1A4BAD; color: #fff; border: none; cursor: pointer;
    font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif;
    transition: background .2s;
}
.btn-prim:hover { background: #153d94; }

.btn-out {
    display: inline-flex; align-items: center; gap: 6px;
    padding: .58rem 1.1rem; border-radius: 10px;
    background: #fff; color: #8A93AE;
    border: 1.5px solid #EBEEF5; cursor: pointer;
    font-size: 13px; font-family: 'DM Sans', sans-serif;
    transition: border-color .2s, background .2s;
}
.btn-out:hover { border-color: #D4D9E8; background: #F5F7FC; }

/* ── Info card ── */
.info-card { border: 1.5px solid #EBEEF5; border-radius: 11px; overflow: hidden; margin-bottom: 14px; }
.info-card-head {
    padding: 13px 18px; background: #E8F0FB; border-bottom: 1px solid #C0D3F5;
    display: flex; align-items: center; gap: 10px;
}
.head-avatar {
    width: 32px; height: 32px; border-radius: 50%; background: #C0D3F5;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.info-row     { display: flex; align-items: center; padding: 11px 18px; border-bottom: 1px solid #EBEEF5; }
.info-row:last-child { border-bottom: none; }
.info-row.alt { background: #FAFBFD; }
.info-lbl { font-size: 12.5px; color: #8A93AE; width: 130px; flex-shrink: 0; }
.info-val { font-size: 14px; color: #181D35; font-weight: 500; }
.info-val.mono  { font-family: monospace; letter-spacing: .07em; }
.info-val.small { font-size: 12px; font-weight: 400; }

/* ── Badges ── */
.badge-green {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 100px;
    background: #ECFDF3; border: 1px solid #6CE9A6; color: #027A48;
}
.badge-blue {
    display: inline-flex; align-items: center;
    font-size: 11.5px; font-weight: 600; padding: 3px 9px; border-radius: 100px;
    background: #E8F0FB; border: 1px solid #C0D3F5; color: #1A4BAD;
}

/* ── Animations ── */
@keyframes scanMove  { 0%,100% { top: 8px; } 50% { top: calc(100% - 10px); } }
@keyframes facePulse { 0%,100% { opacity:.5; transform:scale(1); } 50% { opacity:1; transform:scale(1.04); } }
@keyframes spin      { to { transform: rotate(360deg); } }
@keyframes dotPulse  { 0%,100% { opacity:1; } 50% { opacity:.3; } }
</style>

    {{-- ── Breadcrumb ── --}}
    <nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            style="width:14px;height:14px;color:#8A93AE;flex-shrink:0;">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        <a href="{{ route('dashboard') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
        <span style="color:#D4D9E8;">/</span>
        <a href="{{ route('petugas.dashboard') }}" style="color:#8A93AE;text-decoration:none;">Petugas</a>
        <span style="color:#D4D9E8;">/</span>
        <span style="color:#181D35;font-weight:600;">Scan Masuk</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Scan Masuk Parkir</div>
            <div class="page-sub">Portal kiosk untuk mencatat kendaraan masuk area parkir</div>
        </div>
    </div>

    {{-- ══ KIOSK WRAPPER ══ --}}
    <div class="card" style="padding:0;overflow:hidden;">

        {{-- Top bar --}}
        <div style="padding:12px 24px;border-bottom:1px solid #EBEEF5;
                    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;
                    background:#fff;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="width:7px;height:7px;border-radius:50%;background:#12B76A;
                             display:inline-block;animation:dotPulse 1.5s infinite;"></span>
                <span style="font-size:12px;color:#027A48;font-weight:600;">Kiosk Aktif</span>
            </div>
            <span style="font-size:11.5px;color:#8A93AE;" id="liveClock"></span>
        </div>

        {{-- ══ KIOSK BODY ══ --}}
        <div style="padding:36px 32px;background:#F5F7FC;min-height:640px;
                    display:flex;align-items:center;justify-content:center;">
            <div style="width:100%;max-width:560px;">

                {{-- ─── SCREEN 0 : Pilih Peran ─── --}}
                <div class="kscreen active" id="s0">
                    <div style="text-align:center;margin-bottom:28px;">
                        <div style="width:48px;height:48px;border-radius:13px;background:#E8F0FB;
                                    border:1.5px solid #C0D3F5;display:flex;align-items:center;
                                    justify-content:center;margin:0 auto 14px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                style="width:22px;height:22px;">
                                <rect x="2" y="3" width="20" height="14" rx="2"/>
                                <path d="M8 21h8"/><path d="M12 17v4"/>
                                <path d="M9 10l2 2 4-4"/>
                            </svg>
                        </div>
                        <div style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;
                                    color:#181D35;margin-bottom:5px;">Selamat datang!</div>
                        <div style="font-size:12.5px;color:#8A93AE;line-height:1.6;">
                            Pilih jenis pengunjung untuk memulai proses pencatatan parkir
                        </div>
                    </div>

                    <div style="display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:22px;">
                        <button onclick="chooseRole('mahasiswa')" class="role-btn">
                            <div class="role-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="1.8"
                                    style="width:24px;height:24px;">
                                    <path d="M22 10L12 4 2 10l10 6 10-6z"/>
                                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="role-label">Mahasiswa</div>
                                <div class="role-desc">Verifikasi wajah<br>+ plat nomor</div>
                            </div>
                        </button>

                        <button onclick="chooseRole('tamu')" class="role-btn">
                            <div class="role-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="1.8"
                                    style="width:24px;height:24px;">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="role-label">Tamu</div>
                                <div class="role-desc">Scan plat nomor<br>kendaraan saja</div>
                            </div>
                        </button>
                    </div>

                    <div class="notice-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#B54708" stroke-width="2"
                            style="width:14px;height:14px;flex-shrink:0;margin-top:1px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <span>Hubungi petugas jika membutuhkan bantuan atau terjadi kendala pada sistem</span>
                    </div>
                </div>

                {{-- ─── SCREEN 1M : Scan Wajah (Mahasiswa) ─── --}}
                <div class="kscreen" id="s1m">
                    <div class="step-bar">
                        <button class="back-btn" onclick="showScreen('s0')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </button>
                        <div class="steps">
                            <div class="step done"></div>
                            <div class="step-line done"></div>
                            <div class="step"></div>
                            <div class="step-line"></div>
                            <div class="step"></div>
                        </div>
                    </div>

                    <div style="text-align:center;">
                        <div class="screen-title">Scan Wajah</div>
                        <div class="screen-sub">Hadapkan wajah ke kamera dengan jelas dan pencahayaan cukup</div>

                        <div class="cam-box" style="width:220px;height:220px;margin:0 auto 16px;">
                            <div class="corner tl"></div>
                            <div class="corner tr"></div>
                            <div class="corner bl"></div>
                            <div class="corner br"></div>
                            <div style="width:72px;height:72px;border-radius:50%;background:#E8F0FB;
                                        display:flex;align-items:center;justify-content:center;
                                        animation:facePulse 1.8s ease-in-out infinite;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="1.5"
                                    style="width:34px;height:34px;">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div class="scan-line"></div>
                        </div>

                        <div style="font-size:12px;color:#8A93AE;margin-bottom:18px;">
                            Posisikan wajah di dalam bingkai kamera
                        </div>

                        <div class="btn-row">
                            <button class="btn-out" onclick="showScreen('s0')">Batal</button>
                            <button class="btn-prim" onclick="simulateFaceScan()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:13px;height:13px;">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M3 9V6a1 1 0 0 1 1-1h3M3 15v3a1 1 0 0 0 1 1h3M21 9V6a1 1 0 0 0-1-1h-3M21 15v3a1 1 0 0 1-1 1h-3"/>
                                </svg>
                                Ambil Foto
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ─── SCREEN 1.5M : Processing ─── --}}
                <div class="kscreen" id="s15m" style="text-align:center;padding:3.5rem 0;">
                    <div style="width:46px;height:46px;border:3px solid #E8F0FB;border-top-color:#1A4BAD;
                                border-radius:50%;animation:spin .9s linear infinite;margin:0 auto 18px;"></div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;
                                color:#181D35;margin-bottom:5px;">Memproses wajah...</div>
                    <div style="font-size:12.5px;color:#8A93AE;">Sedang memverifikasi identitas mahasiswa</div>
                </div>

                {{-- ─── SCREEN 2M : Input Plat (Mahasiswa) ─── --}}
                <div class="kscreen" id="s2m">
                    <div class="step-bar">
                        <button class="back-btn" onclick="showScreen('s1m')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </button>
                        <div class="steps">
                            <div class="step done"></div>
                            <div class="step-line done"></div>
                            <div class="step done"></div>
                            <div class="step-line"></div>
                            <div class="step"></div>
                        </div>
                    </div>

                    <div style="text-align:center;">
                        <div class="screen-title">Scan Plat Nomor</div>
                        <div class="screen-sub">Arahkan kamera ke plat nomor atau masukkan manual</div>

                        <div class="cam-box" style="width:280px;height:130px;margin:0 auto 16px;">
                            <div class="corner tl"></div>
                            <div class="corner tr"></div>
                            <div class="corner bl"></div>
                            <div class="corner br"></div>
                            <div style="background:#F5F7FC;border-radius:6px;padding:5px 16px;
                                        border:1.5px dashed #D4D9E8;">
                                <span style="font-family:monospace;font-size:17px;font-weight:700;
                                             color:#8A93AE;letter-spacing:.12em;">AB 1234 CD</span>
                            </div>
                            <div class="scan-line"></div>
                        </div>

                        <input type="text" id="plateM" class="plate-input"
                            placeholder="B 1234 XYZ" maxlength="12"
                            oninput="this.value=this.value.toUpperCase()">

                        <div style="font-size:11.5px;color:#8A93AE;margin:.6rem 0 1.2rem;">
                            Ketik plat nomor jika scan tidak berhasil
                        </div>

                        <div class="btn-row">
                            <button class="btn-out" onclick="showScreen('s1m')">Kembali</button>
                            <button class="btn-prim" onclick="submitPlateM()">Verifikasi →</button>
                        </div>
                    </div>
                </div>

                {{-- ─── SCREEN 3M : Konfirmasi (Mahasiswa) ─── --}}
                <div class="kscreen" id="s3m">
                    <div class="step-bar">
                        <button class="back-btn" onclick="showScreen('s2m')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </button>
                        <div class="steps">
                            <div class="step done"></div>
                            <div class="step-line done"></div>
                            <div class="step done"></div>
                            <div class="step-line done"></div>
                            <div class="step done"></div>
                        </div>
                    </div>

                    <div class="screen-title" style="text-align:center;margin-bottom:16px;">Konfirmasi Data</div>

                    <div class="info-card">
                        <div class="info-card-head">
                            <div class="head-avatar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                    style="width:16px;height:16px;">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#1A4BAD;">Mahasiswa Terdeteksi</div>
                                <div style="font-size:11px;color:#3B6FD4;">Ahmad Fauzi — NIM 220411001</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-lbl">Plat Nomor</div>
                            <div id="plateMDisplay" class="info-val mono"></div>
                        </div>
                        <div class="info-row alt">
                            <div class="info-lbl">Kendaraan</div>
                            <div class="info-val">Honda Vario 125 — Hitam</div>
                        </div>
                        <div class="info-row">
                            <div class="info-lbl">Status Wajah</div>
                            <span class="badge-green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    style="width:9px;height:9px;"><polyline points="20 6 9 17 4 12"/></svg>
                                Cocok
                            </span>
                        </div>
                        <div class="info-row alt">
                            <div class="info-lbl">Waktu Masuk</div>
                            <div id="mEntryTime" class="info-val mono small"></div>
                        </div>
                    </div>

                    <div class="btn-row">
                        <button class="btn-out" onclick="resetKiosk()">Batal</button>
                        <button class="btn-prim" onclick="confirmEntry('mahasiswa')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:13px;height:13px;"><polyline points="20 6 9 17 4 12"/></svg>
                            Konfirmasi Masuk
                        </button>
                    </div>
                </div>

                {{-- ─── SCREEN 1T : Input Plat (Tamu) ─── --}}
                <div class="kscreen" id="s1t">
                    <div class="step-bar">
                        <button class="back-btn" onclick="showScreen('s0')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </button>
                        <div class="steps">
                            <div class="step done"></div>
                            <div class="step-line"></div>
                            <div class="step"></div>
                        </div>
                    </div>

                    <div style="text-align:center;">
                        <div class="screen-title">Scan Plat Nomor</div>
                        <div class="screen-sub">Arahkan kamera ke plat nomor kendaraan tamu</div>

                        <div class="cam-box" style="width:280px;height:130px;margin:0 auto 16px;">
                            <div class="corner tl"></div>
                            <div class="corner tr"></div>
                            <div class="corner bl"></div>
                            <div class="corner br"></div>
                            <div style="background:#F5F7FC;border-radius:6px;padding:5px 16px;
                                        border:1.5px dashed #D4D9E8;">
                                <span style="font-family:monospace;font-size:17px;font-weight:700;
                                             color:#8A93AE;letter-spacing:.12em;">AB 1234 CD</span>
                            </div>
                            <div class="scan-line"></div>
                        </div>

                        <input type="text" id="plateT" class="plate-input"
                            placeholder="B 1234 XYZ" maxlength="12"
                            oninput="this.value=this.value.toUpperCase()">

                        <div style="font-size:11.5px;color:#8A93AE;margin:.6rem 0 1.2rem;">
                            Ketik plat nomor jika scan tidak berhasil
                        </div>

                        <div class="btn-row">
                            <button class="btn-out" onclick="showScreen('s0')">Kembali</button>
                            <button class="btn-prim" onclick="submitPlateT()">Lanjutkan →</button>
                        </div>
                    </div>
                </div>

                {{-- ─── SCREEN 2T : Konfirmasi (Tamu) ─── --}}
                <div class="kscreen" id="s2t">
                    <div class="step-bar">
                        <button class="back-btn" onclick="showScreen('s1t')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </button>
                        <div class="steps">
                            <div class="step done"></div>
                            <div class="step-line done"></div>
                            <div class="step done"></div>
                        </div>
                    </div>

                    <div class="screen-title" style="text-align:center;margin-bottom:16px;">Konfirmasi Tamu</div>

                    <div class="info-card">
                        <div class="info-card-head">
                            <div class="head-avatar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                    style="width:16px;height:16px;">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#1A4BAD;">Tamu Umum</div>
                                <div style="font-size:11px;color:#3B6FD4;">Kendaraan tidak terdaftar dalam sistem</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-lbl">Plat Nomor</div>
                            <div id="plateTDisplay" class="info-val mono"></div>
                        </div>
                        <div class="info-row alt">
                            <div class="info-lbl">Status</div>
                            <span class="badge-blue">Tamu</span>
                        </div>
                        <div class="info-row">
                            <div class="info-lbl">Waktu Masuk</div>
                            <div id="tEntryTime" class="info-val mono small"></div>
                        </div>
                    </div>

                    <div style="padding:11px 14px;border-radius:9px;background:#F5F7FC;
                                border:1px solid #EBEEF5;font-size:12px;color:#8A93AE;
                                line-height:1.5;margin-bottom:14px;text-align:center;">
                        Tiket parkir akan digenerate otomatis. Simpan nomor tiket untuk proses pembayaran saat keluar.
                    </div>

                    <div class="btn-row">
                        <button class="btn-out" onclick="resetKiosk()">Batal</button>
                        <button class="btn-prim" onclick="confirmEntry('tamu')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:13px;height:13px;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            Cetak Tiket
                        </button>
                    </div>
                </div>

                {{-- ─── SCREEN SUCCESS ─── --}}
                <div class="kscreen" id="sSuccess" style="text-align:center;">
                    <div style="width:58px;height:58px;border-radius:50%;background:#ECFDF3;
                                border:1.5px solid #6CE9A6;display:flex;align-items:center;
                                justify-content:center;margin:0 auto 14px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#027A48" stroke-width="2.5"
                            style="width:26px;height:26px;"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>

                    <div style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:800;
                                color:#181D35;margin-bottom:5px;" id="successTitle">Selamat datang!</div>
                    <div style="font-size:13px;color:#8A93AE;margin-bottom:20px;" id="successSub"></div>

                    <div style="padding:14px 22px;background:#fff;border:1.5px solid #EBEEF5;
                                border-radius:11px;display:inline-block;margin-bottom:14px;">
                        <div style="font-size:11px;color:#8A93AE;margin-bottom:4px;">Nomor Tiket</div>
                        <div id="ticketNum"
                            style="font-family:monospace;font-size:22px;font-weight:700;
                                   color:#181D35;letter-spacing:.1em;"></div>
                        <div id="ticketTime" style="font-size:11px;color:#8A93AE;margin-top:4px;"></div>
                    </div>

                    <div style="font-size:12px;color:#8A93AE;margin-bottom:20px;" id="successNote"></div>

                    <button onclick="resetKiosk()" class="btn-prim" style="margin:0 auto;">
                        Selesai — Kembali ke Awal
                    </button>

                    <div style="margin-top:14px;font-size:11.5px;color:#D4D9E8;" id="autoResetLabel"></div>
                </div>

            </div>{{-- /inner --}}
        </div>{{-- /kiosk body --}}

    </div>{{-- /card --}}

<script>
// ── Live Clock ──────────────────────────────────────────────
(function clock() {
    const el = document.getElementById('liveClock');
    function tick() {
        const now = new Date();
        el.textContent =
            now.toLocaleDateString('id-ID', {
                weekday: 'long', day: '2-digit',
                month: 'long', year: 'numeric'
            }) + ' · ' + now.toLocaleTimeString('id-ID');
    }
    tick();
    setInterval(tick, 1000);
})();

// ── Screen navigation ────────────────────────────────────────
function showScreen(id) {
    document.querySelectorAll('.kscreen').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}

// ── Role selection ───────────────────────────────────────────
function chooseRole(role) {
    showScreen(role === 'mahasiswa' ? 's1m' : 's1t');
}

// ── Mahasiswa: simulate face scan ────────────────────────────
function simulateFaceScan() {
    showScreen('s15m');
    setTimeout(() => showScreen('s2m'), 2200);
}

// ── Mahasiswa: validate & move to confirm ────────────────────
function submitPlateM() {
    const val = document.getElementById('plateM').value.trim().toUpperCase();
    if (!val) { showToast('Masukkan plat nomor terlebih dahulu'); return; }
    document.getElementById('plateMDisplay').textContent = val;
    document.getElementById('mEntryTime').textContent   = nowString();
    showScreen('s3m');
}

// ── Tamu: validate & move to confirm ─────────────────────────
function submitPlateT() {
    const val = document.getElementById('plateT').value.trim().toUpperCase();
    if (!val) { showToast('Masukkan plat nomor terlebih dahulu'); return; }
    document.getElementById('plateTDisplay').textContent = val;
    document.getElementById('tEntryTime').textContent    = nowString();
    showScreen('s2t');
}

// ── Confirm entry (static — tanpa fetch) ─────────────────────
function confirmEntry(role) {
    const plate  = role === 'mahasiswa'
        ? document.getElementById('plateMDisplay').textContent
        : document.getElementById('plateTDisplay').textContent;

    const ticket = 'EP-' + Date.now().toString().slice(-6);

    document.getElementById('ticketNum').textContent  = ticket;
    document.getElementById('ticketTime').textContent = nowString();

    if (role === 'mahasiswa') {
        document.getElementById('successTitle').textContent = 'Selamat datang!';
        document.getElementById('successSub').textContent   = 'Kendaraan ' + plate + ' berhasil masuk';
        document.getElementById('successNote').textContent  = 'Wajah & kendaraan terverifikasi. Selamat belajar!';
    } else {
        document.getElementById('successTitle').textContent = 'Tiket berhasil dibuat!';
        document.getElementById('successSub').textContent   = 'Kendaraan ' + plate + ' berhasil masuk';
        document.getElementById('successNote').textContent  = 'Simpan nomor tiket untuk proses keluar.';
    }

    showScreen('sSuccess');
    startAutoReset();
}

// ── Auto reset countdown ──────────────────────────────────────
let autoTimer;
function startAutoReset() {
    let sec = 15;
    const el = document.getElementById('autoResetLabel');
    el.textContent = 'Layar akan reset dalam ' + sec + ' detik';
    clearInterval(autoTimer);
    autoTimer = setInterval(() => {
        sec--;
        el.textContent = 'Layar akan reset dalam ' + sec + ' detik';
        if (sec <= 0) { clearInterval(autoTimer); resetKiosk(); }
    }, 1000);
}

function resetKiosk() {
    clearInterval(autoTimer);
    document.getElementById('plateM').value = '';
    document.getElementById('plateT').value = '';
    showScreen('s0');
}

// ── Helpers ───────────────────────────────────────────────────
function nowString() {
    return new Date().toLocaleString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
    }) + ' WIB';
}

function showToast(msg) {
    let el = document.getElementById('_kToast');
    if (!el) {
        el = document.createElement('div');
        el.id = '_kToast';
        el.style.cssText =
            'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);' +
            'background:#181D35;color:#fff;font-size:13px;padding:10px 20px;' +
            'border-radius:10px;z-index:9999;opacity:0;transition:opacity .25s;' +
            'pointer-events:none;white-space:nowrap;';
        document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.opacity = '1';
    clearTimeout(el._t);
    el._t = setTimeout(() => { el.style.opacity = '0'; }, 2400);
}
</script>

@endsection