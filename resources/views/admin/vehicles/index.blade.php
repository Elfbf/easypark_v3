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
            <div class="page-sub">Data kendaraan yang terdaftar dalam sistem</div>
        </div>
    </div>

    {{-- ── Tabel Kendaraan ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Kendaraan</div>
                <div class="card-sub">{{ $vehicles->total() }} kendaraan terdaftar dalam sistem</div>
            </div>

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
        </div>

        @if ($vehicles->isEmpty())
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
                <div style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:#181D35;margin-bottom:6px;">
                    {{ $search ? 'Tidak ada kendaraan yang cocok' : 'Belum ada kendaraan' }}
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    @if ($search)
                        Coba kata kunci lain atau
                        <a href="{{ route('admin.vehicles.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">reset pencarian</a>
                    @else
                        Belum ada kendaraan yang terdaftar dalam sistem
                    @endif
                </div>
            </div>
        @else
            <table class="data-table" id="vehicleTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Kendaraan</th>
                        <th style="padding:14px 16px;">Pemilik</th>
                        <th style="padding:14px 16px;width:260px;">Tipe</th>
                        <th style="padding:14px 16px;width:140px;">Status Parkir</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aktif</th>
                        <th style="padding:14px 16px;width:140px;">Terdaftar</th>
                        <th style="padding:14px 16px;width:80px;text-align:center;">Aksi</th>
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

                            {{-- Kendaraan --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
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
                                        <div style="font-family:monospace;font-weight:700;font-size:14px;
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

                            {{-- Tipe / Merek / Model --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;">
                                    @if ($vehicle->type)
                                        <span style="display:inline-flex;align-items:center;
                                               background:#F5F0FF;border:1px solid #D9C8FA;
                                               color:#6B3DB5;font-size:11.5px;font-weight:600;
                                               padding:4px 10px;border-radius:100px;">
                                            {{ $vehicle->type->name }}
                                        </span>
                                    @endif
                                    @if ($vehicle->brand)
                                        <span style="display:inline-flex;align-items:center;
                                               background:#F5F7FC;border:1px solid #D4D9E8;
                                               color:#4A5272;font-size:11.5px;font-weight:500;
                                               padding:4px 10px;border-radius:100px;">
                                            {{ $vehicle->brand->name }}
                                        </span>
                                    @endif
                                    @if ($vehicle->model)
                                        <span style="display:inline-flex;align-items:center;
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
                                    <span style="display:inline-flex;align-items:center;gap:5px;
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
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Tidak Parkir
                                    </span>
                                @endif
                            </td>

                            {{-- Aktif --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($vehicle->is_active)
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#12B76A;display:inline-block;"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #D4D9E8;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;">
                                        <span style="width:6px;height:6px;border-radius:50%;
                                                     background:#D4D9E8;display:inline-block;"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Terdaftar --}}
                            <td style="padding:14px 16px;color:#8A93AE;font-size:12.5px;">
                                {{ $vehicle->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi: hanya Detail --}}
                            <td style="padding:14px 16px;text-align:center;">
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
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer + Pagination --}}
            <div style="padding:14px 24px;border-top:1px solid #EBEEF5;
                        display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <span style="font-size:12.5px;color:#8A93AE;">
                    Menampilkan {{ $vehicles->firstItem() }}–{{ $vehicles->lastItem() }}
                    dari {{ $vehicles->total() }} kendaraan
                </span>

                @if ($vehicles->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        @if ($vehicles->onFirstPage())
                            <span style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2" style="width:14px;height:14px;">
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2" style="width:14px;height:14px;">
                                    <polyline points="15 18 9 12 15 6" />
                                </svg>
                            </a>
                        @endif

                        @foreach ($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
                            @if ($page == $vehicles->currentPage())
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

                        @if ($vehicles->hasMorePages())
                            <a href="{{ $vehicles->nextPageUrl() }}"
                                style="width:32px;height:32px;border-radius:8px;border:1.5px solid #D4D9E8;
                                       display:flex;align-items:center;justify-content:center;
                                       text-decoration:none;transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5175" stroke-width="2" style="width:14px;height:14px;">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </a>
                        @else
                            <span style="width:32px;height:32px;border-radius:8px;border:1.5px solid #EBEEF5;
                                         display:flex;align-items:center;justify-content:center;
                                         opacity:.4;cursor:not-allowed;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2" style="width:14px;height:14px;">
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
                    <div style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
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
                        <div style="font-size:12px;color:#8A93AE;margin-top:2px;">Informasi lengkap kendaraan</div>
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
            <div style="width:100%;height:180px;border-radius:14px;overflow:hidden;
                        border:1.5px solid #EBEEF5;background:#F5F7FC;
                        display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
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

            {{-- Nomor Plat --}}
            <div style="text-align:center;margin-bottom:20px;">
                <div style="display:inline-block;font-family:monospace;font-size:22px;font-weight:800;
                            letter-spacing:0.12em;color:#181D35;background:#F5F7FC;
                            border:2px solid #D4D9E8;border-radius:10px;padding:8px 24px;">
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

            <div style="height:1px;background:#EBEEF5;margin-bottom:20px;"></div>

            {{-- Info Grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:6px;">Jenis</div>
                    <div id="detailType" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:6px;">Merek</div>
                    <div id="detailBrand" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:6px;">Model</div>
                    <div id="detailModel" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:6px;">Warna</div>
                    <div id="detailColor" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>
                <div style="padding:14px;background:#F5F7FC;border-radius:12px;border:1.5px solid #EBEEF5;">
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:6px;">Terdaftar</div>
                    <div id="detailCreatedAt" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                </div>
            </div>

            {{-- Pemilik --}}
            <div style="padding:14px 16px;background:#F5F7FC;border-radius:12px;
                        border:1.5px solid #EBEEF5;margin-bottom:20px;
                        display:flex;align-items:center;gap:12px;">
                <div id="detailOwnerAvatar"
                    style="width:38px;height:38px;border-radius:50%;
                           background:#E8F0FB;border:1.5px solid #C0D3F5;
                           display:flex;align-items:center;justify-content:center;
                           flex-shrink:0;font-size:14px;font-weight:700;color:#1A4BAD;">
                </div>
                <div>
                    <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                                letter-spacing:0.06em;margin-bottom:4px;">Pemilik</div>
                    <div id="detailOwnerName" style="font-size:13.5px;font-weight:700;color:#181D35;">—</div>
                    <div id="detailOwnerEmail" style="font-size:12px;color:#8A93AE;margin-top:1px;">—</div>
                </div>
            </div>

            {{-- Foto STNK --}}
            <div id="detailStnkSection" style="margin-bottom:20px;display:none;">
                <div style="font-size:11px;color:#8A93AE;font-weight:600;text-transform:uppercase;
                            letter-spacing:0.06em;margin-bottom:8px;">Foto STNK</div>
                <a id="detailStnkLink" href="#" target="_blank"
                    style="display:block;width:100%;height:120px;border-radius:12px;overflow:hidden;
                           border:1.5px solid #EBEEF5;text-decoration:none;">
                    <img id="detailStnkPhoto" src="" alt="STNK"
                        style="width:100%;height:100%;object-fit:cover;">
                </a>
            </div>

            {{-- Waktu parkir --}}
            <div id="detailParkedAtWrap" style="display:none;margin-bottom:20px;">
                <div style="padding:12px 14px;background:#EFF8FF;border-radius:10px;
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

            <button onclick="closeDetailModal()" class="btn-outline" style="width:100%;justify-content:center;">
                Tutup
            </button>
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
                success: { bg:'#ECFDF3', border:'#6CE9A6', icon:'#12B76A', text:'#027A48', svg:'<polyline points="20 6 9 17 4 12"/>' },
                error:   { bg:'#FEF3F2', border:'#FECDCA', icon:'#D92D20', text:'#912018', svg:'<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>' },
                warning: { bg:'#FFFAEB', border:'#FDE68A', icon:'#F79009', text:'#B54708', svg:'<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>' },
            };
            const c = configs[type] || configs.success;
            const id = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.id = id;
            toast.style.cssText = `pointer-events:auto;background:${c.bg};border:1.5px solid ${c.border};border-radius:12px;padding:12px 16px;display:flex;align-items:flex-start;gap:10px;min-width:280px;max-width:360px;box-shadow:0 8px 24px rgba(0,0,0,.10);animation:toastIn .25s ease;font-family:'DM Sans',sans-serif;`;
            toast.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2" style="width:16px;height:16px;flex-shrink:0;margin-top:1px;">${c.svg}</svg><span style="font-size:13px;color:${c.text};line-height:1.5;flex:1;">${message}</span><button onclick="removeToast('${id}')" style="background:none;border:none;cursor:pointer;padding:0;color:${c.icon};opacity:.6;flex-shrink:0;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;
            document.getElementById('toastContainer').appendChild(toast);
            setTimeout(() => removeToast(id), 4000);
        }

        function removeToast(id) {
            const el = document.getElementById(id);
            if (el) { el.style.animation = 'toastOut .2s ease forwards'; setTimeout(() => el.remove(), 200); }
        }

        const toastStyle = document.createElement('style');
        toastStyle.textContent = `@keyframes toastIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}@keyframes toastOut{from{opacity:1;transform:translateX(0)}to{opacity:0;transform:translateX(20px)}}`;
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
        function openDetailModal(plate, color, type, brand, modelName, ownerName, ownerEmail, isActive, isParked, parkedAt, createdAt, vehiclePhotoUrl, stnkPhotoUrl) {

            document.getElementById('detailPlate').textContent      = plate;
            document.getElementById('detailType').textContent       = type;
            document.getElementById('detailBrand').textContent      = brand;
            document.getElementById('detailModel').textContent      = modelName || '—';
            document.getElementById('detailColor').textContent      = color || '—';
            document.getElementById('detailCreatedAt').textContent  = createdAt;

            // Status aktif
            const statusAktif = document.getElementById('detailStatusAktif');
            if (isActive) {
                statusAktif.innerHTML = '<span style="width:6px;height:6px;border-radius:50%;background:#12B76A;display:inline-block;"></span> Aktif';
                statusAktif.style.cssText += 'background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48;';
            } else {
                statusAktif.innerHTML = '<span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span> Nonaktif';
                statusAktif.style.cssText += 'background:#F5F7FC;border:1px solid #D4D9E8;color:#8A93AE;';
            }

            // Status parkir
            const statusParkir = document.getElementById('detailStatusParkir');
            if (isParked) {
                statusParkir.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="#1D74C4" stroke-width="2.5" style="width:11px;height:11px;flex-shrink:0;"><rect x="3" y="11" width="18" height="5" rx="2"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/><path d="M5 11V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4"/></svg> Sedang Parkir`;
                statusParkir.style.cssText += 'background:#EFF8FF;border:1px solid #84CAFF;color:#1D74C4;';
            } else {
                statusParkir.innerHTML = '<span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span> Tidak Parkir';
                statusParkir.style.cssText += 'background:#F5F7FC;border:1px solid #D4D9E8;color:#8A93AE;';
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
            const photo       = document.getElementById('detailPhoto');
            const placeholder = document.getElementById('detailPhotoPlaceholder');
            if (vehiclePhotoUrl) {
                photo.src = vehiclePhotoUrl; photo.style.display = 'block'; placeholder.style.display = 'none';
            } else {
                photo.style.display = 'none'; placeholder.style.display = 'flex';
            }

            // Foto STNK
            const stnkSection = document.getElementById('detailStnkSection');
            if (stnkPhotoUrl) {
                document.getElementById('detailStnkPhoto').src  = stnkPhotoUrl;
                document.getElementById('detailStnkLink').href  = stnkPhotoUrl;
                stnkSection.style.display = 'block';
            } else {
                stnkSection.style.display = 'none';
            }

            // Pemilik
            if (ownerName) {
                document.getElementById('detailOwnerAvatar').textContent = ownerName.charAt(0).toUpperCase();
                document.getElementById('detailOwnerName').textContent   = ownerName;
                document.getElementById('detailOwnerEmail').textContent  = ownerEmail || '—';
            } else {
                document.getElementById('detailOwnerAvatar').textContent = '?';
                document.getElementById('detailOwnerName').textContent   = '— Tidak ada pemilik —';
                document.getElementById('detailOwnerEmail').textContent  = '';
            }

            document.getElementById('modalDetail').style.display = 'flex';
        }

        function closeDetailModal() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        // Backdrop & Escape
        document.getElementById('modalDetail').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.getElementById('modalDetail').style.display = 'none';
        });
    </script>
@endpush