<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session('user_level') !== 'kepala') {
            return redirect()->to('/dashboard');
        }

        $users = $this->userModel
            ->where('id_sppg', session('id_sppg'))
            ->orderBy('full_name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Manajemen User',
            'users' => $users
        ];

        return view('master/users/index', $data);
    }

    public function create()
    {
        if (session('user_level') !== 'kepala') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah User'
        ];

        return view('master/users/create', $data);
    }

    public function store()
    {
        if (session('user_level') !== 'kepala') {
            return redirect()->to('/dashboard');
        }

        $cekLevel = $this->userModel
            ->where('id_sppg', session('id_sppg'))
            ->where('user_level', $this->request->getPost('user_level'))
            ->first();

        if ($cekLevel) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Level ' . $this->request->getPost('user_level') . ' sudah terdaftar pada SPPG ini.');
        }

        $this->userModel->save([
            'id_sppg'    => session('id_sppg'),
            'email'      => $this->request->getPost('email'),
            'full_name'  => $this->request->getPost('full_name'),
            'password'   => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'user_level' => $this->request->getPost('user_level'),
            'role'       => 'user',
            'username'   => $this->request->getPost('email')
        ]);

        return redirect()->to('/master/users')
            ->with('success', 'User berhasil ditambahkan');
    }
}
