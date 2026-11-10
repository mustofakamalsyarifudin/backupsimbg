<?php

namespace App\Controllers\Koperasi;

use App\Models\BahanRequestModel;
use App\Models\MasterBahanModel;
use App\Models\SupplierKoperasiModel;
use App\Models\UserModel;

class Dashboard extends BaseKoperasi
{
    public function index()
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $sppgs = $this->assignedSppgs();
        $ids = array_map(static fn(array $row): string => (string) $row['id_sppg'], $sppgs);
        $requestModel = new BahanRequestModel();
        $bahanModel = new MasterBahanModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierKoperasiModel();
        $supplierRows = $supplierModel->where('koperasi_id', $this->koperasiId())->where('status','aktif')->findAll();
        $mouWarning = 0; $mouExpired = 0;
        $today = new \DateTimeImmutable('today');
        foreach ($supplierRows as $supplierRow) {
            if (empty($supplierRow['tanggal_mou_akhir'])) continue;
            $days = (int)$today->diff(new \DateTimeImmutable($supplierRow['tanggal_mou_akhir']))->format('%r%a');
            if ($days < 0) $mouExpired++; elseif ($days <= 30) $mouWarning++;
        }

        $pending = 0;
        $totalBahan = 0;
        $totalUser = $userModel->where('koperasi_id', $this->koperasiId())->where('status', 'active')->countAllResults();

        foreach ($ids as $idSppg) {
            $pending += $requestModel->where('id_sppg', $idSppg)->where('status', 'menunggu')->countAllResults();
            $totalBahan += $bahanModel->where('id_sppg', $idSppg)->where('status', 'aktif')->countAllResults();
        }

        $koperasi = $this->koperasiModel->find($this->koperasiId());
        $activeSppg = $this->activeSppgId();
        $activeSppgName = null;
        foreach ($sppgs as $row) {
            if ((string) $row['id_sppg'] === (string) $activeSppg) {
                $activeSppgName = $row['sppg_name'];
                break;
            }
        }

        return view('koperasi/dashboard', [
            'title' => 'Dashboard Koperasi',
            'koperasi' => $koperasi,
            'sppgs' => $sppgs,
            'activeSppg' => $activeSppg,
            'activeSppgName' => $activeSppgName,
            'pendingRequests' => $pending,
            'totalBahan' => $totalBahan,
            'totalUser' => $totalUser,
            'mouWarning' => $mouWarning,
            'mouExpired' => $mouExpired,
        ]);
    }

    public function selectSppg()
    {
        if ($redirect = $this->ensureKoperasi()) {
            return $redirect;
        }

        $idSppg = trim((string) $this->request->getPost('id_sppg'));
        if ($idSppg === '' || !$this->hasAssignedSppg($idSppg)) {
            return redirect()->back()->with('error', 'SPPG yang dipilih bukan bagian dari penugasan Koperasi.');
        }

        session()->set('koperasi_active_sppg', $idSppg);
        return redirect()->back()->with('success', 'SPPG aktif berhasil dipilih.');
    }
}
