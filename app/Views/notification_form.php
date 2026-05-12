<?php ob_start(); ?>
.notif-form-card {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    padding: 1.5rem;
    max-width: 680px;
}
.tipe-options {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.tipe-option input[type="radio"] { display: none; }
.tipe-option label {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    border: 2px solid transparent;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    background: #f1f5f9;
    color: #64748b;
}
.tipe-option input[type="radio"]:checked + label { border-color: currentColor; }
.tipe-option.tipe-info    label { color: #0369a1; background: #e0f2fe; }
.tipe-option.tipe-success label { color: #15803d; background: #dcfce7; }
.tipe-option.tipe-warning label { color: #b45309; background: #fef3c7; }
.tipe-option.tipe-danger  label { color: #dc2626; background: #fee2e2; }
<?php
$pageStyles = ob_get_clean();
/** @var array{id:int,judul:string,pesan:string,tipe:string,aktif:int}|null $notif */
$notif = $notif ?? null;
/** @var string|null $error */
?>
<?= view('_partials/head', ['title' => ($notif ? 'Edit' : 'Buat') . ' Notifikasi', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Admin &rsaquo; Notifikasi</div>
                <h1><?= $notif ? 'Edit Notifikasi' : 'Buat Notifikasi Baru' ?></h1>
                <p class="meta">Notifikasi aktif akan tampil sebagai popup untuk semua pengguna.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/notifikasi">&#8592; Kembali</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-3"><?= esc($error) ?></div>
    <?php endif; ?>

    <div class="notif-form-card">
        <form method="post" action="<?= $notif ? '/notifikasi/update/' . $notif['id'] : '/notifikasi/store' ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul <span style="color:var(--danger)">*</span></label>
                <input type="text" name="judul" class="form-control"
                       value="<?= esc(old('judul', $notif['judul'] ?? '')) ?>"
                       placeholder="Contoh: Pengumuman Penting" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Pesan <span style="color:var(--danger)">*</span></label>
                <textarea name="pesan" class="form-control" rows="5"
                          placeholder="Tulis isi pemberitahuan di sini..." required><?= esc(old('pesan', $notif['pesan'] ?? '')) ?></textarea>
                <div style="font-size:0.75rem;color:var(--muted);margin-top:0.3rem;">Mendukung baris baru. Isi akan ditampilkan apa adanya.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold d-block">Tipe</label>
                <div class="tipe-options">
                    <?php foreach (['info' => '&#8505; Info', 'success' => '&#10003; Sukses', 'warning' => '&#9888; Peringatan', 'danger' => '&#9888; Penting'] as $val => $lbl): ?>
                    <div class="tipe-option tipe-<?= $val ?>">
                        <input type="radio" name="tipe" id="tipe_<?= $val ?>" value="<?= $val ?>"
                               <?= (old('tipe', $notif['tipe'] ?? 'info') === $val) ? 'checked' : '' ?>>
                        <label for="tipe_<?= $val ?>"><?= $lbl ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($notif): ?>
            <div class="mb-4">
                <label class="form-label fw-semibold d-block">Status</label>
                <div style="display:flex;gap:0.75rem;align-items:center;">
                    <label style="display:flex;align-items:center;gap:0.4rem;cursor:pointer;font-size:0.84rem;">
                        <input type="radio" name="aktif" value="1" <?= $notif['aktif'] ? 'checked' : '' ?>>
                        <span>&#9654; Aktif</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:0.4rem;cursor:pointer;font-size:0.84rem;">
                        <input type="radio" name="aktif" value="0" <?= !$notif['aktif'] ? 'checked' : '' ?>>
                        <span>&#9646;&#9646; Nonaktif</span>
                    </label>
                </div>
            </div>
            <?php endif; ?>

            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-custom">&#128190; <?= $notif ? 'Simpan Perubahan' : 'Buat Notifikasi' ?></button>
                <a href="/notifikasi" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</main>

<?= view('_partials/footer') ?>
