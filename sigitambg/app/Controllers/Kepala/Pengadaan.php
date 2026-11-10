<?php
namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\BahanBakuDetailModel;
use App\Models\SppgModel;
use App\Models\UserActivityLogModel;

class Pengadaan extends BaseController
{
    private BahanBakuModel $model;
    private BahanBakuDetailModel $detail;

    public function __construct()
    {
        $this->model = new BahanBakuModel();
        $this->detail = new BahanBakuDetailModel();
    }

    private function guard(): ?\CodeIgniter\HTTP\RedirectResponse
    {
        if (session('user_level') !== 'kepala' || !session('id_sppg')) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Fitur ini hanya untuk Kepala SPPG.');
        }
        return null;
    }

    private function total(int $id): float
    {
        $r = $this->detail->selectSum('total_harga')->where('belanja_id', $id)->first();
        return (float) ($r['total_harga'] ?? 0);
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;

        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));
        $builder = $this->model->where('id_sppg', session('id_sppg'));

        if ($q !== '') {
            $builder->groupStart()
                ->like('kode_transaksi', $q)
                ->orLike('catatan_keuangan', $q)
                ->orLike('catatan_approval', $q)
                ->groupEnd();
        }

        $allowed = ['waiting_kepala','rejected_kepala','waiting_koperasi','procurement','completed'];
        if (in_array($status, $allowed, true)) {
            $builder->where('status', $status);
        }

        $rows = $builder->orderBy('id', 'DESC')->findAll();
        foreach ($rows as &$x) {
            $x['grand_total'] = $this->total((int) $x['id']);
        }

        $s = (new SppgModel())->where('id_sppg', session('id_sppg'))->first();

        return view('kepala/pengadaan/index', [
            'rows' => $rows,
            'q' => $q,
            'status' => $status,
            'sppg_name' => $s['sppg_name'] ?? session('id_sppg'),
        ]);
    }

    public function detail(int $id)
    {
        if ($r = $this->guard()) return $r;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row) {
            return redirect()->to(base_url('kepala/pengadaan'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        return view('kepala/pengadaan/detail', [
            'row' => $row,
            'details' => $this->detail->where('belanja_id', $id)->findAll(),
            'grand_total' => $this->total($id),
        ]);
    }

    public function approve(int $id)
    {
        if ($r = $this->guard()) return $r;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row || $row['status'] !== 'waiting_kepala') {
            return redirect()->back()->with('error', 'Pengajuan tidak tersedia untuk persetujuan Kepala.');
        }

        $note = trim((string) $this->request->getPost('catatan_approval'));
        $this->model->update($id, [
            'status' => 'waiting_koperasi',
            'catatan_approval' => $note ?: null,
            'kepala_approved_by' => session('user_id'),
            'kepala_approved_at' => date('Y-m-d H:i:s'),
        ]);

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'), 'id_sppg' => session('id_sppg'),
            'user_level' => 'kepala', 'username' => (string) session('email'),
            'activity' => 'Menyetujui pengadaan dan meneruskan ke Koperasi', 'module' => 'Pengadaan Bahan',
            'method' => 'POST', 'uri' => '/kepala/pengadaan/approve/' . $id,
            'ip_address' => $this->request->getIPAddress(), 'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('kepala/pengadaan/detail/' . $id))
            ->with('success', 'Pengajuan disetujui Kepala dan dikirim ke Koperasi untuk pengadaan.');
    }

    public function reject(int $id)
    {
        if ($r = $this->guard()) return $r;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row || $row['status'] !== 'waiting_kepala') {
            return redirect()->back()->with('error', 'Pengajuan tidak tersedia untuk ditolak.');
        }

        $note = trim((string) $this->request->getPost('catatan_approval'));
        if ($note === '') {
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $this->model->update($id, [
            'status' => 'rejected_kepala',
            'catatan_approval' => $note,
            'kepala_approved_by' => session('user_id'),
            'kepala_approved_at' => date('Y-m-d H:i:s'),
        ]);

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'), 'id_sppg' => session('id_sppg'),
            'user_level' => 'kepala', 'username' => (string) session('email'),
            'activity' => 'Menolak pengadaan dan mengembalikannya ke Gizi', 'module' => 'Pengadaan Bahan',
            'method' => 'POST', 'uri' => '/kepala/pengadaan/reject/' . $id,
            'ip_address' => $this->request->getIPAddress(), 'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('kepala/pengadaan/detail/' . $id))
            ->with('success', 'Pengajuan ditolak dan dikembalikan ke Gizi.');
    }
}
