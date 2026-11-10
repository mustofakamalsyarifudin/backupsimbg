<?php
namespace App\Controllers\Koperasi;

use App\Models\BahanBakuDetailModel;
use App\Models\BahanBakuModel;
use App\Models\KoperasiPembelianDetailModel;
use App\Models\KoperasiPembelianModel;
use App\Models\SupplierKoperasiModel;
use App\Models\SupplierBahanModel;
use App\Models\SupplierBahanHargaModel;
use App\Models\SppgModel;
use App\Models\UserActivityLogModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Pembelian extends BaseKoperasi
{
    private KoperasiPembelianModel $model;
    private KoperasiPembelianDetailModel $detail;
    private BahanBakuModel $pengadaan;
    private BahanBakuDetailModel $pengadaanDetail;

    public function __construct()
    {
        parent::__construct();
        $this->model = new KoperasiPembelianModel();
        $this->detail = new KoperasiPembelianDetailModel();
        $this->pengadaan = new BahanBakuModel();
        $this->pengadaanDetail = new BahanBakuDetailModel();
    }

    private function total(int $id): float
    {
        $r = $this->detail->selectSum('total_harga')->where('pembelian_id', $id)->first();
        return (float) ($r['total_harga'] ?? 0);
    }

    private function generateNo(): string
    {
        $prefix = 'PB-' . date('Ymd') . '-';
        $last = $this->model->like('no_pembelian', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr((string) $last['no_pembelian'], -5)) + 1 : 1;
        return $prefix . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }

    private function assignedIds(): array
    {
        return array_map(static fn(array $x): string => (string) $x['id_sppg'], $this->assignedSppgs());
    }

    public function index()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $ids = $this->assignedIds();
        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));
        $from = trim((string) $this->request->getGet('from'));
        $to = trim((string) $this->request->getGet('to'));
        $rows = [];
        if ($ids) {
            $b = $this->model->whereIn('id_sppg', $ids);
            if ($q !== '') $b->groupStart()->like('no_pembelian', $q)->orLike('supplier', $q)->orLike('no_invoice_supplier', $q)->groupEnd();
            if (in_array($status, ['draft','dibeli','dikirim'], true)) $b->where('status', $status);
            if ($from !== '') $b->where('tanggal_pembelian >=', $from);
            if ($to !== '') $b->where('tanggal_pembelian <=', $to);
            $rows = $b->orderBy('tanggal_pembelian', 'DESC')->orderBy('id', 'DESC')->findAll();
            foreach ($rows as &$row) $row['grand_total'] = $this->total((int) $row['id']);
        }
        $names = [];
        foreach ($this->assignedSppgs() as $x) $names[(string)$x['id_sppg']] = $x['sppg_name'];
        return view('koperasi/pembelian/index', compact('rows','names','q','status','from','to'));
    }

    public function create(int $belanjaId)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->pengadaan->find($belanjaId);
        if (!$row || !$this->hasAssignedSppg((string)$row['id_sppg'])) return redirect()->to(base_url('koperasi/pengadaan'))->with('error','Pengajuan tidak ditemukan.');
        if ($row['status'] !== 'waiting_koperasi') return redirect()->back()->with('error','Pengajuan belum siap dibuatkan pembelian.');
        $existing = $this->model->where('belanja_id', $belanjaId)->first();
        if ($existing) return redirect()->to(base_url('koperasi/pembelian/detail/'.$existing['id']));
        return redirect()->to(base_url('koperasi/pengadaan/detail/'.$belanjaId))->with('error','Gunakan tombol Terima & Buat Pembelian dari halaman pengadaan.');
    }

    public function detail(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->model->find($id);
        if (!$row || !$this->hasAssignedSppg((string)$row['id_sppg'])) {
            return redirect()->to(base_url('koperasi/pembelian'))->with('error','Pembelian tidak ditemukan.');
        }

        $details = $this->detail->where('pembelian_id',$id)->orderBy('id','ASC')->findAll();
        $supplierModel = new SupplierKoperasiModel();
        $supplierBahanModel = new SupplierBahanModel();

        // Supplier sekarang dipilih per bahan, bukan di header pembelian.
        $suppliers = $supplierModel
            ->where('koperasi_id',$this->koperasiId())
            ->where('status','aktif')
            ->orderBy('nama_supplier')
            ->findAll();

        // Ambil seluruh relasi supplier-bahan aktif milik koperasi,
        // lalu kelompokkan berdasarkan bahan agar dropdown setiap baris
        // hanya menampilkan supplier yang memang menyediakan bahan tersebut.
        $supplierBahanRows = $supplierBahanModel
            ->select('supplier_bahan.*, supplier_koperasi.kode_supplier, supplier_koperasi.nama_supplier, supplier_koperasi.status AS supplier_status, supplier_koperasi.tanggal_mou_mulai, supplier_koperasi.tanggal_mou_akhir')
            ->join('supplier_koperasi', 'supplier_koperasi.id = supplier_bahan.supplier_id', 'inner')
            ->where('supplier_koperasi.koperasi_id', $this->koperasiId())
            ->where('supplier_bahan.status','aktif')
            ->where('supplier_koperasi.status','aktif')
            ->orderBy('supplier_koperasi.nama_supplier','ASC')
            ->findAll();

        $today = date('Y-m-d');
        $supplierBahanByBahan = [];
        foreach ($supplierBahanRows as $sb) {
            // Supplier dengan MOU yang sudah berakhir tidak ditawarkan untuk transaksi baru.
            if (!empty($sb['tanggal_mou_akhir']) && $sb['tanggal_mou_akhir'] < $today) {
                continue;
            }
            $supplierBahanByBahan[(int)$sb['bahan_id']][] = $sb;
        }

        foreach ($details as &$d) {
            $bahanId = (int)($d['bahan_id'] ?? 0);
            $d['supplier_options'] = $supplierBahanByBahan[$bahanId] ?? [];
            $selectedSb = null;
            if (!empty($d['supplier_bahan_id'])) {
                foreach ($d['supplier_options'] as $sb) {
                    if ((int)$sb['id'] === (int)$d['supplier_bahan_id']) {
                        $selectedSb = $sb;
                        break;
                    }
                }
            }
            $d['harga_beli_default'] = $selectedSb
                ? (float)$selectedSb['harga_beli']
                : (float)($d['harga_beli_snapshot'] ?? 0);
            $d['selected_supplier_id'] = $selectedSb ? (int)$selectedSb['supplier_id'] : null;
        }
        unset($d);

        // Nilai permintaan/pagu berasal dari snapshot detail pembelian saat pengadaan
        // dibuat. Data ini menjadi batas transaksi dan tidak boleh diedit dari halaman ini.
        $nilaiPermintaan = 0.0;
        foreach ($details as $d) {
            $qtyDiminta = max(0, (float)($d['qty_diminta'] ?? 0));
            $hargaSppg = (float)($d['harga_jual_snapshot'] ?? 0);
            if ($hargaSppg <= 0) {
                $hargaSppg = (float)($d['harga_satuan'] ?? 0);
            }
            $nilaiPermintaan += $qtyDiminta * $hargaSppg;
        }

        $sppg = (new SppgModel())->find($row['id_sppg']);
        $totalJual = $this->total($id);
        $totalBeli = (float)($row['total_harga_beli'] ?? 0);
        $margin = (float)($row['total_margin'] ?? ($totalJual - $totalBeli));
        $marginPct = $totalBeli > 0 ? ($margin / $totalBeli) * 100 : 0;

        return view('koperasi/pembelian/detail', [
            'row'=>$row,
            'details'=>$details,
            'grand_total'=>$totalJual,
            'total_beli'=>$totalBeli,
            'total_margin'=>$margin,
            'margin_persen'=>$marginPct,
            'nilai_permintaan'=>$nilaiPermintaan,
            'suppliers'=>$suppliers,
            'supplierBahanByBahan'=>$supplierBahanByBahan,
            'sppg_name'=>$sppg['sppg_name'] ?? $row['id_sppg']
        ]);
    }

    public function update(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;

        $row = $this->model->find($id);
        if (!$row || !$this->hasAssignedSppg((string) ($row['id_sppg'] ?? ''))) {
            return redirect()->back()->with('error', 'Pembelian tidak ditemukan.');
        }

        if (($row['status'] ?? '') === 'dikirim') {
            return redirect()->back()->with('error', 'Pembelian yang sudah dikirim tidak dapat diubah.');
        }

        $tanggal = trim((string) $this->request->getPost('tanggal_pembelian'));
        $catatan = trim((string) $this->request->getPost('catatan'));
        $items = $this->request->getPost('item');
        $supplierModel = new SupplierKoperasiModel();
        $supplierBahanModel = new SupplierBahanModel();
        $supplierBahanHargaModel = new SupplierBahanHargaModel();

        if ($tanggal === '') {
            return redirect()->back()->withInput()->with('error', 'Tanggal pembelian wajib diisi.');
        }
        if (!is_array($items) || !$items) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada detail barang yang dikirim. Pastikan data barang masih tampil lalu coba Simpan Pembelian kembali.');
        }

        $db = $this->model->db;
        $db->transBegin();

        try {
            $ok = $this->model->update($id, [
                'tanggal_pembelian' => $tanggal,
                // Supplier dan invoice sekarang disimpan pada detail masing-masing bahan.
                // Kolom supplier header lama sengaja tidak diubah agar backward-compatible.
                'catatan' => $catatan !== '' ? $catatan : null,
                'updated_by' => session('user_id'),
            ]);

            if ($ok === false) {
                throw new \RuntimeException('Gagal memperbarui data pembelian: ' . json_encode($this->model->errors(), JSON_UNESCAPED_UNICODE));
            }

            foreach ($items as $detailId => $item) {
                $detailId = (int) $detailId;
                $d = $this->detail->where('id', $detailId)->where('pembelian_id', $id)->first();
                if (!$d) {
                    throw new \RuntimeException('Detail barang tidak ditemukan untuk pembelian ini.');
                }

                $qtyRaw = $item['qty_dibeli'] ?? null;
                $hargaBeliRaw = $item['harga_beli_snapshot'] ?? null;
                if ($qtyRaw === null || $qtyRaw === '' || $hargaBeliRaw === null || $hargaBeliRaw === '') {
                    throw new \RuntimeException('Qty dibeli dan harga beli supplier wajib diisi untuk ' . ($d['nama_bahan'] ?? 'barang') . '.');
                }

                $qty = (float) $qtyRaw;
                $hargaBeli = (float)$hargaBeliRaw;
                $hargaJual = (float)($d['harga_jual_snapshot'] ?? 0);
                if ($hargaJual <= 0) {
                    $hargaJual = (float)($d['harga_satuan'] ?? 0);
                }
                if ($qty < 0 || $hargaBeli < 0 || $hargaJual < 0) {
                    throw new \RuntimeException('Qty dan harga tidak boleh bernilai negatif untuk ' . ($d['nama_bahan'] ?? 'barang') . '.');
                }
                $qtyDiminta = max(0, (float)($d['qty_diminta'] ?? 0));
                if ($qty > $qtyDiminta) {
                    throw new \RuntimeException('Qty dibeli untuk ' . ($d['nama_bahan'] ?? 'barang') . ' tidak boleh melebihi qty permintaan (' . rtrim(rtrim(number_format($qtyDiminta, 2, '.', ''), '0'), '.') . ').');
                }
                if ($hargaJual <= 0 && $qty > 0) {
                    throw new \RuntimeException('Harga SPPG untuk ' . ($d['nama_bahan'] ?? 'barang') . ' belum tersedia pada permintaan.');
                }

                $supplierId = (int)($item['supplier_id'] ?? 0);
                $invoiceSupplier = trim((string)($item['no_invoice_supplier'] ?? ''));
                $supplierRow = $supplierId > 0
                    ? $supplierModel->where('id',$supplierId)->where('koperasi_id',$this->koperasiId())->where('status','aktif')->first()
                    : null;
                if (!$supplierRow) {
                    throw new \RuntimeException('Supplier wajib dipilih untuk ' . ($d['nama_bahan'] ?? 'barang') . '.');
                }
                $today = date('Y-m-d');
                if (!empty($supplierRow['tanggal_mou_akhir']) && $supplierRow['tanggal_mou_akhir'] < $today) {
                    throw new \RuntimeException('MOU supplier ' . $supplierRow['nama_supplier'] . ' sudah kedaluwarsa.');
                }
                $sb = $supplierBahanModel
                    ->select('supplier_bahan.*')
                    ->join('supplier_koperasi', 'supplier_koperasi.id = supplier_bahan.supplier_id', 'inner')
                    ->where('supplier_bahan.supplier_id',$supplierId)
                    ->where('supplier_bahan.bahan_id',(int)$d['bahan_id'])
                    ->where('supplier_bahan.status','aktif')
                    ->where('supplier_koperasi.koperasi_id',$this->koperasiId())
                    ->where('supplier_koperasi.status','aktif')
                    ->first();
                if (!$sb) {
                    throw new \RuntimeException('Supplier ' . $supplierRow['nama_supplier'] . ' belum dihubungkan ke bahan ' . ($d['nama_bahan'] ?? 'barang') . ' pada Master Supplier.');
                }
                $marginUnit = $hargaJual - $hargaBeli;
                $marginPct = $hargaBeli > 0 ? ($marginUnit / $hargaBeli) * 100 : 0;

                $okDetail = $this->detail->update($detailId, [
                    'supplier_bahan_id' => $sb['id'] ?? null,
                    'no_invoice_supplier' => $invoiceSupplier !== '' ? $invoiceSupplier : null,
                    'qty_dibeli' => $qty,
                    'harga_satuan' => $hargaJual,
                    'harga_beli_snapshot' => $hargaBeli,
                    'harga_jual_snapshot' => $hargaJual,
                    'margin_snapshot' => $marginUnit,
                    'margin_persen_snapshot' => $marginPct,
                    'total_harga' => $qty * $hargaJual,
                    'keterangan' => trim((string) ($item['keterangan'] ?? '')) ?: null,
                ]);

                if ($okDetail === false) {
                    throw new \RuntimeException('Gagal menyimpan detail ' . ($d['nama_bahan'] ?? 'barang') . '.');
                }

                // Jika Koperasi mengoreksi harga dan mencentang opsi, jadikan harga baru
                // sebagai harga supplier terbaru serta simpan histori perubahan.
                if (!empty($item['update_supplier_price'])) {
                    $hargaLama = (float)($sb['harga_beli'] ?? 0);
                    if (abs($hargaLama - $hargaBeli) > 0.00001) {
                        $supplierBahanModel->update((int)$sb['id'], [
                            'harga_beli' => $hargaBeli,
                            'updated_by' => session('user_id'),
                        ]);
                        $supplierBahanHargaModel->insert([
                            'supplier_bahan_id' => (int)$sb['id'],
                            'harga_lama' => $hargaLama,
                            'harga_baru' => $hargaBeli,
                            'berlaku_mulai' => $tanggal,
                            'diubah_oleh' => session('user_id'),
                            'keterangan' => 'Perubahan harga saat transaksi pembelian ' . ($row['no_pembelian'] ?? ''),
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }

            $grandTotal = $this->total($id);
            $detailRows = $this->detail->where('pembelian_id',$id)->findAll();
            $totalBeli = 0.0;
            $totalMargin = 0.0;
            foreach ($detailRows as $dr) {
                $q = (float)$dr['qty_dibeli'];
                $totalBeli += $q * (float)($dr['harga_beli_snapshot'] ?? 0);
                $totalMargin += $q * (float)($dr['margin_snapshot'] ?? ((float)$dr['harga_satuan'] - (float)($dr['harga_beli_snapshot'] ?? 0)));
            }
            $marginPct = $totalBeli > 0 ? ($totalMargin / $totalBeli) * 100 : 0;
            if ($this->model->update($id, ['total' => $grandTotal, 'total_harga_beli'=>$totalBeli, 'total_margin'=>$totalMargin, 'margin_persen'=>$marginPct, 'updated_by' => session('user_id')]) === false) {
                throw new \RuntimeException('Total pembelian gagal disimpan.');
            }

            if (!$db->transStatus()) {
                throw new \RuntimeException('Transaksi database gagal.');
            }

            $db->transCommit();
            return redirect()->to(base_url('koperasi/pembelian/detail/' . $id))
                ->with('success', 'Data pembelian berhasil disimpan. Total pembelian Rp ' . number_format($grandTotal, 0, ',', '.') . '.');
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Koperasi Pembelian update gagal ID {id}: {message}', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);
            return redirect()->back()->withInput()
                ->with('error', 'Data pembelian gagal disimpan. ' . $e->getMessage());
        }
    }

    public function markPurchased(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->model->find($id);
        if (!$row || !$this->hasAssignedSppg((string)$row['id_sppg'])) return redirect()->back()->with('error','Pembelian tidak ditemukan.');
        if ($row['status'] !== 'draft') return redirect()->back()->with('error','Pembelian sudah diproses.');
        $total = $this->total($id);
        if ($total <= 0) return redirect()->back()->with('error','Total harga jual pembelian harus lebih dari Rp0.');
        $details = $this->detail->where('pembelian_id',$id)->findAll();
        $totalBeli = 0; $totalMargin = 0;
        $supplierBahanModel = new SupplierBahanModel();
        $supplierModel = new SupplierKoperasiModel();
        $today = date('Y-m-d');
        $nilaiPermintaan = 0.0;
        foreach($details as $d){
            $qtyDiminta = max(0, (float)($d['qty_diminta'] ?? 0));
            $hargaSppg = (float)($d['harga_jual_snapshot'] ?? 0);
            if ($hargaSppg <= 0) $hargaSppg = (float)($d['harga_satuan'] ?? 0);
            $nilaiPermintaan += $qtyDiminta * $hargaSppg;

            if ((float)$d['qty_dibeli'] > $qtyDiminta) return redirect()->back()->with('error','Qty dibeli untuk '.$d['nama_bahan'].' melebihi qty permintaan.');
            if (empty($d['supplier_bahan_id'])) return redirect()->back()->with('error','Supplier untuk bahan '.$d['nama_bahan'].' belum dipilih/terhubung pada Master Supplier.');
            if ((float)($d['harga_beli_snapshot'] ?? 0) <= 0) return redirect()->back()->with('error','Harga beli supplier untuk '.$d['nama_bahan'].' belum diisi.');
            if ($hargaSppg <= 0 && (float)$d['qty_dibeli'] > 0) return redirect()->back()->with('error','Harga SPPG untuk '.$d['nama_bahan'].' belum tersedia pada permintaan.');
            $sb = $supplierBahanModel->where('id',(int)$d['supplier_bahan_id'])->where('status','aktif')->first();
            if (!$sb) return redirect()->back()->with('error','Relasi supplier-bahan untuk '.$d['nama_bahan'].' tidak aktif atau sudah dihapus.');
            $supplierRow = $supplierModel->where('id',(int)$sb['supplier_id'])->where('koperasi_id',$this->koperasiId())->where('status','aktif')->first();
            if (!$supplierRow) return redirect()->back()->with('error','Supplier untuk bahan '.$d['nama_bahan'].' tidak aktif.');
            if (!empty($supplierRow['tanggal_mou_akhir']) && $supplierRow['tanggal_mou_akhir'] < $today) {
                return redirect()->back()->with('error','MOU supplier '.$supplierRow['nama_supplier'].' untuk bahan '.$d['nama_bahan'].' sudah kedaluwarsa.');
            }
            $totalBeli += (float)$d['qty_dibeli'] * (float)($d['harga_beli_snapshot'] ?? 0);
            $totalMargin += (float)$d['qty_dibeli'] * (float)($d['margin_snapshot'] ?? 0);
        }
        if($totalBeli <= 0) return redirect()->back()->with('error','Harga beli supplier belum lengkap. Lengkapi harga beli setiap bahan.');
        if($total > $nilaiPermintaan + 0.00001) return redirect()->back()->with('error','Nilai jual ke SPPG melebihi pagu/nilai permintaan yang sudah disepakati.');
        $marginPct = ($totalMargin / $totalBeli) * 100;
        $this->model->update($id,['status'=>'dibeli','total'=>$total,'total_harga_beli'=>$totalBeli,'total_margin'=>$totalMargin,'margin_persen'=>$marginPct,'dibeli_at'=>date('Y-m-d H:i:s'),'dibeli_by'=>session('user_id'),'updated_by'=>session('user_id')]);
        $this->log($row,'Pembelian bahan selesai dilakukan');
        return redirect()->to(base_url('koperasi/pembelian/detail/'.$id))->with('success','Pembelian ditandai sudah dibeli.');
    }

    public function send(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->model->find($id);
        if (!$row || !$this->hasAssignedSppg((string)$row['id_sppg'])) return redirect()->back()->with('error','Pembelian tidak ditemukan.');
        if ($row['status'] !== 'dibeli') return redirect()->back()->with('error','Pembelian harus berstatus Dibeli sebelum dikirim ke SPPG.');
        $this->model->update($id,['status'=>'dikirim','dikirim_at'=>date('Y-m-d H:i:s'),'dikirim_by'=>session('user_id'),'updated_by'=>session('user_id')]);
        $this->pengadaan->update((int)$row['belanja_id'],[
            'status'=>'completed','koperasi_processed_by'=>session('user_id'),'koperasi_processed_at'=>date('Y-m-d H:i:s'),
            'koperasi_note'=>$row['catatan'] ?? null
        ]);
        $this->log($row,'Pembelian bahan dikirim ke SPPG');
        return redirect()->to(base_url('koperasi/pembelian/detail/'.$id))->with('success','Pembelian ditandai dikirim ke SPPG dan pengadaan diselesaikan.');
    }

    public function pdf(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->model->find($id);
        if (!$row || !$this->hasAssignedSppg((string)$row['id_sppg'])) return redirect()->to(base_url('koperasi/pembelian'))->with('error','Pembelian tidak ditemukan.');
        $details=$this->detail->where('pembelian_id',$id)->orderBy('id')->findAll();
        $supplierModel = new SupplierKoperasiModel();
        $supplierIds = array_values(array_unique(array_filter(array_map(static fn($d) => (int)($d['supplier_bahan_id'] ?? 0), $details))));
        $supplierNames = [];
        if ($supplierIds) {
            $sbRows = (new SupplierBahanModel())->whereIn('id',$supplierIds)->findAll();
            $sid = array_values(array_unique(array_filter(array_map(static fn($x) => (int)$x['supplier_id'], $sbRows))));
            if ($sid) {
                foreach ($supplierModel->whereIn('id',$sid)->where('koperasi_id',$this->koperasiId())->findAll() as $sr) {
                    $supplierNames[(int)$sr['id']] = $sr['nama_supplier'];
                }
            }
            $mapSb=[]; foreach($sbRows as $sb){ $mapSb[(int)$sb['id']] = (int)$sb['supplier_id']; }
            foreach($details as &$d){ $d['nama_supplier'] = !empty($d['supplier_bahan_id']) && isset($mapSb[(int)$d['supplier_bahan_id']]) ? ($supplierNames[$mapSb[(int)$d['supplier_bahan_id']] ] ?? '-') : '-'; } unset($d);
        }
        $nilaiPermintaan=0.0; foreach($details as $d){ $q=(float)($d['qty_diminta']??0); $hs=(float)($d['harga_jual_snapshot']??0); if($hs<=0)$hs=(float)($d['harga_satuan']??0); $nilaiPermintaan += $q*$hs; }
        $sppg=(new SppgModel())->find($row['id_sppg']);
        $koperasi=$this->koperasiModel->find($this->koperasiId());
        $html=view('koperasi/pembelian/pdf',[ 'row'=>$row,'details'=>$details,'grand_total'=>$this->total($id),'nilai_permintaan'=>$nilaiPermintaan,'sppg'=>$sppg,'koperasi'=>$koperasi ]);
        $opt=new Options(); $opt->set('isRemoteEnabled',true); $dompdf=new Dompdf($opt); $dompdf->loadHtml($html); $dompdf->setPaper('A4','portrait'); $dompdf->render(); $dompdf->stream('invoice-pembelian-'.$row['no_pembelian'].'.pdf',['Attachment'=>true]); exit;
    }

    public function laporan()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $ids=$this->assignedIds(); $from=trim((string)$this->request->getGet('from')); $to=trim((string)$this->request->getGet('to')); $status=trim((string)$this->request->getGet('status')); $sppgId=trim((string)$this->request->getGet('id_sppg'));
        $b=$this->model->whereIn('id_sppg',$ids ?: ['__none__']);
        if($from!=='')$b->where('tanggal_pembelian >=',$from); if($to!=='')$b->where('tanggal_pembelian <=',$to); if(in_array($status,['draft','dibeli','dikirim'],true))$b->where('status',$status); if($sppgId!=='' && in_array($sppgId,$ids,true))$b->where('id_sppg',$sppgId);
        $rows=$b->orderBy('tanggal_pembelian','DESC')->orderBy('id','DESC')->findAll(); foreach($rows as &$x)$x['grand_total']=$this->total((int)$x['id']);
        $sppgs=$this->assignedSppgs(); $names=[]; foreach($sppgs as $s)$names[(string)$s['id_sppg']]=$s['sppg_name'];
        $grand=array_sum(array_map(static fn($x)=>(float)$x['grand_total'],$rows));
        $grandBuy=array_sum(array_map(static fn($x)=>(float)($x['total_harga_beli']??0),$rows));
        $grandMargin=array_sum(array_map(static fn($x)=>(float)($x['total_margin']??0),$rows));
        return view('koperasi/laporan/index',compact('rows','sppgs','names','from','to','status','sppgId','grand','grandBuy','grandMargin'));
    }

    public function laporanPdf()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $ids=$this->assignedIds(); $from=trim((string)$this->request->getGet('from')); $to=trim((string)$this->request->getGet('to')); $status=trim((string)$this->request->getGet('status')); $sppgId=trim((string)$this->request->getGet('id_sppg'));
        $b=$this->model->whereIn('id_sppg',$ids ?: ['__none__']);
        if($from!=='')$b->where('tanggal_pembelian >=',$from); if($to!=='')$b->where('tanggal_pembelian <=',$to); if(in_array($status,['draft','dibeli','dikirim'],true))$b->where('status',$status); if($sppgId!=='' && in_array($sppgId,$ids,true))$b->where('id_sppg',$sppgId);
        $rows=$b->orderBy('tanggal_pembelian','DESC')->orderBy('id','DESC')->findAll(); foreach($rows as &$x)$x['grand_total']=$this->total((int)$x['id']);
        $names=[]; foreach($this->assignedSppgs() as $s)$names[(string)$s['id_sppg']]=$s['sppg_name']; $grand=array_sum(array_map(static fn($x)=>(float)$x['grand_total'],$rows));
        $grandBuy=array_sum(array_map(static fn($x)=>(float)($x['total_harga_beli']??0),$rows));
        $grandMargin=array_sum(array_map(static fn($x)=>(float)($x['total_margin']??0),$rows));
        $koperasi=$this->koperasiModel->find($this->koperasiId());
        $html=view('koperasi/laporan/pdf',compact('rows','names','from','to','status','sppgId','grand','grandBuy','grandMargin','koperasi'));
        $opt=new Options();$opt->set('isRemoteEnabled',true);$dompdf=new Dompdf($opt);$dompdf->loadHtml($html);$dompdf->setPaper('A4','landscape');$dompdf->render();$dompdf->stream('laporan-pembelian-koperasi-'.date('Ymd-His').'.pdf',['Attachment'=>true]);exit;
    }

    private function log(array $row,string $activity): void
    {
        (new UserActivityLogModel())->record([
            'user_id'=>(int)session('user_id'),'id_sppg'=>$row['id_sppg'],'user_level'=>'koperasi','username'=>(string)session('email'),
            'activity'=>$activity,'module'=>'Pembelian Koperasi','method'=>'POST','uri'=>$this->request->getUri()->getPath(),
            'ip_address'=>$this->request->getIPAddress(),'user_agent'=>substr((string)$this->request->getUserAgent()->getAgentString(),0,500),'created_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
