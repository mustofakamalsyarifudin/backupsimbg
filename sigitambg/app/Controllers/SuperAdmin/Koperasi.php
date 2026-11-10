<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\KoperasiModel;
use App\Models\KoperasiSppgModel;
use App\Models\SppgModel;
use App\Models\UserModel;

class Koperasi extends BaseController
{
    protected KoperasiModel $koperasiModel;
    protected KoperasiSppgModel $relasiModel;
    protected SppgModel $sppgModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->koperasiModel = new KoperasiModel();
        $this->relasiModel = new KoperasiSppgModel();
        $this->sppgModel = new SppgModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));

        $builder = $this->koperasiModel;

        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('kode_koperasi', $search)
                ->orLike('nama_koperasi', $search)
                ->orLike('alamat', $search)
                ->orLike('telepon', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        if (in_array($status, ['active', 'inactive'], true)) {
            $builder->where('status', $status);
        } else {
            $status = '';
        }

        $koperasis = $builder
            ->orderBy('created_at', 'DESC')
            ->orderBy('nama_koperasi', 'ASC')
            ->paginate(10);

        foreach ($koperasis as &$koperasi) {
            $koperasi['jumlah_sppg'] = $this->relasiModel
                ->where('koperasi_id', $koperasi['id'])
                ->where('status', 'active')
                ->countAllResults();

            $koperasi['jumlah_user'] = $this->userModel
                ->where('koperasi_id', $koperasi['id'])
                ->countAllResults();
        }
        unset($koperasi);

        return view('super_admin/koperasi/index', [
            'title' => 'Master Koperasi',
            'koperasis' => $koperasis,
            'pager' => $this->koperasiModel->pager,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('super_admin/koperasi/create', [
            'title' => 'Tambah Koperasi',
        ]);
    }

    public function store()
    {
        $rules = [
            'kode_koperasi' => 'required|max_length[30]|regex_match[/^[A-Za-z0-9_-]+$/]',
            'nama_koperasi' => 'required|max_length[150]',
            'alamat' => 'permit_empty|max_length[255]',
            'telepon' => 'permit_empty|max_length[30]',
            'email' => 'permit_empty|valid_email|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Periksa kembali data koperasi yang diisi.')
                ->with('errors', $this->validator->getErrors());
        }

        $kode = trim((string) $this->request->getPost('kode_koperasi'));

        if ($this->koperasiModel->where('kode_koperasi', $kode)->first()) {
            return redirect()->back()->withInput()
                ->with('error', 'Kode koperasi sudah digunakan.');
        }

        $ok = $this->koperasiModel->insert([
            'kode_koperasi' => $kode,
            'nama_koperasi' => trim((string) $this->request->getPost('nama_koperasi')),
            'alamat' => trim((string) $this->request->getPost('alamat')) ?: null,
            'telepon' => trim((string) $this->request->getPost('telepon')) ?: null,
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'status' => 'active',
        ]);

        if (! $ok) {
            return redirect()->back()->withInput()
                ->with('error', 'Koperasi gagal ditambahkan.');
        }

        return redirect()->to(base_url('super-admin/koperasi'))
            ->with('success', 'Koperasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $koperasi = $this->koperasiModel->find($id);

        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        return view('super_admin/koperasi/edit', [
            'title' => 'Edit Koperasi',
            'koperasi' => $koperasi,
        ]);
    }

    public function update($id)
    {
        $koperasi = $this->koperasiModel->find($id);

        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        $rules = [
            'kode_koperasi' => 'required|max_length[30]|regex_match[/^[A-Za-z0-9_-]+$/]',
            'nama_koperasi' => 'required|max_length[150]',
            'alamat' => 'permit_empty|max_length[255]',
            'telepon' => 'permit_empty|max_length[30]',
            'email' => 'permit_empty|valid_email|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Periksa kembali data koperasi yang diisi.')
                ->with('errors', $this->validator->getErrors());
        }

        $kode = trim((string) $this->request->getPost('kode_koperasi'));
        $duplicate = $this->koperasiModel
            ->where('kode_koperasi', $kode)
            ->where('id !=', $id)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()
                ->with('error', 'Kode koperasi sudah digunakan koperasi lain.');
        }

        $this->koperasiModel->update($id, [
            'kode_koperasi' => $kode,
            'nama_koperasi' => trim((string) $this->request->getPost('nama_koperasi')),
            'alamat' => trim((string) $this->request->getPost('alamat')) ?: null,
            'telepon' => trim((string) $this->request->getPost('telepon')) ?: null,
            'email' => trim((string) $this->request->getPost('email')) ?: null,
        ]);

        return redirect()->to(base_url('super-admin/koperasi'))
            ->with('success', 'Data koperasi berhasil diperbarui.');
    }

    public function detail($id)
    {
        $koperasi = $this->koperasiModel->find($id);
        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        $rows = $this->relasiModel
            ->select('koperasi_sppg.*, sppg.sppg_name')
            ->join('sppg', 'sppg.id_sppg = koperasi_sppg.id_sppg')
            ->where('koperasi_sppg.koperasi_id', $id)
            ->orderBy('koperasi_sppg.status', 'DESC')
            ->orderBy('sppg.sppg_name', 'ASC')
            ->findAll();

        $assigned = [];
        foreach ($rows as $row) {
            if (($row['status'] ?? '') === 'active') {
                $assigned[] = (string) $row['id_sppg'];
            }
        }

        return view('super_admin/koperasi/detail', [
            'title' => 'Penugasan Koperasi',
            'koperasi' => $koperasi,
            'sppgs' => $this->sppgModel
                ->where('status', 'active')
                ->orderBy('sppg_name', 'ASC')
                ->findAll(),
            'assigned' => $assigned,
            'rows' => $rows,
        ]);
    }

    public function assign($id)
    {
        $koperasi = $this->koperasiModel->find($id);
        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        if (($koperasi['status'] ?? 'inactive') !== 'active') {
            return redirect()->back()->with('error', 'Koperasi nonaktif tidak dapat menerima penugasan SPPG.');
        }

        $selected = $this->request->getPost('id_sppg') ?? [];
        if (! is_array($selected)) {
            $selected = [];
        }

        $selected = array_values(array_unique(array_filter(array_map('strval', $selected))));
        $validSppgs = $this->sppgModel->where('status', 'active')->findAll();
        $validIds = array_map(static fn(array $s): string => (string) $s['id_sppg'], $validSppgs);
        $selected = array_values(array_intersect($selected, $validIds));

        $existing = $this->relasiModel
            ->where('koperasi_id', $id)
            ->findAll();

        $existingBySppg = [];
        foreach ($existing as $row) {
            $existingBySppg[(string) $row['id_sppg']] = $row;
        }

        $db = $this->relasiModel->db;
        $db->transStart();

        foreach ($existingBySppg as $idSppg => $row) {
            if (! in_array($idSppg, $selected, true) && ($row['status'] ?? '') === 'active') {
                $this->relasiModel->update($row['id'], [
                    'status' => 'inactive',
                    'tanggal_selesai' => date('Y-m-d'),
                ]);
            }
        }

        foreach ($selected as $idSppg) {
            if (isset($existingBySppg[$idSppg])) {
                $row = $existingBySppg[$idSppg];
                $this->relasiModel->update($row['id'], [
                    'status' => 'active',
                    'tanggal_mulai' => $row['tanggal_mulai'] ?: date('Y-m-d'),
                    'tanggal_selesai' => null,
                ]);
            } else {
                $this->relasiModel->insert([
                    'koperasi_id' => $id,
                    'id_sppg' => $idSppg,
                    'status' => 'active',
                    'tanggal_mulai' => date('Y-m-d'),
                    'tanggal_selesai' => null,
                ]);
            }
        }

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Penugasan SPPG gagal disimpan.');
        }

        return redirect()->back()->with('success', 'Penugasan SPPG berhasil diperbarui.');
    }

    public function toggle($id)
    {
        $koperasi = $this->koperasiModel->find($id);
        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        $currentStatus = $koperasi['status'] ?? 'inactive';
        $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';

        if (! $this->koperasiModel->update($id, ['status' => $newStatus])) {
            return redirect()->back()
                ->with('error', 'Status koperasi gagal diubah.');
        }

        // Status Koperasi berdiri sendiri dari riwayat penugasan SPPG.
        // Menonaktifkan Koperasi tidak menghapus/menonaktifkan relasi,
        // sehingga saat Koperasi diaktifkan kembali relasi sebelumnya
        // tetap dapat digunakan tanpa kehilangan histori.
        return redirect()->back()->with(
            'success',
            $newStatus === 'active'
                ? 'Koperasi berhasil diaktifkan.'
                : 'Koperasi berhasil dinonaktifkan.'
        );
    }

    public function delete($id)
    {
        $koperasi = $this->koperasiModel->find($id);
        if (! $koperasi) {
            return redirect()->to(base_url('super-admin/koperasi'))
                ->with('error', 'Koperasi tidak ditemukan.');
        }

        $hasRelation = $this->relasiModel->where('koperasi_id', $id)->countAllResults() > 0;
        $hasUser = $this->userModel->where('koperasi_id', $id)->countAllResults() > 0;

        if ($hasRelation || $hasUser) {
            return redirect()->back()->with('error', 'Koperasi tidak dapat dihapus karena masih memiliki riwayat penugasan SPPG atau user. Gunakan Nonaktifkan.');
        }

        if (! $this->koperasiModel->delete($id)) {
            return redirect()->back()->with('error', 'Koperasi gagal dihapus.');
        }

        return redirect()->to(base_url('super-admin/koperasi'))
            ->with('success', 'Koperasi berhasil dihapus.');
    }
}
