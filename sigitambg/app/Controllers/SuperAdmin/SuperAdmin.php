<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\AdminSppgModel;
use App\Models\KoperasiModel;
use App\Models\KoperasiSppgModel;
use App\Models\SppgModel;
use App\Models\UserModel;

class SuperAdmin extends BaseController
{
    protected SppgModel $sppgModel;
    protected UserModel $userModel;
    protected KoperasiModel $koperasiModel;
    protected AdminSppgModel $adminSppgModel;
    protected KoperasiSppgModel $koperasiSppgModel;

    public function __construct()
    {
        $this->sppgModel = new SppgModel();
        $this->userModel = new UserModel();
        $this->koperasiModel = new KoperasiModel();
        $this->adminSppgModel = new AdminSppgModel();
        $this->koperasiSppgModel = new KoperasiSppgModel();
    }

    protected function denyIfNotSuperAdmin()
    {
        if (session('user_level') !== 'super_admin') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Akses Super Admin tidak diizinkan.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $db = \Config\Database::connect();
        $data = [
            'title' => 'Super Admin',
            'total_sppg' => $this->sppgModel->countAllResults(),
            'total_user' => $this->userModel->countAllResults(),
            'total_koperasi' => $this->koperasiModel->countAllResults(),
            'total_admin' => $this->userModel->where('user_level', 'admin')->countAllResults(),
        ];
        $data['total_pm'] = (int) ($db->table('penerima_manfaat')->selectSum('total_siswa')->get()->getRow('total_siswa') ?? 0);
        return view('super_admin/index', $data);
    }

    public function sppg()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        return view('super_admin/sppg', [
            'title' => 'Master SPPG',
            'sppgs' => $this->sppgModel->orderBy('sppg_name')->findAll(),
        ]);
    }

    public function storeSppg()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $id = trim((string) $this->request->getPost('id_sppg'));
        $name = trim((string) $this->request->getPost('sppg_name'));
        if ($id === '' || $name === '') return redirect()->back()->withInput()->with('error', 'ID SPPG dan nama SPPG wajib diisi.');
        if ($this->sppgModel->find($id)) return redirect()->back()->withInput()->with('error', 'ID SPPG sudah digunakan.');
        $this->sppgModel->insert([
            'id_sppg' => $id, 'sppg_name' => $name,
            'address' => trim((string) $this->request->getPost('address')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'established_date' => $this->request->getPost('established_date') ?: null,
            'status' => 'active',
        ]);
        return redirect()->to(base_url('super-admin/sppg'))->with('success', 'SPPG berhasil ditambahkan.');
    }

    public function toggleSppg($id)
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $row = $this->sppgModel->find($id);
        if (!$row) return redirect()->back()->with('error', 'SPPG tidak ditemukan.');
        $this->sppgModel->update($id, ['status' => $row['status'] === 'active' ? 'inactive' : 'active']);
        return redirect()->back()->with('success', 'Status SPPG berhasil diperbarui.');
    }

    public function users()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $users = $this->userModel->orderBy('full_name')->findAll();
        $sppgs = $this->sppgModel->where('status', 'active')->orderBy('sppg_name')->findAll();
        $koperasis = $this->koperasiModel->where('status', 'active')->orderBy('nama_koperasi')->findAll();
        $adminAssignments = [];
        foreach ($this->adminSppgModel->where('status', 'active')->findAll() as $row) {
            $adminAssignments[$row['user_id']][] = $row['id_sppg'];
        }
        return view('super_admin/users', compact('users', 'sppgs', 'koperasis', 'adminAssignments') + ['title' => 'Manajemen User']);
    }

    public function storeUser()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $level = trim((string) $this->request->getPost('user_level'));
        $allowed = ['super_admin', 'admin', 'kepala', 'gizi', 'keuangan', 'aslap', 'koperasi'];
        if (!in_array($level, $allowed, true)) return redirect()->back()->withInput()->with('error', 'Role user tidak valid.');
        $email = trim((string) $this->request->getPost('email'));
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        if ($username === '' || $email === '' || $password === '') return redirect()->back()->withInput()->with('error', 'Username, email, dan password wajib diisi.');
        if ($this->userModel->where('username', $username)->orWhere('email', $email)->first()) return redirect()->back()->withInput()->with('error', 'Username atau email sudah digunakan.');

        $idSppg = $this->request->getPost('id_sppg') ?: null;
        $koperasiId = $this->request->getPost('koperasi_id') ?: null;
        if (in_array($level, ['kepala', 'gizi', 'keuangan', 'aslap'], true) && !$idSppg) return redirect()->back()->withInput()->with('error', 'SPPG wajib dipilih untuk role operasional.');
        if ($level === 'koperasi' && !$koperasiId) return redirect()->back()->withInput()->with('error', 'Koperasi wajib dipilih untuk role Koperasi.');
        if (in_array($level, ['admin', 'super_admin'], true)) $idSppg = null;

        $this->userModel->insert([
            'id_sppg' => $idSppg,
            'koperasi_id' => $koperasiId,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'user_level' => $level,
            'role' => $level === 'super_admin' || $level === 'admin' ? 'admin' : 'user',
            'status' => 'active',
        ]);
        return redirect()->to(base_url('super-admin/users'))->with('success', 'User berhasil dibuat.');
    }

    public function toggleUser($id)
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->back()->with('error', 'User tidak ditemukan.');
        if ((int)$user['id'] === (int)session('user_id')) return redirect()->back()->with('error', 'Akun yang sedang digunakan tidak dapat dinonaktifkan.');
        $this->userModel->update($id, ['status' => $user['status'] === 'active' ? 'inactive' : 'active']);
        return redirect()->back()->with('success', 'Status user berhasil diperbarui.');
    }

    public function koperasi()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $koperasis = $this->koperasiModel->orderBy('nama_koperasi')->findAll();
        $sppgs = $this->sppgModel->where('status', 'active')->orderBy('sppg_name')->findAll();
        $koperasiAssignments = [];
        foreach ($this->koperasiSppgModel->where('status', 'active')->findAll() as $row) {
            $koperasiAssignments[$row['koperasi_id']][] = $row['id_sppg'];
        }
        return view('super_admin/koperasi', [
            'title' => 'Master Koperasi', 'koperasis' => $koperasis, 'sppgs' => $sppgs, 'koperasiAssignments' => $koperasiAssignments,
        ]);
    }

    public function storeKoperasi()
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $kode = trim((string)$this->request->getPost('kode_koperasi'));
        $nama = trim((string)$this->request->getPost('nama_koperasi'));
        if ($kode === '' || $nama === '') return redirect()->back()->withInput()->with('error', 'Kode dan nama koperasi wajib diisi.');
        if ($this->koperasiModel->where('kode_koperasi', $kode)->first()) return redirect()->back()->withInput()->with('error', 'Kode koperasi sudah digunakan.');
        $this->koperasiModel->insert([
            'kode_koperasi'=>$kode, 'nama_koperasi'=>$nama,
            'alamat'=>trim((string)$this->request->getPost('alamat')),
            'telepon'=>trim((string)$this->request->getPost('telepon')),
            'email'=>trim((string)$this->request->getPost('email')), 'status'=>'active'
        ]);
        return redirect()->to(base_url('super-admin/koperasi'))->with('success', 'Koperasi berhasil ditambahkan.');
    }

    public function assignKoperasiSppg($koperasiId)
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $koperasi = $this->koperasiModel->find($koperasiId);
        if (!$koperasi) return redirect()->back()->with('error', 'Koperasi tidak ditemukan.');
        $selected = $this->request->getPost('id_sppg') ?? [];
        if (!is_array($selected)) $selected = [$selected];
        $this->koperasiSppgModel->where('koperasi_id', $koperasiId)->delete();
        foreach ($selected as $idSppg) {
            if ($this->sppgModel->where('id_sppg', $idSppg)->where('status', 'active')->first()) {
                $this->koperasiSppgModel->insert(['koperasi_id'=>$koperasiId, 'id_sppg'=>$idSppg, 'status'=>'active', 'tanggal_mulai'=>date('Y-m-d')]);
            }
        }
        return redirect()->back()->with('success', 'Penugasan SPPG koperasi berhasil disimpan.');
    }

    public function assignAdminSppg($userId)
    {
        if ($redirect = $this->denyIfNotSuperAdmin()) return $redirect;
        $user = $this->userModel->find($userId);
        if (!$user || $user['user_level'] !== 'admin') return redirect()->back()->with('error', 'Admin tidak ditemukan.');
        $selected = $this->request->getPost('id_sppg') ?? [];
        if (!is_array($selected)) $selected = [$selected];
        $this->adminSppgModel->where('user_id', $userId)->delete();
        foreach ($selected as $idSppg) {
            if ($this->sppgModel->where('id_sppg', $idSppg)->where('status', 'active')->first()) {
                $this->adminSppgModel->insert(['user_id'=>$userId, 'id_sppg'=>$idSppg, 'status'=>'active']);
            }
        }
        return redirect()->back()->with('success', 'Cakupan SPPG Admin berhasil disimpan.');
    }
}
