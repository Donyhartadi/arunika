<?= view('_partials/head', ['title' => 'Tambah User']) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin</div>
                <h1>Tambah User</h1>
                <p class="meta">Buat akun baru untuk pengguna aplikasi ARUNIKA.</p>
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
            <h4 class="mb-0">Tambah User Baru</h4>
        </div>

        <div class="card-body">

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= esc($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('users/store') ?>">
                <?= csrf_field() ?>

                <div class="section-card">
                    <span class="eyebrow">Data Akun</span>

                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control mb-2" required value="<?= old('username') ?>" autocomplete="off">

                    <label>Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control mb-2" required minlength="6" autocomplete="new-password">
                    <small class="form-text text-muted mb-2">Minimal 6 karakter.</small>

                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control mb-2" required value="<?= old('nama') ?>">

                    <label>Unit Kerja / Nama Bidang</label>
                    <input type="text" name="unit_kerja" class="form-control mb-2" value="<?= old('unit_kerja') ?>">

                    <label>Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="user" selected>User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-custom btn-lg w-100 py-3 mt-3">
                    Simpan User
                </button>

            </form>
        </div>
    </div>
</main>

<?= view('_partials/footer') ?>
