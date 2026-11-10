<?php

namespace App\Controllers;

use App\Models\MenuGiziModel;
use App\Models\MasterBahanModel;
use App\Models\SppgModel;
use App\Models\KegiatanAslapModel;
use App\Models\PengeluaranAslapModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $level = session('user_level');

        if ($level === 'super_admin') {
            return redirect()->to('/super-admin');
        }

        if ($level === 'admin') {
            return redirect()->to('/admin');
        }

        if ($level === 'koperasi') {
            return redirect()->to('/koperasi');
        }

        switch ($level) {

            case 'kepala':
                $sppgModel = new SppgModel();
                $bahanBakuModel = new \App\Models\BahanBakuModel();

                $idSppg = session('id_sppg');
                $sppg = $sppgModel->where('id_sppg', $idSppg)->first();

                $data = [
                    'sppg' => $sppg,
                    'pendingPengadaan' => $bahanBakuModel->where('id_sppg', $idSppg)->where('status', 'waiting_kepala')->countAllResults(),
                    'approvalSelesai' => $bahanBakuModel->where('id_sppg', $idSppg)->whereIn('status', ['waiting_koperasi','procurement','completed'])->countAllResults(),
                    'totalPengajuan' => $bahanBakuModel->where('id_sppg', $idSppg)->countAllResults(),
                ];

                return view('dashboard/kepala', $data);

            case 'gizi':

                $menuModel = new MenuGiziModel();
                $bahanModel = new MasterBahanModel();
                $sppgModel = new SppgModel();

                $sppg = $sppgModel
                    ->where('id_sppg', session('id_sppg'))
                    ->first();
                $idSppg = session('id_sppg');

                $db = \Config\Database::connect();

                $ringkasanPM = $db
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
                    ->selectSum(
                        'jumlah_alergi'
                    )
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


                $menuHariIni = $menuModel
                    ->where(
                        'id_sppg',
                        $idSppg
                    )
                    ->findAll();

                $data = [

                    'sppg' => $sppg,

                    'totalHariIni' => $menuModel
                        ->where('id_sppg', $idSppg)
                        ->countAllResults(),

                    'totalBulanIni' => $menuModel
                        ->where('id_sppg', $idSppg)
                        ->countAllResults(),

                    'totalBahan' => $bahanModel
                        ->where('id_sppg', $idSppg)
                        ->countAllResults(),

                    'totalPM' =>
                    $ringkasanPM['total_pm'] ?? 0,

                    'porsiBesar' =>
                    $ringkasanPM['porsi_besar'] ?? 0,

                    'porsiKecil' =>
                    $ringkasanPM['porsi_kecil'] ?? 0,
                    'menuHariIni' => $menuHariIni,

                    'totalAlergi' =>
                    $totalAlergi['jumlah_alergi'] ?? 0

                ];

                return view('dashboard/gizi', $data);
            case 'keuangan':
                // Gunakan controller Keuangan khusus agar dashboard menerima
                // seluruh data (nama SPPG, approval queue, dan ringkasan).
                return redirect()->to(base_url('keuangan'));

            case 'aslap':

                $db = \Config\Database::connect();

                $idSppg = session('id_sppg');

                $totalPM = $db->table('penerima_manfaat')
                    ->selectSum('total_siswa')
                    ->where('id_sppg', $idSppg)
                    ->get()
                    ->getRowArray();

                $porsiBesar = $db->table('penerima_manfaat')
                    ->selectSum('porsi_besar')
                    ->where('id_sppg', $idSppg)
                    ->get()
                    ->getRowArray();

                $porsiKecil = $db->table('penerima_manfaat')
                    ->selectSum('porsi_kecil')
                    ->where('id_sppg', $idSppg)
                    ->get()
                    ->getRowArray();

                $totalSekolah = $db->table('penerima_manfaat')
                    ->where('id_sppg', $idSppg)
                    ->countAllResults();

                $totalAlergi = $db->table('pm_kelas k')
                    ->selectSum('k.jumlah_alergi')
                    ->join(
                        'penerima_manfaat p',
                        'p.id = k.pm_id'
                    )
                    ->where('p.id_sppg', $idSppg)
                    ->get()
                    ->getRowArray();

                /**
                 * ============================================================
                 * RINGKASAN PENERIMA MANFAAT PER JENJANG
                 * ============================================================
                 */
                $kategori = $db->table('pm_jenjang j')
                    ->select(
                        '
    j.jenjang,
    SUM(k.jumlah_siswa) AS total,
    SUM(k.jumlah_alergi) AS total_alergi
    '
                    )
                    ->join(
                        'pm_kelas k',
                        'k.jenjang_id = j.id',
                        'left'
                    )
                    ->join(
                        'penerima_manfaat p',
                        'p.id = j.pm_id',
                        'inner'
                    )
                    ->where(
                        'p.id_sppg',
                        $idSppg
                    )
                    ->groupBy(
                        'j.jenjang'
                    )
                    ->orderBy(
                        'j.jenjang',
                        'ASC'
                    )
                    ->get()
                    ->getResultArray();



                $belumLengkap = $db->table('penerima_manfaat')
                    ->where('id_sppg', $idSppg)
                    ->where('total_siswa', 0)
                    ->countAllResults();

                $kegiatanModel =
                    new KegiatanAslapModel();

                $pengeluaranModel =
                    new PengeluaranAslapModel();

                $totalKegiatan =
                    $kegiatanModel

                    ->where(
                        'id_sppg',
                        session('id_sppg')
                    )

                    ->countAllResults();

                $pengeluaranBulanIni =
                    $pengeluaranModel

                    ->where(
                        'id_sppg',
                        session('id_sppg')
                    )

                    ->where(
                        'MONTH(tanggal)',
                        date('m')
                    )

                    ->selectSum(
                        'nominal'
                    )

                    ->first();

                $data = [

                    'totalPM' => $totalPM['total_siswa'] ?? 0,

                    'porsiBesar' => $porsiBesar['porsi_besar'] ?? 0,

                    'porsiKecil' => $porsiKecil['porsi_kecil'] ?? 0,

                    'totalSekolah' => $totalSekolah,

                    'totalAlergi' => $totalAlergi['jumlah_alergi'] ?? 0,

                    'kategori' => $kategori,
                    'totalKegiatan' =>
                    $totalKegiatan,

                    'pengeluaranBulanIni' =>
                    $pengeluaranBulanIni['nominal']
                        ?? 0,

                    'belumLengkap' => $belumLengkap

                ];

                return view(
                    'dashboard/aslap',
                    $data
                );

            default:
                return view('dashboard/index');
        }
    }
}
