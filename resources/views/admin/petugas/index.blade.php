@extends('layouts.app')

@section('title', 'Master Petugas')
@section('page_title', 'Master Petugas')

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
        <span style="color:#181D35;font-weight:600;">Master Petugas</span>
    </nav>

    {{-- ── Page Header ── --}}
    <div class="page-head">
        <div>
            <div class="page-title">Master Petugas</div>
            <div class="page-sub">Kelola data akun petugas parkir yang terdaftar dalam sistem</div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         TOAST CONTAINER
    ══════════════════════════════════════ --}}
    <div id="toastContainer"
        style="position:fixed;top:24px;right:24px;z-index:999;
               display:flex;flex-direction:column;gap:10px;pointer-events:none;">
    </div>

    {{-- ── Tabel Petugas ── --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Petugas</div>
                <div class="card-sub">{{ $petugas->total() }} petugas terdaftar dalam sistem</div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">

                {{-- Filter Status --}}
                <div style="position:relative;">
                    <select id="filterStatus" onchange="filterTable()"
                        style="height:36px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 32px 0 12px;outline:none;appearance:none;
                               font-family:'DM Sans',sans-serif;font-size:13px;
                               color:#181D35;background:#fff;cursor:pointer;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <option value="">Semua Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                        style="width:14px;height:14px;position:absolute;right:10px;top:50%;
                               transform:translateY(-50%);pointer-events:none;">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </div>

                {{-- Search --}}
                <div class="tb-search" style="width:220px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                    <input type="text" id="searchPetugas" placeholder="Cari nama / NIP..." oninput="filterTable()">
                </div>

                {{-- Tombol Tambah --}}
                <button class="btn-primary" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Petugas
                </button>
            </div>
        </div>

        @if ($petugas->isEmpty())
            {{-- ── Empty state ── --}}
            <div style="padding:64px 24px;text-align:center;">
                <div
                    style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:28px;height:28px;">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div
                    style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                            color:#181D35;margin-bottom:6px;">
                    Belum ada petugas
                </div>
                <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                    Tambahkan akun petugas pertama untuk mulai mengelola sistem parkir
                </div>
                <button class="btn-primary" onclick="openModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Tambah Petugas
                </button>
            </div>
        @else
            <table class="data-table" id="petugasTable">
                <thead>
                    <tr>
                        <th style="padding:14px 16px 14px 24px;width:60px;">#</th>

                        {{-- Sortable: Nama --}}
                        <th style="padding:14px 16px;cursor:pointer;user-select:none;" onclick="sortTable(1, this)"
                            title="Klik untuk urutkan">
                            <div style="display:inline-flex;align-items:center;gap:5px;">
                                Nama Petugas
                                <span id="sort-icon-1" style="color:#D4D9E8;font-size:10px;transition:color .15s;">↕</span>
                            </div>
                        </th>

                        {{-- NIP --}}
                        <th style="padding:14px 16px;width:160px;">NIM / NIP</th>

                        {{-- Kontak --}}
                        <th style="padding:14px 16px;width:200px;">Kontak</th>

                        {{-- Gender --}}
                        <th style="padding:14px 16px;width:110px;text-align:center;">Gender</th>

                        {{-- Status --}}
                        <th style="padding:14px 16px;width:120px;text-align:center;">Status</th>

                        {{-- Sortable: Dibuat --}}
                        <th style="padding:14px 16px;width:150px;cursor:pointer;user-select:none;"
                            onclick="sortTable(6, this)" title="Klik untuk urutkan">
                            <div style="display:inline-flex;align-items:center;gap:5px;">
                                Dibuat
                                <span id="sort-icon-6"
                                    style="color:#D4D9E8;font-size:10px;transition:color .15s;">↕</span>
                            </div>
                        </th>

                        <th style="padding:14px 16px;width:110px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petugas as $index => $p)
                        <tr id="row-{{ $p->id }}" data-name="{{ strtolower($p->name) }}"
                            data-nim="{{ strtolower($p->nim_nip ?? '') }}" data-status="{{ $p->is_active ? '1' : '0' }}"
                            data-created="{{ $p->created_at?->timestamp ?? 0 }}">

                            {{-- No --}}
                            <td style="padding:14px 16px 14px 24px;">
                                <span
                                    style="font-size:12px;font-weight:600;color:#8A93AE;
                                             background:#F5F7FC;border:1px solid #EBEEF5;
                                             border-radius:6px;padding:3px 8px;
                                             display:inline-block;min-width:28px;text-align:center;"
                                    class="row-num">
                                    {{ $index + 1 }}
                                </span>
                            </td>

                            {{-- Nama + Foto --}}
                            <td style="padding:14px 16px;">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    {{-- Avatar foto / inisial --}}
                                    @if ($p->photo)
                                        <img src="{{ Storage::url($p->photo) }}" alt="{{ $p->name }}"
                                            style="width:38px;height:38px;border-radius:10px;
                                                   object-fit:cover;border:1.5px solid #C0D3F5;flex-shrink:0;">
                                    @else
                                        <div
                                            style="width:38px;height:38px;border-radius:10px;
                                                    background:#E8F0FB;border:1.5px solid #C0D3F5;
                                                    display:flex;align-items:center;justify-content:center;
                                                    flex-shrink:0;font-family:'Syne',sans-serif;
                                                    font-size:13px;font-weight:800;color:#1A4BAD;">
                                            {{ strtoupper(substr($p->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;font-size:13.5px;color:#181D35;">
                                            {{ $p->name }}
                                        </div>
                                        @if ($p->email)
                                            <div style="font-size:12px;color:#8A93AE;margin-top:1px;">
                                                {{ $p->email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- NIM / NIP --}}
                            <td style="padding:14px 16px;">
                                <span
                                    style="font-family:'DM Mono',monospace;font-size:12.5px;
                                            color:#4A5175;background:#F5F7FC;
                                            border:1px solid #EBEEF5;border-radius:6px;
                                            padding:3px 8px;display:inline-block;">
                                    {{ $p->nim_nip ?? '-' }}
                                </span>
                            </td>

                            {{-- Kontak --}}
                            <td style="padding:14px 16px;">
                                @if ($p->phone)
                                    <div style="display:flex;align-items:center;gap:6px;font-size:12.5px;color:#4A5175;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                            style="width:13px;height:13px;flex-shrink:0;">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.78a16 16 0 0 0 5.93 5.93l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.5 16.92z" />
                                        </svg>
                                        {{ $p->phone }}
                                    </div>
                                @else
                                    <span style="font-size:12px;color:#D4D9E8;">—</span>
                                @endif
                            </td>

                            {{-- Gender --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($p->gender === 'L')
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                     background:#EFF8FF;border:1px solid #B2DDFF;
                     color:#1849A9;font-size:12px;font-weight:600;
                     padding:4px 14px;border-radius:100px;white-space:nowrap;">
                                        ♂ Laki-laki
                                    </span>
                                @elseif ($p->gender === 'P')
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                     background:#FDF2F8;border:1px solid #F5C6E4;
                     color:#9E2A6D;font-size:12px;font-weight:600;
                     padding:4px 14px;border-radius:100px;white-space:nowrap;">
                                        ♀ Perempuan
                                    </span>
                                @else
                                    <span style="font-size:12px;color:#D4D9E8;">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td style="padding:14px 16px;text-align:center;">
                                @if ($p->is_active)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#ECFDF3;border:1px solid #6CE9A6;
                                                color:#027A48;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;
                                                    background:#12B76A;display:inline-block;">
                                        </span>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                background:#F5F7FC;border:1px solid #EBEEF5;
                                                color:#8A93AE;font-size:12px;font-weight:600;
                                                padding:4px 10px;border-radius:100px;">
                                        <span
                                            style="width:6px;height:6px;border-radius:50%;
                                                    background:#D4D9E8;display:inline-block;">
                                        </span>
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- Dibuat --}}
                            <td style="padding:14px 16px;color:#8A93AE;font-size:12.5px;">
                                {{ $p->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                                    {{-- Edit --}}
                                    <button class="tb-btn" title="Edit petugas"
                                        onclick="openEditModal(
                                            {{ $p->id }},
                                            '{{ addslashes($p->name) }}',
                                            '{{ addslashes($p->nim_nip ?? '') }}',
                                            '{{ addslashes($p->phone ?? '') }}',
                                            '{{ addslashes($p->email ?? '') }}',
                                            {{ $p->is_active ? 'true' : 'false' }},
                                            '{{ $p->gender ?? '' }}',
                                            '{{ $p->birth_date?->format('Y-m-d') ?? '' }}',
                                            '{{ addslashes($p->address ?? '') }}',
                                            '{{ $p->photo ? Storage::url($p->photo) : '' }}'
                                        )"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    {{-- Detail --}}
                                    <button class="tb-btn" title="Detail petugas"
                                        onclick="openDetailModal(
                                            '{{ addslashes($p->name) }}',
                                            '{{ addslashes($p->nim_nip ?? '') }}',
                                            '{{ addslashes($p->phone ?? '') }}',
                                            '{{ addslashes($p->email ?? '') }}',
                                            {{ $p->is_active ? 'true' : 'false' }},
                                            '{{ $p->gender ?? '' }}',
                                            '{{ $p->birth_date?->format('d M Y') ?? '' }}',
                                            '{{ addslashes($p->address ?? '') }}',
                                            '{{ $p->photo ? Storage::url($p->photo) : '' }}',
                                            '{{ $p->created_at?->format('d M Y, H:i') ?? '' }}'
                                            )"
                                        style="width:32px;height:32px;border-radius:8px;border-color:#C0D3F5;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                            style="width:14px;height:14px;">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" y1="8" x2="12" y2="8" />
                                            <line x1="12" y1="12" x2="12" y2="16" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <button class="tb-btn" title="Hapus petugas"
                                        onclick="confirmDelete({{ $p->id }}, '{{ addslashes($p->name) }}')"
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
                    @empty
                    @endforelse
                </tbody>
            </table>

            {{-- ── Empty search state ── --}}
            <div id="emptySearch" style="display:none;padding:48px 24px;text-align:center;border-top:1px solid #EBEEF5;">
                <div
                    style="width:48px;height:48px;background:#F5F7FC;border-radius:12px;
                            display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                        style="width:22px;height:22px;">
                        <circle cx="11" cy="11" r="8" />
                        <path d="M21 21l-4.35-4.35" />
                    </svg>
                </div>
                <div style="font-size:14px;font-weight:600;color:#181D35;margin-bottom:4px;">
                    Tidak ada petugas yang cocok
                </div>
                <div style="font-size:13px;color:#8A93AE;">
                    Coba kata kunci lain atau
                    <span onclick="clearSearch()"
                        style="color:#1A4BAD;cursor:pointer;font-weight:500;text-decoration:underline;">
                        reset pencarian
                    </span>
                </div>
            </div>

            {{-- Footer tabel + Pagination --}}
            <div
                style="padding:14px 24px;border-top:1px solid #EBEEF5;
                        display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                <span style="font-size:12.5px;color:#8A93AE;">
                    Menampilkan {{ $petugas->firstItem() }}–{{ $petugas->lastItem() }}
                    dari {{ $petugas->total() }} petugas
                </span>

                {{-- Pagination --}}
                @if ($petugas->hasPages())
                    <div style="display:flex;align-items:center;gap:6px;">
                        {{-- Prev --}}
                        @if ($petugas->onFirstPage())
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
                            <a href="{{ $petugas->previousPageUrl() }}"
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
                        @foreach ($petugas->getUrlRange(1, $petugas->lastPage()) as $page => $url)
                            @if ($page == $petugas->currentPage())
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
                        @if ($petugas->hasMorePages())
                            <a href="{{ $petugas->nextPageUrl() }}"
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
         MODAL — Tambah Petugas
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
                        Tambah Petugas
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Buat akun petugas baru dalam sistem
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data"
                onsubmit="return validateAddForm()">
                @csrf

                {{-- Foto Upload --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Foto Profil
                    </label>
                    <div style="display:flex;align-items:center;gap:14px;">
                        {{-- Preview --}}
                        <div id="addPhotoPreviewWrap"
                            style="width:64px;height:64px;border-radius:12px;background:#F5F7FC;
                                   border:1.5px dashed #D4D9E8;display:flex;align-items:center;
                                   justify-content:center;flex-shrink:0;overflow:hidden;">
                            <svg id="addPhotoIcon" viewBox="0 0 24 24" fill="none" stroke="#D4D9E8"
                                stroke-width="1.5" style="width:24px;height:24px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <img id="addPhotoPreview" src="" alt="preview"
                                style="display:none;width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div style="flex:1;">
                            <label for="addPhoto"
                                style="display:inline-flex;align-items:center;gap:7px;
                                       height:36px;padding:0 14px;border-radius:10px;
                                       border:1.5px solid #D4D9E8;background:#fff;
                                       font-size:13px;font-weight:500;color:#4A5175;cursor:pointer;
                                       transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Pilih Foto
                            </label>
                            <input type="file" name="photo" id="addPhoto" accept="image/*" style="display:none;"
                                onchange="previewPhoto('addPhoto','addPhotoPreview','addPhotoIcon')">
                            <div style="font-size:11.5px;color:#8A93AE;margin-top:6px;">
                                JPG, PNG, WebP — maks. 2MB
                            </div>
                        </div>
                    </div>
                    @error('photo')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Nama Lengkap <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="name" id="addName" placeholder="Nama lengkap petugas"
                        autocomplete="off" required value="{{ old('name') }}"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    @error('name')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NIM / NIP --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        NIM / NIP <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="nim_nip" id="addNimNip" placeholder="Nomor identitas petugas"
                        autocomplete="off" required value="{{ old('nim_nip') }}"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    @error('nim_nip')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email & No. HP --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Email
                        </label>
                        <input type="email" name="email" id="addEmail" placeholder="email@contoh.com"
                            autocomplete="off" value="{{ old('email') }}"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        @error('email')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            No. HP
                        </label>
                        <input type="text" name="phone" id="addPhone" placeholder="08xxxxxxxxxx"
                            autocomplete="off" value="{{ old('phone') }}"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        @error('phone')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Gender & Tanggal Lahir --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Gender
                        </label>
                        <div style="position:relative;">
                            <select name="gender" id="addGender"
                                style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                       padding:0 32px 0 14px;outline:none;appearance:none;
                                       font-family:'DM Sans',sans-serif;font-size:13.5px;
                                       color:#181D35;background:#fff;cursor:pointer;
                                       transition:border-color .2s,box-shadow .2s;"
                                onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                                onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                                <option value="">— Pilih —</option>
                                <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:14px;height:14px;position:absolute;right:10px;top:50%;
                                       transform:translateY(-50%);pointer-events:none;">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                        @error('gender')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" id="addBirthDate" value="{{ old('birth_date') }}"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        @error('birth_date')
                            <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Alamat --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Alamat
                    </label>
                    <textarea name="address" id="addAddress" rows="3" placeholder="Alamat lengkap petugas..."
                        style="width:100%;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:10px 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;resize:vertical;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">{{ old('address') }}</textarea>
                    @error('address')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Password <span style="color:#D92D20;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="addPassword" placeholder="Minimal 6 karakter"
                            required
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 40px 0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                        <button type="button" onclick="togglePassword('addPassword', 'eyeAdd')"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                                   background:none;border:none;cursor:pointer;padding:0;color:#8A93AE;">
                            <svg id="eyeAdd" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="width:16px;height:16px;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div style="margin-top:6px;font-size:12px;color:#D92D20;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div style="margin-bottom:24px;">
                    <label
                        style="display:flex;align-items:center;gap:10px;cursor:pointer;
                                padding:12px 14px;border:1.5px solid #D4D9E8;border-radius:10px;
                                transition:border-color .2s,background .2s;"
                        onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                        onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                        <input type="checkbox" name="is_active" id="addIsActive" value="1" checked
                            style="width:16px;height:16px;accent-color:#1A4BAD;cursor:pointer;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#181D35;">Akun Aktif</div>
                            <div style="font-size:12px;color:#8A93AE;margin-top:1px;">
                                Petugas dapat login ke sistem
                            </div>
                        </div>
                    </label>
                </div>

                <div id="addError"
                    style="display:none;margin-bottom:16px;padding:10px 14px;background:#FEF3F2;
                           border:1px solid #FECDCA;border-radius:10px;font-size:12.5px;
                           color:#D92D20;align-items:center;gap:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:14px;height:14px;flex-shrink:0;">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span id="addErrorText"></span>
                </div>

                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="closeModal()" class="btn-outline" style="flex:1;">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Simpan Petugas
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════
         MODAL — Edit Petugas
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
                        Edit Petugas
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Ubah data petugas yang dipilih
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto Upload --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Foto Profil
                    </label>
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div id="editPhotoPreviewWrap"
                            style="width:64px;height:64px;border-radius:12px;background:#F5F7FC;
                                   border:1.5px dashed #D4D9E8;display:flex;align-items:center;
                                   justify-content:center;flex-shrink:0;overflow:hidden;">
                            <svg id="editPhotoIcon" viewBox="0 0 24 24" fill="none" stroke="#D4D9E8"
                                stroke-width="1.5" style="width:24px;height:24px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                            <img id="editPhotoPreview" src="" alt="preview"
                                style="display:none;width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div style="flex:1;">
                            <label for="editPhoto"
                                style="display:inline-flex;align-items:center;gap:7px;
                                       height:36px;padding:0 14px;border-radius:10px;
                                       border:1.5px solid #D4D9E8;background:#fff;
                                       font-size:13px;font-weight:500;color:#4A5175;cursor:pointer;
                                       transition:border-color .2s,background .2s;"
                                onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                                onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    style="width:14px;height:14px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                                Ganti Foto
                            </label>
                            <input type="file" name="photo" id="editPhoto" accept="image/*" style="display:none;"
                                onchange="previewPhoto('editPhoto','editPhotoPreview','editPhotoIcon')">
                            <div style="font-size:11.5px;color:#8A93AE;margin-top:6px;">
                                Kosongkan jika tidak ingin mengganti foto
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Nama --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Nama Lengkap <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="name" id="editName" required autocomplete="off"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                </div>

                {{-- NIM / NIP --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        NIM / NIP <span style="color:#D92D20;">*</span>
                    </label>
                    <input type="text" name="nim_nip" id="editNimNip" required autocomplete="off"
                        style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                </div>

                {{-- Email & No. HP --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Email
                        </label>
                        <input type="email" name="email" id="editEmail" autocomplete="off"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            No. HP
                        </label>
                        <input type="text" name="phone" id="editPhone" autocomplete="off"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Gender & Tanggal Lahir --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Gender
                        </label>
                        <div style="position:relative;">
                            <select name="gender" id="editGender"
                                style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                       padding:0 32px 0 14px;outline:none;appearance:none;
                                       font-family:'DM Sans',sans-serif;font-size:13.5px;
                                       color:#181D35;background:#fff;cursor:pointer;
                                       transition:border-color .2s,box-shadow .2s;"
                                onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                                onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                                <option value="">— Pilih —</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8A93AE" stroke-width="2"
                                style="width:14px;height:14px;position:absolute;right:10px;top:50%;
                                       transform:translateY(-50%);pointer-events:none;">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" id="editBirthDate"
                            style="width:100%;height:42px;border:1.5px solid #D4D9E8;border-radius:10px;
                                   padding:0 14px;outline:none;font-family:'DM Sans',sans-serif;
                                   font-size:13.5px;color:#181D35;background:#fff;
                                   transition:border-color .2s,box-shadow .2s;"
                            onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                            onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Alamat --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#181D35;margin-bottom:8px;">
                        Alamat
                    </label>
                    <textarea name="address" id="editAddress" rows="3" placeholder="Alamat lengkap petugas..."
                        style="width:100%;border:1.5px solid #D4D9E8;border-radius:10px;
                               padding:10px 14px;outline:none;font-family:'DM Sans',sans-serif;
                               font-size:13.5px;color:#181D35;background:#fff;resize:vertical;
                               transition:border-color .2s,box-shadow .2s;"
                        onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                        onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'"></textarea>
                </div>

                {{-- Status Aktif --}}
                <div style="margin-bottom:24px;">
                    <label
                        style="display:flex;align-items:center;gap:10px;cursor:pointer;
                                padding:12px 14px;border:1.5px solid #D4D9E8;border-radius:10px;
                                transition:border-color .2s,background .2s;"
                        onmouseover="this.style.borderColor='#3B6FD4';this.style.background='#F8FAFF'"
                        onmouseout="this.style.borderColor='#D4D9E8';this.style.background='#fff'">
                        <input type="checkbox" name="is_active" id="editIsActive" value="1"
                            style="width:16px;height:16px;accent-color:#1A4BAD;cursor:pointer;">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#181D35;">Akun Aktif</div>
                            <div style="font-size:12px;color:#8A93AE;margin-top:1px;">
                                Petugas dapat login ke sistem
                            </div>
                        </div>
                    </label>
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
     MODAL — Detail Petugas
══════════════════════════════════════ --}}
    <div id="modalDetail"
        style="display:none;position:fixed;inset:0;z-index:200;
           background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
           align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:480px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                margin:16px;max-height:90vh;overflow-y:auto;">

            {{-- Header --}}
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                border:1.5px solid #C0D3F5;display:flex;align-items:center;
                justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:18px;height:18px;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Detail Petugas
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Informasi lengkap akun petugas
                    </div>
                </div>
            </div>

            {{-- Foto + Nama --}}
            <div
                style="display:flex;align-items:center;gap:16px;
                    padding:16px;background:#F5F7FC;border-radius:14px;
                    border:1px solid #EBEEF5;margin-bottom:20px;">
                <div id="detailPhotoWrap"
                    style="width:64px;height:64px;border-radius:12px;overflow:hidden;
                       flex-shrink:0;border:2px solid #C0D3F5;">
                    <img id="detailPhoto" src="" alt=""
                        style="width:100%;height:100%;object-fit:cover;display:none;">
                    <div id="detailInitial"
                        style="width:100%;height:100%;background:#E8F0FB;
                           display:flex;align-items:center;justify-content:center;
                           font-family:'Syne',sans-serif;font-size:22px;
                           font-weight:800;color:#1A4BAD;">
                    </div>
                </div>
                <div>
                    <div id="detailName"
                        style="font-family:'Syne',sans-serif;font-size:15px;
                           font-weight:800;color:#181D35;margin-bottom:4px;">
                    </div>
                    <div id="detailEmail" style="font-size:12.5px;color:#8A93AE;"></div>
                    <div id="detailStatusBadge" style="margin-top:6px;"></div>
                </div>
            </div>

            {{-- Grid Info --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">

                <div style="padding:12px 14px;background:#F5F7FC;border-radius:12px;border:1px solid #EBEEF5;">
                    <div
                        style="font-size:11px;font-weight:600;color:#8A93AE;text-transform:uppercase;
                            letter-spacing:.5px;margin-bottom:4px;">
                        NIM / NIP</div>
                    <div id="detailNimNip"
                        style="font-family:'DM Mono',monospace;font-size:13px;
                           font-weight:600;color:#181D35;">
                        —</div>
                </div>

                <div style="padding:12px 14px;background:#F5F7FC;border-radius:12px;border:1px solid #EBEEF5;">
                    <div
                        style="font-size:11px;font-weight:600;color:#8A93AE;text-transform:uppercase;
                            letter-spacing:.5px;margin-bottom:4px;">
                        No. HP</div>
                    <div id="detailPhone" style="font-size:13px;font-weight:600;color:#181D35;">—</div>
                </div>

                <div style="padding:12px 14px;background:#F5F7FC;border-radius:12px;border:1px solid #EBEEF5;">
                    <div
                        style="font-size:11px;font-weight:600;color:#8A93AE;text-transform:uppercase;
                            letter-spacing:.5px;margin-bottom:4px;">
                        Gender</div>
                    <div id="detailGender" style="font-size:13px;font-weight:600;color:#181D35;">—</div>
                </div>

                <div style="padding:12px 14px;background:#F5F7FC;border-radius:12px;border:1px solid #EBEEF5;">
                    <div
                        style="font-size:11px;font-weight:600;color:#8A93AE;text-transform:uppercase;
                            letter-spacing:.5px;margin-bottom:4px;">
                        Tanggal Lahir</div>
                    <div id="detailBirthDate" style="font-size:13px;font-weight:600;color:#181D35;">—</div>
                </div>

            </div>

            {{-- Alamat --}}
            <div
                style="padding:12px 14px;background:#F5F7FC;border-radius:12px;
                    border:1px solid #EBEEF5;margin-bottom:12px;">
                <div
                    style="font-size:11px;font-weight:600;color:#8A93AE;text-transform:uppercase;
                        letter-spacing:.5px;margin-bottom:4px;">
                    Alamat</div>
                <div id="detailAddress" style="font-size:13px;color:#181D35;line-height:1.6;">—</div>
            </div>

            {{-- Dibuat --}}
            <div style="font-size:12px;color:#8A93AE;text-align:right;margin-bottom:20px;">
                Terdaftar: <span id="detailCreated" style="font-weight:600;"></span>
            </div>

            <button onclick="closeDetailModal()" class="btn-outline" style="width:100%;">
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
                Hapus Petugas?
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
                Petugas <strong id="deletePetugasName"
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
        // PREVIEW FOTO
        // ═══════════════════════════════
        function previewPhoto(inputId, imgId, iconId) {
            const file = document.getElementById(inputId).files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(imgId);
                const icon = document.getElementById(iconId);
                img.src = e.target.result;
                img.style.display = 'block';
                icon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // ═══════════════════════════════
        // TOGGLE PASSWORD VISIBILITY
        // ═══════════════════════════════
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>`;
            }
        }

        // ═══════════════════════════════
        // MODAL TAMBAH
        // ═══════════════════════════════
        function openModal() {
            document.getElementById('modalAdd').style.display = 'flex';
            setTimeout(() => document.getElementById('addName').focus(), 100);
        }

        function closeModal() {
            document.getElementById('modalAdd').style.display = 'none';
            document.getElementById('addName').value = '';
            document.getElementById('addNimNip').value = '';
            document.getElementById('addEmail').value = '';
            document.getElementById('addPhone').value = '';
            document.getElementById('addPassword').value = '';
            document.getElementById('addGender').value = '';
            document.getElementById('addBirthDate').value = '';
            document.getElementById('addAddress').value = '';
            document.getElementById('addIsActive').checked = true;
            document.getElementById('addError').style.display = 'none';
            // reset foto preview
            document.getElementById('addPhotoPreview').style.display = 'none';
            document.getElementById('addPhotoPreview').src = '';
            document.getElementById('addPhotoIcon').style.display = '';
            document.getElementById('addPhoto').value = '';
        }

        function validateAddForm() {
            const password = document.getElementById('addPassword').value;
            if (password.length > 0 && password.length < 6) {
                document.getElementById('addErrorText').textContent = 'Password minimal 6 karakter.';
                document.getElementById('addError').style.display = 'flex';
                return false;
            }
            return true;
        }

        // ═══════════════════════════════
        // MODAL EDIT
        // ═══════════════════════════════
        function openEditModal(id, name, nimNip, phone, email, isActive, gender, birthDate, address, photoUrl) {
            document.getElementById('editName').value = name;
            document.getElementById('editNimNip').value = nimNip;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editEmail').value = email;
            document.getElementById('editIsActive').checked = isActive;
            document.getElementById('editGender').value = gender;
            document.getElementById('editBirthDate').value = birthDate;
            document.getElementById('editAddress').value = address;
            document.getElementById('editForm').action = '/admin/petugas/' + id;

            // Foto preview
            const img = document.getElementById('editPhotoPreview');
            const icon = document.getElementById('editPhotoIcon');
            if (photoUrl) {
                img.src = photoUrl;
                img.style.display = 'block';
                icon.style.display = 'none';
            } else {
                img.src = '';
                img.style.display = 'none';
                icon.style.display = '';
            }
            document.getElementById('editPhoto').value = '';

            document.getElementById('modalEdit').style.display = 'flex';
            setTimeout(() => document.getElementById('editName').focus(), 100);
        }

        function closeEditModal() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        // ═══════════════════════════════
        // MODAL DETAIL
        // ═══════════════════════════════
        function openDetailModal(name, nimNip, phone, email, isActive, gender, birthDate, address, photoUrl, createdAt) {
            // Nama & email
            document.getElementById('detailName').textContent = name;
            document.getElementById('detailEmail').textContent = email || '—';

            // Foto / inisial
            const photo = document.getElementById('detailPhoto');
            const initial = document.getElementById('detailInitial');
            if (photoUrl) {
                photo.src = photoUrl;
                photo.style.display = 'block';
                initial.style.display = 'none';
            } else {
                photo.style.display = 'none';
                initial.style.display = 'flex';
                initial.textContent = name.charAt(0).toUpperCase();
            }

            // Badge status
            const statusBadge = document.getElementById('detailStatusBadge');
            if (isActive) {
                statusBadge.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;
            background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48;
            font-size:12px;font-weight:600;padding:3px 10px;border-radius:100px;">
            <span style="width:6px;height:6px;border-radius:50%;background:#12B76A;display:inline-block;"></span>
            Aktif</span>`;
            } else {
                statusBadge.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;
            background:#F5F7FC;border:1px solid #EBEEF5;color:#8A93AE;
            font-size:12px;font-weight:600;padding:3px 10px;border-radius:100px;">
            <span style="width:6px;height:6px;border-radius:50%;background:#D4D9E8;display:inline-block;"></span>
            Non-Aktif</span>`;
            }

            // Info lainnya
            document.getElementById('detailNimNip').textContent = nimNip || '—';
            document.getElementById('detailPhone').textContent = phone || '—';
            document.getElementById('detailGender').textContent = gender === 'L' ? '♂ Laki-laki' : gender === 'P' ?
                '♀ Perempuan' : '—';
            document.getElementById('detailBirthDate').textContent = birthDate || '—';
            document.getElementById('detailAddress').textContent = address || '—';
            document.getElementById('detailCreated').textContent = createdAt || '—';

            document.getElementById('modalDetail').style.display = 'flex';
        }

        function closeDetailModal() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        // Tambahkan 'modalDetail' ke event listener backdrop & Escape yang sudah ada
        document.getElementById('modalDetail').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });

        // ═══════════════════════════════
        // MODAL HAPUS
        // ═══════════════════════════════
        function confirmDelete(id, name) {
            document.getElementById('deletePetugasName').textContent = name;
            document.getElementById('deleteForm').action = '/admin/petugas/' + id;
            document.getElementById('modalDelete').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('modalDelete').style.display = 'none';
        }

        // ── Tutup modal backdrop & Escape ──
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

        // ═══════════════════════════════
        // FILTER / SEARCH
        // ═══════════════════════════════
        function filterTable() {
            const keyword = document.getElementById('searchPetugas').value.toLowerCase().trim();
            const statusFilter = document.getElementById('filterStatus').value;
            const rows = document.querySelectorAll('#petugasTable tbody tr');
            let visible = 0;

            rows.forEach(row => {
                const nameMatch = (row.dataset.name ?? '').includes(keyword) ||
                    (row.dataset.nim ?? '').includes(keyword);
                const statusMatch = statusFilter === '' || row.dataset.status === statusFilter;
                const show = nameMatch && statusMatch;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            const total = rows.length;
            document.getElementById('tableCount').textContent =
                (keyword || statusFilter) ?
                `Menampilkan ${visible} dari ${total} petugas` :
                `Menampilkan ${total} petugas`;

            document.getElementById('emptySearch').style.display = visible === 0 ? 'block' : 'none';

            let num = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const span = row.querySelector('.row-num');
                    if (span) span.textContent = num++;
                }
            });
        }

        function clearSearch() {
            document.getElementById('searchPetugas').value = '';
            document.getElementById('filterStatus').value = '';
            filterTable();
        }

        // ═══════════════════════════════
        // SORT KOLOM
        // ═══════════════════════════════
        const sortState = {};

        function sortTable(colIndex, thEl) {
            const tbody = document.querySelector('#petugasTable tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const current = sortState[colIndex] || 'none';
            const dir = current === 'asc' ? 'desc' : 'asc';
            sortState[colIndex] = dir;

            document.querySelectorAll('[id^="sort-icon-"]').forEach(el => {
                el.textContent = '↕';
                el.style.color = '#D4D9E8';
            });
            const icon = document.getElementById('sort-icon-' + colIndex);
            if (icon) {
                icon.textContent = dir === 'asc' ? '↑' : '↓';
                icon.style.color = '#1A4BAD';
            }

            rows.sort((a, b) => {
                if (colIndex === 1) {
                    const va = (a.dataset.name || '').toLowerCase();
                    const vb = (b.dataset.name || '').toLowerCase();
                    return dir === 'asc' ? va.localeCompare(vb) : vb.localeCompare(va);
                }
                if (colIndex === 6) {
                    const va = parseInt(a.dataset.created || 0);
                    const vb = parseInt(b.dataset.created || 0);
                    return dir === 'asc' ? va - vb : vb - va;
                }
                return 0;
            });

            rows.forEach((row, i) => {
                tbody.appendChild(row);
                const span = row.querySelector('.row-num');
                if (span) span.textContent = i + 1;
            });
        }
    </script>
@endpush
