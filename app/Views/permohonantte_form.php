<?php ob_start(); ?>
#formTTE input[type="text"],
#formTTE textarea {
    text-transform: uppercase;
}
#formTTE input[type="text"]::placeholder,
#formTTE textarea::placeholder {
    text-transform: none;
}
#formTTE .section-card { padding: 0.7rem 0.9rem; margin-bottom: 0.5rem; }
#formTTE .section-card h5 { font-size: 0.9rem; margin-bottom: 0.3rem; }
#formTTE .section-card .eyebrow { margin-bottom: 0.1rem; }
#formTTE label { font-size: 0.8rem; margin-bottom: 0.12rem; font-weight: 600; }
#formTTE .form-control { padding: 0.3rem 0.55rem; font-size: 0.875rem; }
#formTTE select.form-control { padding: 0.3rem 0.4rem; }
#formTTE .form-text { font-size: 0.72rem; margin-top: 0.1rem; }
#formTTE .row.mt-2 { margin-top: 0.4rem !important; }
#formTTE .row.mt-3 { margin-top: 0.5rem !important; }
#formTTE .mt-2 { margin-top: 0.4rem !important; }
<?php $pageStyles = ob_get_clean(); ?>
<?= view('_partials/head', ['title' => 'Form Permohonan TTE', 'pageStyles' => $pageStyles]) ?>
<header class="hero">
    <div style="padding-inline: 1.25rem;">
        <?= view('_partials/menu') ?>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-kicker">Generator Dokumen</div>
                <h1>Permohonan TTE</h1>
                <p class="meta">Buat Surat Rekomendasi Permohonan Penerbitan Sertifikat Elektronik (BSrE – BSSN RI).</p>
            </div>
            <div class="hero-action">
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</header>

<main class="page-body" style="padding: 1rem 1.25rem;">
    <form method="post" action="<?= site_url('surat/proses-tte') ?>" id="formTTE">
        <?= csrf_field() ?>

                <div class="section-card">
                    <span class="eyebrow">Bagian 1</span>
                    <h5>Data Pemohon</h5>

                    <label>Pilih Pegawai</label>
                    <select id="pegawai" name="pegawai" class="form-control mb-3">
                        <option value="">-- Pilih Pegawai (opsional) --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['nip'] ?>">
                                <?= $p['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text mb-3">Pilih pegawai untuk mengisi otomatis Nama, NIP, Pangkat, dan Jabatan. Field lainnya diisi manual.</div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip" id="nip" class="form-control" required maxlength="18" pattern="\d{18}" title="NIP harus 18 digit angka">
                            <small class="form-text" id="nipCounter">0 / 18 angka</small>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>NIK e-KTP <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka">
                            <small class="form-text" id="nikCounter">0 / 16 angka</small>
                        </div>
                        <div class="col-md-6">
                            <label>Pangkat / Golongan <span class="text-danger">*</span></label>
                            <input type="text" name="pangkat" id="pangkat" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Unit Kerja <span class="text-danger">*</span></label>
                            <input type="text" name="unit" id="unit" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <span class="eyebrow">Bagian 2</span>
                    <h5>Instansi &amp; Lokasi</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Instansi <span class="text-danger">*</span></label>
                            <input type="text" name="instansi" id="instansi" class="form-control" required value="PEMERINTAH KABUPATEN MUARA ENIM">
                        </div>
                        <div class="col-md-4">
                            <label>Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="kabupaten" id="kabupaten" class="form-control" required value="Muara Enim">
                        </div>
                        <div class="col-md-4">
                            <label>Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" id="provinsi" class="form-control" required value="Sumatera Selatan">
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <span class="eyebrow">Bagian 3</span>
                    <h5>Kontak &amp; Keperluan</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Email Dinas (domain go.id) <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="contoh@muaraenimkab.go.id">
                        </div>
                        <div class="col-md-4">
                            <label>No. Telp (HP) <span class="text-danger">*</span></label>
                            <input type="text" name="telp" id="telp" class="form-control" required placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-4">
                            <label>Bulan <span class="text-danger">*</span></label>
                            <?php
                                $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                $bulanSekarang = $bulanList[(int)date('n') - 1];
                            ?>
                            <select name="bulan" id="bulan" class="form-control" required>
                                <?php foreach ($bulanList as $b): ?>
                                    <option value="<?= $b ?>" <?= $b === $bulanSekarang ? 'selected' : '' ?>><?= $b ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label>Sistem Elektronik / Keperluan <span class="text-danger">*</span></label>
                        <select name="keperluan" id="keperluan" class="form-control" required>
                            <option value="">-- Pilih Keperluan --</option>
                            <option value="TANDA TANGAN ELEKTRONIK VERSI 6 LKPP (https://katalog.inaproc.id)">TANDA TANGAN ELEKTRONIK VERSI 6 LKPP (https://katalog.inaproc.id)</option>
                            <option value="SISTEM INFORMASI KEARSIPAN DINAMIS TERINTEGRASI (SRIKANDI)">SISTEM INFORMASI KEARSIPAN DINAMIS TERINTEGRASI (SRIKANDI)</option>
                            <option value="TANDA TANGAN ELEKTRONIK UNTUK e-OFFICE / DOKUMEN DINAS">TANDA TANGAN ELEKTRONIK UNTUK e-OFFICE / DOKUMEN DINAS</option>
                        </select>
                    </div>
                </div>

        <button type="submit" class="btn btn-custom w-100 mt-2 py-2">
                    Generate dan Unduh Surat
                </button>

            </form>
</main>

<?= view('_partials/footer') ?>

<script>
document.getElementById('pegawai').addEventListener('change', function() {
    let nip = this.value;
    if (!nip) return;

    fetch('<?= site_url('pegawai') ?>/' + nip)
    .then(res => res.json())
    .then(data => {
        document.getElementById('nama').value = (data.nama || '').toUpperCase();
        document.getElementById('nip').value = (data.nip || '').toUpperCase();
        document.getElementById('pangkat').value = (data.pangkat || '').toUpperCase();
        document.getElementById('jabatan').value = (data.jabatan || '').toUpperCase();
    })
    .catch(err => {
        console.error('Fetch pegawai gagal:', err);
    });
});

// Digit counter for NIK & NIP
function updateCounter(inputId, counterId, max) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    input.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        const len = this.value.length;
        counter.textContent = len + ' / ' + max + ' angka';
        counter.style.color = len === max ? '#198754' : (len > 0 ? '#dc3545' : '');
    });
}
updateCounter('nik', 'nikCounter', 16);
updateCounter('nip', 'nipCounter', 18);

// Force uppercase real-time on all text inputs & textarea
document.getElementById('formTTE').querySelectorAll('input[type="text"], textarea').forEach(function(el) {
    el.addEventListener('input', function() {
        var pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });
});

// Also force uppercase on submit (safety net)
document.getElementById('formTTE').addEventListener('submit', function() {
    this.querySelectorAll('input[type="text"], textarea').forEach(el => {
        el.value = el.value.toUpperCase();
    });
});
</script>
