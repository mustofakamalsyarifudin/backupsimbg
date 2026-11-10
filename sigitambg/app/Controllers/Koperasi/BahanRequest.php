<?php

namespace App\Controllers\Koperasi;

use App\Models\BahanRequestModel;
use App\Models\MasterBahanModel;

class BahanRequest extends BaseKoperasi
{
    protected BahanRequestModel $requestModel;
    protected MasterBahanModel $bahanModel;

    public function __construct()
    {
        parent::__construct();
        $this->requestModel = new BahanRequestModel();
        $this->bahanModel = new MasterBahanModel();
    }

    public function index()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $sppgs = $this->assignedSppgs();
        $ids = array_map(static fn(array $row): string => (string) $row['id_sppg'], $sppgs);
        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));
        $sppg = trim((string) $this->request->getGet('sppg'));

        if (!$ids) $requests = [];
        else {
            $builder = $this->requestModel;
            $builder->whereIn('id_sppg', $ids);
            if ($q !== '') $builder->groupStart()->like('nama_bahan', $q)->orLike('keterangan', $q)->groupEnd();
            if (in_array($status, ['menunggu','dipenuhi','ditolak'], true)) $builder->where('status', $status);
            if ($sppg !== '' && in_array($sppg, $ids, true)) $builder->where('id_sppg', $sppg);
            $requests = $builder->orderBy('created_at', 'DESC')->findAll();
        }

        $pager = $this->requestModel->pager;
        $sppgNames = [];
        foreach ($sppgs as $row) $sppgNames[(string) $row['id_sppg']] = $row['sppg_name'];
        return view('koperasi/bahan_request/index', compact('requests','pager','sppgs','sppgNames','q','status','sppg') + ['title' => 'Request Bahan dari SPPG']);
    }

    public function approve($id)
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $requestRow = $this->requestModel->find($id);
        if (!$requestRow) return redirect()->back()->with('error', 'Request bahan tidak ditemukan.');
        if (!$this->hasAssignedSppg((string) $requestRow['id_sppg'])) return redirect()->back()->with('error', 'Request bukan dari SPPG yang ditangani Koperasi ini.');
        if (($requestRow['status'] ?? '') !== 'menunggu') return redirect()->back()->with('error', 'Request sudah diproses.');

        // Harga sengaja tidak diminta saat request disetujui. Koperasi mengatur harga
        // setelah bahan tersedia, karena harga dapat berbeda di setiap SPPG.
        $harga = 0;

        $duplicate = $this->bahanModel->where('id_sppg', $requestRow['id_sppg'])->where('nama_bahan', $requestRow['nama_bahan'])->first();
        if ($duplicate) return redirect()->back()->with('error', 'Bahan sudah ada di Master Bahan SPPG tersebut.');

        $db = $this->requestModel->db;
        $db->transStart();
        $masterId = $this->bahanModel->insert([
            'id_sppg' => $requestRow['id_sppg'],
            'nama_bahan' => $requestRow['nama_bahan'],
            'satuan_default' => $requestRow['satuan'],
            'harga' => 0,
            'status' => 'aktif',
            'created_by' => session('user_id'),
            'updated_by' => session('user_id'),
        ], true);
        if ($masterId) {
            $this->requestModel->update($id, [
                'status' => 'dipenuhi',
                'processed_by' => session('user_id'),
                'processed_at' => date('Y-m-d H:i:s'),
                'master_bahan_id' => $masterId,
                'rejection_reason' => null,
            ]);
        }
        $db->transComplete();
        if (!$masterId || !$db->transStatus()) return redirect()->back()->with('error', 'Request gagal dipenuhi. Tidak ada data kebutuhan/kuantitas yang dihitung otomatis.');
        return redirect()->back()->with('success', 'Request disetujui. Bahan sudah masuk Master Bahan dan dapat digunakan pada transaksi SPPG.');
    }

    public function reject($id)
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $requestRow = $this->requestModel->find($id);
        if (!$requestRow) return redirect()->back()->with('error', 'Request bahan tidak ditemukan.');
        if (!$this->hasAssignedSppg((string) $requestRow['id_sppg'])) return redirect()->back()->with('error', 'Request bukan dari SPPG yang ditangani Koperasi ini.');
        if (($requestRow['status'] ?? '') !== 'menunggu') return redirect()->back()->with('error', 'Request sudah diproses.');
        $reason = trim((string) $this->request->getPost('rejection_reason'));
        if ($reason === '') return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        $this->requestModel->update($id, ['status' => 'ditolak', 'processed_by' => session('user_id'), 'processed_at' => date('Y-m-d H:i:s'), 'rejection_reason' => $reason]);
        return redirect()->back()->with('success', 'Request bahan ditolak dan alasannya sudah dicatat.');
    }
}
