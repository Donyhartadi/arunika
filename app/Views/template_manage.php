<?php
/** @var array<int, array{name: string, size: int, modified: int}> $templates */
?>
<?= view('_partials/head', ['title' => 'Manajemen Template']) ?>
    <header class="hero">
        <div style="padding-inline: 1.25rem;">
            <?= view('_partials/menu') ?>
            <div class="page-title">
                <div>
                    <div class="hero-kicker">Dokumen</div>
                    <h1>Manajemen Template</h1>
                    <p>Unggah, ganti, dan kurasi file template .docx agar proses generate selalu memakai dokumen yang tepat.</p>
                </div>
                <a class="btn btn-secondary" href="/dashboard">Kembali ke Dashboard</a>
            </div>
        </div>
    </header>

    <main class="page-body" style="padding: 1rem 1.25rem;">
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
                        <h2>Template Tersedia</h2>
                        <p class="text-small">Unggah file .docx baru, ganti file yang sudah ada, atau cek pratinjau secara langsung.</p>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="openTemplateModal('upload')">Unggah Template Baru</button>
                </div>

                <div class="table-wrap">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Diubah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($templates)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada template yang tersedia.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($templates as $template): ?>
                                    <tr>
                                        <td><?= esc($template['name']) ?></td>
                                        <td><?= number_format($template['size'] / 1024, 2) ?> KB</td>
                                        <td><?= date('d M Y H:i', $template['modified']) ?></td>
                                        <td>
                                            <a href="/template/preview/<?= urlencode($template['name']) ?>" class="btn btn-sm btn-outline-primary me-2">Pratinjau</a>
                                            <a href="/template/edit/<?= urlencode($template['name']) ?>" class="btn btn-sm btn-outline-warning me-2">Edit</a>
                                            <a href="/template/download/<?= urlencode($template['name']) ?>" class="btn btn-sm btn-outline-success me-2">Download</a>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick='openTemplateModal("replace", <?= json_encode($template['name']) ?>)'>Ganti</button>
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

    <div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateModalLabel">Unggah Template Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form method="post" action="/template/upload" enctype="multipart/form-data" id="templateForm">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="replace_name" id="replace_name" value="">
                        <div class="mb-3">
                            <label for="template_file" class="form-label">Pilih file .docx</label>
                            <input type="file" class="form-control" id="template_file" name="template_file" accept=".docx" required>
                        </div>
                        <div class="text-small text-muted">Pilih file .docx yang akan diunggah. Jika mengganti template, nama file asli akan tetap dipertahankan.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="templateSubmitButton">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= view('_partials/footer') ?>

    <script>
        function openTemplateModal(mode, filename = '') {
            var modalLabel = document.getElementById('templateModalLabel');
            var templateForm = document.getElementById('templateForm');
            var templateSubmitButton = document.getElementById('templateSubmitButton');
            var replaceInput = document.getElementById('replace_name');

            if (mode === 'replace') {
                modalLabel.textContent = 'Ganti Template';
                templateForm.action = '/template/replace';
                templateSubmitButton.textContent = 'Ganti';
                replaceInput.value = filename;
            } else {
                modalLabel.textContent = 'Unggah Template Baru';
                templateForm.action = '/template/upload';
                templateSubmitButton.textContent = 'Unggah';
                replaceInput.value = '';
            }

            document.getElementById('template_file').value = '';
            var templateModal = new bootstrap.Modal(document.getElementById('templateModal'));
            templateModal.show();
        }
    </script>
