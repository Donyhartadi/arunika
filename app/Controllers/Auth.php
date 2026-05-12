<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SuratLogModel;
use App\Models\PegawaiModel;
use App\Models\RekeningModel;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = service('session');
    }

    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('login', [
            'error' => $this->session->getFlashdata('error'),
            'message' => $this->session->getFlashdata('message'),
        ]);
    }

    public function process()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if ($username === '' || $password === '') {
            return redirect()->back()
                ->with('error', 'Username dan password wajib diisi.')
                ->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->with('error', 'Username atau password salah')
                ->withInput();
        }

        $this->session->set([
            'isLoggedIn'  => true,
            'user_id'     => $user['id'],
            'username'    => $user['username'],
            'nama'        => $user['nama'],
            'unit_kerja'  => $user['unit_kerja'],
            'role'        => $user['role'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function dashboard()
    {
        $suratLogModel = new SuratLogModel();
        $pegawaiModel  = new PegawaiModel();
        $rekeningModel = new RekeningModel();
        $userModel     = new UserModel();

        $isAdmin  = $this->session->get('role') === 'admin';
        $username = $this->session->get('username');

        // Total surat (role-aware)
        $baseQuery = clone $suratLogModel;
        if (!$isAdmin) {
            $baseQuery->where('user', $username);
        }
        $totalSurat = $baseQuery->countAllResults();

        // Surat bulan ini
        $thisMonth = clone $suratLogModel;
        if (!$isAdmin) {
            $thisMonth->where('user', $username);
        }
        $suratBulanIni = $thisMonth
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();

        // Stat lainnya (admin only shows full, operator shows own)
        $totalPegawai  = $isAdmin ? $pegawaiModel->countAll() : null;
        $totalRekening = $isAdmin ? $rekeningModel->countAll() : null;
        $totalUser     = $isAdmin ? $userModel->countAll() : null;

        // Chart: 12 bulan terakhir
        $chartLabels = [];
        $chartData   = [];
        $bulanIndo   = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        for ($i = 11; $i >= 0; $i--) {
            $ts = mktime(0, 0, 0, date('n') - $i, 1, date('Y'));
            $m  = date('n', $ts);
            $y  = date('Y', $ts);
            $chartLabels[] = $bulanIndo[$m - 1] . ' ' . $y;

            $q = clone $suratLogModel;
            if (!$isAdmin) {
                $q->where('user', $username);
            }
            $chartData[] = (int) $q
                ->where('MONTH(created_at)', $m)
                ->where('YEAR(created_at)', $y)
                ->countAllResults();
        }

        return view('dashboard', [
            'username'      => $username,
            'nama'          => $this->session->get('nama'),
            'unit_kerja'    => $this->session->get('unit_kerja'),
            'role'          => $this->session->get('role'),
            'totalSurat'    => $totalSurat,
            'suratBulanIni' => $suratBulanIni,
            'totalPegawai'  => $totalPegawai,
            'totalRekening' => $totalRekening,
            'totalUser'     => $totalUser,
            'chartLabels'   => json_encode($chartLabels),
            'chartData'     => json_encode($chartData),
        ]);
    }

    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/login')->with('message', 'Anda telah logout');
    }

    // ========================
    // PROFIL
    // ========================

    public function profil()
    {
        $userModel = new UserModel();
        $user = $userModel->find($this->session->get('user_id'));

        return view('profil', [
            'user'    => $user,
            'success' => $this->session->getFlashdata('success'),
            'error'   => $this->session->getFlashdata('error'),
        ]);
    }

    public function updateProfil()
    {
        $userModel = new UserModel();
        $userId = $this->session->get('user_id');
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Sesi tidak valid, silakan login ulang.');
        }

        $unitKerja = $this->request->getPost('unit_kerja');
        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        // Update unit kerja
        $updateData = ['unit_kerja' => $unitKerja];

        // Update password jika diisi
        if (!empty($passwordBaru)) {
            if (empty($passwordLama) || !password_verify((string)$passwordLama, (string)$user['password'])) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai.');
            }
            if (strlen($passwordBaru) < 6) {
                return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
            }
            $passwordKonfirmasi = $this->request->getPost('password_konfirmasi');
            if ($passwordBaru !== $passwordKonfirmasi) {
                return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.');
            }
            $updateData['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $updateData);

        // Update session
        $this->session->set('unit_kerja', $unitKerja);

        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // ========================
    // MANAJEMEN USER (Admin)
    // ========================

    public function users()
    {
        $userModel = new UserModel();

        return view('users_manage', [
            'users'   => $userModel->orderBy('role', 'ASC')->orderBy('nama', 'ASC')->findAll(),
            'success' => $this->session->getFlashdata('success'),
            'error'   => $this->session->getFlashdata('error'),
        ]);
    }

    public function editUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        return view('users_edit', [
            'user'    => $user,
            'success' => $this->session->getFlashdata('success'),
            'error'   => $this->session->getFlashdata('error'),
        ]);
    }

    public function updateUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $updateData = [
            'nama'       => $this->request->getPost('nama'),
            'unit_kerja' => $this->request->getPost('unit_kerja'),
            'role'       => $this->request->getPost('role'),
        ];

        $passwordBaru = $this->request->getPost('password_baru');
        if (!empty($passwordBaru)) {
            if (strlen($passwordBaru) < 6) {
                return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
            }
            $updateData['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $updateData);

        // Update session if admin edited their own account
        if ((int)$id === (int)$this->session->get('user_id')) {
            $this->session->set([
                'nama'       => $updateData['nama'],
                'unit_kerja' => $updateData['unit_kerja'],
                'role'       => $updateData['role'],
            ]);
        }

        return redirect()->to('/users')->with('success', 'User "' . esc((string)$user['username']) . '" berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        // Jangan hapus diri sendiri
        if ((int)$id === (int)$this->session->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User "' . esc((string)$user['username']) . '" berhasil dihapus.');
    }

    // ========================
    // USER AKTIF (Admin)
    // ========================

    public function activeUsers()
    {
        $sessionPath = rtrim(WRITEPATH . 'session', '/\\');
        $expiration  = 7200; // sesuai config Session
        $now         = time();
        $active      = [];
        $seen        = [];

        foreach (glob($sessionPath . DIRECTORY_SEPARATOR . 'ci_session*') as $file) {
            if (str_ends_with($file, '.lock')) continue;

            $mtime = @filemtime($file);
            if ($mtime === false) continue;
            $age = $now - $mtime;
            if ($age > $expiration) continue;

            $raw = @file_get_contents($file);
            if (!$raw) continue;

            $data = $this->parseSessionData($raw);
            if (empty($data['isLoggedIn'])) continue;

            $username = $data['username'] ?? '';
            if ($username === '') continue;

            // Simpan sesi yang paling baru per username
            if (isset($seen[$username]) && $seen[$username] >= $mtime) continue;
            $seen[$username] = $mtime;

            $active[$username] = [
                'username'    => $username,
                'nama'        => $data['nama'] ?? '-',
                'role'        => $data['role'] ?? '-',
                'unit_kerja'  => $data['unit_kerja'] ?? '-',
                'last_active' => $mtime,
                'age_seconds' => $age,
            ];
        }

        usort($active, fn($a, $b) => $b['last_active'] - $a['last_active']);

        return view('users_active', [
            'active'   => array_values($active),
            'username' => $this->session->get('username'),
        ]);
    }

    private function parseSessionData(string $raw): array
    {
        $result = [];
        $offset = 0;
        $len    = strlen($raw);

        while ($offset < $len) {
            $barPos = strpos($raw, '|', $offset);
            if ($barPos === false) break;

            $key  = substr($raw, $offset, $barPos - $offset);
            $rest = substr($raw, $barPos + 1);

            $value      = @unserialize($rest, ['allowed_classes' => false]);
            $serialized = serialize($value);
            $offset     = $barPos + 1 + strlen($serialized);

            $result[$key] = $value;
        }

        return $result;
    }

    public function createUser()
    {
        return view('users_create', [
            'error' => $this->session->getFlashdata('error'),
        ]);
    }

    public function storeUser()
    {
        $userModel = new UserModel();

        $username = trim($this->request->getPost('username') ?? '');
        if (empty($username)) {
            return redirect()->back()->with('error', 'Username wajib diisi.')->withInput();
        }
        $nama = trim($this->request->getPost('nama') ?? '');
        if (empty($nama)) {
            return redirect()->back()->with('error', 'Nama lengkap wajib diisi.')->withInput();
        }
        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan.')->withInput();
        }

        $password = $this->request->getPost('password');
        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.')->withInput();
        }

        $userModel->insert([
            'username'   => $username,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'nama'       => $nama,
            'unit_kerja' => $this->request->getPost('unit_kerja'),
            'role'       => $this->request->getPost('role'),
        ]);

        return redirect()->to('/users')->with('success', 'User "' . esc($username) . '" berhasil ditambahkan.');
    }
}
