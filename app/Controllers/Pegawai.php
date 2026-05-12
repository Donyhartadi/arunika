<?php

namespace App\Controllers;

use App\Models\PegawaiModel;

class Pegawai extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
    }

    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $pegawai = $pegawaiModel->orderBy('nama', 'ASC')->findAll();

        return view('pegawai_manage', [
            'username' => $this->session->get('username'),
            'pegawai' => $pegawai,
            'message' => $this->session->getFlashdata('message'),
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    public function edit($nip = null)
    {
        if (! $nip) {
            return redirect()->to('/pegawai/manage')->with('error', 'NIP pegawai tidak ditemukan');
        }

        $pegawaiModel = new PegawaiModel();
        $pegawai = $pegawaiModel->orderBy('nama', 'ASC')->findAll();
        $editPegawai = null;
        foreach ($pegawai as $p) {
            if ($p['nip'] === $nip) {
                $editPegawai = $p;
                break;
            }
        }

        if (! $editPegawai) {
            return redirect()->to('/pegawai/manage')->with('error', 'Data pegawai tidak ditemukan');
        }

        return view('pegawai_manage', [
            'username' => $this->session->get('username'),
            'pegawai' => $pegawai,
            'editPegawai' => $editPegawai,
            'message' => $this->session->getFlashdata('message'),
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    public function save()
    {
        $request = $this->request->getPost();
        $nip = trim($request['nip'] ?? '');
        $originalNip = trim($request['original_nip'] ?? '');
        $nama = trim($request['nama'] ?? '');

        if (! $nip || ! $nama) {
            return redirect()->back()->with('error', 'NIP dan Nama wajib diisi')->withInput();
        }

        $data = [
            'nip' => $nip,
            'nama' => $nama,
            'lahir' => trim($request['lahir'] ?? ''),
            'status' => trim($request['status'] ?? ''),
            'pangkat' => trim($request['pangkat'] ?? ''),
            'tingkat' => trim($request['tingkat'] ?? ''),
            'jabatan' => trim($request['jabatan'] ?? ''),
        ];

        $pegawaiModel = new PegawaiModel();

        if ($originalNip) {
            $existing = $pegawaiModel->find($originalNip);
            if (! $existing) {
                return redirect()->to('/pegawai/manage')->with('error', 'Data pegawai tidak ditemukan');
            }

            if ($originalNip !== $nip && $pegawaiModel->find($nip)) {
                return redirect()->back()->with('error', 'NIP sudah digunakan oleh pegawai lain')->withInput();
            }

            $pegawaiModel->update($originalNip, $data);
            $message = 'Data pegawai berhasil diperbarui.';
        } else {
            if ($pegawaiModel->find($nip)) {
                $pegawaiModel->update($nip, $data);
                $message = 'Data pegawai berhasil diperbarui.';
            } else {
                $pegawaiModel->insert($data);
                $message = 'Pegawai baru berhasil ditambahkan.';
            }
        }

        return redirect()->to('/pegawai/manage')->with('message', $message);
    }

    public function delete($nip = null)
    {
        if (! $nip) {
            return redirect()->to('/pegawai/manage')->with('error', 'NIP pegawai tidak ditemukan');
        }

        $pegawaiModel = new PegawaiModel();
        $pegawaiModel->delete($nip);

        return redirect()->to('/pegawai/manage')->with('message', 'Pegawai berhasil dihapus.');
    }
}
