@extends('layouts.app')

@section('title', 'Dashboard Admin')
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
            <div class="page-title">Selamat datang, Admin 👋</div>
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

        {{-- Kendaraan Masuk Hari Ini --}}
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#E8F0FB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2">
                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
                    <circle cx="7.5" cy="17.5" r="2.5" />
                    <circle cx="16.5" cy="17.5" r="2.5" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-todayIn">{{ $todayIn }}</div>
            <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#3B6FD4;"></div>
        </div>

        {{-- Slot Terisi --}}
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

        {{-- Slot Kosong --}}
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

        {{-- Selesai Parkir --}}
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
         GRUP 2 — Kondisi Slot Saat Ini (full width)
    ════════════════════════════════════════════════ --}}
    <div class="card" style="margin-bottom:24px;" id="slotConditionCard">
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


    {{-- ════════════════════════════════════════════════
         GRUP 3 — Aktivitas Terkini (full width)
    ════════════════════════════════════════════════ --}}
    <div class="card card-flex" style="margin-bottom:24px;">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Masuk / Keluar Terkini</div>
                <div class="card-sub">Diperbarui otomatis setiap 30 detik</div>
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
                            $rec = $activity['record'];
                            $eventType = $activity['type'];
                            $eventTime = $activity['time'];

                            $vehTypeName = strtolower(
                                $rec->vehicle && $rec->vehicle->type ? $rec->vehicle->type->name : 'motor',
                            );
                            $isMotor = $vehTypeName === 'motor';
                            $vehLabel =
                                trim(
                                    implode(
                                        ' ',
                                        array_filter([
                                            $rec->vehicle && $rec->vehicle->type ? $rec->vehicle->type->name : null,
                                            $rec->vehicle && $rec->vehicle->brand ? $rec->vehicle->brand->name : null,
                                            $rec->vehicle && $rec->vehicle->model ? $rec->vehicle->model->name : null,
                                        ]),
                                    ),
                                ) ?:
                                'Kendaraan';

                            $time = $eventTime ? $eventTime->format('H:i') : '-';
                            $fotoUrl = $rec->face_photo ? asset('storage/' . $rec->face_photo) : null;
                        @endphp
                        <tr data-row data-type="{{ $vehTypeName }}">
                            <td style="color:#8A93AE;font-size:12px;font-weight:600;">{{ $i + 1 }}</td>
                            <td>
                                <div class="td-vehicle">
                                    <div class="veh-icon">
                                        @if ($isMotor)
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
                                                <circle cx="7.5" cy="17.5" r="2.5" />
                                                <circle cx="16.5" cy="17.5" r="2.5" />
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <rect x="1" y="3" width="15" height="13" rx="2" />
                                                <path d="M16 8h4l3 3v5h-7V8z" />
                                                <circle cx="5.5" cy="18.5" r="2.5" />
                                                <circle cx="18.5" cy="18.5" r="2.5" />
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
                                        <div
                                            style="width:30px;height:30px;border-radius:50%;background:#E8F0FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#3B6FD4" stroke-width="2"
                                                style="width:14px;height:14px;">
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


    {{-- ════════════════════════════════════════════════
         GRUP 4 — Analitik (2 kolom)
    ════════════════════════════════════════════════ --}}
    <div class="analytics-grid" style="margin-bottom:24px;">

        {{-- Kiri: Kepadatan --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Kepadatan Kendaraan</div>
                    <div class="card-sub" id="chartSub">Kendaraan masuk hari ini</div>
                </div>
                <div style="display:flex;gap:6px;">
                    <button class="toggle-btn active" id="btnHarian" onclick="switchChart('harian')">Hari ini</button>
                    <button class="toggle-btn" id="btnMingguan" onclick="switchChart('mingguan')">7 Hari</button>
                </div>
            </div>
            <div class="card-body">
                <div id="hourChart" style="display:flex;align-items:flex-end;gap:4px;height:130px;padding:0 2px;"></div>
                <div id="hourLabels" style="display:flex;gap:4px;margin-top:6px;padding:0 2px;"></div>
            </div>
        </div>

        {{-- Kanan: Analitik Detail --}}
        <div class="card" id="insightCard">
            <div class="card-header">
                <div>
                    <div class="card-title">Analitik Detail</div>
                    <div class="card-sub" id="insightSub">Kepadatan 7 hari × jam</div>
                </div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <button class="toggle-btn active" onclick="switchInsight('heatmap')">Heatmap</button>
                    <button class="toggle-btn" onclick="switchInsight('durasi')">Durasi</button>
                    <button class="toggle-btn" onclick="switchInsight('zona')">Zona</button>
                </div>
            </div>
            <div class="card-body" id="insightBody" style="min-height:180px;"></div>
        </div>

    </div>

@endsection

@push('scripts')
    {{-- jQuery (pastikan belum di-load di layout, kalau sudah ada hapus baris ini) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // ════════════════════════════════════════
        //  DATA AWAL dari PHP
        // ════════════════════════════════════════
        let zonesData = @json($zonesWithSlots);
        const hourData = @json($hourlyData);
        const weeklyData = @json($weeklyData);
        const totalSlots = {{ $totalSlots }};


        // ════════════════════════════════════════
        //  HELPER
        // ════════════════════════════════════════
        function setText(id, val) {
            $('#' + id).text(val);
        }

        function pct(part, total) {
            return total > 0 ? Math.round((part / total) * 100) : 0;
        }


        // ════════════════════════════════════════
        //  GRUP 2 — Live Ring
        // ════════════════════════════════════════
        function renderLiveRing() {
            const taken = parseInt($('#sc-takenSlots').text()) || 0;
            const free = parseInt($('#sc-freeSlots').text()) || 0;
            const total = taken + free;
            const p = total > 0 ? Math.round((taken / total) * 100) : 0;
            const color = p >= 90 ? '#D92D20' : p >= 70 ? '#F79009' : '#12B76A';
            const circ = 2 * Math.PI * 45;
            const dash = (p / 100) * circ;

            const zonaRows = zonesData.map(z => {
                const zp = z.total > 0 ? Math.round((z.taken / z.total) * 100) : 0;
                const zc = zp >= 90 ? '#D92D20' : zp >= 70 ? '#F79009' : '#12B76A';
                return `
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:12px;gap:10px;">
                        <span style="color:#4A5272;white-space:nowrap;min-width:0;overflow:hidden;text-overflow:ellipsis;">${z.name}</span>
                        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                            <div style="width:72px;height:5px;background:#F0F2F8;border-radius:99px;overflow:hidden;">
                                <div style="height:100%;width:${zp}%;background:${zc};border-radius:99px;"></div>
                            </div>
                            <span style="font-weight:700;color:${zc};min-width:34px;text-align:right;">${zp}%</span>
                        </div>
                    </div>`;
            }).join('');

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
                    <div style="width:100%;display:flex;flex-direction:column;gap:10px;">
                        ${zonaRows || '<div style="text-align:center;color:#8A93AE;font-size:12px;">Belum ada zona.</div>'}
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
            const free = z.available || 0;
            const maint = z.maintenance || 0;
            const p = total > 0 ? Math.round((taken / total) * 100) : 0;
            const color = p >= 90 ? '#D92D20' : p >= 70 ? '#F79009' : '#12B76A';

            // Tabs zona
            let tabs = `<div style="display:flex;gap:6px;margin-bottom:14px;flex-wrap:wrap;">`;
            zonesData.forEach((zone, i) => {
                const active = i === idx;
                tabs += `<button onclick="window._g2Zone(${i})"
                    style="padding:4px 12px;border-radius:20px;border:1.5px solid ${active ? '#3B6FD4' : '#E2E6F0'};
                    background:${active ? '#3B6FD4' : '#F8F9FC'};color:${active ? '#fff' : '#8A93AE'};
                    font-size:11px;font-weight:600;cursor:pointer;transition:all .15s;">${zone.name}</button>`;
            });
            tabs += `</div>`;

            // Stats row
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

            // Progress bar
            const bar = `
                <div style="height:6px;background:#F0F2F8;border-radius:99px;overflow:hidden;margin-bottom:14px;">
                    <div style="height:100%;width:${p}%;background:${color};border-radius:99px;transition:width .6s ease;"></div>
                </div>`;

            // Slot grid
            let grid =
                `<div style="display:flex;flex-wrap:wrap;gap:5px;max-height:180px;overflow-y:auto;padding-right:2px;">`;
            if (!z.slots || !z.slots.length) {
                grid += `<div style="color:#8A93AE;font-size:12px;padding:8px 0;">Belum ada slot.</div>`;
            } else {
                z.slots.forEach(s => {
                    const bg = s.status === 'taken' ?
                        'background:rgba(59,111,212,.18);border-color:#3B6FD4;color:#1A4BAD;' :
                        s.status === 'maintenance' ?
                        'background:#FEF3F2;border-color:#D92D20;color:#D92D20;' :
                        'background:rgba(18,183,106,.12);border-color:#12B76A;color:#0A7A47;';
                    const label = s.status === 'taken' ? 'Terisi' : s.status === 'free' ? 'Kosong' : 'Maintenance';
                    grid += `<div title="${s.id} — ${label}"
                        style="width:36px;height:30px;border-radius:5px;border:1.5px solid;display:flex;align-items:center;
                        justify-content:center;font-size:9px;font-weight:600;cursor:default;${bg}">${s.id}</div>`;
                });
            }
            grid += `</div>`;

            $('#slotMapPanel').html(tabs + stats + bar + grid);

            window._g2Zone = (i) => {
                g2ActiveZone = i;
                buildMapSlot(i);
            };
        }


        // ════════════════════════════════════════
        //  GRUP 3 — Update Tabel Aktivitas in-place
        // ════════════════════════════════════════
        function _iconMotor() {
            return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z"/>
                <circle cx="7.5" cy="17.5" r="2.5"/><circle cx="16.5" cy="17.5" r="2.5"/>
            </svg>`;
        }

        function _iconCar() {
            return `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="3" width="15" height="13" rx="2"/>
                <path d="M16 8h4l3 3v5h-7V8z"/>
                <circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>
            </svg>`;
        }

        function _avatar(fotoUrl) {
            if (fotoUrl) {
                return `<img src="${fotoUrl}" alt="foto"
                    style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:1.5px solid #E2E6F0;flex-shrink:0;">`;
            }
            return `<div style="width:30px;height:30px;border-radius:50%;background:#E8F0FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#3B6FD4" stroke-width="2" style="width:14px;height:14px;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>`;
        }

        function updateActivityTable(activities) {
            const $tbody = $('#activityBody');

            if (!activities || !activities.length) {
                $tbody.html(`<tr id="emptyRow">
                    <td colspan="5" style="text-align:center;color:#8A93AE;padding:20px 0;font-size:13px;">
                        Belum ada aktivitas hari ini.
                    </td>
                </tr>`);
                return;
            }

            // Hapus baris empty jika ada
            $('#emptyRow').remove();

            const $rows = $tbody.find('tr[data-row]');

            // Tambah baris baru jika kurang
            while ($tbody.find('tr[data-row]').length < activities.length) {
                $tbody.append('<tr data-row></tr>');
            }

            // Hapus baris lebih jika data berkurang
            $tbody.find('tr[data-row]').slice(activities.length).remove();

            // Update isi tiap baris in-place
            $tbody.find('tr[data-row]').each(function(i) {
                const a = activities[i];
                $(this).attr('data-type', a.vehType).html(`
                    <td style="color:#8A93AE;font-size:12px;font-weight:600;">${i + 1}</td>
                    <td>
                        <div class="td-vehicle">
                            <div class="veh-icon">${a.vehType === 'motor' ? _iconMotor() : _iconCar()}</div>
                            <div>
                                <div class="veh-plate">${a.plate}</div>
                                <div class="veh-type">${a.vehLabel}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            ${_avatar(a.fotoUrl)}
                            <span>${a.name}</span>
                        </div>
                    </td>
                    <td>${a.time}</td>
                    <td>${a.type === 'in'
                        ? '<span class="badge badge-in">Masuk</span>'
                        : '<span class="badge badge-out">Keluar</span>'
                    }</td>`);
            });
        }


        // ════════════════════════════════════════
        //  GRUP 4 — Chart Kepadatan
        // ════════════════════════════════════════
        function renderChart(mode) {
            const $chart = $('#hourChart').empty();
            const $labels = $('#hourLabels').empty();

            if (mode === 'harian') {
                $('#chartSub').text('Kendaraan masuk hari ini');
                const values = Object.values(hourData);
                const maxVal = Math.max(...values, 1);
                const nowHour = new Date().getHours();

                for (let h = 6; h <= 22; h++) {
                    const val = hourData[h] ?? 0;
                    const p = val / maxVal;
                    const isNow = h === nowHour;

                    let bg = 'linear-gradient(180deg,#DCE7FA,#B7CDF5)';
                    if (isNow) bg = 'linear-gradient(180deg,#3B6FD4,#1A4BAD)';
                    else if (val === Math.max(...values) && val) bg = 'linear-gradient(180deg,#5B8DEF,#3B6FD4)';

                    const barH = val > 0 ? Math.max(p * 110, 8) : 4;

                    $chart.append(`
                        <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;gap:4px;min-width:0;">
                            <div style="font-size:9px;font-weight:600;color:#4A5272;min-height:11px;">${val > 0 ? val : ''}</div>
                            <div style="width:100%;max-width:22px;height:${barH}px;border-radius:6px 6px 0 0;background:${bg};cursor:pointer;"
                                title="${String(h).padStart(2,'0')}:00 — ${val} kendaraan"></div>
                        </div>`);

                    $labels.append(`
                        <div style="flex:1;text-align:center;font-size:9px;color:${isNow ? '#1A4BAD' : '#8A93AE'};font-weight:${isNow ? '700' : '500'};min-width:0;">
                            ${String(h).padStart(2,'0')}
                        </div>`);
                }
            } else {
                $('#chartSub').text('7 hari terakhir');
                const labels = Object.keys(weeklyData);
                const vals = Object.values(weeklyData);
                const maxVal = Math.max(...vals, 1);

                labels.forEach((lbl, i) => {
                    const val = vals[i];
                    const p = val / maxVal;
                    const isToday = i === labels.length - 1;
                    const barH = val > 0 ? Math.max(p * 110, 8) : 4;
                    const bg = isToday ?
                        'linear-gradient(180deg,#3B6FD4,#1A4BAD)' :
                        'linear-gradient(180deg,#DCE7FA,#B7CDF5)';

                    $chart.append(`
                        <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;gap:4px;min-width:0;">
                            <div style="font-size:9px;font-weight:600;color:#4A5272;min-height:11px;">${val > 0 ? val : ''}</div>
                            <div style="width:100%;max-width:32px;height:${barH}px;border-radius:6px 6px 0 0;background:${bg};"
                                title="${lbl} — ${val} kendaraan"></div>
                        </div>`);

                    $labels.append(`
                        <div style="flex:1;text-align:center;font-size:9px;color:${isToday ? '#1A4BAD' : '#8A93AE'};font-weight:${isToday ? '700' : '500'};min-width:0;">
                            ${lbl}
                        </div>`);
                });
            }
        }

        function switchChart(mode) {
            $('#btnHarian').toggleClass('active', mode === 'harian');
            $('#btnMingguan').toggleClass('active', mode === 'mingguan');
            renderChart(mode);
        }

        renderChart('harian');


        // ════════════════════════════════════════
        //  GRUP 4 — Insight: Heatmap / Durasi / Zona
        // ════════════════════════════════════════
        function switchInsight(mode) {
            $('#insightCard .toggle-btn').each(function() {
                $(this).toggleClass('active', $(this).attr('onclick') === `switchInsight('${mode}')`);
            });
            const subMap = {
                heatmap: 'Kepadatan 7 hari × jam',
                durasi: 'Rata-rata durasi parkir per jam',
                zona: 'Okupansi per zona saat ini',
            };
            $('#insightSub').text(subMap[mode]);
            const $body = $('#insightBody').empty();
            if (mode === 'heatmap') renderHeatmap($body);
            if (mode === 'durasi') renderDurasi($body);
            if (mode === 'zona') renderZona($body);
        }

        function renderHeatmap($el) {
            const days = Object.keys(weeklyData);
            const vals7 = Object.values(weeklyData);
            const hours = [6, 8, 10, 12, 14, 16, 18, 20, 22];
            const maxHour = Math.max(...Object.values(hourData), 1);
            const maxWeek = Math.max(...vals7, 1);

            let html = `<div style="overflow-x:auto;">
                <div style="display:grid;grid-template-columns:32px repeat(${hours.length},1fr);gap:2px;min-width:220px;">
                <div></div>`;

            hours.forEach(h => {
                html +=
                    `<div style="text-align:center;font-size:9px;color:#8A93AE;font-weight:500;padding-bottom:3px;">${String(h).padStart(2,'0')}</div>`;
            });

            days.forEach((day, di) => {
                const dayScale = vals7[di] / maxWeek;
                html +=
                    `<div style="font-size:9px;color:#8A93AE;display:flex;align-items:center;font-weight:500;">${day}</div>`;
                hours.forEach(h => {
                    const val = Math.round((hourData[h] ?? 0) * dayScale);
                    const ratio = val / maxHour;
                    const alpha = ratio < 0.1 ? 0.08 : ratio < 0.3 ? 0.2 : ratio < 0.6 ? 0.45 : ratio <
                        0.85 ? 0.7 : 1;
                    html +=
                        `<div title="${day} ${String(h).padStart(2,'0')}:00 — ±${val} kendaraan"
                        style="height:18px;border-radius:3px;background:rgba(59,111,212,${alpha});cursor:default;"></div>`;
                });
            });

            html += `</div>
                <div style="display:flex;align-items:center;gap:6px;margin-top:10px;justify-content:flex-end;">
                    <span style="font-size:10px;color:#8A93AE;">Sepi</span>
                    ${[0.08,0.2,0.45,0.7,1].map(a =>
                        `<div style="width:14px;height:14px;border-radius:3px;background:rgba(59,111,212,${a});"></div>`
                    ).join('')}
                    <span style="font-size:10px;color:#8A93AE;">Padat</span>
                </div>
            </div>`;
            $el.html(html);
        }

        function renderDurasi($el) {
            const baseAvg = {{ $avgDurasiMins ?? 'null' }};
            const hours = [];
            for (let h = 6; h <= 22; h++) hours.push(h);

            if (!baseAvg) {
                $el.html(`<div style="text-align:center;color:#8A93AE;padding:32px 0;font-size:13px;">
                    Belum ada data durasi parkir hari ini.
                </div>`);
                return;
            }

            const vals = hours.map(h => {
                const count = hourData[h] ?? 0;
                if (!count) return 0;
                const f = h < 9 ? 0.7 : h < 12 ? 1.1 : h < 14 ? 1.3 : h < 17 ? 1.0 : h < 20 ? 0.9 : 0.75;
                return Math.round(baseAvg * f);
            });
            const maxVal = Math.max(...vals, 1);

            let bars = '',
                labels = '';
            hours.forEach((h, i) => {
                const val = vals[i];
                const p = val / maxVal;
                const barH = val > 0 ? Math.max(p * 110, 8) : 4;
                const isNow = h === new Date().getHours();
                const isMax = val === Math.max(...vals) && val > 0;
                const bg = isNow ? 'linear-gradient(180deg,#7C3AED,#5B21B6)' :
                    isMax ? 'linear-gradient(180deg,#A78BFA,#7C3AED)' :
                    'linear-gradient(180deg,#EDE9FE,#DDD6FE)';
                const mnt = val > 0 ?
                    (val < 60 ? val + 'm' : Math.floor(val / 60) + 'j' + (val % 60 ? val % 60 + 'm' : '')) :
                    '';

                bars += `
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;gap:3px;min-width:0;">
                        <div style="font-size:8px;font-weight:600;color:#4A5272;min-height:10px;">${mnt}</div>
                        <div style="width:100%;max-width:20px;height:${barH}px;border-radius:5px 5px 0 0;background:${bg};"
                            title="${String(h).padStart(2,'0')}:00 — ~${val} mnt"></div>
                    </div>`;
                labels += `
                    <div style="flex:1;text-align:center;font-size:9px;color:${isNow ? '#7C3AED' : '#8A93AE'};font-weight:${isNow ? '700' : '500'};min-width:0;">
                        ${String(h).padStart(2,'0')}
                    </div>`;
            });

            $el.html(`
                <div>
                    <div style="display:flex;align-items:flex-end;gap:3px;height:130px;padding:0 2px;">${bars}</div>
                    <div style="display:flex;gap:3px;margin-top:6px;padding:0 2px;">${labels}</div>
                    <div style="margin-top:10px;font-size:11px;color:#8A93AE;text-align:center;">
                        Rata-rata keseluruhan: <strong style="color:#7C3AED;">{{ $avgDurasi ?: '-' }}</strong>
                    </div>
                    <div style="font-size:10px;color:#C4C9D8;text-align:center;margin-top:2px;">*estimasi berdasarkan pola hari ini</div>
                </div>`);
        }

        function renderZona($el) {
            if (!zonesData.length) {
                $el.html(
                    `<div style="text-align:center;color:#8A93AE;padding:24px 0;font-size:13px;">Belum ada data zona.</div>`
                    );
                return;
            }
            let html = `<div style="display:flex;flex-direction:column;gap:12px;">`;
            zonesData.forEach(z => {
                const p = z.total > 0 ? Math.round((z.taken / z.total) * 100) : 0;
                const color = p >= 90 ? '#D92D20' : p >= 70 ? '#F79009' : '#12B76A';
                html += `
                    <div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                            <span style="font-size:13px;font-weight:600;color:#1A2340;">${z.name}</span>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <span style="font-size:11px;color:#8A93AE;">${z.taken}/${z.total} slot</span>
                                <span style="font-size:12px;font-weight:700;color:${color};">${p}%</span>
                            </div>
                        </div>
                        <div style="height:8px;background:#F0F2F8;border-radius:99px;overflow:hidden;">
                            <div style="height:100%;width:${p}%;background:${color};border-radius:99px;transition:width .6s ease;"></div>
                        </div>
                    </div>`;
            });
            html += `
                <div style="display:flex;gap:12px;margin-top:4px;padding-top:10px;border-top:1.5px solid #F0F2F8;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:5px;font-size:11px;color:#8A93AE;">
                        <div style="width:9px;height:9px;border-radius:3px;background:#12B76A;"></div> Normal &lt;70%
                    </div>
                    <div style="display:flex;align-items:center;gap:5px;font-size:11px;color:#8A93AE;">
                        <div style="width:9px;height:9px;border-radius:3px;background:#F79009;"></div> Padat 70–90%
                    </div>
                    <div style="display:flex;align-items:center;gap:5px;font-size:11px;color:#8A93AE;">
                        <div style="width:9px;height:9px;border-radius:3px;background:#D92D20;"></div> Penuh &gt;90%
                    </div>
                </div>
            </div>`;
            $el.html(html);
        }

        // Render awal semua panel
        renderLiveRing();
        renderMapSlotPanel();
        switchInsight('heatmap');


        // ════════════════════════════════════════
        //  AJAX POLLING — jQuery $.ajax
        //  Update data tanpa reload halaman
        // ════════════════════════════════════════
        const POLL_INTERVAL = 30000; // 30 detik
        const POLL_URL = '{{ url('dashboard/refresh') }}';
        let pollTimer = null;

        function startPolling() {
            pollTimer = setInterval(fetchAndUpdate, POLL_INTERVAL);
        }

        function fetchAndUpdate() {
            const $badge = $('#liveBadge');
            $badge.addClass('refreshing');

            $.ajax({
                url: POLL_URL,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') ?? '',
                },
                success: function(d) {
                    // ── 1. Stat cards ──────────────────────────────
                    setText('sc-todayIn', d.todayIn);
                    setText('sc-takenSlots', d.takenSlots);
                    setText('sc-freeSlots', d.freeSlots);
                    setText('sc-todayCompleted', d.todayCompleted);
                    setText('sc-takenPct', pct(d.takenSlots, d.totalSlots) + '% terisi');
                    setText('sc-freePct', pct(d.freeSlots, d.totalSlots) + '% tersedia');
                    setText('sc-completedPct', pct(d.todayCompleted, d.todayIn) + '% dari masuk');

                    // ── 2. Header Grup 2 ───────────────────────────
                    setText('g2-taken', d.takenSlots);
                    setText('g2-free', d.freeSlots);

                    // ── 3. Update zonesData → re-render ring & map ─
                    if (Array.isArray(d.zonesWithSlots) && d.zonesWithSlots.length) {
                        zonesData = d.zonesWithSlots;
                    }
                    renderLiveRing();
                    buildMapSlot(g2ActiveZone);

                    // ── 4. Update tabel aktivitas in-place ─────────
                    if (Array.isArray(d.recentActivities)) {
                        updateActivityTable(d.recentActivities);
                    }
                },
                error: function(xhr, status, err) {
                    console.warn('[Dashboard] AJAX poll error:', status, err);
                },
                complete: function() {
                    $badge.removeClass('refreshing');
                }
            });
        }

        startPolling();

        // Pause saat tab tidak aktif, resume + langsung update saat kembali aktif
        $(document).on('visibilitychange', function() {
            if (document.hidden) {
                clearInterval(pollTimer);
                pollTimer = null;
            } else {
                fetchAndUpdate();
                startPolling();
            }
        });
    </script>

    <style>
        /* ── Alert kapasitas ── */
        .alert-capacity {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FEF3F2;
            border: 1.5px solid #FDA29B;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #912018;
            font-size: 13px;
        }

        /* ── Live badge ── */
        .live-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #12B76A;
            background: #ECFDF3;
            border: 1.5px solid #A6F4C5;
            border-radius: 20px;
            padding: 4px 10px;
            transition: opacity .3s;
        }

        .live-badge.refreshing {
            opacity: .5;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #12B76A;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .3;
            }
        }

        /* ── Table ── */
        .data-table th {
            padding: 12px 14px;
            white-space: nowrap;
        }

        .data-table td {
            padding: 12px 14px;
        }

        /* ── Toggle buttons ── */
        .toggle-btn {
            padding: 5px 12px;
            border-radius: 7px;
            border: 1.5px solid #E2E6F0;
            background: #F8F9FC;
            color: #8A93AE;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s;
        }

        .toggle-btn.active {
            background: #3B6FD4;
            border-color: #3B6FD4;
            color: #fff;
        }

        .toggle-btn:hover:not(.active) {
            border-color: #3B6FD4;
            color: #1A4BAD;
        }

        /* ── Grup 2: layout ── */
        .slot-condition-grid {
            display: grid;
            grid-template-columns: 220px 1px 1fr;
            gap: 0;
            min-height: 280px;
        }

        .slot-live-panel {
            padding-right: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .slot-divider {
            background: #F0F2F8;
            margin: 4px 0;
        }

        .slot-map-panel {
            padding-left: 24px;
            min-width: 0;
        }

        /* ── Grup 4: 2 kolom ── */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }

            .slot-condition-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto auto;
            }

            .slot-live-panel {
                padding-right: 0;
                padding-bottom: 20px;
            }

            .slot-divider {
                height: 1px;
                width: 100%;
                margin: 0;
            }

            .slot-map-panel {
                padding-left: 0;
                padding-top: 20px;
            }
        }

        @media (max-width: 640px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
