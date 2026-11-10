<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SppgModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $sppgModel = new SppgModel();
        $userModel = new UserModel();

        $data = [
            'title' => 'Dashboard Admin',
            'totalSppg' => $sppgModel->where('status', 'active')->countAllResults(),
            'totalUser' => $userModel->where('status', 'active')->countAllResults(),
            'totalPM' => (int) ($db->table('penerima_manfaat')->selectSum('total_siswa')->get()->getRowArray()['total_siswa'] ?? 0),
            'totalKegiatan' => (int) $db->table('kegiatan_aslap')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
