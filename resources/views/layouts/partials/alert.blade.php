{{-- ╔══════════════════════════════════════════════════════╗ --}}
{{-- ║  ALERT / FLASH MESSAGE PARTIAL                       ║ --}}
{{-- ║  Menampilkan: success, error, warning, info          ║ --}}
{{-- ╚══════════════════════════════════════════════════════╝ --}}

{{-- ── Peringatan zona parkir (dari controller / shared data) ── --}}
@if (isset($zonaWarning))
    <div class="alert-banner">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <div class="ab-text">
            <div class="ab-title">{{ $zonaWarning['title'] }}</div>
            <div class="ab-sub">{{ $zonaWarning['message'] }}</div>
        </div>
        @if (isset($zonaWarning['link']))
            <a href="{{ $zonaWarning['link'] }}" class="ab-action">
                {{ $zonaWarning['link_label'] ?? 'Lihat Detail' }} →
            </a>
        @endif
    </div>
@endif

{{-- ── Session: success ── --}}
@if (session('success'))
    <div class="flash-alert flash-success" id="flashAlert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
        <p>{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="flash-close">✕</button>
    </div>
@endif

{{-- ── Session: error ── --}}
@if (session('error'))
    <div class="flash-alert flash-error" id="flashAlert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <p>{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="flash-close">✕</button>
    </div>
@endif

{{-- ── Session: warning ── --}}
@if (session('warning'))
    <div class="flash-alert flash-warning" id="flashAlert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
            <line x1="12" y1="9" x2="12" y2="13" />
            <line x1="12" y1="17" x2="12.01" y2="17" />
        </svg>
        <p>{{ session('warning') }}</p>
        <button onclick="this.parentElement.remove()" class="flash-close">✕</button>
    </div>
@endif

{{-- ── Session: info ── --}}
@if (session('info'))
    <div class="flash-alert flash-info" id="flashAlert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="8" />
            <line x1="12" y1="12" x2="12" y2="16" />
        </svg>
        <p>{{ session('info') }}</p>
        <button onclick="this.parentElement.remove()" class="flash-close">✕</button>
    </div>
@endif

<style>
    .flash-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1.5px solid;
        animation: flashIn .3s ease;
    }

    @keyframes flashIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .flash-alert svg { width: 16px; height: 16px; flex-shrink: 0; }
    .flash-alert p   { font-size: 13.5px; flex: 1; line-height: 1.5; }

    .flash-close {
        background: none; border: none; cursor: pointer;
        font-size: 13px; padding: 2px 6px; border-radius: 6px;
        opacity: 0.6; transition: opacity .18s;
    }

    .flash-close:hover { opacity: 1; }

    .flash-success { background: var(--success-bg); border-color: #6CE9A6; color: #027A48; }
    .flash-success svg { color: var(--success); }
    .flash-error   { background: var(--err-bg);     border-color: #FECDCA; color: var(--err); }
    .flash-error svg { color: var(--err); }
    .flash-warning { background: var(--warn-bg);    border-color: #FEC84B; color: #B54708; }
    .flash-warning svg { color: var(--warn); }
    .flash-info    { background: var(--p-50);        border-color: var(--p-100); color: var(--p-800); }
    .flash-info svg { color: var(--p-600); }
</style>
