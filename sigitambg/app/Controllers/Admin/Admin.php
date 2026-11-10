<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminSppgModel;
use App\Models\SppgModel;

class Admin extends BaseController
{
    protected SppgModel $sppgModel;
    protected AdminSppgModel $adminSppgModel;

    public function __construct()
    {
        $this->sppgModel = new SppgModel();
        $this->adminSppgModel = new AdminSppgModel();
    }

    protected function ensureAdmin(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (!in_array(session('user_level'), ['admin', 'super_admin'], true)) {
            return redirect()->to(base_url('dashboard'))
                ->with('error', 'Akses Admin tidak diizinkan.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureAdmin()) return $redirect;

        $userLevel = session('user_level');
        if ($userLevel === 'super_admin') {
            $sppgs = $this->sppgModel->where('status', 'active')->orderBy('sppg_name')->findAll();
        } else {
            $sppgs = $this->sppgModel
                ->select('sppg.*')
                ->join('admin_sppg a', 'a.id_sppg = sppg.id_sppg')
                ->where('a.user_id', session('user_id'))
                ->where('a.status', 'active')
                ->where('sppg.status', 'active')
                ->orderBy('sppg.sppg_name')
                ->findAll();
        }

        $selected = (string) ($this->request->getGet('id_sppg') ?: session('selected_sppg'));
        $allowedIds = array_column($sppgs, 'id_sppg');
        if ($selected !== '' && !in_array($selected, $allowedIds, true)) {
            $selected = '';
        }
        if ($selected === '' && count($sppgs) === 1) {
            $selected = $sppgs[0]['id_sppg'];
        }
        if ($selected !== '') session()->set('selected_sppg', $selected);

        $db = \Config\Database::connect();
        $summary = [
            'total_sppg' => count($sppgs),
            'total_pm' => 0,
            'total_sekolah' => 0,
            'total_kegiatan' => 0,
        ];

        if ($selected !== '') {
            $summary['total_pm'] = (int) ($db->table('penerima_manfaat')->selectSum('total_siswa')->where('id_sppg', $selected)->get()->getRow('total_siswa') ?? 0);
            $summary['total_sekolah'] = (int) $db->table('penerima_manfaat')->where('id_sppg', $selected)->countAllResults();
            $summary['total_kegiatan'] = (int) $db->table('kegiatan_aslap')->where('id_sppg', $selected)->countAllResults();
        } else {
            $summary['total_pm'] = (int) ($db->table('penerima_manfaat')->selectSum('total_siswa')->whereIn('id_sppg', $allowedIds ?: ['__none__'])->get()->getRow('total_siswa') ?? 0);
            $summary['total_sekolah'] = (int) $db->table('penerima_manfaat')->whereIn('id_sppg', $allowedIds ?: ['__none__'])->countAllResults();
            $summary['total_kegiatan'] = (int) $db->table('kegiatan_aslap')->whereIn('id_sppg', $allowedIds ?: ['__none__'])->countAllResults();
        }

        return view('admin/index', [
            'title' => 'Dashboard Admin',
            'sppgs' => $sppgs,
            'selected' => $selected,
            'summary' => $summary,
        ]);
    }

    public function selectSppg()
    {
        if ($redirect = $this->ensureAdmin()) return $redirect;
        $idSppg = (string) $this->request->getPost('id_sppg');
        $allowed = $this->accessibleSppgIds();
        if ($idSppg !== '' && !in_array($idSppg, $allowed, true)) {
            return redirect()->back()->with('error', 'SPPG tidak termasuk dalam cakupan Admin.');
        }
        session()->set('selected_sppg', $idSppg ?: null);
        return redirect()->to(base_url('admin'));
    }

    protected function accessibleSppgIds(): array
    {
        if (session('user_level') === 'super_admin') {
            return array_column($this->sppgModel->where('status', 'active')->findAll(), 'id_sppg');
        }
        return array_column($this->adminSppgModel->where('user_id', session('user_id'))->where('status', 'active')->findAll(), 'id_sppg');
    }
}
