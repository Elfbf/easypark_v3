@extends('layouts.app')

@section('title', 'Master Role')
@section('page_title', 'Master Role')

@section('content')

{{-- ── Breadcrumb ── --}}
<nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         style="width:14px;height:14px;color:#8A93AE;flex-shrink:0;">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
    </svg>
    <a href=href="{{ route('dashboard') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
    <span style="color:#D4D9E8;">/</span>
    <a href={{ route('admin.dashboard') }} style="color:#8A93AE;text-decoration:none;">Admin</a>
    <span style="color:#D4D9E8;">/</span>
    <span style="color:#181D35;font-weight:600;">Master Role</span>
</nav>

{{-- ── Page Header ── --}}
<div class="page-head">
    <div>
        <div class="page-title">Master Role</div>
        <div class="page-sub">Kelola hak akses dan role pengguna sistem</div>
    </div>
    <div class="page-head-actions">
        <button class="btn-primary" onclick="openModal()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Role
        </button>
    </div>
</div>

@if(session('error'))
    <div class="alert-banner" style="background:#FEF3F2;border-color:#D92D20;margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <div class="ab-text">
            <div class="ab-title" style="color:#912018;">{{ session('error') }}</div>
        </div>
    </div>
@endif

{{-- ── Tabel Role ── --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Role</div>
            <div class="card-sub">{{ $roles->count() }} role terdaftar dalam sistem</div>
        </div>

        <div style="display:flex;align-items:center;gap:10px;">
            {{-- Search --}}
            <div class="tb-search" style="width:220px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" id="searchRole" placeholder="Cari role..." oninput="filterTable()">
            </div>
        </div>
    </div>

    @if($roles->isEmpty())
        {{-- Empty state --}}
        <div style="padding:64px 24px;text-align:center;">
            <div style="width:60px;height:60px;background:#E8F0FB;border-radius:16px;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                     style="width:28px;height:28px;">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div style="font-family:'Syne',sans-serif;font-size:15px;font-weight:700;
                        color:#181D35;margin-bottom:6px;">
                Belum ada role
            </div>
            <div style="font-size:13px;color:#8A93AE;margin-bottom:22px;line-height:1.6;">
                Tambahkan role pertama untuk mulai mengelola hak akses pengguna
            </div>
            <button class="btn-primary" onclick="openModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Role
            </button>
        </div>

    @else
        <table class="data-table" id="roleTable">
            <thead>
                <tr>
                    <th style="width:52px;padding-left:22px;">#</th>
                    <th>Nama Role</th>
                    <th style="width:120px;">Jumlah User</th>
                    <th style="width:140px;">Dibuat</th>
                    <th style="width:110px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                <tr id="row-{{ $role->id }}" style="transition:background .15s;">

                    {{-- No --}}
                    <td style="color:#8A93AE;font-size:12.5px;padding-left:22px;">
                        {{ $index + 1 }}
                    </td>

                    {{-- Nama Role --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:36px;height:36px;border-radius:10px;
                                        background:#E8F0FB;border:1.5px solid #C0D3F5;
                                        display:flex;align-items:center;justify-content:center;
                                        flex-shrink:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                                     style="width:16px;height:16px;">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:13.5px;color:#181D35;
                                            margin-bottom:2px;">
                                    {{ $role->name }}
                                </div>
                                <code style="background:#F5F7FC;border:1px solid #D4D9E8;
                                             border-radius:5px;padding:1px 7px;
                                             font-size:11px;color:#4A5272;">
                                    {{ Str::slug($role->name) }}
                                </code>
                            </div>
                        </div>
                    </td>

                    {{-- Jumlah User --}}
                    <td>
                        @if(($role->users_count ?? 0) > 0)
                            <span class="badge badge-in">
                                {{ $role->users_count }} pengguna
                            </span>
                        @else
                            <span class="badge badge-out">Kosong</span>
                        @endif
                    </td>

                    {{-- Dibuat --}}
                    <td style="color:#8A93AE;font-size:12.5px;">
                        {{ $role->created_at?->format('d M Y') ?? '-' }}
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:6px;">

                            {{-- Edit --}}
                            <button class="tb-btn"
                                    title="Edit role"
                                    onclick="openEditModal({{ $role->id }}, '{{ addslashes($role->name) }}')"
                                    style="width:32px;height:32px;border-radius:8px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     style="width:14px;height:14px;">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>

                            {{-- Hapus --}}
                            <button class="tb-btn"
                                    title="Hapus role"
                                    onclick="confirmDelete({{ $role->id }}, '{{ addslashes($role->name) }}')"
                                    style="width:32px;height:32px;border-radius:8px;
                                           border-color:#FECDCA;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                                     style="width:14px;height:14px;">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>

                        </div>
                    </td>

                </tr>
                @empty
                    {{-- fallback jika forelse kosong --}}
                @endforelse
            </tbody>
        </table>

        {{-- Footer tabel --}}
        <div style="padding:14px 22px;border-top:1px solid #EBEEF5;
                    display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:12.5px;color:#8A93AE;">
                Menampilkan {{ $roles->count() }} role
            </span>
            <span style="font-size:12px;color:#D4D9E8;">
                Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB
            </span>
        </div>
    @endif
</div>


{{-- ══════════════════════════════════════
     MODAL — Tambah Role
══════════════════════════════════════ --}}
<div id="modalAdd"
     style="display:none;position:fixed;inset:0;z-index:200;
            background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
            align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:420px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                margin:16px;">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                            border:1.5px solid #C0D3F5;display:flex;align-items:center;
                            justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                         style="width:18px;height:18px;">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Tambah Role
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Buat role baru untuk sistem
                    </div>
                </div>
            </div>
            <button onclick="closeModal()"
                    style="width:34px;height:34px;border-radius:9px;background:#F5F7FC;
                           border:1.5px solid #D4D9E8;display:flex;align-items:center;
                           justify-content:center;cursor:pointer;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5272" stroke-width="2"
                     style="width:15px;height:15px;">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form action="{{ url('admin/roles') }}" method="POST">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;
                              color:#181D35;margin-bottom:8px;">
                    Nama Role <span style="color:#D92D20;">*</span>
                </label>
                <input type="text" name="name" id="addRoleName"
                       placeholder="Contoh: Admin, Mahasiswa, Petugas..."
                       required
                       style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                              border-radius:10px;padding:0 14px;outline:none;
                              font-family:'DM Sans',sans-serif;font-size:13.5px;
                              color:#181D35;background:#fff;
                              transition:border-color .2s,box-shadow .2s;"
                       onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                       onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
                <div style="font-size:11.5px;color:#8A93AE;margin-top:6px;">
                    Nama role akan otomatis dijadikan slug, contoh: <code style="font-size:11px;">master-admin</code>
                </div>
            </div>

            <div style="display:flex;gap:10px;">
                <button type="button" onclick="closeModal()" class="btn-outline" style="flex:1;">
                    Batal
                </button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                    Simpan Role
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════
     MODAL — Edit Role
══════════════════════════════════════ --}}
<div id="modalEdit"
     style="display:none;position:fixed;inset:0;z-index:200;
            background:rgba(7,28,82,.45);backdrop-filter:blur(4px);
            align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:420px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                margin:16px;">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#FFFAEB;
                            border:1.5px solid #FDE68A;display:flex;align-items:center;
                            justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#C9960F" stroke-width="2"
                         style="width:18px;height:18px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Edit Role
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Ubah nama role yang dipilih
                    </div>
                </div>
            </div>
            <button onclick="closeEditModal()"
                    style="width:34px;height:34px;border-radius:9px;background:#F5F7FC;
                           border:1.5px solid #D4D9E8;display:flex;align-items:center;
                           justify-content:center;cursor:pointer;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#4A5272" stroke-width="2"
                     style="width:15px;height:15px;">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;
                              color:#181D35;margin-bottom:8px;">
                    Nama Role <span style="color:#D92D20;">*</span>
                </label>
                <input type="text" name="name" id="editRoleName"
                       required
                       style="width:100%;height:42px;border:1.5px solid #D4D9E8;
                              border-radius:10px;padding:0 14px;outline:none;
                              font-family:'DM Sans',sans-serif;font-size:13.5px;
                              color:#181D35;background:#fff;
                              transition:border-color .2s,box-shadow .2s;"
                       onfocus="this.style.borderColor='#3B6FD4';this.style.boxShadow='0 0 0 4px rgba(59,111,212,.10)'"
                       onblur="this.style.borderColor='#D4D9E8';this.style.boxShadow='none'">
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
    <div style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:400px;box-shadow:0 24px 64px rgba(7,28,82,.18);
                margin:16px;text-align:center;">

        <div style="width:60px;height:60px;background:#FEF3F2;border-radius:16px;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#D92D20" stroke-width="2"
                 style="width:28px;height:28px;">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
        </div>

        <div style="font-family:'Syne',sans-serif;font-size:1.05rem;font-weight:800;
                    color:#181D35;margin-bottom:8px;">
            Hapus Role?
        </div>
        <div style="font-size:13px;color:#8A93AE;margin-bottom:6px;line-height:1.6;">
            Role <strong id="deleteRoleName"
                         style="color:#181D35;background:#F5F7FC;padding:1px 8px;
                                border-radius:6px;border:1px solid #D4D9E8;"></strong>
            akan dihapus permanen.
        </div>
        <div style="font-size:12.5px;color:#F79009;background:#FFFAEB;border:1px solid #FDE68A;
                    border-radius:10px;padding:10px 14px;margin-bottom:24px;line-height:1.6;">
            ⚠ Pengguna dengan role ini perlu ditetapkan ulang setelah dihapus.
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
                               font-size:13.5px;font-weight:600;cursor:pointer;
                               transition:background .2s;"
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
    // ── Modal Tambah ──
    function openModal() {
        const m = document.getElementById('modalAdd');
        m.style.display = 'flex';
        setTimeout(() => document.getElementById('addRoleName').focus(), 100);
    }
    function closeModal() {
        document.getElementById('modalAdd').style.display = 'none';
        document.getElementById('addRoleName').value = '';
    }

    // ── Modal Edit ──
    function openEditModal(id, name) {
        document.getElementById('editRoleName').value = name;
        document.getElementById('editForm').action   = '/admin/roles/' + id;
        const m = document.getElementById('modalEdit');
        m.style.display = 'flex';
        setTimeout(() => document.getElementById('editRoleName').focus(), 100);
    }
    function closeEditModal() {
        document.getElementById('modalEdit').style.display = 'none';
    }

    // ── Modal Hapus ──
    function confirmDelete(id, name) {
        document.getElementById('deleteRoleName').textContent = name;
        document.getElementById('deleteForm').action          = '/admin/roles/' + id;
        document.getElementById('modalDelete').style.display  = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('modalDelete').style.display = 'none';
    }

    // ── Tutup modal klik backdrop ──
    ['modalAdd','modalEdit','modalDelete'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });

    // ── Tutup modal tekan Escape ──
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            ['modalAdd','modalEdit','modalDelete'].forEach(id => {
                document.getElementById(id).style.display = 'none';
            });
        }
    });

    // ── Filter tabel client-side ──
    function filterTable() {
        const keyword = document.getElementById('searchRole').value.toLowerCase();
        let visible = 0;
        document.querySelectorAll('#roleTable tbody tr').forEach(row => {
            const name = row.cells[1]?.textContent.toLowerCase() ?? '';
            const show = name.includes(keyword);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
    }
</script>
@endpush