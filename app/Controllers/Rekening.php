<?php

namespace App\Controllers;

use App\Models\RekeningModel;

class Rekening extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
    }

    public function index()
    {
        $rekeningModel = new RekeningModel();
        $rekening = $rekeningModel->orderBy('nama_rekening', 'ASC')->findAll();

        return view('rekening_manage', [
            'username' => $this->session->get('username'),
            'rekening' => $rekening,
            'editRekening' => null,
            'message' => $this->session->getFlashdata('message'),
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    public function edit($id = null)
    {
        if (! $id) {
            return redirect()->to('/rekening/manage')->with('error', 'ID rekening tidak ditemukan');
        }

        $rekeningModel = new RekeningModel();
        $rekening = $rekeningModel->orderBy('nama_rekening', 'ASC')->findAll();
        $editRekening = null;
        foreach ($rekening as $r) {
            if ((string)$r['id_rekening'] === (string)$id) {
                $editRekening = $r;
                break;
            }
        }

        if (! $editRekening) {
            return redirect()->to('/rekening/manage')->with('error', 'Data rekening tidak ditemukan');
        }

        return view('rekening_manage', [
            'username' => $this->session->get('username'),
            'rekening' => $rekening,
            'editRekening' => $editRekening,
            'message' => $this->session->getFlashdata('message'),
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    public function save()
    {
        $request = $this->request->getPost();
        $id = trim($request['id_rekening'] ?? '');
        $originalId = trim($request['original_id'] ?? '');
        $nama  = trim($request['nama_rekening'] ?? '');
        $nomor = trim($request['no_rekening'] ?? '');
        $bidang       = trim($request['bidang'] ?? '');
        $subKegiatan  = trim($request['sub_kegiatan'] ?? '');

        if (! $nama || ! $nomor) {
            return redirect()->back()->with('error', 'Nama rekening dan nomor rekening wajib diisi')->withInput();
        }

        $data = [
            'nama_rekening' => $nama,
            'no_rekening'   => $nomor,
            'bidang'        => $bidang,
            'sub_kegiatan'  => $subKegiatan,
        ];

        $rekeningModel = new RekeningModel();

        if ($originalId) {
            $existing = $rekeningModel->find($originalId);
            if (! $existing) {
                return redirect()->to('/rekening/manage')->with('error', 'Data rekening tidak ditemukan');
            }

            $rekeningModel->update($originalId, $data);
            $message = 'Data rekening berhasil diperbarui.';
        } else {
            $rekeningModel->insert($data);
            $message = 'Kode rekening baru berhasil ditambahkan.';
        }

        return redirect()->to('/rekening/manage')->with('message', $message);
    }

    public function delete($id = null)
    {
        if (! $id) {
            return redirect()->to('/rekening/manage')->with('error', 'ID rekening tidak ditemukan');
        }

        $rekeningModel = new RekeningModel();
        $rekeningModel->delete($id);

        return redirect()->to('/rekening/manage')->with('message', 'Kode rekening berhasil dihapus.');
    }
}
