<?php
/**
 * @var array<string,string|int|null> $log
 * @var array<string,string>          $prefill
 * @var int                           $parent_log_id
 */
ob_start(); ?>
#formKwitansi .section-card { padding: 0.75rem; margin-bottom: 0.5rem; }
#formKwitansi .section-card h5 { margin-bottom: 0.4rem; font-size: 0.95rem; }
#formKwitansi .section-card .eyebrow { margin-bottom: 0.1rem; }
#formKwitansi .form-control { padding: 0.3rem 0.55rem; font-size: 0.88rem; }
#formKwitansi label { margin-bottom: 0.15rem; font-size: 0.82rem; }
#formKwitansi .form-text { font-size: 0.72rem; margin-top: 0.1rem; }
#formKwitansi textarea.form-control { padding: 0.4rem 0.55rem; }
.rp-preview { font-size: 0.8rem; color: var(--primary); font-weight: 600; margin-top: 0.2rem; }
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Form Kwitansi', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Generator Dokumen</div>
                <h1>Kwitansi Perjalanan Dinas</h1>
                <p class="meta">Buat kwitansi pembayaran berdasarkan data rincian perjalanan dinas.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/surat/history">Kembali ke Riwayat</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <form method="post" action="<?= site_url('surat/proses-kwitansi') ?>" id="formKwitansi">
        <?= csrf_field() ?>
        <input type="hidden" name="parent_log_id" value="<?= (int) $parent_log_id ?>">
        <input type="hidden" name="kategori_rincian" value="<?= esc($kategori_rincian ?? '') ?>">
        <?php $isLuarDaerah = in_array($kategori_rincian ?? '', ['luar_daerah_dalam_provinsi', 'luar_daerah_luar_provinsi']); ?>
        <?php
            $selRek = $selected_rekening ?? null;
            $pf = $prefill ?? [];
        ?>

        <!-- Bagian Header: Kode Rekening, Bidang, Sub Kegiatan, Tahun -->
        <div class="section-card mb-2">
            <span class="eyebrow">Header Dokumen</span>
            <h5>Kode Rekening &amp; Info Bidang</h5>
            <div class="row g-2">
                <div class="col-md-12">
                    <label>Pilih Kode Rekening <span class="text-danger">*</span></label>
                    <select id="rekening_select" class="form-select" required onchange="onRekeningChange(this)">
                        <option value="">-- Pilih Kode Rekening --</option>
                        <?php foreach (($rekening_list ?? []) as $r): ?>
                        <option value="<?= esc($r['no_rekening']) ?>"
                                data-bidang="<?= esc($r['bidang'] ?? '') ?>"
                                data-sub="<?= esc($r['sub_kegiatan'] ?? '') ?>"
                                <?= ($selRek && $selRek['id_rekening'] === $r['id_rekening']) ? 'selected' : '' ?>>
                            <?= esc($r['nama_rekening']) ?> &mdash; <?= esc($r['no_rekening']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-7">
                    <label>Kode Rekening</label>
                    <input type="text" name="kode_rekening" id="kode_rekening" class="form-control"
                           value="<?= esc($selRek['no_rekening'] ?? '') ?>" placeholder="2.21.02.2.01.0005.5.1.02.04.001.00001">
                </div>
                <div class="col-md-5">
                    <label>Bidang</label>
                    <input type="text" name="bidang" id="bidang" class="form-control"
                           value="<?= esc($selRek['bidang'] ?? '') ?>" placeholder="Persandian dan Keamanan Informasi">
                </div>
                <div class="col-12">
                    <label>Sub Kegiatan</label>
                    <input type="text" name="sub_kegiatan" id="sub_kegiatan" class="form-control"
                           value="<?= esc($selRek['sub_kegiatan'] ?? '') ?>" placeholder="Pelaksanaan Keamanan Informasi...">
                </div>
            </div>
        </div>

        <div class="row g-2">
            <!-- Kolom kiri: Data Penerima & Kuitansi -->
            <div class="col-md-6">

                <!-- Bagian 0: PPTK -->
                <div class="section-card">
                    <span class="eyebrow">Bagian 1</span>
                    <h5>Pejabat Pelaksana Teknis Kegiatan (PPTK)</h5>
                    <div class="row g-2">
                        <div class="col-12">
                            <label>Pilih PPTK <span class="text-danger">*</span></label>
                            <select name="pptk_select" id="pptk_select" class="form-select" required onchange="onPPTKChange(this)">
                                <option value="">-- Pilih PPTK --</option>
                                <?php foreach (($pptk_list ?? []) as $p): ?>
                                <option value="<?= esc($p['nip']) ?>" data-nama="<?= esc($p['nama']) ?>" data-jabatan="<?= esc($p['jabatan']) ?>">
                                    <?= esc($p['nama']) ?> &mdash; <?= esc($p['jabatan']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="nama_pptk" id="nama_pptk" value="">
                        <input type="hidden" name="nip_pptk" id="nip_pptk" value="">
                    </div>
                </div>

                <!-- Bagian 1: Info dari SPT -->
                <div class="section-card">
                    <span class="eyebrow">Bagian 2</span>
                    <h5>Data Penerima</h5>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <label>Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penerima" class="form-control" required
                                   value="<?= esc($pf['nama_penerima'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip_penerima" class="form-control" required
                                   value="<?= esc($pf['nip_penerima'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label>Tanggal Kuitansi <span class="text-danger">*</span></label>
                            <?php
                                $bulanId = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                $defaultTanggal = $pf['tanggal'] ?? (date('d') . ' ' . $bulanId[(int)date('n')] . ' ' . date('Y'));
                            ?>
                            <input type="text" name="tanggal" class="form-control" required
                                   placeholder="04 Mei 2026" autocomplete="off"
                                   value="<?= esc($defaultTanggal) ?>">
                            <div class="form-text">Format: tanggal bulan tahun. Contoh: 04 Mei 2026</div>
                        </div>
                        <div class="col-12">
                            <label>Nomor Kuitansi</label>
                            <input type="text" name="nomor" class="form-control"
                                   placeholder="001/BP/001/Diskominfo SP/2026"
                                   value="<?= esc($pf['nomor'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Bagian 3: Deskripsi Pembayaran -->
                <div class="section-card">
                    <span class="eyebrow">Bagian 3</span>
                    <h5>Untuk Pembayaran</h5>
                    <textarea name="untuk_pembayaran" class="form-control" rows="5" required
                              placeholder="Biaya Perjalanan Dinas Dalam Daerah a.n. ..."><?= esc($pf['untuk_pembayaran'] ?? '') ?></textarea>
                    <div class="form-text">Deskripsi lengkap pembayaran yang tertera di kuitansi.</div>
                </div>

            </div>

            <!-- Kolom kanan: Rincian Biaya -->
            <div class="col-md-6">
                <div class="section-card" style="height:100%;">
                    <span class="eyebrow">Bagian 4</span>
                    <h5>Rincian Biaya</h5>
                    <p class="text-muted" style="font-size:0.79rem; margin-bottom:0.6rem;">
                        Masukkan jumlah sesuai dengan rincian perjalanan dinas yang sudah dibuat.
                        Format angka: <code>300.000,-</code>
                    </p>

                    <div class="row g-2">
                        <div class="col-12">
                            <label>Uang Harian <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.82rem;">Rp.</span>
                                <input type="text" name="uang_harian" id="uang_harian" class="form-control rp-input"
                                       required placeholder="300.000,-"
                                       value="<?= esc($pf['uang_harian'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-12"<?= $isLuarDaerah ? '' : ' style="display:none"' ?> id="row_uang_penginapan">
                            <label>Uang Penginapan</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.82rem;">Rp.</span>
                                <input type="text" name="uang_penginapan" id="uang_penginapan" class="form-control rp-input"
                                       placeholder="0,-"
                                       value="<?= esc($pf['uang_penginapan'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Biaya Transportasi / BBM <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.82rem;">Rp.</span>
                                <input type="text" name="biaya_transport" id="biaya_transport" class="form-control rp-input"
                                       required placeholder="496.000,-"
                                       value="<?= esc($pf['biaya_transport'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Biaya Lain-lain</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.82rem;">Rp.</span>
                                <input type="text" name="biaya_lain" id="biaya_lain" class="form-control rp-input"
                                       placeholder="0,-"
                                       value="<?= esc($pf['biaya_lain'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Jumlah Total <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:0.82rem;">Rp.</span>
                                <input type="text" name="jumlah" id="jumlah" class="form-control rp-input"
                                       required placeholder="796.000,-"
                                       value="<?= esc($pf['jumlah'] ?? '') ?>">
                            </div>
                            <div class="form-text">
                                <button type="button" class="btn btn-link p-0" style="font-size:0.72rem;" onclick="autoJumlah()">
                                    &#8679; Hitung otomatis (harian + transportasi)
                                </button>
                            </div>
                        </div>
                        <div class="col-12" style="margin-top:0.5rem;">
                            <label>Terbilang <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2 align-items-start">
                                <input type="text" name="terbilang" id="terbilang" class="form-control"
                                       required placeholder="Tujuh Ratus Sembilan Puluh Enam Ribu Rupiah"
                                       value="<?= esc($pf['terbilang'] ?? '') ?>">
                                <button type="button" class="btn btn-outline-secondary btn-sm flex-shrink-0"
                                        style="white-space:nowrap; font-size:0.75rem;" onclick="autoTerbilang()">
                                    &#9998; Auto
                                </button>
                            </div>
                            <div class="form-text">Terbilang dari jumlah total (tanpa "Rp." dan tanda "=").</div>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div id="ringkasanBiaya" style="display:none; margin-top:1rem; padding:0.6rem 0.75rem; background:var(--surface-alt,#f8f7f3); border-radius:8px; border:1px solid var(--line,#e5e7eb);">
                        <div style="font-size:0.78rem; font-weight:600; color:var(--text); margin-bottom:0.3rem;">Ringkasan:</div>
                        <div style="font-size:0.8rem; display:flex; justify-content:space-between;">
                            <span>Uang Harian</span><span id="sum_harian">-</span>
                        </div>
                        <div style="font-size:0.8rem; display:flex; justify-content:space-between;">
                            <span>Uang Penginapan</span><span id="sum_penginapan">-</span>
                        </div>
                        <div style="font-size:0.8rem; display:flex; justify-content:space-between;">
                            <span>Biaya Transport</span><span id="sum_transport">-</span>
                        </div>
                        <div style="font-size:0.8rem; display:flex; justify-content:space-between;">
                            <span>Biaya Lain-lain</span><span id="sum_lain">-</span>
                        </div>
                        <div style="font-size:0.8rem; display:flex; justify-content:space-between; font-weight:600; border-top:1px solid var(--line,#e5e7eb); margin-top:0.25rem; padding-top:0.25rem;">
                            <span>Total</span><span id="sum_total">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="row g-2 mt-1">
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="/surat/history" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    &#8659;&nbsp; Generate Kwitansi
                </button>
            </div>
        </div>
    </form>
</main>

<script>
// Parse angka dari format "300.000,-" atau "300000"
function parseRp(str) {
    if (!str) return 0;
    return parseInt(str.replace(/\./g, '').replace(',-', '').replace(',', '').replace('Rp', '').trim()) || 0;
}

// Format angka ke "796.000,-"
function formatRp(n) {
    return n.toLocaleString('id-ID') + ',-';
}

var isLuarDaerah = <?= $isLuarDaerah ? 'true' : 'false' ?>;

function onRekeningChange(sel) {
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('kode_rekening').value = opt.value || '';
    document.getElementById('bidang').value         = opt.dataset.bidang || '';
    document.getElementById('sub_kegiatan').value   = opt.dataset.sub || '';
}

function onPPTKChange(sel) {
    var opt = sel.options[sel.selectedIndex];
    document.getElementById('nama_pptk').value = opt.dataset.nama || '';
    document.getElementById('nip_pptk').value  = opt.value || '';
}

function autoJumlah() {
    var h = parseRp(document.getElementById('uang_harian').value);
    var p = isLuarDaerah ? parseRp(document.getElementById('uang_penginapan').value) : 0;
    var t = parseRp(document.getElementById('biaya_transport').value);
    var l = parseRp(document.getElementById('biaya_lain').value);
    var total = h + p + t + l;
    document.getElementById('jumlah').value = total > 0 ? formatRp(total) : '';
    updateRingkasan();
}

function updateRingkasan() {
    var h = parseRp(document.getElementById('uang_harian').value);
    var p = isLuarDaerah ? parseRp(document.getElementById('uang_penginapan').value) : 0;
    var t = parseRp(document.getElementById('biaya_transport').value);
    var l = parseRp(document.getElementById('biaya_lain').value);
    var total = parseRp(document.getElementById('jumlah').value);
    if (h > 0 || p > 0 || t > 0 || l > 0) {
        document.getElementById('ringkasanBiaya').style.display = 'block';
        document.getElementById('sum_harian').textContent    = 'Rp ' + h.toLocaleString('id-ID');
        document.getElementById('sum_penginapan').textContent = 'Rp ' + p.toLocaleString('id-ID');
        document.getElementById('sum_transport').textContent  = 'Rp ' + t.toLocaleString('id-ID');
        document.getElementById('sum_lain').textContent       = 'Rp ' + l.toLocaleString('id-ID');
        document.getElementById('sum_total').textContent      = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// Simple terbilang in Indonesian
function terbilang(n) {
    if (n === 0) return 'Nol';
    var satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan',
                  'Sepuluh', 'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas',
                  'Enam Belas', 'Tujuh Belas', 'Delapan Belas', 'Sembilan Belas'];
    function ratusan(x) {
        if (x < 20) return satuan[x];
        var t = Math.floor(x / 10);
        var s = x % 10;
        return (t === 1 ? 'Sepuluh' : satuan[t] + ' Puluh') + (s > 0 ? ' ' + satuan[s] : '');
    }
    function ribuan(x) {
        if (x < 100) return ratusan(x);
        var r = Math.floor(x / 100);
        var s = x % 100;
        return (r === 1 ? 'Seratus' : satuan[r] + ' Ratus') + (s > 0 ? ' ' + ratusan(s) : '');
    }
    var parts = [];
    var m = Math.floor(n / 1000000);
    var r = Math.floor((n % 1000000) / 1000);
    var s = n % 1000;
    if (m > 0) parts.push(ribuan(m) + ' Juta');
    if (r > 0) parts.push((r === 1 ? 'Seribu' : ribuan(r) + ' Ribu'));
    if (s > 0) parts.push(ribuan(s));
    return parts.join(' ');
}

function autoTerbilang() {
    var n = parseRp(document.getElementById('jumlah').value);
    if (n > 0) {
        document.getElementById('terbilang').value = terbilang(n) + ' Rupiah';
    }
}

// Listen on input
['uang_harian', 'uang_penginapan', 'biaya_transport', 'biaya_lain', 'jumlah'].forEach(function(id) {
    document.getElementById(id).addEventListener('input', updateRingkasan);
});

// Sync PPTK hidden fields on submit (robust fallback)
document.getElementById('formKwitansi').addEventListener('submit', function() {
    var sel = document.getElementById('pptk_select');
    if (sel && sel.selectedIndex > 0) {
        var opt = sel.options[sel.selectedIndex];
        document.getElementById('nama_pptk').value = opt.dataset.nama || '';
        document.getElementById('nip_pptk').value  = opt.value || '';
    }
    // Sync rekening fields
    var rSel = document.getElementById('rekening_select');
    if (rSel && rSel.selectedIndex > 0) {
        var rOpt = rSel.options[rSel.selectedIndex];
        document.getElementById('kode_rekening').value = rOpt.value || '';
        document.getElementById('bidang').value         = rOpt.dataset.bidang || '';
        document.getElementById('sub_kegiatan').value   = rOpt.dataset.sub || '';
    }
});

// Init if prefilled
updateRingkasan();
</script>

<?= view('_partials/footer') ?>
