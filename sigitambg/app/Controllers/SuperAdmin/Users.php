<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\KoperasiModel;
use App\Models\SppgModel;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;
    protected SppgModel $sppgModel;
    protected KoperasiModel $koperasiModel;

    private array $levels = ['super_admin', 'admin', 'kepala', 'gizi', 'keuangan', 'aslap', 'koperasi'];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->sppgModel = new SppgModel();
        $this->koperasiModel = new KoperasiModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $level = trim((string) $this->request->getGet('level'));
        $status = trim((string) $this->request->getGet('status'));

        $builder = $this->userModel
            ->select('users.*, sppg.sppg_name, koperasi.nama_koperasi')
            ->join('sppg', 'sppg.id_sppg = users.id_sppg', 'left')
            ->join('koperasi', 'koperasi.id = users.koperasi_id', 'left');

        if ($search !== '') {
            $builder->groupStart()
                ->like('users.full_name', $search)
                ->orLike('users.username', $search)
                ->orLike('users.email', $search)
                ->orLike('users.user_level', $search)
                ->orLike('sppg.sppg_name', $search)
                ->orLike('koperasi.nama_koperasi', $search)
                ->groupEnd();
        }

        if (in_array($level, $this->levels, true)) {
            $builder->where('users.user_level', $level);
        } else {
            $level = '';
        }

        if (in_array($status, ['active', 'inactive'], true)) {
            $builder->where('users.status', $status);
        } else {
            $status = '';
        }

        $data = [
            'title' => 'Manajemen User',
            'users' => $builder
                ->orderBy('users.created_at', 'DESC')
                ->orderBy('users.full_name', 'ASC')
                ->paginate(10),
            'pager' => $this->userModel->pager,
            'search' => $search,
            'level' => $level,
            'status' => $status,
            'levels' => $this->levels,
        ];

        return view('super_admin/users/index', $data);
    }

    public function create()
    {
        return view('super_admin/users/create', [
            'title' => 'Tambah User',
            'sppgs' => $this->sppgModel->where('status', 'active')->orderBy('sppg_name', 'ASC')->findAll(),
            'koperasis' => $this->koperasiModel->where('status', 'active')->orderBy('nama_koperasi', 'ASC')->findAll(),
            'levels' => $this->levels,
        ]);
    }

    public function store()
    {
        $level = trim((string) $this->request->getPost('user_level'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $fullName = trim((string) $this->request->getPost('full_name'));
        $username = trim((string) $this->request->getPost('username')) ?: $email;

        if (!in_array($level, $this->levels, true)) {
            return redirect()->back()->withInput()->with('error', 'Role tidak valid.');
        }
        if ($fullName === '' || mb_strlen($fullName) > 100) {
            return redirect()->back()->withInput()->with('error', 'Nama lengkap wajib diisi dan maksimal 100 karakter.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Format email tidak valid.');
        }
        if (strlen($username) < 3 || strlen($username) > 50) {
            return redirect()->back()->withInput()->with('error', 'Username harus 3-50 karakter.');
        }
        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 8 karakter.');
        }
        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan.');
        }
        if ($this->userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        [$idSppg, $koperasiId, $error] = $this->resolveAssignment($level);
        if ($error !== null) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        $ok = $this->userModel->insert([
            'id_sppg' => $idSppg,
            'koperasi_id' => $koperasiId,
            'username' => $username,
            'email' => $email,
            'full_name' => $fullName,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'user_level' => $level,
            'role' => in_array($level, ['admin', 'super_admin'], true) ? $level : 'user',
            'status' => 'active',
        ]);

        if (!$ok) {
            return redirect()->back()->withInput()->with('error', 'User gagal dibuat. Silakan periksa data.');
        }

        return redirect()->to(base_url('super-admin/users'))->with('success', 'User berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('super-admin/users'))->with('error', 'User tidak ditemukan.');
        }

        return view('super_admin/users/edit', [
            'title' => 'Edit User',
            'user' => $user,
            'sppgs' => $this->sppgModel->where('status', 'active')->orderBy('sppg_name', 'ASC')->findAll(),
            'koperasis' => $this->koperasiModel->where('status', 'active')->orderBy('nama_koperasi', 'ASC')->findAll(),
            'levels' => $this->levels,
        ]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('super-admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $level = trim((string) $this->request->getPost('user_level'));
        $email = trim((string) $this->request->getPost('email'));
        $username = trim((string) $this->request->getPost('username'));
        $fullName = trim((string) $this->request->getPost('full_name'));
        $password = (string) $this->request->getPost('password');

        if (!in_array($level, $this->levels, true)) {
            return redirect()->back()->withInput()->with('error', 'Role tidak valid.');
        }
        if ($fullName === '' || mb_strlen($fullName) > 100) {
            return redirect()->back()->withInput()->with('error', 'Nama lengkap wajib diisi dan maksimal 100 karakter.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Format email tidak valid.');
        }
        if (strlen($username) < 3 || strlen($username) > 50) {
            return redirect()->back()->withInput()->with('error', 'Username harus 3-50 karakter.');
        }

        $emailExists = $this->userModel->where('email', $email)->where('id !=', $id)->first();
        if ($emailExists) {
            return redirect()->back()->withInput()->with('error', 'Email sudah digunakan user lain.');
        }
        $usernameExists = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($usernameExists) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan user lain.');
        }

        // Akun Super Admin yang sedang digunakan tidak boleh diturunkan role-nya sendiri.
        if ((int) $id === (int) session('user_id') && $user['user_level'] === 'super_admin' && $level !== 'super_admin') {
            return redirect()->back()->withInput()->with('error', 'Akun Super Admin yang sedang digunakan tidak boleh diturunkan rolenya.');
        }

        [$idSppg, $koperasiId, $error] = $this->resolveAssignment($level);
        if ($error !== null) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        $payload = [
            'id_sppg' => $idSppg,
            'koperasi_id' => $koperasiId,
            'username' => $username,
            'email' => $email,
            'full_name' => $fullName,
            'user_level' => $level,
            'role' => in_array($level, ['admin', 'super_admin'], true) ? $level : 'user',
        ];

        if ($password !== '') {
            if (strlen($password) < 8) {
                return redirect()->back()->withInput()->with('error', 'Password baru minimal 8 karakter.');
            }
            $payload['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $payload);

        return redirect()->to(base_url('super-admin/users'))->with('success', 'Data user berhasil diperbarui.');
    }

    public function toggle($id)
    {
        if ((int) $id === (int) session('user_id')) {
            return redirect()->back()->with('error', 'Akun yang sedang digunakan tidak dapat dinonaktifkan.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->update($id, [
            'status' => ($user['status'] ?? 'active') === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->back()->with('success', 'Status user berhasil diubah.');
    }

    public function resetPassword($id)
    {
        if ((int) $id === (int) session('user_id')) {
            return redirect()->back()->with('error', 'Gunakan pengaturan akun sendiri untuk mengganti password akun ini.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $temp = 'Sigita' . date('Y') . '!';
        $this->userModel->update($id, [
            'password' => password_hash($temp, PASSWORD_DEFAULT),
        ]);

        return redirect()->back()->with('success', 'Password ' . $user['full_name'] . ' direset ke password sementara: ' . $temp . '. Segera ganti setelah login.');
    }

    public function delete($id)
    {
        if ((int) $id === (int) session('user_id')) {
            return redirect()->back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        if ($user['user_level'] === 'super_admin') {
            $count = $this->userModel->where('user_level', 'super_admin')->where('status', 'active')->countAllResults();
            if ($count <= 1) {
                return redirect()->back()->with('error', 'Super Admin terakhir tidak dapat dihapus. Buat Super Admin pengganti terlebih dahulu.');
            }
        }

        if (!$this->userModel->delete($id)) {
            return redirect()->back()->with('error', 'User gagal dihapus.');
        }

        return redirect()->back()->with('success', 'User ' . $user['full_name'] . ' berhasil dihapus.');
    }

    private function resolveAssignment(string $level): array
    {
        $idSppg = trim((string) $this->request->getPost('id_sppg')) ?: null;
        $koperasiId = (int) ($this->request->getPost('koperasi_id') ?: 0) ?: null;

        if (in_array($level, ['kepala', 'gizi', 'keuangan', 'aslap'], true)) {
            if (!$idSppg || !$this->sppgModel->find($idSppg)) {
                return [null, null, 'SPPG wajib dipilih untuk role ini.'];
            }
            return [$idSppg, null, null];
        }

        if ($level === 'koperasi') {
            if (!$koperasiId || !$this->koperasiModel->find($koperasiId)) {
                return [null, null, 'Koperasi wajib dipilih untuk role Koperasi.'];
            }
            return [null, $koperasiId, null];
        }

        return [null, null, null];
    }
}
