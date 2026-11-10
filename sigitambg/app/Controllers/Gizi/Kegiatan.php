<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\KegiatanGiziModel;
use App\Models\KegiatanGiziFotoModel;
use App\Models\MasterJenisKegiatanModel;
use App\Models\PenerimaManfaatModel;

class Kegiatan extends BaseController
{

    protected $kegiatanModel;
    protected $fotoModel;
    protected $jenisModel;
    protected $pmModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanGiziModel();
        $this->fotoModel      = new KegiatanGiziFotoModel();
        $this->jenisModel     = new MasterJenisKegiatanModel();
        $this->pmModel        = new PenerimaManfaatModel();
    }

    public function create()
    {
        $jenis = $this->jenisModel
            ->where('is_active', 1)
            ->orderBy('urutan')
            ->findAll();

        $sekolah = $this->pmModel
            ->where('id_sppg', session('id_sppg'))
            ->orderBy('sekolah_nama')
            ->findAll();

        // Hilangkan sekolah yang sama
        $uniqueSekolah = [];

        foreach ($sekolah as $s) {

            $uniqueSekolah[$s['sekolah_nama']] = $s['sekolah_nama'];
        }

        return view('gizi/kegiatan/create', [

            'jenis' => $jenis,

            'sekolah' => $uniqueSekolah

        ]);
    }
    public function store()
    {
        // Validasi
        $rules = [

            'tanggal' => 'required',

            'jenis_kegiatan_id' => 'required',

            'lokasi' => 'required',

            'deskripsi' => 'required'

        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Silakan lengkapi seluruh data kegiatan.'
                );
        }

        // Ambil lokasi
        $lokasi = $this->request->getPost('lokasi');

        if ($lokasi == 'lainnya') {

            $lokasi = trim(
                $this->request->getPost('lokasi_manual')
            );

            if ($lokasi == '') {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Silakan isi nama lokasi.'
                    );
            }
        }

        // Simpan Header Kegiatan
        $this->kegiatanModel->insert([

            'id_sppg'           => session('id_sppg'),

            'tanggal'           => $this->request->getPost('tanggal'),

            'lokasi_nama'       => $lokasi,

            'jenis_kegiatan_id' => $this->request->getPost('jenis_kegiatan_id'),

            'deskripsi'         => trim(
                $this->request->getPost('deskripsi')
            ),

            'created_by'        => session('user_id')

        ]);

        $id = $this->kegiatanModel->getInsertID();

        /*
        =======================================================
        Upload Foto
        */
        $files = $this->request->getFiles();

        if (isset($files['foto'])) {

            foreach ($files['foto'] as $file) {

                if (!$file->isValid()) {

                    continue;
                }

                $namaFile = uploadImage(

                    $file,

                    'kegiatan'

                );

                if ($namaFile) {

                    $this->fotoModel->insert([

                        'kegiatan_id' => $id,

                        'foto'        => $namaFile

                    ]);
                }
            }
        }
        /*
        =======================================================
        */

        return redirect()
            ->to('/gizi/kegiatan')
            ->with(
                'success',
                'Kegiatan berhasil disimpan.'
            );
    }

    private function getKegiatan($id)
    {
        $kegiatan = $this->kegiatanModel

            ->where(
                'id',
                $id
            )

            ->where(
                'id_sppg',
                session('id_sppg')
            )

            ->first();

        if (!$kegiatan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $kegiatan;
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $kegiatan = $db->table('kegiatan_gizi k')

            ->select('
            k.*,
            j.nama_kegiatan,
            j.icon,
            j.warna,
            COUNT(f.id) as jumlah_foto
        ')

            ->join(
                'master_jenis_kegiatan j',
                'j.id = k.jenis_kegiatan_id'
            )

            ->join(
                'kegiatan_gizi_foto f',
                'f.kegiatan_id = k.id',
                'left'
            )

            ->where(
                'k.id_sppg',
                session('id_sppg')
            )

            ->groupBy('k.id')

            ->orderBy('k.tanggal', 'DESC')

            ->orderBy('k.id', 'DESC')

            ->get()

            ->getResultArray();

        return view(
            'gizi/kegiatan/index',
            [
                'kegiatan' => $kegiatan
            ]
        );
    }

    public function edit($id)
    {
        $kegiatan = $this->getKegiatan($id);

        $jenis = $this->jenisModel
            ->where('is_active', 1)
            ->orderBy('urutan')
            ->findAll();

        $sekolah = $this->pmModel
            ->where('id_sppg', session('id_sppg'))
            ->orderBy('sekolah_nama')
            ->findAll();

        $uniqueSekolah = [];
        foreach ($sekolah as $s) {
            $uniqueSekolah[$s['sekolah_nama']] = $s['sekolah_nama'];
        }

        $foto = $this->fotoModel
            ->where('kegiatan_id', $id)
            ->findAll();

        return view('gizi/kegiatan/edit', [
            'kegiatan' => $kegiatan,
            'jenis'    => $jenis,
            'sekolah'  => $uniqueSekolah,
            'foto'     => $foto,
        ]);
    }

    public function update($id)
    {
        $kegiatan = $this->getKegiatan($id);

        $rules = [
            'tanggal'           => 'required',
            'jenis_kegiatan_id' => 'required',
            'lokasi'            => 'required',
            'deskripsi'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Silakan lengkapi seluruh data kegiatan.');
        }

        $lokasi = trim((string) $this->request->getPost('lokasi'));

        if ($lokasi === 'lainnya') {
            $lokasi = trim((string) $this->request->getPost('lokasi_manual'));
            if ($lokasi === '') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Silakan isi nama lokasi.');
            }
        }

        $this->kegiatanModel->update($id, [
            'tanggal'           => $this->request->getPost('tanggal'),
            'lokasi_nama'       => $lokasi,
            'jenis_kegiatan_id' => $this->request->getPost('jenis_kegiatan_id'),
            'deskripsi'         => trim((string) $this->request->getPost('deskripsi')),
        ]);

        // Tambahkan dokumentasi baru tanpa menghapus dokumentasi lama.
        $files = $this->request->getFiles();
        if (isset($files['foto']) && is_array($files['foto'])) {
            foreach ($files['foto'] as $file) {
                if (!$file->isValid() || $file->hasMoved()) {
                    continue;
                }

                if ($file->getSizeByUnit('mb') > 5) {
                    continue;
                }

                $namaFile = uploadImage($file, 'kegiatan');
                if ($namaFile) {
                    $this->fotoModel->insert([
                        'kegiatan_id' => $id,
                        'foto'        => $namaFile,
                    ]);
                }
            }
        }

        return redirect()
            ->to(base_url('gizi/kegiatan/detail/' . $id))
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function detail($id)
    {
        $kegiatan = $this->kegiatanModel

            ->select('
            kegiatan_gizi.*,
            master_jenis_kegiatan.nama_kegiatan,
            master_jenis_kegiatan.icon,
            master_jenis_kegiatan.warna
        ')

            ->join(
                'master_jenis_kegiatan',
                'master_jenis_kegiatan.id = kegiatan_gizi.jenis_kegiatan_id'
            )

            ->where(
                'kegiatan_gizi.id',
                $id
            )

            ->where(
                'id_sppg',
                session('id_sppg')
            )

            ->first();

        if (!$kegiatan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $foto = $this->fotoModel

            ->where(
                'kegiatan_id',
                $id
            )

            ->findAll();

        return view(
            'gizi/kegiatan/detail',
            [

                'kegiatan' => $kegiatan,

                'foto' => $foto

            ]
        );
    }
}
