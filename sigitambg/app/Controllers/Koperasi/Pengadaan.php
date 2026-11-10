<?php

namespace App\Controllers\Koperasi;

use App\Models\BahanBakuModel;
use App\Models\BahanBakuDetailModel;
use App\Models\UserActivityLogModel;
use App\Models\KoperasiPembelianModel;
use App\Models\KoperasiPembelianDetailModel;

class Pengadaan extends BaseKoperasi
{
    private BahanBakuModel $model;
    private BahanBakuDetailModel $detail;

    public function __construct()
    {
        parent::__construct();
        $this->model = new BahanBakuModel();
        $this->detail = new BahanBakuDetailModel();
    }

    private function total(int $id): float
    {
        $r = $this->detail->selectSum('total_harga')->where('belanja_id', $id)->first();
        return (float) ($r['total_harga'] ?? 0);
    }

    /**
     * Hanya pengajuan yang menjadi pekerjaan Koperasi:
     * waiting_koperasi -> procurement -> completed.
     * Tidak memakai paginate() CodeIgniter; pagination ditangani DataTables.
     */
    public function index()
    {
        if ($r = $this->ensureKoperasi()) {
            return $r;
        }

        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));
        $allowed = ['waiting_koperasi', 'procurement', 'completed'];

        $builder = $this->model->builder();
        $builder->distinct();
        $builder->select([
            'bb.id',
            'bb.kode_transaksi',
            'bb.id_sppg',
            'bb.tanggal',
            'bb.status',
            'bb.catatan_keuangan',
            'bb.catatan_approval',
            'bb.koperasi_note',
            'bb.created_at',
            's.sppg_name',
        ]);
        $builder->from('bahan_baku bb');
        $builder->join(
            'koperasi_sppg ks',
            'ks.id_sppg = bb.id_sppg AND ks.koperasi_id = ' . (int) $this->koperasiId() . " AND ks.status = 'active'",
            'inner'
        );
        $builder->join('sppg s', "s.id_sppg = bb.id_sppg AND s.status = 'active'", 'inner');
        $builder->whereIn('bb.status', $allowed);

        if ($status !== '' && in_array($status, $allowed, true)) {
            $builder->where('bb.status', $status);
        }

        if ($q !== '') {
            $builder->groupStart();
            $builder->like('bb.kode_transaksi', $q);
            $builder->orLike('bb.catatan_keuangan', $q);
            $builder->orLike('bb.catatan_approval', $q);
            $builder->orLike('bb.koperasi_note', $q);
            $builder->orLike('s.sppg_name', $q);
            $builder->groupEnd();
        }

        $rows = $builder->orderBy('bb.id', 'DESC')->get()->getResultArray();

        foreach ($rows as &$row) {
            $row['grand_total'] = $this->total((int) $row['id']);
        }
        unset($row);

        return view('koperasi/pengadaan/index', [
            'rows' => $rows,
            'names' => [],
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function detail(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;

        $row = $this->model
            ->select('bahan_baku.*')
            ->join('koperasi_sppg', 'koperasi_sppg.id_sppg = bahan_baku.id_sppg')
            ->where('bahan_baku.id', $id)
            ->where('koperasi_sppg.koperasi_id', $this->koperasiId())
            ->where('koperasi_sppg.status', 'active')
            ->whereIn('bahan_baku.status', ['waiting_koperasi', 'procurement', 'completed'])
            ->first();

        if (!$row) {
            return redirect()->to(base_url('koperasi/pengadaan'))
                ->with('error', 'Pengajuan tidak ditemukan atau bukan dari SPPG yang ditangani.');
        }

        return view('koperasi/pengadaan/detail', [
            'row' => $row,
            'details' => $this->detail->where('belanja_id', $id)->findAll(),
            'grand_total' => $this->total($id),
        ]);
    }

    public function process(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;

        $row = $this->model
            ->select('bahan_baku.*')
            ->join('koperasi_sppg', 'koperasi_sppg.id_sppg = bahan_baku.id_sppg')
            ->where('bahan_baku.id', $id)
            ->where('koperasi_sppg.koperasi_id', $this->koperasiId())
            ->where('koperasi_sppg.status', 'active')
            ->first();

        if (!$row) return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');
        if ($row['status'] !== 'waiting_koperasi') {
            return redirect()->back()->with('error', 'Pengajuan belum siap diproses Koperasi.');
        }

        $note = trim((string) $this->request->getPost('koperasi_note')) ?: null;
        $this->model->update($id, [
            'status' => 'procurement',
            'koperasi_processed_by' => session('user_id'),
            'koperasi_processed_at' => date('Y-m-d H:i:s'),
            'koperasi_note' => $note,
        ]);

        $purchaseModel = new KoperasiPembelianModel();
        $purchaseDetail = new KoperasiPembelianDetailModel();
        $existing = $purchaseModel->where('belanja_id', $id)->first();

        if (!$existing) {
            $no = 'PB-' . date('Ymd') . '-' . str_pad((string) ($purchaseModel->countAll() + 1), 5, '0', STR_PAD_LEFT);
            $purchaseId = $purchaseModel->insert([
                'no_pembelian' => $no,
                'belanja_id' => $id,
                'id_sppg' => $row['id_sppg'],
                'tanggal_pembelian' => date('Y-m-d'),
                'supplier' => null,
                'no_invoice_supplier' => null,
                'catatan' => $note,
                'status' => 'draft',
                'total' => 0,
                'created_by' => session('user_id'),
                'updated_by' => session('user_id'),
            ], true);

            if (!$purchaseId) {
                $this->model->update($id, [
                    'status' => 'waiting_koperasi',
                    'koperasi_processed_by' => null,
                    'koperasi_processed_at' => null,
                    'koperasi_note' => null,
                ]);
                return redirect()->back()->with('error', 'Dokumen Pembelian Koperasi gagal dibuat. Pengadaan dikembalikan ke Menunggu Koperasi.');
            }

            foreach ($this->detail->where('belanja_id', $id)->findAll() as $item) {
                $purchaseDetail->insert([
                    'pembelian_id' => $purchaseId,
                    'bahan_id' => $item['bahan_id'],
                    'nama_bahan' => $item['nama_bahan'],
                    'qty_diminta' => (float) $item['qty'],
                    'qty_dibeli' => (float) $item['qty'],
                    'satuan' => $item['satuan'],
                    'harga_satuan' => (float) $item['harga'],
                    'harga_beli_snapshot' => 0,
                    'harga_jual_snapshot' => (float) $item['harga'],
                    'margin_snapshot' => 0,
                    'margin_persen_snapshot' => 0,
                    'total_harga' => (float) $item['total_harga'],
                ]);
            }

            $existing = ['id' => $purchaseId];
        }

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'),
            'id_sppg' => $row['id_sppg'],
            'user_level' => 'koperasi',
            'username' => (string) session('email'),
            'activity' => 'Menerima pengadaan dan memulai proses',
            'module' => 'Pengadaan Bahan',
            'method' => 'POST',
            'uri' => '/koperasi/pengadaan/process/' . $id,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('koperasi/pembelian/detail/' . $existing['id']))
            ->with('success', 'Pengadaan diterima. Silakan lengkapi data pembelian dan siapkan barang untuk dikirim ke SPPG.');
    }

    public function complete(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;

        $row = $this->model
            ->select('bahan_baku.*')
            ->join('koperasi_sppg', 'koperasi_sppg.id_sppg = bahan_baku.id_sppg')
            ->where('bahan_baku.id', $id)
            ->where('koperasi_sppg.koperasi_id', $this->koperasiId())
            ->where('koperasi_sppg.status', 'active')
            ->first();

        if (!$row) return redirect()->back()->with('error', 'Pengajuan tidak ditemukan.');

        $purchase = (new KoperasiPembelianModel())->where('belanja_id', $id)->first();
        if ($purchase) {
            return redirect()->to(base_url('koperasi/pembelian/detail/' . $purchase['id']))
                ->with('error', 'Penyelesaian pengadaan dilakukan melalui fitur Pembelian Koperasi.');
        }
        if ($row['status'] !== 'procurement') return redirect()->back()->with('error', 'Pengadaan belum dalam proses.');
        return redirect()->back()->with('error', 'Pembelian belum dibuat untuk pengadaan ini.');
    }
}
