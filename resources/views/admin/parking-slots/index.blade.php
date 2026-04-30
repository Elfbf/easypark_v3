@extends('layouts.app')

@section('title', 'Slot Parkir')
@section('page_title', 'Slot Parkir')

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
        <span style="color:#181D35;font-weight:600;">Slot Parkir</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Slot Parkir</div>
            <div class="page-sub">Kelola data slot parkir yang tersedia di setiap area</div>
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

    {{-- ── Tabel Slot Parkir ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Slot Parkir</div>
                <div class="card-sub">{{ $parkingSlots->total() }} slot parkir terdaftar dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.parking-slots.index') }}" id="searchForm">
                    <div class="tb-search" style="width:240px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text" name="search" id="searchInput"
                            placeholder="Cari kode slot..."
                            value="{{ $search }}"
                            oninput="debounceSearch()">
                    </div>
                </form>

                {{-- Tombol Tambah --}}
                <button class="btn-primary" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Slot
                </button>
            </div>
        </div>

        @if ($parkingSlots->isEmpty())
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
                    {{ $search ? 'Tidak ada slot yang cocok' : 'Belum ada slot parkir' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    @if ($search)
                        Coba kata kunci lain atau
                        <a href="{{ route('admin.parking-slots.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Tambahkan slot parkir pertama untuk mulai mengelola kapasitas parkir
                    @endif
                </div>
                @if (!$search)
                    <button class="btn-primary" onclick="openModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Slot Parkir
                    </button>
                @endif
            </div>
        @else
            <table class="data-table" id="slotTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Kode Slot</th>
                        <th style="padding:14px 16px;">Area Parkir</th>
                        <th style="padding:14px 16px;width:150px;">Jenis Kendaraan</th>
                        <th style="padding:14px 16px;width:140px;text-align:center;">Status Slot</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aktif</th>
                        <th style="padding:14px 16px;width:140px;">Dibuat</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parkingSlots as $index => $slot)
                        <tr id="row-{{ $slot->id }}">

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span
                                    style="font-size:12px;font-weight:600;color:#8A93AE;
                                             background:#F5F7FC;border:1px solid #EBEEF5;
                                             border-radius:6px;padding:3px 8px;
                                             display:inline-block;min-width:28px;text-align:center;">
                                    {{ $parkingSlots->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Kode Slot --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div
                                        style="width:38px;height:38px;border-radius:10px;
                                                background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                display:flex;align-items:center;justify-content:center;
                                                flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                            style="width:17px;height:17px;">
                                            <rect x="3" y="11" width="18" height="5" rx="2" />
                                            <circle cx="7" cy="18" r="2" />
                                            <circle cx="17" cy="18" r="2" />
                                            <path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div style="font-family:monospace;font-weight:700;font-size:14px;
                                                    letter-spacing:0.08em;color:#181D35;">
                                            {{ $slot->slot_code }}
                                        </div>
                                        <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;">
                                            ID #{{ $slot->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Area Parkir --}}
                            <td style="padding:14px 16px;">
                                @if ($slot->parkingArea)
                                    <div style="display:flex;align-items:center;gap:7px;">
                                        <span
                                            style="font-family:monospace;font-size:11px;font-weight:700;
                                                    letter-spacing:0.06em;background:#F5F7FC;
                                                    border:1.5px solid #D4D9E8;color:#4A5272;
                                                    padding:2px 7px;border-radius:5px;">
                                            {{ $slot->parkingArea->code }}
                                        </span>
                                        <span style="font-size:13px;color:#181D35;font-weight:500;">
                                            {{ $slot->parkingArea->name }}
                                        </span>
                                    </div>
                                @else
                                    <span style="font-size:12px;color:#8A93AE;font-style:italic;">—</span>
                                @endif
                            </td>

                            {{-- Jenis Kendaraan --}}
                            <td style="padding:14px 16px;">
                                @if ($slot->vehicleType)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F0FF;border:1px solid #D9C8FA;
                                                color:#6B3DB5;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:11px;height:11px;">
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        {{ $slot->vehicleType->name }}
                                    </span>
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:500;
                                                padding:4px 10px;border-radius:100px;">
                                        Semua Jenis
                                    </span>
                                @endif
                            </td>

                            {{-- Status Slot --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($slot->status === 'available')
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;"></span>
                                        Tersedia
                                    </span>
                                @elseif ($slot->status === 'occupied')
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#FEF3F2;border:1px solid #FECDCA;
                                                color:#912018;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#D92D20;display:inline-block;"></span>
                                        Terisi
                                    </span>
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#FFFAEB;border:1px solid #FDE68A;
                                                color:#B54708;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#F79009;display:inline-block;"></span>
                                        Maintenance
                                    </span>
                                @endif
                            </td>

                            {{-- Aktif --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($slot->is_active)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Dibuat --}}
                            <td style="padding:14px 16px;color:#8A93AE;font-size:12.5px;">
                                {{ $slot->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                    {{-- Edit --}}
                                    <button class="tb-btn" title="Edit slot parkir"
                                        onclick="openEditModal(
                                            {{ $slot->id }},
                                            '{{ addslashes($slot->slot_code) }}',
                                            {{ $slot->parking_area_id }},
                                            {{ $slot->vehicle_type_id ?? 'null' }},
                                            '{{ $slot->status }}',
                                            {{ $slot->is_active ? 'true' : 'false' }}
                                        )"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <button class="tb-btn" title="Hapus slot parkir"
                                        onclick="confirmDelete({{ $slot->id }}, '{{ addslashes($slot->slot_code) }}')"
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
                    Menampilkan {{ $parkingSlots->firstItem() }}–{{ $parkingSlots->lastItem() }}
                    dari {{ $parkingSlots->total() }} slot parkir
                </span>

                @if ($parkingSlots->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        {{-- Prev --}}
                        @if ($parkingSlots->onFirstPage())
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
                            <a href="{{ $parkingSlots->previousPageUrl() }}"
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
                        @foreach ($parkingSlots->getUrlRange(1, $parkingSlots->lastPage()) as $page => $url)
                            @if ($page == $parkingSlots->currentPage())
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
                        @if ($parkingSlots->hasMorePages())
                            <a href="{{ $parkingSlots->nextPageUrl() }}"
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
         MODAL — Tambah Slot Parkir
    ══════════════════════════════════════ --}}
    <div id="modalAdd"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:480px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;">

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
                        Tambah Slot Parkir
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Buat slot parkir baru dalam sistem
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.parking-slots.store') }}" method="POST">
                @csrf

                {{-- Kode Slot --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Kode Slot <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="slot_code" placeholder="Contoh: A-01"
                        autocomplete="off" required
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:monospace;
                               font-size:13.5px;color:#181D35;background:#fff;text-transform:uppercase;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    @error('slot_code')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Area Parkir --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Area Parkir <span style="color:#D92D20;">*</span>
                    </label>
                    <select name="parking_area_id" required
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               appearance:none;cursor:pointer;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <option value="">— Pilih Area Parkir —</option>
                        @foreach ($parkingAreas as $area)
                            <option value="{{ $area->id }}">{{ $area->code }} — {{ $area->name }}</option>
                        @endforeach
                    </select>
                    @error('parking_area_id')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kendaraan & Status side by side --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Jenis Kendaraan
                            <span style="font-weight:400;color:#8A93AE;">(opsional)</span>
                        </label>
                        <select name="vehicle_type_id"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   appearance:none;cursor:pointer;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="">Semua Jenis</option>
                            @foreach ($vehicleTypes as $vt)
                                <option value="{{ $vt->id }}">{{ $vt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Status Slot <span style="color:#D92D20;">*</span>
                        </label>
                        <select name="status" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   appearance:none;cursor:pointer;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="available">Tersedia</option>
                            <option value="occupied">Terisi</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        @error('status')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeModal()" class="btn-outline" style="flex:1;">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Simpan Slot
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Edit Slot Parkir
    ══════════════════════════════════════ --}}
    <div id="modalEdit"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:480px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                    margin:16px;">

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
                        Edit Slot Parkir
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Ubah data slot parkir yang dipilih
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                {{-- Kode Slot --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Kode Slot <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="slot_code" id="editSlotCode" required autocomplete="off"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:monospace;
                               font-size:13.5px;color:#181D35;background:#fff;text-transform:uppercase;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                </div>

                {{-- Area Parkir --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Area Parkir <span style="color:#D92D20;">*</span>
                    </label>
                    <select name="parking_area_id" id="editParkingAreaId" required
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               appearance:none;cursor:pointer;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <option value="">— Pilih Area Parkir —</option>
                        @foreach ($parkingAreas as $area)
                            <option value="{{ $area->id }}">{{ $area->code }} — {{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Kendaraan & Status --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Jenis Kendaraan
                        </label>
                        <select name="vehicle_type_id" id="editVehicleTypeId"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   appearance:none;cursor:pointer;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="">Semua Jenis</option>
                            @foreach ($vehicleTypes as $vt)
                                <option value="{{ $vt->id }}">{{ $vt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Status Slot <span style="color:#D92D20;">*</span>
                        </label>
                        <select name="status" id="editStatus" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   appearance:none;cursor:pointer;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="available">Tersedia</option>
                            <option value="occupied">Terisi</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                {{-- Status Toggle --}}
                <div style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;
                            padding:12px 14px;background:#F5F7FC;border-radius:10px;border:1.5px solid #EBEEF5;">
                    <div>
                        <div style="font-size:13px;font-weight:600;color:#181D35;">Status Slot</div>
                        <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;">Aktifkan atau nonaktifkan slot parkir</div>
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
                Hapus Slot Parkir?
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
                Slot <strong id="deleteSlotCode"
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
                        onmouseover="this.style.background='#912018'"
                        onmouseout="this.style.background='#D92D20'">
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
            const c = configs[type] || configs.success;
            const id = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = id;
            toast.style.cssText = `pointer-events:auto;background:${c.bg};border:1.5px solid ${c.border};
                border-radius:12px;padding:12px 16px;display:flex;align-items:flex-start;gap:10px;
                min-width:280px;max-width:360px;box-shadow:0 8px 24px rgba(0,0,0,.10);
                animation:toastIn .25s ease;font-family:'DM Sans',sans-serif;`;
            toast.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2"
                    style="width:16px;height:16px;flex-shrink:0;margin-top:1px;">${c.svg}</svg>
                <span style="font-size:13px;color:${c.text};line-height:1.5;flex:1;">${message}</span>
                <button onclick="removeToast('${id}')"
                    style="background:none;border:none;cursor:pointer;padding:0;color:${c.icon};opacity:.6;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>`;
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
            @keyframes toastIn  { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }
            @keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(20px)} }`;
        document.head.appendChild(toastStyle);

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
        function openEditModal(id, slotCode, parkingAreaId, vehicleTypeId, status, isActive) {
            document.getElementById('editSlotCode').value       = slotCode;
            document.getElementById('editParkingAreaId').value  = parkingAreaId;
            document.getElementById('editVehicleTypeId').value  = vehicleTypeId ?? '';
            document.getElementById('editStatus').value         = status;
            document.getElementById('editForm').action          = '/admin/parking-slots/' + id;

            const checkbox = document.getElementById('editIsActive');
            const track    = document.getElementById('toggleTrack');
            const thumb    = document.getElementById('toggleThumb');
            checkbox.checked           = isActive;
            track.style.background     = isActive ? '#1A4BAD' : '#D4D9E8';
            thumb.style.transform      = isActive ? 'translateX(20px)' : 'translateX(0)';

            document.getElementById('modalEdit').style.display = 'flex';
            setTimeout(() => document.getElementById('editSlotCode').focus(), 100);
        }

        function closeEditModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        // Toggle visual update
        document.getElementById('editIsActive').addEventListener('change', function () {
            document.getElementById('toggleTrack').style.background = this.checked ? '#1A4BAD' : '#D4D9E8';
            document.getElementById('toggleThumb').style.transform  = this.checked ? 'translateX(20px)' : 'translateX(0)';
        });

        // ═══════════════════════════════
        // MODAL HAPUS
        // ═══════════════════════════════
        function confirmDelete(id, slotCode) {
            document.getElementById('deleteSlotCode').textContent = slotCode;
            document.getElementById('deleteForm').action = '/admin/parking-slots/' + id;
            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
        }

        // ── Tutup modal backdrop & Escape ──
        ['modalAdd', 'modalEdit', 'modalDelete'].forEach(id => {
            document.getElementById(id).addEventListener('click', function (e) {
                if (e.target === this) this.style.display = 'none';
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape')
                ['modalAdd', 'modalEdit', 'modalDelete'].forEach(id =>
                    document.getElementById(id).style.display = 'none');
        });
    </script>
@endpush