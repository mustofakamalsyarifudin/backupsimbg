<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\MenuGiziModel;
use App\Models\MenuKomposisiModel;

class MenuVarian extends BaseController
{
    protected MenuGiziModel $menuModel;
    protected MenuKomposisiModel $komposisiModel;

    public function __construct()
    {
        $this->menuModel = new MenuGiziModel();
        $this->komposisiModel = new MenuKomposisiModel();
    }

    public function create($id)
    {
        $master = $this->getMaster($id);

        if (!$master) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $komposisi = $this->komposisiModel
            ->where('menu_id', $id)
            ->findAll();

        $dataKomposisi = [];

        foreach ($komposisi as $item) {
            $dataKomposisi[$item['jenis']] = $item['nama_item'];
        }

        $categories = $this->menuModel
            ->select('kategori')
            ->where('id_sppg', session('id_sppg'))
            ->where('kategori !=', '')
            ->groupBy('kategori')
            ->orderBy('kategori', 'ASC')
            ->findAll();

        return view('gizi/menu/variant', [
            'title'       => 'Buat Varian Menu',
            'master'      => $master,
            'komposisi'   => $dataKomposisi,
            'categories'  => $categories,
        ]);
    }

    public function store($id)
    {
        $master = $this->getMaster($id);

        if (!$master) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $namaMenu = trim((string) $this->request->getPost('nama_menu'));
        $kategori = trim((string) $this->request->getPost('kategori'));
        $catatan  = trim((string) $this->request->getPost('catatan'));

        if ($namaMenu === '') {
            return redirect()->back()->withInput()->with('error', 'Nama menu varian wajib diisi.');
        }

        $duplicate = $this->menuModel
            ->where('id_sppg', session('id_sppg'))
            ->where('nama_menu', $namaMenu)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'Nama menu tersebut sudah tersedia.');
        }

        $namaFoto = $this->copyMasterPhoto($master['foto_menu'] ?? null);

        $db = db_connect();
        $db->transStart();

        $menuId = $this->menuModel->insert([
            'id_sppg'      => session('id_sppg'),
            'nama_menu'    => $namaMenu,
            'kategori'     => $kategori,
            'catatan'      => $catatan !== '' ? $catatan : null,
            'foto_menu'    => $namaFoto,
            'menu_induk_id'=> $id,
            'is_varian'    => 1,
            'created_by'   => session('user_id'),
        ], true);

        if (!$menuId) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Varian menu gagal dibuat.');
        }

        $komposisi = [
            'karbohidrat'    => $this->request->getPost('karbohidrat'),
            'protein_nabati' => $this->request->getPost('protein_nabati'),
            'protein_hewani' => $this->request->getPost('protein_hewani'),
            'sayuran'        => $this->request->getPost('sayuran'),
            'buah'           => $this->request->getPost('buah'),
            'other'          => $this->request->getPost('other'),
        ];

        foreach ($komposisi as $jenis => $namaItem) {
            $namaItem = trim((string) $namaItem);

            if ($namaItem === '') {
                continue;
            }

            $this->komposisiModel->insert([
                'menu_id'   => $menuId,
                'jenis'     => $jenis,
                'nama_item' => $namaItem,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Varian menu gagal disimpan.');
        }

        return redirect()
            ->to(base_url('gizi/menu/edit/' . $menuId))
            ->with('success', 'Varian menu berhasil dibuat dari Master Menu.');
    }

    private function getMaster($id): ?array
    {
        return $this->menuModel
            ->where('id', $id)
            ->where('id_sppg', session('id_sppg'))
            ->first();
    }

    private function copyMasterPhoto(?string $file): ?string
    {
        if (!$file) {
            return null;
        }

        $source = FCPATH . 'uploads/menu/' . $file;

        if (!is_file($source)) {
            return null;
        }

        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $newName = bin2hex(random_bytes(10)) . ($extension ? '.' . $extension : '');

        if (copy($source, FCPATH . 'uploads/menu/' . $newName)) {
            return $newName;
        }

        return null;
    }
}
