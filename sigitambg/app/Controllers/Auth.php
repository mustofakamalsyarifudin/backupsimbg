<?php

namespace App\Controllers;

use App\Models\UserActivityLogModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan');
        }

        if (($user['status'] ?? 'active') !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda sedang nonaktif. Hubungi administrator.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        session()->set([
            'user_id'    => $user['id'],
            'email'      => $user['email'],
            'full_name'  => $user['full_name'],
            'user_level' => $user['user_level'],
            'role'       => $user['role'],
            'id_sppg'    => $user['id_sppg'],
            'koperasi_id' => $user['koperasi_id'] ?? null,
            'logged_in'  => true
        ]);

        (new UserActivityLogModel())->record([
            'user_id' => (int) $user['id'],
            'id_sppg' => $user['id_sppg'] ?: null,
            'user_level' => (string) $user['user_level'],
            'username' => (string) ($user['email'] ?? ''),
            'activity' => 'Login berhasil',
            'module' => 'Autentikasi',
            'method' => 'POST',
            'uri' => '/auth/processLogin',
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (in_array($user['user_level'], ['admin', 'super_admin'], true)) {
            return redirect()->to($user['user_level'] === 'super_admin' ? '/super-admin' : '/admin');
        }

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        if (session()->get('logged_in')) {
            (new UserActivityLogModel())->record([
                'user_id' => session('user_id') ? (int) session('user_id') : null,
                'id_sppg' => session('id_sppg') ?: null,
                'user_level' => (string) (session('user_level') ?? ''),
                'username' => (string) (session('email') ?? ''),
                'activity' => 'Logout',
                'module' => 'Autentikasi',
                'method' => 'GET',
                'uri' => '/auth/logout',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        session()->destroy();

        return redirect()->to('/');
    }
}
