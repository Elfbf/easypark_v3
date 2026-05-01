@extends('layouts.app')

@section('title', 'Laporan Parkir')
@section('page_title', 'Laporan Parkir')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            style="width:14px;height:14px;color:#8A93AE;flex-shrink:0;">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        <a href="{{ route('dashboard') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
        <span style="color:#D4D9E8;">/</span>
        <a href="{{ route('admin.dashboard') }}" style="color:#8A93AE;text-decoration:none;">Admin</a>
        <span style="color:#D4D9E8;">/</span>
        <span style="color:#181D35;font-weight:600;">Laporan Parkir</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Laporan Parkir</div>
            <div class="page-sub">Pantau dan kelola seluruh riwayat aktivitas parkir kendaraan</div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TOAST CONTAINER
    ══════════════════════════════════════ --}}
    <div id="toastContainer"
        style="position:fixed;top:24px;right:24px;z-index:999;
               display:flex;flex-direction:column;gap:10px;pointer-events:none;">
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () =>
                showToast('success', '{{ session('success') }}'));
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () =>
                showToast('error', '{{ session('error') }}'));
        </script>
    @endif
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', () =>
                showToast('warning', '{{ session('warning') }}'));
        </script>
    @endif

    {{-- ══════════════════════════════════════
         STAT CARDS
    ══════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">

        {{-- Total Catatan --}}
        <div style="background:#fff;border:1.5px solid #EBEEF5;border-radius:16px;
                    padding:20px 22px;display:flex;align-items:center;gap:16px;">
            <div style="width:46px;height:46px;border-radius:12px;background:#E8F0FB;
                        border:1.5px solid #C0D3F5;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                    style="width:20px;height:20px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div>
                <div style="font-size:11.5px;color:#8A93AE;font-weight:500;margin-bottom:3px;">
                    Total Catatan
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:#181D35;line-height:1;">
                    {{ number_format($totalRecords) }}
                </div>
            </div>
        </div>

        {{-- Sedang Parkir --}}
        <div style="background:#fff;border:1.5px solid #EBEEF5;border-radius:16px;
                    padding:20px 22px;display:flex;align-items:center;gap:16px;">
            <div style="width:46px;height:46px;border-radius:12px;background:#ECFDF3;
                        border:1.5px solid #6CE9A6;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#027A48" stroke-width="2"
                    style="width:20px;height:20px;">
                    <rect x="3" y="11" width="18" height="5" rx="2"/>
                    <circle cx="7" cy="18" r="2"/>
                    <circle cx="17" cy="18" r="2"/>
                    <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/>
                </svg>
            </div>
            <div>
                <div style="font-size:11.5px;color:#8A93AE;font-weight:500;margin-bottom:3px;">
                    Sedang Parkir
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:#027A48;line-height:1;">
                    {{ number_format($parkedCount) }}
                </div>
            </div>
        </div>

        {{-- Selesai Hari Ini --}}
        <div style="background:#fff;border:1.5px solid #EBEEF5;border-radius:16px;
                    padding:20px 22px;display:flex;align-items:center;gap:16px;">
            <div style="width:46px;height:46px;border-radius:12px;background:#F5F0FF;
                        border:1.5px solid #D9C8FA;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#6B3DB5" stroke-width="2"
                    style="width:20px;height:20px;">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <div style="font-size:11.5px;color:#8A93AE;font-weight:500;margin-bottom:3px;">
                    Selesai Hari Ini
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:#6B3DB5;line-height:1;">
                    {{ number_format($completedCount) }}
                </div>
            </div>
        </div>

        {{-- Masuk Hari Ini --}}
        <div style="background:#fff;border:1.5px solid #EBEEF5;border-radius:16px;
                    padding:20px 22px;display:flex;align-items:center;gap:16px;">
            <div style="width:46px;height:46px;border-radius:12px;background:#FFFAEB;
                        border:1.5px solid #FDE68A;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#B54708" stroke-width="2"
                    style="width:20px;height:20px;">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div style="font-size:11.5px;color:#8A93AE;font-weight:500;margin-bottom:3px;">
                    Masuk Hari Ini
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:#B54708;line-height:1;">
                    {{ number_format($todayCount) }}
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         TABEL LAPORAN PARKIR
    ══════════════════════════════════════ --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Catatan Parkir</div>
                <div class="card-sub">{{ $parkingRecords->total() }} catatan ditemukan dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">

                {{-- Filter Status --}}
                <form method="GET" action="{{ route('admin.parking-records.index') }}" id="filterForm">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="status" onchange="document.getElementById('filterForm').submit()"
                        style="height:38px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 32px 0 12px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13px;color:#181D35;background:#fff;
                               appearance:none;cursor:pointer;
                               background-image:url(\"data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='%238A93AE' stroke-width='2' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");
                               background-repeat:no-repeat;background-position:right 10px center;background-size:14px;
                               transition:border-color .2s;"
                        onfocus="this.style.borderColor='#3B6FD4'"
                        onblur="this.style.borderColor='#D4D9E8'">
                        <option value="">Semua Status</option>
                        <option value="parked"    {{ $status === 'parked'    ? 'selected' : '' }}>Sedang Parkir</option>
                        <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.parking-records.index') }}" id="searchForm">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="tb-search" style="width:240px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" id="searchInput"
                            placeholder="Cari plat nomor..."
                            value="{{ $search }}"
                            oninput="debounceSearch()">
                    </div>
                </form>

            </div>
        </div>

        @if ($parkingRecords->isEmpty())
            {{-- ── Empty State ── --}}
            <div style="padding:64px 24px;text-align:center;">
                <div style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:28px;height:28px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                            color:#181D35;margin-bottom:6px;">
                    {{ ($search || $status) ? 'Tidak ada catatan yang cocok' : 'Belum ada catatan parkir' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    @if ($search || $status)
                        Coba ubah filter atau
                        <a href="{{ route('admin.parking-records.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Belum ada kendaraan yang tercatat masuk ke sistem parkir
                    @endif
                </div>
            </div>
        @else
            <table class="data-table" id="recordTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Plat Nomor</th>
                        <th style="padding:14px 16px;">Foto Wajah</th>
                        <th style="padding:14px 16px;width:160px;">Waktu Masuk</th>
                        <th style="padding:14px 16px;width:160px;">Waktu Keluar</th>
                        <th style="padding:14px 16px;width:100px;">Durasi</th>
                        <th style="padding:14px 16px;width:140px;text-align:center;">Status</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parkingRecords as $index => $record)
                        <tr id="row-{{ $record->id }}">

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span style="font-size:12px;font-weight:600;color:#8A93AE;
                                             background:#F5F7FC;border:1px solid #EBEEF5;
                                             border-radius:6px;padding:3px 8px;
                                             display:inline-block;min-width:28px;text-align:center;">
                                    {{ $parkingRecords->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Plat Nomor --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div style="width:38px;height:38px;border-radius:10px;
                                                background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                display:flex;align-items:center;justify-content:center;
                                                flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                            style="width:17px;height:17px;">
                                            <rect x="3" y="11" width="18" height="5" rx="2"/>
                                            <circle cx="7" cy="18" r="2"/>
                                            <circle cx="17" cy="18" r="2"/>
                                            <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div style="font-family:monospace;font-weight:700;font-size:14px;
                                                    letter-spacing:0.08em;color:#181D35;">
                                            {{ strtoupper($record->plate_number) }}
                                        </div>
                                        <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;">
                                            @if ($record->vehicle)
                                                {{ $record->vehicle->brand ?? '' }} {{ $record->vehicle->model ?? '' }}
                                            @else
                                                <span style="font-style:italic;">Tidak terdaftar</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Foto Wajah --}}
                            <td style="padding:14px 16px;">
                                @if ($record->face_photo)
                                    <button onclick="openPhotoModal('{{ $record->face_photo }}', '{{ $record->plate_number }}')"
                                        style="width:38px;height:38px;border-radius:10px;
                                               background:#F5F7FC;border:1.5px solid #D4D9E8;
                                               display:flex;align-items:center;justify-content:center;
                                               cursor:pointer;transition:border-color .2s,background .2s;"
                                        onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#E8F0FB'"
                                        onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#F5F7FC'"
                                        title="Lihat foto wajah">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#4A5272" stroke-width="2"
                                            style="width:16px;height:16px;">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                        </svg>
                                    </button>
                                @else
                                    <span style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:38px;height:38px;border-radius:10px;
                                                 background:#F5F7FC;border:1.5px solid #EBEEF5;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#D4D9E8" stroke-width="2"
                                            style="width:16px;height:16px;">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                        </svg>
                                    </span>
                                @endif
                            </td>

                            {{-- Waktu Masuk --}}
                            <td style="padding:14px 16px;">
                                <div style="font-size:13px;font-weight:600;color:#181D35;">
                                    {{ $record->entry_time?->format('d M Y') ?? '-' }}
                                </div>
                                <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;font-family:monospace;">
                                    {{ $record->entry_time?->format('H:i:s') ?? '' }}
                                </div>
                            </td>

                            {{-- Waktu Keluar --}}
                            <td style="padding:14px 16px;">
                                @if ($record->exit_time)
                                    <div style="font-size:13px;font-weight:600;color:#181D35;">
                                        {{ $record->exit_time->format('d M Y') }}
                                    </div>
                                    <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;font-family:monospace;">
                                        {{ $record->exit_time->format('H:i:s') }}
                                    </div>
                                @else
                                    <span style="font-size:12px;color:#8A93AE;font-style:italic;">—</span>
                                @endif
                            </td>

                            {{-- Durasi --}}
                            <td style="padding:14px 16px;">
                                @php
                                    $end   = $record->exit_time ?? now();
                                    $start = $record->entry_time;
                                    if ($start) {
                                        $diff    = $start->diff($end);
                                        $hours   = ($diff->days * 24) + $diff->h;
                                        $minutes = $diff->i;
                                        $durasi  = $hours > 0
                                            ? "{$hours}j {$minutes}m"
                                            : "{$minutes}m";
                                    } else {
                                        $durasi = '-';
                                    }
                                @endphp
                                <span style="display:inline-flex;align-items:center;gap:4px;
                                             font-size:12.5px;font-weight:600;
                                             color:{{ $record->status === 'parked' ? '#027A48' : '#181D35' }};">
                                    @if ($record->status === 'parked')
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;
                                                     animation:pulse 1.5s infinite;"></span>
                                    @endif
                                    {{ $durasi }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($record->status === 'parked')
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                 background:#ECFDF3;border:1px solid #6CE9A6;
                                                 color:#027A48;font-size:12px;font-weight:600;
                                                 padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;"></span>
                                        Parkir
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                 background:#F5F7FC;border:1px solid #D4D9E8;
                                                 color:#4A5272;font-size:12px;font-weight:600;
                                                 padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                    {{-- Detail --}}
                                    <button class="tb-btn" title="Lihat detail"
                                        onclick="openDetailModal(
                                            '{{ addslashes($record->plate_number) }}',
                                            '{{ $record->entry_time?->format('d M Y, H:i:s') ?? '-' }}',
                                            '{{ $record->exit_time?->format('d M Y, H:i:s') ?? '-' }}',
                                            '{{ $durasi }}',
                                            '{{ $record->status }}',
                                            '{{ $record->vehicle?->brand ?? '' }}',
                                            '{{ $record->vehicle?->model ?? '' }}',
                                            '{{ $record->face_photo ?? '' }}'
                                        )"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <circle cx="11" cy="11" r="8"/>
                                            <path d="M21 21l-4.35-4.35"/>
                                        </svg>
                                    </button>

                                    {{-- Force Exit (hanya jika masih parkir) --}}
                                    @if ($record->status === 'parked')
                                        <button class="tb-btn" title="Paksa keluar"
                                            onclick="confirmForceExit({{ $record->id }}, '{{ addslashes($record->plate_number) }}')"
                                            style="width:32px;height:32px;border-radius:8px;border-color:#FECDCA;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                                                style="width:14px;height:14px;">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                                <polyline points="16 17 21 12 16 7"/>
                                                <line x1="21" y1="12" x2="9" y2="12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <span style="width:32px;height:32px;"></span>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer + Pagination --}}
            <div style="padding:14px 24px;border-top:1px solid #EBEEF5;
                        display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <span style="font-size:12.5px;color:#8A93AE;">
                    Menampilkan {{ $parkingRecords->firstItem() }}–{{ $parkingRecords->lastItem() }}
                    dari {{ $parkingRecords->total() }} catatan
                </span>

                @if ($parkingRecords->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        {{-- Prev --}}
                        @if ($parkingRecords->onFirstPage())
                            <span style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="15 18 9 12 15 6"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $parkingRecords->previousPageUrl() }}"
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                      display:flex;align-items:center;justify-content:center;
                                      text-decoration:none;transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="15 18 9 12 15 6"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($parkingRecords->getUrlRange(1, $parkingRecords->lastPage()) as $page => $url)
                            @if ($page == $parkingRecords->currentPage())
                                <span style="width:32px;height:32px;border-radius:8px;
                                             background:#1A4BAD;color:#fff;
                                             display:flex;align-items:center;justify-content:center;
                                             font-size:12.5px;font-weight:600;">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                          display:flex;align-items:center;justify-content:center;
                                          font-size:12.5px;color:#4A5175;text-decoration:none;
                                          transition:border-color .2s,background .2s;"
                                    onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                    onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($parkingRecords->hasMorePages())
                            <a href="{{ $parkingRecords->nextPageUrl() }}"
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                      display:flex;align-items:center;justify-content:center;
                                      text-decoration:none;transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        @else
                            <span style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Detail Catatan Parkir
    ══════════════════════════════════════ --}}
    <div id="modalDetail"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:460px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;">

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                            border:1.5px solid #C0D3F5;display:flex;align-items:center;
                            justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:18px;height:18px;">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="M21 21l-4.35-4.35"/>
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Detail Catatan Parkir
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Informasi lengkap aktivitas parkir
                    </div>
                </div>
            </div>

            {{-- Foto Wajah (jika ada) --}}
            <div id="detailPhotoWrap" style="display:none;margin-bottom:20px;text-align:center;">
                <img id="detailPhoto" src="" alt="Foto Wajah"
                    style="width:90px;height:90px;border-radius:50%;object-fit:cover;
                           border:3px solid #C0D3F5;box-shadow:0 4px 16px rgba(26,75,173,.12);">
                <div style="font-size:11.5px;color:#8A93AE;margin-top:8px;">Foto Wajah Pengemudi</div>
            </div>

            {{-- Info Grid --}}
            <div style="display:flex;flex-direction:column;gap:0;border:1.5px solid #EBEEF5;border-radius:14px;overflow:hidden;">

                <div style="display:flex;align-items:center;padding:12px 16px;border-bottom:1px solid #EBEEF5;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Plat Nomor
                    </div>
                    <div id="detailPlate"
                        style="font-family:monospace;font-weight:700;font-size:14px;
                               letter-spacing:0.08em;color:#181D35;">
                    </div>
                </div>

                <div style="display:flex;align-items:center;padding:12px 16px;border-bottom:1px solid #EBEEF5;background:#FAFBFD;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Kendaraan
                    </div>
                    <div id="detailVehicle" style="font-size:13px;color:#181D35;font-weight:500;"></div>
                </div>

                <div style="display:flex;align-items:center;padding:12px 16px;border-bottom:1px solid #EBEEF5;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Waktu Masuk
                    </div>
                    <div id="detailEntry" style="font-size:13px;color:#181D35;font-weight:500;font-family:monospace;"></div>
                </div>

                <div style="display:flex;align-items:center;padding:12px 16px;border-bottom:1px solid #EBEEF5;background:#FAFBFD;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Waktu Keluar
                    </div>
                    <div id="detailExit" style="font-size:13px;color:#181D35;font-weight:500;font-family:monospace;"></div>
                </div>

                <div style="display:flex;align-items:center;padding:12px 16px;border-bottom:1px solid #EBEEF5;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Durasi Parkir
                    </div>
                    <div id="detailDuration" style="font-size:13px;color:#181D35;font-weight:600;"></div>
                </div>

                <div style="display:flex;align-items:center;padding:12px 16px;background:#FAFBFD;">
                    <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:130px;flex-shrink:0;">
                        Status
                    </div>
                    <div id="detailStatus"></div>
                </div>

            </div>

            <div style="margin-top:20px;">
                <button type="button" onclick="closeDetailModal()" class="btn-outline"
                    style="width:100%;justify-content:center;">
                    Tutup
                </button>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Foto Wajah
    ══════════════════════════════════════ --}}
    <div id="modalPhoto"
        style="display:none;position:fixed;inset:0;z-index:210;
               background:rgba(7,28,82,.6);backdrop-filter:blur(6px);
               align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:20px;padding:24px;
                    max-width:360px;width:calc(100% - 32px);
                    box-shadow:0 24px 64px rgba(7,28,82,.25);text-align:center;">
            <div style="font-family:'Syne',sans-serif;font-size:14px;font-weight:800;
                        color:#181D35;margin-bottom:4px;" id="photoModalTitle">
                Foto Wajah
            </div>
            <div style="font-size:12px;color:#8A93AE;margin-bottom:16px;" id="photoModalPlate"></div>
            <img id="photoModalImg" src="" alt="Foto Wajah"
                style="width:200px;height:200px;border-radius:50%;object-fit:cover;
                       border:4px solid #C0D3F5;box-shadow:0 8px 32px rgba(26,75,173,.15);
                       margin:0 auto 20px;display:block;">
            <button onclick="closePhotoModal()" class="btn-outline"
                style="width:100%;justify-content:center;">
                Tutup
            </button>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Konfirmasi Force Exit
    ══════════════════════════════════════ --}}
    <div id="modalForceExit"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:400px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;text-align:center;">

            <div style="width:60px;height:60px;background:#FEF3F2;border-radius:16px;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                    style="width:28px;height:28px;">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </div>

            <div style="font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:800;
                        color:#181D35;margin-bottom:8px;">
                Paksa Keluarkan Kendaraan?
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
                Kendaraan <strong id="forceExitPlate"
                    style="color:#181D35;background:#F5F7FC;padding:1px 8px;
                           border-radius:6px;border:1px solid #D4D9E8;font-family:monospace;"></strong>
                akan dicatat sebagai selesai parkir.
            </div>
            <div style="font-size:12.5px;color:#F79009;background:#FFFAEB;
                        border:1px solid #FDE68A;border-radius:10px;
                        padding:10px 14px;margin-bottom:24px;line-height:1.6;">
                ⚠ Waktu keluar akan diset ke waktu saat ini.
            </div>

            <form id="forceExitForm" method="POST">
                @csrf
                @method('PATCH')
                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeForceExitModal()" class="btn-outline" style="flex:1;">
                        Batal
                    </button>
                    <button type="submit"
                        style="flex:1;height:38px;border:none;border-radius:10px;
                               background:#D92D20;color:#fff;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;font-weight:600;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='#912018'"
                        onmouseout="this.style.background='#D92D20'">
                        Ya, Paksa Keluar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ═══════════════════════════════
        // TOAST
        // ═══════════════════════════════
        function showToast(type, message) {
            const configs = {
                success: {
                    bg: '#ECFDF3', border: '#6CE9A6', icon: '#12B76A', text: '#027A48',
                    svg: '<polyline points="20 6 9 17 4 12"/>'
                },
                error: {
                    bg: '#FEF3F2', border: '#FECDCA', icon: '#D92D20', text: '#912018',
                    svg: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'
                },
                warning: {
                    bg: '#FFFAEB', border: '#FDE68A', icon: '#F79009', text: '#B54708',
                    svg: '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
                },
            };
            const c  = configs[type] || configs.success;
            const id = 'toast-' + Date.now();
            const el = document.createElement('div');
            el.id = id;
            el.style.cssText = `pointer-events:auto;background:${c.bg};border:1.5px solid ${c.border};
                border-radius:12px;padding:12px 16px;display:flex;align-items:flex-start;gap:10px;
                min-width:280px;max-width:360px;box-shadow:0 8px 24px rgba(0,0,0,.10);
                animation:toastIn .25s ease;font-family:'DM Sans',sans-serif;`;
            el.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2"
                    style="width:16px;height:16px;flex-shrink:0;margin-top:1px;">${c.svg}</svg>
                <span style="font-size:13px;color:${c.text};line-height:1.5;flex:1;">${message}</span>
                <button onclick="removeToast('${id}')"
                    style="background:none;border:none;cursor:pointer;padding:0;color:${c.icon};opacity:.6;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:14px;height:14px;">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>`;
            document.getElementById('toastContainer').appendChild(el);
            setTimeout(() => removeToast(id), 4000);
        }

        function removeToast(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.animation = 'toastOut .2s ease forwards';
                setTimeout(() => el.remove(), 200);
            }
        }

        const toastStyle = document.createElement('style');
        toastStyle.textContent = `
            @keyframes toastIn  { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }
            @keyframes toastOut { from{opacity:1;transform:translateX(0)}    to{opacity:0;transform:translateX(20px)} }
            @keyframes pulse    { 0%,100%{opacity:1} 50%{opacity:.4} }`;
        document.head.appendChild(toastStyle);

        // ═══════════════════════════════
        // SEARCH
        // ═══════════════════════════════
        let searchTimer;
        function debounceSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => document.getElementById('searchForm').submit(), 500);
        }

        // ═══════════════════════════════
        // MODAL DETAIL
        // ═══════════════════════════════
        function openDetailModal(plate, entry, exit, duration, status, brand, model, photo) {
            document.getElementById('detailPlate').textContent    = plate.toUpperCase();
            document.getElementById('detailEntry').textContent    = entry;
            document.getElementById('detailExit').textContent     = exit === '-' ? '—' : exit;
            document.getElementById('detailDuration').textContent = duration;

            const vehicle = [brand, model].filter(Boolean).join(' ') || 'Tidak terdaftar';
            document.getElementById('detailVehicle').textContent  = vehicle;

            const statusEl = document.getElementById('detailStatus');
            if (status === 'parked') {
                statusEl.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;
                    background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48;
                    font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#12B76A;display:inline-block;"></span>
                    Sedang Parkir</span>`;
            } else {
                statusEl.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;
                    background:#F5F7FC;border:1px solid #D4D9E8;color:#4A5272;
                    font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span>
                    Selesai</span>`;
            }

            const photoWrap = document.getElementById('detailPhotoWrap');
            const photoImg  = document.getElementById('detailPhoto');
            if (photo) {
                photoImg.src         = photo;
                photoWrap.style.display = 'block';
            } else {
                photoWrap.style.display = 'none';
            }

            document.getElementById('modalDetail').style.display = 'flex';
        }

        function closeDetailModal() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        // ═══════════════════════════════
        // MODAL FOTO
        // ═══════════════════════════════
        function openPhotoModal(photoUrl, plate) {
            document.getElementById('photoModalImg').src   = photoUrl;
            document.getElementById('photoModalPlate').textContent = plate.toUpperCase();
            document.getElementById('modalPhoto').style.display = 'flex';
        }

        function closePhotoModal() {
            document.getElementById('modalPhoto').style.display = 'none';
        }

        // ═══════════════════════════════
        // MODAL FORCE EXIT
        // ═══════════════════════════════
        function confirmForceExit(id, plate) {
            document.getElementById('forceExitPlate').textContent = plate.toUpperCase();
            document.getElementById('forceExitForm').action = '/admin/parking-records/' + id + '/force-exit';
            document.getElementById('modalForceExit').style.display = 'flex';
        }

        function closeForceExitModal() {
            document.getElementById('modalForceExit').style.display = 'none';
        }

        // ── Tutup backdrop & Escape ──
        ['modalDetail', 'modalPhoto', 'modalForceExit'].forEach(id => {
            document.getElementById(id).addEventListener('click', function (e) {
                if (e.target === this) this.style.display = 'none';
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape')
                ['modalDetail', 'modalPhoto', 'modalForceExit'].forEach(id =>
                    document.getElementById(id).style.display = 'none');
        });
    </script>
@endpush