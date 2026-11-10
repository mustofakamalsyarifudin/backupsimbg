<?php
namespace App\Controllers\Keuangan;

use App\Controllers\BaseController;
use App\Models\SppgModel;

abstract class BaseKeuangan extends BaseController
{
    protected function ensureKeuangan(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session('user_level') !== 'keuangan') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Fitur ini hanya untuk akun Keuangan.');
        }
        if (!session('id_sppg')) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Akun Keuangan belum terhubung dengan SPPG.');
        }
        return null;
    }

    protected function sppgName(): string
    {
        $row = (new SppgModel())->where('id_sppg', session('id_sppg'))->first();
        return (string) ($row['sppg_name'] ?? session('id_sppg'));
    }
}
