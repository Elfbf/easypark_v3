@extends('layouts.app')

@section('title', 'Kendaraan')
@section('page_title', 'Kendaraan')

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
        <span style="color:#181D35;font-weight:600;">Kendaraan</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Kendaraan</div>
            <div class="page-sub">Kelola data kendaraan yang terdaftar dalam sistem</div>
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

    {{-- ── Tabel Kendaraan ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Kendaraan</div>
                <div class="card-sub">{{ $vehicles->total() }} kendaraan terdaftar dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.vehicles.index') }}" id="searchForm">
                    <div class="tb-search" style="width:240px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text" name="search" id="searchInput" placeholder="Cari plat, warna, merek..."
                            value="{{ $search }}" oninput="debounceSearch()">
                    </div>
                </form>

                {{-- Tombol Tambah --}}
                <button class="btn-primary" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Kendaraan
                </button>
            </div>
        </div>

        @if ($vehicles->isEmpty())
            {{-- ── Empty state ── --}}
            <div style="padding:64px 24px;text-align:center;">
                <div
                    style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:28px;height:28px;">
                        <rect x="3" y="11" width="18" height="5" rx="2" />
                        <circle cx="7" cy="18" r="2" />
                        <circle cx="17" cy="18" r="2" />
                        <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                    </svg>
                </div>
                <div
                    style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                            color:#181D35;margin-bottom:6px;">
                    {{ $search ? 'Tidak ada kendaraan yang cocok' : 'Belum ada kendaraan' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    @if ($search)
                        Coba kata kunci lain atau
                        <a href="{{ route('admin.vehicles.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Tambahkan kendaraan pertama untuk mulai mengelola data armada
                    @endif
                </div>
                @if (!$search)
                    <button class="btn-primary" onclick="openModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Kendaraan
                    </button>
                @endif
            </div>
        @else
            <table class="data-table" id="vehicleTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Kendaraan</th>
                        <th style="padding:14px 16px;">Pemilik</th>
                        <th style="padding:14px 16px;width:260px;">Kendaraan</th>
                        <th style="padding:14px 16px;width:140px;">Status Parkir</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aktif</th>
                        <th style="padding:14px 16px;width:140px;">Terdaftar</th>
                        <th style="padding:14px 16px;width:130px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $index => $vehicle)
                        <tr id="row-{{ $vehicle->id }}">

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span
                                    style="font-size:12px;font-weight:600;color:#8A93AE;
                                             background:#F5F7FC;border:1px solid #EBEEF5;
                                             border-radius:6px;padding:3px 8px;
                                             display:inline-block;min-width:28px;text-align:center;">
                                    {{ $vehicles->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Kendaraan (foto + plat + warna) --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    {{-- Foto / Placeholder --}}
                                    @if ($vehicle->vehicle_photo)
                                        <img src="{{ Storage::url($vehicle->vehicle_photo) }}"
                                            alt="{{ $vehicle->plate_number }}"
                                            style="width:42px;height:42px;border-radius:10px;
                                                   object-fit:cover;border:1.5px solid #EBEEF5;flex-shrink:0;">
                                    @else
                                        <div
                                            style="width:42px;height:42px;border-radius:10px;
                                                    background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                    display:flex;align-items:center;justify-content:center;
                                                    flex-shrink:0;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                                style="width:18px;height:18px;">
                                                <rect x="3" y="11" width="18" height="5" rx="2" />
                                                <circle cx="7" cy="18" r="2" />
                                                <circle cx="17" cy="18" r="2" />
                                                <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div
                                            style="font-family:monospace;font-weight:700;font-size:14px;
                                                    letter-spacing:0.08em;color:#181D35;">
                                            {{ $vehicle->plate_number }}
                                        </div>
                                        <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;">
                                            {{ $vehicle->color ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Pemilik --}}
                            <td style="padding:14px 16px;">
                                @if ($vehicle->user)
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <div
                                            style="width:30px;height:30px;border-radius:50%;
                                                    background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                    display:flex;align-items:center;justify-content:center;
                                                    flex-shrink:0;font-size:12px;font-weight:700;color:#1A4BAD;">
                                            {{ strtoupper(substr($vehicle->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-size:13px;font-weight:600;color:#181D35;">
                                                {{ $vehicle->user->name }}
                                            </div>
                                            <div style="font-size:11.5px;color:#8A93AE;margin-top:1px;">
                                                {{ $vehicle->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span style="font-size:12px;color:#8A93AE;font-style:italic;">— Tidak ada —</span>
                                @endif
                            </td>

                            {{-- Jenis / Merek / Model --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;">

                                    @if ($vehicle->type)
                                        <span
                                            style="display:inline-flex;align-items:center;
                       background:#F5F0FF;border:1px solid #D9C8FA;
                       color:#6B3DB5;font-size:11.5px;font-weight:600;
                       padding:4px 10px;border-radius:100px;">
                                            {{ $vehicle->type->name }}
                                        </span>
                                    @endif

                                    @if ($vehicle->brand)
                                        <span
                                            style="display:inline-flex;align-items:center;
                       background:#F5F7FC;border:1px solid #D4D9E8;
                       color:#4A5272;font-size:11.5px;font-weight:500;
                       padding:4px 10px;border-radius:100px;">
                                            {{ $vehicle->brand->name }}
                                        </span>
                                    @endif

                                    @if ($vehicle->model)
                                        <span
                                            style="display:inline-flex;align-items:center;
                       background:#EFF8FF;border:1px solid #84CAFF;
                       color:#1D74C4;font-size:11.5px;font-weight:500;
                       padding:4px 10px;border-radius:100px;">
                                            {{ $vehicle->model->name }}
                                        </span>
                                    @endif

                                </div>
                            </td>

                            {{-- Status Parkir --}}
                            <td style="padding:14px 16px;">
                                @if ($vehicle->is_parked)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#EFF8FF;border:1px solid #84CAFF;
                                                color:#1D74C4;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1D74C4" stroke-width="2.5"
                                            style="width:11px;height:11px;flex-shrink:0;">
                                            <rect x="3" y="11" width="18" height="5" rx="2" />
                                            <circle cx="7" cy="18" r="2" />
                                            <circle cx="17" cy="18" r="2" />
                                            <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                                        </svg>
                                        Sedang Parkir
                                    </span>
                                    @if ($vehicle->parked_at)
                                        <div style="font-size:11px;color:#8A93AE;margin-top:4px;">
                                            {{ $vehicle->parked_at->format('d M, H:i') }}
                                        </div>
                                    @endif
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Tidak Parkir
                                    </span>
                                @endif
                            </td>

                            {{-- Aktif --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($vehicle->is_active)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Terdaftar --}}
                            <td style="padding:14px 16px;color:#8A93AE;font-size:12.5px;">
                                {{ $vehicle->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                    {{-- Detail --}}
                                    <button class="tb-btn" title="Detail kendaraan"
                                        onclick="openDetailModal(
        '{{ addslashes($vehicle->plate_number) }}',
        '{{ addslashes($vehicle->color ?? '—') }}',
        '{{ $vehicle->type?->name ?? '—' }}',
        '{{ $vehicle->brand?->name ?? '—' }}',
        '{{ $vehicle->model?->name ?? '—' }}',
        {{ $vehicle->user_id ? "'" . addslashes($vehicle->user->name) . "'" : 'null' }},
        {{ $vehicle->user_id ? "'" . addslashes($vehicle->user->email) . "'" : 'null' }},
        {{ $vehicle->is_active ? 'true' : 'false' }},
        {{ $vehicle->is_parked ? 'true' : 'false' }},
        '{{ $vehicle->parked_at?->format('d M Y, H:i') ?? '' }}',
        '{{ $vehicle->created_at?->format('d M Y') ?? '—' }}',
        {{ $vehicle->vehicle_photo ? "'" . Storage::url($vehicle->vehicle_photo) . "'" : 'null' }},
        {{ $vehicle->stnk_photo ? "'" . Storage::url($vehicle->stnk_photo) . "'" : 'null' }}
    )"
                                        style="width:32px;height:32px;border-radius:8px;
           display:inline-flex;align-items:center;justify-content:center;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>

                                    {{-- Edit --}}
                                    <button class="tb-btn" title="Edit kendaraan"
                                        onclick="openEditModal(
        {{ $vehicle->id }},
        {{ $vehicle->user_id ?? 'null' }},
        {{ $vehicle->vehicle_type_id }},
        {{ $vehicle->vehicle_brand_id }},
        {{ $vehicle->vehicle_model_id ? $vehicle->vehicle_model_id : 'null' }},
        '{{ addslashes($vehicle->plate_number) }}',
        '{{ addslashes($vehicle->color ?? '') }}',
        {{ $vehicle->is_active ? 'true' : 'false' }},
        {{ $vehicle->vehicle_photo ? "'" . Storage::url($vehicle->vehicle_photo) . "'" : 'null' }},
        {{ $vehicle->stnk_photo ? "'" . Storage::url($vehicle->stnk_photo) . "'" : 'null' }}
    )"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <button class="tb-btn" title="Hapus kendaraan"
                                        onclick="confirmDelete({{ $vehicle->id }}, '{{ addslashes($vehicle->plate_number) }}')"
                                        style="width:32px;height:32px;border-radius:8px;border-color:#FECDCA;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                            <path d="M10 11v6M14 11v6" />
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                        </svg>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer tabel + Pagination --}}
            <div
                style="padding:14px 24px;border-top:1px solid #EBEEF5;
                        display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <span style="font-size:12.5px;color:#8A93AE;">
                    Menampilkan {{ $vehicles->firstItem() }}–{{ $vehicles->lastItem() }}
                    dari {{ $vehicles->total() }} kendaraan
                </span>

                @if ($vehicles->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        {{-- Prev --}}
                        @if ($vehicles->onFirstPage())
                            <span
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $vehicles->previousPageUrl() }}"
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                      display:flex;align-items:center;justify-content:center;
                                      text-decoration:none;transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach ($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
                            @if ($page == $vehicles->currentPage())
                                <span
                                    style="width:32px;height:32px;border-radius:8px;
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
                        @if ($vehicles->hasMorePages())
                            <a href="{{ $vehicles->nextPageUrl() }}"
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                      display:flex;align-items:center;justify-content:center;
                                      text-decoration:none;transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </a>
                        @else
                            <span
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </span>
                        @endif
                    </div>
                @endif
            </div>

        @endif
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Tambah Kendaraan
    ══════════════════════════════════════ --}}
    <div id="modalAdd"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:520px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;max-height:90vh;overflow-y:auto;">

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                            border:1.5px solid #C0D3F5;display:flex;align-items:center;
                            justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:18px;height:18px;">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Tambah Kendaraan
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Daftarkan kendaraan baru ke dalam sistem
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Pemilik --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Pemilik
                        <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                    </label>
                    <select name="user_id"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               appearance:none;cursor:pointer;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <option value="">— Tanpa Pemilik —</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis & Merek side by side --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Jenis Kendaraan <span style="color:#D92D20;">*</span>
                        </label>

                        <select name="vehicle_type_id" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                   font-size:13.5px;color:#181D35;background:#fff;
                   appearance:none;cursor:pointer;
                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                            <option value="">— Pilih Jenis —</option>

                            @foreach ($vehicleTypes as $vt)
                                <option value="{{ $vt->id }}">
                                    {{ $vt->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('vehicle_type_id')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Merek Kendaraan <span style="color:#D92D20;">*</span>
                        </label>

                        <select name="vehicle_brand_id" required onchange="filterModels('addVehicleModelId', this.value)"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                   font-size:13.5px;color:#181D35;background:#fff;
                   appearance:none;cursor:pointer;
                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                            <option value="">— Pilih Merek —</option>

                            @foreach ($vehicleBrands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('vehicle_brand_id')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Model Kendaraan --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Model Kendaraan
                        <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                    </label>

                    <select name="vehicle_model_id" id="addVehicleModelId"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
               font-size:13.5px;color:#181D35;background:#fff;
               appearance:none;cursor:pointer;
               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                        <option value="">— Pilih Model —</option>

                        @foreach ($vehicleModels as $model)
                            <option value="{{ $model->id }}" data-brand="{{ $model->vehicle_brand_id }}">
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('vehicle_model_id')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- Nomor Plat & Warna side by side --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Nomor Plat <span style="color:#D92D20;">*</span>
                        </label>
                        <input type="text" name="plate_number" placeholder="Contoh: B 1234 ABC" autocomplete="off"
                            required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:monospace;
                                   font-size:13.5px;color:#181D35;background:#fff;text-transform:uppercase;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        @error('plate_number')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Warna
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>
                        <input type="text" name="color" placeholder="Contoh: Hitam" autocomplete="off"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        @error('color')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Foto Kendaraan & STNK side by side --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Foto Kendaraan
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>
                        <label for="addVehiclePhoto"
                            style="display:flex;align-items:center;gap:10px;height:42px;
                                   border:1.5px dashed #D4D9E8;border-radius:10px;
                                   padding:0 14px;cursor:pointer;background:#FAFBFD;
                                   transition:border-color .2s;"
                            onmouseover="this.style.borderColor='#3B6FD4'" onmouseout="this.style.borderColor='#D4D9E8'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:16px;height:16px;flex-shrink:0;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span id="addVehiclePhotoLabel"
                                style="font-size:12px;color:#8A93AE;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                Pilih foto...
                            </span>
                            <input type="file" id="addVehiclePhoto" name="vehicle_photo" accept=".jpg,.jpeg,.png"
                                style="display:none;" onchange="updateFileName('addVehiclePhoto','addVehiclePhotoLabel')">
                        </label>
                        @error('vehicle_photo')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Foto STNK
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>
                        <label for="addStnkPhoto"
                            style="display:flex;align-items:center;gap:10px;height:42px;
                                   border:1.5px dashed #D4D9E8;border-radius:10px;
                                   padding:0 14px;cursor:pointer;background:#FAFBFD;
                                   transition:border-color .2s;"
                            onmouseover="this.style.borderColor='#3B6FD4'" onmouseout="this.style.borderColor='#D4D9E8'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:16px;height:16px;flex-shrink:0;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <span id="addStnkPhotoLabel"
                                style="font-size:12px;color:#8A93AE;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                Pilih foto...
                            </span>
                            <input type="file" id="addStnkPhoto" name="stnk_photo" accept=".jpg,.jpeg,.png"
                                style="display:none;" onchange="updateFileName('addStnkPhoto','addStnkPhotoLabel')">
                        </label>
                        @error('stnk_photo')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeModal()" class="btn-outline" style="flex:1;">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Simpan Kendaraan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Edit Kendaraan
    ══════════════════════════════════════ --}}
    <div id="modalEdit"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:520px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;max-height:90vh;overflow-y:auto;">

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#FFFAEB;
                            border:1.5px solid #FDE68A;display:flex;align-items:center;
                            justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#C9960F" stroke-width="2"
                        style="width:18px;height:18px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Edit Kendaraan
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Ubah data kendaraan yang dipilih
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Pemilik --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Pemilik
                        <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                    </label>
                    <select name="user_id" id="editUserId"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               appearance:none;cursor:pointer;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <option value="">— Tanpa Pemilik —</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis & Merek --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Jenis Kendaraan <span style="color:#D92D20;">*</span>
                        </label>

                        <select name="vehicle_type_id" id="editVehicleTypeId" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                   font-size:13.5px;color:#181D35;background:#fff;
                   appearance:none;cursor:pointer;
                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                            <option value="">— Pilih Jenis —</option>

                            @foreach ($vehicleTypes as $vt)
                                <option value="{{ $vt->id }}">
                                    {{ $vt->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Merek Kendaraan <span style="color:#D92D20;">*</span>
                        </label>

                        <select name="vehicle_brand_id" id="editVehicleBrandId" required
                            onchange="filterModels('editVehicleModelId', this.value)"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                   font-size:13.5px;color:#181D35;background:#fff;
                   appearance:none;cursor:pointer;
                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                            <option value="">— Pilih Merek —</option>

                            @foreach ($vehicleBrands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Model Kendaraan --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Model Kendaraan
                        <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                    </label>

                    <select name="vehicle_model_id" id="editVehicleModelId"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
               font-size:13.5px;color:#181D35;background:#fff;
               appearance:none;cursor:pointer;
               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">

                        <option value="">— Pilih Model —</option>

                        @foreach ($vehicleModels as $model)
                            <option value="{{ $model->id }}" data-brand="{{ $model->vehicle_brand_id }}">
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nomor Plat & Warna --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Nomor Plat <span style="color:#D92D20;">*</span>
                        </label>
                        <input type="text" name="plate_number" id="editPlateNumber" required autocomplete="off"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:monospace;
                                   font-size:13.5px;color:#181D35;background:#fff;text-transform:uppercase;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Warna
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>
                        <input type="text" name="color" id="editColor" autocomplete="off"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Ganti Foto Kendaraan & STNK side by side --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">

                    {{-- Foto Kendaraan --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Foto Kendaraan
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>

                        {{-- Preview foto lama / foto baru --}}
                        <div id="editVehiclePhotoPreviewWrap"
                            style="width:100%;height:100px;border-radius:10px;overflow:hidden;
                   border:1.5px solid #EBEEF5;background:#F5F7FC;margin-bottom:8px;
                   display:flex;align-items:center;justify-content:center;position:relative;">
                            <img id="editVehiclePhotoPreview" src="" alt="Preview"
                                style="width:100%;height:100%;object-fit:cover;display:none;">
                            <div id="editVehiclePhotoNone"
                                style="display:flex;flex-direction:column;align-items:center;gap:6px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#D4D9E8" stroke-width="1.5"
                                    style="width:28px;height:28px;">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <span style="font-size:11px;color:#D4D9E8;font-weight:500;">Belum ada foto</span>
                            </div>
                            {{-- Badge "foto lama" --}}
                            <span id="editVehiclePhotoOldBadge"
                                style="display:none;position:absolute;top:6px;left:6px;
                       font-size:10px;font-weight:700;color:#4A5272;
                       background:rgba(255,255,255,.88);border:1px solid #D4D9E8;
                       border-radius:6px;padding:2px 7px;">
                                Foto saat ini
                            </span>
                            {{-- Badge "foto baru" --}}
                            <span id="editVehiclePhotoNewBadge"
                                style="display:none;position:absolute;top:6px;left:6px;
                       font-size:10px;font-weight:700;color:#027A48;
                       background:rgba(236,253,243,.92);border:1px solid #6CE9A6;
                       border-radius:6px;padding:2px 7px;">
                                Foto baru
                            </span>
                        </div>

                        <label for="editVehiclePhoto"
                            style="display:flex;align-items:center;gap:10px;height:38px;
                   border:1.5px dashed #D4D9E8;border-radius:10px;
                   padding:0 12px;cursor:pointer;background:#FAFBFD;
                   transition:border-color .2s;"
                            onmouseover="this.style.borderColor='#3B6FD4'" onmouseout="this.style.borderColor='#D4D9E8'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:15px;height:15px;flex-shrink:0;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <span id="editVehiclePhotoLabel"
                                style="font-size:12px;color:#8A93AE;overflow:hidden;
                       text-overflow:ellipsis;white-space:nowrap;flex:1;">
                                Ganti foto...
                            </span>
                            <input type="file" id="editVehiclePhoto" name="vehicle_photo" accept=".jpg,.jpeg,.png"
                                style="display:none;"
                                onchange="previewEditPhoto('editVehiclePhoto','editVehiclePhotoPreview',
                    'editVehiclePhotoNone','editVehiclePhotoLabel',
                    'editVehiclePhotoOldBadge','editVehiclePhotoNewBadge')">
                        </label>
                    </div>

                    {{-- Foto STNK --}}
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Foto STNK
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>

                        {{-- Preview --}}
                        <div id="editStnkPhotoPreviewWrap"
                            style="width:100%;height:100px;border-radius:10px;overflow:hidden;
                   border:1.5px solid #EBEEF5;background:#F5F7FC;margin-bottom:8px;
                   display:flex;align-items:center;justify-content:center;position:relative;">
                            <img id="editStnkPhotoPreview" src="" alt="Preview STNK"
                                style="width:100%;height:100%;object-fit:cover;display:none;">
                            <div id="editStnkPhotoNone"
                                style="display:flex;flex-direction:column;align-items:center;gap:6px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#D4D9E8" stroke-width="1.5"
                                    style="width:28px;height:28px;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                                <span style="font-size:11px;color:#D4D9E8;font-weight:500;">Belum ada foto</span>
                            </div>
                            <span id="editStnkPhotoOldBadge"
                                style="display:none;position:absolute;top:6px;left:6px;
                       font-size:10px;font-weight:700;color:#4A5272;
                       background:rgba(255,255,255,.88);border:1px solid #D4D9E8;
                       border-radius:6px;padding:2px 7px;">
                                Foto saat ini
                            </span>
                            <span id="editStnkPhotoNewBadge"
                                style="display:none;position:absolute;top:6px;left:6px;
                       font-size:10px;font-weight:700;color:#027A48;
                       background:rgba(236,253,243,.92);border:1px solid #6CE9A6;
                       border-radius:6px;padding:2px 7px;">
                                Foto baru
                            </span>
                        </div>

                        <label for="editStnkPhoto"
                            style="display:flex;align-items:center;gap:10px;height:38px;
                   border:1.5px dashed #D4D9E8;border-radius:10px;
                   padding:0 12px;cursor:pointer;background:#FAFBFD;
                   transition:border-color .2s;"
                            onmouseover="this.style.borderColor='#3B6FD4'" onmouseout="this.style.borderColor='#D4D9E8'">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:15px;height:15px;flex-shrink:0;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                            <span id="editStnkPhotoLabel"
                                style="font-size:12px;color:#8A93AE;overflow:hidden;
                       text-overflow:ellipsis;white-space:nowrap;flex:1;">
                                Ganti foto...
                            </span>
                            <input type="file" id="editStnkPhoto" name="stnk_photo" accept=".jpg,.jpeg,.png"
                                style="display:none;"
                                onchange="previewEditPhoto('editStnkPhoto','editStnkPhotoPreview',
                    'editStnkPhotoNone','editStnkPhotoLabel',
                    'editStnkPhotoOldBadge','editStnkPhotoNewBadge')">
                        </label>
                    </div>

                </div>

                {{-- Status Aktif Toggle --}}
                <div
                    style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;
                            padding:12px 14px;background:#F5F7FC;border-radius:10px;border:1.5px solid #EBEEF5;">
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#181D35;">Status Kendaraan</div>
                        <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;">Aktifkan atau nonaktifkan kendaraan
                        </div>
                    </div>
                    <label style="position:relative;display:inline-block;width:44px;height:24px;cursor:pointer;">
                        <input type="checkbox" name="is_active" id="editIsActive" value="1"
                            style="opacity:0;width:0;height:0;">
                        <span id="toggleTrack"
                            style="position:absolute;inset:0;border-radius:100px;
                                   background:#D4D9E8;transition:background .2s;"></span>
                        <span id="toggleThumb"
                            style="position:absolute;top:3px;left:3px;width:18px;height:18px;
                                   background:#fff;border-radius:50%;transition:transform .2s;
                                   box-shadow:0 1px 4px rgba(0,0,0,.15);"></span>
                    </label>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeEditModal()" class="btn-outline" style="flex:1;">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════
     MODAL — Detail Kendaraan
══════════════════════════════════════ --}}
    <div id="modalDetail"
        style="display:none;position:fixed;inset:0;z-index:200;
           background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
           align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:520px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                margin:16px;max-height:90vh;overflow-y:auto;">

            {{-- Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div
                        style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                            border:1.5px solid #C0D3F5;display:flex;align-items:center;
                            justify-content:center;flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                            style="width:18px;height:18px;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                            Detail Kendaraan
                        </div>
                        <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                            Informasi lengkap kendaraan
                        </div>
                    </div>
                </div>
                <button onclick="closeDetailModal()"
                    style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                       background:none;cursor:pointer;display:flex;align-items:center;
                       justify-content:center;transition:border-color .2s,background .2s;"
                    onmouseover="this.style.borderColor='#D4D9E8';this.style.background='#F5F7FC'"
                    onmouseout="this.style.borderColor='#EBEEF5';this.style.background='none'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                        style="width:14px;height:14px;">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            {{-- Foto Kendaraan --}}
            <div id="detailPhotoWrap"
                style="width:100%;height:180px;border-radius:14px;overflow:hidden;
                   border:1.5px solid #EBEEF5;background:#F5F7FC;
                   display:flex;align-items:center;justify-content:center;
                   margin-bottom:20px;">
                <img id="detailPhoto" src="" alt="Foto Kendaraan"
                    style="width:100%;height:100%;object-fit:cover;display:none;">
                <div id="detailPhotoPlaceholder" style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#C0D3F5" stroke-width="1.5"
                        style="width:40px;height:40px;">
                        <rect x="3" y="11" width="18" height="5" rx="2" />
                        <circle cx="7" cy="18" r="2" />
                        <circle cx="17" cy="18" r="2" />
                        <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                    </svg>
                    <span style="font-size:12px;color:#C0D3F5;font-weight:500;">Tidak ada foto</span>
                </div>
            </div>

            {{-- Nomor Plat besar --}}
            <div style="text-align:center;margin-bottom:20px;">
                <div
                    style="display:inline-block;font-family:monospace;font-size:22px;font-weight:800;
                       letter-spacing:0.12em;color:#181D35;background:#F5F7FC;
                       border:2px solid #D4D9E8;border-radius:10px;
                       padding:8px 24px;">
                    <span id="detailPlate">—</span>
                </div>
            </div>

            {{-- Badge Status --}}
            <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px;">
                <span id="detailStatusAktif"
                    style="display:inline-flex;align-items:center;gap:5px;
                       font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;">
                </span>
                <span id="detailStatusParkir"
                    style="display:inline-flex;align-items:center;gap:5px;
                       font-size:12px;font-weight:600;padding:4px 12px;border-radius:100px;">
                </span>
            </div>

            {{-- Divider --}}
            <div style="height:1px;background:#EBEEF5;margin-bottom:20px;"></div>

            {{-- Info Grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">

                {{-- Jenis --}}
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:6px;">
                        Jenis</div>
                    <div id="detailType" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>

                {{-- Merek --}}
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:6px;">
                        Merek</div>
                    <div id="detailBrand" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>

                {{-- Model --}}
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
            letter-spacing:0.06em;margin-bottom:6px;">
                        Model</div>
                    <div id="detailModel" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>

                {{-- Warna --}}
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:6px;">
                        Warna</div>
                    <div id="detailColor" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>

                {{-- Terdaftar --}}
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:6px;">
                        Terdaftar</div>
                    <div id="detailCreatedAt" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>

            </div>

            {{-- Pemilik --}}
            <div id="detailOwnerWrap"
                style="padding:14px 16px;background:#F5F7FC;border-radius:12px;
                   border:1.5px solid #EBEEF5;margin-bottom:20px;
                   display:flex;align-items:center;gap:12px;">
                <div id="detailOwnerAvatar"
                    style="width:38px;height:38px;border-radius:50%;
                       background:#E8F0FB;border:1.5px solid #C0D3F5;
                       display:flex;align-items:center;justify-content:center;
                       flex-shrink:0;font-size:14px;font-weight:700;color:#1A4BAD;">
                </div>
                <div>
                    <div
                        style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:4px;">
                        Pemilik</div>
                    <div id="detailOwnerName" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                    <div id="detailOwnerEmail" style="font-size:12px;color:#8A93AE;margin-top:1px;">—</div>
                </div>
            </div>

            {{-- Foto STNK --}}
            <div id="detailStnkSection" style="margin-bottom:20px;display:none;">
                <div
                    style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                        letter-spacing:0.06em;margin-bottom:8px;">
                    Foto STNK</div>
                <a id="detailStnkLink" href="#" target="_blank"
                    style="display:block;width:100%;height:120px;border-radius:12px;overflow:hidden;
                       border:1.5px solid #EBEEF5;text-decoration:none;">
                    <img id="detailStnkPhoto" src="" alt="STNK"
                        style="width:100%;height:100%;object-fit:cover;">
                </a>
            </div>

            {{-- Info parkir (waktu masuk) --}}
            <div id="detailParkedAtWrap" style="display:none;margin-bottom:20px;">
                <div
                    style="padding:12px 14px;background:#EFF8FF;border-radius:10px;
                       border:1px solid #84CAFF;display:flex;align-items:center;gap:10px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1D74C4" stroke-width="2"
                        style="width:15px;height:15px;flex-shrink:0;">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <div>
                        <span style="font-size:12px;color:#1D74C4;font-weight:600;">Mulai parkir: </span>
                        <span id="detailParkedAt" style="font-size:12px;color:#1D74C4;font-weight:700;"></span>
                    </div>
                </div>
            </div>

            {{-- Tombol tutup --}}
            <button onclick="closeDetailModal()" class="btn-outline" style="width:100%;justify-content:center;">
                Tutup
            </button>

        </div>
    </div>

    {{-- ══════════════════════════════════════
         MODAL — Konfirmasi Hapus
    ══════════════════════════════════════ --}}
    <div id="modalDelete"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:400px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;text-align:center;">

            <div
                style="width:60px;height:60px;background:#FEF3F2;border-radius:16px;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                    style="width:28px;height:28px;">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                </svg>
            </div>

            <div
                style="font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:800;
                        color:#181D35;margin-bottom:8px;">
                Hapus Kendaraan?
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
                Kendaraan dengan plat <strong id="deletePlateNumber"
                    style="color:#181D35;background:#F5F7FC;padding:1px 8px;
                           border-radius:6px;border:1px solid #D4D9E8;font-family:monospace;"></strong>
                akan dihapus permanen.
            </div>
            <div
                style="font-size:12.5px;color:#F79009;background:#FFFAEB;
                        border:1px solid #FDE68A;border-radius:10px;
                        padding:10px 14px;margin-bottom:24px;line-height:1.6;">
                ⚠ Tindakan ini tidak dapat dibatalkan.
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeDeleteModal()" class="btn-outline" style="flex:1;">
                        Batal
                    </button>
                    <button type="submit"
                        style="flex:1;height:38px;border:none;border-radius:10px;
                               background:#D92D20;color:#fff;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;font-weight:600;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='#912018'" onmouseout="this.style.background='#D92D20'">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ═══════════════════════════════
        // TOAST NOTIFICATION
        // ═══════════════════════════════
        function showToast(type, message) {
            const configs = {
                success: {
                    bg: '#ECFDF3',
                    border: '#6CE9A6',
                    icon: '#12B76A',
                    text: '#027A48',
                    svg: '<polyline points="20 6 9 17 4 12"/>'
                },
                error: {
                    bg: '#FEF3F2',
                    border: '#FECDCA',
                    icon: '#D92D20',
                    text: '#912018',
                    svg: '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'
                },
                warning: {
                    bg: '#FFFAEB',
                    border: '#FDE68A',
                    icon: '#F79009',
                    text: '#B54708',
                    svg: '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>'
                },
            };

            const c = configs[type] || configs.success;
            const id = 'toast-' + Date.now();

            const toast = document.createElement('div');

            toast.id = id;
            toast.style.cssText = `
                pointer-events:auto;
                background:${c.bg};
                border:1.5px solid ${c.border};
                border-radius:12px;
                padding:12px 16px;
                display:flex;
                align-items:flex-start;
                gap:10px;
                min-width:280px;
                max-width:360px;
                box-shadow:0 8px 24px rgba(0,0,0,.10);
                animation:toastIn .25s ease;
                font-family:'DM Sans',sans-serif;
            `;

            toast.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2"
                    style="width:16px;height:16px;flex-shrink:0;margin-top:1px;">
                    ${c.svg}
                </svg>

                <span style="font-size:13px;color:${c.text};line-height:1.5;flex:1;">
                    ${message}
                </span>

                <button onclick="removeToast('${id}')"
                    style="background:none;border:none;cursor:pointer;padding:0;color:${c.icon};opacity:.6;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:14px;height:14px;">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            `;

            document.getElementById('toastContainer').appendChild(toast);

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
            @keyframes toastIn {
                from {
                    opacity:0;
                    transform:translateX(20px)
                }
                to {
                    opacity:1;
                    transform:translateX(0)
                }
            }

            @keyframes toastOut {
                from {
                    opacity:1;
                    transform:translateX(0)
                }
                to {
                    opacity:0;
                    transform:translateX(20px)
                }
            }
        `;

        document.head.appendChild(toastStyle);

        // ═══════════════════════════════
        // FILE NAME DISPLAY
        // ═══════════════════════════════
        function updateFileName(inputId, labelId) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);

            if (input.files && input.files[0]) {
                label.textContent = input.files[0].name;
                label.style.color = '#181D35';
            } else {
                label.textContent = 'Pilih foto...';
                label.style.color = '#8A93AE';
            }
        }

        // ═══════════════════════════════
        // FILTER MODEL BY BRAND
        // ═══════════════════════════════
        function filterModels(selectId, brandId) {
            const select = document.getElementById(selectId);

            if (!select) return;

            const current = select.value;

            Array.from(select.options).forEach(opt => {
                if (!opt.value) return;

                opt.hidden = opt.dataset.brand !== String(brandId);
            });

            if (select.options[select.selectedIndex]?.hidden) {
                select.value = '';
            }
        }

        // ═══════════════════════════════
        // SEARCH (debounce + submit)
        // ═══════════════════════════════
        let searchTimer;

        function debounceSearch() {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        }

        // ═══════════════════════════════
        // MODAL TAMBAH
        // ═══════════════════════════════
        function openModal() {
            document.getElementById('modalAdd').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalAdd').style.display = 'none';
        }

        // ═══════════════════════════════
        // MODAL EDIT
        // ═══════════════════════════════
        function openEditModal(
            id,
            userId,
            vehicleTypeId,
            vehicleBrandId,
            vehicleModelId,
            plateNumber,
            color,
            isActive,
            vehiclePhotoUrl,
            stnkPhotoUrl
        ) {

            document.getElementById('editUserId').value = userId ?? '';
            document.getElementById('editVehicleTypeId').value = vehicleTypeId;

            document.getElementById('editVehicleBrandId').value = vehicleBrandId;

            // FILTER MODEL
            filterModels('editVehicleModelId', vehicleBrandId);

            document.getElementById('editVehicleModelId').value = vehicleModelId ?? '';

            document.getElementById('editPlateNumber').value = plateNumber;
            document.getElementById('editColor').value = color;

            document.getElementById('editForm').action = '/admin/vehicles/' + id;

            // Reset file inputs + label
            ['editVehiclePhoto', 'editStnkPhoto'].forEach(inputId => {
                document.getElementById(inputId).value = '';
            });

            document.getElementById('editVehiclePhotoLabel').textContent = 'Ganti foto...';
            document.getElementById('editVehiclePhotoLabel').style.color = '#8A93AE';

            document.getElementById('editStnkPhotoLabel').textContent = 'Ganti foto...';
            document.getElementById('editStnkPhotoLabel').style.color = '#8A93AE';

            // Preview kendaraan
            _setEditPreview(
                vehiclePhotoUrl,
                'editVehiclePhotoPreview',
                'editVehiclePhotoNone',
                'editVehiclePhotoOldBadge',
                'editVehiclePhotoNewBadge'
            );

            // Preview STNK
            _setEditPreview(
                stnkPhotoUrl,
                'editStnkPhotoPreview',
                'editStnkPhotoNone',
                'editStnkPhotoOldBadge',
                'editStnkPhotoNewBadge'
            );

            // Toggle aktif
            const checkbox = document.getElementById('editIsActive');
            const track = document.getElementById('toggleTrack');
            const thumb = document.getElementById('toggleThumb');

            checkbox.checked = isActive;

            track.style.background = isActive ? '#1A4BAD' : '#D4D9E8';
            thumb.style.transform = isActive ? 'translateX(20px)' : 'translateX(0)';

            document.getElementById('modalEdit').style.display = 'flex';

            setTimeout(() => {
                document.getElementById('editPlateNumber').focus();
            }, 100);
        }

        // ═══════════════════════════════
        // HELPER PREVIEW
        // ═══════════════════════════════
        function _setEditPreview(url, imgId, noneId, oldBadgeId, newBadgeId) {
            const img = document.getElementById(imgId);
            const none = document.getElementById(noneId);
            const oldBadge = document.getElementById(oldBadgeId);
            const newBadge = document.getElementById(newBadgeId);

            newBadge.style.display = 'none';

            if (url) {
                img.src = url;
                img.style.display = 'block';

                none.style.display = 'none';

                oldBadge.style.display = 'inline-block';
            } else {
                img.src = '';

                img.style.display = 'none';

                none.style.display = 'flex';

                oldBadge.style.display = 'none';
            }
        }

        // ═══════════════════════════════
        // PREVIEW FILE EDIT
        // ═══════════════════════════════
        function previewEditPhoto(inputId, imgId, noneId, labelId, oldBadgeId, newBadgeId) {

            const input = document.getElementById(inputId);
            const img = document.getElementById(imgId);
            const none = document.getElementById(noneId);
            const label = document.getElementById(labelId);
            const oldBadge = document.getElementById(oldBadgeId);
            const newBadge = document.getElementById(newBadgeId);

            if (input.files && input.files[0]) {

                const reader = new FileReader();

                reader.onload = e => {
                    img.src = e.target.result;

                    img.style.display = 'block';
                    none.style.display = 'none';

                    oldBadge.style.display = 'none';
                    newBadge.style.display = 'inline-block';
                };

                reader.readAsDataURL(input.files[0]);

                label.textContent = input.files[0].name;
                label.style.color = '#181D35';
            }
        }

        function closeEditModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        // ═══════════════════════════════
        // MODAL DETAIL
        // ═══════════════════════════════
        function openDetailModal(
            plate,
            color,
            type,
            brand,
            modelName,
            ownerName,
            ownerEmail,
            isActive,
            isParked,
            parkedAt,
            createdAt,
            vehiclePhotoUrl,
            stnkPhotoUrl
        ) {

            // Plat
            document.getElementById('detailPlate').textContent = plate;

            // Info
            document.getElementById('detailType').textContent = type;
            document.getElementById('detailBrand').textContent = brand;
            document.getElementById('detailModel').textContent = modelName || '—';
            document.getElementById('detailColor').textContent = color || '—';
            document.getElementById('detailCreatedAt').textContent = createdAt;

            // Status aktif
            const statusAktif = document.getElementById('detailStatusAktif');

            if (isActive) {
                statusAktif.innerHTML =
                    '<span style="width:6px;height:6px;border-radius:50%;background:#12B76A;display:inline-block;"></span> Aktif';

                statusAktif.style.cssText +=
                    'background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48;';
            } else {
                statusAktif.innerHTML =
                    '<span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span> Nonaktif';

                statusAktif.style.cssText +=
                    'background:#F5F7FC;border:1px solid #D4D9E8;color:#8A93AE;';
            }

            // Status parkir
            const statusParkir = document.getElementById('detailStatusParkir');

            if (isParked) {
                statusParkir.innerHTML =
                    `<svg viewBox="0 0 24 24" fill="none" stroke="#1D74C4" stroke-width="2.5"
                        style="width:11px;height:11px;flex-shrink:0;">
                        <rect x="3" y="11" width="18" height="5" rx="2"/>
                        <circle cx="7" cy="18" r="2"/>
                        <circle cx="17" cy="18" r="2"/>
                        <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/>
                    </svg> Sedang Parkir`;

                statusParkir.style.cssText +=
                    'background:#EFF8FF;border:1px solid #84CAFF;color:#1D74C4;';
            } else {
                statusParkir.innerHTML =
                    '<span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span> Tidak Parkir';

                statusParkir.style.cssText +=
                    'background:#F5F7FC;border:1px solid #D4D9E8;color:#8A93AE;';
            }

            // Waktu parkir
            const parkedWrap = document.getElementById('detailParkedAtWrap');

            if (isParked && parkedAt) {
                document.getElementById('detailParkedAt').textContent = parkedAt;

                parkedWrap.style.display = 'block';
            } else {
                parkedWrap.style.display = 'none';
            }

            // Foto kendaraan
            const photo = document.getElementById('detailPhoto');
            const placeholder = document.getElementById('detailPhotoPlaceholder');

            if (vehiclePhotoUrl) {
                photo.src = vehiclePhotoUrl;

                photo.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                photo.style.display = 'none';
                placeholder.style.display = 'flex';
            }

            // Foto STNK
            const stnkSection = document.getElementById('detailStnkSection');

            if (stnkPhotoUrl) {
                document.getElementById('detailStnkPhoto').src = stnkPhotoUrl;
                document.getElementById('detailStnkLink').href = stnkPhotoUrl;

                stnkSection.style.display = 'block';
            } else {
                stnkSection.style.display = 'none';
            }

            // Pemilik
            if (ownerName) {
                document.getElementById('detailOwnerAvatar').textContent =
                    ownerName.charAt(0).toUpperCase();

                document.getElementById('detailOwnerName').textContent = ownerName;

                document.getElementById('detailOwnerEmail').textContent =
                    ownerEmail || '—';
            } else {
                document.getElementById('detailOwnerAvatar').textContent = '?';

                document.getElementById('detailOwnerName').textContent =
                    '— Tidak ada pemilik —';

                document.getElementById('detailOwnerEmail').textContent = '';
            }

            document.getElementById('modalDetail').style.display = 'flex';
        }

        function closeDetailModal() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        // Toggle visual update
        document.getElementById('editIsActive').addEventListener('change', function() {

            document.getElementById('toggleTrack').style.background =
                this.checked ? '#1A4BAD' : '#D4D9E8';

            document.getElementById('toggleThumb').style.transform =
                this.checked ? 'translateX(20px)' : 'translateX(0)';
        });

        // ═══════════════════════════════
        // MODAL HAPUS
        // ═══════════════════════════════
        function confirmDelete(id, plateNumber) {
            document.getElementById('deletePlateNumber').textContent = plateNumber;

            document.getElementById('deleteForm').action =
                '/admin/vehicles/' + id;

            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
        }

        // ═══════════════════════════════
        // BACKDROP & ESCAPE
        // ═══════════════════════════════
        ['modalAdd', 'modalEdit', 'modalDelete', 'modalDetail'].forEach(id => {

            document.getElementById(id).addEventListener('click', function(e) {

                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        });

        document.addEventListener('keydown', e => {

            if (e.key === 'Escape') {

                ['modalAdd', 'modalEdit', 'modalDelete', 'modalDetail']
                .forEach(id => {
                    document.getElementById(id).style.display = 'none';
                });
            }
        });
    </script>
@endpush
