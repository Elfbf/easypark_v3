@extends('layouts.app')

@section('title', 'Model Kendaraan')
@section('page_title', 'Model Kendaraan')

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
        <span style="color:#181D35;font-weight:600;">Model Kendaraan</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Model Kendaraan</div>
            <div class="page-sub">Kelola data model kendaraan yang terdaftar dalam sistem</div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TOAST CONTAINER
    ══════════════════════════════════════ --}}
    <div id="toastContainer"
        style="position:fixed;top:24px;right:24px;z-index:999;
               display:flex;flex-direction:column;gap:10px;pointer-events:none;">
    </div>

    {{-- ── Tabel Model Kendaraan ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Model Kendaraan</div>
                <div class="card-sub">{{ $vehicleModels->total() }} model kendaraan terdaftar dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.vehicle-models.index') }}" style="display:flex;">
                    <div class="tb-search" style="width:220px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text" name="search" placeholder="Cari model kendaraan..."
                            value="{{ $search }}" onchange="this.form.submit()">
                    </div>
                </form>

                {{-- Tombol Tambah --}}
                <button class="btn-primary" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Model
                </button>
            </div>
        </div>

        @if ($vehicleModels->isEmpty())
            {{-- ── Empty state ── --}}
            <div style="padding:64px 24px;text-align:center;">
                <div
                    style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:28px;height:28px;">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                        <line x1="12" y1="12" x2="12" y2="16" />
                        <line x1="10" y1="14" x2="14" y2="14" />
                    </svg>
                </div>
                <div
                    style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                            color:#181D35;margin-bottom:6px;">
                    @if ($search)
                        Tidak ada model kendaraan yang cocok
                    @else
                        Belum ada model kendaraan
                    @endif
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    @if ($search)
                        Coba kata kunci lain atau
                        <a href="{{ route('admin.vehicle-models.index') }}"
                            style="color:#1A4BAD;font-weight:500;text-decoration:underline;">
                            reset pencarian
                        </a>
                    @else
                        Tambahkan model kendaraan pertama untuk mulai mengelola data parkir
                    @endif
                </div>
                @if (!$search)
                    <button class="btn-primary" onclick="openModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Model Kendaraan
                    </button>
                @endif
            </div>
        @else
            <table class="data-table" id="vehicleModelTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>
                        <th style="padding:14px 16px;">Nama Model</th>
                        <th style="padding:14px 16px;width:200px;">Brand Kendaraan</th>
                        <th style="padding:14px 16px;width:180px;text-align:center;">Jumlah Kendaraan</th>
                        <th style="padding:14px 16px;width:150px;">Dibuat</th>
                        <th style="padding:14px 16px;width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicleModels as $index => $model)
                        @php
                            $vehicleCount = $model->vehicles()->count();
                            $isProtected = $vehicleCount > 0;
                        @endphp
                        <tr id="row-{{ $model->id }}">

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span
                                    style="font-size:12px;font-weight:600;color:#8A93AE;
                                           background:#F5F7FC;border:1px solid #EBEEF5;
                                           border-radius:6px;padding:3px 8px;
                                           display:inline-block;min-width:28px;text-align:center;"
                                    class="row-num">
                                    {{ $vehicleModels->firstItem() + $index }}
                                </span>
                            </td>

                            {{-- Nama Model --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div
                                        style="width:38px;height:38px;border-radius:10px;
                                                background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                display:flex;align-items:center;justify-content:center;
                                                flex-shrink:0;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                            style="width:17px;height:17px;">
                                            <rect x="2" y="7" width="20" height="14" rx="2" />
                                            <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                                        </svg>
                                    </div>
                                    <span
                                        style="font-weight:600;font-size:13.5px;color:#181D35;text-transform:capitalize;">
                                        {{ $model->name }}
                                    </span>
                                </div>
                            </td>

                            {{-- Brand Kendaraan --}}
                            <td style="padding:14px 16px;">
                                <span
                                    style="display:inline-flex;align-items:center;gap:6px;
                                            background:#F5F7FC;border:1px solid #EBEEF5;
                                            color:#4A5175;font-size:12px;font-weight:600;
                                            padding:4px 12px;border-radius:100px;white-space:nowrap;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                        style="width:11px;height:11px;">
                                        <rect x="1" y="3" width="15" height="13" rx="2" />
                                        <path d="M16 8h4l3 3v5h-7V8z" />
                                        <circle cx="5.5" cy="18.5" r="2.5" />
                                        <circle cx="18.5" cy="18.5" r="2.5" />
                                    </svg>
                                    {{ $model->brand->name ?? '-' }}
                                </span>
                            </td>

                            {{-- Jumlah Kendaraan --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($vehicleCount > 0)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 12px;border-radius:100px;white-space:nowrap;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:12px;height:12px;">
                                            <rect x="1" y="3" width="15" height="13" rx="2" />
                                            <path d="M16 8h4l3 3v5h-7V8z" />
                                            <circle cx="5.5" cy="18.5" r="2.5" />
                                            <circle cx="18.5" cy="18.5" r="2.5" />
                                        </svg>
                                        {{ $vehicleCount }} kendaraan
                                    </span>
                                @else
                                    <span style="font-size:12px;color:#D4D9E8;">—</span>
                                @endif
                            </td>

                            {{-- Dibuat --}}
                            <td style="padding:14px 16px;color:#8A93AE;font-size:12.5px;">
                                {{ $model->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                    {{-- Edit --}}
                                    <button class="tb-btn" title="Edit model kendaraan"
                                        onclick="openEditModal({{ $model->id }}, '{{ addslashes($model->name) }}', {{ $model->vehicle_brand_id }})"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus — disabled jika masih dipakai --}}
                                    @if ($isProtected)
                                        <button class="tb-btn" title="Masih digunakan {{ $vehicleCount }} kendaraan"
                                            onclick="showToast('warning', 'Model &quot;{{ addslashes($model->name) }}&quot; masih digunakan oleh {{ $vehicleCount }} kendaraan. Hapus atau pindahkan data terlebih dahulu.')"
                                            style="width:32px;height:32px;border-radius:8px;
                                                   opacity:.45;cursor:not-allowed;border-color:#FECDCA;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                                                style="width:14px;height:14px;">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    @else
                                        <button class="tb-btn" title="Hapus model kendaraan"
                                            onclick="confirmDelete({{ $model->id }}, '{{ addslashes($model->name) }}')"
                                            style="width:32px;height:32px;border-radius:8px;border-color:#FECDCA;">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                                                style="width:14px;height:14px;">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            {{-- Footer tabel + Pagination --}}
            <div
                style="padding:14px 24px;border-top:1px solid #EBEEF5;
                        display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <span style="font-size:12.5px;color:#8A93AE;">
                    Menampilkan {{ $vehicleModels->firstItem() }}–{{ $vehicleModels->lastItem() }}
                    dari {{ $vehicleModels->total() }} model kendaraan
                </span>

                {{-- Pagination --}}
                @if ($vehicleModels->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        {{-- Prev --}}
                        @if ($vehicleModels->onFirstPage())
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
                            <a href="{{ $vehicleModels->previousPageUrl() }}"
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
                        @foreach ($vehicleModels->getUrlRange(1, $vehicleModels->lastPage()) as $page => $url)
                            @if ($page == $vehicleModels->currentPage())
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
                        @if ($vehicleModels->hasMorePages())
                            <a href="{{ $vehicleModels->nextPageUrl() }}"
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
         MODAL — Tambah Model Kendaraan
    ══════════════════════════════════════ --}}
    <div id="modalAdd"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:440px;box-shadow:0 24px 64px rgba(7,28,82,.18);
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
                        Tambah Model Kendaraan
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Buat model kendaraan baru dalam sistem
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.vehicle-models.store') }}" method="POST" onsubmit="return validateAddForm()">
                @csrf

                {{-- Brand --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Brand Kendaraan <span style="color:#D92D20;">*</span>
                    </label>
                    <div style="position:relative;">
                        <select name="vehicle_brand_id" id="addBrandId" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                                   border-radius:10px;padding:0 36px 0 14px;outline:none;
                                   font-family:'DM Sans',sans-serif;font-size:13.5px;
                                   color:#181D35;background:#fff;appearance:none;
                                   cursor:pointer;transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="" disabled selected>-- Pilih brand kendaraan --</option>
                            @foreach ($vehicleBrands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('vehicle_brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                                   width:14px;height:14px;pointer-events:none;">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </div>
                    @error('vehicle_brand_id')
                        <div
                            style="margin-top:7px;font-size:12px;color:#D92D20;
                                    display:flex;align-items:center;gap:5px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:13px;height:13px;flex-shrink:0;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nama Model --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Nama Model <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="name" id="addModelName"
                        placeholder="Contoh: Avanza, Civic, Fortuner..." autocomplete="off" required
                        value="{{ old('name') }}"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                               border-radius:10px;padding:0 14px;outline:none;
                               font-family:'DM Sans',sans-serif;font-size:13.5px;
                               color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'" oninput="clearAddError()">

                    <div id="addError"
                        style="display:none;margin-top:7px;font-size:12px;color:#D92D20;
                               align-items:center;gap:5px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width:13px;height:13px;flex-shrink:0;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="addErrorText"></span>
                    </div>

                    @error('name')
                        <div
                            style="margin-top:7px;font-size:12px;color:#D92D20;
                                    display:flex;align-items:center;gap:5px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:13px;height:13px;flex-shrink:0;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeModal()" class="btn-outline" style="flex:1;">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Simpan Model
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Edit Model Kendaraan
    ══════════════════════════════════════ --}}
    <div id="modalEdit"
        style="display:none;position:fixed;inset:0;z-index:200;
               background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:440px;box-shadow:0 24px 64px rgba(7,28,82,.18);
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
                        Edit Model Kendaraan
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Ubah data model kendaraan yang dipilih
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST" onsubmit="return validateEditForm()">
                @csrf
                @method('PUT')

                {{-- Brand --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Brand Kendaraan <span style="color:#D92D20;">*</span>
                    </label>
                    <div style="position:relative;">
                        <select name="vehicle_brand_id" id="editBrandId" required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                                   border-radius:10px;padding:0 36px 0 14px;outline:none;
                                   font-family:'DM Sans',sans-serif;font-size:13.5px;
                                   color:#181D35;background:#fff;appearance:none;
                                   cursor:pointer;transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                            <option value="" disabled>-- Pilih brand kendaraan --</option>
                            @foreach ($vehicleBrands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                                   width:14px;height:14px;pointer-events:none;">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </div>
                </div>

                {{-- Nama Model --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Nama Model <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="name" id="editModelName" required autocomplete="off"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                               border-radius:10px;padding:0 14px;outline:none;
                               font-family:'DM Sans',sans-serif;font-size:13.5px;
                               color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'" oninput="clearEditError()">

                    <div id="editError"
                        style="display:none;margin-top:7px;font-size:12px;color:#D92D20;
                               align-items:center;gap:5px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width:13px;height:13px;flex-shrink:0;">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="editErrorText"></span>
                    </div>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeEditModal()" class="btn-outline" style="flex:1;">
                        Batal
                    </button>
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
                Hapus Model Kendaraan?
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
                Model <strong id="deleteModelName"
                    style="color:#181D35;background:#F5F7FC;padding:1px 8px;
                           border-radius:6px;border:1px solid #D4D9E8;"></strong>
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
        // DATA MODEL UNTUK VALIDASI DUPLIKAT
        // Struktur: [{id, name, vehicle_brand_id}, ...]
        // ═══════════════════════════════
        const existingModels = {!! $existingModelsJson !!};
        let currentEditId = null;

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
        // MODAL TAMBAH
        // ═══════════════════════════════
        function openModal() {
            document.getElementById('modalAdd').style.display = 'flex';
            setTimeout(() => document.getElementById('addBrandId').focus(), 100);
        }

        function closeModal() {
            document.getElementById('modalAdd').style.display = 'none';
            document.getElementById('addBrandId').value = '';
            document.getElementById('addModelName').value = '';
            clearAddError();
        }

        function clearAddError() {
            document.getElementById('addError').style.display = 'none';
            document.getElementById('addModelName').style.borderColor = '#D4D9E8';
            document.getElementById('addModelName').style.boxShadow = 'none';
        }

        function validateAddForm() {
            const name = document.getElementById('addModelName').value.trim().toLowerCase();
            const brandId = parseInt(document.getElementById('addBrandId').value);
            if (!name || !brandId) return true;

            // Cek duplikat: nama + brand yang sama
            const duplicate = existingModels.some(
                m => m.name.toLowerCase() === name && m.vehicle_brand_id === brandId
            );
            if (duplicate) {
                showAddError('Model dengan nama ini sudah ada untuk brand yang dipilih.');
                return false;
            }
            return true;
        }

        function showAddError(msg) {
            const input = document.getElementById('addModelName');
            input.style.borderColor = '#D92D20';
            input.style.boxShadow = '0 0 0 4px rgba(217,45,32,.10)';
            document.getElementById('addErrorText').textContent = msg;
            document.getElementById('addError').style.display = 'flex';
        }

        // ═══════════════════════════════
        // MODAL EDIT
        // ═══════════════════════════════
        function openEditModal(id, name, brandId) {
            currentEditId = id;
            document.getElementById('editModelName').value = name;
            document.getElementById('editBrandId').value = brandId;
            document.getElementById('editForm').action = '/admin/vehicle-models/' + id;
            document.getElementById('modalEdit').style.display = 'flex';
            clearEditError();
            setTimeout(() => document.getElementById('editModelName').focus(), 100);
        }

        function closeEditModal() {
            document.getElementById('modalEdit').style.display = 'none';
            clearEditError();
        }

        function clearEditError() {
            document.getElementById('editError').style.display = 'none';
            document.getElementById('editModelName').style.borderColor = '#D4D9E8';
            document.getElementById('editModelName').style.boxShadow = 'none';
        }

        function validateEditForm() {
            const name = document.getElementById('editModelName').value.trim().toLowerCase();
            const brandId = parseInt(document.getElementById('editBrandId').value);
            if (!name || !brandId) return true;

            // Cek duplikat: nama + brand sama, tapi bukan dirinya sendiri
            const duplicate = existingModels.some(
                m => m.id !== currentEditId && m.name.toLowerCase() === name && m.vehicle_brand_id === brandId
            );
            if (duplicate) {
                showEditError('Model dengan nama ini sudah ada untuk brand yang dipilih.');
                return false;
            }
            return true;
        }

        function showEditError(msg) {
            const input = document.getElementById('editModelName');
            input.style.borderColor = '#D92D20';
            input.style.boxShadow = '0 0 0 4px rgba(217,45,32,.10)';
            document.getElementById('editErrorText').textContent = msg;
            document.getElementById('editError').style.display = 'flex';
        }

        // ═══════════════════════════════
        // MODAL HAPUS
        // ═══════════════════════════════
        function confirmDelete(id, name) {
            document.getElementById('deleteModelName').textContent = name;
            document.getElementById('deleteForm').action = '/admin/vehicle-models/' + id;
            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
        }

        // ── Tutup modal dengan klik backdrop & Escape ──
        ['modalAdd', 'modalEdit', 'modalDelete'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
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
