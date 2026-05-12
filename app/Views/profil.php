<?php ob_start(); ?>
/* ---- profil page local styles ---- */
.profil-wrap {
    max-width: 960px;
    margin: 0 auto;
}

/* Identity card */
.profil-id-card {
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin-bottom: 1rem;
    border: 1px solid rgba(255,255,255,0.6);
}

.profil-id-banner {
    background: linear-gradient(135deg, rgba(15,118,110,0.95) 0%, rgba(13,148,136,0.88) 55%, rgba(170,115,38,0.78) 100%);
    padding: 1.5rem 1.5rem 3.5rem;
    position: relative;
    overflow: hidden;
}

.profil-id-banner::after {
    content: '';
    position: absolute;
    top: -40%;
    right: -10%;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}

.profil-id-role {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.22rem 0.65rem;
    border-radius: 999px;
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.95);
}

.profil-id-body {
    background: var(--surface);
    padding: 0 1.5rem 1.4rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.profil-avatar-wrap {
    margin-top: -2.4rem;
    flex-shrink: 0;
}

.profil-avatar {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-deep));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.9rem;
    font-weight: 800;
    color: #fff;
    font-family: 'Fraunces', serif;
    border: 3px solid #fff;
    box-shadow: 0 8px 24px rgba(13,148,136,0.28);
}

.profil-id-meta {
    flex: 1;
    min-width: 0;
    padding-top: 0.75rem;
}

.profil-id-name {
    font-size: 1.12rem;
    font-weight: 800;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profil-id-username {
    color: var(--muted);
    font-size: 0.82rem;
    margin-top: 0.1rem;
}

.profil-unit-badge {
    flex-shrink: 0;
    padding: 0.5rem 0.85rem;
    border-radius: var(--radius-md);
    background: var(--accent-soft);
    border: 1px solid rgba(217,119,6,0.14);
    font-size: 0.78rem;
    color: var(--accent);
    font-weight: 700;
    text-align: right;
    line-height: 1.4;
    max-width: 220px;
}

/* Section cards */
.profil-section {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    margin-bottom: 1rem;
    overflow: hidden;
}

.profil-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.35rem;
    border-bottom: 1px solid var(--line);
    background: rgba(248,246,242,0.7);
}

.profil-section-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.profil-section-icon.teal {
    background: rgba(13,148,136,0.1);
    color: var(--primary-deep);
}

.profil-section-icon.amber {
    background: var(--accent-soft);
    color: var(--accent);
}

.profil-section-title {
    font-size: 0.9rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}

.profil-section-desc {
    font-size: 0.78rem;
    color: var(--muted);
    margin: 0;
}

.profil-section-body {
    padding: 1.25rem 1.35rem;
}

/* Password input wrapper with show/hide toggle */
.pwd-wrap {
    position: relative;
}

.pwd-wrap .form-control {
    padding-right: 2.8rem;
}

.pwd-toggle {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--muted);
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    font-size: 1.05rem;
    line-height: 1;
    transition: color 0.15s;
}

.pwd-toggle:hover { color: var(--primary); }

/* Save button row */
.profil-save-row {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Profil Saya', 'pageStyles' => $pageStyles]) ?>
<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Akun</div>
                <h1>Profil Saya</h1>
                <p class="meta">Kelola informasi akun dan keamanan login Anda.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/dashboard">← Dashboard</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <div class="profil-wrap">

        <?php if (!empty($success)): ?>
            <div class="alert alert-success mb-3" role="alert"><?= esc($success) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger mb-3" role="alert"><?= esc($error) ?></div>
        <?php endif; ?>

        <!-- Identity card -->
        <div class="profil-id-card">
            <div class="profil-id-banner">
                <span class="profil-id-role"><?= esc($user['role']) ?></span>
            </div>
            <div class="profil-id-body">
                <div class="profil-avatar-wrap">
                    <div class="profil-avatar"><?= strtoupper(mb_substr($user['nama'] ?? $user['username'], 0, 1)) ?></div>
                </div>
                <div class="profil-id-meta">
                    <div class="profil-id-name"><?= esc($user['nama'] ?? '-') ?></div>
                    <div class="profil-id-username">@<?= esc($user['username']) ?></div>
                </div>
                <?php if (!empty($user['unit_kerja'])): ?>
                <div class="profil-unit-badge"><?= esc($user['unit_kerja']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <form method="post" action="<?= site_url('profil/update') ?>">
            <?= csrf_field() ?>

            <!-- Unit Kerja -->
            <div class="profil-section">
                <div class="profil-section-header">
                    <div class="profil-section-icon teal">🏢</div>
                    <div>
                        <p class="profil-section-title">Unit Kerja</p>
                        <p class="profil-section-desc">Identitas bidang yang muncul pada dokumen</p>
                    </div>
                </div>
                <div class="profil-section-body">
                    <label for="unit_kerja">Nama Bidang / Unit Kerja <span class="text-danger">*</span></label>
                    <input type="text" id="unit_kerja" name="unit_kerja" class="form-control" required
                        value="<?= esc($user['unit_kerja'] ?? '') ?>"
                        placeholder="Contoh: Bidang Persandian dan KI">
                    <small class="form-text mt-1 d-block">Nama ini digunakan sebagai identitas bidang pada semua dokumen yang dibuat.</small>
                </div>
            </div>

            <!-- Password -->
            <div class="profil-section">
                <div class="profil-section-header">
                    <div class="profil-section-icon amber">🔒</div>
                    <div>
                        <p class="profil-section-title">Keamanan Akun</p>
                        <p class="profil-section-desc">Kosongkan semua kolom jika tidak ingin ubah password</p>
                    </div>
                </div>
                <div class="profil-section-body">
                    <div class="mb-3">
                        <label for="password_lama">Password Lama</label>
                        <div class="pwd-wrap">
                            <input type="password" id="password_lama" name="password_lama" class="form-control"
                                autocomplete="current-password" placeholder="Masukkan password saat ini">
                            <button type="button" class="pwd-toggle" onclick="togglePwd('password_lama', this)" aria-label="Tampilkan password">👁</button>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="password_baru">Password Baru</label>
                            <div class="pwd-wrap">
                                <input type="password" id="password_baru" name="password_baru" class="form-control"
                                    minlength="6" autocomplete="new-password" placeholder="Min. 6 karakter">
                                <button type="button" class="pwd-toggle" onclick="togglePwd('password_baru', this)" aria-label="Tampilkan password">👁</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password_konfirmasi">Konfirmasi Password Baru</label>
                            <div class="pwd-wrap">
                                <input type="password" id="password_konfirmasi" name="password_konfirmasi" class="form-control"
                                    minlength="6" autocomplete="new-password" placeholder="Ulangi password baru">
                                <button type="button" class="pwd-toggle" onclick="togglePwd('password_konfirmasi', this)" aria-label="Tampilkan password">👁</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profil-save-row">
                <button type="submit" class="btn btn-custom btn-lg" style="flex:1; padding-top:0.9rem; padding-bottom:0.9rem;">
                    Simpan Perubahan
                </button>
                <a href="/dashboard" class="btn btn-outline-primary btn-lg" style="white-space:nowrap;">Batal</a>
            </div>

        </form>
    </div>
</main>

<script>
function togglePwd(id, btn) {
    var inp = document.getElementById(id);
    var show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.textContent = show ? '🙈' : '👁';
}
</script>

<?= view('_partials/footer') ?>
