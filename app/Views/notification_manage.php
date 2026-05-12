<?php ob_start(); ?>
/* Notification manage page */
.notif-card {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.notif-toolbar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 1rem;
    border-bottom: 1px solid var(--line);
    background: rgba(248,246,242,0.8);
}
.notif-toolbar-title { font-size: 0.82rem; font-weight: 700; color: var(--text); margin-right: auto; }
.notif-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.notif-table th {
    padding: 0.55rem 0.9rem;
    text-align: left;
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--muted);
    border-bottom: 1px solid var(--line);
    background: rgba(248,246,242,0.5);
    white-space: nowrap;
}
.notif-table td {
    padding: 0.7rem 0.9rem;
    border-bottom: 1px solid var(--line);
    vertical-align: middle;
}
.notif-table tbody tr:last-child td { border-bottom: none; }
.notif-table tbody tr:hover td { background: rgba(13,148,136,0.03); }
.notif-pesan-preview {
    font-size: 0.78rem;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 380px;
}
.tipe-dot {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.74rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.tipe-info    { color: #0369a1; }
.tipe-success { color: #15803d; }
.tipe-warning { color: #b45309; }
.tipe-danger  { color: #dc2626; }
.status-pill {
    display: inline-block;
    padding: 0.15rem 0.55rem;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 700;
}
.status-aktif   { background: #dcfce7; color: #15803d; }
.status-nonaktif { background: #f1f5f9; color: #94a3b8; }
<?php
$pageStyles = ob_get_clean();
/** @var array<int,array{id:int,judul:string,pesan:string,tipe:string,aktif:int,created_by:string,created_at:string,updated_at:string}> $notifications */
$notifications = $notifications ?? [];
/** @var string|null $success */
/** @var string|null $error */
?>
<?= view('_partials/head', ['title' => 'Kelola Notifikasi', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin &rsaquo; Pengaturan</div>
                <h1>Kelola Notifikasi</h1>
                <p class="meta">Buat dan kelola pemberitahuan yang tampil sebagai popup saat user login.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-custom" href="/notifikasi/create">&#43; Notifikasi Baru</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">

    <?php if (!empty($success)): ?>
        <div class="alert alert-success mb-3"><?= esc($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-3"><?= esc($error) ?></div>
    <?php endif; ?>

    <div class="notif-card">
        <div class="notif-toolbar">
            <span class="notif-toolbar-title">&#128276; Daftar Notifikasi</span>
            <span style="font-size:0.75rem;color:var(--muted);"><?= count($notifications) ?> notifikasi</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="notif-table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pesan</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Dibuat oleh</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($notifications)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--muted);">
                            Belum ada notifikasi. <a href="/notifikasi/create">Buat sekarang</a>.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($notifications as $n): ?>
                    <?php /** @var array{id:int,judul:string,pesan:string,tipe:string,aktif:int,created_by:string,created_at:string} $n */ ?>
                    <tr>
                        <td style="font-weight:600;"><?= esc($n['judul']) ?></td>
                        <td><div class="notif-pesan-preview" title="<?= esc($n['pesan']) ?>"><?= esc($n['pesan']) ?></div></td>
                        <td>
                            <span class="tipe-dot tipe-<?= esc($n['tipe']) ?>">
                                <?= match($n['tipe']) {
                                    'info'    => '&#8505; Info',
                                    'success' => '&#10003; Sukses',
                                    'warning' => '&#9888; Peringatan',
                                    'danger'  => '&#9888; Penting',
                                    default   => esc($n['tipe'])
                                } ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-pill <?= $n['aktif'] ? 'status-aktif' : 'status-nonaktif' ?>">
                                <?= $n['aktif'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </td>
                        <td><code style="font-size:0.76rem;"><?= esc($n['created_by']) ?></code></td>
                        <td style="font-size:0.76rem;color:var(--muted);white-space:nowrap;"><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></td>
                        <td>
                            <div style="display:flex;gap:4px;align-items:center;">
                                <a href="/notifikasi/edit/<?= $n['id'] ?>" class="act-btn btn-outline-primary" style="height:26px;padding:0 0.5rem;font-size:0.72rem;display:inline-flex;align-items:center;border-radius:5px;border:1px solid;text-decoration:none;">&#9998; Edit</a>
                                <form method="post" action="/notifikasi/toggle/<?= $n['id'] ?>" style="display:contents;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="act-btn <?= $n['aktif'] ? 'btn-outline-warning' : 'btn-outline-success' ?>" style="height:26px;padding:0 0.5rem;font-size:0.72rem;display:inline-flex;align-items:center;border-radius:5px;border:1px solid;background:none;cursor:pointer;" title="<?= $n['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                        <?= $n['aktif'] ? '&#9646;&#9646; Nonaktifkan' : '&#9654; Aktifkan' ?>
                                    </button>
                                </form>
                                <form method="post" action="/notifikasi/delete/<?= $n['id'] ?>" style="display:contents;" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" style="height:26px;padding:0 0.5rem;font-size:0.72rem;display:inline-flex;align-items:center;border-radius:5px;border:1px solid var(--danger,#dc2626);color:var(--danger,#dc2626);background:none;cursor:pointer;">&#128465;</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?= view('_partials/footer') ?>
