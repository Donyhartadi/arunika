<?php ob_start(); ?>
/* User aktif page */
.active-wrap {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.active-toolbar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 1rem;
    border-bottom: 1px solid var(--line);
    background: rgba(248,246,242,0.8);
    flex-wrap: wrap;
}
.active-toolbar-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text);
}
.active-toolbar-count {
    font-size: 0.75rem;
    color: var(--muted);
    margin-right: auto;
}
.refresh-badge {
    font-size: 0.72rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
#refreshCountdown {
    font-weight: 700;
    color: var(--primary-deep);
    min-width: 2ch;
    display: inline-block;
    text-align: right;
}
.active-table-wrap { overflow-x: auto; }
.active-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
}
.active-table th {
    padding: 0.55rem 0.9rem;
    text-align: left;
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--muted);
    border-bottom: 1px solid var(--line);
    white-space: nowrap;
    background: rgba(248,246,242,0.5);
}
.active-table td {
    padding: 0.65rem 0.9rem;
    border-bottom: 1px solid var(--line);
    vertical-align: middle;
    color: var(--text);
}
.active-table tbody tr:last-child td { border-bottom: none; }
.active-table tbody tr:hover td { background: rgba(13,148,136,0.04); }

/* Status dot */
.status-dot {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.76rem;
    font-weight: 600;
    white-space: nowrap;
}
.status-dot::before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}
.status-online::before  { background: #16a34a; box-shadow: 0 0 0 2px rgba(22,163,74,0.25); animation: pulse-dot 1.8s infinite; }
.status-idle::before    { background: #d97706; }
.status-login::before   { background: #94a3b8; }
.status-online  { color: #15803d; }
.status-idle    { color: #b45309; }
.status-login   { color: #64748b; }

@keyframes pulse-dot {
    0%, 100% { box-shadow: 0 0 0 2px rgba(22,163,74,0.25); }
    50%       { box-shadow: 0 0 0 5px rgba(22,163,74,0.08); }
}

.ago-text { font-size: 0.75rem; color: var(--muted); }
.col-unit { max-width: 240px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--muted);
    font-size: 0.84rem;
}
<?php
$pageStyles = ob_get_clean();
/** @var array<int,array{username:string,nama:string,role:string,unit_kerja:string,last_activity:int,status:string}> $active */
$active = $active ?? [];
/** @var string $username */
?>
<?= view('_partials/head', ['title' => 'User Aktif', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin &rsaquo; Pengguna</div>
                <h1>User Aktif</h1>
                <p class="meta">Daftar pengguna yang sedang aktif atau baru saja menggunakan aplikasi.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/users">&#8592; Manajemen User</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">

    <div class="active-wrap">
        <div class="active-toolbar">
            <span class="active-toolbar-title">&#128100; Sesi Login Aktif</span>
            <span class="active-toolbar-count"><?= count($active) ?> pengguna terdeteksi</span>
            <span class="refresh-badge">
                &#8635; Refresh otomatis dalam <span id="refreshCountdown">30</span>s
            </span>
            <a href="/users/active" class="btn btn-outline-primary" style="height:30px;font-size:0.76rem;padding:0 0.7rem;">Refresh Sekarang</a>
        </div>

        <div class="active-table-wrap">
            <table class="active-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="col-unit">Unit / Bidang</th>
                        <th>Terakhir Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($active)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Tidak ada sesi aktif yang terdeteksi saat ini.
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($active as $u): /** @var array{username:string,nama:string,role:string,unit_kerja:string,age_seconds:int,status:string} $u */
                        $age = (int) $u['age_seconds'];
                        if ($age < 300) {
                            $statusClass = 'status-online';
                            $statusLabel = 'Aktif';
                        } elseif ($age < 1800) {
                            $statusClass = 'status-idle';
                            $statusLabel = 'Idle';
                        } else {
                            $statusClass = 'status-login';
                            $statusLabel = 'Login';
                        }

                        if ($age < 60) {
                            $agoText = 'Baru saja';
                        } elseif ($age < 3600) {
                            $agoText = floor($age / 60) . ' menit lalu';
                        } else {
                            $agoText = floor($age / 3600) . ' jam lalu';
                        }
                        $isMe = ($u['username'] === $username);
                    ?>
                    <tr>
                        <td>
                            <span class="status-dot <?= $statusClass ?>"><?= $statusLabel ?></span>
                        </td>
                        <td>
                            <?= esc($u['nama']) ?>
                            <?php if ($isMe): ?>
                                <span class="badge bg-primary" style="font-size:0.6rem;vertical-align:middle;margin-left:4px;">Anda</span>
                            <?php endif; ?>
                        </td>
                        <td><code style="font-size:0.78rem;"><?= esc($u['username']) ?></code></td>
                        <td>
                            <span class="badge <?= $u['role'] === 'admin' ? 'bg-primary' : 'bg-secondary' ?>">
                                <?= esc($u['role']) ?>
                            </span>
                        </td>
                        <td class="col-unit" title="<?= esc($u['unit_kerja']) ?>"><?= esc($u['unit_kerja']) ?></td>
                        <td>
                            <span><?= date('H:i:s', $u['last_active']) ?></span><br>
                            <span class="ago-text"><?= $agoText ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <p style="font-size:0.72rem;color:var(--muted);margin-top:0.75rem;text-align:right;">
        &#9432; Deteksi berdasarkan file sesi aktif (dalam 2 jam terakhir).
        Status: <strong>Aktif</strong> &lt;5 mnt &bull; <strong>Idle</strong> 5&ndash;30 mnt &bull; <strong>Login</strong> &gt;30 mnt.
    </p>

</main>

<script>
(function () {
    var secs = 30;
    var el = document.getElementById('refreshCountdown');
    el.textContent = secs;
    var t = setInterval(function () {
        secs--;
        el.textContent = secs;
        if (secs <= 0) {
            clearInterval(t);
            window.location.reload();
        }
    }, 1000);
})();
</script>

<?= view('_partials/footer') ?>
