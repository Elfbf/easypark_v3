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
        <a href="{{ route('petugas.dashboard') }}" style="color:#8A93AE;text-decoration:none;">Petugas</a>
        <span style="color:#D4D9E8;">/</span>
        <span style="color:#181D35;font-weight:600;">Slot Parkir</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Slot Parkir</div>
            <div class="page-sub">Informasi slot parkir yang tersedia di setiap area</div>
        </div>
    </div>

    {{-- ══ TOAST CONTAINER ══ --}}
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

    {{-- ── Tabel Slot Parkir ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Slot Parkir</div>
                <div class="card-sub">{{ $parkingSlots->total() }} slot parkir aktif dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                {{-- Filter Area --}}
                <form method="GET" action="{{ route('petugas.parking-slots.index') }}" id="searchForm">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <select name="parking_area_id"
                            onchange="document.getElementById('searchForm').submit()"
                            style="height:38px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 12px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13px;color:#181D35;background:#fff;
                                   appearance:none;cursor:pointer;">
                            <option value="">Semua Area</option>
                            @foreach ($parkingAreas as $area)
                                <option value="{{ $area->id }}"
                                    {{ $areaFilter == $area->id ? 'selected' : '' }}>
                                    {{ $area->code }} — {{ $area->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Search --}}
                        <div class="tb-search" style="width:220px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="M21 21l-4.35-4.35" />
                            </svg>
                            <input type="text" name="search" id="searchInput"
                                placeholder="Cari kode slot..."
                                value="{{ $search }}"
                                oninput="debounceSearch()">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($parkingSlots->isEmpty())
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
                    {{ $search || $areaFilter ? 'Tidak ada slot yang cocok' : 'Belum ada slot parkir' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;line-height:1.6;">
                    @if ($search || $areaFilter)
                        Coba filter lain atau
                        <a href="{{ route('petugas.parking-slots.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Belum ada slot parkir aktif yang dapat ditampilkan
                    @endif
                </div>
            </div>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Kode Slot</th>
                        <th style="padding:14px 16px;">Area Parkir</th>
                        <th style="padding:14px 16px;width:150px;">Jenis Kendaraan</th>
                        <th style="padding:14px 16px;width:140px;text-align:center;">Status Slot</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aktif</th>
                        <th style="padding:14px 16px;width:140px;">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parkingSlots as $index => $slot)
                        <tr>

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

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer + Pagination --}}
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

@endsection

@push('scripts')
    <script>
        // ═══════════════════════════════
        // TOAST
        // ═══════════════════════════════
        function showToast(type, message) {
            const configs = {
                success: { bg:'#ECFDF3', border:'#6CE9A6', icon:'#12B76A', text:'#027A48',
                    svg:'<polyline points="20 6 9 17 4 12"/>' },
                error:   { bg:'#FEF3F2', border:'#FECDCA', icon:'#D92D20', text:'#912018',
                    svg:'<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>' },
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
        // SEARCH
        // ═══════════════════════════════
        let searchTimer;
        function debounceSearch() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => document.getElementById('searchForm').submit(), 500);
        }
    </script>
@endpush