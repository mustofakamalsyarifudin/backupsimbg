<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;
use App\Models\SppgModel;

class Sppg extends BaseController
{
    protected SppgModel $sppgModel;

    public function __construct()
    {
        $this->sppgModel = new SppgModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('q'));

        $builder = $this->sppgModel;

        if ($search !== '') {
            $builder = $builder->groupStart()
                ->like('id_sppg', $search)
                ->orLike('sppg_name', $search)
                ->orLike('phone', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $data = [
            'title' => 'Master SPPG',
            'search' => $search,
            'sppgs' => $builder
                ->orderBy('created_at', 'DESC')
                ->orderBy('sppg_name', 'ASC')
                ->paginate(10),
            'pager' => $this->sppgModel->pager,
        ];

        return view('super_admin/sppg/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_sppg' => [
                'label' => 'ID SPPG',
                'rules' => 'required|max_length[20]|regex_match[/^[A-Za-z0-9_-]+$/]',
                'errors' => [
                    'required' => 'ID SPPG wajib diisi.',
                    'max_length' => 'ID SPPG maksimal 20 karakter.',
                    'regex_match' => 'ID SPPG hanya boleh berisi huruf, angka, tanda hubung (-), atau garis bawah (_).',
                ],
            ],
            'sppg_name' => [
                'label' => 'Nama SPPG',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama SPPG wajib diisi.',
                    'max_length' => 'Nama SPPG maksimal 100 karakter.',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal 100 karakter.',
                ],
            ],
            'phone' => [
                'label' => 'Telepon',
                'rules' => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'Nomor telepon maksimal 20 karakter.',
                ],
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'permit_empty',
            ],
            'established_date' => [
                'label' => 'Tanggal Berdiri',
                'rules' => 'permit_empty|valid_date[Y-m-d]',
                'errors' => [
                    'valid_date' => 'Tanggal berdiri tidak valid.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali data SPPG yang diisi.')->with('errors', $this->validator->getErrors());
        }

        $id = trim((string) $this->request->getPost('id_sppg'));

        if ($this->sppgModel->find($id)) {
            return redirect()->back()->withInput()->with('error', 'ID SPPG sudah digunakan. Silakan gunakan ID lain.');
        }

        $this->sppgModel->insert([
            'id_sppg' => $id,
            'sppg_name' => trim((string) $this->request->getPost('sppg_name')),
            'address' => trim((string) $this->request->getPost('address')) ?: null,
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'established_date' => $this->request->getPost('established_date') ?: null,
            'status' => 'active',
        ]);

        return redirect()->to(base_url('super-admin/sppg'))->with('success', 'SPPG berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sppg = $this->sppgModel->find($id);

        if (! $sppg) {
            return redirect()->to(base_url('super-admin/sppg'))->with('error', 'SPPG tidak ditemukan.');
        }

        return view('super_admin/sppg/edit', [
            'title' => 'Edit SPPG',
            'sppg' => $sppg,
        ]);
    }

    public function update($id)
    {
        $sppg = $this->sppgModel->find($id);

        if (! $sppg) {
            return redirect()->to(base_url('super-admin/sppg'))->with('error', 'SPPG tidak ditemukan.');
        }

        $rules = [
            'sppg_name' => [
                'label' => 'Nama SPPG',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama SPPG wajib diisi.',
                    'max_length' => 'Nama SPPG maksimal 100 karakter.',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal 100 karakter.',
                ],
            ],
            'phone' => [
                'label' => 'Telepon',
                'rules' => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'Nomor telepon maksimal 20 karakter.',
                ],
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'permit_empty',
            ],
            'established_date' => [
                'label' => 'Tanggal Berdiri',
                'rules' => 'permit_empty|valid_date[Y-m-d]',
                'errors' => [
                    'valid_date' => 'Tanggal berdiri tidak valid.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali data SPPG yang diisi.')->with('errors', $this->validator->getErrors());
        }

        $this->sppgModel->update($id, [
            'sppg_name' => trim((string) $this->request->getPost('sppg_name')),
            'address' => trim((string) $this->request->getPost('address')) ?: null,
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
            'email' => trim((string) $this->request->getPost('email')) ?: null,
            'established_date' => $this->request->getPost('established_date') ?: null,
        ]);

        return redirect()->to(base_url('super-admin/sppg'))->with('success', 'Data SPPG berhasil diperbarui.');
    }

    public function toggle($id)
    {
        $sppg = $this->sppgModel->find($id);
        if (! $sppg) {
            return redirect()->back()->with('error', 'SPPG tidak ditemukan.');
        }

        $this->sppgModel->update($id, [
            'status' => $sppg['status'] === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()->back()->with('success', 'Status SPPG berhasil diubah.');
    }
}
