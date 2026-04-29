<script>
    /* ══════════════════════════════════════════════
     |  GLOBAL SCRIPTS — EasyPark Layout
     ══════════════════════════════════════════════ */

    /* ── Sidebar toggle (mobile) ── */
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    /* ── Auto-dismiss flash alerts setelah 5 detik ── */
    document.addEventListener('DOMContentLoaded', function () {
        const flash = document.getElementById('flashAlert');
        if (flash) {
            setTimeout(() => {
                flash.style.transition = 'opacity .4s ease, transform .4s ease';
                flash.style.opacity    = '0';
                flash.style.transform  = 'translateY(-8px)';
                setTimeout(() => flash.remove(), 400);
            }, 5000);
        }
    });

    /* ── Active nav item highlight (fallback untuk Blade) ── */
    document.addEventListener('DOMContentLoaded', function () {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sb-item').forEach(item => {
            if (item.getAttribute('href') && currentPath.startsWith(item.getAttribute('href'))) {
                item.classList.add('active');
            }
        });
    });
</script>
