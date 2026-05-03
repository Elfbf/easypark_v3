@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('page_title', 'Dashboard')

@section('content')

    {{-- ── Alert Kapasitas Penuh ── --}}
    @if ($capacityAlert)
        <div class="alert-capacity" id="alertCapacity">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                style="width:18px;height:18px;flex-shrink:0;">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <span>
                <strong>Peringatan!</strong> Kapasitas parkir hampir penuh —
                hanya tersisa <strong>{{ $freeSlots }}</strong> slot
                ({{ $totalSlots > 0 ? round(($freeSlots / $totalSlots) * 100) : 0 }}%).
            </span>
            <button onclick="document.getElementById('alertCapacity').remove()"
                style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;padding:0 4px;font-size:18px;line-height:1;">
                &times;
            </button>
        </div>
    @endif

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Selamat datang, Petugas 👋</div>
            <div class="page-sub">Pantau kondisi parkir kampus hari ini secara real-time</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="live-badge" id="liveBadge">
                <span class="live-dot"></span> Live
            </div>
        </div>
    </div>


    {{-- ════════════════════════════════════════════════
         GRUP 1 — Ringkasan Cepat (stat cards)
    ════════════════════════════════════════════════ --}}
    <div class="stats-grid" id="statsGrid">

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#E8F0FB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2">
                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
                    <circle cx="7.5" cy="17.5" r="2.5" /><circle cx="16.5" cy="17.5" r="2.5" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-todayIn">{{ $todayIn }}</div>
            <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#3B6FD4;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#FFFAEB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#F79009" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-takenSlots">{{ $takenSlots }}</div>
            <div class="stat-card-label">Slot Terisi Sekarang</div>
            <div class="stat-card-delta delta-neu" id="sc-takenPct">
                {{ $totalSlots > 0 ? round(($takenSlots / $totalSlots) * 100) : 0 }}% terisi
            </div>
            <div class="stat-card-accent" style="background:#F79009;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#ECFDF3;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#12B76A" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                    <line x1="14" y1="15" x2="18" y2="15" />
                    <line x1="14" y1="18" x2="16" y2="18" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-freeSlots">{{ $freeSlots }}</div>
            <div class="stat-card-label">Slot Kosong Tersedia</div>
            <div class="stat-card-delta {{ $freeSlots < 10 ? 'delta-up' : 'delta-down' }}" id="sc-freePct">
                {{ $totalSlots > 0 ? round(($freeSlots / $totalSlots) * 100) : 0 }}% tersedia
            </div>
            <div class="stat-card-accent" style="background:#12B76A;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#FEF3F2;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-todayCompleted">{{ $todayCompleted }}</div>
            <div class="stat-card-label">Selesai Parkir Hari Ini</div>
            <div class="stat-card-delta delta-neu" id="sc-completedPct">
                {{ $todayIn > 0 ? round(($todayCompleted / $todayIn) * 100) : 0 }}% dari masuk
            </div>
            <div class="stat-card-accent" style="background:#D92D20;"></div>
        </div>

    </div>


    {{-- ════════════════════════════════════════════════
         GRUP 2 (kiri) + GRUP 3 (kanan)
    ════════════════════════════════════════════════ --}}
    <div class="g2-g3-grid" style="margin-bottom:24px;">

        {{-- ── Kiri: Kondisi Slot Saat Ini ── --}}
        <div class="card" id="slotConditionCard">
            <div class="card-header">
                <div>
                    <div class="card-title">Kondisi Slot Saat Ini</div>
                    <div class="card-sub">Ocupansi real-time &amp; peta slot per zona</div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:11px;color:#8A93AE;">
                        {{ $totalSlots }} total &middot;
                        <span id="g2-taken">{{ $takenSlots }}</span> terisi &middot;
                        <span id="g2-free">{{ $freeSlots }}</span> kosong
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="slot-condition-grid">
                    <div class="slot-live-panel" id="slotLivePanel"></div>
                    <div class="slot-divider"></div>
                    <div class="slot-map-panel" id="slotMapPanel"></div>
                </div>
            </div>
        </div>

        {{-- ── Kanan: Aktivitas Terkini ── --}}
        <div class="card card-flex">
            <div class="card-header">
                <div>
                    <div class="card-title">Aktivitas Masuk / Keluar Terkini</div>
                    <div class="card-sub">Data terkini dari server</div>
                </div>
            </div>
            <div class="card-scroll-body">
                <table class="data-table" id="activityTable">
                    <thead>
                        <tr>
                            <th style="width:36px;">#</th>
                            <th>Kendaraan</th>
                            <th>Pengemudi</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="activityBody">
                        @forelse($recentActivities as $i => $activity)
                            @php
                                $rec         = $activity['record'];
                                $eventType   = $activity['type'];
                                $eventTime   = $activity['time'];
                                $vehTypeName = strtolower(
                                    $rec->vehicle && $rec->vehicle->type ? $rec->vehicle->type->name : 'motor'
                                );
                                $isMotor  = $vehTypeName === 'motor';
                                $vehLabel = trim(implode(' ', array_filter([
                                    $rec->vehicle && $rec->vehicle->type  ? $rec->vehicle->type->name  : null,
                                    $rec->vehicle && $rec->vehicle->brand ? $rec->vehicle->brand->name : null,
                                    $rec->vehicle && $rec->vehicle->model ? $rec->vehicle->model->name : null,
                                ]))) ?: 'Kendaraan';
                                $time    = $eventTime ? $eventTime->format('H:i') : '-';
                                $fotoUrl = $rec->face_photo ? asset('storage/' . $rec->face_photo) : null;
                            @endphp
                            <tr data-row data-type="{{ $vehTypeName }}">
                                <td style="color:#8A93AE;font-size:12px;font-weight:600;">{{ $i + 1 }}</td>
                                <td>
                                    <div class="td-vehicle">
                                        <div class="veh-icon">
                                            @if ($isMotor)
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
                                                    <circle cx="7.5" cy="17.5" r="2.5" /><circle cx="16.5" cy="17.5" r="2.5" />
                                                </svg>
                                            @else
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="1" y="3" width="15" height="13" rx="2" />
                                                    <path d="M16 8h4l3 3v5h-7V8z" />
                                                    <circle cx="5.5" cy="18.5" r="2.5" /><circle cx="18.5" cy="18.5" r="2.5" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="veh-plate">{{ $rec->plate_number }}</div>
                                            <div class="veh-type">{{ $vehLabel }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        @if ($fotoUrl)
                                            <img src="{{ $fotoUrl }}" alt="foto"
                                                style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:1.5px solid #E2E6F0;flex-shrink:0;">
                                        @else
                                            <div style="width:30px;height:30px;border-radius:50%;background:#E8F0FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="#3B6FD4" stroke-width="2" style="width:14px;height:14px;">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            </div>
                                        @endif
                                        <span>{{ $rec->vehicle && $rec->vehicle->user ? $rec->vehicle->user->name : '-' }}</span>
                                    </div>
                                </td>
                                <td>{{ $time }}</td>
                                <td>
                                    @if ($eventType === 'in')
                                        <span class="badge badge-in">Masuk</span>
                                    @else
                                        <span class="badge badge-out">Keluar</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="5" style="text-align:center;color:#8A93AE;padding:20px 0;font-size:13px;">
                                    Belum ada aktivitas hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- /.g2-g3-grid --}}

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
    // ════════════════════════════════════════
    //  DATA AWAL dari PHP
    // ════════════════════════════════════════
    let zonesData    = @json($zonesWithSlots);
    const totalSlots = {{ $totalSlots }};


    // ════════════════════════════════════════
    //  HELPER UMUM
    // ════════════════════════════════════════
    function setText(id, val) { $('#' + id).text(val); }
    function pct(part, total) { return total > 0 ? Math.round((part / total) * 100) : 0; }


    // ════════════════════════════════════════
    //  GRUP 2 — Live Ring
    // ════════════════════════════════════════
    function renderLiveRing() {
        const taken = parseInt($('#sc-takenSlots').text()) || 0;
        const free  = parseInt($('#sc-freeSlots').text())  || 0;
        const total = taken + free;
        const p     = total > 0 ? Math.round((taken / total) * 100) : 0;
        const color = p >= 90 ? '#D92D20' : p >= 70 ? '#F79009' : '#12B76A';
        const circ  = 2 * Math.PI * 45;
        const dash  = (p / 100) * circ;

        $('#slotLivePanel').html(`
            <div style="display:flex;flex-direction:column;align-items:center;gap:18px;">
                <div style="position:relative;width:130px;height:130px;">
                    <svg viewBox="0 0 100 100" width="130" height="130" style="transform:rotate(-90deg);">
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#F0F2F8" stroke-width="8"/>
                        <circle cx="50" cy="50" r="45" fill="none" stroke="${color}" stroke-width="8"
                            stroke-dasharray="${dash} ${circ - dash}" stroke-linecap="round"
                            style="transition:stroke-dasharray .8s ease;"/>
                    </svg>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;line-height:1.3;">
                        <div style="font-size:26px;font-weight:800;color:${color};">${p}%</div>
                        <div style="font-size:10px;color:#8A93AE;">terisi</div>
                    </div>
                </div>
                <div style="display:flex;gap:24px;">
                    <div style="text-align:center;">
                        <div style="font-weight:700;color:#1A2340;font-size:16px;">${taken}</div>
                        <div style="color:#8A93AE;font-size:11px;margin-top:2px;">Terisi</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-weight:700;color:#1A2340;font-size:16px;">${free}</div>
                        <div style="color:#8A93AE;font-size:11px;margin-top:2px;">Kosong</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-weight:700;color:#1A2340;font-size:16px;">${total}</div>
                        <div style="color:#8A93AE;font-size:11px;margin-top:2px;">Total</div>
                    </div>
                </div>
            </div>`);
    }


    // ════════════════════════════════════════
    //  GRUP 2 — Map Slot per Zona
    // ════════════════════════════════════════
    let g2ActiveZone = 0;

    function renderMapSlotPanel() {
        if (!zonesData.length) {
            $('#slotMapPanel').html(
                `<div style="text-align:center;color:#8A93AE;padding:24px 0;font-size:13px;">Belum ada data zona.</div>`
            );
            return;
        }
        buildMapSlot(g2ActiveZone);
    }

    function buildMapSlot(idx) {
        const z = zonesData[idx];
        if (!z) return;

        const total = z.total || 0;
        const taken = z.taken || 0;
        const free  = z.available || 0;
        const maint = z.maintenance || 0;
        const p     = total > 0 ? Math.round((taken / total) * 100) : 0;
        const color = p >= 90 ? '#D92D20' : p >= 70 ? '#F79009' : '#12B76A';

        let tabs = `<div style="display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap;">`;
        zonesData.forEach(function(zone, i) {
            const active = i === idx;
            tabs += `<button onclick="window._g2Zone(${i})"
                style="padding:4px 12px;border-radius:20px;border:1.5px solid ${active ? '#3B6FD4' : '#E2E6F0'};
                background:${active ? '#3B6FD4' : '#F8F9FC'};color:${active ? '#fff' : '#8A93AE'};
                font-size:11px;font-weight:600;cursor:pointer;transition:all .15s;">${zone.name}</button>`;
        });
        tabs += `</div>`;

        const stats = `
            <div style="display:flex;gap:16px;margin-bottom:12px;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:10px;height:10px;border-radius:3px;background:rgba(59,111,212,.25);border:1.5px solid #3B6FD4;"></div>
                    <span style="font-size:11px;color:#4A5272;">Terisi <strong style="color:#1A2340;">${taken}</strong></span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:10px;height:10px;border-radius:3px;background:rgba(18,183,106,.2);border:1.5px solid #12B76A;"></div>
                    <span style="font-size:11px;color:#4A5272;">Kosong <strong style="color:#1A2340;">${free}</strong></span>
                </div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <div style="width:10px;height:10px;border-radius:3px;background:#FEF3F2;border:1.5px solid #D92D20;"></div>
                    <span style="font-size:11px;color:#4A5272;">Maintenance <strong style="color:#1A2340;">${maint}</strong></span>
                </div>
                <div style="margin-left:auto;font-size:11px;font-weight:700;color:${color};">${p}% terisi</div>
            </div>`;

        const bar = `
            <div style="height:6px;background:#F0F2F8;border-radius:99px;overflow:hidden;margin-bottom:14px;">
                <div style="height:100%;width:${p}%;background:${color};border-radius:99px;transition:width .6s ease;"></div>
            </div>`;

        let grid = `<div style="display:flex;flex-wrap:wrap;gap:5px;max-height:180px;overflow-y:auto;padding-right:2px;">`;
        if (!z.slots || !z.slots.length) {
            grid += `<div style="color:#8A93AE;font-size:12px;padding:8px 0;">Belum ada slot.</div>`;
        } else {
            z.slots.forEach(function(s) {
                const bg = s.status === 'taken'
                    ? 'background:rgba(59,111,212,.18);border-color:#3B6FD4;color:#1A4BAD;'
                    : s.status === 'maintenance'
                    ? 'background:#FEF3F2;border-color:#D92D20;color:#D92D20;'
                    : 'background:rgba(18,183,106,.12);border-color:#12B76A;color:#0A7A47;';
                const label = s.status === 'taken' ? 'Terisi' : s.status === 'free' ? 'Kosong' : 'Maintenance';
                grid += `<div title="${s.id} — ${label}"
                    style="width:36px;height:30px;border-radius:5px;border:1.5px solid;display:flex;align-items:center;
                    justify-content:center;font-size:9px;font-weight:600;cursor:default;${bg}">${s.id}</div>`;
            });
        }
        grid += `</div>`;

        $('#slotMapPanel').html(tabs + stats + bar + grid);
        window._g2Zone = function(i) { g2ActiveZone = i; buildMapSlot(i); };
    }


    // ════════════════════════════════════════
    //  Render awal
    // ════════════════════════════════════════
    renderLiveRing();
    renderMapSlotPanel();

    </script>

    <style>
        /* ── Alert kapasitas ── */
        .alert-capacity {
            display: flex; align-items: center; gap: 10px;
            background: #FEF3F2; border: 1.5px solid #FDA29B;
            border-radius: 10px; padding: 12px 16px;
            margin-bottom: 20px; color: #912018; font-size: 13px;
        }

        /* ── Live badge ── */
        .live-badge {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 600; color: #12B76A;
            background: #ECFDF3; border: 1.5px solid #A6F4C5;
            border-radius: 20px; padding: 4px 10px; transition: opacity .3s;
        }
        .live-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #12B76A; animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; } 50% { opacity: .3; }
        }

        /* ── Table ── */
        .data-table th { padding: 12px 14px; white-space: nowrap; }
        .data-table td { padding: 12px 14px; }

        /* ── Slot zona toggle ── */
        .toggle-btn {
            padding: 5px 12px; border-radius: 7px;
            border: 1.5px solid #E2E6F0; background: #F8F9FC;
            color: #8A93AE; font-size: 11px; font-weight: 500;
            cursor: pointer; transition: all .15s;
        }
        .toggle-btn.active { background: #3B6FD4; border-color: #3B6FD4; color: #fff; }
        .toggle-btn:hover:not(.active) { border-color: #3B6FD4; color: #1A4BAD; }

        /* ── GRUP 2+3 berdampingan ── */
        .g2-g3-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start; }
        .slot-condition-grid { display: grid; grid-template-columns: 180px 1px 1fr; gap: 0; min-height: 280px; }
        .slot-live-panel { padding-right: 20px; display: flex; flex-direction: column; justify-content: center; }
        .slot-divider { background: #F0F2F8; margin: 4px 0; }
        .slot-map-panel { padding-left: 20px; min-width: 0; }

        /* ── Responsive ── */
        @media (max-width: 1100px) {
            .g2-g3-grid          { grid-template-columns: 1fr; }
            .slot-condition-grid { grid-template-columns: 1fr; grid-template-rows: auto auto auto; }
            .slot-live-panel     { padding-right: 0; padding-bottom: 20px; }
            .slot-divider        { height: 1px; width: 100%; margin: 0; }
            .slot-map-panel      { padding-left: 0; padding-top: 20px; }
        }
    </style>
@endpush