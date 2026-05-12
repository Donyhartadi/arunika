    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Picker -->
    <div class="theme-picker-wrap" id="themePickerWrap">
        <div class="theme-panel" id="themePanel" hidden>
            <div class="theme-panel-title">Tema Aplikasi</div>
            <div class="theme-swatches">
                <button class="theme-swatch" data-theme="default" style="--sw:#0d9488">
                    <span class="theme-dot"></span>Default
                </button>
                <button class="theme-swatch" data-theme="dark" style="--sw:#334155">
                    <span class="theme-dot"></span>Dark
                </button>
                <button class="theme-swatch" data-theme="ocean" style="--sw:#2563eb">
                    <span class="theme-dot"></span>Ocean
                </button>
                <button class="theme-swatch" data-theme="rose" style="--sw:#e11d48">
                    <span class="theme-dot"></span>Rose
                </button>
            </div>
        </div>
        <button class="theme-fab" id="themeFab" title="Ganti tema" aria-label="Ganti tema" aria-expanded="false">🎨</button>
    </div>

    <script>
    (function () {
        var fab   = document.getElementById('themeFab');
        var panel = document.getElementById('themePanel');
        var saved = localStorage.getItem('arunika_theme') || 'default';

        function applyTheme(t) {
            if (t === 'default') {
                document.documentElement.removeAttribute('data-theme');
            } else {
                document.documentElement.setAttribute('data-theme', t);
            }
            localStorage.setItem('arunika_theme', t);
            document.querySelectorAll('.theme-swatch').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.theme === t);
            });
        }

        // Apply current saved theme on load
        applyTheme(saved);

        fab.addEventListener('click', function () {
            var isOpen = !panel.hidden;
            panel.hidden = isOpen;
            fab.classList.toggle('open', !isOpen);
            fab.setAttribute('aria-expanded', String(!isOpen));
        });

        document.querySelectorAll('.theme-swatch').forEach(function (btn) {
            btn.addEventListener('click', function () {
                applyTheme(this.dataset.theme);
                panel.hidden = true;
                fab.classList.remove('open');
                fab.setAttribute('aria-expanded', 'false');
            });
        });

        // Close panel when clicking outside
        document.addEventListener('click', function (e) {
            if (!document.getElementById('themePickerWrap').contains(e.target)) {
                panel.hidden = true;
                fab.classList.remove('open');
                fab.setAttribute('aria-expanded', 'false');
            }
        });
    })();
    </script>

<?php
// Popup notifikasi — hanya untuk user yang sudah login (bukan admin)
$_sess = service('session');
if ($_sess->get('isLoggedIn') && $_sess->get('role') !== 'admin'):
    $_userId = (int) $_sess->get('user_id');
    if ($_userId > 0):
        $notifModel    = new \App\Models\NotificationModel();
        $pendingNotifs = $notifModel->getUnreadForUser($_userId);
        if (!empty($pendingNotifs)):
            // Tandai sebagai sudah dibaca di database (permanen, antar sesi)
            $notifModel->markRead($_userId, array_column($pendingNotifs, 'id'));
?>
<style>
.notif-popup-backdrop {
    display: flex;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    animation: notif-fadein 0.2s ease;
}
@keyframes notif-fadein { from { opacity: 0; } to { opacity: 1; } }
.notif-popup-dialog {
    background: var(--surface, #fff);
    border-radius: var(--radius-xl, 16px);
    box-shadow: 0 24px 64px rgba(0,0,0,0.28);
    width: 100%;
    max-width: 500px;
    max-height: 85vh;
    overflow-y: auto;
    animation: notif-slidein 0.25s ease;
}
@keyframes notif-slidein { from { transform: translateY(24px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.notif-popup-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 1rem 1.25rem 0.6rem;
    border-bottom: 1px solid var(--line, #e5e7eb);
}
.notif-popup-header-title {
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--muted);
    margin: 0;
    flex: 1;
}
.notif-popup-close {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%; border: none; background: none;
    cursor: pointer; color: var(--muted); font-size: 1rem;
    transition: background 0.12s;
}
.notif-popup-close:hover { background: var(--line, #e5e7eb); color: var(--text); }
.notif-popup-body { padding: 0.75rem 1.25rem 1.25rem; display: flex; flex-direction: column; gap: 0.75rem; }
.notif-item {
    border-radius: var(--radius-lg, 12px);
    padding: 0.85rem 1rem;
    border-left: 4px solid;
}
.notif-item-info    { background: #e0f2fe; border-color: #0ea5e9; }
.notif-item-success { background: #dcfce7; border-color: #22c55e; }
.notif-item-warning { background: #fef3c7; border-color: #f59e0b; }
.notif-item-danger  { background: #fee2e2; border-color: #ef4444; }
.notif-item-judul {
    font-size: 0.88rem;
    font-weight: 800;
    margin-bottom: 0.3rem;
    color: var(--text);
}
.notif-item-pesan {
    font-size: 0.82rem;
    color: #374151;
    white-space: pre-line;
    line-height: 1.55;
}
.notif-popup-footer {
    padding: 0.75rem 1.25rem;
    border-top: 1px solid var(--line, #e5e7eb);
    text-align: right;
}
</style>
<div class="notif-popup-backdrop" id="notifPopup" role="dialog" aria-modal="true" aria-label="Pemberitahuan">
    <div class="notif-popup-dialog">
        <div class="notif-popup-header">
            <span style="font-size:1.1rem;">&#128276;</span>
            <p class="notif-popup-header-title">Pemberitahuan</p>
            <button class="notif-popup-close" id="notifPopupClose" aria-label="Tutup">&#10005;</button>
        </div>
        <div class="notif-popup-body">
            <?php foreach ($pendingNotifs as $pn): ?>
            <?php /** @var array{id:int,judul:string,pesan:string,tipe:string} $pn */ ?>
            <div class="notif-item notif-item-<?= esc($pn['tipe']) ?>">
                <div class="notif-item-judul"><?= esc($pn['judul']) ?></div>
                <div class="notif-item-pesan"><?= esc($pn['pesan']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="notif-popup-footer">
            <button class="btn btn-custom" id="notifPopupOk">&#10003; Mengerti</button>
        </div>
    </div>
</div>
<script>
(function () {
    var popup = document.getElementById('notifPopup');
    function close() {
        popup.style.animation = 'notif-fadein 0.15s ease reverse';
        setTimeout(function () { popup.remove(); }, 150);
    }
    document.getElementById('notifPopupClose').addEventListener('click', close);
    document.getElementById('notifPopupOk').addEventListener('click', close);
    popup.addEventListener('click', function (e) {
        if (e.target === popup) close();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
    });
})();
</script>
<?php endif; endif; endif; ?>

</body>
</html>
