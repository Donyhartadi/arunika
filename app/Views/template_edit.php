<?= view('_partials/head', ['title' => 'Edit Template - ' . esc($name)]) ?>
    <header class="hero">
        <div style="padding-inline: 1.25rem;">
            <?= view('_partials/menu') ?>
            <div class="page-title">
                <div>
                    <div class="hero-kicker">Edit Dokumen</div>
                    <h1>Edit Template</h1>
                    <p>Ubah isi XML template secara langsung. Placeholder seperti <code>${nama_placeholder}</code> dapat diedit di sini.</p>
                </div>
                <a class="btn btn-secondary" href="/template/manage">Kembali ke Manajemen Template</a>
            </div>
        </div>
    </header>

    <main class="page-body" style="padding: 1rem 1.25rem;">
        <div class="card">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success" role="alert"><?= esc($message) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert"><?= esc($error) ?></div>
            <?php endif; ?>

            <span class="eyebrow">Dokumen Aktif</span>
            <h2><?= esc($name) ?></h2>
            <p class="text-small">
                Edit konten XML file <code>word/document.xml</code> dari template ini.
                Pastikan XML tetap valid sebelum menyimpan.
                Gunakan <strong>Ctrl+H</strong> untuk find &amp; replace di editor.
            </p>

            <form method="post" action="/template/saveEdit" id="editForm">
                <?= csrf_field() ?>
                <input type="hidden" name="filename" value="<?= esc($name) ?>">

                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;">
                        <input type="text" id="searchInput" placeholder="Cari teks..." class="form-control" style="max-width: 260px;">
                        <input type="text" id="replaceInput" placeholder="Ganti dengan..." class="form-control" style="max-width: 260px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="doReplace()">Ganti Semua</button>
                        <span id="replaceInfo" style="font-size: 0.85rem; color: var(--color-muted, #666);"></span>
                    </div>
                </div>

                <textarea
                    name="xml_content"
                    id="xmlEditor"
                    spellcheck="false"
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    style="
                        width: 100%;
                        height: 600px;
                        font-family: 'Cascadia Code', 'Fira Mono', 'Consolas', monospace;
                        font-size: 0.82rem;
                        line-height: 1.5;
                        padding: 1rem;
                        border: 1px solid #ccc;
                        border-radius: 6px;
                        background: #1e1e1e;
                        color: #d4d4d4;
                        resize: vertical;
                        tab-size: 2;
                        white-space: pre;
                        overflow-wrap: normal;
                        overflow-x: auto;
                    "
                ><?= esc($xml) ?></textarea>

                <div style="display: flex; gap: 0.75rem; margin-top: 1rem; align-items: center;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="/template/preview/<?= urlencode($name) ?>" class="btn btn-outline-secondary" target="_blank">Pratinjau</a>
                    <span style="font-size: 0.82rem; color: var(--color-muted, #666);" id="charCount"></span>
                </div>
            </form>
        </div>
    </main>

    <script>
        const editor = document.getElementById('xmlEditor');
        const charCount = document.getElementById('charCount');

        function updateCount() {
            charCount.textContent = editor.value.length.toLocaleString() + ' karakter';
        }
        editor.addEventListener('input', updateCount);
        updateCount();

        // Tab key inserts spaces instead of changing focus
        editor.addEventListener('keydown', function (e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + '  ' + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 2;
                updateCount();
            }
        });

        // Find & Replace
        function doReplace() {
            const search = document.getElementById('searchInput').value;
            const replace = document.getElementById('replaceInput').value;
            const info = document.getElementById('replaceInfo');

            if (!search) {
                info.textContent = 'Masukkan teks yang dicari.';
                return;
            }

            const escaped = search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const regex = new RegExp(escaped, 'g');
            const matches = (editor.value.match(regex) || []).length;

            if (matches === 0) {
                info.textContent = 'Teks tidak ditemukan.';
                return;
            }

            editor.value = editor.value.replace(regex, replace);
            info.textContent = matches + ' penggantian berhasil.';
            updateCount();
        }

        document.getElementById('searchInput').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); doReplace(); }
        });

        // Warn before leaving with unsaved changes
        let savedValue = editor.value;
        document.getElementById('editForm').addEventListener('submit', function () {
            savedValue = editor.value;
        });
        window.addEventListener('beforeunload', function (e) {
            if (editor.value !== savedValue) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
<?= view('_partials/footer') ?>
