<?= view('_partials/head', ['title' => 'Manajemen User']) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin</div>
                <h1>Manajemen User</h1>
                <p class="meta">Kelola semua akun pengguna aplikasi ARUNIKA.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/users/create">+ Tambah User</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <div class="card">
        <div class="section-card">

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= esc($success) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= esc($error) ?></div>
            <?php endif; ?>

            <div class="table-wrap">
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Unit Kerja</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada user.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= esc($u['username']) ?></td>
                                    <td><?= esc($u['nama']) ?></td>
                                    <td><?= esc($u['unit_kerja'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge <?= $u['role'] === 'admin' ? 'bg-primary' : 'bg-secondary' ?>">
                                            <?= esc($u['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <?php if ((int)$u['id'] !== (int)service('session')->get('user_id')): ?>
                                            <form method="post" action="<?= site_url('users/delete/' . $u['id']) ?>" style="display:inline;" onsubmit="return confirm('Hapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?= view('_partials/footer') ?>
