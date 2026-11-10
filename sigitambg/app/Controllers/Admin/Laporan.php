<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SppgModel;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $sppgModel = new SppgModel();

        $from = $this->request->getGet('from') ?: date('Y-m-01');
        $to = $this->request->getGet('to') ?: date('Y-m-d');
        $idSppg = trim((string) $this->request->getGet('id_sppg'));

        $sppgs = $sppgModel->orderBy('sppg_name', 'ASC')->findAll();
        $summary = [];

        foreach ($sppgs as $sppg) {
            if ($idSppg !== '' && $idSppg !== $sppg['id_sppg']) {
                continue;
            }

            $id = $sppg['id_sppg'];
            $pm = $db->table('penerima_manfaat')
                ->select('COALESCE(SUM(total_siswa),0) total_pm, COALESCE(SUM(porsi_besar),0) porsi_besar, COALESCE(SUM(porsi_kecil),0) porsi_kecil')
                ->where('id_sppg', $id)
                ->get()->getRowArray();

            $kegiatan = $db->table('kegiatan_aslap')
                ->where('id_sppg', $id)
                ->where('tanggal >=', $from)
                ->where('tanggal <=', $to)
                ->countAllResults();

            $pengeluaran = $db->table('pengeluaran_aslap')
                ->select('COALESCE(SUM(nominal),0) total')
                ->where('id_sppg', $id)
                ->where('tanggal >=', $from)
                ->where('tanggal <=', $to)
                ->get()->getRowArray();

            $summary[] = [
                'id_sppg' => $id,
                'sppg_name' => $sppg['sppg_name'],
                'total_pm' => (int) ($pm['total_pm'] ?? 0),
                'porsi_besar' => (int) ($pm['porsi_besar'] ?? 0),
                'porsi_kecil' => (int) ($pm['porsi_kecil'] ?? 0),
                'kegiatan' => (int) $kegiatan,
                'pengeluaran' => (float) ($pengeluaran['total'] ?? 0),
            ];
        }

        return view('admin/laporan', [
            'title' => 'Laporan Seluruh SPPG',
            'sppgs' => $sppgs,
            'summary' => $summary,
            'from' => $from,
            'to' => $to,
            'idSppg' => $idSppg,
        ]);
    }
}
