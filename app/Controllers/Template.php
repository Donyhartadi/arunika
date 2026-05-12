<?php

namespace App\Controllers;

class Template extends BaseController
{
    protected $session;
    protected $templatePath;

    public function __construct()
    {
        $this->session = service('session');
        $this->templatePath = FCPATH . 'template/';
    }

    public function index()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        return view('template_manage', [
            'username' => $this->session->get('username'),
            'templates' => $this->getTemplateFiles(),
            'message' => $this->session->getFlashdata('message'),
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    protected function getTemplateFiles()
    {
        if (! is_dir($this->templatePath)) {
            return [];
        }

        $files = array_values(array_filter(scandir($this->templatePath), function ($file) {
            return ! in_array($file, ['.', '..']) && is_file($this->templatePath . $file) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'docx';
        }));

        sort($files);

        return array_map(function ($file) {
            return [
                'name' => $file,
                'size' => filesize($this->templatePath . $file),
                'modified' => filemtime($this->templatePath . $file),
            ];
        }, $files);
    }

    public function upload()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        $file = $this->request->getFile('template_file');

        if (! $file || ! $file->isValid()) {
            return redirect()->to('/template/manage')->with('error', 'Harap pilih berkas template yang valid.');
        }

        $extension = strtolower($file->getClientExtension());
        if ($extension !== 'docx') {
            return redirect()->to('/template/manage')->with('error', 'Hanya file .docx yang diizinkan.');
        }

        $allowedMimes = [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip',
            'application/octet-stream',
        ];
        if (!in_array($file->getMimeType(), $allowedMimes, true)) {
            return redirect()->to('/template/manage')->with('error', 'Tipe file tidak valid.');
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            return redirect()->to('/template/manage')->with('error', 'Ukuran file maksimal 10 MB.');
        }

        $filename = basename($file->getClientName());
        $filename = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $filename);
        $filename = trim($filename);

        if (empty($filename)) {
            return redirect()->to('/template/manage')->with('error', 'Nama file tidak valid.');
        }

        if (! file_exists($this->templatePath) && ! mkdir($this->templatePath, 0755, true)) {
            return redirect()->to('/template/manage')->with('error', 'Gagal membuat folder template.');
        }

        if ($file->move($this->templatePath, $filename, true)) {
            return redirect()->to('/template/manage')->with('message', 'Template berhasil diunggah.');
        }

        return redirect()->to('/template/manage')->with('error', 'Gagal menyimpan file template.');
    }

    public function replace()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        $replaceName = $this->request->getPost('replace_name');
        $file = $this->request->getFile('template_file');

        if (! $replaceName || ! $file || ! $file->isValid()) {
            return redirect()->to('/template/manage')->with('error', 'Harap pilih template dan berkas yang valid.');
        }

        $replaceName = basename($replaceName);
        $extension = strtolower($file->getClientExtension());
        if ($extension !== 'docx') {
            return redirect()->to('/template/manage')->with('error', 'Hanya file .docx yang diizinkan.');
        }

        $allowedMimes = [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip',
            'application/octet-stream',
        ];
        if (!in_array($file->getMimeType(), $allowedMimes, true)) {
            return redirect()->to('/template/manage')->with('error', 'Tipe file tidak valid.');
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            return redirect()->to('/template/manage')->with('error', 'Ukuran file maksimal 10 MB.');
        }

        $existingPath = $this->templatePath . $replaceName;
        if (! file_exists($existingPath) || ! is_file($existingPath)) {
            return redirect()->to('/template/manage')->with('error', 'Template yang akan diganti tidak ditemukan.');
        }

        if ($file->move($this->templatePath, $replaceName, true)) {
            return redirect()->to('/template/manage')->with('message', 'Template berhasil diganti.');
        }

        return redirect()->to('/template/manage')->with('error', 'Gagal mengganti template.');
    }

    public function preview($filename = null)
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        if (! $filename) {
            return redirect()->to('/template/manage')->with('error', 'Nama template tidak ditemukan.');
        }

        $filename = basename($filename);
        $filePath = $this->templatePath . $filename;

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return redirect()->to('/template/manage')->with('error', 'Template tidak ditemukan.');
        }

        $content = $this->extractDocxHtml($filePath);

        return view('template_preview', [
            'username' => $this->session->get('username'),
            'name' => $filename,
            'content' => $content,
        ]);
    }

    protected function extractDocxHtml(string $path): string
    {
        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
            $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            ob_start();
            $writer->save('php://output');
            $html = ob_get_clean();

            if ($html) {
                return $html;
            }
        } catch (\Throwable $e) {
            // fallback to plain text extraction
        }

        return '<div style="white-space: pre-wrap; font-family: Inter, system-ui, sans-serif;">' . htmlspecialchars($this->extractDocxText($path), ENT_QUOTES) . '</div>';
    }

    protected function extractDocxText(string $path): string
    {
        $zip = new \ZipArchive();
        $text = '';

        if ($zip->open($path) === true) {
            $xml = $zip->getFromName('word/document.xml');
            $zip->close();

            if ($xml !== false) {
                $text = preg_replace('/<w:p[^>]*>/', "\n\n", $xml);
                $text = preg_replace('/<w:tab[^>]*\/>/', "\t", $text);
                $text = preg_replace('/<[^>]+>/', '', $text);
                $text = htmlspecialchars_decode($text, ENT_QUOTES);
                $text = trim($text);
            }
        }

        return $text;
    }

    public function edit($filename = null)
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        if (! $filename) {
            return redirect()->to('/template/manage')->with('error', 'Nama template tidak ditemukan.');
        }

        $filename = basename($filename);
        $filePath = $this->templatePath . $filename;

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return redirect()->to('/template/manage')->with('error', 'Template tidak ditemukan.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return redirect()->to('/template/manage')->with('error', 'Gagal membuka file template.');
        }

        $xmlContent = $zip->getFromName('word/document.xml');
        $zip->close();

        if ($xmlContent === false) {
            return redirect()->to('/template/manage')->with('error', 'Gagal membaca isi template.');
        }

        return view('template_edit', [
            'username' => $this->session->get('username'),
            'name'     => $filename,
            'xml'      => $xmlContent,
            'message'  => $this->session->getFlashdata('message'),
            'error'    => $this->session->getFlashdata('error'),
        ]);
    }

    public function saveEdit()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        $filename = $this->request->getPost('filename');
        $xmlContent = $this->request->getPost('xml_content');

        if (! $filename || $xmlContent === null) {
            return redirect()->to('/template/manage')->with('error', 'Data tidak lengkap.');
        }

        $filename = basename($filename);
        $filePath = $this->templatePath . $filename;

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return redirect()->to('/template/manage')->with('error', 'Template tidak ditemukan.');
        }

        // Validate that the submitted content is well-formed XML
        libxml_use_internal_errors(true);
        $doc = simplexml_load_string($xmlContent);
        if ($doc === false) {
            return redirect()->to('/template/edit/' . urlencode($filename))
                ->with('error', 'XML tidak valid. Periksa kembali konten yang Anda edit.');
        }
        libxml_clear_errors();

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return redirect()->to('/template/manage')->with('error', 'Gagal membuka file template.');
        }

        $result = $zip->addFromString('word/document.xml', $xmlContent);
        $zip->close();

        if (! $result) {
            return redirect()->to('/template/edit/' . urlencode($filename))
                ->with('error', 'Gagal menyimpan perubahan.');
        }

        return redirect()->to('/template/edit/' . urlencode($filename))
            ->with('message', 'Template berhasil disimpan.');
    }

    public function download($filename = null)
    {
        if (! $filename) {
            return redirect()->to('/template/manage')->with('error', 'Nama template tidak ditemukan.');
        }

        $filename = basename($filename);
        $filePath = $this->templatePath . $filename;

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return redirect()->to('/template/manage')->with('error', 'Template tidak ditemukan.');
        }

        return $this->response->download($filePath, null);
    }
}
