<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Parkir – EasyPark</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-900: #0F2D6E;
            --blue-700: #1A4BAD;
            --blue-500: #3B6FD4;
            --blue-100: #E8F0FB;
            --blue-50:  #F0F5FF;
            --green-700: #027A48;
            --green-100: #ECFDF3;
            --green-300: #6CE9A6;
            --green-500: #12B76A;
            --gray-900: #181D35;
            --gray-700: #4A5272;
            --gray-400: #8A93AE;
            --gray-200: #D4D9E8;
            --gray-100: #EBEEF5;
            --gray-50:  #F5F7FC;
            --white:    #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', 'Segoe UI', sans-serif;
            font-size: 12px;
            color: var(--gray-900);
            background: #F0F4FA;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════
           SCREEN-ONLY ACTION BAR
        ══════════════════════════════════════ */
        .action-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1.5px solid var(--gray-100);
            padding: 14px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(15,45,110,.06);
        }

        .action-bar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .action-bar-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green-100);
            border: 1px solid var(--green-300);
            color: var(--green-700);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 100px;
        }
        .action-bar-badge .pulse {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--green-500);
            animation: pulse 1.6s ease-in-out infinite;
        }

        .action-bar-text strong {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--gray-900);
            display: block;
        }
        .action-bar-text span {
            font-size: 11.5px;
            color: var(--gray-400);
        }

        .action-bar-btns { display: flex; gap: 8px; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--white); color: var(--gray-700);
            border: 1.5px solid var(--gray-200); border-radius: 10px;
            padding: 9px 18px; font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 600; cursor: pointer;
            transition: all .2s; text-decoration: none;
        }
        .btn-back:hover {
            border-color: var(--blue-500);
            color: var(--blue-700);
            background: var(--blue-50);
        }

        .btn-print {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--blue-700); color: var(--white);
            border: none; border-radius: 10px;
            padding: 9px 22px; font-family: 'DM Sans', sans-serif;
            font-size: 13px; font-weight: 600; cursor: pointer;
            transition: background .2s; text-decoration: none;
            box-shadow: 0 2px 8px rgba(26,75,173,.25);
        }
        .btn-print:hover { background: var(--blue-900); }

        /* ══════════════════════════════════════
           DOCUMENT WRAPPER
        ══════════════════════════════════════ */
        .document {
            max-width: 900px;
            margin: 32px auto;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(15,45,110,.10), 0 1px 3px rgba(15,45,110,.06);
            overflow: hidden;
        }

        /* ── Document Top Accent ── */
        .doc-accent {
            height: 5px;
            background: linear-gradient(90deg, var(--blue-900) 0%, var(--blue-500) 60%, #60A5FA 100%);
        }

        .doc-body { padding: 40px 44px; }

        /* ══════════════════════════════════════
           REPORT HEADER
        ══════════════════════════════════════ */
        .report-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--gray-100);
            position: relative;
        }

        .report-header::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0;
            width: 64px; height: 2px;
            background: var(--blue-700);
            border-radius: 2px;
        }

        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-icon {
            width: 46px; height: 46px;
            background: linear-gradient(135deg, var(--blue-700) 0%, var(--blue-900) 100%);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(26,75,173,.30);
        }
        .brand-icon svg { width: 24px; height: 24px; }

        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 22px; font-weight: 800;
            color: var(--blue-700); letter-spacing: -.5px;
        }
        .brand-sub { font-size: 11.5px; color: var(--gray-400); margin-top: 3px; }

        .report-meta { text-align: right; }
        .report-meta .doc-label {
            display: inline-block;
            background: var(--blue-100);
            border: 1px solid #C0D3F5;
            color: var(--blue-700);
            font-size: 10px; font-weight: 700;
            letter-spacing: .6px; text-transform: uppercase;
            padding: 3px 10px; border-radius: 6px;
            margin-bottom: 8px;
        }
        .report-meta .title {
            font-family: 'Syne', sans-serif;
            font-size: 18px; font-weight: 800;
            color: var(--gray-900); line-height: 1.2;
        }
        .report-meta .sub {
            font-size: 11.5px; color: var(--gray-400);
            margin-top: 6px; line-height: 1.8;
        }

        /* ══════════════════════════════════════
           FILTER BAR
        ══════════════════════════════════════ */
        .filter-section {
            background: var(--blue-50);
            border: 1px solid #C0D3F5;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .filter-label {
            font-size: 11px; font-weight: 700; color: var(--gray-400);
            text-transform: uppercase; letter-spacing: .5px;
            margin-right: 4px;
        }
        .filter-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--white); border: 1px solid #C0D3F5;
            color: var(--blue-700); font-size: 11.5px; font-weight: 600;
            padding: 4px 11px; border-radius: 100px;
            box-shadow: 0 1px 3px rgba(26,75,173,.08);
        }
        .no-filter {
            font-size: 12px; color: var(--gray-400);
            font-style: italic;
        }



        /* ══════════════════════════════════════
           SECTION HEADING
        ══════════════════════════════════════ */
        .section-heading {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 14px;
        }
        .section-heading .dot-line {
            width: 4px; height: 18px;
            background: var(--blue-700);
            border-radius: 4px;
        }
        .section-heading h3 {
            font-family: 'Syne', sans-serif;
            font-size: 13px; font-weight: 800;
            color: var(--gray-900); letter-spacing: -.2px;
        }
        .section-heading .count-badge {
            margin-left: auto;
            background: var(--blue-100);
            border: 1px solid #C0D3F5;
            color: var(--blue-700);
            font-size: 11px; font-weight: 700;
            padding: 2px 10px; border-radius: 100px;
        }

        /* ══════════════════════════════════════
           TABLE
        ══════════════════════════════════════ */
        .table-wrap {
            border: 1.5px solid var(--gray-100);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 32px;
        }

        table { width: 100%; border-collapse: collapse; }

        thead tr { background: var(--gray-900); }
        thead th {
            padding: 11px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: rgba(255,255,255,.7);
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        thead th:first-child { padding-left: 18px; }
        thead th:last-child  { padding-right: 18px; }

        tbody tr { border-bottom: 1px solid var(--gray-100); transition: background .1s; }
        tbody tr:nth-child(even) { background: var(--gray-50); }
        tbody tr:last-child { border-bottom: none; }

        td {
            padding: 10px 14px;
            font-size: 11.5px;
            color: var(--gray-900);
            vertical-align: middle;
        }
        td:first-child { padding-left: 18px; }
        td:last-child  { padding-right: 18px; }

        .row-num {
            font-size: 11px; font-weight: 600; color: var(--gray-400);
            background: var(--gray-50); border: 1px solid var(--gray-100);
            border-radius: 5px; padding: 2px 7px;
            display: inline-block; min-width: 26px; text-align: center;
        }

        .plate {
            font-family: 'DM Mono', 'Courier New', monospace;
            font-weight: 500; font-size: 13px;
            letter-spacing: .07em; color: var(--gray-900);
        }
        .vehicle-sub { font-size: 10.5px; color: var(--gray-400); margin-top: 2px; }

        .time-main { font-size: 12px; font-weight: 600; color: var(--gray-900); }
        .time-sub  {
            font-family: 'DM Mono', monospace;
            font-size: 10.5px; color: var(--gray-400);
            margin-top: 2px;
        }

        .duration {
            font-family: 'DM Mono', monospace;
            font-size: 12px; font-weight: 500;
            color: var(--gray-700);
        }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 10.5px; font-weight: 700;
            padding: 3px 10px; border-radius: 100px;
            white-space: nowrap;
        }
        .badge-green { background: var(--green-100); border: 1px solid var(--green-300); color: var(--green-700); }
        .badge-gray  { background: var(--gray-50);   border: 1px solid var(--gray-200);  color: var(--gray-700); }
        .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }

        /* ══════════════════════════════════════
           DIVIDER
        ══════════════════════════════════════ */
        .divider {
            height: 1px;
            background: var(--gray-100);
            margin: 28px 0;
        }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        .report-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid var(--gray-100);
        }

        .footer-brand {
            display: flex; align-items: center; gap: 8px;
        }
        .footer-brand-dot {
            width: 22px; height: 22px;
            background: var(--blue-100);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
        }
        .footer-brand-dot svg { width: 12px; height: 12px; }
        .footer-brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 12px; font-weight: 800;
            color: var(--blue-700);
        }

        .footer-right { text-align: right; }
        .footer-right .footer-label {
            font-size: 10.5px; color: var(--gray-400); display: block;
        }
        .footer-right .footer-time {
            font-family: 'DM Mono', monospace;
            font-size: 11px; color: var(--gray-700);
            font-weight: 500; margin-top: 2px;
        }

        /* ══════════════════════════════════════
           EMPTY STATE
        ══════════════════════════════════════ */
        .empty-state {
            padding: 56px 24px;
            text-align: center;
        }
        .empty-icon {
            width: 52px; height: 52px;
            background: var(--blue-100); border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 14px; font-weight: 800;
            color: var(--gray-900); margin-bottom: 6px;
        }
        .empty-sub { font-size: 12px; color: var(--gray-400); }

        /* ══════════════════════════════════════
           ANIMATIONS
        ══════════════════════════════════════ */
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.85); }
        }

        /* ══════════════════════════════════════
           PRINT OVERRIDES
        ══════════════════════════════════════ */
        @media print {
            body { background: #fff; }
            .action-bar, .no-print { display: none !important; }
            .document {
                max-width: 100%;
                margin: 0;
                border-radius: 0;
                box-shadow: none;
            }
            .doc-body { padding: 24px 28px; }
            .doc-accent { display: none; }
            table { page-break-inside: auto; }
            tr    { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            .table-wrap { border: 1px solid var(--gray-200); }
            .stat-card { break-inside: avoid; }
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════
         SCREEN-ONLY ACTION BAR
    ══════════════════════════════════════ --}}
    <div class="action-bar no-print">
        <div class="action-bar-left">
            <div class="action-bar-badge">
                <span class="pulse"></span>
                Pratinjau Siap
            </div>
            <div class="action-bar-text">
                <strong>Laporan Catatan Parkir</strong>
                <span>Klik "Cetak / Simpan PDF" untuk mencetak atau mengunduh sebagai PDF</span>
            </div>
        </div>
        <div class="action-bar-btns">
            <a href="/admin/parking-records" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="width:14px;height:14px;"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <button class="btn-print" onclick="window.print()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="width:14px;height:14px;">
                    <polyline points="6 9 6 2 18 2 18 9"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         DOCUMENT
    ══════════════════════════════════════ --}}
    <div class="document">
        <div class="doc-accent"></div>
        <div class="doc-body">

            {{-- ── Report Header ── --}}
            <div class="report-header">
                <div class="brand">
                    <div class="brand-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                            <rect x="3" y="11" width="18" height="5" rx="2"/>
                            <circle cx="7" cy="18" r="2"/>
                            <circle cx="17" cy="18" r="2"/>
                            <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="brand-name">EasyPark</div>
                        <div class="brand-sub">Sistem Manajemen Parkir</div>
                    </div>
                </div>
                <div class="report-meta">
                    <div class="doc-label">&#9632; Dokumen Resmi</div>
                    <div class="title">Laporan Catatan Parkir</div>
                    <div class="sub">
                        Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB<br>
                        Total data: {{ $records->count() }} catatan
                    </div>
                </div>
            </div>

            {{-- ── Filter Aktif ── --}}
            @if ($search || $status || $dateFrom || $dateTo)
                <div class="filter-section">
                    <span class="filter-label">Filter:</span>
                    @if ($search)
                        <span class="filter-chip">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                style="width:9px;height:9px;"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                            Plat: {{ strtoupper($search) }}
                        </span>
                    @endif
                    @if ($status)
                        <span class="filter-chip">
                            Status: {{ $status === 'parked' ? 'Sedang Parkir' : 'Selesai' }}
                        </span>
                    @endif
                    @if ($dateFrom)
                        <span class="filter-chip">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                style="width:9px;height:9px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Dari: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}
                        </span>
                    @endif
                    @if ($dateTo)
                        <span class="filter-chip">
                            s/d: {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}
                        </span>
                    @endif
                </div>
            @else
                <div style="font-size:12px;color:var(--gray-400);margin-bottom:20px;
                            display:flex;align-items:center;gap:6px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Menampilkan seluruh catatan parkir tanpa filter aktif
                </div>
            @endif

            {{-- ── Table Section ── --}}
            @if ($records->isEmpty())
                <div class="table-wrap">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                style="width:24px;height:24px;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div class="empty-title">Tidak ada data</div>
                        <div class="empty-sub">Tidak ada catatan parkir yang sesuai dengan filter yang dipilih.</div>
                    </div>
                </div>
            @else
                <div class="section-heading">
                    <div class="dot-line"></div>
                    <h3>Data Catatan Parkir</h3>
                    <span class="count-badge">{{ $records->count() }} catatan</span>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:46px;">#</th>
                                <th>Plat Nomor</th>
                                <th>Kendaraan</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Durasi</th>
                                <th style="text-align:center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $i => $record)
                                @php
                                    $end   = $record->exit_time ?? now();
                                    $start = $record->entry_time;
                                    if ($start) {
                                        $diff   = $start->diff($end);
                                        $hours  = $diff->days * 24 + $diff->h;
                                        $mins   = $diff->i;
                                        $durasi = $hours > 0 ? "{$hours}j {$mins}m" : "{$mins}m";
                                    } else {
                                        $durasi = '-';
                                    }
                                    $vehicleStr = collect([
                                        ucfirst($record->vehicle?->type?->name ?? ''),
                                        ucfirst($record->vehicle?->brand?->name ?? ''),
                                        ucfirst($record->vehicle?->model?->name ?? ''),
                                    ])->filter()->join(' ');
                                @endphp
                                <tr>
                                    <td><span class="row-num">{{ $i + 1 }}</span></td>
                                    <td>
                                        <div class="plate">{{ strtoupper($record->plate_number) }}</div>
                                    </td>
                                    <td>
                                        @if ($vehicleStr)
                                            {{ $vehicleStr }}
                                        @else
                                            <span style="color:var(--gray-400);font-style:italic;font-size:11px;">Tidak terdaftar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="time-main">{{ $record->entry_time?->format('d M Y') ?? '-' }}</div>
                                        <div class="time-sub">{{ $record->entry_time?->format('H:i:s') ?? '' }}</div>
                                    </td>
                                    <td>
                                        @if ($record->exit_time)
                                            <div class="time-main">{{ $record->exit_time->format('d M Y') }}</div>
                                            <div class="time-sub">{{ $record->exit_time->format('H:i:s') }}</div>
                                        @else
                                            <span style="color:var(--gray-400);">—</span>
                                        @endif
                                    </td>
                                    <td><span class="duration">{{ $durasi }}</span></td>
                                    <td style="text-align:center;">
                                        @if ($record->status === 'parked')
                                            <span class="badge badge-green">
                                                <span class="dot" style="background:#12B76A;"></span>
                                                Parkir
                                            </span>
                                        @else
                                            <span class="badge badge-gray">
                                                <span class="dot" style="background:#D4D9E8;"></span>
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ── Footer ── --}}
            <div class="report-footer">
                <div class="footer-brand">
                    <div class="footer-brand-dot">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2">
                            <rect x="3" y="11" width="18" height="5" rx="2"/>
                            <circle cx="7" cy="18" r="2"/>
                            <circle cx="17" cy="18" r="2"/>
                            <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="footer-brand-name">EasyPark</div>
                        <div style="font-size:10px;color:var(--gray-400);margin-top:1px;">Sistem Manajemen Parkir</div>
                    </div>
                </div>
                <div class="footer-right">
                    <span class="footer-label">Dokumen dicetak pada</span>
                    <div class="footer-time">{{ now()->format('d M Y, H:i') }} WIB</div>
                </div>
            </div>

        </div>{{-- /doc-body --}}
    </div>{{-- /document --}}

    <div style="height:40px;" class="no-print"></div>

</body>
</html>