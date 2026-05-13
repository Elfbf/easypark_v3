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
                    <circle cx="7.5" cy="17.5" r="2.5" />
                    <circle cx="16.5" cy="17.5" r="2.5" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-todayIn">{{ $todayIn }}</div>
            <div class="stat-card-label">Kendaraan Masuk Hari Ini</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#3B6FD4;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon" style="background:#ECFDF3;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#12B76A" stroke-width="2">
                    <path
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1" />
                </svg>
            </div>
            <div class="stat-card-val" id="sc-todayOut">{{ $todayCompleted }}</div>
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
            <div class="stat-card-val" id="sc-todayCompleted">{{ $todayCompleted }}</div>
            <div class="stat-card-label">Selesai Parkir Hari Ini</div>
            <div class="stat-card-delta delta-neu" id="sc-completedPct">
                {{ $todayIn > 0 ? round(($todayCompleted / $todayIn) * 100) : 0 }}% dari masuk
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
            <div class="stat-card-val" id="sc-avgDurasi">{{ $avgDurasi }}</div>
            <div class="stat-card-label">Rata-rata Lama Parkir</div>
            <div class="stat-card-delta delta-neu">Hari ini</div>
            <div class="stat-card-accent" style="background:#F79009;"></div>
        </div>

    </div>


    {{-- ════════════════════════════════════════════════
         GRUP 3 — Aktivitas Terkini (full width)
    ════════════════════════════════════════════════ --}}
    <div class="card" style="margin-bottom:24px;">
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
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M19 17H5a2 2 0 0 1-2-2V7l2-4h10l2 4h2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2z" />
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
         GRUP 4 — Grafik Tren Harian / Mingguan / Bulanan
    ════════════════════════════════════════════════ --}}

    @php
        $hourlyLabels = array_map(function ($h) {
            return str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
        }, range(0, 23));

        $nonZeroHours = 0;
        foreach ($hourlyData as $v) {
            if ($v > 0) {
                $nonZeroHours++;
            }
        }
        $nonZeroHours = $nonZeroHours ?: 1;
    @endphp

    <div class="card" id="chartTrenCard" style="margin-bottom:24px;">
        <div class="card-header" style="padding-bottom:0;">
            <div>
                <div class="card-title">Tren Kendaraan</div>
                <div class="card-sub">
                    Peak hour hari ini:
                    <strong style="color:#3B6FD4;">{{ $peakHourLabel }}</strong>
                    &middot; Rata-rata durasi: <strong style="color:#3B6FD4;">{{ $avgDurasi }}</strong>
                </div>
            </div>
            <div style="display:flex;gap:6px;">
                <button class="tren-tab active" id="tabHarian" onclick="switchTrenTab('harian')">Hari Ini</button>
                <button class="tren-tab" id="tabMingguan" onclick="switchTrenTab('mingguan')">7 Hari</button>
                <button class="tren-tab" id="tabBulanan" onclick="switchTrenTab('bulanan')">30 Hari</button>
            </div>
        </div>

        <div class="card-body" style="padding-top:16px;">

            {{-- Metric ringkasan --}}
            <div class="tren-metrics">
                <div class="tren-metric">
                    <div class="tren-metric-val" id="tmPeak">{{ $peakHourLabel }}</div>
                    <div class="tren-metric-lbl" id="tmPeakLbl">Jam tersibuk</div>
                </div>
                <div class="tren-metric">
                    <div class="tren-metric-val" id="tmTotal">{{ $todayIn }}</div>
                    <div class="tren-metric-lbl">Total kendaraan</div>
                </div>
                <div class="tren-metric">
                    <div class="tren-metric-val" id="tmAvg">{{ round($todayIn / $nonZeroHours) }}</div>
                    <div class="tren-metric-lbl" id="tmAvgLbl">Rata-rata/jam</div>
                </div>
                <div class="tren-metric">
                    <div class="tren-metric-val" id="tmDurasi">{{ $avgDurasi }}</div>
                    <div class="tren-metric-lbl">Rata-rata durasi</div>
                </div>
            </div>

            {{-- Canvas chart --}}
            <div style="position:relative;width:100%;height:240px;margin-top:4px;">
                <canvas id="chartTren" role="img" aria-label="Grafik tren kendaraan masuk">
                    Grafik tren kendaraan masuk.
                </canvas>
            </div>

        </div>
    </div>

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>

    <script>
        // ════════════════════════════════════════
        //  DATA AWAL dari PHP
        // ════════════════════════════════════════
        const trenDataset = {
            harian: {
                labels: @json($hourlyLabels),
                data: @json(array_values($hourlyData)),
            },
            mingguan: {
                labels: @json(array_keys($weeklyData)),
                data: @json(array_values($weeklyData)),
            },
            bulanan: {
                labels: @json(array_keys($monthlyData)),
                data: @json(array_values($monthlyData)),
            },
        };


        // ════════════════════════════════════════
        //  HELPER UMUM
        // ════════════════════════════════════════
        function setText(id, val) {
            $('#' + id).text(val);
        }


        // ════════════════════════════════════════
        //  GRUP 4 — Grafik Tren
        // ════════════════════════════════════════
        let trenMode = 'harian';
        let chartInst = null;

        function initChart() {
            const ctx = document.getElementById('chartTren').getContext('2d');

            const grad = ctx.createLinearGradient(0, 0, 0, 240);
            grad.addColorStop(0, 'rgba(59,111,212,0.85)');
            grad.addColorStop(0.5, 'rgba(59,111,212,0.55)');
            grad.addColorStop(1, 'rgba(59,111,212,0.15)');

            chartInst = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Kendaraan Masuk',
                        data: [],
                        backgroundColor: grad,
                        hoverBackgroundColor: 'rgba(59,111,212,1)',
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.55,
                        categoryPercentage: 0.7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    animation: {
                        duration: 500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1A2340',
                            titleColor: '#fff',
                            bodyColor: '#C8D0E7',
                            padding: 12,
                            cornerRadius: 10,
                            displayColors: false,
                            callbacks: {
                                title: function(items) {
                                    return items[0].label;
                                },
                                label: function(ctx) {
                                    return '  ' + ctx.parsed.y + ' kendaraan';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawTicks: false
                            },
                            ticks: {
                                color: '#8A93AE',
                                font: {
                                    size: 11
                                },
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 10
                            },
                            border: {
                                display: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.045)',
                                drawTicks: false
                            },
                            ticks: {
                                color: '#8A93AE',
                                font: {
                                    size: 11
                                },
                                precision: 0,
                                stepSize: 1
                            },
                            border: {
                                display: false
                            },
                        }
                    }
                }
            });
        }

        function renderTren() {
            const d = trenDataset[trenMode];
            if (!d || !chartInst) return;

            chartInst.data.labels = d.labels;
            chartInst.data.datasets[0].data = d.data;
            chartInst.update('active');

            const total = d.data.reduce(function(s, v) {
                return s + v;
            }, 0);
            const max = d.data.length ? Math.max.apply(null, d.data) : 0;
            const maxIdx = d.data.indexOf(max);
            const nonZero = d.data.filter(function(v) {
                return v > 0;
            }).length || 1;
            const avg = Math.round(total / nonZero);

            $('#tmTotal').text(total);
            $('#tmPeak').text(d.labels[maxIdx] !== undefined ? d.labels[maxIdx] : '—');
            $('#tmAvg').text(avg);

            if (trenMode === 'harian') {
                $('#tmPeakLbl').text('Jam tersibuk');
                $('#tmAvgLbl').text('Rata-rata/jam');
            } else {
                $('#tmPeakLbl').text('Hari tersibuk');
                $('#tmAvgLbl').text('Rata-rata/hari');
            }
        }

        function switchTrenTab(mode) {
            trenMode = mode;
            $('#tabHarian').toggleClass('active', mode === 'harian');
            $('#tabMingguan').toggleClass('active', mode === 'mingguan');
            $('#tabBulanan').toggleClass('active', mode === 'bulanan');
            renderTren();
        }

        // ════════════════════════════════════════
        //  Render awal
        // ════════════════════════════════════════
        initChart();
        renderTren();
    </script>

    <style>
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

        /* ── GRUP 4 — Grafik Tren ── */
        .tren-tab {
            padding: 5px 14px;
            border-radius: 20px;
            border: 1.5px solid #E2E6F0;
            background: #F8F9FC;
            color: #8A93AE;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .tren-tab.active {
            background: #3B6FD4;
            border-color: #3B6FD4;
            color: #fff;
        }

        .tren-tab:hover:not(.active) {
            border-color: #3B6FD4;
            color: #1A4BAD;
        }

        .tren-metrics {
            display: flex;
            gap: 32px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .tren-metric {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .tren-metric-val {
            font-size: 22px;
            font-weight: 700;
            color: #1A2340;
            line-height: 1.1;
        }

        .tren-metric-lbl {
            font-size: 11px;
            color: #8A93AE;
        }
    </style>
@endpush
