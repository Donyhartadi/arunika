<?php

namespace App\Controllers;

use App\Models\PengaturanPerjadinModel;
use App\Models\DasarSuratModel;
use App\Models\ParafHirarkiModel;

class Pengaturan extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
    }

    public function index()
    {
        $model = new PengaturanPerjadinModel();

        return view('pengaturan_perjadin', [
            'uang_harian'    => $model->getByGrup('uang_harian'),
            'bbm'            => $model->getByGrup('bbm'),
            'penginapan'     => $model->getByGrup('penginapan'),
            'tarif_provinsi' => $model->getByGrup('tarif_provinsi'),
            'message'        => $this->session->getFlashdata('message'),
            'error'          => $this->session->getFlashdata('error'),
        ]);
    }

    public function update()
    {
        $model  = new PengaturanPerjadinModel();
        $values = $this->request->getPost('nilai') ?? [];

        if (empty($values)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($values as $kunci => $nilai) {
            $nilai = (int) $nilai;
            if ($nilai < 0) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Nilai tidak boleh negatif.');
            }
            $db->table('pengaturan_perjadin')
               ->where('kunci', $kunci)
               ->update(['nilai' => $nilai, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan.');
        }

        return redirect()->to('/pengaturan/perjadin')->with('message', 'Pengaturan berhasil disimpan.');
    }

    // ── Dasar Surat ─────────────────────────────────────
    public function dasar()
    {
        $model = new DasarSuratModel();
        return view('pengaturan_dasar', [
            'dasar'   => $model->getAll(),
            'message' => $this->session->getFlashdata('message'),
            'error'   => $this->session->getFlashdata('error'),
        ]);
    }

    public function updateDasar()
    {
        $model = new DasarSuratModel();
        $items = $this->request->getPost('dasar') ?? [];

        if (empty($items)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($items as $id => $isi) {
            $id  = (int) $id;
            $isi = trim((string) $isi);
            if ($id < 1) continue;
            $db->table('dasar_surat')
               ->where('id', $id)
               ->update(['isi' => $isi, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal menyimpan dasar surat.');
        }

        return redirect()->to('/pengaturan/dasar')->with('message', 'Dasar surat berhasil disimpan.');
    }

    public function addDasar()
    {
        $model = new DasarSuratModel();
        $all   = $model->getAll();
        $nextNomor = count($all) + 1;

        $model->insert([
            'nomor'      => $nextNomor,
            'isi'        => '',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pengaturan/dasar')->with('message', 'Baris dasar baru ditambahkan.');
    }

    public function deleteDasar(int $id)
    {
        $model = new DasarSuratModel();
        $model->delete($id);

        // Re-number remaining rows
        $all = $model->getAll();
        foreach ($all as $i => $row) {
            $model->update($row['id'], ['nomor' => $i + 1]);
        }

        return redirect()->to('/pengaturan/dasar')->with('message', 'Baris berhasil dihapus.');
    }

    // ── Paraf Hirarki ───────────────────────────────────
    public function paraf()
    {
        $model = new ParafHirarkiModel();
        return view('pengaturan_paraf_hirarki', [
            'paraf'   => $model->getAll(),
            'message' => $this->session->getFlashdata('message'),
            'error'   => $this->session->getFlashdata('error'),
        ]);
    }

    public function updateParaf()
    {
        $model = new ParafHirarkiModel();
        $items = $this->request->getPost('paraf') ?? [];

        if (empty($items)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($items as $id => $label) {
            $id    = (int) $id;
            $label = trim((string) $label);
            if ($id < 1) continue;
            $db->table('paraf_hirarki')
               ->where('id', $id)
               ->update(['label' => $label, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal menyimpan paraf hirarki.');
        }

        return redirect()->to('/pengaturan/paraf')->with('message', 'Paraf hirarki berhasil disimpan.');
    }

    public function addParaf()
    {
        $model = new ParafHirarkiModel();
        $all   = $model->getAll();
        $nextNomor = count($all) + 1;

        $model->insert([
            'nomor'      => $nextNomor,
            'label'      => '',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pengaturan/paraf')->with('message', 'Baris paraf baru ditambahkan.');
    }

    public function deleteParaf(int $id)
    {
        $model = new ParafHirarkiModel();
        $model->delete($id);

        // Re-number remaining rows
        $all = $model->getAll();
        foreach ($all as $i => $row) {
            $model->update($row['id'], ['nomor' => $i + 1]);
        }

        return redirect()->to('/pengaturan/paraf')->with('message', 'Baris paraf berhasil dihapus.');
    }
}
