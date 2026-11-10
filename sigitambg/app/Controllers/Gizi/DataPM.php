<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;

class DataPM extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $idSppg = session('id_sppg');

        $ringkasan = $db
            ->table('penerima_manfaat')
            ->select('
                SUM(total_siswa) as total_pm,
                SUM(porsi_besar) as porsi_besar,
                SUM(porsi_kecil) as porsi_kecil
            ')
            ->where(
                'id_sppg',
                $idSppg
            )
            ->get()
            ->getRowArray();

        $totalAlergi = $db
            ->table('pm_kelas k')
            ->selectSum('jumlah_alergi')
            ->join(
                'penerima_manfaat p',
                'p.id = k.pm_id'
            )
            ->where(
                'p.id_sppg',
                $idSppg
            )
            ->get()
            ->getRowArray();

        $detail = $db
            ->table('penerima_manfaat p')
            ->select('
                p.sekolah_nama,
                p.sub_kategori,
                k.nama_kelas,
                k.jumlah_siswa,
                k.jumlah_alergi,
                k.catatan_alergi
            ')
            ->join(
                'pm_kelas k',
                'k.pm_id = p.id'
            )
            ->where(
                'p.id_sppg',
                $idSppg
            )
            ->orderBy(
                'p.sekolah_nama',
                'ASC'
            )
            ->orderBy(
                'k.nama_kelas',
                'ASC'
            )
            ->get()
            ->getResultArray();

        $data = [

            'title' => 'Data PM',

            'ringkasan' => $ringkasan,

            'totalAlergi' =>
            $totalAlergi['jumlah_alergi'] ?? 0,

            'detail' => $detail

        ];

        return view(
            'gizi/data_pm/index',
            $data
        );
    }
}
