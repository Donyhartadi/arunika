<?php
/** @var list<array<string, string>> $dasar */
/** @var string|null $message */
/** @var string|null $error */
ob_start(); ?>
/* Dasar Surat settings page */
.dasar-card {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.dasar-card-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.7rem 1rem;
    background: rgba(248,246,242,0.8);
    border-bottom: 1px solid var(--line);
}
.dasar-card-title {
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--primary-deep);
    margin: 0;
}

.dasar-row {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--line);
}
.dasar-row:last-child { border-bottom: none; }

.dasar-num {
    width: 28px;
    height: 28px;
    min-width: 28px;
    border-radius: 50%;
    background: var(--primary);
    color: #fff;
    font-size: 0.76rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 0.35rem;
}

.dasar-textarea {
    flex: 1;
    min-width: 0;
    font-size: 0.85rem;
    line-height: 1.55;
    resize: vertical;
    min-height: 80px;
    padding: 0.45rem 0.65rem;
}

.dasar-del-btn {
    width: 30px;
    height: 30px;
    min-width: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 0.25rem;
}

.save-bar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: flex-end;
    margin-top: 1.25rem;
    padding-top: 1rem;
    border-top: 1px solid var(--line);
}
.save-hint {
    flex: 1;
    min-width: 180px;
    font-size: 0.78rem;
    color: var(--muted);
    margin: 0;
}
@media (max-width: 575px) {
    .save-bar { flex-direction: column; align-items: stretch; }
    .save-hint { text-align: center; }
    .save-bar .btn { width: 100%; }
}
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Pengaturan Dasar Surat', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-copy">
            <div class="hero-kicker">Administrasi</div>
            <h1>Pengaturan Dasar Surat</h1>
            <div class="meta">Kelola poin-poin dasar hukum yang dicetak pada setiap Surat Perintah Tugas.</div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">

    <?php if (!empty($message)): ?>
        <div class="alert alert-success mb-3" role="alert"><?= esc((string) $message) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-3" role="alert"><?= esc((string) $error) ?></div>
    <?php endif; ?>

    <form id="save-form" method="post" action="/pengaturan/dasar/update">
        <?= csrf_field() ?>

        <div class="dasar-card mb-3">
            <div class="dasar-card-header">
                <span style="font-size:1rem;">📋</span>
                <h2 class="dasar-card-title">Poin Dasar Hukum</h2>
            </div>

            <?php foreach ($dasar as $row): ?>
            <div class="dasar-row">
                <span class="dasar-num"><?= (int) $row['nomor'] ?></span>
                <textarea
                    name="dasar[<?= (int) $row['id'] ?>]"
                    class="form-control dasar-textarea"
                    rows="3"
                    required><?= esc($row['isi']) ?></textarea>
                <button type="button"
                    class="btn btn-sm btn-danger-solid dasar-del-btn"
                    title="Hapus poin ini"
                    onclick="deleteDasar(<?= (int) $row['id'] ?>)">&#128465;</button>
            </div>
            <?php endforeach; ?>

            <?php if (empty($dasar)): ?>
            <div class="dasar-row" style="color:var(--muted); font-size:0.85rem;">
                Belum ada poin dasar. Tambah poin baru di bawah.
            </div>
            <?php endif; ?>
        </div>
    </form>

    <div class="save-bar">
        <p class="save-hint">Perubahan akan langsung digunakan saat membuat surat baru.</p>
        <form method="post" action="/pengaturan/dasar/add" style="margin:0;">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-primary">&#43; Tambah Poin</button>
        </form>
        <button type="submit" form="save-form" class="btn btn-custom">&#128190; Simpan Perubahan</button>
    </div>

    <script>
    function deleteDasar(id) {
        if (!confirm('Hapus poin dasar ini?')) return;
        var f = document.createElement('form');
        f.method = 'post';
        f.action = '/pengaturan/dasar/delete/' + id;
        var c = document.createElement('input');
        c.type = 'hidden';
        c.name = '<?= csrf_token() ?>';
        c.value = '<?= csrf_hash() ?>';
        f.appendChild(c);
        document.body.appendChild(f);
        f.submit();
    }
    </script>

</main>

<?= view('_partials/footer') ?>
