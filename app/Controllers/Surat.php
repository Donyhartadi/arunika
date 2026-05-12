<?php

namespace App\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Settings;
use App\Models\PegawaiModel;
use App\Models\RekeningModel;
use App\Models\SuratLogModel;
use App\Models\PengaturanPerjadinModel;
use App\Models\DasarSuratModel;
use App\Models\ParafHirarkiModel;

class Surat extends BaseController
{
    // tampilkan form
    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $rekeningModel = new RekeningModel();
        $parafModel = new ParafHirarkiModel();

        return view('surat_form', [
            'pegawai'       => $pegawaiModel->orderBy('nama', 'ASC')->findAll(),
            'rekening'      => $rekeningModel->findAll(),
            'paraf_default' => $parafModel->getAll(),
        ]);
    }

    // API ambil data pegawai
    public function getPegawai($nip)
    {
        $nip = trim($nip ?? '');
        if ($nip === '') {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'NIP tidak valid.']);
        }

        $pegawaiModel = new PegawaiModel();
        $data = $pegawaiModel->where('nip', $nip)->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Pegawai tidak ditemukan.']);
        }

        return $this->response->setJSON($data);
    }

    public function cetak()
    {
        try {
            $result = $this->generateSurat($this->request->getPost());
            return $this->response->download($result['savePath'], null);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal generate surat: ' . esc($e->getMessage()),
            ]);
        }
    }

    public function proses()
    {
        try {
            $result = $this->generateSurat($this->request->getPost());
            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename' => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memproses surat: ' . esc($e->getMessage()),
            ]);
        }
    }

    public function download($filename)
    {
        if (!preg_match('/^[A-Za-z0-9_\-]+\.docx$/', $filename)) {
            return redirect()->back()->with('error', 'Nama file tidak valid.');
        }

        $filePath = WRITEPATH . 'uploads/' . $filename;
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan.');
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Serve a DOCX file inline (no Content-Disposition: attachment)
     * Used by the client-side Word-like previewer (Mammoth.js).
     */
    public function serveDocx($filename)
    {
        if (!preg_match('/^[A-Za-z0-9_\-]+\.docx$/', $filename)) {
            return $this->response->setStatusCode(400)->setBody('Nama file tidak valid.');
        }

        $filePath = WRITEPATH . 'uploads/' . $filename;
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
            ->setHeader('Content-Length', (string) filesize($filePath))
            ->setBody(file_get_contents($filePath));
    }

    private function ensureUploadsDir(): void
    {
        $dir = WRITEPATH . 'uploads';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    protected function generateSurat(array $request, ?int $updateLogId = null): array
    {
        $rekeningModel = new RekeningModel();
        $rekeningData = $rekeningModel->where('no_rekening', $request['no_rekening'] ?? '')->first();
        $namaRekening = $rekeningData['nama_rekening'] ?? '';

        $seksi  = $request['seksi'] ?? '';
        $tahun  = $request['tahun'] ?? date('Y');

        $data = [
            'seksi'  => $seksi,
            'tahun'  => $tahun,
            'tanggal' => $request['tanggal'] ?? '',

            'nama' => $request['nama'] ?? '',
            'nip' => $request['nip'] ?? '',
            'pangkat' => $request['pangkat'] ?? '',
            'tingkat' => $request['tingkat'] ?? '',
            'jabatan' => $request['jabatan'] ?? '',

            'nama_pengikut_1' => $request['nama_pengikut_1'] ?? '',
            'nip_pengikut_1' => $request['nip_pengikut_1'] ?? '',
            'pangkat_pengikut_1' => $request['pangkat_pengikut_1'] ?? '',
            'jabatan_pengikut_1' => $request['jabatan_pengikut_1'] ?? '',
            'lahir_pengikut_1' => $request['lahir_pengikut_1'] ?? '',
            'status_1' => $request['status_1'] ?? '',

            'nama_pengikut_2' => $request['nama_pengikut_2'] ?? '',
            'nip_pengikut_2' => $request['nip_pengikut_2'] ?? '',
            'pangkat_pengikut_2' => $request['pangkat_pengikut_2'] ?? '',
            'jabatan_pengikut_2' => $request['jabatan_pengikut_2'] ?? '',
            'lahir_pengikut_2' => $request['lahir_pengikut_2'] ?? '',
            'status_2' => $request['status_2'] ?? '',

            'nama_pengikut_3' => $request['nama_pengikut_3'] ?? '',
            'nip_pengikut_3' => $request['nip_pengikut_3'] ?? '',
            'pangkat_pengikut_3' => $request['pangkat_pengikut_3'] ?? '',
            'jabatan_pengikut_3' => $request['jabatan_pengikut_3'] ?? '',
            'lahir_pengikut_3' => $request['lahir_pengikut_3'] ?? '',
            'status_3' => $request['status_3'] ?? '',

            'asal' => $request['asal'] ?? '',
            'tujuan' => $request['tujuan'] ?? '',
            'perihal' => $request['perihal'] ?? '',
            'bulan' => $request['bulan'] ?? '',
            'plat' => $request['alat'] ?? $request['plat'] ?? '',
            'alat' => $request['alat'] ?? $request['plat'] ?? '',
            'lama' => $request['lama'] ?? '',
            'berangkat' => $request['berangkat'] ?? '',
            'kembali' => $request['kembali'] ?? '',

            'instansi' => $request['instansi'] ?? '',
            'rekening' => $request['no_rekening'] ?? '',
            'nama_rekening' => $namaRekening,
        ];

        $allowedTemplates = [
            'spt0.docx' => FCPATH . 'template/spt0.docx',
            'spt1.docx' => FCPATH . 'template/spt1.docx',
            'spt2.docx' => FCPATH . 'template/spt2.docx',
            'spt3.docx' => FCPATH . 'template/spt3.docx',
        ];

        $templateChoice = 'spt0.docx';
        if (!empty($data['nama_pengikut_1']) || !empty($data['nip_pengikut_1'])) {
            $templateChoice = 'spt1.docx';
        }
        if (!empty($data['nama_pengikut_2']) || !empty($data['nip_pengikut_2'])) {
            $templateChoice = 'spt2.docx';
        }
        if (!empty($data['nama_pengikut_3']) || !empty($data['nip_pengikut_3'])) {
            $templateChoice = 'spt3.docx';
        }

        $templatePath = $allowedTemplates[$templateChoice] ?? $allowedTemplates['spt0.docx'];
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template tidak ditemukan atau belum diunggah!');
        }

        $template = new TemplateProcessor($templatePath);
        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        // Inject dasar hukum placeholders (dasar_1 … dasar_N)
        $dasarModel = new DasarSuratModel();
        foreach ($dasarModel->getAll() as $row) {
            $template->setValue('dasar_' . (int) $row['nomor'], $row['isi']);
        }

        // Inject paraf hirarki placeholders (paraf_1 … paraf_N)
        // Form values override DB defaults when provided and non-empty
        $parafModel    = new ParafHirarkiModel();
        $parafFromForm = $request['paraf'] ?? [];
        foreach ($parafModel->getAll() as $row) {
            $num   = (int) $row['nomor'];
            $label = (isset($parafFromForm[$num]) && trim($parafFromForm[$num]) !== '')
                ? trim($parafFromForm[$num])
                : $row['label'];
            $template->setValue('paraf_' . $num, $label);
        }

        $filename = 'surat_' . date('Ymd_His') . '.docx';
        $savePath = WRITEPATH . 'uploads/' . $filename;

        $this->ensureUploadsDir();

        $template->saveAs($savePath);
        $this->saveSuratLog($data, $templateChoice, $filename, $updateLogId);

        return [
            'savePath' => $savePath,
            'filename' => $filename,
            'templateChoice' => $templateChoice,
            'data' => $data,
        ];
    }

    // ========================
    // EDIT SPT & SPD
    // ========================

    public function editSurat(int $id)
    {
        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log || ($log['jenis_surat'] ?? '') !== 'Surat Dinas') {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        $pegawaiModel  = new PegawaiModel();
        $rekeningModel = new RekeningModel();

        // Extract seksi and tahun from stored nomor (format: 800.1.11.1/ /SEKSI/TAHUN)
        $seksi = '';
        $tahun = (string) date('Y');
        if (preg_match('/\/([^\/]+)\/(\d{4})$/', $log['nomor'] ?? '', $m)) {
            $seksi = trim($m[1]);
            $tahun = $m[2];
        }

        // Convert stored Indonesian date ("12 Desember 2025") to ISO ("2025-12-12")
        $bulanMap = [
            'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
            'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
            'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12',
        ];
        $toIso = function (string $tgl) use ($bulanMap): string {
            if (preg_match('/^(\d+)\s+(\w+)\s+(\d{4})$/', trim($tgl), $m)) {
                $bln = $bulanMap[$m[2]] ?? '01';
                return $m[3] . '-' . $bln . '-' . str_pad($m[1], 2, '0', STR_PAD_LEFT);
            }
            return '';
        };

        // Lookup pengikut data from PegawaiModel
        $pengikut = [1 => null, 2 => null, 3 => null];
        foreach ([1, 2, 3] as $i) {
            $nip = $log["nip_pengikut_{$i}"] ?? '';
            if ($nip) {
                $pengikut[$i] = $pegawaiModel->where('nip', $nip)->first() ?? null;
            }
        }

        $prefill = [
            'seksi'          => $seksi,
            'tahun'          => $tahun,
            'bulan'          => $log['bulan'] ?? '',
            'nip'            => $log['nip'] ?? '',
            'nama'           => $log['nama'] ?? '',
            'pangkat'        => $log['pangkat'] ?? '',
            'tingkat'        => $log['tingkat'] ?? '',
            'jabatan'        => $log['jabatan'] ?? '',
            'asal'           => $log['asal'] ?? '',
            'tujuan'         => $log['tujuan'] ?? '',
            'alat'           => $log['alat'] ?? $log['plat'] ?? '',
            'perihal'        => $log['perihal'] ?? '',
            'berangkat'      => $log['berangkat'] ?? '',
            'kembali'        => $log['kembali'] ?? '',
            'lama'           => $log['lama'] ?? '',
            'no_rekening'    => $log['no_rekening'] ?? '',
            'berangkat_date' => $toIso($log['berangkat'] ?? ''),
            'kembali_date'   => $toIso($log['kembali'] ?? ''),
            'pengikut_1'     => $pengikut[1],
            'pengikut_2'     => $pengikut[2],
            'pengikut_3'     => $pengikut[3],
        ];

        return view('Surat_form', [
            'pegawai'       => $pegawaiModel->orderBy('nama', 'ASC')->findAll(),
            'rekening'      => $rekeningModel->findAll(),
            'prefill'       => $prefill,
            'editId'        => $id,
            'paraf_default' => (new ParafHirarkiModel())->getAll(),
        ]);
    }

    public function updateSurat(int $id)
    {
        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log || ($log['jenis_surat'] ?? '') !== 'Surat Dinas') {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $oldFilename = $log['filename'];
            $result = $this->generateSurat($this->request->getPost(), $id);

            // Delete old file if a new one was generated
            if ($oldFilename && $oldFilename !== $result['filename']) {
                $oldPath = WRITEPATH . 'uploads/' . $oldFilename;
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename'    => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memperbarui surat: ' . esc($e->getMessage()),
            ]);
        }
    }

    public function history()
    {
        $suratLogModel = new SuratLogModel();
        $jenis   = $this->request->getGet('jenis') ?? 'semua';
        $search  = trim($this->request->getGet('search') ?? '');
        $page    = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 25;
        $session = service('session');

        if ($jenis && $jenis !== 'semua') {
            $suratLogModel->where('jenis_surat', $jenis);
        }

        if ($search !== '') {
            $suratLogModel->groupStart()
                ->like('nama', $search)
                ->orLike('nip', $search)
                ->orLike('jabatan', $search)
                ->orLike('user', $search)
                ->orLike('unit_kerja', $search)
                ->groupEnd();
        }

        // Non-admin hanya melihat riwayat miliknya sendiri
        if ($session->get('role') !== 'admin') {
            $suratLogModel->where('user', $session->get('username'));
        }

        $total = $suratLogModel->countAllResults(false);
        $logs  = $suratLogModel->orderBy('created_at', 'DESC')
                               ->limit($perPage, ($page - 1) * $perPage)
                               ->findAll();

        $totalPages = (int) ceil($total / $perPage);

        return view('surat_history', [
            'logs'        => $logs,
            'jenis'       => $jenis,
            'search'      => $search,
            'username'    => $session->get('username') ?? null,
            'role'        => $session->get('role'),
            'page'        => $page,
            'totalPages'  => $totalPages,
            'total'       => $total,
            'perPage'     => $perPage,
        ]);
    }

    public function deleteHistory(int $id)
    {
        $session  = service('session');
        $role     = $session->get('role');
        $username = $session->get('username');

        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log) {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        // Admin boleh hapus semua; user biasa hanya boleh hapus miliknya sendiri
        if ($role !== 'admin' && $log['user'] !== $username) {
            return redirect()->to('/surat/history')->with('error', 'Akses ditolak.');
        }

        $filePath = WRITEPATH . 'uploads/' . $log['filename'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $suratLogModel->delete($id);

        return redirect()->to('/surat/history')->with('success', 'Riwayat berhasil dihapus.');
    }

    public function deleteRincian(int $id)
    {
        $session = service('session');
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/surat/history')->with('error', 'Akses ditolak.');
        }

        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log) {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        $rincianFilename = $log['rincian_filename'] ?? null;
        if ($rincianFilename) {
            $filePath = WRITEPATH . 'uploads/' . $rincianFilename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $suratLogModel->update($id, ['rincian_filename' => null]);
        }

        return redirect()->to('/surat/history')->with('success', 'Rincian berhasil dihapus.');
    }

    public function deleteBulkHistory()
    {
        $session = service('session');
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/surat/history')->with('error', 'Akses ditolak.');
        }

        $ids = $this->request->getPost('ids');
        if (empty($ids) || !is_array($ids)) {
            return redirect()->to('/surat/history')->with('error', 'Tidak ada data yang dipilih.');
        }

        $suratLogModel = new SuratLogModel();
        $deleted = 0;

        foreach ($ids as $id) {
            $id  = (int) $id;
            $log = $suratLogModel->find($id);
            if (!$log) continue;

            $filePath = WRITEPATH . 'uploads/' . $log['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $suratLogModel->delete($id);
            $deleted++;
        }

        return redirect()->to('/surat/history')->with('success', $deleted . ' riwayat berhasil dihapus.');
    }

    // ========================
    // PERMOHONAN TTE
    // ========================

    public function permohonantte()
    {
        $pegawaiModel = new PegawaiModel();

        return view('permohonantte_form', [
            'pegawai' => $pegawaiModel->orderBy('nama', 'ASC')->findAll(),
        ]);
    }

    public function prosesPermohonanTTE()
    {
        try {
            $result = $this->generatePermohonanTTE($this->request->getPost());
            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename' => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memproses surat: ' . esc($e->getMessage()),
            ]);
        }
    }

    protected function generatePermohonanTTE(array $request): array
    {
        $data = [
            'nama'       => $request['nama'] ?? '',
            'nip'        => $request['nip'] ?? '',
            'nik'        => $request['nik'] ?? '',
            'pangkat'    => $request['pangkat'] ?? '',
            'jabatan'    => $request['jabatan'] ?? '',
            'unit'       => $request['unit'] ?? '',
            'instansi'   => $request['instansi'] ?? '',
            'kabupaten'  => $request['kabupaten'] ?? '',
            'provinsi'   => $request['provinsi'] ?? '',
            'email'      => $request['email'] ?? '',
            'telp'       => $request['telp'] ?? '',
            'keperluan'  => $request['keperluan'] ?? '',
            'bulan'      => $request['bulan'] ?? '',
        ];

        $templatePath = FCPATH . 'template/permohonantte.docx';
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template permohonantte.docx tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);
        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $filename = 'permohonantte_' . date('Ymd_His') . '.docx';
        $savePath = WRITEPATH . 'uploads/' . $filename;

        $this->ensureUploadsDir();

        $template->saveAs($savePath);
        $this->saveTTELog($data, $filename);

        return [
            'savePath' => $savePath,
            'filename' => $filename,
        ];
    }

    protected function saveTTELog(array $data, string $filename)
    {
        try {
            $suratLogModel = new SuratLogModel();
            $suratLogModel->insert([
                'jenis_surat' => 'Permohonan TTE',
                'nama' => $data['nama'],
                'nip' => $data['nip'],
                'pangkat' => $data['pangkat'],
                'jabatan' => $data['jabatan'],
                'instansi' => $data['instansi'],
                'bulan' => $data['bulan'],
                'perihal' => $data['keperluan'],
                'template_choice' => 'permohonantte.docx',
                'filename' => $filename,
                'user' => service('session')->get('username') ?? null,
                'unit_kerja' => service('session')->get('unit_kerja') ?? null,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menyimpan log TTE: ' . $e->getMessage());
        }
    }

    protected function saveSuratLog(array $data, string $templateChoice, string $filename, ?int $updateLogId = null)
    {
        try {
            $suratLogModel = new SuratLogModel();
            $record = [
                'jenis_surat' => 'Surat Dinas',
                'nomor' => '800.1.11.1/ /' . ($data['seksi'] ?? '') . '/' . ($data['tahun'] ?? date('Y')),
                'tanggal' => $data['tanggal'],
                'nama' => $data['nama'],
                'nip' => $data['nip'],
                'pangkat' => $data['pangkat'],
                'tingkat' => $data['tingkat'],
                'nip_pengikut_1' => $data['nip_pengikut_1'] ?? null,
                'nip_pengikut_2' => $data['nip_pengikut_2'] ?? null,
                'nip_pengikut_3' => $data['nip_pengikut_3'] ?? null,
                'jabatan' => $data['jabatan'],
                'asal' => $data['asal'],
                'tujuan' => $data['tujuan'],
                'perihal' => $data['perihal'],
                'bulan' => $data['bulan'],
                'plat' => $data['plat'],
                'alat' => $data['alat'],
                'lama' => $data['lama'],
                'berangkat' => $data['berangkat'],
                'kembali' => $data['kembali'],
                'instansi' => $data['instansi'],
                'no_rekening' => $data['rekening'],
                'nama_rekening' => $data['nama_rekening'],
                'template_choice' => $templateChoice,
                'filename' => $filename,
                'user' => service('session')->get('username') ?? null,
                'unit_kerja' => service('session')->get('unit_kerja') ?? null,
            ];
            if ($updateLogId !== null) {
                $suratLogModel->update($updateLogId, $record);
            } else {
                $suratLogModel->insert($record);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menyimpan log surat: ' . $e->getMessage());
        }
    }

    // ========================
    // NOTA DINAS TTE
    // ========================

    public function notadinastte()
    {
        $prefill = [
            'dinas' => $this->request->getGet('dinas') ?? '',
            'bulan' => $this->request->getGet('bulan') ?? '',
        ];
        return view('notadinastte_form', ['prefill' => $prefill]);
    }

    public function notadinasDariPermohonan(int $logId)
    {
        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($logId);

        if (!$log || $log['jenis_surat'] !== 'Permohonan TTE') {
            return redirect()->to(site_url('surat/history'))->with('error', 'Data permohonan tidak ditemukan.');
        }

        $createdAt = $log['created_at'] ?? date('Y-m-d H:i:s');
        $prefill = [
            'nomor'   => $log['nomor'] ?? '',
            'dinas'   => $log['unit_kerja'] ?? '',
            'tanggal' => date('d', strtotime($createdAt)),
            'bulan'   => $log['bulan'] ?? '',
            'log_id'  => $logId,
        ];

        return view('notadinastte_form', ['prefill' => $prefill]);
    }

    public function prosesNotaDinasTTE()
    {
        try {
            $post   = $this->request->getPost();
            $logId  = !empty($post['log_id']) ? (int) $post['log_id'] : null;
            $result = $this->generateNotaDinasTTE($post, skipLog: $logId !== null);

            if ($logId !== null) {
                $suratLogModel = new SuratLogModel();
                $suratLogModel->update($logId, ['notadinas_filename' => $result['filename']]);
            }

            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename' => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memproses nota dinas: ' . esc($e->getMessage()),
            ]);
        }
    }

    protected function generateNotaDinasTTE(array $request, bool $skipLog = false): array
    {
        $data = [
            'nomor'   => $request['nomor'] ?? '',
            'dinas'   => $request['dinas'] ?? '',
            'tanggal' => $request['tanggal'] ?? '',
            'bulan'   => $request['bulan'] ?? '',
        ];

        $templatePath = FCPATH . 'template/notadinastte.docx';
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template notadinastte.docx tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);
        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $filename = 'notadinastte_' . date('Ymd_His') . '.docx';
        $savePath = WRITEPATH . 'uploads/' . $filename;

        $this->ensureUploadsDir();

        $template->saveAs($savePath);
        if (!$skipLog) {
            $this->saveNotaDinasLog($data, $filename);
        }

        return [
            'savePath' => $savePath,
            'filename' => $filename,
        ];
    }

    protected function saveNotaDinasLog(array $data, string $filename)
    {
        try {
            $suratLogModel = new SuratLogModel();
            $suratLogModel->insert([
                'jenis_surat' => 'Nota Dinas TTE',
                'nomor' => $data['nomor'],
                'tanggal' => $data['tanggal'],
                'bulan' => $data['bulan'],
                'template_choice' => 'notadinastte.docx',
                'filename' => $filename,
                'user' => service('session')->get('username') ?? null,
                'unit_kerja' => service('session')->get('unit_kerja') ?? null,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menyimpan log nota dinas: ' . $e->getMessage());
        }
    }

    // ========================
    // RINCIAN PERJALANAN DINAS
    // ========================

    public function rincianperjadin($logId = null)
    {
        $pegawaiModel = new PegawaiModel();
        $prefill = [];

        if ($logId) {
            $suratLogModel = new SuratLogModel();
            $log = $suratLogModel->find($logId);
            if ($log && ($log['jenis_surat'] ?? '') === 'Surat Dinas') {
                // Tentukan jumlah orang dari template_choice
                $tplCount = [
                    'spt0.docx' => 1,
                    'spt1.docx' => 2,
                    'spt2.docx' => 3,
                    'spt3.docx' => 4,
                ];
                $jumlahDariTemplate = $tplCount[(string)($log['template_choice'] ?? '')] ?? 1;

                $prefill = [
                    'nama_1'        => $log['nama'] ?? '',
                    'nip_penerima'  => $log['nip'] ?? '',
                    'pangkat_1'     => ($log['pangkat'] ?? '') . ' Muara Enim',
                    'golongan_1'    => $log['tingkat'] ?? '',
                    'tanggal'       => $log['tanggal'] ?? '',
                    'plat_nomor'    => $log['plat'] ?? '',
                    'perihal'       => $log['perihal'] ?? '',
                    'nomor_spt'     => $log['nomor'] ?? '',
                    'bulan'         => $log['bulan'] ?? '',
                    'lama'          => $log['lama'] ?? '',
                    'berangkat'     => $log['berangkat'] ?? '',
                    'kembali'       => $log['kembali'] ?? '',
                    'daftar'        => 'Permintaan Biaya Perjalanan Dinas Dalam Daerah Dalam rangka ' . ($log['perihal'] ?? '') . ' sesuai dengan SPT Nomor: ' . ($log['nomor'] ?? '') . ' Bulan ' . ($log['bulan'] ?? ''),
                    'jumlah_pegawai' => $jumlahDariTemplate,
                ];

                // Lookup pengikut data — batch query to avoid N+1
                $nipList = array_filter([
                    $log['nip_pengikut_1'] ?? '',
                    $log['nip_pengikut_2'] ?? '',
                    $log['nip_pengikut_3'] ?? '',
                ]);
                $pengikutMap = [];
                if (!empty($nipList)) {
                    $results = $pegawaiModel->whereIn('nip', array_values($nipList))->findAll();
                    foreach ($results as $pgw) {
                        $pengikutMap[$pgw['nip']] = $pgw;
                    }
                }

                $pengikutIndex = 2;
                for ($i = 1; $i <= 3; $i++) {
                    $nipPengikut = $log['nip_pengikut_' . $i] ?? '';
                    if (!empty($nipPengikut) && isset($pengikutMap[(string)$nipPengikut])) {
                        $pgw = $pengikutMap[(string)$nipPengikut];
                        $prefill['nama_' . $pengikutIndex]     = $pgw['nama'] ?? '';
                        $prefill['nip_' . $pengikutIndex]      = $pgw['nip'] ?? '';
                        $prefill['pangkat_' . $pengikutIndex]   = ($pgw['pangkat'] ?? '') . ' Muara Enim';
                        $prefill['golongan_' . $pengikutIndex]  = $pgw['tingkat'] ?? '';
                        $pengikutIndex++;
                    }
                }
            }
        }

        $pengaturanModel = new PengaturanPerjadinModel();
        $settings = $pengaturanModel->getAllAsMap();
        $provinsiRows = $pengaturanModel->getByGrup('tarif_provinsi');

        return view('rincianperjadin_form', [
            'pegawai'         => $pegawaiModel->orderBy('nama', 'ASC')->findAll(),
            'prefill'         => $prefill,
            'settings'        => $settings,
            'tarif_provinsi'  => $provinsiRows,
            'parent_log_id'   => $logId ? (int) $logId : null,
        ]);
    }

    public function prosesRincianPerjadin()
    {
        try {
            $result = $this->generateRincianPerjadin($this->request->getPost());
            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename' => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memproses rincian perjalanan dinas: ' . esc($e->getMessage()),
            ]);
        }
    }

    protected function generateRincianPerjadin(array $request): array
    {
        $jumlahPegawai = max(1, (int)($request['jumlah_pegawai'] ?? 1));
        $jenisAngkut = $request['jenis_angkut'] ?? 'kendaraan_dinas';

        // Determine transport-related values based on jenis_angkut
        if ($jenisAngkut === 'transportasi_umum') {
            $biayaTransport = (int)($request['biaya_transportasi'] ?? 0);
            $ketTransport = $request['ket_transportasi'] ?? 'Transportasi Umum';
            $labelAngkut = 'Transportasi Umum';
            $labelJumlah = 'Jumlah Biaya Transportasi Perjalanan Dinas';
            $platNomor = $ketTransport;
            $rincianBbm = '';
            $totalBbm = $biayaTransport > 0 ? number_format($biayaTransport, 0, ',', '.') . ',-' : '';
        } else {
            $labelAngkut = 'BBM Kendaran Dinas';
            $labelJumlah = 'Jumlah Biaya Perjalanan Dinas';
            $platNomor = $request['plat_nomor'] ?? '';
            $rincianBbm = $request['rincian_bbm'] ?? '';
            $totalBbm = $request['total_bbm'] ?? '';
        }

        $data = [
            'daftar'        => $request['daftar'] ?? '',
            'nama_1'        => $request['nama_1'] ?? '',
            'pangkat_1'     => $request['pangkat_1'] ?? '',
            'golongan_1'    => $request['golongan_1'] ?? '',
            'uang_harian_1' => $request['uang_harian_1'] ?? '',
            'jumlah_1'      => $request['jumlah_1'] ?? '',
            'plat_nomor'    => $platNomor,
            'rincian_bbm'   => $rincianBbm,
            'total_bbm'     => $totalBbm,
            'label_angkut'  => $labelAngkut,
            'label_jumlah'  => $labelJumlah,
            'jumlah_total'  => $request['jumlah_total'] ?? '',
            'terbilang'     => $request['terbilang'] ?? '',
            'tanggal'       => $request['tanggal'] ?? '',
            'jumlah_um'     => $request['jumlah_um'] ?? '',
            'nama_penerima'    => $request['nama_1'] ?? '',
            'pangkat_penerima' => $request['pangkat_1'] ?? '',
            'nip_penerima'     => $request['nip_penerima'] ?? '',
        ];

        // Add dynamic pegawai 2-4
        for ($i = 2; $i <= $jumlahPegawai; $i++) {
            $data['nama_' . $i]        = $request['nama_' . $i] ?? '';
            $data['pangkat_' . $i]     = $request['pangkat_' . $i] ?? '';
            $data['golongan_' . $i]    = $request['golongan_' . $i] ?? '';
            $data['uang_harian_' . $i] = $request['uang_harian_' . $i] ?? '';
            $data['jumlah_' . $i]      = $request['jumlah_' . $i] ?? '';
        }

        // Check if penginapan is included
        $pakaiPenginapan = !empty($request['pakai_penginapan']);

        if ($pakaiPenginapan) {
            for ($i = 1; $i <= $jumlahPegawai; $i++) {
                $data['penginapan_' . $i]        = $request['penginapan_' . $i] ?? '';
                $data['jumlah_penginapan_' . $i] = $request['jumlah_penginapan_' . $i] ?? '';
            }
        }

        // Build biaya lain-lain items
        $jumlahBiayaLain = max(0, (int)($request['jumlah_biaya_lain'] ?? 0));
        $biayaLainKets = [];
        $biayaLainDescriptions = [];
        $biayaLainAmounts = [];
        $totalBiayaLain = 0;
        $noBiayaLain = $pakaiPenginapan ? 4 : 3;
        for ($i = 1; $i <= $jumlahBiayaLain; $i++) {
            $ket = $request['ket_lain_' . $i] ?? '';
            $nominal = (int)($request['nominal_lain_' . $i] ?? 0);
            $jumlahOrang = (int)($request['jumlah_orang_lain_' . $i] ?? 1);
            $subtotal = $nominal * $jumlahOrang;
            if ($ket !== '' && $nominal > 0 && $jumlahOrang > 0) {
                $biayaLainKets[] = $ket;
                $biayaLainDescriptions[] = 'Rp. ' . number_format($nominal, 0, ',', '.') . ',- x ' . $jumlahOrang . ' orang';
                $biayaLainAmounts[] = number_format($subtotal, 0, ',', '.');
                $totalBiayaLain += $subtotal;
            }
        }

        $br = '</w:t><w:br/><w:t>';

        // Biaya lain values (will be set with XML line breaks)
        $biayaLainData = [
            'no_biaya_lain'       => count($biayaLainKets) > 0 ? (string)$noBiayaLain : '',
            'label_biaya_lain'    => count($biayaLainKets) > 0
                ? 'Biaya Lain-lain' . $br . implode($br, $biayaLainKets)
                : '',
            'biaya_lain_ket'      => '',
            'rincian_biaya_lain'  => count($biayaLainDescriptions) > 0
                ? $br . implode($br, $biayaLainDescriptions)
                : '',
            'rp_biaya_lain'       => count($biayaLainKets) > 0
                ? $br . implode($br, array_fill(0, count($biayaLainKets), 'Rp.'))
                : '',
            'total_biaya_lain'    => count($biayaLainAmounts) > 0
                ? $br . implode($br, $biayaLainAmounts)
                : '',
        ];

        // Select template based on pegawai count and penginapan toggle
        if ($pakaiPenginapan) {
            $templateMap = [
                1 => 'rincian1p.docx',
                2 => 'rincian2p.docx',
                3 => 'rincian3p.docx',
                4 => 'rincian4p.docx',
            ];
        } else {
            $templateMap = [
                1 => 'rincian1.docx',
                2 => 'rincian2.docx',
                3 => 'rincian3.docx',
                4 => 'rincian4.docx',
            ];
        }
        $templateFile = $templateMap[$jumlahPegawai] ?? 'rincian2.docx';
        $templatePath = FCPATH . 'template/' . $templateFile;

        // Fallback to original template if variant not found
        if (!file_exists($templatePath)) {
            $templatePath = FCPATH . 'template/rincianperjalanandinas.docx';
        }
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template rincian perjalanan dinas tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);

        // Set biaya lain-lain with XML line breaks (disable escaping temporarily)
        $escapingWasEnabled = Settings::isOutputEscapingEnabled();
        Settings::setOutputEscapingEnabled(false);
        foreach ($biayaLainData as $key => $value) {
            $template->setValue($key, $value);
        }
        Settings::setOutputEscapingEnabled($escapingWasEnabled);

        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $filename = 'rincian_perjadin_' . date('Ymd_His') . '.docx';
        $savePath = WRITEPATH . 'uploads/' . $filename;

        $this->ensureUploadsDir();

        $template->saveAs($savePath);
        $parentLogId = isset($request['parent_log_id']) && (int)$request['parent_log_id'] > 0
            ? (int)$request['parent_log_id']
            : null;

        // Compute uang harian total (sum of jumlah_N across all pegawai)
        $uangHarianTotal = 0;
        for ($i = 1; $i <= $jumlahPegawai; $i++) {
            $raw = $data['jumlah_' . $i] ?? '';
            $uangHarianTotal += (int) preg_replace('/[^0-9]/', '', $raw);
        }

        // Compute penginapan total
        $uangPenginapanTotal = 0;
        if ($pakaiPenginapan) {
            for ($i = 1; $i <= $jumlahPegawai; $i++) {
                $raw = $request['jumlah_penginapan_' . $i] ?? '';
                $uangPenginapanTotal += (int) preg_replace('/[^0-9]/', '', $raw);
            }
        }

        // Compute BBM/transport total
        if ($jenisAngkut === 'transportasi_umum') {
            $biayaTransportTotal = (int)($request['biaya_transportasi'] ?? 0);
        } else {
            $biayaTransportTotal = (int) preg_replace('/[^0-9]/', '', $request['total_bbm'] ?? '');
        }

        // Compute biaya lain-lain total
        $biayaLainTotal = 0;
        $jumlahBiayaLainF = max(0, (int)($request['jumlah_biaya_lain'] ?? 0));
        for ($i = 1; $i <= $jumlahBiayaLainF; $i++) {
            $nominal   = (int)($request['nominal_lain_' . $i] ?? 0);
            $jumlahOrg = (int)($request['jumlah_orang_lain_' . $i] ?? 1);
            if ($nominal > 0 && $jumlahOrg > 0) {
                $biayaLainTotal += $nominal * $jumlahOrg;
            }
        }

        $financial = [
            'rincian_uang_harian'     => $uangHarianTotal > 0    ? number_format($uangHarianTotal, 0, ',', '.') . ',-' : '',
            'rincian_uang_penginapan' => $uangPenginapanTotal > 0 ? number_format($uangPenginapanTotal, 0, ',', '.') . ',-' : '',
            'rincian_biaya_transport' => $biayaTransportTotal > 0 ? number_format($biayaTransportTotal, 0, ',', '.') . ',-' : '',
            'rincian_biaya_lain'      => $biayaLainTotal > 0     ? number_format($biayaLainTotal, 0, ',', '.') . ',-' : '',
            'rincian_jumlah_total'    => $data['jumlah_total'] ?? '',
            'rincian_terbilang'       => $data['terbilang'] ?? '',
            'rincian_kategori'        => $request['kategori'] ?? '',
        ];

        $this->saveRincianPerjadinLog($data, $filename, $parentLogId, $financial);

        return [
            'savePath' => $savePath,
            'filename' => $filename,
        ];
    }

    protected function saveRincianPerjadinLog(array $data, string $filename, ?int $parentLogId = null, array $financial = [])
    {
        try {
            $suratLogModel = new SuratLogModel();

            if ($parentLogId !== null) {
                            // Simpan rincian_filename dan data finansial ke baris SPT yang sudah ada
                $suratLogModel->update($parentLogId, array_merge([
                    'rincian_filename' => $filename,
                ], $financial));
            } else {
                // Standalone — buat baris baru seperti sebelumnya
                $suratLogModel->insert([
                    'jenis_surat' => 'Rincian Perjadin',
                    'nama' => $data['nama_1'],
                    'nip' => $data['nip_penerima'],
                    'pangkat' => $data['pangkat_1'],
                    'tanggal' => $data['tanggal'],
                    'perihal' => 'Rincian Perjalanan Dinas',
                    'template_choice' => 'rincianperjalanandinas.docx',
                    'filename' => $filename,
                    'user' => service('session')->get('username') ?? null,
                    'unit_kerja' => service('session')->get('unit_kerja') ?? null,
                ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menyimpan log rincian perjadin: ' . $e->getMessage());
        }
    }

    // ========================
    // KWITANSI
    // ========================

    public function kwitansi(int $logId)
    {
        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($logId);

        if (!$log || ($log['jenis_surat'] ?? '') !== 'Surat Dinas') {
            return redirect()->to('/surat/history')->with('error', 'Data surat tidak ditemukan.');
        }

        if (empty($log['rincian_filename'])) {
            return redirect()->to('/surat/history')->with('error', 'Kwitansi hanya dapat dibuat setelah Rincian Perjalanan Dinas selesai dibuat.');
        }

        // Build default description from SPT data
        $defaultDeskripsi = 'Biaya Perjalanan Dinas ' . ($log['perihal'] ?? '')
            . ' sesuai dengan SPT Nomor: ' . ($log['nomor'] ?? '')
            . ' Bulan ' . ($log['bulan'] ?? '');

        $bulanId = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $todayId  = date('d') . ' ' . $bulanId[(int)date('n')] . ' ' . date('Y');

        $prefill = [
            'nama_penerima'    => $log['nama'] ?? '',
            'nip_penerima'     => $log['nip'] ?? '',
            'untuk_pembayaran' => $defaultDeskripsi,
            'tanggal'          => $todayId,
            'nomor'            => '      /BP/      /Diskominfo SP/' . date('Y'),
            'uang_harian'      => $log['rincian_uang_harian'] ?? '',
            'uang_penginapan'  => $log['rincian_uang_penginapan'] ?? '',
            'biaya_transport'  => $log['rincian_biaya_transport'] ?? '',
            'biaya_lain'       => $log['rincian_biaya_lain'] ?? '',
            'jumlah'           => $log['rincian_jumlah_total'] ?? '',
            'terbilang'        => $log['rincian_terbilang'] ?? '',
        ];

        $kategoriRincian = $log['rincian_kategori'] ?? '';
        // Fallback: jika kategori belum tersimpan tapi ada nilai penginapan, anggap luar daerah
        $penginapanValue = trim($log['rincian_uang_penginapan'] ?? '');
        $isLuarDaerah = in_array($kategoriRincian, ['luar_daerah_dalam_provinsi', 'luar_daerah_luar_provinsi'])
            || ($penginapanValue !== '' && $penginapanValue !== '0,-' && $penginapanValue !== '0');

        $pegawaiModel = new PegawaiModel();
        $pptk_list = $pegawaiModel->where('tingkat', 'C1')->orderBy('nama', 'ASC')->findAll();

        $rekeningModel = new RekeningModel();
        $rekening_list = $rekeningModel->orderBy('nama_rekening', 'ASC')->findAll();

        // Pre-select rekening dari log (match by no_rekening)
        $logNoRekening = $log['no_rekening'] ?? '';
        $selectedRekening = null;
        foreach ($rekening_list as $r) {
            if ($r['no_rekening'] === $logNoRekening) {
                $selectedRekening = $r;
                break;
            }
        }

        return view('kwitansi_form', [
            'log'               => $log,
            'prefill'           => $prefill,
            'parent_log_id'     => $logId,
            'kategori_rincian'  => $isLuarDaerah ? ($kategoriRincian ?: 'luar_daerah_dalam_provinsi') : $kategoriRincian,
            'pptk_list'         => $pptk_list,
            'rekening_list'     => $rekening_list,
            'selected_rekening' => $selectedRekening,
        ]);
    }

    public function prosesKwitansi()
    {
        try {
            $result = $this->generateKwitansi($this->request->getPost());
            return view('surat_processing', [
                'downloadUrl' => site_url('surat/download/' . $result['filename']),
                'filename'    => $result['filename'],
            ]);
        } catch (\Throwable $e) {
            return view('surat_processing', [
                'error' => 'Gagal memproses kwitansi: ' . esc($e->getMessage()),
            ]);
        }
    }

    protected function generateKwitansi(array $request): array
    {
        $data = [
            'nomor'             => $request['nomor'] ?? '',
            'terbilang'         => $request['terbilang'] ?? '',
            'untuk_pembayaran'  => $request['untuk_pembayaran'] ?? '',
            'uang_harian'       => $request['uang_harian'] ?? '',
            'uang_penginapan'   => $request['uang_penginapan'] ?? '',
            'biaya_transport'   => $request['biaya_transport'] ?? '',
            'biaya_lain'        => $request['biaya_lain'] ?? '',
            'jumlah'            => $request['jumlah'] ?? '',
            'tanggal'           => $request['tanggal'] ?? '',
            'nama_penerima'     => $request['nama_penerima'] ?? '',
            'nip_penerima'      => $request['nip_penerima'] ?? '',
            'nama_pptk'         => $request['nama_pptk'] ?? '',
            'nip_pptk'          => $request['nip_pptk'] ?? '',
            'kode_rekening'     => $request['kode_rekening'] ?? '',
            'bidang'            => $request['bidang'] ?? '',
            'sub_kegiatan'      => $request['sub_kegiatan'] ?? '',
            'tahun'             => date('Y'),
            'kategori_rincian'  => $request['kategori_rincian'] ?? '',
        ];

        $templatePath = FCPATH . 'template/kwitansi.docx';
        $kategori = $request['kategori_rincian'] ?? '';
        if (in_array($kategori, ['luar_daerah_dalam_provinsi', 'luar_daerah_luar_provinsi'])) {
            $templatePath = FCPATH . 'template/kwitansi_luar.docx';
        }
        if (!file_exists($templatePath)) {
            throw new \RuntimeException('Template kwitansi tidak ditemukan!');
        }

        $template = new TemplateProcessor($templatePath);
        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $filename = 'kwitansi_' . date('Ymd_His') . '.docx';
        $savePath = WRITEPATH . 'uploads/' . $filename;

        $this->ensureUploadsDir();
        $template->saveAs($savePath);

        $parentLogId = isset($request['parent_log_id']) && (int)$request['parent_log_id'] > 0
            ? (int)$request['parent_log_id']
            : null;

        if ($parentLogId !== null) {
            $suratLogModel = new SuratLogModel();
            $suratLogModel->update($parentLogId, ['kwitansi_filename' => $filename]);
        }

        return [
            'savePath' => $savePath,
            'filename' => $filename,
        ];
    }

    public function deleteKwitansi(int $id)
    {
        $session = service('session');
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/surat/history')->with('error', 'Akses ditolak.');
        }

        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log) {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        $kwitansiFilename = $log['kwitansi_filename'] ?? null;
        if ($kwitansiFilename) {
            $filePath = WRITEPATH . 'uploads/' . $kwitansiFilename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $suratLogModel->update($id, ['kwitansi_filename' => null]);
        }

        return redirect()->to('/surat/history')->with('success', 'Kwitansi berhasil dihapus.');
    }

    public function deleteNotaDinas(int $id)
    {
        $session = service('session');
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/surat/history')->with('error', 'Akses ditolak.');
        }

        $suratLogModel = new SuratLogModel();
        $log = $suratLogModel->find($id);

        if (!$log) {
            return redirect()->to('/surat/history')->with('error', 'Data tidak ditemukan.');
        }

        $notadinasFilename = $log['notadinas_filename'] ?? null;
        if ($notadinasFilename) {
            $filePath = WRITEPATH . 'uploads/' . $notadinasFilename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $suratLogModel->update($id, ['notadinas_filename' => null]);
        }

        return redirect()->to('/surat/history')->with('success', 'Nota Dinas berhasil dihapus.');
    }
}
