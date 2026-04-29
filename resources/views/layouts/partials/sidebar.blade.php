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

    <!-- User -->
    <div class="sb-user">
        <div class="sb-avatar">AC</div>
        <div>
            <div class="sb-uname">Alief Chandra</div>
            <div class="sb-urole">Admin</div>
        </div>
        <div class="sb-badge">Admin</div>
    </div>

    <!-- Navigation -->
    <nav class="sb-nav">

        <!-- ── UTAMA ── -->
        <div class="sb-section-label">Utama</div>

        <a href="#" class="sb-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="14" width="7" height="7" rx="1" />
                <rect x="3" y="14" width="7" height="7" rx="1" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.roles.index') }}"
            class="sb-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                <path d="M16 4l2 2 4-4" />
            </svg>
            <span>Master Role</span>
        </a>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                <path d="M9 12l2 2 4-4" />
            </svg>
            <span>Petugas</span>
        </a>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 10L12 4 2 10l10 6 10-6z" />
                <path d="M6 12v5c0 2 2.7 4 6 4s6-2 6-4v-5" />
                <line x1="22" y1="10" x2="22" y2="16" />
            </svg>
            <span>Mahasiswa</span>
        </a>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2" />
                <path d="M16 7V5a2 2 0 0 0-4 0v2" />
                <line x1="8" y1="14" x2="16" y2="14" />
            </svg>
            <span>Jurusan</span>
        </a>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                <line x1="9" y1="9" x2="15" y2="9" />
                <line x1="9" y1="13" x2="13" y2="13" />
            </svg>
            <span>Program Studi</span>
        </a>

        <!-- ── LAPORAN ── -->
        <div class="sb-section-label" style="margin-top: 16px">Laporan</div>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="20" x2="18" y2="10" />
                <line x1="12" y1="20" x2="12" y2="4" />
                <line x1="6" y1="20" x2="6" y2="14" />
            </svg>
            <span>Analitik</span>
        </a>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
            </svg>
            <span>Ekspor Laporan</span>
        </a>

        <!-- ── SISTEM ── -->
        <div class="sb-section-label" style="margin-top: 16px">Sistem</div>

        <a href="#" class="sb-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3" />
                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
            <span>Pengaturan</span>
        </a>

        <button class="sb-item"
            style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            <span>Keluar</span>
        </button>

    </nav>

    <!-- Footer -->
    <div class="sb-footer">
        <div class="status-dot">
            <div class="dot-live"></div>
            <span>Sistem aktif — Rabu, 29 Apr 2026</span>
        </div>
    </div>
</aside>
