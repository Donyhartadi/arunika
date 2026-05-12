<?= view('_partials/head', ['title' => 'Login - ARUNIKA', 'bodyClass' => 'auth-page login-page']) ?>

<div class="login-split">

    <!-- Panel Kiri: Branding -->
    <div class="login-brand">
        <div class="login-brand-inner">
            <div class="login-brand-logo">
                <img src="<?= base_url('assets/img/Kabupaten-Muara-Enim.png') ?>" alt="Logo Muara Enim">
            </div>
            <h1 class="login-brand-title">ARUNIKA</h1>
            <p class="login-brand-sub">Automasi Rutinitas Administrasi Kantor</p>
            <div class="login-brand-divider"></div>
            <p class="login-brand-desc">Kelola surat dinas, template dokumen, dan data referensi kepegawaian dalam satu platform terintegrasi.</p>
            <div class="login-brand-dots">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="login-brand-footer">
            Pemerintah Kabupaten Muara Enim &mdash; Dinas Komunikasi dan Informatika Statistik dan Persandian
        </div>
    </div>

    <!-- Panel Kanan: Form -->
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="login-form-header">
                <p class="login-form-eyebrow">Portal Internal</p>
                <h2 class="login-form-title">Selamat Datang</h2>
                <p class="login-form-sub">Masuk menggunakan akun yang telah terdaftar.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="login-alert login-alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?= esc($error) ?>
                </div>
            <?php endif ?>

            <?php if (!empty($message)): ?>
                <div class="login-alert login-alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    <?= esc($message) ?>
                </div>
            <?php endif ?>

            <form action="<?= site_url('login/process') ?>" method="post" class="login-form">
                <?= csrf_field() ?>

                <div class="lf-group">
                    <label class="lf-label" for="username">Username</label>
                    <div class="lf-input-wrap">
                        <svg class="lf-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= old('username') ?>"
                            placeholder="Masukkan username"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="lf-group">
                    <label class="lf-label" for="password">Password</label>
                    <div class="lf-input-wrap">
                        <svg class="lf-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="lf-eye" onclick="togglePassword()" aria-label="Tampilkan password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="lf-submit">
                    <span>Masuk ke Dashboard</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>

            <p class="login-form-copy">&copy; <?= date('Y') ?> ARUNIKA &mdash; Kabupaten Muara Enim</p>
        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    document.getElementById('eyeIcon').style.opacity = isPassword ? '0.4' : '1';
}
</script>

<?= view('_partials/footer') ?>
