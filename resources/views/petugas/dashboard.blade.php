@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('page_title', 'Dashboard')

@section('content')

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
         Ringkasan Cepat (stat cards)
    ════════════════════════════════════════════════ --}}
    <div class="stats-grid" id="statsGrid">

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#E8F0FB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2">
                    <path d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
                    <circle cx="7.5" cy="17.5" r="2.5" />
                    <circle cx="16.5" cy="17.5" r="2.5" />
                </svg>
            </div>
            <div class="stat-card-val">{{ $todayIn }}</div>
            <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#3B6FD4;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#ECFDF3;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#12B76A" stroke-width="2">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                </svg>
            </div>
            <div class="stat-card-val">{{ $todayCompleted }}</div>
            <div class="stat-card-label">Kendaraan Keluar Hari Ini</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#12B76A;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#FEF3F2;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="stat-card-val">{{ $currentlyParked }}</div>
            <div class="stat-card-label">Sedang Parkir</div>
            <div class="stat-card-delta delta-neu">
                {{ $todayIn > 0 ? round(($currentlyParked / $todayIn) * 100) : 0 }}% dari masuk
            </div>
            <div class="stat-card-accent" style="background:#D92D20;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#FFFAEB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#F79009" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div class="stat-card-val">{{ $avgDurasi }}</div>
            <div class="stat-card-label">Rata-rata Lama Parkir</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#F79009;"></div>
        </div>

    </div>


    {{-- ════════════════════════════════════════════════
         Aktivitas Terkini
    ════════════════════════════════════════════════ --}}
    <div class="card" style="margin-bottom:24px;">
        <div class="card-header">
            <div>
                <div class="card-title">Aktivitas Masuk / Keluar Terkini</div>
                <div class="card-sub">Data terkini dari server</div>
            </div>
        </div>
        <div class="card-scroll-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:36px;">#</th>
                        <th>Kendaraan</th>
                        <th>Pengemudi</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
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
                                                <circle cx="7.5" cy="17.5" r="2.5" />
                                                <circle cx="16.5" cy="17.5" r="2.5" />
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                                        <div style="width:30px;height:30px;border-radius:50%;background:#E8F0FB;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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
                        <tr>
                            <td colspan="5" style="text-align:center;color:#8A93AE;padding:20px 0;font-size:13px;">
                                Belum ada aktivitas hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection


@push('scripts')
    <style>
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
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #12B76A;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: .3; }
        }

        .data-table th { padding: 12px 14px; white-space: nowrap; }
        .data-table td { padding: 12px 14px; }
    </style>
@endpush