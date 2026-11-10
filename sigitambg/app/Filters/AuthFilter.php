<?php

namespace App\Filters;

use App\Models\UserActivityLogModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        if (!session()->get('logged_in')) {
            return;
        }

        $method = strtoupper($request->getMethod());
        $uri = trim($request->getUri()->getPath(), '/');

        // Jangan simpan request terhadap endpoint asset/static apabila suatu saat
        // filter auth dipasang pada pola yang lebih luas.
        if ($uri === '' || str_contains($uri, 'favicon.ico')) {
            return;
        }

        [$module, $activity] = $this->describe($uri, $method);

        (new UserActivityLogModel())->record([
            'user_id' => session('user_id') ? (int) session('user_id') : null,
            'id_sppg' => (session('user_level') === 'koperasi' ? (session('koperasi_active_sppg') ?: null) : (session('id_sppg') ?: null)),
            'user_level' => (string) (session('user_level') ?? ''),
            'username' => (string) (session('email') ?? ''),
            'activity' => $activity,
            'module' => $module,
            'method' => $method,
            'uri' => '/' . $uri,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => substr((string) $request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function describe(string $uri, string $method): array
    {
        $segments = explode('/', $uri);
        $first = $segments[0] ?? '';
        $moduleMap = [
            'admin' => 'Administrasi Pusat',
            'super-admin' => 'Administrasi Pusat',
            'gizi' => 'Gizi',
            'aslap' => 'Aslap',
            'keuangan' => 'Keuangan',
            'master' => 'Manajemen User',
            'dashboard' => 'Dashboard',
            'auth' => 'Autentikasi',
        ];

        $module = $moduleMap[$first] ?? ucfirst(str_replace('-', ' ', $first));

        if ($method === 'GET') {
            $activity = 'Membuka halaman';
        } elseif ($method === 'POST') {
            $activity = 'Mengirim data';
        } elseif (in_array($method, ['PUT', 'PATCH'], true)) {
            $activity = 'Memperbarui data';
        } elseif ($method === 'DELETE') {
            $activity = 'Menghapus data';
        } else {
            $activity = 'Melakukan aktivitas';
        }

        if ($module === 'Autentikasi') {
            $activity = 'Mengakses autentikasi';
        }

        return [$module, $activity];
    }
}
