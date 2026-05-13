<?= view('_partials/head', ['title' => 'Proses Generate Surat']) ?>
    <header class="hero hero-mini">
        <div class="container">
            <?= view('_partials/menu') ?>
        </div>
    </header>
    <div class="page-wrapper">
        <div class="card p-5 processing-card">
            <div class="mb-4 text-center">
                <div class="eyebrow">Generate Dokumen</div>
                <h1 class="h3 mb-2">Sedang memproses surat</h1>
                <p class="text-muted mb-0">Halaman ini menggantikan form saat proses generate berjalan.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc($error) ?>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= site_url('surat') ?>" class="btn btn-secondary">Kembali ke Form Surat</a>
                </div>
            <?php else: ?>
                <div class="text-center mb-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="lead mb-3">Surat Anda sedang disiapkan. Jika unduhan tidak muncul secara otomatis, klik tombol di bawah.</p>
                    <a id="manualDownload" href="<?= esc($downloadUrl ?? '#') ?>" class="btn btn-primary btn-lg">Unduh Surat</a>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= site_url('surat/history') ?>" class="btn btn-link">Kembali ke Histori Surat</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const downloadUrl = '<?= esc($downloadUrl ?? '', 'js') ?>';
            if (downloadUrl) {
                setTimeout(function() {
                    window.location.href = downloadUrl;
                }, 1200);
            }
        });
    </script>
<?= view('_partials/footer') ?>
