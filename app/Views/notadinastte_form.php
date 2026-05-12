<?php
/** @var array $prefill */
$prefill = $prefill ?? [];
ob_start(); ?>
#formNotaDinas input[type="text"]::placeholder,
#formNotaDinas textarea::placeholder { text-transform: none; }
#formNotaDinas .section-card { padding: 0.7rem 0.9rem; margin-bottom: 0.5rem; }
#formNotaDinas .section-card h5 { font-size: 0.9rem; margin-bottom: 0.3rem; }
#formNotaDinas .section-card .eyebrow { margin-bottom: 0.1rem; }
#formNotaDinas label { font-size: 0.8rem; margin-bottom: 0.12rem; font-weight: 600; }
#formNotaDinas .form-control { padding: 0.3rem 0.55rem; font-size: 0.875rem; }
#formNotaDinas select.form-control { padding: 0.3rem 0.4rem; }
#formNotaDinas .form-text { font-size: 0.72rem; }
#formNotaDinas .row.mt-3 { margin-top: 0.5rem !important; }
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Form Nota Dinas TTE', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Generator Dokumen</div>
                <h1>Nota Dinas TTE</h1>
                <p class="meta">Buat Nota Dinas sebagai surat pendukung Permohonan Penerbitan Sertifikat Elektronik (BSrE).</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <form method="post" action="<?= site_url('surat/proses-notadinas') ?>" id="formNotaDinas">
        <?= csrf_field() ?>
        <?php if (!empty($prefill['log_id'])): ?>
        <input type="hidden" name="log_id" value="<?= (int) $prefill['log_id'] ?>">
        <?php endif; ?>

                <div class="section-card">
                    <span class="eyebrow">Data Nota Dinas</span>
                    <h5>Isi data berikut</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Nomor Surat <span class="text-danger">*</span></label>
                            <input type="text" name="nomor" id="nomor" class="form-control" required placeholder="Contoh: 005/123/KOMINFO/2026" value="<?= esc($prefill['nomor'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Nama Dinas <span class="text-danger">*</span></label>
                            <input type="text" name="dinas" id="dinas" class="form-control" required placeholder="Contoh: DINAS KOMUNIKASI, INFORMATIKA, STATISTIK DAN PERSANDIAN" value="<?= esc($prefill['dinas'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Tanggal <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal" id="tanggal" class="form-control" required placeholder="Contoh: <?= date('d') ?>" value="<?= esc($prefill['tanggal'] ?? '') ?>">
                            <small class="form-text text-muted">Tanggal dalam angka (hari saja).</small>
                        </div>
                        <div class="col-md-6">
                            <label>Bulan <span class="text-danger">*</span></label>
                            <?php
                                $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                $bulanSekarang = ($prefill['bulan'] ?? '') !== '' ? $prefill['bulan'] : $bulanList[(int)date('n') - 1];
                            ?>
                            <select name="bulan" id="bulan" class="form-control" required>
                                <?php foreach ($bulanList as $b): ?>
                                    <option value="<?= $b ?>" <?= $b === $bulanSekarang ? 'selected' : '' ?>><?= $b ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom w-100 mt-2 py-2">
                    Generate dan Unduh Nota Dinas
                </button>

            </form>
</main>

<?= view('_partials/footer') ?>


