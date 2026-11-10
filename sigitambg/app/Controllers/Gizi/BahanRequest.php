<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\BahanRequestModel;
use App\Models\MasterBahanModel;

class BahanRequest extends BaseController
{
    protected BahanRequestModel $requestModel;
    protected MasterBahanModel $bahanModel;

    public function __construct()
    {
        $this->requestModel = new BahanRequestModel();
        $this->bahanModel = new MasterBahanModel();
    }

    protected function currentSppg(): ?string
    {
        return session('id_sppg') ?: null;
    }

    protected function ensureGizi(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session('user_level') !== 'gizi') {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Fitur Request Bahan hanya untuk role Gizi.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureGizi()) {
            return $redirect;
        }

        $requests = $this->requestModel
            ->where('id_sppg', $this->currentSppg())
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('gizi/bahan_request/index', [
            'title' => 'Request Bahan Baru',
            'requests' => $requests,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->ensureGizi()) {
            return $redirect;
        }

        return view('gizi/bahan_request/create', [
            'title' => 'Request Bahan Baru',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureGizi()) {
            return $redirect;
        }

        $nama = trim((string) $this->request->getPost('nama_bahan'));
        $satuan = trim((string) $this->request->getPost('satuan'));
        $keterangan = trim((string) $this->request->getPost('keterangan'));

        if ($nama === '' || $satuan === '') {
            return redirect()->back()->withInput()
                ->with('error', 'Nama bahan dan satuan wajib diisi.');
        }

        $idSppg = $this->currentSppg();

        $master = $this->bahanModel
            ->where('id_sppg', $idSppg)
            ->where('nama_bahan', $nama)
            ->first();

        if ($master) {
            return redirect()->back()->withInput()
                ->with('error', 'Bahan tersebut sudah tersedia di Master Bahan. Silakan gunakan bahan yang sudah ada.');
        }

        $pending = $this->requestModel
            ->where('id_sppg', $idSppg)
            ->where('nama_bahan', $nama)
            ->where('status', 'menunggu')
            ->first();

        if ($pending) {
            return redirect()->back()->withInput()
                ->with('error', 'Request bahan yang sama masih menunggu persetujuan Koperasi.');
        }

        $ok = $this->requestModel->insert([
            'id_sppg' => $idSppg,
            'nama_bahan' => $nama,
            'satuan' => $satuan,
            'keterangan' => $keterangan ?: null,
            'status' => 'menunggu',
            'requested_by' => session('user_id'),
        ]);

        if (!$ok) {
            return redirect()->back()->withInput()
                ->with('error', 'Request bahan gagal disimpan.');
        }

        return redirect()->to(base_url('gizi/bahan/request'))
            ->with('success', 'Request bahan berhasil dikirim ke Koperasi.');
    }
}
