@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('page_title', 'Dashboard')

@section('content')

{{-- ── Page Header ── --}}
<div class="page-head">
    <div>
        <div class="page-title">Halo, {{ Auth::user()->name }} 👋</div>
        <div class="page-sub">Pantau kendaraan dan riwayat parkir kampus kamu di sini</div>
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
            Daftarkan Kendaraan
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
        <div class="stat-card-val">2</div>
        <div class="stat-card-label">Kendaraan Terdaftar</div>
        <div class="stat-card-delta delta-neu">—</div>
        <div class="stat-card-accent" style="background:#3B6FD4;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#ECFDF3;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#12B76A" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M8 17V7h5a3 3 0 0 1 0 6H8"/>
                <line x1="8" y1="13" x2="14" y2="13"/>
            </svg>
        </div>
        <div class="stat-card-val">1</div>
        <div class="stat-card-label">Sedang Parkir</div>
        <div class="stat-card-delta delta-up">↑ Aktif</div>
        <div class="stat-card-accent" style="background:#12B76A;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FFFAEB;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#F79009" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="stat-card-val">14</div>
        <div class="stat-card-label">Total Riwayat Parkir</div>
        <div class="stat-card-delta delta-up">↑ 3 minggu ini</div>
        <div class="stat-card-accent" style="background:#F79009;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEF3F2;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="stat-card-val">0</div>
        <div class="stat-card-label">Pelanggaran Saya</div>
        <div class="stat-card-delta delta-neu">Aman 🎉</div>
        <div class="stat-card-accent" style="background:#D92D20;"></div>
    </div>

</div>

{{-- ── Main Content Grid ── --}}
<div class="content-grid">

    {{-- Riwayat Parkir --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Riwayat Parkir Terkini</div>
                <div class="card-sub">Aktivitas 7 hari terakhir</div>
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
                    <th>Zona / Slot</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
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
                                <div class="veh-type">Motor · Honda Beat</div>
                            </div>
                        </div>
                    </td>
                    <td>A1 — 03</td>
                    <td>07:45</td>
                    <td>—</td>
                    <td><span class="badge badge-in">Parkir</span></td>
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
                                <div class="veh-plate">W 1234 AB</div>
                                <div class="veh-type">Motor · Honda Beat</div>
                            </div>
                        </div>
                    </td>
                    <td>B2 — 07</td>
                    <td>08:00</td>
                    <td>14:30</td>
                    <td><span class="badge badge-out">Selesai</span></td>
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
                                <div class="veh-plate">W 1234 AB</div>
                                <div class="veh-type">Motor · Honda Beat</div>
                            </div>
                        </div>
                    </td>
                    <td>A1 — 10</td>
                    <td>07:30</td>
                    <td>16:00</td>
                    <td><span class="badge badge-out">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Peta Slot & Status Parkir Sekarang --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Status Parkir Sekarang</div>
                <div class="card-sub">Zona A · Kendaraan kamu di slot A1-03</div>
            </div>
            <a href="#" class="card-action">Semua zona</a>
        </div>

        <div class="slot-map-wrap">

            <div class="mini-stats">
                <div class="mini-stat">
                    <div class="mini-stat-val" style="color:#1A4BAD;">1</div>
                    <div class="mini-stat-label">Kendaraanku</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val" style="color:#12B76A;">37</div>
                    <div class="mini-stat-label">Slot Kosong</div>
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
                    <div class="leg-dot" style="background:#E8F0FB;border:2px solid #1A4BAD;"></div>
                    Kendaraanku
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

    {{-- Log Aktivitas Saya --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Parkir Saya</div>
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
                        <div class="act-meta">Zona A, Slot 03 · Hari ini</div>
                    </div>
                    <div class="act-time">07:45</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#8A93AE;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Kendaraan keluar — W 1234 AB</div>
                        <div class="act-meta">Zona B, Slot 07 · Kemarin</div>
                    </div>
                    <div class="act-time">14:30</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#12B76A;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Kendaraan masuk — W 1234 AB</div>
                        <div class="act-meta">Zona B, Slot 07 · Kemarin</div>
                    </div>
                    <div class="act-time">08:00</div>
                </div>

                <div class="act-item">
                    <div class="act-dot-wrap">
                        <div class="act-dot" style="background:#8A93AE;"></div>
                    </div>
                    <div class="act-content">
                        <div class="act-title">Kendaraan keluar — W 1234 AB</div>
                        <div class="act-meta">Zona A, Slot 10 · 2 hari lalu</div>
                    </div>
                    <div class="act-time">16:00</div>
                </div>

            </div>
        </div>
    </div>

    {{-- Ketersediaan Zona --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Ketersediaan Area Parkir</div>
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

    {{-- Info Profil Mahasiswa --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Profil Saya</div>
                <div class="card-sub">Data akademik terdaftar</div>
            </div>
        </div>
        <div class="card-body">
            <div class="officer-list">

                <div class="officer-item">
                    @php
                        $nameParts = explode(' ', Auth::user()->name);
                        $initials  = strtoupper($nameParts[0][0] ?? '') . strtoupper(end($nameParts)[0] ?? '');
                    @endphp
                    <div class="off-av" style="background:#1A4BAD;">{{ $initials }}</div>
                    <div style="flex:1">
                        <div class="off-name">{{ Auth::user()->name }}</div>
                        <div class="off-zone">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="off-status" style="background:#12B76A;box-shadow:0 0 6px #12B76A;"></div>
                </div>

            </div>

            <div style="margin-top:16px;display:flex;flex-direction:column;gap:10px;">

                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:var(--muted)">NIM</span>
                    <span style="font-weight:600;color:var(--text)">
                        {{ Auth::user()->mahasiswa->nim ?? '—' }}
                    </span>
                </div>

                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:var(--muted)">Jurusan</span>
                    <span style="font-weight:600;color:var(--text)">
                        {{ Auth::user()->mahasiswa->department->name ?? '—' }}
                    </span>
                </div>

                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:var(--muted)">Program Studi</span>
                    <span style="font-weight:600;color:var(--text)">
                        {{ Auth::user()->mahasiswa->studyProgram->name ?? '—' }}
                    </span>
                </div>

                <div style="display:flex;justify-content:space-between;font-size:13px;">
                    <span style="color:var(--muted)">Angkatan</span>
                    <span style="font-weight:600;color:var(--text)">
                        {{ Auth::user()->mahasiswa->angkatan ?? '—' }}
                    </span>
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
        {id:'A3', status:'mine'},  {id:'A4', status:'free'},   {{-- slot milik mahasiswa --}}
        {id:'A5', status:'taken'}, {id:'A6', status:'taken'},
        {id:'A7', status:'free'}, {id:'A8', status:'blocked'},
    ];

    const slotsB = [
        {id:'A9',  status:'free'},    {id:'A10', status:'taken'},
        {id:'A11', status:'free'},    {id:'A12', status:'blocked'},
        {id:'A13', status:'taken'},   {id:'A14', status:'free'},
        {id:'A15', status:'taken'},   {id:'A16', status:'taken'},
    ];

    function buildRow(data, elId) {
        const el = document.getElementById(elId);
        if (!el) return;
        data.forEach(s => {
            const d       = document.createElement('div');
            const labels  = { taken:'Terisi', free:'Kosong', blocked:'Diblokir', mine:'Kendaraanku' };
            d.className   = 'sl ' + (s.status === 'mine' ? 'taken mine-slot' : s.status);
            d.innerText   = s.id;
            d.title       = s.id + ' — ' + (labels[s.status] ?? s.status);
            if (s.status === 'mine') {
                d.style.outline      = '2.5px solid #1A4BAD';
                d.style.outlineOffset = '2px';
                d.style.background   = '#E8F0FB';
                d.style.color        = '#1A4BAD';
                d.style.fontWeight   = '700';
            }
            el.appendChild(d);
        });
    }

    buildRow(slotsA, 'slotRowA');
    buildRow(slotsB, 'slotRowB');

    // ── Bar Chart (frekuensi parkir per jam) ──
    const hourData = [1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0];
    const hours    = Array.from({length:24}, (_, i) => String(i).padStart(2,'0'));
    const maxV     = Math.max(...hourData, 1);
    const ca       = document.getElementById('chartArea');

    if (ca) {
        hourData.forEach((v, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'bar-wrap';

            const bar = document.createElement('div');
            bar.className       = 'bar';
            bar.style.height    = (v / maxV * 120) + 'px';
            bar.style.background = v > 0
                ? 'linear-gradient(180deg,#3B6FD4,#1A4BAD)'
                : 'linear-gradient(180deg,#E8EEFF,#D0D8F0)';
            bar.title = hours[i] + ':00 — ' + v + ' sesi';

            const label = document.createElement('div');
            label.className   = 'bar-label';
            label.textContent = i % 3 === 0 ? hours[i] : '';

            wrap.appendChild(bar);
            wrap.appendChild(label);
            ca.appendChild(wrap);
        });
    }
</script>
@endpush