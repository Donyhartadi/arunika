<?php
// Hitung per-kategori untuk badge filter
$totalC1 = count(array_filter($pegawai, fn($p) => $p['tingkat'] === 'C1'));
$totalC2 = count(array_filter($pegawai, fn($p) => $p['tingkat'] === 'C2'));
$totalC3 = count(array_filter($pegawai, fn($p) => $p['tingkat'] === 'C3'));
?>
<?= view('_partials/head', ['title' => 'Manajemen Pegawai']) ?>

<style>
/* ── Toolbar ── */
.toolbar-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .75rem;
}
.search-wrap {
    flex: 1 1 220px;
    position: relative;
}
.search-wrap .search-icon {
    position: absolute;
    left: .75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
    font-size: .9rem;
}
.search-wrap input {
    padding-left: 2.25rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    height: 38px;
    font-size: .875rem;
    width: 100%;
}
.search-wrap input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}

/* ── Filter pills ── */
.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: .375rem;
}
.filter-pill {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .3rem .75rem;
    border-radius: 999px;
    border: 1.5px solid #e5e7eb;
    background: #f9fafb;
    font-size: .8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    color: #374151;
    user-select: none;
}
.filter-pill:hover { border-color: #6366f1; color: #6366f1; background: #eef2ff; }
.filter-pill.active { background: #6366f1; border-color: #6366f1; color: #fff; }
.filter-pill.active .pill-count { background: rgba(255,255,255,.25); color: #fff; }
.pill-count {
    background: #e5e7eb;
    color: #6b7280;
    border-radius: 999px;
    padding: 0 .45rem;
    font-size: .72rem;
    font-weight: 600;
    min-width: 18px;
    text-align: center;
}

/* ── Tingkat badge ── */
.badge-tingkat {
    display: inline-block;
    padding: .25rem .6rem;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .03em;
}
.badge-C1 { background: #dbeafe; color: #1d4ed8; }
.badge-C2 { background: #dcfce7; color: #166534; }
.badge-C3 { background: #fef9c3; color: #854d0e; }

/* ── Table improvements ── */
.pegawai-table th {
    font-size: .75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #6b7280;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
}
.pegawai-table td { font-size: .875rem; color: #374151; }
.pegawai-table .nip-cell { font-family: monospace; font-size: .78rem; color: #6b7280; }
.pegawai-table .jabatan-cell { max-width: 260px; }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #9ca3af;
}
.empty-state .empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }
.empty-state p { margin: 0; font-size: .9rem; }

/* ── Action buttons ── */
.action-btn-group { display: flex; gap: .375rem; flex-wrap: nowrap; }

/* ── Result counter ── */
#resultCount { font-size: .82rem; color: #6b7280; white-space: nowrap; }

/* ── Responsive hide ── */
@media (max-width: 767px) {
    .col-hide-mobile { display: none; }
    .jabatan-cell { max-width: 150px; }
    .toolbar-card { gap: .5rem; }
}
</style>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Master Data</div>
                <h1>Manajemen Pegawai</h1>
                <p class="meta">Kelola data pegawai yang menjadi sumber otomatis pada form surat dinas.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-light" href="/dashboard">← Kembali</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">

    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= esc($message) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <div class="card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
            <div>
                <h2 style="margin:0 0 .15rem;">Daftar Pegawai</h2>
                <small class="text-muted">Total <?= count($pegawai) ?> pegawai terdaftar</small>
            </div>
            <button class="btn btn-primary" onclick="openPegawaiModal()">+ Tambah Pegawai</button>
        </div>

        <!-- TOOLBAR: search + filter -->
        <div class="toolbar-card">
            <div class="search-wrap">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" placeholder="Cari NIP, nama, atau jabatan…" autocomplete="off">
            </div>

            <div class="filter-pills">
                <span class="filter-pill active" data-filter="all">
                    Semua <span class="pill-count"><?= count($pegawai) ?></span>
                </span>
                <span class="filter-pill" data-filter="C1">
                    C1 – Gol. IV <span class="pill-count"><?= $totalC1 ?></span>
                </span>
                <span class="filter-pill" data-filter="C2">
                    C2 – Gol. III.c/d <span class="pill-count"><?= $totalC2 ?></span>
                </span>
                <span class="filter-pill" data-filter="C3">
                    C3 – Gol. III.a/b &amp; II <span class="pill-count"><?= $totalC3 ?></span>
                </span>
            </div>

            <span id="resultCount"></span>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle pegawai-table" id="pegawaiTable">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama &amp; Jabatan</th>
                        <th class="col-hide-mobile">Pangkat</th>
                        <th>Kat.</th>
                        <th class="col-hide-mobile">Status</th>
                        <th style="width:110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pegawaiTbody">
                    <?php if (empty($pegawai)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">👥</div>
                                    <p>Belum ada data pegawai.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pegawai as $p): ?>
                            <?php
                                $tingkat = esc($p['tingkat']);
                                $badgeClass = match($tingkat) { 'C1' => 'badge-C1', 'C2' => 'badge-C2', default => 'badge-C3' };
                            ?>
                            <tr data-tingkat="<?= $tingkat ?>"
                                data-search="<?= strtolower(esc($p['nip']) . ' ' . esc($p['nama']) . ' ' . esc($p['jabatan'])) ?>">
                                <td class="nip-cell"><?= esc($p['nip']) ?></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($p['nama']) ?></div>
                                    <div class="text-muted jabatan-cell" style="font-size:.8rem;"><?= esc($p['jabatan']) ?></div>
                                </td>
                                <td class="col-hide-mobile" style="font-size:.8rem;"><?= esc($p['pangkat']) ?></td>
                                <td><span class="badge-tingkat <?= $badgeClass ?>"><?= $tingkat ?></span></td>
                                <td class="col-hide-mobile">
                                    <?php if (!empty($p['status'])): ?>
                                        <span class="badge bg-light text-dark border"><?= esc($p['status']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btn-group">
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick='openPegawaiModal(
                                                <?= json_encode($p['nip']) ?>,
                                                <?= json_encode($p['nama']) ?>,
                                                <?= json_encode($p['lahir']) ?>,
                                                <?= json_encode($p['status']) ?>,
                                                <?= json_encode($p['pangkat']) ?>,
                                                <?= json_encode($p['tingkat']) ?>,
                                                <?= json_encode($p['jabatan']) ?>
                                            )'>Edit</button>

                                        <form method="post" action="/pegawai/delete/<?= esc($p['nip']) ?>" style="display:inline;" onsubmit="return confirm('Hapus pegawai ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <!-- Baris kosong saat filter tidak ada hasil -->
                <tbody id="emptyFilterRow" style="display:none;">
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">🔍</div>
                                <p>Tidak ada pegawai yang cocok dengan pencarian.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</main>

<!-- MODAL -->
<div class="modal fade" id="pegawaiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pegawaiModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="/pegawai/save">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="original_nip" id="original_nip">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" id="modal_nip" name="nip" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" id="modal_nama" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tempat, Tgl Lahir</label>
                            <input type="text" id="modal_lahir" name="lahir" class="form-control" placeholder="cth: Palembang, 01-01-1990">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status Kepegawaian</label>
                            <select id="modal_status" name="status" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="PNS">PNS</option>
                                <option value="PPPK">PPPK</option>
                                <option value="Non-PNS">Non-PNS</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori Biaya</label>
                            <select id="modal_tingkat" name="tingkat" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="C1">C1 – Gol. IV</option>
                                <option value="C2">C2 – Gol. III.c / III.d</option>
                                <option value="C3">C3 – Gol. III.a, III.b, II</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Pangkat / Golongan</label>
                            <input type="text" id="modal_pangkat" name="pangkat" class="form-control" placeholder="cth: Penata Tingkat I / (III.d)">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <input type="text" id="modal_jabatan" name="jabatan" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="modalSubmitButton">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('_partials/footer') ?>

<script>
/* ─── Modal ─── */
const modalEl = document.getElementById('pegawaiModal');
const modal   = new bootstrap.Modal(modalEl);
const form    = modalEl.querySelector('form');

function openPegawaiModal(nip = '', nama = '', lahir = '', status = '', pangkat = '', tingkat = '', jabatan = '') {
    form.reset();

    document.getElementById('modal_nip').value    = nip;
    document.getElementById('modal_nama').value   = nama;
    document.getElementById('modal_lahir').value  = lahir;
    document.getElementById('modal_status').value = status;
    document.getElementById('modal_pangkat').value= pangkat;
    document.getElementById('modal_tingkat').value= tingkat;
    document.getElementById('modal_jabatan').value= jabatan;
    document.getElementById('original_nip').value = nip;

    const isEdit = !!nip;
    document.getElementById('pegawaiModalLabel').innerText = isEdit ? 'Edit Pegawai' : 'Tambah Pegawai';
    document.getElementById('modalSubmitButton').innerText  = isEdit ? 'Update'       : 'Simpan';
    document.getElementById('modal_nip').readOnly           = isEdit;

    modal.show();
}

modalEl.addEventListener('hidden.bs.modal', () => {
    form.reset();
    document.getElementById('original_nip').value  = '';
    document.getElementById('modal_nip').readOnly   = false;
    document.getElementById('pegawaiModalLabel').innerText = 'Tambah Pegawai';
    document.getElementById('modalSubmitButton').innerText  = 'Simpan';
});

/* ─── Search & Filter ─── */
const rows       = Array.from(document.querySelectorAll('#pegawaiTbody tr[data-tingkat]'));
const emptyRow   = document.getElementById('emptyFilterRow');
const resultCount= document.getElementById('resultCount');
const searchInput= document.getElementById('searchInput');
const pills      = document.querySelectorAll('.filter-pill');

let activeFilter = 'all';
let searchQuery  = '';

function applyFilters() {
    let visible = 0;

    rows.forEach(row => {
        const matchFilter = activeFilter === 'all' || row.dataset.tingkat === activeFilter;
        const matchSearch = !searchQuery || row.dataset.search.includes(searchQuery);
        const show = matchFilter && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const total = activeFilter === 'all' ? rows.length :
                  rows.filter(r => r.dataset.tingkat === activeFilter).length;

    emptyRow.style.display = visible === 0 ? '' : 'none';

    if (searchQuery || activeFilter !== 'all') {
        resultCount.textContent = `Menampilkan ${visible} dari ${rows.length} pegawai`;
    } else {
        resultCount.textContent = '';
    }
}

pills.forEach(pill => {
    pill.addEventListener('click', () => {
        pills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        activeFilter = pill.dataset.filter;
        applyFilters();
    });
});

searchInput.addEventListener('input', () => {
    searchQuery = searchInput.value.trim().toLowerCase();
    applyFilters();
});
</script>
