<?php
/** @var list<array<string, string>> $logs */
/** @var string $jenis */
/** @var string $search */
/** @var string $role */
/** @var string $username */
/** @var int    $page */
/** @var int    $totalPages */
/** @var int    $total */
/** @var int    $perPage */
ob_start(); ?>
/* ── Full-width history layout ───────────────────────── */
.history-wrap {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 180px);
    background: var(--surface, #fff);
    border: 1px solid var(--line, #e5e7eb);
    border-radius: var(--radius-xl, 16px);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

/* Toolbar */
.history-toolbar {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--line, #e5e7eb);
    background: var(--surface, #fff);
    flex-shrink: 0;
    flex-wrap: wrap;
}
.history-toolbar .ht-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    white-space: nowrap;
}
.history-toolbar .ht-count {
    font-size: 0.75rem;
    color: var(--muted, #888);
    white-space: nowrap;
    margin-right: auto;
}
.history-toolbar .search-wrap {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 320px;
}
.history-toolbar .search-wrap input {
    padding-left: 2rem;
    height: 32px;
    font-size: 0.8rem;
}
.history-toolbar .search-icon {
    position: absolute;
    left: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    font-size: 0.8rem;
    pointer-events: none;
}
.history-toolbar select {
    height: 32px;
    font-size: 0.8rem;
    padding: 0 0.5rem;
    border: 1px solid var(--line, #e5e7eb);
    border-radius: var(--radius-md, 8px);
    background: var(--surface);
    color: var(--text);
    cursor: pointer;
}
.history-toolbar .btn { height: 32px; font-size: 0.78rem; padding: 0 0.75rem; white-space: nowrap; }

/* Bulk bar */
.bulk-bar {
    display: none;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 1rem;
    background: rgba(220,38,38,0.06);
    border-bottom: 1px solid rgba(220,38,38,0.15);
    flex-shrink: 0;
    flex-wrap: wrap;
}
.bulk-bar.visible { display: flex; }
.bulk-bar-count { font-size: 0.82rem; font-weight: 700; color: var(--danger, #dc2626); flex: 1; }
.btn-danger-solid { background: var(--danger, #dc2626); color: #fff; border-color: var(--danger, #dc2626); }
.btn-danger-solid:hover { background: #b91c1c; border-color: #b91c1c; color: #fff; }

/* Scrollable table area */
.history-table-wrap {
    flex: 1;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
}

/* Table */
#historyTable {
    width: 100%;
    font-size: 0.8rem;
    border-collapse: collapse;
    white-space: nowrap;
}
#historyTable th {
    position: sticky;
    top: 0;
    z-index: 2;
    background: var(--surface-alt, #f8f7f3);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted, #888);
    padding: 0.6rem 0.85rem;
    border-bottom: 2px solid var(--line, #e5e7eb);
    white-space: nowrap;
    font-weight: 600;
}
#historyTable td {
    padding: 0.5rem 0.85rem;
    border-bottom: 1px solid var(--line, #f3f4f6);
    vertical-align: middle;
    color: var(--text);
}
#historyTable tbody tr:hover td {
    background: rgba(15,118,110,0.03);
}
#historyTable tbody tr:last-child td { border-bottom: none; }

/* Checkbox */
.cb-col { width: 36px; text-align: center; }
input[type="checkbox"] { width: 15px; height: 15px; cursor: pointer; accent-color: var(--primary); }

/* Column widths */
#historyTable .col-tgl      { width: 140px; }
#historyTable .col-jenis    { width: 130px; }
#historyTable .col-nama     { max-width: 170px; overflow: hidden; text-overflow: ellipsis; }
#historyTable .col-keperluan{ max-width: 220px; overflow: hidden; text-overflow: ellipsis; color: var(--muted); font-size:0.78rem; }
#historyTable .col-bidang   { max-width: 130px; overflow: hidden; text-overflow: ellipsis; color: var(--muted); font-size:0.78rem; }
#historyTable .col-user     { width: 100px; color: var(--muted); font-size:0.78rem; }
#historyTable .col-aksi     { width: 1px; }

/* Rincian badge */
.badge-rincian {
    font-size: 0.6rem;
    font-weight: 600;
    color: #16a34a;
    background: rgba(22,163,74,0.1);
    border: 1px solid rgba(22,163,74,0.28);
    border-radius: 20px;
    padding: 0.07rem 0.35rem;
    margin-left: 0.25rem;
    vertical-align: middle;
    white-space: nowrap;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    transition: opacity 0.15s;
}
a.badge-rincian:hover {
    opacity: 0.75;
    text-decoration: none;
}

/* Action buttons */
.act-group {
    display: flex;
    align-items: center;
    gap: 3px;
    flex-wrap: nowrap;
}
.act-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    height: 26px;
    padding: 0 0.45rem;
    font-size: 0.72rem;
    font-weight: 500;
    border-radius: 5px;
    border: 1px solid;
    cursor: pointer;
    background: none;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.12s, color 0.12s;
    flex-shrink: 0;
    line-height: 1;
}
.act-sep {
    display: inline-block;
    width: 1px;
    height: 14px;
    background: var(--line, #e5e7eb);
    margin: 0 2px;
    flex-shrink: 0;
}

/* Dropdown menu */
.act-drop { position: relative; }
.act-drop-menu {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 3px);
    background: var(--surface, #fff);
    border: 1px solid var(--line, #e5e7eb);
    border-radius: 7px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.13);
    min-width: 170px;
    z-index: 500;
    overflow: hidden;
    padding: 3px 0;
}
.act-drop.open .act-drop-menu { display: block; }
.act-drop-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.42rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--text);
    text-decoration: none;
    background: none;
    border: none;
    width: 100%;
    cursor: pointer;
    text-align: left;
    white-space: nowrap;
    transition: background 0.1s;
}
.act-drop-item:hover { background: var(--surface-alt, #f3f4f6); }
.act-drop-item.danger { color: var(--danger, #dc2626); }
.act-drop-item.danger:hover { background: #fef2f2; }
.act-drop-divider {
    height: 1px;
    background: var(--line, #e5e7eb);
    margin: 3px 0;
}

/* Pagination */
.history-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-top: 1px solid var(--line, #e5e7eb);
    background: var(--surface, #fff);
    flex-shrink: 0;
    flex-wrap: wrap;
}
.history-footer .pg-info { font-size: 0.75rem; color: var(--muted); }
.pg-btns { display: flex; gap: 3px; flex-wrap: wrap; align-items: center; }
.pg-btns a, .pg-btns span {
    display: inline-flex; align-items: center; justify-content: center;
    height: 28px; min-width: 28px; padding: 0 6px;
    font-size: 0.75rem; border-radius: 5px; text-decoration: none;
    border: 1px solid var(--line, #e5e7eb);
    color: var(--text); background: var(--surface);
    transition: background 0.1s;
}
.pg-btns a:hover { background: var(--surface-alt, #f3f4f6); }
.pg-btns .active { background: var(--primary, #0f766e); color: #fff; border-color: var(--primary, #0f766e); }
.pg-btns .dots { border: none; background: none; color: var(--muted); pointer-events: none; }

/* Preview modal */
.preview-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.7); z-index: 9999;
    align-items: center; justify-content: center;
}
.preview-backdrop.open { display: flex; }
.preview-dialog {
    display: flex; flex-direction: column;
    width: 96vw; max-width: 980px; height: 93vh;
    border-radius: 4px; overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.7);
    transition: max-width 0.2s;
}
.preview-dialog.landscape { max-width: 1240px; }
.preview-titlebar {
    display: flex; align-items: center; background: #2b579a;
    height: 32px; padding: 0 0.4rem 0 0.75rem; gap: 0.4rem; flex-shrink: 0;
}
.preview-titlebar-icon { color: #fff; font-size: 1rem; flex-shrink: 0; }
.preview-titlebar-name {
    color: #fff; font-size: 0.78rem; font-weight: 600; flex: 1;
    text-align: center; white-space: nowrap; overflow: hidden;
    text-overflow: ellipsis; letter-spacing: 0.01em;
}
.preview-winctr {
    width: 30px; height: 32px; background: none; border: none;
    color: rgba(255,255,255,0.85); font-size: 0.8rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: background 0.1s;
}
.preview-winctr:hover { background: rgba(255,255,255,0.2); color: #fff; }
.preview-winctr.wc-close:hover { background: #c42b1c; color: #fff; }
.preview-ribbon {
    background: #f0f0f0; border-bottom: 1px solid #c8c8c8;
    padding: 0.3rem 1rem; display: flex; align-items: center;
    gap: 0.75rem; flex-shrink: 0;
}
.preview-ribbon-label { font-size: 0.72rem; color: #666; margin-left: auto; font-style: italic; }
.preview-page-wrap { background: #808080; flex: 1; overflow-y: auto; overflow-x: hidden; padding: 1.25rem 1rem 2rem; }
.preview-page {
    background: #fff; width: 21cm; min-height: 29.7cm; margin: 0 auto;
    padding: 2.54cm 3.17cm;
    transform-origin: top center;
}
.preview-page.landscape {
    width: 29.7cm; min-height: 21cm;
    padding: 1.5cm 2cm;
    box-shadow: 0 1px 3px rgba(0,0,0,.25), 0 6px 20px rgba(0,0,0,.3);
    font-family: 'Times New Roman', Times, serif; font-size: 12pt;
    line-height: 1.5; color: #000; box-sizing: border-box; word-wrap: break-word;
}
.preview-page p   { margin: 0; }
.preview-page h1  { font-size: 16pt; font-weight: bold; margin: 12pt 0 3pt; }
.preview-page h2  { font-size: 14pt; font-weight: bold; margin: 10pt 0 3pt; }
.preview-page h3  { font-size: 13pt; font-weight: bold; margin: 8pt 0 3pt; }
.preview-page table { border-collapse: collapse; width: 100%; margin: 4pt 0 8pt; font-size: 11pt; }
.preview-page td, .preview-page th { border: 1px solid #000; padding: 3pt 5.4pt; vertical-align: top; }
.preview-page ul, .preview-page ol { padding-left: 1.5em; margin: 2pt 0; }
.preview-page img { max-width: 100%; height: auto; display: block; }
.preview-statusbar {
    background: #2b579a; color: rgba(255,255,255,0.82); font-size: 0.68rem;
    padding: 0.18rem 1rem; display: flex; gap: 1.5rem; flex-shrink: 0;
}
.preview-loading { text-align: center; color: #e0e0e0; padding: 4rem 0; font-size: 0.9rem; }
.preview-error { color: #fca5a5; text-align: center; padding: 3rem 0; font-size: 0.85rem; }
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Riwayat Surat', 'pageStyles' => $pageStyles]) ?>
<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="page-title">
            <div>
                <div class="hero-kicker">Aktivitas</div>
                <h1>Riwayat Surat</h1>
                <p>Daftar surat yang pernah di-generate, tersusun dari aktivitas terbaru.</p>
            </div>
            <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success mb-3"><?= esc((string) session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mb-3"><?= esc((string) session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="history-wrap">

        <!-- Toolbar -->
        <form method="get" action="<?= site_url('surat/history') ?>" class="history-toolbar" id="filterForm">
            <span class="ht-title">Riwayat Generate Surat</span>
            <span class="ht-count">
                <?php if ($total > 0): ?>
                    <?= (($page-1)*$perPage)+1 ?>&ndash;<?= min($page*$perPage,$total) ?> / <?= $total ?> entri
                <?php else: ?>
                    Belum ada riwayat
                <?php endif; ?>
            </span>
            <div class="search-wrap">
                <span class="search-icon">&#128269;</span>
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NIP, user&hellip;" value="<?= esc($search) ?>">
            </div>
            <select name="jenis" onchange="this.form.submit()">
                <option value="semua"            <?= $jenis==='semua'            ? 'selected':'' ?>>Semua Jenis</option>
                <option value="Surat Dinas"      <?= $jenis==='Surat Dinas'      ? 'selected':'' ?>>SPT &amp; SPD</option>
                <option value="Permohonan TTE"   <?= $jenis==='Permohonan TTE'   ? 'selected':'' ?>>Permohonan TTE</option>
                <option value="Nota Dinas TTE"   <?= $jenis==='Nota Dinas TTE'   ? 'selected':'' ?>>Nota Dinas TTE</option>
                <option value="Rincian Perjadin" <?= $jenis==='Rincian Perjadin' ? 'selected':'' ?>>Rincian Perjadin</option>
            </select>
            <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
            <?php if ($search!=='' || $jenis!=='semua'): ?>
                <a href="<?= site_url('surat/history') ?>" class="btn btn-outline-primary btn-sm">&#10005; Reset</a>
            <?php endif; ?>
        </form>

        <?php if ($role === 'admin'): ?>
        <div class="bulk-bar" id="bulkBar">
            <span class="bulk-bar-count" id="bulkCount">0 dipilih</span>
            <form method="post" action="<?= site_url('surat/history/delete-bulk') ?>" id="bulkForm" onsubmit="return confirmBulkDelete()">
                <?= csrf_field() ?>
                <div id="bulkInputs"></div>
                <button type="submit" class="btn btn-sm btn-danger-solid">&#128465; Hapus yang Dipilih</button>
            </form>
            <button class="btn btn-sm btn-outline-primary" onclick="clearAll()">Batal pilih</button>
        </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="history-table-wrap">
            <table id="historyTable">
                <thead>
                    <tr>
                        <?php if ($role === 'admin'): ?>
                        <th class="cb-col"><input type="checkbox" id="checkAll" title="Pilih semua"></th>
                        <?php endif; ?>
                        <th class="col-tgl">Tanggal</th>
                        <th class="col-jenis">Jenis</th>
                        <th class="col-nama">Nama</th>
                        <th class="col-keperluan">Keperluan</th>
                        <th class="col-aksi">Aksi</th>
                        <th class="col-bidang">Bidang</th>
                        <th class="col-user">User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="<?= $role==='admin' ? 8 : 7 ?>" style="text-align:center; padding:3rem; color:var(--muted);">
                                Belum ada riwayat<?= $search!=='' ? ' yang cocok dengan pencarian.' : '.' ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <?php
                                $jenisLog   = $log['jenis_surat'] ?? 'Surat Dinas';
                                $badgeClass = match($jenisLog) {
                                    'Permohonan TTE'   => 'bg-info text-dark',
                                    'Nota Dinas TTE'   => 'bg-warning text-dark',
                                    'Rincian Perjadin' => 'bg-success text-white',
                                    default            => 'bg-primary',
                                };
                                $jenisLabel = ($jenisLog === 'Surat Dinas') ? 'SPT & SPD' : $jenisLog;
                                $hasRincian = ($jenisLog === 'Surat Dinas') && !empty($log['rincian_filename']);
                                $hasKwitansi = ($jenisLog === 'Surat Dinas') && !empty($log['kwitansi_filename']);
                                $hasNotaDinas = ($jenisLog === 'Permohonan TTE') && !empty($log['notadinas_filename']);
                            ?>
                            <tr>
                                <?php if ($role === 'admin'): ?>
                                <td class="cb-col"><input type="checkbox" class="row-cb" value="<?= $log['id'] ?>"></td>
                                <?php endif; ?>
                                <td class="col-tgl"><?= esc($log['created_at']) ?></td>
                                <td class="col-jenis">
                                    <a class="badge <?= $badgeClass ?>" href="<?= site_url('surat/download/' . esc($log['filename'])) ?>" title="Unduh <?= esc($jenisLabel) ?>" style="text-decoration:none;"><?= esc($jenisLabel) ?></a>
                                    <?php if ($hasRincian): ?><a class="badge-rincian" href="<?= site_url('surat/download/' . esc($log['rincian_filename'])) ?>" title="Unduh Rincian">&#8659; Rincian</a><?php endif; ?>
                                    <?php if ($hasKwitansi): ?><a class="badge-rincian" href="<?= site_url('surat/download/' . esc($log['kwitansi_filename'])) ?>" title="Unduh Kwitansi" style="color:#b45309;background:rgba(180,83,9,0.1);border-color:rgba(180,83,9,0.28);">&#8659; Kwitansi</a><?php endif; ?>
                                    <?php if ($hasNotaDinas): ?><a class="badge-rincian" href="<?= site_url('surat/download/' . esc($log['notadinas_filename'])) ?>" title="Unduh Nota Dinas" style="color:#7c3aed;background:rgba(124,58,237,0.1);border-color:rgba(124,58,237,0.28);">&#8659; Nota Dinas</a><?php endif; ?>
                                </td>
                                <td class="col-nama" title="<?= esc($log['nama']) ?>"><?= esc($log['nama']) ?></td>
                                <td class="col-keperluan" title="<?= esc($log['perihal'] ?? '-') ?>"><?= esc($log['perihal'] ?? '-') ?></td>
                                <td class="col-aksi">
                                    <div class="act-group">
                                        <!-- Primary: Download -->
                                        <a class="act-btn btn-outline-primary"
                                           href="<?= site_url('surat/download/' . esc($log['filename'])) ?>"
                                           title="Unduh Dokumen">&#8659; Unduh</a>

                                        <!-- More actions dropdown -->
                                        <div class="act-drop">
                                            <button class="act-btn btn-outline-secondary act-drop-toggle" title="Aksi lainnya">&#8942;</button>
                                            <div class="act-drop-menu">
                                                <!-- Preview utama -->
                                                <button class="act-drop-item btn-preview"
                                                        data-filename="<?= esc($log['filename']) ?>"
                                                        data-label="<?= esc($jenisLabel) ?> &ndash; <?= esc($log['nama']) ?>">
                                                    &#128065; Pratinjau Dokumen
                                                </button>

                                                <?php if ($jenisLog === 'Permohonan TTE'): ?>
                                                <div class="act-drop-divider"></div>
                                                <?php if ($hasNotaDinas): ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/download/' . esc($log['notadinas_filename'])) ?>">
                                                    &#8659; Unduh Nota Dinas
                                                </a>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/notadinas-dari-permohonan/' . $log['id']) ?>">
                                                    &#8635; Buat Ulang Nota Dinas
                                                </a>
                                                <?php else: ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/notadinas-dari-permohonan/' . $log['id']) ?>">
                                                    &#43; Buat Nota Dinas
                                                </a>
                                                <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if ($jenisLog === 'Surat Dinas'): ?>
                                                <div class="act-drop-divider"></div>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/edit/' . esc($log['id'])) ?>">
                                                    &#9997; Edit Surat
                                                </a>
                                                <?php endif; ?>

                                                <?php if ($hasRincian): ?>
                                                <div class="act-drop-divider"></div>
                                                <!-- Download rincian -->
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/download/' . esc($log['rincian_filename'])) ?>">
                                                    &#8659; Unduh Rincian
                                                </a>
                                                <!-- Preview rincian -->
                                                <button class="act-drop-item btn-preview"
                                                        data-filename="<?= esc($log['rincian_filename']) ?>"
                                                        data-label="Rincian &ndash; <?= esc($log['nama']) ?>">
                                                    &#128065; Pratinjau Rincian
                                                </button>
                                                <?php endif; ?>

                                                <?php if ($jenisLog === 'Surat Dinas'): ?>
                                                <div class="act-drop-divider"></div>
                                                <?php if ($hasRincian): ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/rincianperjadin/' . esc($log['id'])) ?>">
                                                    &#8635; Buat Ulang Rincian
                                                </a>
                                                <?php else: ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/rincianperjadin/' . esc($log['id'])) ?>">
                                                    &#43; Buat Rincian
                                                </a>
                                                <?php endif; ?>
                                                <div class="act-drop-divider"></div>
                                                <?php if ($hasKwitansi): ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/download/' . esc($log['kwitansi_filename'])) ?>">
                                                    &#8659; Unduh Kwitansi
                                                </a>
                                                <button class="act-drop-item btn-preview"
                                                        data-filename="<?= esc($log['kwitansi_filename']) ?>"
                                                        data-label="Kwitansi &ndash; <?= esc($log['nama']) ?>">
                                                    &#128065; Pratinjau Kwitansi
                                                </button>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/kwitansi/' . esc($log['id'])) ?>">
                                                    &#8635; Buat Ulang Kwitansi
                                                </a>
                                                <?php else: ?>
                                                <a class="act-drop-item"
                                                   href="<?= site_url('surat/kwitansi/' . esc($log['id'])) ?>">
                                                    &#43; Buat Kwitansi
                                                </a>
                                                <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if ($role === 'admin'): ?>
                                                <div class="act-drop-divider"></div>
                                                <?php if ($hasNotaDinas): ?>
                                                <form method="post" action="<?= site_url('surat/history/delete-notadinas/' . $log['id']) ?>"
                                                      style="display:contents;" onsubmit="return confirm('Hapus file nota dinas ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="act-drop-item danger">&#128465; Hapus Nota Dinas</button>
                                                </form>
                                                <?php endif; ?>
                                                <?php if ($hasKwitansi): ?>
                                                <form method="post" action="<?= site_url('surat/history/delete-kwitansi/' . $log['id']) ?>"
                                                      style="display:contents;" onsubmit="return confirm('Hapus file kwitansi ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="act-drop-item danger">&#128465; Hapus Kwitansi</button>
                                                </form>
                                                <?php endif; ?>
                                                <?php if ($hasRincian): ?>
                                                <form method="post" action="<?= site_url('surat/history/delete-rincian/' . $log['id']) ?>"
                                                      style="display:contents;" onsubmit="return confirm('Hapus file rincian ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="act-drop-item danger">&#128465; Hapus Rincian</button>
                                                </form>
                                                <?php endif; ?>
                                                <form method="post" action="<?= site_url('surat/history/delete/' . $log['id']) ?>"
                                                      style="display:contents;" onsubmit="return confirm('Hapus riwayat ini? File dokumen juga akan ikut dihapus.')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="act-drop-item danger">&#128465; Hapus Riwayat</button>
                                                </form>
                                                <?php elseif ($log['user'] === $username): ?>
                                                <div class="act-drop-divider"></div>
                                                <form method="post" action="<?= site_url('surat/history/delete/' . $log['id']) ?>"
                                                      style="display:contents;" onsubmit="return confirm('Hapus riwayat ini? File dokumen juga akan ikut dihapus.')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="act-drop-item danger">&#128465; Hapus Riwayat</button>
                                                </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-bidang" title="<?= esc($log['unit_kerja'] ?? '-') ?>"><?= esc($log['unit_kerja'] ?? '-') ?></td>
                                <td class="col-user"><?= esc($log['user']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="history-footer">
            <span class="pg-info">Halaman <?= $page ?> dari <?= $totalPages ?></span>
            <div class="pg-btns">
                <?php
                    $baseUrl = site_url('surat/history').'?jenis='.urlencode($jenis).'&search='.urlencode($search).'&page=';
                    $start = max(1, $page-2); $end = min($totalPages, $page+2);
                ?>
                <?php if ($page>1): ?><a href="<?= $baseUrl.($page-1) ?>">&lsaquo;</a><?php endif; ?>
                <?php if ($start>1): ?>
                    <a href="<?= $baseUrl.(1) ?>">1</a>
                    <?php if ($start>2): ?><span class="dots">&hellip;</span><?php endif; ?>
                <?php endif; ?>
                <?php for ($i=$start; $i<=$end; $i++): ?>
                    <a href="<?= $baseUrl.$i ?>" class="<?= $i===$page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($end<$totalPages): ?>
                    <?php if ($end<$totalPages-1): ?><span class="dots">&hellip;</span><?php endif; ?>
                    <a href="<?= $baseUrl.$totalPages ?>"><?= $totalPages ?></a>
                <?php endif; ?>
                <?php if ($page<$totalPages): ?><a href="<?= $baseUrl.($page+1) ?>">&rsaquo;</a><?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="history-footer"><span class="pg-info">Halaman 1 dari 1</span></div>
        <?php endif; ?>

    </div>
</main>

<?php if ($role === 'admin'): ?>
<script>
var checkAll   = document.getElementById('checkAll');
var bulkBar    = document.getElementById('bulkBar');
var bulkCount  = document.getElementById('bulkCount');
var bulkInputs = document.getElementById('bulkInputs');

function getChecked() {
    return Array.from(document.querySelectorAll('.row-cb:checked'));
}

function syncBulkBar() {
    var checked = getChecked();
    if (checked.length > 0) {
        bulkBar.classList.add('visible');
        bulkCount.textContent = checked.length + ' baris dipilih';
        bulkInputs.innerHTML = checked.map(function(cb) {
            return '<input type="hidden" name="ids[]" value="' + cb.value + '">';
        }).join('');
    } else {
        bulkBar.classList.remove('visible');
        bulkInputs.innerHTML = '';
    }
}

checkAll.addEventListener('change', function() {
    document.querySelectorAll('.row-cb').forEach(function(cb) {
        cb.checked = checkAll.checked;
    });
    syncBulkBar();
});

document.querySelectorAll('.row-cb').forEach(function(cb) {
    cb.addEventListener('change', function() {
        var all = document.querySelectorAll('.row-cb');
        var chk = getChecked();
        checkAll.indeterminate = chk.length > 0 && chk.length < all.length;
        checkAll.checked = chk.length === all.length && all.length > 0;
        syncBulkBar();
    });
});

function clearAll() {
    document.querySelectorAll('.row-cb').forEach(function(cb) { cb.checked = false; });
    checkAll.checked = false;
    checkAll.indeterminate = false;
    syncBulkBar();
}

function confirmBulkDelete() {
    var n = getChecked().length;
    return confirm(n + ' riwayat akan dihapus permanen beserta file dokumennya. Lanjutkan?');
}
</script>
<?php endif; ?>

<?= view('_partials/footer') ?>

<!-- ── Word-like Preview Modal ───────────────────────── -->
<div class="preview-backdrop" id="previewBackdrop" role="dialog" aria-modal="true" aria-label="Pratinjau Surat">
    <div class="preview-dialog">

        <!-- Title bar – Word blue -->
        <div class="preview-titlebar">
            <span class="preview-titlebar-icon">&#128196;</span>
            <span class="preview-titlebar-name" id="previewTitle">Dokumen &mdash; Microsoft Word</span>
            <button class="preview-winctr wc-close" id="closePreview" title="Tutup (Esc)">&#10005;</button>
        </div>

        <!-- Ribbon -->
        <div class="preview-ribbon">
            <a id="previewDownloadBtn" href="#" class="btn btn-sm btn-outline-primary"
               style="font-size:0.75rem; white-space:nowrap;" download>&#8659; Unduh Dokumen</a>
            <span class="preview-ribbon-label">Mode Pratinjau &mdash; Baca Saja</span>
        </div>

        <!-- Page canvas -->
        <div class="preview-page-wrap" id="previewPageWrap">
            <div class="preview-loading" id="previewLoading">Memuat dokumen&hellip;</div>
            <div class="preview-error" id="previewError" style="display:none;"></div>
            <div class="preview-page" id="previewPage" style="display:none;"></div>
        </div>

        <!-- Status bar -->
        <div class="preview-statusbar">
            <span id="previewPageInfo">Halaman 1</span>
            <span>Pratinjau &mdash; Baca Saja</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mammoth@1/mammoth.browser.min.js"></script>
<script>
(function () {
    var backdrop  = document.getElementById('previewBackdrop');
    var dialog    = backdrop.querySelector('.preview-dialog');
    var pageWrap  = document.getElementById('previewPageWrap');
    var page      = document.getElementById('previewPage');
    var loading   = document.getElementById('previewLoading');
    var errorEl   = document.getElementById('previewError');
    var titleEl   = document.getElementById('previewTitle');
    var dlBtn     = document.getElementById('previewDownloadBtn');
    var closeBtn  = document.getElementById('closePreview');
    var pageInfo  = document.getElementById('previewPageInfo');
    var baseServe = '<?= site_url('surat/serve') ?>/';
    var baseDl    = '<?= site_url('surat/download') ?>/';

    function openPreview(filename, label) {
        titleEl.textContent = (label ? label + ' \u2014 ' : '') + 'Microsoft Word';
        dlBtn.href = baseDl + encodeURIComponent(filename);
        dlBtn.setAttribute('download', filename);

        // Rincian dokumen ditampilkan landscape
        var isLandscape = /rincian/i.test(filename);
        page.classList.toggle('landscape', isLandscape);
        dialog.classList.toggle('landscape', isLandscape);
        page.style.transform = '';
        page.style.marginBottom = '';

        page.style.display    = 'none';
        errorEl.style.display = 'none';
        loading.style.display = 'block';
        page.innerHTML        = '';
        pageInfo.textContent  = 'Memuat\u2026';

        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';

        fetch(baseServe + encodeURIComponent(filename))
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.arrayBuffer();
            })
            .then(function (buf) {
                return mammoth.convertToHtml(
                    { arrayBuffer: buf },
                    {
                        styleMap: [
                            "p[style-name='Heading 1'] => h1:fresh",
                            "p[style-name='Heading 2'] => h2:fresh",
                            "p[style-name='Heading 3'] => h3:fresh"
                        ],
                        convertImage: mammoth.images.inline(function (el) {
                            return el.read('base64').then(function (b64) {
                                return { src: 'data:' + el.contentType + ';base64,' + b64 };
                            });
                        })
                    }
                );
            })
            .then(function (result) {
                loading.style.display = 'none';
                page.innerHTML = result.value ||
                    '<p style="color:#999; text-align:center; padding:2rem 0;">Dokumen kosong atau tidak dapat ditampilkan.</p>';
                page.style.display = 'block';
                pageWrap.scrollTop = 0;
                pageInfo.textContent = 'Halaman 1';
                // Scale to fit wrap width
                requestAnimationFrame(function () {
                    page.style.transform = '';
                    page.style.marginBottom = '';
                    var available = pageWrap.clientWidth - 32; // 16px padding each side
                    var natural   = page.scrollWidth;
                    if (natural > available) {
                        var scale = available / natural;
                        page.style.transform = 'scale(' + scale + ')';
                        page.style.marginBottom = '-' + (page.offsetHeight * (1 - scale)) + 'px';
                    }
                });
            })
            .catch(function (err) {
                loading.style.display = 'none';
                errorEl.textContent   = 'Gagal memuat pratinjau: ' + err.message;
                errorEl.style.display = 'block';
                pageInfo.textContent  = '';
            });
    }

    function closePreview() {
        backdrop.classList.remove('open');
        document.body.style.overflow = '';
        page.innerHTML = '';
    }

    document.addEventListener('click', function (e) {
        // Preview
        var btn = e.target.closest('.btn-preview');
        if (btn) {
            // close any open dropdown first
            document.querySelectorAll('.act-drop.open').forEach(function(d){ d.classList.remove('open'); });
            openPreview(btn.dataset.filename, btn.dataset.label);
            return;
        }
        // Dropdown toggle
        var tog = e.target.closest('.act-drop-toggle');
        if (tog) {
            var drop = tog.closest('.act-drop');
            var wasOpen = drop.classList.contains('open');
            document.querySelectorAll('.act-drop.open').forEach(function(d){ d.classList.remove('open'); });
            if (!wasOpen) drop.classList.add('open');
            return;
        }
        // Click outside closes dropdowns
        if (!e.target.closest('.act-drop')) {
            document.querySelectorAll('.act-drop.open').forEach(function(d){ d.classList.remove('open'); });
        }
    });

    closeBtn.addEventListener('click', closePreview);
    backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) closePreview();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePreview();
    });
})();
</script>
