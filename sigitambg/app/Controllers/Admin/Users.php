<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $level = trim((string) $this->request->getGet('level'));
        $status = trim((string) $this->request->getGet('status'));
        $levels = ['admin','kepala','gizi','keuangan','aslap','koperasi'];

        $builder = $this->userModel
            ->select('users.*, sppg.sppg_name, koperasi.nama_koperasi')
            ->join('sppg', 'sppg.id_sppg = users.id_sppg', 'left')
            ->join('koperasi', 'koperasi.id = users.koperasi_id', 'left')
            ->where('users.user_level !=', 'super_admin');

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
        if (in_array($level, $levels, true)) $builder->where('users.user_level', $level); else $level='';
        if (in_array($status, ['active','inactive'], true)) $builder->where('users.status', $status); else $status='';

        $active = $this->userModel->where('user_level !=', 'super_admin')->where('users.status','active')->countAllResults();
        $inactive = $this->userModel->where('user_level !=', 'super_admin')->where('users.status','inactive')->countAllResults();
        $total = $this->userModel->where('user_level !=', 'super_admin')->countAllResults();

        return view('admin/users', [
            'title' => 'Monitoring User',
            'users' => $builder->orderBy('users.created_at','DESC')->orderBy('users.full_name','ASC')->paginate(10),
            'pager' => $this->userModel->pager,
            'search' => $search,
            'level' => $level,
            'status' => $status,
            'levels' => $levels,
            'summary' => ['total'=>$total,'active'=>$active,'inactive'=>$inactive],
        ]);
    }

    public function toggle($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->back()->with('error', 'User tidak ditemukan.');
        if ($user['user_level'] === 'super_admin') return redirect()->back()->with('error', 'Admin tidak dapat menonaktifkan Super Admin.');
        if ((int)$id === (int)session('user_id')) return redirect()->back()->with('error', 'Akun yang sedang digunakan tidak dapat dinonaktifkan.');
        $this->userModel->update($id, ['status'=>($user['status']??'active')==='active'?'inactive':'active']);
        return redirect()->back()->with('success','Status user berhasil diubah.');
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->back()->with('error','User tidak ditemukan.');
        if ($user['user_level'] === 'super_admin') return redirect()->back()->with('error','Admin tidak dapat mereset password Super Admin.');
        $temp='Sigita'.date('Y').'!';
        $this->userModel->update($id,['password'=>password_hash($temp,PASSWORD_DEFAULT)]);
        return redirect()->back()->with('success','Password '.$user['full_name'].' direset menjadi: '.$temp.'. Segera ganti setelah login.');
    }
}
