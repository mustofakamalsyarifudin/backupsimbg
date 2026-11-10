<?php

namespace App\Controllers\Aslap;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use App\Models\PengeluaranAslapModel;

class Pengeluaran extends BaseController
{
    protected $pengeluaranModel;

    public function __construct()
    {
        $this->pengeluaranModel =
            new PengeluaranAslapModel();
    }

    public function index()
    {
        $data = [

            'pengeluaran' => $this->pengeluaranModel

                ->where(
                    'id_sppg',
                    session('id_sppg')
                )

                ->orderBy(
                    'tanggal',
                    'DESC'
                )

                ->findAll()

        ];

        return view(
            'aslap/pengeluaran/index',
            $data
        );
    }

    public function create()
    {
        return view(
            'aslap/pengeluaran/create'
        );
    }

    public function store()
    {
        $namaFoto = null;

        $file =
            $this->request
            ->getFile('foto_bukti');

        if (
            $file &&
            $file->isValid()
        ) {

            $namaFoto =
                uploadImage(
                    $file,
                    'pengeluaran'
                );
        }

        $this->pengeluaranModel->insert([

            'id_sppg' => session('id_sppg'),

            'tanggal' => $this->request->getPost('tanggal'),

            'kategori' => trim(
                $this->request->getPost('kategori')
            ),

            'nominal' => (float)
            $this->request->getPost('nominal'),

            'metode_pembayaran' =>
            $this->request->getPost(
                'metode_pembayaran'
            ),

            'uraian' => trim(
                $this->request->getPost('uraian')
            ),

            'foto_bukti' => $namaFoto,

            'created_by' => session('user_id')

        ]);

        return redirect()->to(
            base_url(
                'aslap/pengeluaran'
            )
        )->with(
            'success',
            'Pengeluaran berhasil disimpan'
        );
    }


    public function detail($id)
    {
        $pengeluaran = $this->pengeluaranModel

            ->where(
                'id',
                $id
            )

            ->where(
                'id_sppg',
                session('id_sppg')
            )

            ->first();

        if (!$pengeluaran) {

            throw PageNotFoundException::forPageNotFound();
        }

        return view(
            'aslap/pengeluaran/detail',
            [

                'pengeluaran' =>
                $pengeluaran

            ]
        );
    }

    public function edit($id)
    {
        $pengeluaran = $this->pengeluaranModel

            ->where(
                'id',
                $id
            )

            ->where(
                'id_sppg',
                session('id_sppg')
            )

            ->first();

        if (!$pengeluaran) {

            throw PageNotFoundException::forPageNotFound();
        }

        return view(
            'aslap/pengeluaran/edit',
            [

                'pengeluaran' =>
                $pengeluaran

            ]
        );
    }

    public function update($id)
    {
        $pengeluaran = $this->pengeluaranModel
            ->find($id);

        if (!$pengeluaran) {

            throw PageNotFoundException::forPageNotFound();
        }

        $data = [

            'tanggal' =>
            $this->request->getPost(
                'tanggal'
            ),

            'kategori' =>
            trim(
                $this->request->getPost(
                    'kategori'
                )
            ),

            'nominal' =>
            (float)
            $this->request->getPost(
                'nominal'
            ),

            'metode_pembayaran' =>
            $this->request->getPost(
                'metode_pembayaran'
            ),

            'uraian' =>
            trim(
                $this->request->getPost(
                    'uraian'
                )
            )

        ];

        $file =
            $this->request
            ->getFile(
                'foto_bukti'
            );

        if (
            $file &&
            $file->isValid()
        ) {

            if (
                !empty($pengeluaran['foto_bukti'])
            ) {

                $oldPath =
                    FCPATH .
                    'uploads/pengeluaran/' .
                    $pengeluaran['foto_bukti'];

                if (
                    file_exists(
                        $oldPath
                    )
                ) {

                    unlink(
                        $oldPath
                    );
                }
            }

            $data['foto_bukti'] =
                uploadImage(
                    $file,
                    'pengeluaran'
                );
        }

        $this->pengeluaranModel
            ->update(
                $id,
                $data
            );

        return redirect()->to(
            base_url(
                'aslap/pengeluaran/detail/' .
                    $id
            )
        )->with(
            'success',
            'Pengeluaran berhasil diperbarui'
        );
    }

    public function delete($id)
    {
        $pengeluaran =
            $this->pengeluaranModel
            ->find($id);

        if (!$pengeluaran) {

            return redirect()->back();
        }

        if (
            !empty($pengeluaran['foto_bukti'])
        ) {

            $path =
                FCPATH .
                'uploads/pengeluaran/' .
                $pengeluaran['foto_bukti'];

            if (
                file_exists(
                    $path
                )
            ) {

                unlink(
                    $path
                );
            }
        }

        $this->pengeluaranModel
            ->delete($id);

        return redirect()->to(
            base_url(
                'aslap/pengeluaran'
            )
        )->with(
            'success',
            'Pengeluaran berhasil dihapus'
        );
    }
}
