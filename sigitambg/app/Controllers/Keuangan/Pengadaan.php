<?php
namespace App\Controllers\Keuangan;

use App\Models\BahanBakuModel;
use App\Models\BahanBakuDetailModel;
use App\Models\UserActivityLogModel;

class Pengadaan extends BaseKeuangan
{
    protected BahanBakuModel $model;
    protected BahanBakuDetailModel $detailModel;

    public function __construct()
    {
        $this->model = new BahanBakuModel();
        $this->detailModel = new BahanBakuDetailModel();
    }

    private function total(int $id): float
    {
        $row = $this->detailModel->selectSum('total_harga')->where('belanja_id', $id)->first();
        return (float) ($row['total_harga'] ?? 0);
    }

    public function index()
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;

        $status = trim((string) $this->request->getGet('status'));
        $q = trim((string) $this->request->getGet('q'));
        $builder = $this->model->where('id_sppg', session('id_sppg'))->where('status !=', 'draft');

        if ($q !== '') {
            $builder->groupStart()
                ->like('kode_transaksi', $q)
                ->orLike('catatan_keuangan', $q)
                ->orLike('catatan_approval', $q)
                ->groupEnd();
        }

        $allowed = ['waiting_finance','rejected_finance','waiting_kepala','rejected_kepala','waiting_koperasi','procurement','completed'];
        if ($status === 'draft') {
            // Draft adalah proses internal Gizi dan tidak ditampilkan di modul Keuangan.
            $builder->where('status', '__never__');
        } elseif (in_array($status, $allowed, true)) {
            $builder->where('status', $status);
        }

        $rows = $builder->orderBy('id', 'DESC')->findAll();
        foreach ($rows as &$row) {
            $row['grand_total'] = $this->total((int) $row['id']);
            $row['pagu_available'] = $row['pagu_total'] !== null && $row['pagu_total'] !== '';
            $row['pagu_selisih_live'] = $row['pagu_available']
                ? (float) $row['pagu_total'] - (float) $row['grand_total']
                : null;
        }

        return view('keuangan/pengadaan/index', [
            'rows' => $rows,
            'q' => $q,
            'status' => $status,
            'sppg_name' => $this->sppgName(),
            'title' => 'Pengajuan Pembelian Bahan',
        ]);
    }

    public function detail(int $id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row) return redirect()->to(base_url('keuangan/pengadaan'))->with('error', 'Pengajuan tidak ditemukan.');

        $grandTotal = $this->total($id);
        $paguAvailable = $row['pagu_total'] !== null && $row['pagu_total'] !== '';
        $paguSelisih = $paguAvailable ? (float) $row['pagu_total'] - $grandTotal : null;

        return view('keuangan/pengadaan/detail', [
            'row' => $row,
            'pagu_available' => $paguAvailable,
            'pagu_selisih' => $paguSelisih,
            'details' => $this->detailModel->where('belanja_id', $id)->findAll(),
            'grand_total' => $grandTotal,
            'sppg_name' => $this->sppgName(),
        ]);
    }

    /**
     * Invoice tagihan koperasi untuk pengajuan yang sudah berstatus completed.
     * Menggunakan snapshot pembelian koperasi agar nilai tagihan sesuai nilai yang diproses koperasi.
     */
    public function invoice(int $id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;

        $db = \Config\Database::connect();
        $row = $db->table('bahan_baku bb')
            ->select('bb.*, s.sppg_name, s.address AS sppg_address, s.phone AS sppg_phone, s.email AS sppg_email')
            ->join('sppg s', 's.id_sppg = bb.id_sppg', 'left')
            ->where('bb.id', $id)
            ->where('bb.id_sppg', session('id_sppg'))
            ->where('bb.status', 'completed')
            ->get()->getRowArray();

        if (!$row) {
            return redirect()->to(base_url('keuangan/pengadaan'))
                ->with('error', 'Invoice hanya tersedia untuk pengajuan yang sudah selesai.');
        }

        $purchase = $db->table('koperasi_pembelian')
            ->where('belanja_id', $id)
            ->where('id_sppg', $row['id_sppg'])
            ->orderBy('id', 'DESC')->get()->getRowArray();

        if (!$purchase) {
            return redirect()->to(base_url('keuangan/pengadaan/detail/' . $id))
                ->with('error', 'Data pembelian koperasi belum tersedia, sehingga invoice belum dapat dibuat.');
        }

        $details = $db->table('koperasi_pembelian_detail')
            ->where('pembelian_id', $purchase['id'])
            ->orderBy('id', 'ASC')->get()->getResultArray();

        $total = (float) ($purchase['total'] ?? 0);
        if ($total <= 0) {
            foreach ($details as $item) $total += (float) ($item['total_harga'] ?? 0);
        }

        return view('keuangan/pengadaan/invoice', [
            'row' => $row,
            'purchase' => $purchase,
            'details' => $details,
            'invoice_total' => $total,
            'invoice_number' => 'INV-' . preg_replace('/[^A-Za-z0-9-]/', '', (string) $row['kode_transaksi']),
            'sppg_name' => $this->sppgName(),
        ]);
    }

    public function approve(int $id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row || $row['status'] !== 'waiting_finance') {
            return redirect()->back()->with('error', 'Pengajuan tidak tersedia untuk pemeriksaan Keuangan.');
        }

        $note = trim((string) $this->request->getPost('catatan_keuangan'));

        $grandTotal = $this->total($id);
        $pagu = ($row['pagu_total'] !== null && $row['pagu_total'] !== '')
            ? (float) $row['pagu_total']
            : null;

        if ($pagu !== null && $grandTotal > $pagu && $note === '') {
            return redirect()->back()
                ->with('error', 'Pengajuan melebihi pagu harian sebesar Rp ' . number_format($grandTotal - $pagu, 0, ',', '.') . '. Catatan/alasan wajib diisi sebelum diteruskan.');
        }

        $this->model->update($id, [
            'status' => 'waiting_kepala',
            'catatan_keuangan' => $note ?: null,
            'finance_reviewed_by' => session('user_id'),
            'finance_reviewed_at' => date('Y-m-d H:i:s'),
        ]);

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'), 'id_sppg' => session('id_sppg'),
            'user_level' => 'keuangan', 'username' => (string) session('email'),
            'activity' => 'Menyetujui pengajuan pembelian dan meneruskan ke Kepala SPPG',
            'module' => 'Pengadaan Bahan', 'method' => 'POST',
            'uri' => '/keuangan/pengadaan/approve/' . $id,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('keuangan/pengadaan/detail/' . $id))
            ->with('success', 'Pengajuan disetujui Keuangan dan diteruskan ke Kepala SPPG.');
    }

    public function reject(int $id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;

        $row = $this->model->where('id', $id)->where('id_sppg', session('id_sppg'))->first();
        if (!$row || $row['status'] !== 'waiting_finance') {
            return redirect()->back()->with('error', 'Pengajuan tidak tersedia untuk ditolak.');
        }

        $note = trim((string) $this->request->getPost('catatan_keuangan'));
        if ($note === '') return redirect()->back()->with('error', 'Catatan/alasan Keuangan wajib diisi saat menolak.');

        $this->model->update($id, [
            'status' => 'rejected_finance',
            'catatan_keuangan' => $note,
            'finance_reviewed_by' => session('user_id'),
            'finance_reviewed_at' => date('Y-m-d H:i:s'),
        ]);

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'), 'id_sppg' => session('id_sppg'),
            'user_level' => 'keuangan', 'username' => (string) session('email'),
            'activity' => 'Menolak pengajuan pembelian dan mengembalikannya ke Gizi',
            'module' => 'Pengadaan Bahan', 'method' => 'POST',
            'uri' => '/keuangan/pengadaan/reject/' . $id,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('keuangan/pengadaan/detail/' . $id))
            ->with('success', 'Pengajuan ditolak dan dikembalikan ke Gizi.');
    }
}
