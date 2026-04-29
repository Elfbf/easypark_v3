@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')

@section('content')

{{-- ── Page Header ── --}}
<div class="page-head">
    <div>
        <div class="page-title">Selamat datang, Admin 👋</div>
        <div class="page-sub">Pantau kondisi parkir kampus hari ini secara real-time</div>
    </div>
    <div class="page-head-actions">
        <button class="btn-outline">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Ekspor
        </button>
        <button class="btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Kendaraan
        </button>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#E8F0FB;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2">
                <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z"/>
                <circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/>
            </svg>
        </div>
        <div class="stat-card-val">120</div>
        <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
        <div class="stat-card-delta delta-up">↑ 8%</div>
        <div class="stat-card-accent" style="background:#3B6FD4;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FFFAEB;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#F79009" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M3 9h18M9 21V9"/>
            </svg>
        </div>
        <div class="stat-card-val">80</div>
        <div class="stat-card-label">Slot Terisi Sekarang</div>
        <div class="stat-card-delta delta-neu">±2%</div>
        <div class="stat-card-accent" style="background:#F79009;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#ECFDF3;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#12B76A" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M3 9h18M9 21V9"/>
                <line x1="14" y1="15" x2="18" y2="15"/>
                <line x1="14" y1="18" x2="16" y2="18"/>
            </svg>
        </div>
        <div class="stat-card-val">40</div>
        <div class="stat-card-label">Slot Kosong Tersedia</div>
        <div class="stat-card-delta delta-down">↓ 12%</div>
        <div class="stat-card-accent" style="background:#12B76A;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEF3F2;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="stat-card-val">3</div>
        <div class="stat-card-label">Pelanggaran Tercatat</div>
        <div class="stat-card-delta delta-up">↑ 1</div>
        <div class="stat-card-accent" style="background:#D92D20;"></div>
    </div>

</div>

{{-- ── Main Content Grid ── --}}
<div class="content-grid">

    {{-- Tabel Aktivitas --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Masuk / Keluar Terkini</div>
                <div class="card-sub">Diperbarui otomatis setiap 30 detik</div>
            </div>
            <a href="#" class="card-action">
                Lihat semua
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px;">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Pengemudi</th>
                    <th>Zona / Slot</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="td-vehicle">
                            <div class="veh-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z"/>
                                    <circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="veh-plate">W 1234 AB</div>
                                <div class="veh-type">Motor</div>
                            </div>
                        </div>
                    </td>
                    <td>Alief</td>
                    <td>A1 — 01</td>
                    <td>08:30</td>
                    <td><span class="badge badge-in">Masuk</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="td-vehicle">
                            <div class="veh-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                                    <path d="M16 8h4l3 3v5h-7V8z"/>
                                    <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="veh-plate">L 5678 CD</div>
                                <div class="veh-type">Mobil</div>
                            </div>
                        </div>
                    </td>
                    <td>Budi</td>
                    <td>A1 — 02</td>
                    <td>09:10</td>
                    <td><span class="badge badge-out">Keluar</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="td-vehicle">
                            <div class="veh-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z"/>
                                    <circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/>
                                </svg>
                            </div>
                            <div>
                                <div class="veh-plate">N 9012 EF</div>
                                <div class="veh-type">Motor</div>
                            </div>
                        </div>
                    </td>
                    <td>Citra</td>
                    <td>B2 — 05</td>
                    <td>09:45</td>
                    <td><span class="badge badge-warn">Pelanggaran</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Peta Slot --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Peta Slot — Zona A</div>
                <div class="card-sub">100 slot total · 60 terisi · 40 kosong</div>
            </div>
            <a href="#" class="card-action">Semua zona</a>
        </div>

        <div class="slot-map-wrap">

            <div class="mini-stats">
                <div class="mini-stat">
                    <div class="mini-stat-val" style="color:#1A4BAD;">60</div>
                    <div class="mini-stat-label">Terisi</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val" style="color:#C9960F;">40</div>
                    <div class="mini-stat-label">Kosong</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val" style="color:#D92D20;">5</div>
                    <div class="mini-stat-label">Blokir</div>
                </div>
            </div>

            <div class="chart-area" id="chartArea"></div>

            <div class="zone-label" style="margin-top:14px;">Baris 1 — 2</div>
            <div class="slot-row" id="slotRowA"></div>

            <div class="zone-label">Baris 3 — 4</div>
            <div class="slot-row" id="slotRowB"></div>

            <div class="slot-legend">
                <div class="leg-item">
                    <div class="leg-dot" style="background:rgba(59,111,212,.25);border:1.5px solid #3B6FD4;"></div>
                    Terisi
                </div>
                <div class="leg-item">
                    <div class="leg-dot" style="background:rgba(232,183,64,.2);border:1.5px solid #E8B740;"></div>
                    Kosong
                </div>
                <div class="leg-item">
                    <div class="leg-dot" style="background:#FEF3F2;border:1.5px solid #D92D20;"></div>
                    Blokir
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Bottom Grid ── --}}
<div class="bottom-grid">

    {{-- Log Aktivitas --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Log Aktivitas Sistem</div>
                <div class="card-sub">Real-time</div>
            </div>
        </div>
        <div class="card-body">
            <div class="activity-list">

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#12B76A;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Kendaraan masuk — W 1234 AB</div>
                        <div class="act-meta">Zona A, Slot 01 · Alief</div>
                    </div>
                    <div class="act-time">08:30</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#8A93AE;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Kendaraan keluar — L 5678 CD</div>
                        <div class="act-meta">Zona A, Slot 02 · Budi</div>
                    </div>
                    <div class="act-time">09:10</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#D92D20;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Pelanggaran tercatat — N 9012 EF</div>
                        <div class="act-meta">Zona B, Slot 05 · Citra</div>
                    </div>
                    <div class="act-time">09:45</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#F79009;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Slot diblokir — Zona B, 03</div>
                        <div class="act-meta">Oleh sistem otomatis</div>
                    </div>
                    <div class="act-time">10:00</div>
                </div>

            </div>
        </div>
    </div>

    {{-- Kapasitas Zona --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Kapasitas per Zona</div>
                <div class="card-sub">Update langsung</div>
            </div>
        </div>
        <div class="card-body">
            <div class="zone-cards">

                <div class="zone-item">
                    <div class="zone-top">
                        <div class="zone-name">Zona A</div>
                        <div class="zone-count">60 / 100 slot</div>
                    </div>
                    <div class="progress">
                        <div class="progress-fill" style="width:60%;background:#3B6FD4;"></div>
                    </div>
                </div>

                <div class="zone-item">
                    <div class="zone-top">
                        <div class="zone-name">Zona B</div>
                        <div class="zone-count">30 / 100 slot</div>
                    </div>
                    <div class="progress">
                        <div class="progress-fill" style="width:30%;background:#12B76A;"></div>
                    </div>
                </div>

                <div class="zone-item">
                    <div class="zone-top">
                        <div class="zone-name">Zona C</div>
                        <div class="zone-count">85 / 100 slot</div>
                    </div>
                    <div class="progress">
                        <div class="progress-fill" style="width:85%;background:#F79009;"></div>
                    </div>
                </div>

                <div class="zone-item">
                    <div class="zone-top">
                        <div class="zone-name">Zona D</div>
                        <div class="zone-count">98 / 100 slot</div>
                    </div>
                    <div class="progress">
                        <div class="progress-fill" style="width:98%;background:#D92D20;"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Petugas Berjaga --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Petugas Berjaga</div>
                <div class="card-sub">Shift pagi · 4 aktif</div>
            </div>
        </div>
        <div class="card-body">
            <div class="officer-list">

                <div class="officer-item">
                    <div class="off-av" style="background:#0E2F7A;">AL</div>
                    <div>
                        <div class="off-name">Alief Chandra</div>
                        <div class="off-zone">Zona A</div>
                    </div>
                    <div class="off-status" style="background:#12B76A;box-shadow:0 0 6px #12B76A;"></div>
                </div>

                <div class="officer-item">
                    <div class="off-av" style="background:#1A4BAD;">BD</div>
                    <div>
                        <div class="off-name">Budi Santoso</div>
                        <div class="off-zone">Zona B</div>
                    </div>
                    <div class="off-status" style="background:#12B76A;box-shadow:0 0 6px #12B76A;"></div>
                </div>

                <div class="officer-item">
                    <div class="off-av" style="background:#C9960F;">CT</div>
                    <div>
                        <div class="off-name">Citra Dewi</div>
                        <div class="off-zone">Zona C</div>
                    </div>
                    <div class="off-status" style="background:#12B76A;box-shadow:0 0 6px #12B76A;"></div>
                </div>

                <div class="officer-item">
                    <div class="off-av" style="background:#4A5272;">DN</div>
                    <div>
                        <div class="off-name">Dani Prasetyo</div>
                        <div class="off-zone">Zona D</div>
                    </div>
                    <div class="off-status" style="background:#8A93AE;"></div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // ── Slot Map ──
    const slotsA = [
        {id:'A1', status:'taken'}, {id:'A2', status:'free'},
        {id:'A3', status:'blocked'}, {id:'A4', status:'free'},
        {id:'A5', status:'taken'}, {id:'A6', status:'taken'},
        {id:'A7', status:'free'}, {id:'A8', status:'taken'},
    ];

    const slotsB = [
        {id:'A9', status:'free'}, {id:'A10', status:'taken'},
        {id:'A11', status:'free'}, {id:'A12', status:'blocked'},
        {id:'A13', status:'taken'}, {id:'A14', status:'free'},
        {id:'A15', status:'taken'}, {id:'A16', status:'taken'},
    ];

    function buildRow(data, elId) {
        const el = document.getElementById(elId);
        if (!el) return;
        data.forEach(s => {
            const d = document.createElement('div');
            d.className = 'sl ' + s.status;
            d.innerText = s.id;
            d.title = s.id + ' — ' + (s.status === 'taken' ? 'Terisi' : s.status === 'free' ? 'Kosong' : 'Diblokir');
            el.appendChild(d);
        });
    }

    buildRow(slotsA, 'slotRowA');
    buildRow(slotsB, 'slotRowB');

    // ── Bar Chart ──
    const hourData = [2, 4, 6, 8, 10, 6, 4, 3, 5, 7, 8, 6];
    const hours    = ['06','07','08','09','10','11','12','13','14','15','16','17'];
    const maxV     = Math.max(...hourData);
    const ca       = document.getElementById('chartArea');

    if (ca) {
        hourData.forEach((v, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'bar-wrap';

            const bar = document.createElement('div');
            bar.className = 'bar';
            bar.style.height      = (v / maxV * 120) + 'px';
            bar.style.background  = v === maxV
                ? 'linear-gradient(180deg,#3B6FD4,#1A4BAD)'
                : 'linear-gradient(180deg,#93B3EE,#C0D3F5)';
            bar.title = hours[i] + ':00 — ' + v + ' kendaraan';

            const label = document.createElement('div');
            label.className   = 'bar-label';
            label.textContent = hours[i];

            wrap.appendChild(bar);
            wrap.appendChild(label);
            ca.appendChild(wrap);
        });
    }
</script>
@endpush