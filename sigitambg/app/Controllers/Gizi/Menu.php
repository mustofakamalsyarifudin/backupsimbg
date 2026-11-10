<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\MenuGiziModel;
use App\Models\MenuKomposisiModel;
use App\Models\SppgModel;

class Menu extends BaseController
{
    protected $menuModel;
    protected $komposisiModel;

    public function __construct()
    {
        $this->menuModel = new MenuGiziModel();
        $this->komposisiModel = new MenuKomposisiModel();
    }

    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index()
    {
        return redirect()->to(
            base_url('gizi/menu/list')
        );
    }

    /**
     * ============================================================
     * CREATE
     * ============================================================
     */
    public function create()
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        return view(
            'gizi/menu/create',
            [
                'title' => 'Tambah Menu'
            ]
        );
    }

    /**
     * ============================================================
     * STORE
     * ============================================================
     */
    public function store()
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $namaMenu = trim(
            $this->request->getPost('nama_menu')
        );

        $kategori = trim(
            $this->request->getPost('kategori')
        );

        $catatan = trim(
            $this->request->getPost('catatan')
        );

        /**
         * --------------------------------------------------------
         * VALIDASI NAMA MENU
         * --------------------------------------------------------
         */
        if ($namaMenu === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama menu wajib diisi.'
                );
        }

        /**
         * --------------------------------------------------------
         * CEGAH DUPLIKAT NAMA MENU
         * --------------------------------------------------------
         */
        $cek = $this->menuModel
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->where(
                'nama_menu',
                $namaMenu
            )
            ->first();

        if ($cek) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama menu tersebut sudah tersedia.'
                );
        }

        /**
         * --------------------------------------------------------
         * UPLOAD FOTO
         * --------------------------------------------------------
         */
        $namaFoto = null;

        $foto = $this->request->getFile(
            'foto_menu'
        );

        if (
            $foto &&
            $foto->isValid() &&
            !$foto->hasMoved()
        ) {

            $namaFoto =
                $foto->getRandomName();

            $foto->move(
                FCPATH . 'uploads/menu',
                $namaFoto
            );

            /**
             * Kompres foto
             */
            $image =
                \Config\Services::image();

            $image
                ->withFile(
                    FCPATH .
                        'uploads/menu/' .
                        $namaFoto
                )
                ->resize(
                    1280,
                    1280,
                    true,
                    'height'
                )
                ->save(
                    FCPATH .
                        'uploads/menu/' .
                        $namaFoto,
                    75
                );
        }

        /**
         * --------------------------------------------------------
         * SIMPAN MASTER MENU
         * --------------------------------------------------------
         */
        $menuId = $this->menuModel->insert(
            [
                'id_sppg' =>
                session('id_sppg'),

                'nama_menu' =>
                $namaMenu,

                'kategori' =>
                $kategori,

                'catatan' =>
                $catatan,

                'foto_menu' =>
                $namaFoto,

                'created_by' =>
                session('user_id')
            ],
            true
        );

        /**
         * --------------------------------------------------------
         * KOMPOSISI
         * --------------------------------------------------------
         */
        $komposisi = [

            'karbohidrat' =>
            $this->request
                ->getPost('karbohidrat'),

            'protein_nabati' =>
            $this->request
                ->getPost('protein_nabati'),

            'protein_hewani' =>
            $this->request
                ->getPost('protein_hewani'),

            'sayuran' =>
            $this->request
                ->getPost('sayuran'),

            'buah' =>
            $this->request
                ->getPost('buah'),

            'other' =>
            $this->request
                ->getPost('other')
        ];

        foreach ($komposisi
            as $jenis => $namaItem) {

            $namaItem = trim(
                (string) $namaItem
            );

            if ($namaItem === '') {
                continue;
            }

            $this->komposisiModel->insert(
                [
                    'menu_id' =>
                    $menuId,

                    'jenis' =>
                    $jenis,

                    'nama_item' =>
                    $namaItem
                ]
            );
        }

        return redirect()
            ->to(
                base_url('gizi/menu/list')
            )
            ->with(
                'success',
                'Menu berhasil disimpan.'
            );
    }

    /**
     * ============================================================
     * LIST MASTER MENU
     * ============================================================
     */
    public function list()
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $menus = $this->menuModel
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->orderBy(
                'nama_menu',
                'ASC'
            )
            ->findAll();
        $sppgModel = new SppgModel();

        $sppg = $sppgModel
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();


        foreach ($menus as &$menu) {

            $menu['komposisi'] = $this->komposisiModel
                ->where(
                    'menu_id',
                    $menu['id']
                )
                ->orderBy(
                    'id',
                    'ASC'
                )
                ->findAll();
        }

        return view(
            'gizi/menu/index',
            [
                'title' => 'Master Menu',
                'sppg' => $sppg,
                'menus' => $menus
            ]
        );
    }

    /**
     * ============================================================
     * DETAIL
     * ============================================================
     */
    public function detail($id)
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $menu = $this->menuModel
            ->where(
                'id',
                $id
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$menu) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $komposisi = $this->komposisiModel
            ->where(
                'menu_id',
                $id
            )
            ->findAll();

        return view(
            'gizi/menu/detail',
            [
                'title' =>
                'Detail Menu',

                'menu' =>
                $menu,

                'komposisi' =>
                $komposisi
            ]
        );
    }

    /**
     * ============================================================
     * EDIT
     * ============================================================
     */
    public function edit($id)
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $menu = $this->menuModel
            ->where(
                'id',
                $id
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$menu) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $komposisi = $this->komposisiModel
            ->where(
                'menu_id',
                $id
            )
            ->findAll();

        $dataKomposisi = [];

        foreach ($komposisi as $item) {

            $dataKomposisi[$item['jenis']] =
                $item['nama_item'];
        }

        return view(
            'gizi/menu/edit',
            [
                'title' =>
                'Edit Menu',

                'menu' =>
                $menu,

                'komposisi' =>
                $dataKomposisi
            ]
        );
    }

    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update($id)
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $menu = $this->menuModel
            ->where(
                'id',
                $id
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$menu) {

            return redirect()
                ->to(
                    base_url('gizi/menu/list')
                )
                ->with(
                    'error',
                    'Menu tidak ditemukan.'
                );
        }

        $namaMenu = trim(
            $this->request
                ->getPost('nama_menu')
        );

        $kategori = trim(
            $this->request
                ->getPost('kategori')
        );

        $catatan = trim(
            $this->request
                ->getPost('catatan')
        );

        /**
         * --------------------------------------------------------
         * VALIDASI
         * --------------------------------------------------------
         */
        if ($namaMenu === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama menu wajib diisi.'
                );
        }

        /**
         * Cek nama menu duplikat
         */
        $cek = $this->menuModel
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->where(
                'nama_menu',
                $namaMenu
            )
            ->where(
                'id !=',
                $id
            )
            ->first();

        if ($cek) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Nama menu tersebut sudah tersedia.'
                );
        }

        /**
         * --------------------------------------------------------
         * FOTO
         * --------------------------------------------------------
         */
        $namaFoto =
            $menu['foto_menu'];

        $foto = $this->request->getFile(
            'foto_menu'
        );

        if (
            $foto &&
            $foto->isValid() &&
            !$foto->hasMoved()
        ) {

            $namaFoto =
                $foto->getRandomName();

            $foto->move(
                FCPATH . 'uploads/menu',
                $namaFoto
            );

            $image =
                \Config\Services::image();

            $image
                ->withFile(
                    FCPATH .
                        'uploads/menu/' .
                        $namaFoto
                )
                ->resize(
                    1280,
                    1280,
                    true,
                    'height'
                )
                ->save(
                    FCPATH .
                        'uploads/menu/' .
                        $namaFoto,
                    75
                );

            /**
             * Hapus foto lama
             */
            if (
                !empty($menu['foto_menu']) &&
                file_exists(
                    FCPATH .
                        'uploads/menu/' .
                        $menu['foto_menu']
                )
            ) {

                unlink(
                    FCPATH .
                        'uploads/menu/' .
                        $menu['foto_menu']
                );
            }
        }

        /**
         * --------------------------------------------------------
         * UPDATE MASTER MENU
         * --------------------------------------------------------
         */
        $this->menuModel->update(
            $id,
            [
                'nama_menu' =>
                $namaMenu,

                'kategori' =>
                $kategori,

                'catatan' =>
                $catatan,

                'foto_menu' =>
                $namaFoto
            ]
        );

        /**
         * --------------------------------------------------------
         * HAPUS KOMPOSISI LAMA
         * --------------------------------------------------------
         */
        $this->komposisiModel
            ->where(
                'menu_id',
                $id
            )
            ->delete();

        /**
         * --------------------------------------------------------
         * SIMPAN KOMPOSISI BARU
         * --------------------------------------------------------
         */
        $komposisi = [

            'karbohidrat' =>
            $this->request
                ->getPost('karbohidrat'),

            'protein_nabati' =>
            $this->request
                ->getPost('protein_nabati'),

            'protein_hewani' =>
            $this->request
                ->getPost('protein_hewani'),

            'sayuran' =>
            $this->request
                ->getPost('sayuran'),

            'buah' =>
            $this->request
                ->getPost('buah'),

            'other' =>
            $this->request
                ->getPost('other')
        ];

        foreach ($komposisi
            as $jenis => $namaItem) {

            $namaItem = trim(
                (string) $namaItem
            );

            if ($namaItem === '') {
                continue;
            }

            $this->komposisiModel->insert(
                [
                    'menu_id' =>
                    $id,

                    'jenis' =>
                    $jenis,

                    'nama_item' =>
                    $namaItem
                ]
            );
        }

        return redirect()
            ->to(
                base_url('gizi/menu/list')
            )
            ->with(
                'success',
                'Menu berhasil diperbarui.'
            );
    }

    /**
     * ============================================================
     * DELETE
     * ============================================================
     */
    public function delete($id)
    {
        if (session('user_level') !== 'gizi') {

            return redirect()->to('/dashboard');
        }

        $menu = $this->menuModel
            ->where(
                'id',
                $id
            )
            ->where(
                'id_sppg',
                session('id_sppg')
            )
            ->first();

        if (!$menu) {

            return redirect()
                ->to(
                    base_url('gizi/menu/list')
                )
                ->with(
                    'error',
                    'Menu tidak ditemukan.'
                );
        }

        /**
         * Hapus komposisi
         */
        $this->komposisiModel
            ->where(
                'menu_id',
                $id
            )
            ->delete();

        /**
         * Hapus foto
         */
        if (
            !empty($menu['foto_menu']) &&
            file_exists(
                FCPATH .
                    'uploads/menu/' .
                    $menu['foto_menu']
            )
        ) {

            unlink(
                FCPATH .
                    'uploads/menu/' .
                    $menu['foto_menu']
            );
        }

        /**
         * Hapus menu
         */
        $this->menuModel
            ->delete($id);

        return redirect()
            ->to(
                base_url('gizi/menu/list')
            )
            ->with(
                'success',
                'Menu berhasil dihapus.'
            );
    }
}
