<?php

namespace App\Controllers\Aslap;

use App\Controllers\BaseController;
use App\Models\KegiatanAslapModel;
use App\Models\KegiatanAslapFotoModel;

class Kegiatan extends BaseController
{
    protected $kegiatanModel;

    protected $fotoModel;

    public function __construct()
    {
        $this->kegiatanModel =
            new KegiatanAslapModel();

        $this->fotoModel =
            new KegiatanAslapFotoModel();
    }

    public function index()
    {
        $kegiatan = $this->kegiatanModel
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->orderBy(
                'tanggal',
                'DESC'
            )
            ->findAll();

        foreach ($kegiatan as &$item) {

            $item['total_foto'] = $this->fotoModel
                ->where(
                    'kegiatan_id',
                    $item['id']
                )
                ->countAllResults();
        }

        $data = [

            'kegiatan' => $kegiatan

        ];

        return view(
            'aslap/kegiatan/index',
            $data
        );
    }

    public function create()
    {
        return view(
            'aslap/kegiatan/create'
        );
    }

    public function store()
    {
        $this->kegiatanModel->insert([

            'id_sppg' => session('id_sppg'),

            'tanggal' => $this->request
                ->getPost('tanggal'),

            'judul_kegiatan' => trim(
                $this->request
                    ->getPost(
                        'judul_kegiatan'
                    )
            ),

            'lokasi' => trim(
                $this->request
                    ->getPost(
                        'lokasi'
                    )
            ),

            'deskripsi' => trim(
                $this->request
                    ->getPost(
                        'deskripsi'
                    )
            ),

            'created_by' => session(
                'user_id'
            )

        ]);

        $kegiatanId =
            $this->kegiatanModel
            ->getInsertID();

        $files =
            $this->request
            ->getFiles();

        if (
            isset(
                $files['foto']
            )
        ) {

            foreach ($files['foto']
                as $file) {

                if ($file->isValid()) {
                    if (
                        $file->getSizeByUnit('mb')
                        > 5
                    ) {
                        continue;
                    }
                    $namaFoto =
                        uploadImage(
                            $file,
                            'kegiatan'
                        );

                    $this->fotoModel
                        ->insert([

                            'kegiatan_id' =>
                            $kegiatanId,

                            'foto' =>
                            $namaFoto

                        ]);
                }
            }
        }

        return redirect()->to(
            base_url(
                'aslap/kegiatan'
            )
        )->with(
            'success',
            'Kegiatan berhasil ditambahkan'
        );
    }

    public function detail($id)
    {
        $kegiatan =
            $this->kegiatanModel
            ->find($id);

        if (!$kegiatan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $foto =
            $this->fotoModel
            ->where(
                'kegiatan_id',
                $id
            )
            ->findAll();

        return view(
            'aslap/kegiatan/detail',
            [

                'kegiatan' =>
                $kegiatan,

                'foto' =>
                $foto

            ]
        );
    }

    public function edit($id)
    {
        $kegiatan = $this->kegiatanModel
            ->where('id', $id)
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$kegiatan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view(
            'aslap/kegiatan/edit',
            [
                'kegiatan' => $kegiatan
            ]
        );
    }

    public function update($id)
    {
        $this->kegiatanModel->update($id, [

            'tanggal' => $this->request
                ->getPost('tanggal'),

            'judul_kegiatan' => trim(
                $this->request->getPost(
                    'judul_kegiatan'
                )
            ),

            'lokasi' => trim(
                $this->request->getPost(
                    'lokasi'
                )
            ),

            'deskripsi' => trim(
                $this->request->getPost(
                    'deskripsi'
                )
            )

        ]);

        return redirect()->to(
            base_url(
                'aslap/kegiatan/detail/' . $id
            )
        )->with(
            'success',
            'Kegiatan berhasil diperbarui'
        );
    }
    public function delete($id)
    {
        $foto = $this->fotoModel
            ->where(
                'kegiatan_id',
                $id
            )
            ->findAll();

        foreach ($foto as $item) {

            $path =
                FCPATH .
                'uploads/kegiatan/' .
                $item['foto'];

            if (file_exists($path)) {

                unlink($path);
            }
        }

        $this->fotoModel
            ->where(
                'kegiatan_id',
                $id
            )
            ->delete();

        $this->kegiatanModel
            ->delete($id);

        return redirect()->to(
            base_url(
                'aslap/kegiatan'
            )
        )->with(
            'success',
            'Kegiatan berhasil dihapus'
        );
    }

    public function uploadFoto($id)
    {
        $files = $this->request->getFiles();

        if (isset($files['foto'])) {

            foreach ($files['foto'] as $file) {

                if ($file->isValid()) {
                    if (
                        $file->getSizeByUnit('mb')
                        > 5
                    ) {
                        continue;
                    }
                    $namaFoto =
                        uploadImage(
                            $file,
                            'kegiatan'
                        );

                    $this->fotoModel->insert([

                        'kegiatan_id' => $id,

                        'foto' => $namaFoto

                    ]);
                }
            }
        }

        return redirect()->back()
            ->with(
                'success',
                'Foto berhasil ditambahkan'
            );
    }

    public function deleteFoto($id)
    {
        $foto = $this->fotoModel
            ->find($id);

        if (!$foto) {

            return redirect()->back();
        }

        $path =
            FCPATH .
            'uploads/kegiatan/' .
            $foto['foto'];

        if (file_exists($path)) {

            unlink($path);
        }

        $this->fotoModel
            ->delete($id);

        return redirect()->back()
            ->with(
                'success',
                'Foto berhasil dihapus'
            );
    }
}
