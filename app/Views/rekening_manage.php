<?= view('_partials/head', ['title' => 'Manajemen Kode Rekening']) ?>
    <header class="hero">
        <div style="padding-inline: 1.25rem;">
            <?= view('_partials/menu') ?>
            <div class="page-title">
                <div>
                    <div class="hero-kicker">Master Data</div>
                    <h1>Manajemen Kode Rekening</h1>
                    <p>Tambah, edit, dan rapikan kode rekening yang dipakai pada proses generate surat.</p>
                </div>
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </header>

    <main class="page-body" style="padding: 1rem 1.25rem;">
        <?php $isEdit = ! empty($editRekening); ?>
        <div class="card">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success" role="alert"><?php echo esc($message); ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert"><?php echo esc($error); ?></div>
            <?php endif; ?>

            <div class="section-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div>
                        <h2>Daftar Kode Rekening</h2>
                        <p class="text-muted">Total referensi aktif: <?php echo count($rekening); ?></p>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="openRekeningModal()">Tambah Kode Rekening</button>
                </div>
                <div class="table-wrap">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Rekening</th>
                                <th>No Rekening</th>
                                <th>Bidang</th>
                                <th>Sub Kegiatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rekening)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data rekening.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rekening as $r): ?>
                                    <tr>
                                        <td><?= esc($r['id_rekening']) ?></td>
                                        <td><?= esc($r['nama_rekening']) ?></td>
                                        <td><?= esc($r['no_rekening']) ?></td>
                                        <td><?= esc($r['bidang'] ?? '-') ?></td>
                                        <td style="max-width:220px;white-space:normal;font-size:0.82rem;"><?= esc($r['sub_kegiatan'] ?? '-') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary me-2" onclick='openRekeningModal(<?= esc($r['id_rekening']) ?>, <?= json_encode($r['nama_rekening']) ?>, <?= json_encode($r['no_rekening']) ?>, <?= json_encode($r['bidang'] ?? '') ?>, <?= json_encode($r['sub_kegiatan'] ?? '') ?>)'>Edit</button>
                                            <form method="post" action="/rekening/delete/<?= esc($r['id_rekening']) ?>" style="display:inline;" onsubmit="return confirm('Hapus kode rekening ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <div class="modal fade" id="rekeningModal" tabindex="-1" aria-labelledby="rekeningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rekeningModalLabel">Tambah Kode Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form method="post" action="/rekening/save" id="rekeningForm">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="original_id" id="original_id" value="<?= esc(old('original_id') ?? ($editRekening['id_rekening'] ?? '')) ?>">

                        <div class="mb-3">
                            <label for="modal_nama_rekening" class="form-label">Nama Rekening</label>
                            <input type="text" id="modal_nama_rekening" name="nama_rekening" class="form-control" placeholder="Contoh: Kode Rekening Rutin" required value="<?= esc(old('nama_rekening') ?? ($editRekening['nama_rekening'] ?? '')) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="modal_no_rekening" class="form-label">No Rekening</label>
                            <input type="text" id="modal_no_rekening" name="no_rekening" class="form-control" placeholder="Contoh: 2.16.01.2.06.0009.5.1.02.04.001.00001" required value="<?= esc(old('no_rekening') ?? ($editRekening['no_rekening'] ?? '')) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="modal_bidang" class="form-label">Bidang</label>
                            <input type="text" id="modal_bidang" name="bidang" class="form-control" placeholder="Contoh: Persandian dan Keamanan Informasi" value="<?= esc(old('bidang') ?? ($editRekening['bidang'] ?? '')) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="modal_sub_kegiatan" class="form-label">Sub Kegiatan</label>
                            <textarea id="modal_sub_kegiatan" name="sub_kegiatan" class="form-control" rows="3" placeholder="Contoh: Pelaksanaan Keamanan Informasi Pemerintahan Daerah..."><?= esc(old('sub_kegiatan') ?? ($editRekening['sub_kegiatan'] ?? '')) ?></textarea>
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
        function openRekeningModal(id = '', nama = '', noRekening = '', bidang = '', subKegiatan = '') {
            const modalTitle = document.getElementById('rekeningModalLabel');
            const submitButton = document.getElementById('modalSubmitButton');
            const originalInput = document.getElementById('original_id');
            const namaInput = document.getElementById('modal_nama_rekening');
            const noInput = document.getElementById('modal_no_rekening');
            const bidangInput = document.getElementById('modal_bidang');
            const subKegiatanInput = document.getElementById('modal_sub_kegiatan');

            if (id) {
                modalTitle.textContent = 'Edit Kode Rekening';
                submitButton.textContent = 'Perbarui';
                originalInput.value = id;
                namaInput.value = nama;
                noInput.value = noRekening;
                bidangInput.value = bidang;
                subKegiatanInput.value = subKegiatan;
            } else {
                modalTitle.textContent = 'Tambah Kode Rekening';
                submitButton.textContent = 'Simpan';
                document.getElementById("rekeningForm").reset();
                originalInput.value = '';
            }

            let modalEl = document.getElementById('rekeningModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var hasOldInput = <?= !empty(old('nama_rekening')) || !empty(old('no_rekening')) ? 'true' : 'false' ?>;
            var isEditMode = <?= $isEdit ? 'true' : 'false' ?>;

            if (hasOldInput || isEditMode) {
                var editId = <?= $isEdit ? json_encode($editRekening['id_rekening']) : '""' ?>;
                var editNama = <?= $isEdit ? json_encode($editRekening['nama_rekening']) : '""' ?>;
                var editNo = <?= $isEdit ? json_encode($editRekening['no_rekening']) : '""' ?>;
                var editBidang = <?= $isEdit ? json_encode($editRekening['bidang'] ?? '') : '""' ?>;
                var editSubKegiatan = <?= $isEdit ? json_encode($editRekening['sub_kegiatan'] ?? '') : '""' ?>;

                if (isEditMode) {
                    openRekeningModal(editId, editNama, editNo, editBidang, editSubKegiatan);
                } else {
                    openRekeningModal();
                }
            }
        });
    </script>
