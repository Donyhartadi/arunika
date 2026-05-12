<?php
/**
 * @var array<int,array<string,string>>  $pegawai
 * @var array<int,array<string,string>>  $rekening
 * @var array<int,array<string,string>>  $paraf_default
 * @var int|null                         $editId
 * @var array{
 *   nama:string,nip:string,pangkat:string,tingkat:string,jabatan:string,
 *   asal:string,tujuan:string,perihal:string,bulan:string,alat:string,
 *   berangkat:string,kembali:string,lama:string,
 *   berangkat_date:string,kembali_date:string,
 *   no_rekening:string,seksi:string,tahun:string,
 *   pengikut_1:array<string,string>|null,
 *   pengikut_2:array<string,string>|null,
 *   pengikut_3:array<string,string>|null,
 *   paraf:array<int,string>
 * }|null $prefill
 */
ob_start(); ?>
#formSPT .section-card { padding: 0.7rem 0.9rem; margin-bottom: 0.5rem; }
#formSPT .section-card h5 { font-size: 0.9rem; margin-bottom: 0.3rem; }
#formSPT .section-card .eyebrow { margin-bottom: 0.1rem; }
#formSPT label { font-size: 0.8rem; margin-bottom: 0.12rem; font-weight: 600; }
#formSPT .form-control { padding: 0.3rem 0.55rem; font-size: 0.875rem; }
#formSPT select.form-control { padding: 0.3rem 0.4rem; }
#formSPT .form-text { font-size: 0.72rem; margin-top: 0.1rem; }
#formSPT .row.g-2 > [class*='col'] { padding-bottom: 0; }
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Form SPT & SPD', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Generator Dokumen</div>
                <h1>Form SPT & SPD</h1>
                <p class="meta">Lengkapi data perjalanan, pilih pegawai, lalu generate dokumen SPT dan SPPD dari satu alur kerja yang lebih rapi.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <form method="post" action="<?= isset($editId) ? site_url('surat/update/'.$editId) : site_url('surat/proses') ?>" id="formSPT">
        <?= csrf_field() ?>

        <div class="section-card">
            <span class="eyebrow">Bagian 1</span>
            <h5>Data Surat</h5>
            <div class="row g-2 align-items-end">
                        <div class="col-md-4 col-sm-12">
                            <label>Seksi / Bidang</label>
                            <select name="seksi" id="seksi" class="form-control" required>
                                <option value="">-- Pilih Seksi --</option>
                                <option value="Diskominfo SP-I" <?= (isset($prefill) && $prefill['seksi'] === 'Diskominfo SP-I') ? 'selected' : '' ?>>Sekretariat &mdash; Diskominfo SP-I</option>
                                <option value="Diskominfo SP-II" <?= (isset($prefill) && $prefill['seksi'] === 'Diskominfo SP-II') ? 'selected' : '' ?>>PDIPS &mdash; Diskominfo SP-II</option>
                                <option value="Diskominfo SP-III" <?= (isset($prefill) && $prefill['seksi'] === 'Diskominfo SP-III') ? 'selected' : '' ?>>EGOV &mdash; Diskominfo SP-III</option>
                                <option value="Diskominfo SP-IV" <?= (isset($prefill) && $prefill['seksi'] === 'Diskominfo SP-IV') ? 'selected' : '' ?>>Perski &mdash; Diskominfo SP-IV</option>
                                <option value="Diskominfo SP-V" <?= (isset($prefill) && $prefill['seksi'] === 'Diskominfo SP-V') ? 'selected' : '' ?>>PKP &mdash; Diskominfo SP-V</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label>Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" min="2000" max="2099" placeholder="<?= date('Y') ?>" value="<?= isset($prefill) ? esc($prefill['tahun']) : '' ?>" required>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label>Bulan</label>
                            <select name="bulan" id="bulan" class="form-control" required>
                                <option value="">-- Pilih Bulan --</option>
                                <option value="Januari" <?= (isset($prefill) && $prefill['bulan'] === 'Januari') ? 'selected' : '' ?>>Januari</option>
                                <option value="Februari" <?= (isset($prefill) && $prefill['bulan'] === 'Februari') ? 'selected' : '' ?>>Februari</option>
                                <option value="Maret" <?= (isset($prefill) && $prefill['bulan'] === 'Maret') ? 'selected' : '' ?>>Maret</option>
                                <option value="April" <?= (isset($prefill) && $prefill['bulan'] === 'April') ? 'selected' : '' ?>>April</option>
                                <option value="Mei" <?= (isset($prefill) && $prefill['bulan'] === 'Mei') ? 'selected' : '' ?>>Mei</option>
                                <option value="Juni" <?= (isset($prefill) && $prefill['bulan'] === 'Juni') ? 'selected' : '' ?>>Juni</option>
                                <option value="Juli" <?= (isset($prefill) && $prefill['bulan'] === 'Juli') ? 'selected' : '' ?>>Juli</option>
                                <option value="Agustus" <?= (isset($prefill) && $prefill['bulan'] === 'Agustus') ? 'selected' : '' ?>>Agustus</option>
                                <option value="September" <?= (isset($prefill) && $prefill['bulan'] === 'September') ? 'selected' : '' ?>>September</option>
                                <option value="Oktober" <?= (isset($prefill) && $prefill['bulan'] === 'Oktober') ? 'selected' : '' ?>>Oktober</option>
                                <option value="November" <?= (isset($prefill) && $prefill['bulan'] === 'November') ? 'selected' : '' ?>>November</option>
                                <option value="Desember" <?= (isset($prefill) && $prefill['bulan'] === 'Desember') ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12 d-flex align-items-end pb-1">
                            <div>
                                <p class="text-muted mb-0" style="font-size:0.79rem;">Kode seksi &amp; tahun tercantum di nomor surat.</p>
                                <p class="text-muted mb-0" style="font-size:0.79rem;">Contoh: <em>800.1.11.1/&nbsp;&nbsp;&nbsp;/Diskominfo SP-IV/2026</em></p>
                            </div>
                    </div>
                </div>
        </div>

        <div class="section-card">
            <span class="eyebrow">Bagian 2</span>
            <h5>Pegawai Utama</h5>

                    <label>Pilih Pegawai</label>
                    <select id="pegawai" name="pegawai" class="form-control mb-3" required>
                        <option value="">-- Pilih Pegawai --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['nip'] ?>" <?= (isset($prefill) && $prefill['nip'] === $p['nip']) ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="row g-2">
                        <div class="col-md-5">
                            <label>Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" readonly required value="<?= esc($prefill['nama'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" readonly required value="<?= esc($prefill['nip'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Tingkat</label>
                            <input type="text" name="tingkat" id="tingkat" class="form-control text-center" readonly required value="<?= esc($prefill['tingkat'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat</label>
                            <input type="text" name="pangkat" id="pangkat" class="form-control" readonly required value="<?= esc($prefill['pangkat'] ?? '') ?>">
                        </div>
                        <div class="col-md-8">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" readonly required value="<?= esc($prefill['jabatan'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="button" id="add_pengikut_1" class="btn btn-outline-primary">
                            + Tambah Pengikut
                        </button>
                    </div>
                </div>

                <div id="pengikut_1_section" class="section-card" style="display:<?= (!empty($prefill['pengikut_1'])) ? 'block' : 'none' ?>;">
                    <span class="eyebrow">Opsional</span>
                    <h5>Pengikut 1</h5>

                    <label>Pilih Pengikut</label>
                    <select id="pengikut_1" name="pengikut_1" class="form-control mb-1">
                        <option value="">-- Pilih Pengikut --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['nip'] ?>" <?= (isset($prefill['pengikut_1']) && ($prefill['pengikut_1']['nip'] ?? '') === $p['nip']) ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text mb-2">Biarkan kosong jika tidak ada pengikut.</div>

                    <div class="row g-2">
                        <div class="col-md-5">
                            <label>Nama</label>
                            <input type="text" name="nama_pengikut_1" id="nama_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['nama'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>NIP</label>
                            <input type="text" name="nip_pengikut_1" id="nip_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['nip'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="lahir_pengikut_1" id="lahir_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['lahir'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat</label>
                            <input type="text" name="pangkat_pengikut_1" id="pangkat_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['pangkat'] ?? '') ?>">
                        </div>
                        <div class="col-md-5">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan_pengikut_1" id="jabatan_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['jabatan'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Keterangan</label>
                            <input type="text" name="status_1" id="status_pengikut_1" class="form-control" readonly value="<?= esc($prefill['pengikut_1']['status'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="button" id="add_pengikut_2" class="btn btn-outline-primary" <?= (!empty($prefill['pengikut_2'])) ? 'style="display:none"' : '' ?>>
                            Tambah Pengikut 2
                        </button>
                        <button type="button" id="remove_pengikut_1" class="btn btn-outline-danger">
                            Hapus Pengikut 1
                        </button>
                    </div>
                </div>

                <div id="pengikut_2_section" class="section-card" style="display:<?= (!empty($prefill['pengikut_2'])) ? 'block' : 'none' ?>;">
                    <span class="eyebrow">Opsional</span>
                    <h5>Pengikut 2</h5>

                    <label>Pilih Pengikut</label>
                    <select id="pengikut_2" name="pengikut_2" class="form-control mb-2">
                        <option value="">-- Pilih Pengikut --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['nip'] ?>" <?= (isset($prefill['pengikut_2']) && ($prefill['pengikut_2']['nip'] ?? '') === $p['nip']) ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="row g-2">
                        <div class="col-md-5">
                            <label>Nama</label>
                            <input type="text" name="nama_pengikut_2" id="nama_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['nama'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>NIP</label>
                            <input type="text" name="nip_pengikut_2" id="nip_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['nip'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="lahir_pengikut_2" id="lahir_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['lahir'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat</label>
                            <input type="text" name="pangkat_pengikut_2" id="pangkat_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['pangkat'] ?? '') ?>">
                        </div>
                        <div class="col-md-5">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan_pengikut_2" id="jabatan_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['jabatan'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Keterangan</label>
                            <input type="text" name="status_2" id="status_pengikut_2" class="form-control" readonly value="<?= esc($prefill['pengikut_2']['status'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="button" id="add_pengikut_3" class="btn btn-outline-primary" <?= (!empty($prefill['pengikut_3'])) ? 'style="display:none"' : '' ?>>
                            Tambah Pengikut 3
                        </button>
                        <button type="button" id="remove_pengikut_2" class="btn btn-outline-danger">
                            Hapus Pengikut 2
                        </button>
                    </div>
                </div>

                <div id="pengikut_3_section" class="section-card" style="display:<?= (!empty($prefill['pengikut_3'])) ? 'block' : 'none' ?>;">
                    <span class="eyebrow">Opsional</span>
                    <h5>Pengikut 3</h5>

                    <label>Pilih Pengikut</label>
                    <select id="pengikut_3" name="pengikut_3" class="form-control mb-2">
                        <option value="">-- Pilih Pengikut --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['nip'] ?>" <?= (isset($prefill['pengikut_3']) && ($prefill['pengikut_3']['nip'] ?? '') === $p['nip']) ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="row g-2">
                        <div class="col-md-5">
                            <label>Nama</label>
                            <input type="text" name="nama_pengikut_3" id="nama_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['nama'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>NIP</label>
                            <input type="text" name="nip_pengikut_3" id="nip_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['nip'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Lahir</label>
                            <input type="text" name="lahir_pengikut_3" id="lahir_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['lahir'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat</label>
                            <input type="text" name="pangkat_pengikut_3" id="pangkat_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['pangkat'] ?? '') ?>">
                        </div>
                        <div class="col-md-5">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan_pengikut_3" id="jabatan_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['jabatan'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Keterangan</label>
                            <input type="text" name="status_3" id="status_pengikut_3" class="form-control" readonly value="<?= esc($prefill['pengikut_3']['status'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" id="remove_pengikut_3" class="btn btn-outline-danger">
                            Hapus Pengikut 3
                        </button>
                    </div>
                </div>

                <div class="section-card">
                    <span class="eyebrow">Bagian 3</span>
                    <h5>Perjalanan Dinas</h5>

                    <div class="row g-2 mb-2">
                        <div class="col-md-4 col-sm-6">
                            <label>Asal</label>
                            <input list="list_asal" name="asal" class="form-control" required value="<?= esc($prefill['asal'] ?? '') ?>">
                            <datalist id="list_asal">
                                <option value="Muara Enim">
                                <option value="Palembang">
                                <option value="Prabumulih">
                                <option value="Lahat">
                                <option value="Baturaja">
                            </datalist>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <label>Tujuan</label>
                            <input list="list_tujuan" name="tujuan" class="form-control" required value="<?= esc($prefill['tujuan'] ?? '') ?>">
                            <datalist id="list_tujuan">
                                <option value="Palembang">
                                <option value="Jakarta">
                                <option value="Bandung">
                                <option value="Lampung">
                                <option value="Medan">
                            </datalist>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label>Alat Angkut</label>
                            <input list="list_alat" name="alat" id="alat" class="form-control" required value="<?= esc($prefill['alat'] ?? '') ?>">
                            <datalist id="list_alat">
                                <option value="Kendaraan Dinas - BG 8077 DZ">
                                <option value="Kendaraan Pribadi">
                                <option value="Pesawat">
                                <option value="Kereta Api">
                                <option value="Kapal Laut">
                                <option value="Travel">
                            </datalist>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Keperluan / Perihal</label>
                        <textarea name="perihal" class="form-control" style="min-height:80px;" required><?= esc($prefill['perihal'] ?? '') ?></textarea>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-md-4 col-sm-6">
                            <label>Berangkat</label>
                            <input type="date" id="berangkat_date" class="form-control" required value="<?= esc($prefill['berangkat_date'] ?? '') ?>">
                            <input type="hidden" name="berangkat" id="berangkat" value="<?= esc($prefill['berangkat'] ?? '') ?>">
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <label>Kembali</label>
                            <input type="date" id="kembali_date" class="form-control" required value="<?= esc($prefill['kembali_date'] ?? '') ?>">
                            <input type="hidden" name="kembali" id="kembali" value="<?= esc($prefill['kembali'] ?? '') ?>">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label>Lama</label>
                            <input type="text" name="lama" id="lama" class="form-control" readonly required placeholder="otomatis" value="<?= esc($prefill['lama'] ?? '') ?>">
                        </div>

                        <div class="col-md-2 col-sm-6 d-flex align-items-end pb-1">
                            <span class="text-muted" style="font-size:0.78rem;">Format: <em>12 Desember 2025</em></span>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-5 col-12">
                        <div class="section-card" style="height:100%;">
                            <span class="eyebrow">Bagian 4</span>
                            <h5>Pembiayaan</h5>
                            <label>Kode Rekening</label>
                            <select name="no_rekening" id="rekening" class="form-control" required>
                                <option value="">-- Pilih Rekening --</option>
                                <?php foreach ($rekening as $r): ?>
                                    <option
                                        value="<?= $r['no_rekening']; ?>"
                                        data-nama="<?= $r['nama_rekening']; ?>"                                        <?= (isset($prefill) && $prefill['no_rekening'] === $r['no_rekening']) ? 'selected' : '' ?>                                    >
                                        <?= $r['nama_rekening']; ?> &mdash; <?= $r['no_rekening']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-muted mt-1 mb-0" style="font-size:0.78rem;">Pilih rekening anggaran perjalanan dinas.</p>
                        </div>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="section-card" style="height:100%;">
                            <span class="eyebrow">Bagian 5 &mdash; Opsional</span>
                            <h5 style="margin-bottom:0.15rem;">Paraf Hirarki</h5>
                            <p class="text-muted" style="font-size:0.79rem; margin-bottom:0.6rem;">
                                Secara default menggunakan pengaturan global. Ubah di sini untuk menyesuaikan surat ini saja.
                            </p>
                            <?php
                            $parafDefaults = $paraf_default ?? [];
                            $parafRows = [];
                            for ($pi = 1; $pi <= 3; $pi++):
                                $row = null;
                                foreach ($parafDefaults as $pr) {
                                    if ((int)$pr['nomor'] === $pi) { $row = $pr; break; }
                                }
                                $parafRows[] = [
                                    'num'   => $pi,
                                    'value' => $prefill['paraf'][$pi] ?? ($row['label'] ?? ''),
                                ];
                            endfor;
                            ?>
                            <?php foreach ($parafRows as $pr): ?>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span style="width:22px;height:22px;min-width:22px;border-radius:50%;background:var(--primary);color:#fff;font-size:0.72rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;"><?= $pr['num'] ?></span>
                                <select name="paraf[<?= $pr['num'] ?>]" class="form-control">
                                    <option value="">— (gunakan default) —</option>
                                    <?php foreach ($parafDefaults as $opt): ?>
                                        <option value="<?= esc($opt['label']) ?>"
                                            <?= ($pr['value'] === $opt['label']) ? 'selected' : '' ?>>
                                            <?= esc($opt['label']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

        <button type="submit" id="btn_generate" class="btn btn-custom w-100 mt-2 py-2" style="letter-spacing:0.02em;">
            <?= isset($editId) ? '&#9997;&nbsp; Update &amp; Unduh Surat' : '&#128196;&nbsp; Generate &amp; Unduh Surat' ?>
        </button>

    </form>
</main>

<script>
// ========================
// PEGAWAI UTAMA
// ========================
document.getElementById('pegawai').addEventListener('change', function() {
    let nip = this.value;

    if (!nip) return;

    fetch('<?= site_url('pegawai') ?>/' + nip)
    .then(res => res.json())
    .then(data => {
        document.getElementById('nama').value = data.nama;
        document.getElementById('nip').value = data.nip;
        document.getElementById('pangkat').value = data.pangkat;
        document.getElementById('tingkat').value = data.tingkat;
        document.getElementById('jabatan').value = data.jabatan;
    })
    .catch(err => {
        console.error('Fetch pegawai gagal:', err);
    });
});

// ========================
// PENGIKUT
// ========================
document.getElementById('pengikut_1').addEventListener('change', function() {
    let nip = this.value;

    if (!nip) return;

    fetch('<?= site_url('pegawai') ?>/' + nip)
    .then(res => res.json())
    .then(data => {
        document.getElementById('nama_pengikut_1').value = data.nama;
        document.getElementById('nip_pengikut_1').value = data.nip;
        document.getElementById('pangkat_pengikut_1').value = data.pangkat;
        document.getElementById('jabatan_pengikut_1').value = data.jabatan;
        document.getElementById('lahir_pengikut_1').value = data.lahir;
        document.getElementById('status_pengikut_1').value = data.status;
    })
    .catch(err => {
        console.error('Fetch pengikut 1 gagal:', err);
    });
});

// TOMBOL TAMBAH PENGIKUT 1
const addPengikut1Button = document.getElementById('add_pengikut_1');
const pengikut1Section = document.getElementById('pengikut_1_section');
const addPengikut2Button = document.getElementById('add_pengikut_2');
const pengikut2Section = document.getElementById('pengikut_2_section');
const addPengikut3Button = document.getElementById('add_pengikut_3');
const pengikut3Section = document.getElementById('pengikut_3_section');

addPengikut1Button.addEventListener('click', function() {
    pengikut1Section.style.display = 'block';
    addPengikut1Button.style.display = 'none';
});

addPengikut2Button.addEventListener('click', function() {
    pengikut2Section.style.display = 'block';
    addPengikut2Button.style.display = 'none';
});

addPengikut3Button.addEventListener('click', function() {
    pengikut3Section.style.display = 'block';
    addPengikut3Button.style.display = 'none';
});

const removePengikut2Button = document.getElementById('remove_pengikut_2');
const removePengikut3Button = document.getElementById('remove_pengikut_3');
const removePengikut1Button = document.getElementById('remove_pengikut_1');

function clearPengikutFields(number) {
    const fields = ['nama', 'nip', 'pangkat', 'jabatan', 'lahir', 'status'];
    fields.forEach(field => {
        const el = document.getElementById(`${field}_pengikut_${number}`);
        if (el) el.value = '';
    });
    const select = document.getElementById(`pengikut_${number}`);
    if (select) select.value = '';
}

function removePengikut3Section() {
    pengikut3Section.style.display = 'none';
    addPengikut3Button.style.display = 'block';
    clearPengikutFields(3);
}

removePengikut1Button.addEventListener('click', function() {
    pengikut1Section.style.display = 'none';
    addPengikut1Button.style.display = 'block';
    clearPengikutFields(1);
    pengikut2Section.style.display = 'none';
    addPengikut2Button.style.display = 'block';
    clearPengikutFields(2);
    removePengikut3Section();
});

removePengikut2Button.addEventListener('click', function() {
    pengikut2Section.style.display = 'none';
    addPengikut2Button.style.display = 'block';
    clearPengikutFields(2);
    removePengikut3Section();
});

removePengikut3Button.addEventListener('click', function() {
    removePengikut3Section();
});

document.getElementById('pengikut_2').addEventListener('change', function() {
    let nip = this.value;

    if (!nip) {
        document.getElementById('nama_pengikut_2').value = '';
        document.getElementById('nip_pengikut_2').value = '';
        document.getElementById('pangkat_pengikut_2').value = '';
        document.getElementById('jabatan_pengikut_2').value = '';
        document.getElementById('lahir_pengikut_2').value = '';
        document.getElementById('status_pengikut_2').value = '';
        return;
    }

    fetch('<?= site_url('pegawai') ?>/' + nip)
    .then(res => res.json())
    .then(data => {
        document.getElementById('nama_pengikut_2').value = data.nama;
        document.getElementById('nip_pengikut_2').value = data.nip;
        document.getElementById('pangkat_pengikut_2').value = data.pangkat;
        document.getElementById('jabatan_pengikut_2').value = data.jabatan;
        document.getElementById('lahir_pengikut_2').value = data.lahir;
        document.getElementById('status_pengikut_2').value = data.status;
    })
    .catch(err => {
        console.error('Fetch pengikut 2 gagal:', err);
    });
});

document.getElementById('pengikut_3').addEventListener('change', function() {
    let nip = this.value;

    if (!nip) {
        document.getElementById('nama_pengikut_3').value = '';
        document.getElementById('nip_pengikut_3').value = '';
        document.getElementById('pangkat_pengikut_3').value = '';
        document.getElementById('jabatan_pengikut_3').value = '';
        document.getElementById('lahir_pengikut_3').value = '';
        document.getElementById('status_pengikut_3').value = '';
        return;
    }

    fetch('<?= site_url('pegawai') ?>/' + nip)
    .then(res => res.json())
    .then(data => {
        document.getElementById('nama_pengikut_3').value = data.nama;
        document.getElementById('nip_pengikut_3').value = data.nip;
        document.getElementById('pangkat_pengikut_3').value = data.pangkat;
        document.getElementById('jabatan_pengikut_3').value = data.jabatan;
        document.getElementById('lahir_pengikut_3').value = data.lahir;
        document.getElementById('status_pengikut_3').value = data.status;
    })
    .catch(err => {
        console.error('Fetch pengikut 3 gagal:', err);
    });
});

// ========================
// HITUNG LAMA
// ========================
function formatIndoDate(dateString) {
    if (!dateString) return '';

    const date = new Date(dateString);
    if (Number.isNaN(date.getTime())) return '';

    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

function buildDateValue(prefix) {
    const dateValue = document.getElementById(prefix + '_date').value;
    const hidden = document.getElementById(prefix);
    hidden.value = formatIndoDate(dateValue);
    return dateValue;
}

function hitungLama() {
    const berangkatDate = buildDateValue('berangkat');
    const kembaliDate = buildDateValue('kembali');

    if (berangkatDate && kembaliDate) {
        let t1 = new Date(berangkatDate);
        let t2 = new Date(kembaliDate);

        if (Number.isNaN(t1.getTime()) || Number.isNaN(t2.getTime())) {
            document.getElementById('lama').value = '';
            return;
        }

        let selisih = (t2 - t1) / (1000 * 60 * 60 * 24);

        if (selisih >= 0) {
            const days = selisih + 1;
            document.getElementById('lama').value = days + ' hari';
        } else {
            document.getElementById('lama').value = "";
        }
    } else {
        document.getElementById('lama').value = '';
    }
}

document.getElementById('berangkat_date').addEventListener('change', hitungLama);
document.getElementById('kembali_date').addEventListener('change', hitungLama);

document.addEventListener("DOMContentLoaded", function() {
    <?php if (!isset($prefill)): ?>
    const bulanSekarang = new Date().getMonth(); // 0 = Januari

    const daftarBulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    document.getElementById("bulan").value = daftarBulan[bulanSekarang];
    document.getElementById("tahun").value = new Date().getFullYear();
    <?php endif; ?>
});

// ========================
// KONFIRMASI GENERATE SURAT
// ========================
document.getElementById('btn_generate').addEventListener('click', function (e) {
    e.preventDefault();
    var form = this.closest('form');

    // Kumpulkan ringkasan sebelum konfirmasi
    var namaPegawai = document.getElementById('nama')?.value?.trim() || '—';
    var tujuan      = document.querySelector('[name="tujuan"]')?.value?.trim() || '—';
    var keperluan   = document.querySelector('[name="perihal"]')?.value?.trim() || '—';

    var isEdit = <?= isset($editId) ? 'true' : 'false' ?>;
    var aksi   = isEdit ? 'update' : 'generate';
    var pesan  = 'Pastikan data berikut sudah benar sebelum ' + aksi + ':\n\n'
              + '  Pegawai  : ' + namaPegawai + '\n'
              + '  Tujuan   : ' + tujuan + '\n'
              + '  Keperluan: ' + keperluan + '\n\n'
              + 'Lanjutkan ' + aksi + ' surat?';

    if (window.confirm(pesan)) {
        form.submit();
    }
});

<?php if (isset($prefill)): ?>
// Prefill tanggal dan lama (agar tidak kosong jika user tidak mengubah tanggal)
document.addEventListener('DOMContentLoaded', function () {
    var bd = document.getElementById('berangkat_date');
    var kd = document.getElementById('kembali_date');
    if (bd && !bd.dataset.prefilled) {
        bd.dataset.prefilled = '1';
        // Tanggal sudah di-set via value attr. Pastikan hidden fields terisi juga.
        var bh = document.getElementById('berangkat');
        var kh = document.getElementById('kembali');
        if (bh && !bh.value) bh.value = '<?= esc($prefill['berangkat']) ?>';
        if (kh && !kh.value) kh.value = '<?= esc($prefill['kembali']) ?>';
        var lama = document.getElementById('lama');
        if (lama && !lama.value) lama.value = '<?= esc($prefill['lama']) ?>';
    }
    // Show pengikut 1 add button appropriately
    <?php if (!empty($prefill['pengikut_1'])): ?>
    var addBtn1 = document.getElementById('add_pengikut_1');
    if (addBtn1) addBtn1.style.display = 'none';
    <?php endif; ?>
});
<?php endif; ?>

</script>

<?= view('_partials/footer') ?>