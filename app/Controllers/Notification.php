<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notification extends BaseController
{
    // ── Admin: list all notifications ─────────────────────
    public function index()
    {
        $model = new NotificationModel();
        return view('notification_manage', [
            'notifications' => $model->orderBy('created_at', 'DESC')->findAll(),
            'success'       => session()->getFlashdata('success'),
            'error'         => session()->getFlashdata('error'),
        ]);
    }

    // ── Admin: show create form ────────────────────────────
    public function create()
    {
        return view('notification_form', [
            'notif' => null,
            'error' => session()->getFlashdata('error'),
        ]);
    }

    // ── Admin: store new notification ──────────────────────
    public function store()
    {
        $judul = trim($this->request->getPost('judul') ?? '');
        $pesan = trim($this->request->getPost('pesan') ?? '');
        $tipe  = $this->request->getPost('tipe') ?? 'info';

        if ($judul === '' || $pesan === '') {
            return redirect()->back()->with('error', 'Judul dan pesan wajib diisi.')->withInput();
        }

        $model = new NotificationModel();
        $model->insert([
            'judul'      => $judul,
            'pesan'      => $pesan,
            'tipe'       => in_array($tipe, ['info','success','warning','danger']) ? $tipe : 'info',
            'aktif'      => 1,
            'created_by' => session()->get('username'),
        ]);

        return redirect()->to('/notifikasi')->with('success', 'Notifikasi berhasil dibuat.');
    }

    // ── Admin: show edit form ──────────────────────────────
    public function edit(int $id)
    {
        $model = new NotificationModel();
        $notif = $model->find($id);
        if (!$notif) {
            return redirect()->to('/notifikasi')->with('error', 'Notifikasi tidak ditemukan.');
        }
        return view('notification_form', ['notif' => $notif, 'error' => session()->getFlashdata('error')]);
    }

    // ── Admin: update notification ─────────────────────────
    public function update(int $id)
    {
        $model = new NotificationModel();
        $notif = $model->find($id);
        if (!$notif) {
            return redirect()->to('/notifikasi')->with('error', 'Notifikasi tidak ditemukan.');
        }

        $judul = trim($this->request->getPost('judul') ?? '');
        $pesan = trim($this->request->getPost('pesan') ?? '');
        $tipe  = $this->request->getPost('tipe') ?? 'info';
        $aktif = (int) $this->request->getPost('aktif');

        if ($judul === '' || $pesan === '') {
            return redirect()->back()->with('error', 'Judul dan pesan wajib diisi.')->withInput();
        }

        $model->update($id, [
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe'  => in_array($tipe, ['info','success','warning','danger']) ? $tipe : 'info',
            'aktif' => $aktif ? 1 : 0,
        ]);

        return redirect()->to('/notifikasi')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    // ── Admin: toggle aktif ────────────────────────────────
    public function toggle(int $id)
    {
        $model = new NotificationModel();
        $notif = $model->find($id);
        if ($notif) {
            $newAktif = $notif['aktif'] ? 0 : 1;
            $model->update($id, ['aktif' => $newAktif]);
            // Ketika notifikasi diaktifkan kembali, hapus riwayat baca
            // agar user dapat melihatnya lagi
            if ($newAktif === 1) {
                $model->clearReads($id);
            }
        }
        return redirect()->to('/notifikasi')->with('success', 'Status notifikasi diubah.');
    }

    // ── Admin: delete ──────────────────────────────────────
    public function delete(int $id)
    {
        $model = new NotificationModel();
        $model->delete($id);
        return redirect()->to('/notifikasi')->with('success', 'Notifikasi dihapus.');
    }

    // ── API: return active notifications as JSON (called from frontend) ──
    public function active()
    {
        $model  = new NotificationModel();
        $notifs = $model->getAktif();
        return $this->response->setJSON($notifs);
    }
}
