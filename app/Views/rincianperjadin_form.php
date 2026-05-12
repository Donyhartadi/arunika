<?php ob_start(); ?>
#formRincian .section-card { padding: 0.75rem; margin-bottom: 0.5rem; }
#formRincian .section-card h5 { margin-bottom: 0.4rem; font-size: 0.95rem; }
#formRincian .section-card .eyebrow { margin-bottom: 0.1rem; }
#formRincian .row.mt-3 { margin-top: 0.5rem !important; }
#formRincian .form-control { padding: 0.3rem 0.55rem; font-size: 0.88rem; }
#formRincian label { margin-bottom: 0.15rem; font-size: 0.82rem; }
#formRincian .form-text { font-size: 0.72rem; margin-top: 0.1rem; }
#formRincian select.form-control { padding: 0.3rem 0.4rem; font-size: 0.88rem; }
#formRincian .form-check-label { font-size: 0.85rem; }
#formRincian textarea.form-control { padding: 0.4rem 0.55rem; }
<?php $pageStyles = ob_get_clean();

// Helper: format nilai ke label Rupiah singkat (e.g. 150000 -> "150.000")
$s = $settings ?? [];
$fmt = fn(int $v) => number_format($v, 0, ',', '.');

$harian_dalam           = (int)($s['harian_dalam_daerah'] ?? 150000);
$harian_luar_dalam      = (int)($s['harian_luar_daerah_dalam_provinsi'] ?? 380000);
$harian_luar_luar       = (int)($s['harian_luar_daerah_luar_provinsi'] ?? 380000);

$bbm_pertalite          = (int)($s['bbm_pertalite']      ?? 10000);
$bbm_pertamax           = (int)($s['bbm_pertamax']       ?? 12950);
$bbm_pertamax_green     = (int)($s['bbm_pertamax_green'] ?? 13900);
$bbm_pertamax_turbo     = (int)($s['bbm_pertamax_turbo'] ?? 14400);
$bbm_dexlite            = (int)($s['bbm_dexlite']        ?? 13950);
$bbm_solar              = (int)($s['bbm_solar']          ?? 6800);

$pagu_dalam_C1              = (int)($s['pagu_dalam_daerah_C1'] ?? 0);
$pagu_dalam_C2              = (int)($s['pagu_dalam_daerah_C2'] ?? 0);
$pagu_dalam_C3              = (int)($s['pagu_dalam_daerah_C3'] ?? 0);
$pagu_luar_dalam_C1         = (int)($s['pagu_luar_daerah_dalam_provinsi_C1'] ?? 1955000);
$pagu_luar_dalam_C2         = (int)($s['pagu_luar_daerah_dalam_provinsi_C2'] ?? 861000);
$pagu_luar_dalam_C3         = (int)($s['pagu_luar_daerah_dalam_provinsi_C3'] ?? 861000);
$pagu_luar_luar_C1          = (int)($s['pagu_luar_daerah_luar_provinsi_C1'] ?? 1955000);
$pagu_luar_luar_C2          = (int)($s['pagu_luar_daerah_luar_provinsi_C2'] ?? 861000);
$pagu_luar_luar_C3          = (int)($s['pagu_luar_daerah_luar_provinsi_C3'] ?? 861000);
?>
<?= view('_partials/head', ['title' => 'Form Rincian Perjalanan Dinas', 'pageStyles' => $pageStyles]) ?>

<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Generator Dokumen</div>
                <h1>Rincian Perjalanan Dinas</h1>
                <p class="meta">Buat dokumen rincian biaya perjalanan dinas beserta perhitungan BBM dan uang harian.</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <form method="post" action="<?= site_url('surat/proses-rincian') ?>" id="formRincian">
                <?= csrf_field() ?>
                <?php if (!empty($parent_log_id)): ?>
                <input type="hidden" name="parent_log_id" value="<?= (int) $parent_log_id ?>">
                <?php endif; ?>

                <?php $pf = $prefill ?? []; ?>

                <!-- KATEGORI & DESKRIPSI PERJALANAN -->
                <div class="section-card">
                    <span class="eyebrow">Kategori &amp; Deskripsi</span>
                    <h5>Jenis Perjalanan Dinas</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="dalam_daerah" data-harian="<?= $harian_dalam ?>">Dalam Daerah (Rp <?= $fmt($harian_dalam) ?>)</option>
                                <option value="luar_daerah_dalam_provinsi" data-harian="<?= $harian_luar_dalam ?>">Luar Daerah Dalam Provinsi (Rp <?= $fmt($harian_luar_dalam) ?>)</option>
                                <option value="luar_daerah_luar_provinsi" data-harian="<?= $harian_luar_luar ?>">Luar Daerah Luar Provinsi (Rp <?= $fmt($harian_luar_luar) ?>)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Jumlah Hari <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_hari" id="jumlah_hari" class="form-control" required min="1" value="<?= (int) preg_replace('/[^0-9]/', '', $pf['lama'] ?? '1') ?>" placeholder="3">
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal" id="tanggal" class="form-control" required placeholder="9 Maret 2026" value="<?= esc($pf['tanggal'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end" style="padding-bottom:0.25rem;">
                            <div class="form-check">
                                <input type="checkbox" name="pakai_penginapan" id="pakai_penginapan" class="form-check-input" value="1">
                                <label class="form-check-label" for="pakai_penginapan"><strong>Termasuk Penginapan</strong></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 g-2" id="tarif_harian_row" style="display:none;">
                        <div class="col-md-5">
                            <label>Provinsi Tujuan <small class="text-muted">(pilih untuk auto-isi tarif)</small></label>
                            <select id="provinsi_tujuan" class="form-control" style="font-size:0.86rem;">
                                <option value="">-- Pilih Provinsi --</option>
                                <?php foreach ($tarif_provinsi ?? [] as $prov): ?>
                                <option value="<?= esc($prov['nilai']) ?>"><?= esc($prov['label']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tarif Harian <small class="text-muted">(dapat diubah manual)</small></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="tarif_harian_override" class="form-control" min="0" step="1000" placeholder="380000">
                            </div>
                            <div class="form-text" style="font-size:0.7rem;">Dari pengaturan/provinsi — ubah jika perlu.</div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <textarea name="daftar" id="daftar" class="form-control" rows="2" required placeholder="Contoh: Permintaan Biaya Perjalanan Dinas [Kategori] Dalam rangka ..."><?= esc($pf['daftar'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- PEGAWAI 1 -->
                <div class="section-card">
                    <span class="eyebrow">Pegawai 1 — Penerima Uang</span>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Pilih Pegawai <span class="text-danger">*</span></label>
                            <select name="pegawai_1_select" id="pegawai_1_select" class="form-control">
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= esc($p['nip']) ?>"
                                        data-nama="<?= esc($p['nama']) ?>"
                                        data-pangkat="<?= esc($p['pangkat']) ?>"
                                        data-jabatan="<?= esc($p['jabatan']) ?>"
                                        data-tingkat="<?= esc($p['tingkat']) ?>"
                                        data-nip="<?= esc($p['nip']) ?>">
                                        <?= esc($p['nama']) ?> — <?= esc($p['nip']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama_1" id="nama_1" class="form-control" required placeholder="Nama lengkap" value="<?= esc($pf['nama_1'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat / Kedudukan <span class="text-danger">*</span></label>
                            <input type="text" name="pangkat_1" id="pangkat_1" class="form-control" required placeholder="Penata Tk. I / (III/d) Muara Enim" value="<?= esc($pf['pangkat_1'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip_penerima" id="nip_penerima" class="form-control" required placeholder="NIP" value="<?= esc($pf['nip_penerima'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Golongan Perjadin <span class="text-danger">*</span></label>
                            <input type="text" name="golongan_1" id="golongan_1" class="form-control" required placeholder="Otomatis" readonly value="<?= esc($pf['golongan_1'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Uang Harian <span class="text-danger">*</span></label>
                            <input type="text" name="uang_harian_1" id="uang_harian_1" class="form-control" required placeholder="Otomatis" readonly>
                            <input type="hidden" name="jumlah_1" id="jumlah_1">
                        </div>
                        <div class="col-md-3 penginapan-pegawai" id="penginapan_1_row" style="display:none;">
                            <label>Opsi Penginapan</label>
                            <select name="opsi_penginapan_1" id="opsi_penginapan_1" class="form-control opsi-penginapan-select" data-idx="1">
                                <option value="">-- Pilih --</option>
                                <option value="30persen">30% Pagu</option>
                                <option value="full">Pagu Penuh</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3" id="penginapan_1_detail" style="display:none;">
                        <div class="col-md-3 offset-md-6" id="biaya_hotel_1_wrap" style="display:none;">
                            <label>Biaya Hotel /Malam</label>
                            <input type="number" name="biaya_hotel_1" id="biaya_hotel_1" class="form-control biaya-hotel-input" data-idx="1" min="0" placeholder="800000">
                        </div>
                        <div class="col-md-3" id="tarif_penginapan_1_wrap">
                            <label>Tarif /Malam</label>
                            <input type="text" id="tarif_penginapan_1" class="form-control" readonly placeholder="Otomatis">
                        </div>
                    </div>
                    <input type="hidden" name="penginapan_1" id="penginapan_1_hidden">
                    <input type="hidden" name="jumlah_penginapan_1" id="jumlah_penginapan_1_hidden">
                </div>

                <!-- PEGAWAI TAMBAHAN (2, 3, 4) - Dinamis -->
                <?php $jumlahPegawai = (int)($pf['jumlah_pegawai'] ?? 1); ?>
                <input type="hidden" name="jumlah_pegawai" id="jumlah_pegawai" value="<?= $jumlahPegawai ?>">

                <?php for ($idx = 2; $idx <= 4; $idx++):
                    $show = $idx <= $jumlahPegawai;
                ?>
                <div class="section-card" id="pegawai_<?= $idx ?>_section" style="<?= $show ? '' : 'display:none;' ?>">
                    <span class="eyebrow">Pegawai <?= $idx ?>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-remove-pegawai" style="float:right;padding:0.1rem 0.5rem;font-size:0.75rem;" data-idx="<?= $idx ?>">Hapus</button>
                    </span>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Pilih Pegawai</label>
                            <select name="pegawai_<?= $idx ?>_select" id="pegawai_<?= $idx ?>_select" class="form-control pegawai-select" data-idx="<?= $idx ?>">
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= esc($p['nip']) ?>"
                                        data-nama="<?= esc($p['nama']) ?>"
                                        data-pangkat="<?= esc($p['pangkat']) ?>"
                                        data-jabatan="<?= esc($p['jabatan']) ?>"
                                        data-tingkat="<?= esc($p['tingkat']) ?>"
                                        data-nip="<?= esc($p['nip']) ?>">
                                        <?= esc($p['nama']) ?> — <?= esc($p['nip']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama_<?= $idx ?>" id="nama_<?= $idx ?>" class="form-control" placeholder="Nama lengkap" value="<?= esc($pf['nama_' . $idx] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label>Pangkat / Kedudukan <span class="text-danger">*</span></label>
                            <input type="text" name="pangkat_<?= $idx ?>" id="pangkat_<?= $idx ?>" class="form-control" placeholder="Penata Muda / (III/a) Muara Enim" value="<?= esc($pf['pangkat_' . $idx] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Golongan Perjadin <span class="text-danger">*</span></label>
                            <input type="text" name="golongan_<?= $idx ?>" id="golongan_<?= $idx ?>" class="form-control" placeholder="Otomatis" readonly value="<?= esc($pf['golongan_' . $idx] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Uang Harian <span class="text-danger">*</span></label>
                            <input type="text" name="uang_harian_<?= $idx ?>" id="uang_harian_<?= $idx ?>" class="form-control uang-harian" placeholder="Otomatis" readonly>
                            <input type="hidden" name="jumlah_<?= $idx ?>" id="jumlah_<?= $idx ?>">
                        </div>
                        <div class="col-md-3 penginapan-pegawai" id="penginapan_<?= $idx ?>_row" style="display:none;">
                            <label>Opsi Penginapan</label>
                            <select name="opsi_penginapan_<?= $idx ?>" id="opsi_penginapan_<?= $idx ?>" class="form-control opsi-penginapan-select" data-idx="<?= $idx ?>">
                                <option value="">-- Pilih --</option>
                                <option value="30persen">30% Pagu</option>
                                <option value="full">Pagu Penuh</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="tarif_penginapan_<?= $idx ?>_wrap" style="display:none;">
                            <label>Tarif /Malam</label>
                            <input type="text" id="tarif_penginapan_<?= $idx ?>" class="form-control" readonly placeholder="Otomatis">
                        </div>
                    </div>

                    <div class="row mt-3" id="penginapan_<?= $idx ?>_detail" style="display:none;">
                        <div class="col-md-3 offset-md-6" id="biaya_hotel_<?= $idx ?>_wrap" style="display:none;">
                            <label>Biaya Hotel /Malam</label>
                            <input type="number" name="biaya_hotel_<?= $idx ?>" id="biaya_hotel_<?= $idx ?>" class="form-control biaya-hotel-input" data-idx="<?= $idx ?>" min="0" placeholder="800000">
                        </div>
                    </div>
                    <input type="hidden" name="penginapan_<?= $idx ?>" id="penginapan_<?= $idx ?>_hidden">
                    <input type="hidden" name="jumlah_penginapan_<?= $idx ?>" id="jumlah_penginapan_<?= $idx ?>_hidden">
                </div>
                <?php endfor; ?>

                <div id="tambah_pegawai_section" class="mb-2" style="<?= $jumlahPegawai >= 4 ? 'display:none;' : '' ?>">
                    <button type="button" id="btn_tambah_pegawai" class="btn btn-outline-primary btn-sm">
                        + Tambah Pegawai
                    </button>
                </div>

                <!-- ALAT ANGKUT -->
                <div class="section-card">
                    <span class="eyebrow">Alat Angkut</span>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Jenis Angkut <span class="text-danger">*</span></label>
                            <select name="jenis_angkut" id="jenis_angkut" class="form-control" required>
                                <option value="kendaraan_dinas" selected>Kendaraan Dinas</option>
                                <option value="transportasi_umum">Transportasi Umum</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sub-section: Kendaraan Dinas (BBM) -->
                    <div id="angkut_kendaraan_dinas">
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <label>Plat Nomor <span class="text-danger">*</span></label>
                                <input type="text" name="plat_nomor" id="plat_nomor" class="form-control" placeholder="BG 8077 DZ" value="<?= esc($pf['plat_nomor'] ?? '') ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Jenis BBM <span class="text-danger">*</span></label>
                                <select name="jenis_bbm" id="jenis_bbm" class="form-control">
                                    <option value="">-- Pilih BBM --</option>
                                    <option value="Pertalite" data-harga="<?= $bbm_pertalite ?>">Pertalite (<?= $fmt($bbm_pertalite) ?>)</option>
                                    <option value="Pertamax" data-harga="<?= $bbm_pertamax ?>">Pertamax (<?= $fmt($bbm_pertamax) ?>)</option>
                                    <option value="Pertamax Green" data-harga="<?= $bbm_pertamax_green ?>">Pertamax Green (<?= $fmt($bbm_pertamax_green) ?>)</option>
                                    <option value="Pertamax Turbo" data-harga="<?= $bbm_pertamax_turbo ?>">Pertamax Turbo (<?= $fmt($bbm_pertamax_turbo) ?>)</option>
                                    <option value="Dexlite" data-harga="<?= $bbm_dexlite ?>">Dexlite (<?= $fmt($bbm_dexlite) ?>)</option>
                                    <option value="Solar" data-harga="<?= $bbm_solar ?>">Solar (<?= $fmt($bbm_solar) ?>)</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label>Rp/L</label>
                                <input type="text" name="harga_bbm" id="harga_bbm" class="form-control" readonly placeholder="Auto">
                            </div>
                            <div class="col-md-1">
                                <label>L Pergi <span class="text-danger">*</span></label>
                                <input type="number" name="liter_pergi" id="liter_pergi" class="form-control" min="1" placeholder="40">
                            </div>
                            <div class="col-md-1" id="liter_pulang_wrap">
                                <label>L Pulang</label>
                                <input type="number" name="liter_pulang" id="liter_pulang" class="form-control" min="1" placeholder="20">
                            </div>
                            <div class="col-md-2">
                                <label>Ket.</label>
                                <select name="ket_bbm" id="ket_bbm" class="form-control">
                                    <option value="PP" selected>PP</option>
                                    <option value="Sekali Jalan">Sekali Jalan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Total BBM</label>
                                <input type="text" name="total_bbm" id="total_bbm" class="form-control" readonly placeholder="Otomatis">
                            </div>
                        </div>
                    </div>

                    <!-- Sub-section: Transportasi Umum -->
                    <div id="angkut_transportasi_umum" style="display:none;">
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Keterangan Transportasi <span class="text-danger">*</span></label>
                                <input type="text" name="ket_transportasi" id="ket_transportasi" class="form-control" placeholder="Bus Muara Enim - Palembang PP">
                            </div>
                            <div class="col-md-4">
                                <label>Biaya (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="biaya_transportasi" id="biaya_transportasi" class="form-control" min="0" placeholder="250000">
                            </div>
                            <div class="col-md-4">
                                <label>Total</label>
                                <input type="text" id="total_transportasi_display" class="form-control" readonly placeholder="Otomatis">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rincian_bbm" id="rincian_bbm">
                </div>

                <!-- PENGINAPAN TOTAL -->
                <div class="section-card" id="penginapan_section" style="display:none;">
                    <span class="eyebrow">Penginapan</span>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Jumlah Malam <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_malam" id="jumlah_malam" class="form-control" min="1" value="1" placeholder="Malam">
                        </div>
                        <div class="col-md-3">
                            <label>Total Penginapan</label>
                            <input type="text" id="total_penginapan_display" class="form-control" readonly placeholder="Otomatis">
                        </div>
                    </div>
                </div>

                <!-- BIAYA LAIN-LAIN -->
                <div class="section-card">
                    <span class="eyebrow">Biaya Lain-lain (Opsional)</span>

                    <div class="row mb-1">
                        <div class="col-md-3"><strong>Nama Biaya</strong></div>
                        <div class="col-md-2"><strong>Harga Tiket</strong></div>
                        <div class="col-md-2"><strong>Jumlah Orang</strong></div>
                        <div class="col-md-3"><strong>Total</strong></div>
                        <div class="col-md-2"></div>
                    </div>
                    <div id="biaya_lain_container"></div>
                    <input type="hidden" name="jumlah_biaya_lain" id="jumlah_biaya_lain" value="0">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" id="btn_tambah_biaya_lain" class="btn btn-outline-primary btn-sm">
                                + Tambah Biaya Lain
                            </button>
                        </div>
                        <div class="col-md-3 offset-md-5">
                            <label>Total Biaya Lain</label>
                            <input type="text" id="total_biaya_lain_display" class="form-control" readonly placeholder="Otomatis">
                        </div>
                    </div>
                </div>

                <!-- TOTAL & TERBILANG -->
                <div class="section-card">
                    <span class="eyebrow">Total Biaya</span>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Total Biaya <span class="text-danger">*</span></label>
                            <input type="text" name="jumlah_total" id="jumlah_total" class="form-control" required readonly placeholder="Otomatis">
                        </div>
                        <div class="col-md-4">
                            <label>UM/UP (75%) <span class="text-danger">*</span></label>
                            <input type="text" name="jumlah_um" id="jumlah_um" class="form-control" required readonly placeholder="Otomatis">
                        </div>
                        <div class="col-md-4">
                            <label>Terbilang <span class="text-danger">*</span></label>
                            <input type="text" name="terbilang" id="terbilang" class="form-control" required readonly placeholder="Otomatis">
                        </div>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-custom w-100 py-2">
                        Generate Rincian Perjalanan Dinas
                    </button>
                </div>

            </form>

            <script>
            document.getElementById('formRincian').addEventListener('submit', function(e) {
                if (document.getElementById('pakai_penginapan').checked) {
                    var jmlPegawai = parseInt(document.getElementById('jumlah_pegawai').value) || 1;
                    for (var i = 1; i <= jmlPegawai; i++) {
                        var opsi = document.getElementById('opsi_penginapan_' + i);
                        if (opsi && !opsi.value) {
                            e.preventDefault();
                            alert('Silakan pilih opsi penginapan untuk Pegawai ' + i + ' terlebih dahulu.');
                            opsi.focus();
                            return false;
                        }
                    }
                }
            });
            </script>
</main>

<script>
// Auto-fill tanggal hari ini
(function() {
    var el = document.getElementById('tanggal');
    if (!el.value) {
        var bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        var now = new Date();
        el.value = now.getDate() + ' ' + bulan[now.getMonth()] + ' ' + now.getFullYear();
    }
})();

// Format angka ke format Indonesia: 150000 -> "150.000,-"
function formatRupiah(angka) {
    if (!angka || angka === 0) return '';
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',-';
}



var harianPerHari = 0; // tarif uang harian per hari

function hitungUangHarian() {
    var hari = parseInt(document.getElementById('jumlah_hari').value) || 0;
    var jmlPegawai = parseInt(document.getElementById('jumlah_pegawai').value) || 1;

    for (var i = 1; i <= jmlPegawai; i++) {
        var elHarian = document.getElementById('uang_harian_' + i);
        var elJumlah = document.getElementById('jumlah_' + i);
        if (!elHarian) continue;

        if (harianPerHari > 0 && hari > 0) {
            elHarian.value = formatRupiah(harianPerHari) + 'x ' + hari;
            var total = harianPerHari * hari;
            elJumlah.value = formatRupiah(total);
        } else {
            elHarian.value = harianPerHari > 0 ? formatRupiah(harianPerHari) : '';
            elJumlah.value = '';
        }
    }
    hitungTotal();
}

var kategoriLabels = {
    'dalam_daerah'              : 'Dalam Daerah',
    'luar_daerah_dalam_provinsi': 'Luar Daerah Dalam Provinsi',
    'luar_daerah_luar_provinsi' : 'Luar Daerah Luar Provinsi'
};

function updateDaftarPlaceholderAndContent(newLabel) {
    var daftar = document.getElementById('daftar');
    // Update placeholder
    daftar.placeholder = 'Contoh: Permintaan Biaya Perjalanan Dinas ' + newLabel + ' Dalam rangka ...';

    // Replace isi textarea jika cocok dengan pola salah satu kategori
    var current = daftar.value;
    var replaced = false;
    Object.values(kategoriLabels).forEach(function(lbl) {
        if (!replaced && current.toLowerCase().indexOf(lbl.toLowerCase()) !== -1) {
            daftar.value = current.replace(new RegExp(lbl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'i'), newLabel);
            replaced = true;
        }
    });
    // Jika textarea kosong, auto-fill dengan pola
    if (!replaced && current.trim() === '') {
        daftar.value = 'Permintaan Biaya Perjalanan Dinas ' + newLabel + ' Dalam rangka ';
    }
}

document.getElementById('kategori').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    var defaultHarian = parseInt(opt.dataset.harian) || 0;
    var isLuar = this.value === 'luar_daerah_dalam_provinsi' || this.value === 'luar_daerah_luar_provinsi';
    var overrideRow   = document.getElementById('tarif_harian_row');
    var overrideInput = document.getElementById('tarif_harian_override');
    var provSel       = document.getElementById('provinsi_tujuan');
    if (isLuar) {
        overrideRow.style.display = '';
        // Jika sudah ada provinsi dipilih, pakai tarif provinsi; jika tidak, pakai default
        var provTarif = provSel ? parseInt(provSel.value) : 0;
        overrideInput.value = provTarif > 0 ? provTarif : defaultHarian;
        harianPerHari = parseInt(overrideInput.value) || 0;
    } else {
        overrideRow.style.display = 'none';
        overrideInput.value = '';
        if (provSel) provSel.value = '';
        harianPerHari = defaultHarian;
    }
    hitungUangHarian();
    if (this.value && kategoriLabels[this.value]) {
        updateDaftarPlaceholderAndContent(kategoriLabels[this.value]);
    }
});

document.getElementById('provinsi_tujuan').addEventListener('change', function() {
    var tarif = parseInt(this.value) || 0;
    var overrideInput = document.getElementById('tarif_harian_override');
    if (tarif > 0) {
        overrideInput.value = tarif;
        harianPerHari = tarif;
        hitungUangHarian();
    }
});

document.getElementById('tarif_harian_override').addEventListener('input', function() {
    // Hapus pilihan provinsi jika user mengetik manual
    document.getElementById('provinsi_tujuan').value = '';
    harianPerHari = parseInt(this.value) || 0;
    hitungUangHarian();
});

document.getElementById('jumlah_hari').addEventListener('input', hitungUangHarian);

// Auto-fill pegawai 1
document.getElementById('pegawai_1_select').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (this.value) {
        document.getElementById('nama_1').value = opt.dataset.nama || '';
        document.getElementById('pangkat_1').value = (opt.dataset.pangkat || '') + ' Muara Enim';
        document.getElementById('nip_penerima').value = opt.dataset.nip || '';
        document.getElementById('golongan_1').value = opt.dataset.tingkat || '';
    }
    hitungPenginapan();
});

// Auto-fill pegawai 2-4 via delegated event
document.querySelectorAll('.pegawai-select').forEach(function(sel) {
    sel.addEventListener('change', function() {
        const idx = this.dataset.idx;
        const opt = this.options[this.selectedIndex];
        if (this.value) {
            document.getElementById('nama_' + idx).value = opt.dataset.nama || '';
            document.getElementById('pangkat_' + idx).value = (opt.dataset.pangkat || '') + ' Muara Enim';
            document.getElementById('golongan_' + idx).value = opt.dataset.tingkat || '';
        }
        hitungPenginapan();
    });
});

// Tambah pegawai
document.getElementById('btn_tambah_pegawai').addEventListener('click', function() {
    var count = parseInt(document.getElementById('jumlah_pegawai').value);
    var next = count + 1;
    if (next > 4) return;
    document.getElementById('pegawai_' + next + '_section').style.display = '';
    document.getElementById('jumlah_pegawai').value = next;
    // Fill uang harian × hari for new pegawai
    hitungUangHarian();
    // Pastikan baris opsi penginapan muncul untuk semua pegawai aktif jika penginapan dicentang
    if (document.getElementById('pakai_penginapan').checked) {
        togglePenginapanRows(true);
    }
    if (next >= 4) this.parentElement.style.display = 'none';
    hitungTotal();
});

// Hapus pegawai
document.querySelectorAll('.btn-remove-pegawai').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var idx = parseInt(this.dataset.idx);
        var count = parseInt(document.getElementById('jumlah_pegawai').value);
        // Hapus dari idx ke atas
        for (var i = idx; i <= 4; i++) {
            var section = document.getElementById('pegawai_' + i + '_section');
            if (!section) continue;
            section.style.display = 'none';
            // Clear fields
            var sel = document.getElementById('pegawai_' + i + '_select');
            if (sel) sel.value = '';
            ['nama_', 'pangkat_', 'golongan_', 'uang_harian_'].forEach(function(f) {
                var el = document.getElementById(f + i);
                if (el) el.value = '';
            });
            // Hide & clear penginapan row
            var pRow = document.getElementById('penginapan_' + i + '_row');
            if (pRow) pRow.style.display = 'none';
            ['penginapan_' + i + '_hidden', 'jumlah_penginapan_' + i + '_hidden'].forEach(function(fid) {
                var el = document.getElementById(fid);
                if (el) el.value = '';
            });
        }
        document.getElementById('jumlah_pegawai').value = idx - 1;
        document.getElementById('tambah_pegawai_section').style.display = '';
        hitungPenginapan();
        hitungTotal();
    });
});

// Auto-select pegawai 1 dropdown if prefill NIP exists
(function() {
    var prefillNip = '<?= esc($pf['nip_penerima'] ?? '') ?>';
    if (prefillNip) {
        var sel = document.getElementById('pegawai_1_select');
        for (var i = 0; i < sel.options.length; i++) {
            if (sel.options[i].value === prefillNip) {
                sel.selectedIndex = i;
                break;
            }
        }
    }

    // Auto-select pegawai 2-4 dropdowns if prefill NIP exists
    <?php for ($idx = 2; $idx <= 4; $idx++): ?>
    (function() {
        var nip = '<?= esc($pf['nip_' . $idx] ?? '') ?>';
        if (nip) {
            var sel = document.getElementById('pegawai_<?= $idx ?>_select');
            if (sel) {
                for (var i = 0; i < sel.options.length; i++) {
                    if (sel.options[i].value === nip) {
                        sel.selectedIndex = i;
                        break;
                    }
                }
            }
        }
    })();
    <?php endfor; ?>

    // Auto-select kategori dari prefill daftar
    var prefillDaftar = '<?= esc($pf['daftar'] ?? '') ?>';
    var katSel = document.getElementById('kategori');
    var autoKategori = null;
    if (prefillDaftar.toLowerCase().indexOf('luar daerah luar provinsi') !== -1) {
        autoKategori = 'luar_daerah_luar_provinsi';
    } else if (prefillDaftar.toLowerCase().indexOf('luar daerah dalam provinsi') !== -1) {
        autoKategori = 'luar_daerah_dalam_provinsi';
    } else if (prefillDaftar.toLowerCase().indexOf('dalam daerah') !== -1) {
        autoKategori = 'dalam_daerah';
    }
    if (autoKategori) {
        katSel.value = autoKategori;
        harianPerHari = parseInt(katSel.options[katSel.selectedIndex].dataset.harian) || 0;
        hitungUangHarian();
    }
    if (katSel.value && kategoriLabels[katSel.value]) {
        updateDaftarPlaceholderAndContent(kategoriLabels[katSel.value]);
    }
})();

// ========================
// ALAT ANGKUT TOGGLE
// ========================
document.getElementById('jenis_angkut').addEventListener('change', function() {
    var isKendaraan = this.value === 'kendaraan_dinas';
    document.getElementById('angkut_kendaraan_dinas').style.display = isKendaraan ? '' : 'none';
    document.getElementById('angkut_transportasi_umum').style.display = isKendaraan ? 'none' : '';
    hitungTotal();
});

// ========================
// BBM AUTO-CALC (Kendaraan Dinas)
// ========================
var hargaBbmPerLiter = 0;

document.getElementById('jenis_bbm').addEventListener('change', function() {
    var opt = this.options[this.selectedIndex];
    hargaBbmPerLiter = parseInt(opt.dataset.harga) || 0;
    document.getElementById('harga_bbm').value = hargaBbmPerLiter ? formatRupiah(hargaBbmPerLiter).replace(',-', '') : '';
    hitungBbm();
});

document.getElementById('liter_pergi').addEventListener('input', hitungBbm);
document.getElementById('liter_pulang').addEventListener('input', hitungBbm);
document.getElementById('ket_bbm').addEventListener('change', function() {
    var isPP = this.value === 'PP';
    document.getElementById('liter_pulang_wrap').style.display = isPP ? '' : 'none';
    if (!isPP) document.getElementById('liter_pulang').value = '';
    hitungBbm();
});

function formatAngka(n) {
    if (!n || n === 0) return '0';
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function hitungBbm() {
    var literPergi = parseInt(document.getElementById('liter_pergi').value) || 0;
    var ket = document.getElementById('ket_bbm').value;
    var isPP = ket === 'PP';
    var literPulang = isPP ? (parseInt(document.getElementById('liter_pulang').value) || 0) : 0;

    if (hargaBbmPerLiter > 0 && literPergi > 0) {
        var subPergi = hargaBbmPerLiter * literPergi;
        var total = subPergi;
        var rincian = formatAngka(hargaBbmPerLiter) + ' x ' + literPergi + '\t= ' + formatAngka(subPergi);

        if (isPP && literPulang > 0) {
            var subPulang = hargaBbmPerLiter * literPulang;
            total += subPulang;
            rincian += ' +\n' + formatAngka(hargaBbmPerLiter) + ' x ' + literPulang + '\t= ' + formatAngka(subPulang);
        }

        document.getElementById('total_bbm').value = formatRupiah(total);
        document.getElementById('rincian_bbm').value = rincian;
    } else {
        document.getElementById('total_bbm').value = '';
        document.getElementById('rincian_bbm').value = '';
    }
    hitungTotal();
}

// ========================
// TRANSPORTASI UMUM
// ========================
document.getElementById('biaya_transportasi').addEventListener('input', function() {
    var biaya = parseInt(this.value) || 0;
    document.getElementById('total_transportasi_display').value = biaya > 0 ? formatRupiah(biaya) : '';
    hitungTotal();
});

// ========================
// TOTAL & TERBILANG AUTO-CALC
// ========================

// ========================
// PENGINAPAN (OPSIONAL)
// ========================
var PAGU_PENGINAPAN = {
    'dalam_daerah':              { 'C1': <?= $pagu_dalam_C1 ?>,     'C2': <?= $pagu_dalam_C2 ?>,     'C3': <?= $pagu_dalam_C3 ?> },
    'luar_daerah_dalam_provinsi':{ 'C1': <?= $pagu_luar_dalam_C1 ?>, 'C2': <?= $pagu_luar_dalam_C2 ?>, 'C3': <?= $pagu_luar_dalam_C3 ?> },
    'luar_daerah_luar_provinsi': { 'C1': <?= $pagu_luar_luar_C1 ?>,  'C2': <?= $pagu_luar_luar_C2 ?>,  'C3': <?= $pagu_luar_luar_C3 ?> }
};

function togglePenginapanRows(show) {
    var jmlPegawai = parseInt(document.getElementById('jumlah_pegawai').value) || 1;
    for (var i = 1; i <= 4; i++) {
        var row = document.getElementById('penginapan_' + i + '_row');
        if (row) row.style.display = (show && i <= jmlPegawai) ? '' : 'none';
        var tarifWrap = document.getElementById('tarif_penginapan_' + i + '_wrap');
        if (tarifWrap) tarifWrap.style.display = (show && i <= jmlPegawai) ? '' : 'none';
        var detailRow = document.getElementById('penginapan_' + i + '_detail');
        if (detailRow) detailRow.style.display = (show && i <= jmlPegawai) ? '' : 'none';
    }
    document.getElementById('penginapan_section').style.display = show ? '' : 'none';
    if (!show) {
        // Clear penginapan hidden fields
        for (var i = 1; i <= 4; i++) {
            var h1 = document.getElementById('penginapan_' + i + '_hidden');
            var h2 = document.getElementById('jumlah_penginapan_' + i + '_hidden');
            if (h1) h1.value = '';
            if (h2) h2.value = '';
        }
    }
    hitungPenginapan();
}

document.getElementById('pakai_penginapan').addEventListener('change', function() {
    togglePenginapanRows(this.checked);
});

function getPaguForPegawai(idx) {
    var katEl = document.getElementById('kategori');
    var kat = katEl ? katEl.value : '';
    var golEl = document.getElementById('golongan_' + idx);
    var gol = golEl ? golEl.value.trim() : '';
    var katMap = PAGU_PENGINAPAN[kat] || {};
    return katMap[gol] || 0;
}

function hitungPenginapan() {
    var pakaiPenginapan = document.getElementById('pakai_penginapan').checked;
    if (!pakaiPenginapan) {
        document.getElementById('total_penginapan_display').value = '';
        hitungTotal();
        return;
    }

    var jmlPegawai = parseInt(document.getElementById('jumlah_pegawai').value) || 1;
    var jmlMalam = parseInt(document.getElementById('jumlah_malam').value) || 1;
    var totalPenginapan = 0;

    for (var i = 1; i <= jmlPegawai; i++) {
        var pagu = getPaguForPegawai(i);
        var opsi = document.getElementById('opsi_penginapan_' + i);
        var opsiVal = opsi ? opsi.value : '';
        var tarifPerMalam = 0;

        if (opsiVal === '30persen') {
            tarifPerMalam = Math.floor(pagu * 0.3);
            // Hide hotel input
            var hotelWrap = document.getElementById('biaya_hotel_' + i + '_wrap');
            if (hotelWrap) hotelWrap.style.display = 'none';
        } else {
            // Full: use hotel input, capped at pagu
            var hotelWrap = document.getElementById('biaya_hotel_' + i + '_wrap');
            if (hotelWrap) hotelWrap.style.display = '';
            var hotelInput = document.getElementById('biaya_hotel_' + i);
            var biayaHotel = hotelInput ? (parseInt(hotelInput.value) || 0) : 0;
            tarifPerMalam = Math.min(biayaHotel, pagu);
        }

        // Update tarif display
        var tarifEl = document.getElementById('tarif_penginapan_' + i);
        if (tarifEl) tarifEl.value = tarifPerMalam > 0 ? formatRupiah(tarifPerMalam) : '';

        var jumlahPerPegawai = tarifPerMalam * jmlMalam;
        totalPenginapan += jumlahPerPegawai;

        // Populate hidden fields for form submission
        var hPenginapan = document.getElementById('penginapan_' + i + '_hidden');
        var hJumlah = document.getElementById('jumlah_penginapan_' + i + '_hidden');
        if (hPenginapan) {
            if (opsiVal === '30persen' && pagu > 0) {
                hPenginapan.value = formatRupiah(pagu) + 'x 30% x ' + jmlMalam;
            } else {
                hPenginapan.value = tarifPerMalam > 0 ? (formatRupiah(tarifPerMalam) + 'x ' + jmlMalam) : '';
            }
        }
        if (hJumlah) hJumlah.value = jumlahPerPegawai > 0 ? formatRupiah(jumlahPerPegawai) : '';
    }

    document.getElementById('total_penginapan_display').value = totalPenginapan > 0 ? formatRupiah(totalPenginapan) : '';
    hitungTotal();
}

// Opsi penginapan change (30% vs full)
document.querySelectorAll('.opsi-penginapan-select').forEach(function(sel) {
    sel.addEventListener('change', hitungPenginapan);
});

// Biaya hotel input
document.querySelectorAll('.biaya-hotel-input').forEach(function(inp) {
    inp.addEventListener('input', hitungPenginapan);
});

// Jumlah malam input
document.getElementById('jumlah_malam').addEventListener('input', hitungPenginapan);

// Re-calc penginapan when kategori changes (affects pagu via golongan)
document.getElementById('kategori').addEventListener('change', function() {
    setTimeout(hitungPenginapan, 100);
});

// ========================
function parseRupiah(str) {
    if (!str) return 0;
    return parseInt(str.replace(/[^0-9]/g, '')) || 0;
}

function angkaTerbilang(angka) {
    if (angka === 0) return 'Nol Rupiah';
    var satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
    function terbilangHelper(n) {
        if (n < 12) return satuan[n];
        if (n < 20) return satuan[n - 10] + ' Belas';
        if (n < 100) return satuan[Math.floor(n / 10)] + ' Puluh' + (n % 10 > 0 ? ' ' + satuan[n % 10] : '');
        if (n < 200) return 'Seratus' + (n - 100 > 0 ? ' ' + terbilangHelper(n - 100) : '');
        if (n < 1000) return satuan[Math.floor(n / 100)] + ' Ratus' + (n % 100 > 0 ? ' ' + terbilangHelper(n % 100) : '');
        if (n < 2000) return 'Seribu' + (n - 1000 > 0 ? ' ' + terbilangHelper(n - 1000) : '');
        if (n < 1000000) return terbilangHelper(Math.floor(n / 1000)) + ' Ribu' + (n % 1000 > 0 ? ' ' + terbilangHelper(n % 1000) : '');
        if (n < 1000000000) return terbilangHelper(Math.floor(n / 1000000)) + ' Juta' + (n % 1000000 > 0 ? ' ' + terbilangHelper(n % 1000000) : '');
        if (n < 1000000000000) return terbilangHelper(Math.floor(n / 1000000000)) + ' Miliar' + (n % 1000000000 > 0 ? ' ' + terbilangHelper(n % 1000000000) : '');
        return terbilangHelper(Math.floor(n / 1000000000000)) + ' Triliun' + (n % 1000000000000 > 0 ? ' ' + terbilangHelper(n % 1000000000000) : '');
    }
    return terbilangHelper(angka) + ' Rupiah';
}

function hitungTotal() {
    var jmlPegawai = parseInt(document.getElementById('jumlah_pegawai').value) || 1;
    var total = 0;

    // Sum uang harian (jumlah_N) per pegawai
    for (var i = 1; i <= jmlPegawai; i++) {
        var el = document.getElementById('jumlah_' + i);
        if (el) total += parseRupiah(el.value);
    }

    // + Penginapan (if enabled)
    if (document.getElementById('pakai_penginapan').checked) {
        for (var i = 1; i <= jmlPegawai; i++) {
            var elP = document.getElementById('jumlah_penginapan_' + i + '_hidden');
            if (elP) total += parseRupiah(elP.value);
        }
    }

    // + Alat Angkut (BBM atau Transportasi Umum)
    var jenisAngkut = document.getElementById('jenis_angkut').value;
    if (jenisAngkut === 'kendaraan_dinas') {
        total += parseRupiah(document.getElementById('total_bbm').value);
    } else {
        total += parseInt(document.getElementById('biaya_transportasi').value) || 0;
    }

    // + Biaya Lain-lain
    var jmlBiayaLain = parseInt(document.getElementById('jumlah_biaya_lain').value) || 0;
    var totalBiayaLain = 0;
    for (var i = 1; i <= jmlBiayaLain; i++) {
        var elTotal = document.getElementById('total_lain_' + i);
        if (elTotal) totalBiayaLain += parseRupiah(elTotal.value);
    }
    total += totalBiayaLain;
    document.getElementById('total_biaya_lain_display').value = totalBiayaLain > 0 ? formatRupiah(totalBiayaLain) : '';

    if (total > 0) {
        document.getElementById('jumlah_total').value = formatRupiah(total);
        var um = Math.floor(total * 0.75);
        document.getElementById('jumlah_um').value = formatRupiah(um);
        document.getElementById('terbilang').value = angkaTerbilang(total);
    } else {
        document.getElementById('jumlah_total').value = '';
        document.getElementById('jumlah_um').value = '';
        document.getElementById('terbilang').value = '';
    }
}

// ========================
// BIAYA LAIN-LAIN (DINAMIS)
// ========================
var biayaLainCounter = 0;

document.getElementById('btn_tambah_biaya_lain').addEventListener('click', function() {
    biayaLainCounter++;
    var idx = biayaLainCounter;
    document.getElementById('jumlah_biaya_lain').value = idx;

    var row = document.createElement('div');
    row.className = 'row mt-2 biaya-lain-row';
    row.id = 'biaya_lain_row_' + idx;
    row.innerHTML =
        '<div class="col-md-3">' +
            '<input type="text" name="ket_lain_' + idx + '" id="ket_lain_' + idx + '" class="form-control" placeholder="Tiket Kereta Api PP">' +
        '</div>' +
        '<div class="col-md-2">' +
            '<input type="number" name="nominal_lain_' + idx + '" id="nominal_lain_' + idx + '" class="form-control nominal-lain-input" min="0" placeholder="250000">' +
        '</div>' +
        '<div class="col-md-2">' +
            '<input type="number" name="jumlah_orang_lain_' + idx + '" id="jumlah_orang_lain_' + idx + '" class="form-control jumlah-orang-lain-input" min="1" value="1" placeholder="1">' +
        '</div>' +
        '<div class="col-md-3">' +
            '<input type="text" name="total_lain_' + idx + '" id="total_lain_' + idx + '" class="form-control total-lain-input" readonly placeholder="Total">' +
        '</div>' +
        '<div class="col-md-2 d-flex align-items-center">' +
            '<button type="button" class="btn btn-outline-danger btn-sm btn-hapus-biaya-lain" data-idx="' + idx + '">Hapus</button>' +
        '</div>';

    document.getElementById('biaya_lain_container').appendChild(row);

    // Bind events for new inputs
    document.getElementById('nominal_lain_' + idx).addEventListener('input', function() { hitungTotalBiayaLain(idx); hitungTotal(); });
    document.getElementById('jumlah_orang_lain_' + idx).addEventListener('input', function() { hitungTotalBiayaLain(idx); hitungTotal(); });
    // Inisialisasi total pertama kali
    hitungTotalBiayaLain(idx);
    row.querySelector('.btn-hapus-biaya-lain').addEventListener('click', function() {
        row.remove();
        reindexBiayaLain();
        hitungTotal();
    });
});

function hitungTotalBiayaLain(idx) {
    var harga = parseInt(document.getElementById('nominal_lain_' + idx)?.value) || 0;
    var orang = parseInt(document.getElementById('jumlah_orang_lain_' + idx)?.value) || 1;
    var total = harga * orang;
    document.getElementById('total_lain_' + idx).value = total > 0 ? formatRupiah(total) : '';
}

function reindexBiayaLain() {
    var rows = document.querySelectorAll('.biaya-lain-row');
    biayaLainCounter = rows.length;
    document.getElementById('jumlah_biaya_lain').value = biayaLainCounter;
    rows.forEach(function(row, i) {
        var newIdx = i + 1;
        row.id = 'biaya_lain_row_' + newIdx;
        var ketInput = row.querySelector('input[name^="ket_lain_"]');
        var nominalInput = row.querySelector('input[name^="nominal_lain_"]');
        var jumlahOrangInput = row.querySelector('input[name^="jumlah_orang_lain_"]');
        var totalInput = row.querySelector('input[name^="total_lain_"]');
        ketInput.name = 'ket_lain_' + newIdx;
        ketInput.id = 'ket_lain_' + newIdx;
        nominalInput.name = 'nominal_lain_' + newIdx;
        nominalInput.id = 'nominal_lain_' + newIdx;
        jumlahOrangInput.name = 'jumlah_orang_lain_' + newIdx;
        jumlahOrangInput.id = 'jumlah_orang_lain_' + newIdx;
        totalInput.name = 'total_lain_' + newIdx;
        totalInput.id = 'total_lain_' + newIdx;
        row.querySelector('.btn-hapus-biaya-lain').dataset.idx = newIdx;
    });
}
</script>

<?= view('_partials/footer') ?>
