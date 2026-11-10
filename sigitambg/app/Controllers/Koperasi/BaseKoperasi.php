<?php

namespace App\Controllers\Koperasi;

use App\Controllers\BaseController;
use App\Models\KoperasiModel;
use App\Models\KoperasiSppgModel;
use App\Models\SppgModel;

abstract class BaseKoperasi extends BaseController
{
    protected KoperasiModel $koperasiModel;
    protected KoperasiSppgModel $relasiModel;
    protected SppgModel $sppgModel;

    public function __construct()
    {
        $this->koperasiModel = new KoperasiModel();
        $this->relasiModel = new KoperasiSppgModel();
        $this->sppgModel = new SppgModel();
    }

    protected function ensureKoperasi(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session('user_level') !== 'koperasi') {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Fitur ini hanya untuk akun Koperasi.');
        }

        $koperasiId = (int) session('koperasi_id');
        if ($koperasiId <= 0) {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Akun Koperasi belum terhubung dengan Master Koperasi. Hubungi Super Admin.');
        }

        $koperasi = $this->koperasiModel->find($koperasiId);
        if (!$koperasi || ($koperasi['status'] ?? 'inactive') !== 'active') {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Koperasi Anda sedang tidak aktif. Hubungi Super Admin.');
        }

        return null;
    }

    protected function koperasiId(): int
    {
        return (int) session('koperasi_id');
    }

    protected function assignedSppgs(): array
    {
        return $this->relasiModel
            ->select('koperasi_sppg.id_sppg, sppg.sppg_name')
            ->join('sppg', 'sppg.id_sppg = koperasi_sppg.id_sppg')
            ->where('koperasi_sppg.koperasi_id', $this->koperasiId())
            ->where('koperasi_sppg.status', 'active')
            ->where('sppg.status', 'active')
            ->orderBy('sppg.sppg_name', 'ASC')
            ->findAll();
    }

    protected function activeSppgId(): ?string
    {
        $assigned = $this->assignedSppgs();
        if (!$assigned) {
            session()->remove('koperasi_active_sppg');
            return null;
        }

        $selected = (string) (session('koperasi_active_sppg') ?? '');
        foreach ($assigned as $sppg) {
            if ((string) $sppg['id_sppg'] === $selected) {
                return $selected;
            }
        }

        $selected = (string) $assigned[0]['id_sppg'];
        session()->set('koperasi_active_sppg', $selected);
        return $selected;
    }

    protected function hasAssignedSppg(string $idSppg): bool
    {
        foreach ($this->assignedSppgs() as $sppg) {
            if ((string) $sppg['id_sppg'] === $idSppg) {
                return true;
            }
        }
        return false;
    }
}
