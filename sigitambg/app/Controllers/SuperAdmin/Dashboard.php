<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\KoperasiModel;
use App\Models\SppgModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $sppgModel = new SppgModel();
        $userModel = new UserModel();
        $koperasiModel = new KoperasiModel();

        $totalSppg = (int) $sppgModel->countAllResults();
        $activeSppg = (int) $sppgModel->where('status', 'active')->countAllResults();
        $inactiveSppg = $totalSppg - $activeSppg;

        $totalUser = (int) $userModel->countAllResults();
        $activeUser = (int) $userModel->where('status', 'active')->countAllResults();
        $inactiveUser = $totalUser - $activeUser;

        $totalKoperasi = (int) $koperasiModel->countAllResults();
        $activeKoperasi = (int) $koperasiModel->where('status', 'active')->countAllResults();

        $totalPM = 0;
        if ($db->tableExists('penerima_manfaat')) {
            $totalPM = (int) ($db->table('penerima_manfaat')
                ->selectSum('total_siswa')
                ->get()
                ->getRowArray()['total_siswa'] ?? 0);
        }

        $totalKegiatan = 0;
        if ($db->tableExists('kegiatan_aslap')) {
            $totalKegiatan = (int) $db->table('kegiatan_aslap')->countAllResults();
        }

        $pendingRequest = 0;
        if ($db->tableExists('bahan_request')) {
            $pendingRequest = (int) $db->table('bahan_request')
                ->where('status', 'menunggu')
                ->countAllResults();
        }

        $assignedSppg = 0;
        if ($db->tableExists('koperasi_sppg')) {
            $assignedSppg = (int) $db->table('koperasi_sppg')
                ->where('status', 'active')
                ->countAllResults();
        }

        $roleCounts = [];
        $roleRows = $db->table('users')
            ->select('user_level, COUNT(*) AS jumlah')
            ->groupBy('user_level')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();
        foreach ($roleRows as $row) {
            $roleCounts[$row['user_level']] = (int) $row['jumlah'];
        }

        $recentSppgs = $sppgModel
            ->select('id_sppg, sppg_name, status, created_at')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        foreach ($recentSppgs as &$sppg) {
            $sppg['jumlah_user'] = (int) $userModel
                ->where('id_sppg', $sppg['id_sppg'])
                ->countAllResults();
        }
        unset($sppg);

        return view('super_admin/dashboard', [
            'title' => 'Dashboard Super Admin',
            'totalSppg' => $totalSppg,
            'activeSppg' => $activeSppg,
            'inactiveSppg' => $inactiveSppg,
            'totalUser' => $totalUser,
            'activeUser' => $activeUser,
            'inactiveUser' => $inactiveUser,
            'totalKoperasi' => $totalKoperasi,
            'activeKoperasi' => $activeKoperasi,
            'assignedSppg' => $assignedSppg,
            'totalPM' => $totalPM,
            'totalKegiatan' => $totalKegiatan,
            'pendingRequest' => $pendingRequest,
            'roleCounts' => $roleCounts,
            'recentSppgs' => $recentSppgs,
        ]);
    }
}
