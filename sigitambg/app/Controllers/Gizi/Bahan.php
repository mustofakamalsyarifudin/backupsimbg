<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\MasterBahanModel;
use App\Models\MasterBahanHargaModel;

class Bahan extends BaseController
{
    protected MasterBahanModel $bahanModel;
    protected MasterBahanHargaModel $hargaModel;

    public function __construct()
    {
        $this->bahanModel = new MasterBahanModel();
        $this->hargaModel = new MasterBahanHargaModel();
    }

    protected function ensureKoperasi()
    {
        if (session('user_level') !== 'koperasi') {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Akses Master Bahan hanya untuk role Koperasi.');
        }

        return null;
    }

    protected function currentSppg(): ?string
    {
        return session('id_sppg') ?: null;
    }

    public function index()
    {
        $idSppg = $this->currentSppg();

        $bahans = $this->bahanModel
            ->where('id_sppg', $idSppg)
            ->orderBy('status', 'DESC')
            ->orderBy('nama_bahan', 'ASC')
            ->findAll();

        return view('gizi/bahan/index', [
            'title' => 'Master Bahan Baku',
            'bahans' => $bahans,
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $nama = trim((string) $this->request->getPost('nama_bahan'));
        $satuan = trim((string) $this->request->getPost('satuan_default'));
        $harga = (float) ($this->request->getPost('harga') ?? 0);

        if ($nama === '' || $satuan === '') {
            return redirect()->back()->withInput()
                ->with('error', 'Nama bahan dan satuan wajib diisi.');
        }

        if ($harga < 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Harga tidak boleh negatif.');
        }

        $idSppg = $this->currentSppg();

        $exists = $this->bahanModel
            ->where('id_sppg', $idSppg)
            ->where('nama_bahan', $nama)
            ->first();

        if ($exists) {
            return redirect()->back()->withInput()
                ->with('error', 'Nama bahan sudah ada di Master Bahan.');
        }

        $id = $this->bahanModel->insert([
            'id_sppg' => $idSppg,
            'nama_bahan' => $nama,
            'satuan_default' => $satuan,
            'harga' => $harga,
            'status' => 'aktif',
            'created_by' => session('user_id'),
            'updated_by' => session('user_id'),
        ], true);

        if (!$id) {
            return redirect()->back()->withInput()
                ->with('error', 'Bahan gagal ditambahkan.');
        }

        return redirect()->to(base_url('gizi/bahan'))
            ->with('success', 'Bahan berhasil ditambahkan ke Master Bahan.');
    }

    public function update($id)
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $bahan = $this->bahanModel
            ->where('id', $id)
            ->where('id_sppg', $this->currentSppg())
            ->first();

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        $nama = trim((string) $this->request->getPost('nama_bahan'));
        $satuan = trim((string) $this->request->getPost('satuan_default'));
        $harga = (float) ($this->request->getPost('harga') ?? $bahan['harga']);

        if ($nama === '' || $satuan === '') {
            return redirect()->back()->withInput()
                ->with('error', 'Nama bahan dan satuan wajib diisi.');
        }

        if ($harga < 0) {
            return redirect()->back()->withInput()
                ->with('error', 'Harga tidak boleh negatif.');
        }

        $duplicate = $this->bahanModel
            ->where('id_sppg', $this->currentSppg())
            ->where('nama_bahan', $nama)
            ->where('id !=', $id)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()
                ->with('error', 'Nama bahan sudah digunakan.');
        }

        $hargaLama = (float) $bahan['harga'];

        $this->bahanModel->update($id, [
            'nama_bahan' => $nama,
            'satuan_default' => $satuan,
            'harga' => $harga,
            'updated_by' => session('user_id'),
        ]);

        if ($harga != $hargaLama) {
            $this->hargaModel->insert([
                'bahan_id' => $id,
                'harga_lama' => $hargaLama,
                'harga_baru' => $harga,
                'diubah_oleh' => session('user_id'),
                'keterangan' => 'Perubahan harga Master Bahan oleh Koperasi',
            ]);
        }

        return redirect()->to(base_url('gizi/bahan'))
            ->with('success', 'Master bahan berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $bahan = $this->bahanModel
            ->where('id', $id)
            ->where('id_sppg', $this->currentSppg())
            ->first();

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        $status = $bahan['status'] === 'aktif' ? 'nonaktif' : 'aktif';

        $this->bahanModel->update($id, [
            'status' => $status,
            'updated_by' => session('user_id'),
        ]);

        return redirect()->back()->with(
            'success',
            'Status bahan diubah menjadi ' . ucfirst($status) . '.'
        );
    }

    public function history($id)
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $bahan = $this->bahanModel
            ->where('id', $id)
            ->where('id_sppg', $this->currentSppg())
            ->first();

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        $history = $this->hargaModel
            ->where('bahan_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('gizi/bahan/history', [
            'title' => 'Riwayat Harga Bahan',
            'bahan' => $bahan,
            'history' => $history,
        ]);
    }
}
