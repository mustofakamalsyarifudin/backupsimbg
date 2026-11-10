<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\BahanBakuDetailModel;
use App\Models\MasterBahanModel;
use App\Models\UserActivityLogModel;


class BahanBaku extends BaseController
{
    protected $bahanBakuModel;
    protected $detailModel;

    public function __construct()
    {
        $this->bahanBakuModel = new BahanBakuModel();
        $this->detailModel = new BahanBakuDetailModel();
    }

    private function canEdit($status)
    {
        return in_array(
            $status,
            ['draft', 'rejected', 'rejected_finance', 'rejected_kepala']
        );
    }

    public function index()
    {
        $transaksi = $this->bahanBakuModel
            ->where('id_sppg', session('id_sppg'))
            ->orderBy('id', 'DESC')
            ->findAll();

        foreach ($transaksi as &$row) {

            $total = $this->detailModel
                ->selectSum('total_harga')
                ->where('belanja_id', $row['id'])
                ->first();

            $row['grand_total'] = $total['total_harga'] ?? 0;
        }

        $data = [

            'transaksi' => $transaksi

        ];

        return view(
            'gizi/bahan_baku/index',
            $data
        );
    }




    private function generateKodeTransaksi()
    {
        $last = $this->bahanBakuModel
            ->orderBy('id', 'DESC')
            ->first();

        $urut = 1;

        if ($last) {

            $kodeTerakhir = $last['kode_transaksi'];

            $urut = (int) substr($kodeTerakhir, -7) + 1;
        }

        return 'BB-' . date('Ymd') . '-' .
            str_pad($urut, 7, '0', STR_PAD_LEFT);
    }

    public function create()
    {
        $data = [

            'kode_transaksi' => $this->generateKodeTransaksi()

        ];

        return view(
            'gizi/bahan_baku/create',
            $data
        );
    }

    public function store()
    {
        $fotoStruk = $this->request->getFile('foto_struk');

        $namaFile = null;

        if ($fotoStruk && $fotoStruk->isValid() && !$fotoStruk->hasMoved()) {

            $namaFile = $fotoStruk->getRandomName();

            $fotoStruk->move(
                FCPATH . 'uploads/struk',
                $namaFile
            );
        }

        $id = $this->bahanBakuModel->insert([

            'kode_transaksi' => $this->generateKodeTransaksi(),

            'id_sppg' => session('id_sppg'),

            'tanggal' => $this->request->getPost('tanggal'),

            'foto_struk' => $namaFile,

            'status' => 'draft',

            'created_by' => session('user_id')

        ], true);

        return redirect()->to(
            base_url('gizi/bahan-baku/detail/' . $id)
        );
    }

    public function detail($id)
    {
        $transaksi = $this->bahanBakuModel
            ->where('id', $id)
            ->where('id_sppg', session('id_sppg'))
            ->first();

        if (!$transaksi) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $details = $this->detailModel
            ->where('belanja_id', $id)
            ->findAll();

        $bahanRows = (new MasterBahanModel())
            ->where('id_sppg', session('id_sppg'))
            ->where('status', 'aktif')
            ->orderBy('nama_bahan')
            ->findAll();

        // Hide duplicate master records from the picker. Names are compared
        // case-insensitively and with repeated whitespace normalized.
        $bahans = [];
        $seenNames = [];
        foreach ($bahanRows as $bahanRow) {
            $key = mb_strtolower(preg_replace('/\s+/u', ' ', trim((string) ($bahanRow['nama_bahan'] ?? ''))));
            if ($key === '' || isset($seenNames[$key])) {
                continue;
            }
            $seenNames[$key] = true;
            $bahans[] = $bahanRow;
        }

        $grandTotal = $this->detailModel
            ->selectSum('total_harga')
            ->where('belanja_id', $id)
            ->first();

        $data = [
            'transaksi' => $transaksi,
            'details' => $details,
            'bahans' => $bahans,
            'grand_total' => $grandTotal['total_harga'] ?? 0,
        ];

        return view(
            'gizi/bahan_baku/detail',
            $data
        );
    }

    public function storeDetail()
    {
        $bahanModel = new MasterBahanModel();

        $bahanId = (int) $this->request->getPost('bahan_id');
        $belanjaId = (int) $this->request->getPost('belanja_id');

        // Bahan harus berasal dari Master Bahan milik SPPG yang sedang login.
        // Harga diambil dari master saat bahan dimasukkan sebagai snapshot transaksi.
        $bahan = $bahanModel
            ->where('id', $bahanId)
            ->where('id_sppg', session('id_sppg'))
            ->where('status', 'aktif')
            ->first();

        if (!$bahan) {
            return redirect()->back()
                ->with('error', 'Bahan tidak ditemukan atau bukan milik SPPG Anda.');
        }

        $transaksi = $this->bahanBakuModel
            ->where('id', $belanjaId)
            ->where('id_sppg', session('id_sppg'))
            ->first();

        if (!$transaksi) {
            return redirect()->back()
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        if (!$this->canEdit($transaksi['status'])) {
            return redirect()->back()
                ->with('error', 'Transaksi sudah diajukan dan tidak dapat diubah.');
        }

        // Satu bahan hanya boleh muncul satu kali dalam satu permintaan.
        // Compare both master ID and normalized label so duplicate legacy master
        // records cannot introduce the same item into a transaction twice.
        $normalizedName = mb_strtolower(preg_replace('/\s+/u', ' ', trim((string) $bahan['nama_bahan'])));
        $existingDetails = $this->detailModel->where('belanja_id', $belanjaId)->findAll();
        foreach ($existingDetails as $existingDetail) {
            $existingName = mb_strtolower(preg_replace('/\s+/u', ' ', trim((string) ($existingDetail['nama_bahan'] ?? ''))));
            if ((int) ($existingDetail['bahan_id'] ?? 0) === (int) $bahan['id'] || ($normalizedName !== '' && $existingName === $normalizedName)) {
                return redirect()->back()
                    ->with('error', 'Bahan "' . $bahan['nama_bahan'] . '" sudah ada dalam permintaan ini.');
            }
        }

        $qty = (float) $this->request->getPost('qty');
        if ($qty <= 0) {
            return redirect()->back()
                ->with('error', 'Qty harus lebih besar dari 0.');
        }

        // Harga transaksi selalu mengambil harga Master Bahan pada saat ditambahkan.
        // Jika master belum memiliki harga, nilainya tetap 0 (belum diatur).
        $harga = (float) ($bahan['harga'] ?? 0);
        $total = $qty * $harga;

        $this->detailModel->insert([

            'belanja_id' => $belanjaId,

            'bahan_id' =>
            $bahan['id'],

            'nama_bahan' =>
            $bahan['nama_bahan'],

            'satuan' =>
            $bahan['satuan_default'],

            'qty' =>
            $qty,

            'harga' =>
            $harga,

            'total_harga' =>
            $total

        ]);

        return redirect()->to(
            base_url(
                'gizi/bahan-baku/detail/' .
                    $belanjaId
            )
        )->with(
            'success',
            'Bahan berhasil ditambahkan'
        );
    }

    private function totalPengajuan(int $id): float
    {
        $row = $this->detailModel
            ->selectSum('total_harga')
            ->where('belanja_id', $id)
            ->first();

        return (float) ($row['total_harga'] ?? 0);
    }

    /**
     * Snapshot pagu harian berdasarkan data PM terkini dari Aslap.
     *
     * Catatan: tabel penerima_manfaat pada versi ini belum memiliki
     * status aktif/nonaktif, sehingga seluruh data PM milik SPPG
     * diperlakukan sebagai PM yang sedang berjalan.
     */
    private function snapshotPaguHarian(string $tanggal): array
    {
        $db = \Config\Database::connect();

        $pm = $db->table('penerima_manfaat')
            ->select('
                COALESCE(SUM(porsi_kecil), 0) AS porsi_kecil,
                COALESCE(SUM(porsi_besar), 0) AS porsi_besar
            ')
            ->where('id_sppg', session('id_sppg'))
            ->get()
            ->getRowArray();

        $porsiKecil = (int) ($pm['porsi_kecil'] ?? 0);
        $porsiBesar = (int) ($pm['porsi_besar'] ?? 0);

        $tarifKecil = 8000;
        $tarifBesar = 10000;
        $totalPagu = ($porsiKecil * $tarifKecil) + ($porsiBesar * $tarifBesar);

        return [
            'pagu_tanggal' => $tanggal,
            'pagu_porsi_kecil' => $porsiKecil,
            'pagu_porsi_besar' => $porsiBesar,
            'pagu_tarif_kecil' => $tarifKecil,
            'pagu_tarif_besar' => $tarifBesar,
            'pagu_total' => $totalPagu,
            'pagu_snapshot_at' => date('Y-m-d H:i:s'),
        ];
    }

    public function ajukan($id)
    {
        $transaksi = $this->bahanBakuModel
            ->where('id', $id)
            ->where('id_sppg', session('id_sppg'))
            ->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if (!$this->canEdit($transaksi['status'])) {
            return redirect()->back()->with('error', 'Pengajuan sudah masuk proses approval dan tidak dapat diajukan ulang dari tahap ini.');
        }

        $detail = $this->detailModel
            ->where('belanja_id', $id)
            ->countAllResults();

        if ($detail === 0) {
            return redirect()->back()->with('error', 'Minimal harus ada 1 bahan sebelum pengajuan dikirim.');
        }

        // Saat pengajuan dikirim ke Keuangan, snapshot PM dan pagu harian.
        // Snapshot ini tidak lagi bergantung pada perubahan PM di kemudian hari.
        $snapshot = $this->snapshotPaguHarian((string) $transaksi['tanggal']);

        $totalPengajuan = $this->totalPengajuan($id);
        $snapshot['pagu_selisih'] = (int) $snapshot['pagu_total'] - (int) round($totalPengajuan);

        // Setiap pengajuan ulang dianggap sebagai pengajuan yang direvisi.
        // Karena isi/qty bisa berubah, snapshot pagu dibuat ulang pada saat
        // pengajuan ulang dan seluruh tahapan approval dimulai kembali dari Finance.
        $this->bahanBakuModel->update($id, array_merge($snapshot, [
            'status' => 'waiting_finance',
            'catatan_keuangan' => null,
            'catatan_approval' => null,
            'finance_reviewed_by' => null,
            'finance_reviewed_at' => null,
            'kepala_approved_by' => null,
            'kepala_approved_at' => null,
            'koperasi_processed_by' => null,
            'koperasi_processed_at' => null,
            'koperasi_note' => null,
        ]));

        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'), 'id_sppg' => session('id_sppg'),
            'user_level' => 'gizi', 'username' => (string) session('email'),
            'activity' => in_array($transaksi['status'], ['rejected_finance', 'rejected_kepala'], true)
                ? 'Merevisi dan mengajukan ulang pembelian bahan ke Keuangan'
                : 'Mengirim pengajuan pembelian bahan ke Keuangan', 'module' => 'Pengadaan Bahan',
            'method' => 'POST', 'uri' => '/gizi/bahan-baku/ajukan/' . $id,
            'ip_address' => $this->request->getIPAddress(), 'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Pengajuan pembelian berhasil dikirim ke Keuangan untuk diperiksa.');
    }

    /**
     * Menghapus transaksi pembelian bahan baku.
     *
     * Aturan v42:
     * - Hanya transaksi milik SPPG yang sedang login yang dapat dihapus.
     * - Hanya status `draft` yang boleh dihapus.
     * - Detail transaksi ikut dihapus agar tidak meninggalkan data yatim.
     * - Foto struk draft yang terhapus ikut dibersihkan dari storage.
     * - Proses database menggunakan transaction agar penghapusan konsisten.
     */
    public function delete($id)
    {
        $id = (int) $id;

        $transaksi = $this->bahanBakuModel
            ->where('id', $id)
            ->where('id_sppg', session('id_sppg'))
            ->first();

        if (!$transaksi) {
            return redirect()
                ->to(base_url('gizi/bahan-baku'))
                ->with('error', 'Transaksi tidak ditemukan atau bukan milik SPPG Anda.');
        }

        // HARD RULE: transaksi yang sudah masuk workflow tidak boleh dihapus.
        if ((string) ($transaksi['status'] ?? '') !== 'draft') {
            return redirect()
                ->to(base_url('gizi/bahan-baku'))
                ->with('error', 'Transaksi hanya dapat dihapus jika masih berstatus Draft.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus seluruh detail terlebih dahulu.
        $this->detailModel
            ->where('belanja_id', $id)
            ->delete();

        // Hapus transaksi induk.
        $this->bahanBakuModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()
                ->to(base_url('gizi/bahan-baku'))
                ->with('error', 'Transaksi gagal dihapus. Silakan coba lagi.');
        }

        // Bersihkan foto struk setelah transaksi database berhasil dihapus.
        if (!empty($transaksi['foto_struk'])) {
            $fotoPath = FCPATH . 'uploads/struk/' . basename((string) $transaksi['foto_struk']);

            if (is_file($fotoPath)) {
                @unlink($fotoPath);
            }
        }

        // Catat aktivitas penghapusan untuk audit trail.
        (new UserActivityLogModel())->record([
            'user_id' => (int) session('user_id'),
            'id_sppg' => session('id_sppg'),
            'user_level' => 'gizi',
            'username' => (string) session('email'),
            'activity' => 'Menghapus transaksi pembelian bahan baku Draft',
            'module' => 'Pengadaan Bahan',
            'method' => 'POST',
            'uri' => '/gizi/bahan-baku/delete/' . $id,
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => substr((string) $this->request->getUserAgent()->getAgentString(), 0, 500),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to(base_url('gizi/bahan-baku'))
            ->with('success', 'Transaksi Draft berhasil dihapus.');
    }

    public function deleteDetail($id)
    {
        $detail = $this->detailModel->find($id);

        if (!$detail) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan'
                );
        }

        $transaksi = $this->bahanBakuModel
            ->find($detail['belanja_id']);

        if (
            !$transaksi ||
            !$this->canEdit($transaksi['status'])
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Transaksi sudah diajukan dan tidak dapat diubah.'
                );
        }

        $this->detailModel->delete($id);

        return redirect()
            ->back()
            ->with(
                'success',
                'Bahan berhasil dihapus'
            );
    }

    public function updateDetail($id)
    {
        $detail = $this->detailModel->find($id);

        if (!$detail) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data tidak ditemukan'
                );
        }

        $transaksi = $this->bahanBakuModel
            ->find($detail['belanja_id']);

        if (
            !$transaksi ||
            !$this->canEdit($transaksi['status'])
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Transaksi sudah diajukan dan tidak dapat diubah.'
                );
        }

        $qty = (float) $this->request->getPost('qty');

        if ($qty <= 0) {
            return redirect()
                ->back()
                ->with('error', 'Qty harus lebih besar dari 0.');
        }

        $updated = $this->detailModel->update($id, [

            'qty' => $qty,

            'total_harga' => $qty * $detail['harga'],

            'updated_by' => session('user_id')

        ]);

        if (!$updated) {
            return redirect()
                ->back()
                ->with('error', 'Qty gagal diperbarui.');
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Qty berhasil diperbarui'
            );
    }
}
