<?php

namespace App\Controllers\Aslap;

use App\Controllers\BaseController;
use App\Models\PenerimaManfaatModel;
use App\Models\PMKelasModel;
use App\Models\PMJenjangModel;

class PenerimaManfaat extends BaseController
{
    protected $pmModel;
    protected $kelasModel;
    protected $jenjangModel;

    public function __construct()
    {
        $this->pmModel = new PenerimaManfaatModel();
        $this->kelasModel = new PMKelasModel();
        $this->jenjangModel = new PMJenjangModel();
    }

    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index()
    {
        $pms = $this->pmModel
            ->where('id_sppg', session('id_sppg'))
            ->orderBy('sekolah_nama', 'ASC')
            ->findAll();

        foreach ($pms as &$pm) {

            $alergi = $this->kelasModel
                ->selectSum('jumlah_alergi')
                ->where('pm_id', $pm['id'])
                ->first();

            $pm['total_alergi'] =
                (int) ($alergi['jumlah_alergi'] ?? 0);
        }

        return view(
            'aslap/penerima_manfaat/index',
            [
                'pms' => $pms
            ]
        );
    }

    /**
     * ============================================================
     * STORE PENERIMA MANFAAT
     * ============================================================
     */
    public function store()
    {
        $sekolahNama = trim(
            $this->request->getPost('sekolah_nama')
        );

        $sekolahAlamat = trim(
            $this->request->getPost('sekolah_alamat')
        );

        $kategori = trim(
            $this->request->getPost('kategori')
        );

        if ($sekolahNama === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama sekolah/posyandu wajib diisi.'
                );
        }

        if ($kategori === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kategori wajib dipilih.'
                );
        }

        $this->pmModel->insert([

            'id_sppg' => session('id_sppg'),

            'sekolah_nama' => $sekolahNama,

            'sekolah_alamat' => $sekolahAlamat,

            'kategori' => $kategori,

            'porsi_besar' => 0,

            'porsi_kecil' => 0,

            'total_siswa' => 0,

            'created_by' => session('user_id')

        ], true);

        $id = $this->pmModel->getInsertID();

        return redirect()->to(
            base_url(
                'aslap/penerima-manfaat/detail/' . $id
            )
        )->with(
            'success',
            'Penerima manfaat berhasil ditambahkan.'
        );
    }

    /**
     * ============================================================
     * DELETE PENERIMA MANFAAT
     * ============================================================
     */
    public function delete($id)
    {
        $pm = $this->pmModel
            ->where('id', $id)
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data penerima manfaat tidak ditemukan.'
                );
        }

        // Hapus detail kelas/kelompok
        $this->kelasModel
            ->where('pm_id', $id)
            ->delete();

        // Hapus jenjang
        $this->jenjangModel
            ->where('pm_id', $id)
            ->delete();

        // Hapus penerima manfaat
        $this->pmModel
            ->delete($id);

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    /**
     * ============================================================
     * DETAIL
     * ============================================================
     */
    public function detail($id)
    {
        $pm = $this->pmModel
            ->where('id', $id)
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()->to(
                base_url(
                    'aslap/penerima-manfaat'
                )
            )->with(
                'error',
                'Data penerima manfaat tidak ditemukan.'
            );
        }

        $totalAlergi = $this->kelasModel
            ->selectSum('jumlah_alergi')
            ->where('pm_id', $id)
            ->first();

        $kelas = $this->kelasModel
            ->select(
                'pm_kelas.*,
                 pm_jenjang.jenjang'
            )
            ->join(
                'pm_jenjang',
                'pm_jenjang.id = pm_kelas.jenjang_id',
                'left'
            )
            ->where(
                'pm_kelas.pm_id',
                $id
            )
            ->orderBy(
                'pm_jenjang.jenjang',
                'ASC'
            )
            ->orderBy(
                'pm_kelas.nama_kelas',
                'ASC'
            )
            ->findAll();

        $jenjang = $this->jenjangModel
            ->where(
                'pm_id',
                $id
            )
            ->orderBy(
                'jenjang',
                'ASC'
            )
            ->findAll();


        /**
         * ============================================================
         * REKAP ALERGI PER JENJANG
         * ============================================================
         */
        $alergiPerJenjang = [];

        foreach ($kelas as $item) {

            $namaJenjang = $item['jenjang'] ?? 'Tidak diketahui';

            if (!isset($alergiPerJenjang[$namaJenjang])) {

                $alergiPerJenjang[$namaJenjang] = [
                    'jenjang' => $namaJenjang,
                    'jumlah_alergi' => 0,
                    'catatan' => []
                ];
            }

            $alergiPerJenjang[$namaJenjang]['jumlah_alergi']
                += (int) ($item['jumlah_alergi'] ?? 0);

            $catatan = trim(
                $item['catatan_alergi'] ?? ''
            );

            if ($catatan !== '') {

                $alergiPerJenjang[$namaJenjang]['catatan'][] = [
                    'kelas' => $item['nama_kelas'],
                    'catatan' => $catatan
                ];
            }
        }




        return view(
            'aslap/penerima_manfaat/detail',
            [
                'pm' => $pm,

                'jumlah_alergi' =>
                (int) ($totalAlergi['jumlah_alergi'] ?? 0),

                'kelas' => $kelas,

                'jenjang' => $jenjang,

                'alergiPerJenjang' => $alergiPerJenjang
            ]
        );
    }


    /**
     * ============================================================
     * DETAIL JENJANG
     * ============================================================
     */
    public function detailJenjang($id)
    {
        // Ambil jenjang
        $jenjang = $this->jenjangModel
            ->where('id', $id)
            ->first();

        if (!$jenjang) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang tidak ditemukan.'
                );
        }

        // Pastikan penerima manfaat milik SPPG
        $pm = $this->pmModel
            ->where(
                'id',
                $jenjang['pm_id']
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->to(
                    base_url(
                        'aslap/penerima-manfaat'
                    )
                )
                ->with(
                    'error',
                    'Data penerima manfaat tidak ditemukan.'
                );
        }

        // Ambil semua kelompok/kelas
        // pada jenjang ini
        $kelas = $this->kelasModel
            ->where(
                'pm_id',
                $jenjang['pm_id']
            )
            ->where(
                'jenjang_id',
                $jenjang['id']
            )
            ->orderBy(
                'id',
                'ASC'
            )
            ->findAll();

        return view(
            'aslap/penerima_manfaat/jenjang',
            [
                'pm' => $pm,

                'jenjang' => $jenjang,

                'kelas' => $kelas
            ]
        );
    }

    /**
     * ============================================================
     * STORE KELAS / KELOMPOK
     * ============================================================
     */
    public function storeKelas()
    {
        $pmId = (int) $this->request
            ->getPost('pm_id');

        $jenjangId = (int) $this->request
            ->getPost('jenjang_id');

        $namaKelas = trim(
            $this->request
                ->getPost('nama_kelas')
        );

        $jumlahSiswa = (int) $this->request
            ->getPost('jumlah_siswa');

        $jumlahAlergi = (int) $this->request
            ->getPost('jumlah_alergi');

        $catatanAlergi = trim(
            $this->request
                ->getPost('catatan_alergi')
        );

        /**
         * --------------------------------------------------------
         * VALIDASI PENERIMA MANFAAT
         * --------------------------------------------------------
         */
        $pm = $this->pmModel
            ->where(
                'id',
                $pmId
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Penerima manfaat tidak ditemukan.'
                );
        }

        /**
         * --------------------------------------------------------
         * VALIDASI JENJANG
         * --------------------------------------------------------
         */
        $jenjang = $this->jenjangModel
            ->where(
                'id',
                $jenjangId
            )
            ->where(
                'pm_id',
                $pmId
            )
            ->first();

        if (!$jenjang) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang tidak ditemukan.'
                );
        }

        /**
         * --------------------------------------------------------
         * VALIDASI NAMA KELOMPOK
         * --------------------------------------------------------
         */
        if ($namaKelas === '') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Nama kelas/kelompok wajib diisi.'
                );
        }

        /**
         * --------------------------------------------------------
         * VALIDASI JUMLAH
         * --------------------------------------------------------
         */
        if ($jumlahSiswa < 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah penerima tidak valid.'
                );
        }

        if ($jumlahAlergi < 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah alergi tidak valid.'
                );
        }

        if ($jumlahAlergi > $jumlahSiswa) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah alergi tidak boleh melebihi jumlah penerima.'
                );
        }

        /**
         * --------------------------------------------------------
         * CEGAH DUPLIKAT
         * --------------------------------------------------------
         */
        $cek = $this->kelasModel
            ->where(
                'pm_id',
                $pmId
            )
            ->where(
                'jenjang_id',
                $jenjangId
            )
            ->where(
                'nama_kelas',
                $namaKelas
            )
            ->first();

        if ($cek) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Kelas/kelompok tersebut sudah tersedia.'
                );
        }

        /**
         * --------------------------------------------------------
         * TENTUKAN PORSI OTOMATIS
         * --------------------------------------------------------
         */
        $porsi = $this->tentukanPorsi(
            $jenjang['jenjang'],
            $namaKelas
        );

        /**
         * --------------------------------------------------------
         * SIMPAN
         * --------------------------------------------------------
         */
        $this->kelasModel->insert([

            'pm_id' => $pmId,

            'jenjang_id' => $jenjangId,

            'nama_kelas' => $namaKelas,

            'jumlah_siswa' => $jumlahSiswa,

            'jumlah_alergi' => $jumlahAlergi,

            'catatan_alergi' => $catatanAlergi,

            'porsi' => $porsi

        ]);

        /**
         * Hitung ulang total
         */
        $this->hitungPM($pmId);

        return redirect()
            ->back()
            ->with(
                'success',
                'Kelas/kelompok berhasil ditambahkan.'
            );
    }

    /**
     * ============================================================
     * TENTUKAN PORSI
     * ============================================================
     */
    private function tentukanPorsi(
        string $jenjang,
        string $namaKelas
    ): string {

        $jenjang = trim(
            strtolower($jenjang)
        );

        $namaKelas = trim(
            strtolower($namaKelas)
        );

        /**
         * --------------------------------------------------------
         * SAMPEL
         * --------------------------------------------------------
         *
         * Sampel adalah satu-satunya kelompok
         * yang bisa memilih besar/kecil.
         */
        if (
            $namaKelas === 'porsi besar'
            || $namaKelas === 'sampel besar'
        ) {

            return 'besar';
        }

        if (
            $namaKelas === 'porsi kecil'
            || $namaKelas === 'sampel kecil'
        ) {

            return 'kecil';
        }

        /**
         * --------------------------------------------------------
         * GURU / STAF
         * --------------------------------------------------------
         *
         * Semua guru/staf = porsi besar.
         */
        if (
            str_contains(
                $namaKelas,
                'guru'
            )
            ||
            str_contains(
                $namaKelas,
                'staf'
            )
        ) {

            return 'besar';
        }

        /**
         * --------------------------------------------------------
         * PAUD
         * --------------------------------------------------------
         */
        if ($jenjang === 'paud') {

            return 'kecil';
        }

        /**
         * --------------------------------------------------------
         * TK
         * --------------------------------------------------------
         */
        if ($jenjang === 'tk') {

            return 'kecil';
        }

        /**
         * --------------------------------------------------------
         * SD
         * --------------------------------------------------------
         */
        if ($jenjang === 'sd') {

            if (
                in_array(
                    $namaKelas,
                    [
                        'kelas 1',
                        'kelas 2',
                        'kelas 3'
                    ],
                    true
                )
            ) {

                return 'kecil';
            }

            if (
                in_array(
                    $namaKelas,
                    [
                        'kelas 4',
                        'kelas 5',
                        'kelas 6'
                    ],
                    true
                )
            ) {

                return 'besar';
            }
        }

        /**
         * --------------------------------------------------------
         * SMP
         * --------------------------------------------------------
         */
        if ($jenjang === 'smp') {

            return 'besar';
        }

        /**
         * --------------------------------------------------------
         * SMA / SMK
         * --------------------------------------------------------
         */
        if (
            $jenjang === 'sma/smk'
            ||
            $jenjang === 'sma'
            ||
            $jenjang === 'smk'
        ) {

            return 'besar';
        }

        /**
         * --------------------------------------------------------
         * BALITA
         * --------------------------------------------------------
         */
        if ($jenjang === 'balita') {

            return 'kecil';
        }

        /**
         * --------------------------------------------------------
         * IBU HAMIL
         * --------------------------------------------------------
         */
        if ($jenjang === 'ibu hamil') {

            return 'besar';
        }

        /**
         * --------------------------------------------------------
         * IBU MENYUSUI
         * --------------------------------------------------------
         */
        if ($jenjang === 'ibu menyusui') {

            return 'besar';
        }

        /**
         * --------------------------------------------------------
         * DEFAULT
         * --------------------------------------------------------
         *
         * Untuk kelompok yang belum mempunyai
         * aturan khusus, default kecil.
         */
        return 'kecil';
    }

    /**
     * ============================================================
     * HITUNG TOTAL PORSI
     * ============================================================
     */
    private function hitungPM($pmId)
    {
        $details = $this->kelasModel
            ->where(
                'pm_id',
                $pmId
            )
            ->findAll();

        $besar = 0;

        $kecil = 0;

        foreach ($details as $item) {

            $jumlah = (int) ($item['jumlah_siswa'] ?? 0
            );

            if (
                ($item['porsi'] ?? '') === 'besar'
            ) {

                $besar += $jumlah;
            }

            if (
                ($item['porsi'] ?? '') === 'kecil'
            ) {

                $kecil += $jumlah;
            }
        }

        $this->pmModel->update(
            $pmId,
            [
                'porsi_besar' => $besar,

                'porsi_kecil' => $kecil,

                'total_siswa' =>
                $besar + $kecil
            ]
        );
    }

    /**
     * ============================================================
     * UPDATE KELAS / KELOMPOK
     * ============================================================
     */
    public function updateKelas($id)
    {
        $kelas = $this->kelasModel
            ->find($id);

        if (!$kelas) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        /**
         * Pastikan data masih milik SPPG
         */
        $pm = $this->pmModel
            ->where(
                'id',
                $kelas['pm_id']
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        $jumlahSiswa = (int)
        $this->request
            ->getPost(
                'jumlah_siswa'
            );

        $jumlahAlergi = (int)
        $this->request
            ->getPost(
                'jumlah_alergi'
            );

        $catatanAlergi = trim(
            $this->request
                ->getPost(
                    'catatan_alergi'
                )
        );

        if ($jumlahSiswa < 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah penerima tidak valid.'
                );
        }

        if ($jumlahAlergi < 0) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah alergi tidak valid.'
                );
        }

        if ($jumlahAlergi > $jumlahSiswa) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jumlah alergi tidak boleh melebihi jumlah penerima.'
                );
        }

        /**
         * --------------------------------------------------------
         * TENTUKAN ULANG PORSI
         * --------------------------------------------------------
         *
         * Porsi tidak boleh diinput manual dari form.
         * Sistem menentukan berdasarkan jenjang + nama kelas.
         */
        $jenjang = $this->jenjangModel
            ->where(
                'id',
                $kelas['jenjang_id']
            )
            ->where(
                'pm_id',
                $kelas['pm_id']
            )
            ->first();

        if (!$jenjang) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang kelas tidak ditemukan.'
                );
        }

        $porsi = $this->tentukanPorsi(
            $jenjang['jenjang'],
            $kelas['nama_kelas']
        );


        /**
         * --------------------------------------------------------
         * UPDATE DATA
         * --------------------------------------------------------
         */
        $this->kelasModel->update(
            $id,
            [
                'jumlah_siswa' =>
                $jumlahSiswa,

                'jumlah_alergi' =>
                $jumlahAlergi,

                'catatan_alergi' =>
                $catatanAlergi,

                'porsi' =>
                $porsi
            ]
        );

        /**
         * Hitung ulang
         */
        $this->hitungPM(
            $kelas['pm_id']
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil diperbarui.'
            );
    }

    /**
     * ============================================================
     * DELETE KELAS / KELOMPOK
     * ============================================================
     */
    public function deleteKelas($id)
    {
        $kelas = $this->kelasModel
            ->find($id);

        if (!$kelas) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        /**
         * Pastikan milik SPPG yang sedang login
         */
        $pm = $this->pmModel
            ->where(
                'id',
                $kelas['pm_id']
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        $pmId = $kelas['pm_id'];

        $this->kelasModel
            ->delete($id);

        /**
         * Hitung ulang total
         */
        $this->hitungPM(
            $pmId
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil dihapus.'
            );
    }

    /**
     * ============================================================
     * UPDATE PENERIMA MANFAAT
     * ============================================================
     */
    public function updatePM($id)
    {
        $pm = $this->pmModel
            ->where(
                'id',
                $id
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        $sekolahNama = trim(
            $this->request
                ->getPost(
                    'sekolah_nama'
                )
        );

        $sekolahAlamat = trim(
            $this->request
                ->getPost(
                    'sekolah_alamat'
                )
        );

        if ($sekolahNama === '') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Nama sekolah/posyandu wajib diisi.'
                );
        }

        $this->pmModel->update(
            $id,
            [
                'sekolah_nama' =>
                $sekolahNama,

                'sekolah_alamat' =>
                $sekolahAlamat
            ]
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil diperbarui.'
            );
    }

    /**
     * ============================================================
     * STORE JENJANG
     * ============================================================
     */
    public function storeJenjang()
    {
        $pmId = (int) $this->request
            ->getPost('pm_id');

        $pm = $this->pmModel
            ->where(
                'id',
                $pmId
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data penerima manfaat tidak ditemukan.'
                );
        }

        $jenjang = trim(
            $this->request
                ->getPost('jenjang')
        );

        if ($jenjang === '') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang wajib dipilih.'
                );
        }

        /**
         * Cegah jenjang yang sama
         * dimasukkan dua kali.
         */
        $cek = $this->jenjangModel
            ->where(
                'pm_id',
                $pmId
            )
            ->where(
                'jenjang',
                $jenjang
            )
            ->first();

        if ($cek) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang tersebut sudah tersedia.'
                );
        }

        $this->jenjangModel->insert(
            [
                'pm_id' =>
                $pmId,

                'jenjang' =>
                $jenjang
            ]
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Jenjang berhasil ditambahkan.'
            );
    }

    /**
     * ============================================================
     * DELETE JENJANG
     * ============================================================
     */
    public function deleteJenjang($id)
    {
        // Ambil data jenjang
        $jenjang = $this->jenjangModel
            ->find($id);

        if (!$jenjang) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang tidak ditemukan.'
                );
        }







        /**
         * ========================================================
         * PASTIKAN JENJANG MILIK SPPG YANG SEDANG LOGIN
         * ========================================================
         */
        $pm = $this->pmModel
            ->where(
                'id',
                $jenjang['pm_id']
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$pm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan.'
                );
        }

        $db = \Config\Database::connect();

        try {

            /**
             * ====================================================
             * MULAI TRANSAKSI
             * ====================================================
             */
            $db->transStart();

            /**
             * ====================================================
             * HAPUS SEMUA KELAS / KELOMPOK
             * DI BAWAH JENJANG INI
             * ====================================================
             */
            $this->kelasModel
                ->where(
                    'jenjang_id',
                    $id
                )
                ->where(
                    'pm_id',
                    $jenjang['pm_id']
                )
                ->delete();

            /**
             * ====================================================
             * HAPUS JENJANG
             * ====================================================
             */
            $this->jenjangModel
                ->where(
                    'id',
                    $id
                )
                ->where(
                    'pm_id',
                    $jenjang['pm_id']
                )
                ->delete();

            /**
             * ====================================================
             * SELESAIKAN TRANSAKSI
             * ====================================================
             */
            $db->transComplete();

            /**
             * ====================================================
             * CEK STATUS TRANSAKSI
             * ====================================================
             */
            if ($db->transStatus() === false) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Jenjang gagal dihapus.'
                    );
            }

            /**
             * ====================================================
             * HITUNG ULANG PORSI
             * ====================================================
             */
            $this->hitungPM(
                $jenjang['pm_id']
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Jenjang berhasil dihapus.'
                );
        } catch (\Throwable $e) {

            log_message(
                'error',
                'Gagal menghapus jenjang: ' .
                    $e->getMessage()
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Jenjang gagal dihapus.'
                );
        }
    }
}
