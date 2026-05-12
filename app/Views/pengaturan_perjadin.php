<?php ob_start(); ?>
/* Pengaturan page local styles */
.setting-group-card {
    background: var(--surface);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 0;
}
.setting-group-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.7rem 1rem;
    background: rgba(248,246,242,0.8);
    border-bottom: 1px solid var(--line);
}
.setting-group-icon { font-size: 1.05rem; flex-shrink: 0; }
.setting-group-title {
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--primary-deep);
    margin: 0;
    line-height: 1.3;
}
.setting-group-desc {
    font-size: 0.7rem;
    color: var(--muted);
    margin-left: auto;
    text-align: right;
    flex-shrink: 0;
}
@media (max-width: 480px) { .setting-group-desc { display: none; } }

.setting-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.65rem 1rem;
    border-bottom: 1px solid var(--line);
}
.setting-row:last-child { border-bottom: none; }
.setting-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text);
    line-height: 1.3;
}
.setting-sublabel {
    font-size: 0.68rem;
    font-weight: 400;
    color: var(--muted);
    margin-top: 0.1rem;
}
.setting-input-wrap {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    flex-shrink: 0;
}
.setting-prefix {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--muted);
    white-space: nowrap;
}
.setting-input {
    width: 120px;
    text-align: right;
    font-weight: 700;
    font-size: 0.86rem;
    padding: 0.28rem 0.5rem;
}
@media (max-width: 360px) { .setting-input { width: 95px; } }

.updated-badge {
    font-size: 0.62rem;
    color: var(--muted);
    margin-top: 0.15rem;
}
.pagu-30pct {
    font-size: 0.65rem;
    color: var(--muted);
    margin-top: 0.1rem;
}
/* Section divider heading (above pagu cards) */
.section-eyebrow {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 1.5rem 0 0.6rem;
}
.section-eyebrow-line {
    flex: 1;
    height: 1px;
    background: var(--line);
}
.section-eyebrow-text {
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    white-space: nowrap;
}
/* Save bar */
.save-bar {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: flex-end;
    margin-top: 1.5rem;
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
    .save-bar { flex-direction: column; align-items: stretch; gap: 0.5rem; }
    .save-hint { text-align: center; }
    .save-bar .btn { width: 100%; }
}
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Pengaturan Perjalanan Dinas', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-copy">
            <div class="hero-kicker">Administrasi</div>
            <h1>Pengaturan Perjalanan Dinas</h1>
            <div class="meta">Kelola tarif uang harian, harga BBM, dan pagu biaya penginapan yang digunakan pada form Rincian Perjadin.</div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">

    <?php if (!empty($message)): ?>
        <div class="alert alert-success mb-3" role="alert"><?= esc($message) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-3" role="alert"><?= esc($error) ?></div>
    <?php endif; ?>

    <form method="post" action="/pengaturan/perjadin/update">
        <?= csrf_field() ?>

        <!-- BARIS 1: Uang Harian + BBM sejajar, stack di mobile -->
        <div class="row g-3">

            <!-- Uang Harian -->
            <div class="col-12 col-md-6">
                <div class="setting-group-card h-100">
                    <div class="setting-group-header">
                        <span class="setting-group-icon">💰</span>
                        <h2 class="setting-group-title">Uang Harian</h2>
                        <span class="setting-group-desc">per orang / per hari</span>
                    </div>
                    <?php foreach ($uang_harian as $row): ?>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label"><?= esc($row['label']) ?></div>
                            <?php if ($row['updated_at']): ?>
                                <div class="updated-badge">Diperbarui: <?= date('d M Y H:i', strtotime($row['updated_at'])) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="setting-input-wrap">
                            <span class="setting-prefix">Rp</span>
                            <input type="number"
                                   name="nilai[<?= esc($row['kunci']) ?>]"
                                   class="form-control setting-input"
                                   value="<?= esc($row['nilai']) ?>"
                                   min="0" step="1000" required>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Harga BBM -->
            <div class="col-12 col-md-6">
                <div class="setting-group-card h-100">
                    <div class="setting-group-header">
                        <span class="setting-group-icon">⛽</span>
                        <h2 class="setting-group-title">Harga BBM</h2>
                        <span class="setting-group-desc">per liter</span>
                    </div>
                    <?php foreach ($bbm as $row): ?>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label"><?= esc($row['label']) ?></div>
                            <?php if ($row['updated_at']): ?>
                                <div class="updated-badge">Diperbarui: <?= date('d M Y H:i', strtotime($row['updated_at'])) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="setting-input-wrap">
                            <span class="setting-prefix">Rp</span>
                            <input type="number"
                                   name="nilai[<?= esc($row['kunci']) ?>]"
                                   class="form-control setting-input"
                                   value="<?= esc($row['nilai']) ?>"
                                   min="0" step="50" required>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div><!-- /row g-3 -->

        <!-- BARIS 2: Pagu Penginapan — 3 kartu sejajar, stack di mobile -->
        <div class="section-eyebrow">
            <div class="section-eyebrow-line"></div>
            <span class="section-eyebrow-text">🏨 Pagu Biaya Penginapan</span>
            <div class="section-eyebrow-line"></div>
        </div>
        <p class="text-muted" style="font-size:0.78rem; margin-bottom:0.75rem; text-align:center;">
            Batas maksimum biaya penginapan per malam. 30% dari pagu = nilai uang sewa.
        </p>

        <?php
        $pMap = [];
        foreach ($penginapan as $row) { $pMap[$row['kunci']] = $row; }
        $paguKategori = [
            ['label' => 'Dalam Daerah',              'prefix' => 'pagu_dalam_daerah'],
            ['label' => 'Luar Daerah Dlm. Provinsi', 'prefix' => 'pagu_luar_daerah_dalam_provinsi'],
            ['label' => 'Luar Daerah Luar Provinsi', 'prefix' => 'pagu_luar_daerah_luar_provinsi'],
        ];
        $golongan = ['C1', 'C2', 'C3'];
        ?>
        <div class="row g-3">
            <?php foreach ($paguKategori as $kat): ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="setting-group-card">
                    <div class="setting-group-header">
                        <span class="setting-group-icon">🏨</span>
                        <h2 class="setting-group-title"><?= esc($kat['label']) ?></h2>
                    </div>
                    <?php foreach ($golongan as $gol): ?>
                    <?php $kunci = $kat['prefix'] . '_' . $gol; $r = $pMap[$kunci] ?? ['nilai' => 0, 'updated_at' => null]; ?>
                    <div class="setting-row">
                        <div>
                            <div class="setting-label">Golongan <?= esc($gol) ?></div>
                            <?php if ($r['nilai'] > 0): ?>
                                <div class="pagu-30pct">30% = Rp <?= number_format($r['nilai'] * 0.3, 0, ',', '.') ?></div>
                            <?php endif; ?>
                            <?php if (!empty($r['updated_at'])): ?>
                                <div class="updated-badge">Diperbarui: <?= date('d M Y H:i', strtotime($r['updated_at'])) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="setting-input-wrap">
                            <span class="setting-prefix">Rp</span>
                            <input type="number"
                                   name="nilai[<?= esc($kunci) ?>]"
                                   class="form-control setting-input"
                                   value="<?= esc($r['nilai']) ?>"
                                   min="0" step="1000" required>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div><!-- /row pagu -->

        <!-- Tarif Uang Harian Per Provinsi -->
        <div class="section-eyebrow">
            <div class="section-eyebrow-line"></div>
            <span class="section-eyebrow-text">🗺️ Tarif Uang Harian Per Provinsi</span>
            <div class="section-eyebrow-line"></div>
        </div>
        <p class="text-muted" style="font-size:0.78rem; margin-bottom:0.75rem; text-align:center;">
            Tarif luar kota per OH sesuai PMK. Digunakan pada pilihan provinsi tujuan di form Rincian Perjadin.
        </p>

        <div class="setting-group-card">
            <div class="setting-group-header">
                <span class="setting-group-icon">🗺️</span>
                <h2 class="setting-group-title">Tarif Per Provinsi</h2>
                <span class="setting-group-desc">luar kota / OH</span>
            </div>
            <div class="row g-0">
                <?php foreach ($tarif_provinsi as $idx => $row): ?>
                <div class="col-12 col-sm-6 col-md-4" style="border-bottom:1px solid var(--line); <?= $idx % 2 === 1 ? 'border-left:1px solid var(--line);' : '' ?>">
                    <div class="setting-row" style="border-bottom:none;">
                        <div class="setting-label" style="font-size:0.82rem;"><?= esc($row['label']) ?></div>
                        <div class="setting-input-wrap">
                            <span class="setting-prefix">Rp</span>
                            <input type="number"
                                   name="nilai[<?= esc($row['kunci']) ?>]"
                                   class="form-control setting-input"
                                   value="<?= esc($row['nilai']) ?>"
                                   min="0" step="1000" required
                                   style="width:105px;">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Save bar -->
        <div class="save-bar">
            <p class="save-hint">Perubahan langsung berlaku pada form Rincian Perjadin yang dibuka setelah simpan.</p>
            <a href="/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Semua Pengaturan</button>
        </div>

    </form>
</main>

<?= view('_partials/footer') ?>

