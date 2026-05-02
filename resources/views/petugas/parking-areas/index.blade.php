@extends('layouts.app')

@section('title', 'Area Parkir')
@section('page_title', 'Area Parkir')

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
        <span style="color:#181D35;font-weight:600;">Area Parkir</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Area Parkir</div>
            <div class="page-sub">Informasi area dan slot parkir yang tersedia</div>
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

    {{-- ── Tabel Area Parkir ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Area Parkir</div>
                <div class="card-sub">{{ $parkingAreas->total() }} area parkir aktif dalam sistem</div>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('petugas.parking-areas.index') }}" id="searchForm">
                <div class="tb-search" style="width:240px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" name="search" id="searchInput"
                        placeholder="Cari nama atau kode area..."
                        value="{{ $search }}"
                        oninput="debounceSearch()">
                </div>
            </form>
        </div>

        @if ($parkingAreas->isEmpty())
            {{-- ── Empty state ── --}}
            <div style="padding:64px 24px;text-align:center;">
                <div
                    style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:28px;height:28px;">
                        <rect x="3" y="3" width="18" height="18" rx="3" />
                        <path d="M9 17V10a3 3 0 0 1 6 0v7" />
                        <line x1="9" y1="13" x2="15" y2="13" />
                    </svg>
                </div>
                <div
                    style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                            color:#181D35;margin-bottom:6px;">
                    {{ $search ? 'Tidak ada area yang cocok' : 'Belum ada area parkir' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;line-height:1.6;">
                    @if ($search)
                        Coba kata kunci lain atau
                        <a href="{{ route('petugas.parking-areas.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Belum ada area parkir aktif yang dapat ditampilkan
                    @endif
                </div>
            </div>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Nama Area</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Kode</th>
                        <th style="padding:14px 16px;width:130px;text-align:center;">Kapasitas</th>
                        <th style="padding:14px 16px;width:120px;text-align:center;">Status</th>
                        <th style="padding:14px 16px;width:140px;">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parkingAreas as $index => $area)
                        <tr>

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span
                                    style="font-size:12px;font-weight:600;color:#8A93AE;
                                             background:#F5F7FC;border:1px solid #EBEEF5;
                                             border-radius:6px;padding:3px 8px;
                                             display:inline-block;min-width:28px;text-align:center;">
                                    {{ $parkingAreas->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Nama Area --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div
                                        style="width:38px;height:38px;border-radius:10px;
                                                background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                display:flex;align-items:center;justify-content:center;
                                                flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                            style="width:17px;height:17px;">
                                            <rect x="3" y="3" width="18" height="18" rx="3" />
                                            <path d="M9 17V10a3 3 0 0 1 6 0v7" />
                                            <line x1="9" y1="13" x2="15" y2="13" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div style="font-weight:600;font-size:13.5px;color:#181D35;">
                                            {{ $area->name }}
                                        </div>
                                        @if ($area->description)
                                            <div style="font-size:11.5px;color:#8A93AE;margin-top:2px;
                                                        max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                {{ $area->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Kode --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <span
                                    style="font-family:monospace;font-size:12px;font-weight:700;
                                            letter-spacing:0.08em;
                                            background:#F5F7FC;border:1.5px solid #D4D9E8;
                                            color:#4A5272;padding:4px 10px;border-radius:7px;
                                            display:inline-block;">
                                    {{ $area->code }}
                                </span>
                            </td>

                            {{-- Kapasitas --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <span
                                    style="display:inline-flex;align-items:center;gap:5px;
                                            background:#E8F0FB;border:1px solid #C0D3F5;
                                            color:#1A4BAD;font-size:12px;font-weight:600;
                                            padding:4px 10px;border-radius:100px;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        style="width:12px;height:12px;">
                                        <rect x="3" y="11" width="18" height="5" rx="2" />
                                        <circle cx="7" cy="18" r="2" />
                                        <circle cx="17" cy="18" r="2" />
                                    </svg>
                                    {{ $area->capacity }} slot
                                </span>
                            </td>

                            {{-- Status --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($area->is_active)
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
                                {{ $area->created_at?->format('d M Y') ?? '-' }}
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
                    Menampilkan {{ $parkingAreas->firstItem() }}–{{ $parkingAreas->lastItem() }}
                    dari {{ $parkingAreas->total() }} area parkir
                </span>

                @if ($parkingAreas->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">

                        {{-- Prev --}}
                        @if ($parkingAreas->onFirstPage())
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
                            <a href="{{ $parkingAreas->previousPageUrl() }}"
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
                        @foreach ($parkingAreas->getUrlRange(1, $parkingAreas->lastPage()) as $page => $url)
                            @if ($page == $parkingAreas->currentPage())
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
                        @if ($parkingAreas->hasMorePages())
                            <a href="{{ $parkingAreas->nextPageUrl() }}"
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