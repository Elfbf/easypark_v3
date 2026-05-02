@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')

    @php
        $user = Auth::user();
        $nameParts = explode(' ', $user->name);
        $initials = strtoupper($nameParts[0][0] ?? '') . strtoupper(end($nameParts)[0] ?? '');
    @endphp

    {{-- Breadcrumb --}}
    <nav style="display:flex;align-items:center;gap:6px;font-size:13px;margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            style="width:14px;height:14px;color:#8A93AE;flex-shrink:0;">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        <a href="{{ route('dashboard') }}" style="color:#8A93AE;text-decoration:none;">EasyPark</a>
        <span style="color:#D4D9E8;">/</span>
        <span style="color:#181D35;font-weight:600;">Profil Saya</span>
    </nav>

    {{-- Toast --}}
    <div id="toastContainer"
        style="position:fixed;top:24px;right:24px;z-index:999;
               display:flex;flex-direction:column;gap:10px;pointer-events:none;">
    </div>

    {{-- Layout 2 kolom --}}
    <div style="display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;">

        {{-- ── Kartu Kiri — Avatar & Info Singkat ── --}}
        <div class="card" style="padding:32px 24px;text-align:center;">

            {{-- Avatar --}}
            <div style="position:relative;display:inline-block;margin-bottom:16px;">
                <div
                    style="width:96px;height:96px;border-radius:50%;
                            background:#E8F0FB;border:3px solid #C0D3F5;
                            display:flex;align-items:center;justify-content:center;
                            overflow:hidden;margin:0 auto;
                            font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:#1A4BAD;">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ $initials }}
                    @endif
                </div>
                {{-- Badge status aktif --}}
                <span
                    style="position:absolute;bottom:4px;right:4px;
                             width:14px;height:14px;border-radius:50%;
                             background:#12B76A;border:2px solid #fff;display:block;"></span>
            </div>

            <div
                style="font-family:'Syne',sans-serif;font-size:16px;font-weight:800;
                        color:#181D35;margin-bottom:4px;">
                {{ $user->name }}</div>
            <div style="font-size:12.5px;color:#8A93AE;margin-bottom:16px;">
                {{ $user->email }}
            </div>

            {{-- Badge role --}}
            <span
                style="display:inline-flex;align-items:center;gap:5px;
                         background:#E8F0FB;border:1px solid #C0D3F5;
                         color:#1A4BAD;font-size:12px;font-weight:600;
                         padding:4px 14px;border-radius:100px;margin-bottom:24px;">
                <span
                    style="width:6px;height:6px;border-radius:50%;
                             background:#1A4BAD;display:inline-block;"></span>
                {{ ucfirst($user->role->name) }}
            </span>

            <div
                style="border-top:1px solid #EBEEF5;padding-top:20px;
                        display:flex;flex-direction:column;gap:10px;">
                <button onclick="openEditProfileModal()" class="btn-primary"
                    style="width:100%;justify-content:center;gap:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:14px;height:14px;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit Profil
                </button>
                <button onclick="openChangePasswordModal()" class="btn-outline"
                    style="width:100%;justify-content:center;gap:8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:14px;height:14px;">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    Ganti Password
                </button>
            </div>
        </div>

        {{-- ── Kartu Kanan — Detail Info ── --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- Informasi Akun --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informasi Akun</div>
                        <div class="card-sub">Data identitas & kontak</div>
                    </div>
                </div>

                <div style="padding:0 24px 24px;">
                    <div
                        style="display:grid;grid-template-columns:1fr 1fr;gap:0;
                   border:1.5px solid #EBEEF5;border-radius:14px;overflow:hidden;">

                        @php
                            if ($user->role->name === 'admin') {
                                $rows = [
                                    ['label' => 'Nama Lengkap', 'value' => $user->name],
                                    ['label' => 'Email', 'value' => $user->email],
                                ];
                            } else {
                                $rows = [
                                    ['label' => 'Nama Lengkap', 'value' => $user->name],
                                    ['label' => 'Email', 'value' => $user->email],
                                    ['label' => 'No. HP', 'value' => $user->phone ?? '—'],
                                    ['label' => 'NIM / NIP', 'value' => $user->nim_nip ?? '—'],
                                    [
                                        'label' => 'Jenis Kelamin',
                                        'value' =>
                                            $user->gender === 'L'
                                                ? 'Laki-laki'
                                                : ($user->gender === 'P'
                                                    ? 'Perempuan'
                                                    : '—'),
                                    ],
                                    [
                                        'label' => 'Tanggal Lahir',
                                        'value' => $user->birth_date?->translatedFormat('d F Y') ?? '—',
                                    ],
                                    [
                                        'label' => 'Alamat',
                                        'value' => $user->address ?? '—',
                                        'full' => true,
                                    ],
                                ];
                            }
                        @endphp

                        @foreach ($rows as $i => $row)
                            <div
                                style="
                        padding:14px 18px;
                        {{ $i % 2 === 1 ? 'background:#FAFBFD;' : '' }}
                        {{ !empty($row['full']) ? 'grid-column:1/-1;' : '' }}
                        {{ $i < count($rows) - 1 ? 'border-bottom:1px solid #EBEEF5;' : '' }}
                    ">

                                <div style="font-size:11.5px;color:#8A93AE;font-weight:500;margin-bottom:4px;">
                                    {{ $row['label'] }}
                                </div>

                                <div
                                    style="
                            font-size:13.5px;
                            font-weight:600;
                            color:#181D35;
                            {{ !empty($row['full']) ? 'line-height:1.6;' : '' }}
                        ">
                                    {{ $row['value'] }}
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- Informasi Sistem --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Informasi Sistem</div>
                        <div class="card-sub">Aktivitas & status akun</div>
                    </div>
                </div>
                <div style="padding:0 24px 24px;">
                    <div style="border:1.5px solid #EBEEF5;border-radius:14px;overflow:hidden;">
                        @php
                            $sysRows = [
                                [
                                    'label' => 'Status Akun',
                                    'value' => $user->is_active ? 'Aktif' : 'Nonaktif',
                                    'badge' => $user->is_active,
                                ],
                                [
                                    'label' => 'Login Terakhir',
                                    'value' => $user->last_login_at?->translatedFormat('d F Y, H:i') ?? '—',
                                ],
                                ['label' => 'Bergabung Sejak', 'value' => $user->created_at->translatedFormat('d F Y')],
                            ];
                        @endphp
                        @foreach ($sysRows as $i => $row)
                            <div
                                style="display:flex;align-items:center;padding:14px 18px;
                                        {{ $i % 2 === 1 ? 'background:#FAFBFD;' : '' }}
                                        {{ $i < count($sysRows) - 1 ? 'border-bottom:1px solid #EBEEF5;' : '' }}">
                                <div style="font-size:12.5px;color:#8A93AE;font-weight:500;width:160px;flex-shrink:0;">
                                    {{ $row['label'] }}
                                </div>
                                @if (isset($row['badge']))
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;
                                                 {{ $row['badge'] ? 'background:#ECFDF3;border:1px solid #6CE9A6;color:#027A48;' : 'background:#F5F7FC;border:1px solid #D4D9E8;color:#4A5272;' }}
                                                 font-size:12px;font-weight:600;
                                                 padding:3px 10px;border-radius:100px;">
                                        <span
                                            style="width:5px;height:5px;border-radius:50%;
                                                     background:{{ $row['badge'] ? '#12B76A' : '#D4D9E8' }};
                                                     display:inline-block;"></span>
                                        {{ $row['value'] }}
                                    </span>
                                @else
                                    <div style="font-size:13px;font-weight:600;color:#181D35;">
                                        {{ $row['value'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ══ MODAL EDIT PROFIL ══ --}}
    <div id="modalEditProfile"
        style="display:none;position:fixed;inset:0;z-index:300;
           background:rgba(7,28,82,.5);backdrop-filter:blur(4px);
           align-items:center;justify-content:center;">

        <div
            style="background:#fff;border-radius:20px;padding:32px;
                width:100%;max-width:560px;max-height:90vh;overflow-y:auto;
                box-shadow:0 24px 64px rgba(7,28,82,.2);margin:16px;">

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                        border:1.5px solid #C0D3F5;display:flex;align-items:center;
                        justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:18px;height:18px;">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                </div>

                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Edit Profil
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">
                        Perbarui informasi akun Anda
                    </div>
                </div>

                <button onclick="closeEditProfileModal()"
                    style="margin-left:auto;background:none;border:none;cursor:pointer;
                       width:32px;height:32px;border-radius:8px;display:flex;
                       align-items:center;justify-content:center;color:#8A93AE;transition:background .2s;"
                    onmouseover="this.style.background='#F5F7FC'" onmouseout="this.style.background='transparent'">

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:16px;height:16px;">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- FOTO --}}
                <div
                    style="display:flex;align-items:center;gap:16px;margin-bottom:24px;
                        padding:16px;background:#F8FAFF;border-radius:12px;border:1.5px solid #E8F0FB;">

                    <div id="photoPreview"
                        style="width:64px;height:64px;border-radius:50%;flex-shrink:0;
                           background:#E8F0FB;border:2px solid #C0D3F5;
                           display:flex;align-items:center;justify-content:center;
                           overflow:hidden;font-family:'Syne',sans-serif;
                           font-size:20px;font-weight:800;color:#1A4BAD;">

                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}"
                                style="width:100%;height:100%;object-fit:cover;">
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                    <div>
                        <div style="font-size:13px;font-weight:600;color:#181D35;margin-bottom:6px;">
                            Foto Profil
                        </div>

                        <label
                            style="display:inline-flex;align-items:center;gap:6px;height:32px;
                               padding:0 12px;border:1.5px solid #D4D9E8;border-radius:8px;
                               font-size:12px;font-weight:600;color:#4A5272;cursor:pointer;
                               background:#fff;transition:border-color .2s;"
                            onmouseover="this.style.borderColor='#3B6FD4'" onmouseout="this.style.borderColor='#D4D9E8'">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                style="width:12px;height:12px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>

                            Upload Foto

                            <input type="file" name="photo" accept="image/*" style="display:none;"
                                onchange="previewPhoto(this)">
                        </label>

                        <div style="font-size:11px;color:#8A93AE;margin-top:4px;">
                            JPG, PNG maks. 2MB
                        </div>
                    </div>
                </div>

                {{-- ================= ADMIN ================= --}}
                @if ($user->role->name === 'admin')
                    <div style="display:flex;flex-direction:column;gap:16px;">

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                                   color:#4A5272;margin-bottom:6px;">
                                Nama Lengkap <span style="color:#D92D20;">*</span>
                            </label>

                            <input type="text" name="name" value="{{ $user->name }}" required
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                                   border-radius:10px;padding:0 12px;
                                   font-family:'DM Sans',sans-serif;font-size:13px;
                                   color:#181D35;outline:none;box-sizing:border-box;
                                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                                   color:#4A5272;margin-bottom:6px;">
                                Email <span style="color:#D92D20;">*</span>
                            </label>

                            <input type="email" name="email" value="{{ $user->email }}" required
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                                   border-radius:10px;padding:0 12px;
                                   font-family:'DM Sans',sans-serif;font-size:13px;
                                   color:#181D35;outline:none;box-sizing:border-box;
                                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                    </div>
                @else
                    {{-- ================= PETUGAS / MAHASISWA ================= --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                        <div style="grid-column:1/-1;">
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                Nama Lengkap <span style="color:#D92D20;">*</span>
                            </label>

                            <input type="text" name="name" value="{{ $user->name }}" required
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                Email <span style="color:#D92D20;">*</span>
                            </label>

                            <input type="email" name="email" value="{{ $user->email }}" required
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                No. HP
                            </label>

                            <input type="text" name="phone" value="{{ $user->phone }}" placeholder="08xxxxxxxxxx"
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                NIM / NIP
                            </label>

                            <input type="text" name="nim_nip" value="{{ $user->nim_nip }}"
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                Jenis Kelamin
                            </label>

                            <select name="gender"
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 32px 0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   background:#fff;appearance:none;cursor:pointer;
                   transition:border-color .2s;
                   background-image:url(\"data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='%238A93AE' stroke-width='2' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E\");
                   background-repeat:no-repeat;
                   background-position:right 10px center;
                   background-size:14px;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">

                                <option value="">— Pilih —</option>
                                <option value="L" {{ $user->gender === 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ $user->gender === 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                Tanggal Lahir
                            </label>

                            <input type="date" name="birth_date" value="{{ $user->birth_date?->format('Y-m-d') }}"
                                style="width:100%;height:40px;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:0 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   cursor:pointer;transition:border-color .2s;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                        </div>

                        <div style="grid-column:1/-1;">
                            <label
                                style="display:block;font-size:12.5px;font-weight:600;
                   color:#4A5272;margin-bottom:6px;">
                                Alamat
                            </label>

                            <textarea name="address" rows="3" placeholder="Jl. ..."
                                style="width:100%;border:1.5px solid #D4D9E8;
                   border-radius:10px;padding:10px 12px;
                   font-family:'DM Sans',sans-serif;font-size:13px;
                   color:#181D35;outline:none;box-sizing:border-box;
                   resize:vertical;transition:border-color .2s;
                   line-height:1.5;"
                                onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">{{ $user->address }}</textarea>
                        </div>

                    </div>
                @endif

                <div style="display:flex;gap:10px;margin-top:24px;">
                    <button type="button" onclick="closeEditProfileModal()" class="btn-outline"
                        style="flex:1;justify-content:center;">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary" style="flex:2;justify-content:center;">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ══ MODAL GANTI PASSWORD ══ --}}
    <div id="modalChangePassword"
        style="display:none;position:fixed;inset:0;z-index:300;
               background:rgba(7,28,82,.5);backdrop-filter:blur(4px);
               align-items:center;justify-content:center;">
        <div
            style="background:#fff;border-radius:20px;padding:32px;
                    width:100%;max-width:420px;
                    box-shadow:0 24px 64px rgba(7,28,82,.2);margin:16px;">

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:40px;height:40px;border-radius:10px;background:#E8F0FB;
                            border:1.5px solid #C0D3F5;display:flex;align-items:center;
                            justify-content:center;flex-shrink:0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#1A4BAD" stroke-width="2"
                        style="width:18px;height:18px;">
                        <rect x="3" y="11" width="18" height="11" rx="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <div>
                    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:#181D35;">
                        Ganti Password
                    </div>
                    <div style="font-size:12px;color:#8A93AE;margin-top:2px;">Pastikan password baru mudah diingat</div>
                </div>
                <button onclick="closeChangePasswordModal()"
                    style="margin-left:auto;background:none;border:none;cursor:pointer;
                           width:32px;height:32px;border-radius:8px;display:flex;
                           align-items:center;justify-content:center;color:#8A93AE;transition:background .2s;"
                    onmouseover="this.style.background='#F5F7FC'" onmouseout="this.style.background='transparent'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        style="width:16px;height:16px;">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PATCH')

                <div style="display:flex;flex-direction:column;gap:16px;">

                    @foreach ([['id' => 'currentPwd', 'name' => 'current_password', 'label' => 'Password Saat Ini'], ['id' => 'newPwd', 'name' => 'password', 'label' => 'Password Baru'], ['id' => 'confirmPwd', 'name' => 'password_confirmation', 'label' => 'Konfirmasi Password Baru']] as $field)
                        <div>
                            <label style="display:block;font-size:12.5px;font-weight:600;color:#4A5272;margin-bottom:6px;">
                                {{ $field['label'] }} <span style="color:#D92D20;">*</span>
                            </label>
                            <div style="position:relative;">
                                <input type="password" name="{{ $field['name'] }}" id="{{ $field['id'] }}" required
                                    style="width:100%;height:40px;border:1.5px solid #D4D9E8;border-radius:10px;
                                       padding:0 40px 0 12px;font-family:'DM Sans',sans-serif;font-size:13px;
                                       color:#181D35;outline:none;box-sizing:border-box;transition:border-color .2s;"
                                    onfocus="this.style.borderColor='#3B6FD4'" onblur="this.style.borderColor='#D4D9E8'">
                                <button type="button" onclick="togglePwd('{{ $field['id'] }}', this)"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);
                                       background:none;border:none;cursor:pointer;color:#8A93AE;padding:0;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        style="width:15px;height:15px;">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div style="display:flex;gap:10px;margin-top:24px;">
                    <button type="button" onclick="closeChangePasswordModal()" class="btn-outline"
                        style="flex:1;justify-content:center;">Batal</button>
                    <button type="submit" class="btn-primary" style="flex:2;justify-content:center;">Ganti
                        Password</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
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
            };
            const c = configs[type] || configs.success;
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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
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
        @keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(20px)} }`;
        document.head.appendChild(toastStyle);

        function openEditProfileModal() {
            document.getElementById('modalEditProfile').style.display = 'flex';
        }

        function closeEditProfileModal() {
            document.getElementById('modalEditProfile').style.display = 'none';
        }

        function openChangePasswordModal() {
            document.getElementById('modalChangePassword').style.display = 'flex';
        }

        function closeChangePasswordModal() {
            document.getElementById('modalChangePassword').style.display = 'none';
        }

        ['modalEditProfile', 'modalChangePassword'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) this.style.display = 'none';
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape')
                ['modalEditProfile', 'modalChangePassword'].forEach(id =>
                    document.getElementById(id).style.display = 'none');
        });

        function previewPhoto(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('photoPreview').innerHTML =
                    `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }

        function togglePwd(inputId, btn) {
            const input = document.getElementById(inputId);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.querySelector('svg').style.opacity = isText ? '1' : '0.4';
        }

    </script>
@endpush
