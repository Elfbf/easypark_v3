{{-- sidebar.blade.php --}}
<aside class="sidebar" id="sidebar">
    <div class="sb-orb sb-orb-1"></div>
    <div class="sb-orb sb-orb-2"></div>

    <!-- Logo -->
    <div class="sb-header">
        <div class="sb-logo">
            <div class="sb-logo-box">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="3" width="7" height="9" rx="2" fill="white" opacity="0.9" />
                    <rect x="12" y="3" width="9" height="9" rx="2" fill="white" opacity="0.5" />
                    <rect x="3" y="14" width="18" height="7" rx="2" fill="white" opacity="0.75" />
                </svg>
            </div>
            <div>
                <div class="sb-wordmark">Easy<span>Park</span></div>
                <div class="sb-campus">Polije — Bondowoso</div>
            </div>
        </div>
    </div>

    @php
        $nameParts = explode(' ', Auth::user()->name);
        $initials = strtoupper($nameParts[0][0] ?? '') . strtoupper(end($nameParts)[0] ?? '');
        $role = Auth::user()->role->name; // 'admin' | 'petugas' | 'mahasiswa'
    @endphp

    <!-- User -->
    <div class="sb-user">
        <div class="sb-avatar">{{ $initials }}</div>
        <div>
            <div class="sb-uname">{{ Auth::user()->name }}</div>
            <div class="sb-urole">{{ ucfirst($role) }}</div>
        </div>
        <div class="sb-badge">{{ ucfirst($role) }}</div>
    </div>

    <!-- Navigation -->
    <nav class="sb-nav">

        {{-- ══════════════════════════════════════
             ADMIN
        ══════════════════════════════════════ --}}
        @if ($role === 'admin')
            {{-- Utama --}}
            <div class="sb-section-label">Utama</div>

            <a href="{{ route('admin.dashboard') }}"
                class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Manajemen Pengguna --}}
            <div class="sb-section-label" style="margin-top:16px">Manajemen Pengguna</div>

            <a href="{{ route('admin.roles.index') }}"
                class="sb-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    <path d="M16 4l2 2 4-4" />
                </svg>
                <span>Role</span>
            </a>

            <a href="{{ route('admin.petugas.index') }}"
                class="sb-item {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="M9 12l2 2 4-4" />
                </svg>
                <span>Petugas</span>
            </a>

            <a href="{{ route('admin.mahasiswa.index') }}"
                class="sb-item {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 10L12 4 2 10l10 6 10-6z" />
                    <path d="M6 12v5c0 2 2.7 4 6 4s6-2 6-4v-5" />
                    <line x1="22" y1="10" x2="22" y2="16" />
                </svg>
                <span>Mahasiswa</span>
            </a>

            {{-- Akademik --}}
            <div class="sb-section-label" style="margin-top:16px">Akademik</div>

            <a href="{{ route('admin.departments.index') }}"
                class="sb-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 7V5a2 2 0 0 0-4 0v2" />
                    <line x1="8" y1="14" x2="16" y2="14" />
                </svg>
                <span>Jurusan</span>
            </a>

            <a href="{{ route('admin.study-programs.index') }}"
                class="sb-item {{ request()->routeIs('admin.study-programs.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    <line x1="9" y1="9" x2="15" y2="9" />
                    <line x1="9" y1="13" x2="13" y2="13" />
                </svg>
                <span>Program Studi</span>
            </a>

            {{-- Kendaraan --}}
            <div class="sb-section-label" style="margin-top:16px">Kendaraan</div>

            <a href="{{ route('admin.vehicle-types.index') }}"
                class="sb-item {{ request()->routeIs('admin.vehicle-types.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="5" rx="2" />
                    <circle cx="7" cy="18" r="2" />
                    <circle cx="17" cy="18" r="2" />
                </svg>
                <span>Tipe Kendaraan</span>
            </a>

            <a href="{{ route('admin.vehicle-brands.index') }}"
                class="sb-item {{ request()->routeIs('admin.vehicle-brands.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 12V4a2 2 0 0 0-2-2H4v16h8" />
                    <path d="M16 16l4 4" />
                    <circle cx="16" cy="16" r="4" />
                </svg>
                <span>Brand Kendaraan</span>
            </a>

            <a href="{{ route('admin.vehicles.index') }}"
                class="sb-item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="11" width="22" height="6" rx="2" />
                    <path d="M5 11l2-5h10l2 5" />
                    <circle cx="7" cy="18" r="2" />
                    <circle cx="17" cy="18" r="2" />
                </svg>
                <span>Kendaraan</span>
            </a>

            {{-- Parkir --}}
            <div class="sb-section-label" style="margin-top:16px">Parkir</div>

            <a href="{{ route('admin.parking-areas.index') }}"
                class="sb-item {{ request()->routeIs('admin.parking-areas.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M8 17V7h5a3 3 0 0 1 0 6H8" />
                    <line x1="8" y1="13" x2="14" y2="13" />
                </svg>
                <span>Area Parkir</span>
            </a>

            <a href="{{ route('admin.parking-slots.index') }}"
                class="sb-item {{ request()->routeIs('admin.parking-slots.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="M7 9h10" />
                    <path d="M7 13h6" />
                    <circle cx="17" cy="13" r="1" fill="currentColor" />
                </svg>
                <span>Slot Parkir</span>
            </a>

            <a href="{{ route('admin.parking-records.index') }}"
                class="sb-item {{ request()->routeIs('admin.parking-records.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01" />
                </svg>
                <span>Parking Records</span>
            </a>

            {{-- Monitoring & Log --}}
            <div class="sb-section-label" style="margin-top:16px">Monitoring &amp; Log</div>

            <a href="javascript:void(0)" class="sb-item disabled">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9" />
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                </svg>
                <span>Activity Logs</span>
            </a>

            {{-- Pengaturan --}}
            <div class="sb-section-label" style="margin-top:16px">Pengaturan</div>

            <a href="javascript:void(0)" class="sb-item disabled">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                <span>Profil</span>
            </a>

            {{-- ══════════════════════════════════════
             PETUGAS
        ══════════════════════════════════════ --}}
        @elseif ($role === 'petugas')
            <div class="sb-section-label">Utama</div>

            <a href="{{ route('admin.dashboard') }}"
                class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="sb-section-label" style="margin-top:16px">Parkir</div>

            <a href="{{ route('admin.parking-areas.index') }}"
                class="sb-item {{ request()->routeIs('admin.parking-areas.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M8 17V7h5a3 3 0 0 1 0 6H8" />
                    <line x1="8" y1="13" x2="14" y2="13" />
                </svg>
                <span>Area Parkir</span>
            </a>

            <a href="{{ route('admin.parking-slots.index') }}"
                class="sb-item {{ request()->routeIs('admin.parking-slots.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="M7 9h10" />
                    <path d="M7 13h6" />
                    <circle cx="17" cy="13" r="1" fill="currentColor" />
                </svg>
                <span>Slot Parkir</span>
            </a>

            <a href="{{ route('admin.vehicles.index') }}"
                class="sb-item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="11" width="22" height="6" rx="2" />
                    <path d="M5 11l2-5h10l2 5" />
                    <circle cx="7" cy="18" r="2" />
                    <circle cx="17" cy="18" r="2" />
                </svg>
                <span>Kendaraan</span>
            </a>

            {{-- ══════════════════════════════════════
             MAHASISWA
        ══════════════════════════════════════ --}}
        @elseif ($role === 'mahasiswa')
            <div class="sb-section-label">Utama</div>

            <a href="{{ route('mahasiswa.dashboard') }}"
                class="sb-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="sb-section-label" style="margin-top:16px">Kendaraan Saya</div>

            <a href="#" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="11" width="22" height="6" rx="2" />
                    <path d="M5 11l2-5h10l2 5" />
                    <circle cx="7" cy="18" r="2" />
                    <circle cx="17" cy="18" r="2" />
                </svg>
                <span>Kendaraan Saya</span>
            </a>

            <div class="sb-section-label" style="margin-top:16px">Parkir</div>

            <a href="#" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M8 17V7h5a3 3 0 0 1 0 6H8" />
                    <line x1="8" y1="13" x2="14" y2="13" />
                </svg>
                <span>Cek Area Parkir</span>
            </a>

            <a href="#" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <line x1="16" y1="2" x2="16" y2="6" />
                    <line x1="8" y1="2" x2="8" y2="6" />
                    <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                <span>Riwayat Parkir</span>
            </a>

            <div class="sb-section-label" style="margin-top:16px">Akun</div>

            <a href="#" class="sb-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                <span>Profil Saya</span>
            </a>
        @endif

        {{-- ══════════════════════════════════════
             SISTEM — tampil untuk semua role
        ══════════════════════════════════════ --}}
        <div class="sb-section-label" style="margin-top:16px">Sistem</div>

        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button" class="sb-item sb-logout-btn"
                onclick="document.getElementById('logout-modal').classList.add('show')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Logout</span>
            </button>
        </form>

    </nav>

    <!-- Footer -->
    <div class="sb-footer">
        <div class="status-dot">
            <div class="dot-live"></div>
            <span>Sistem aktif — {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
        </div>
    </div>

    <!-- Modal Logout -->
    <div id="logout-modal" class="lm-overlay">
        <div class="lm-box">
            <div class="lm-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
            </div>
            <div class="lm-title">Keluar dari sistem?</div>
            <div class="lm-sub">Sesi Anda akan diakhiri dan Anda perlu login kembali.</div>
            <div class="lm-actions">
                <button class="lm-cancel" onclick="document.getElementById('logout-modal').classList.remove('show')">
                    Batal
                </button>
                <button class="lm-confirm" onclick="document.getElementById('logout-form').submit()">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

</aside>
