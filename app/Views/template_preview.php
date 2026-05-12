<?php
/** @var string $name */
/** @var string $content */
/** @var string $username */
?>
<?= view('_partials/head', ['title' => 'Pratinjau Template - ' . esc($name)]) ?>
    <header class="hero">
        <div style="padding-inline: 1.25rem;">
            <?= view('_partials/menu') ?>
            <div class="page-title">
                <div>
                    <div class="hero-kicker">Preview Dokumen</div>
                    <h1>Pratinjau Template</h1>
                    <p>Lihat isi template tanpa perlu mengunduh file agar proses pengecekan lebih cepat.</p>
                </div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
                    <a class="btn btn-outline-secondary" href="/template/edit/<?= urlencode($name) ?>">Edit Template</a>
                    <a class="btn btn-secondary" href="/template/manage">Kembali ke Manajemen Template</a>
                </div>
            </div>
        </div>
    </header>

    <main class="page-body" style="padding: 1rem 1.25rem;">
        <div class="card">
            <span class="eyebrow">Dokumen Aktif</span>
            <h2><?= esc($name) ?></h2>
            <p class="text-small">Render langsung di browser seperti tampilan Microsoft Word.</p>

            <div id="docx-loading" style="padding:2rem;text-align:center;color:var(--color-muted,#666);">
                Memuat dokumen&hellip;
            </div>
            <div id="docx-error" style="display:none;padding:1rem;" class="alert alert-danger"></div>
            <div id="docx-container" style="
                background: #e0e0e0;
                padding: 2rem;
                border-radius: 6px;
                overflow-x: auto;
            "></div>
        </div>
    </main>

    <script src="/assets/js/docx-bundle.js"></script>
    <script>
        (async function () {
            const loading  = document.getElementById('docx-loading');
            const errorBox = document.getElementById('docx-error');
            const container = document.getElementById('docx-container');
            const url = '/template/download/<?= urlencode($name) ?>';

            if (typeof window.docx === 'undefined' || typeof window.docx.renderAsync !== 'function') {
                loading.style.display = 'none';
                errorBox.style.display = '';
                errorBox.textContent = 'Library docx-preview gagal dimuat. Coba refresh halaman (Ctrl+Shift+R).';
                return;
            }

            try {
                const res = await fetch(url);
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const blob = await res.blob();

                loading.style.display = 'none';

                await window.docx.renderAsync(blob, container, null, {
                    className: 'docx-render',
                    inWrapper: true,
                    ignoreWidth: false,
                    ignoreHeight: false,
                    ignoreFonts: false,
                    breakPages: true,
                    useBase64URL: true,
                    renderHeaders: true,
                    renderFooters: true,
                    renderFootnotes: true,
                });
            } catch (err) {
                loading.style.display = 'none';
                errorBox.style.display = '';
                errorBox.textContent = 'Gagal memuat dokumen: ' + err.message;
            }
        })();
    </script>

    <style>
        .docx-render section.docx {
            box-shadow: 0 2px 12px rgba(0,0,0,.18);
            margin: 0 auto 2rem;
        }
    </style>
<?= view('_partials/footer') ?>
