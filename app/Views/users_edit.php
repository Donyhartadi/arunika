<?= view('_partials/head', ['title' => 'Edit User']) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin</div>
                <h1>Edit User</h1>
                <p class="meta">Ubah data akun <?= esc($user['username']) ?>.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/users">Kembali</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <div class="card shadow" style="max-width: 600px; margin: 0 auto;">

        <div class="card-header header-gradient text-white">
            <h4 class="mb-0">Edit User: <?= esc($user['username']) ?></h4>
        </div>

        <div class="card-body">

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= esc($success) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= esc($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('users/update/' . $user['id']) ?>">
                <?= csrf_field() ?>

                <div class="section-card">
                    <span class="eyebrow">Data User</span>

                    <label>Username</label>
                    <input type="text" class="form-control mb-2" value="<?= esc($user['username']) ?>" disabled>

                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control mb-2" required value="<?= esc($user['nama']) ?>">

                    <label>Unit Kerja / Nama Bidang</label>
                    <input type="text" name="unit_kerja" class="form-control mb-2" value="<?= esc($user['unit_kerja'] ?? '') ?>">

                    <label>Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="section-card mt-3">
                    <span class="eyebrow">Reset Password</span>
                    <p class="text-small text-muted mb-2">Kosongkan jika tidak ingin mengubah password.</p>

                    <label>Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" minlength="6" autocomplete="new-password">
                    <small class="form-text text-muted">Minimal 6 karakter.</small>
                </div>

                <button type="submit" class="btn btn-custom btn-lg w-100 py-3 mt-3">
                    Simpan Perubahan
                </button>

            </form>
        </div>
    </div>
</main>

<?= view('_partials/footer') ?>
