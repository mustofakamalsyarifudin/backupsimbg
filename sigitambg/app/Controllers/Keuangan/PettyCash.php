<?php
namespace App\Controllers\Keuangan;

class PettyCash extends BaseKeuangan
{
    private function recalculateLedger($db, string $idSppg): bool
    {
        $ledger = $db->table('petty_cash')->where('id_sppg', $idSppg)->orderBy('tanggal', 'ASC')->orderBy('id', 'ASC')->get()->getResultArray();
        $balance = 0.0;
        foreach ($ledger as $entry) {
            $amount = (float) $entry['jumlah'];
            $balance += $entry['jenis'] === 'pemasukan' ? $amount : -$amount;
            if ($balance < -0.00001) return false;
            if (!$db->table('petty_cash')->where('id', (int)$entry['id'])->where('id_sppg', $idSppg)->update(['saldo_akhir' => $balance])) return false;
        }
        return $db->transStatus() !== false;
    }

    private function validateInput(): array
    {
        $tanggal = trim((string)$this->request->getPost('tanggal'));
        $jenis = trim((string)$this->request->getPost('jenis'));
        $kategori = trim((string)$this->request->getPost('kategori'));
        $deskripsi = trim((string)$this->request->getPost('deskripsi'));
        $raw = trim((string)$this->request->getPost('jumlah'));
        $date = \DateTime::createFromFormat('Y-m-d', $tanggal);
        $jumlah = is_numeric($raw) ? (float)$raw : 0;
        if (!$date || $date->format('Y-m-d') !== $tanggal) return [null, 'Tanggal transaksi tidak valid.'];
        if (!in_array($jenis, ['pemasukan','pengeluaran'], true)) return [null, 'Jenis transaksi tidak valid.'];
        if ($kategori === '' || mb_strlen($kategori) > 100) return [null, 'Kategori wajib diisi (maksimal 100 karakter).'];
        if ($jumlah <= 0 || !is_finite($jumlah)) return [null, 'Jumlah transaksi harus lebih besar dari nol.'];
        return [[ 'tanggal'=>$tanggal, 'jenis'=>$jenis, 'kategori'=>$kategori, 'deskripsi'=>$deskripsi !== '' ? $deskripsi : null, 'jumlah'=>$jumlah ], null];
    }

    private function uploadReceipt(?string $oldFile = null): array
    {
        $file = $this->request->getFile('bukti_struk');
        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) return [$oldFile, null, false];
        if (!$file->isValid()) return [$oldFile, 'Upload struk gagal atau file tidak valid.', false];
        if ($file->getSize() > 5 * 1024 * 1024) return [$oldFile, 'Ukuran struk maksimal 5 MB sebelum kompresi.', false];
        $mime = $file->getMimeType();
        if (!in_array($mime, ['image/jpeg','image/png','image/webp'], true)) return [$oldFile, 'Struk harus berupa gambar JPG, PNG, atau WEBP.', false];
        // uploadImage memakai Image Service SIGITA: resize maksimum 1280px dan kompresi JPEG kualitas 60.
        $newFile = uploadImage($file, 'petty_cash');
        if (!$newFile) return [$oldFile, 'Gambar struk gagal diproses/ dikompresi.', false];
        return [$newFile, null, true];
    }

    private function removeReceipt(?string $name): void
    {
        if (!$name || basename($name) !== $name) return;
        $path = FCPATH . 'uploads/petty_cash/' . $name;
        if (is_file($path)) @unlink($path);
    }

    public function index()
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        $db = \Config\Database::connect(); $idSppg = (string)session('id_sppg');
        $from = trim((string)$this->request->getGet('from')); $to = trim((string)$this->request->getGet('to'));
        $builder = $db->table('petty_cash')->where('id_sppg',$idSppg);
        if ($from !== '') $builder->where('tanggal >=',$from); if ($to !== '') $builder->where('tanggal <=',$to);
        $rows = $builder->orderBy('tanggal','DESC')->orderBy('id','DESC')->get()->getResultArray();
        $summaryBuilder = $db->table('petty_cash')->select("SUM(CASE WHEN jenis='pemasukan' THEN jumlah ELSE 0 END) AS total_masuk, SUM(CASE WHEN jenis='pengeluaran' THEN jumlah ELSE 0 END) AS total_keluar",false)->where('id_sppg',$idSppg);
        if ($from !== '') $summaryBuilder->where('tanggal >=',$from); if ($to !== '') $summaryBuilder->where('tanggal <=',$to);
        $summary = $summaryBuilder->get()->getRowArray() ?? [];
        $balanceRow = $db->table('petty_cash')->select('saldo_akhir')->where('id_sppg',$idSppg)->orderBy('tanggal','DESC')->orderBy('id','DESC')->get()->getRowArray();
        $editId = (int)$this->request->getGet('edit');
        $editRow = $editId ? $db->table('petty_cash')->where('id',$editId)->where('id_sppg',$idSppg)->get()->getRowArray() : null;
        return view('keuangan/petty_cash/index', ['rows'=>$rows,'from'=>$from,'to'=>$to,'total_masuk'=>(float)($summary['total_masuk']??0),'total_keluar'=>(float)($summary['total_keluar']??0),'saldo_akhir'=>(float)($balanceRow['saldo_akhir']??0),'sppg_name'=>$this->sppgName(),'edit_row'=>$editRow]);
    }

    public function store()
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        [$data,$error] = $this->validateInput(); if ($error) return redirect()->back()->withInput()->with('error',$error);
        [$receipt,$uploadError] = $this->uploadReceipt(); if ($uploadError) return redirect()->back()->withInput()->with('error',$uploadError);
        $db=\Config\Database::connect(); $idSppg=(string)session('id_sppg'); $db->transBegin();
        $db->table('petty_cash')->insert($data + ['id_sppg'=>$idSppg,'saldo_akhir'=>0,'created_by'=>(int)(session('user_id')??0) ?: null,'bukti_file'=>$receipt]);
        if ($db->transStatus()===false || !$this->recalculateLedger($db,$idSppg)) { $db->transRollback(); if ($receipt) $this->removeReceipt($receipt); return redirect()->back()->withInput()->with('error','Transaksi ditolak: saldo kas akan negatif atau penyimpanan gagal. Periksa saldo awal dan tanggal transaksi.'); }
        $db->transCommit(); return redirect()->to(base_url('keuangan/petty-cash'))->with('success','Transaksi petty cash berhasil dicatat.');
    }

    public function update($id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        $db=\Config\Database::connect(); $idSppg=(string)session('id_sppg');
        $old=$db->table('petty_cash')->where('id',(int)$id)->where('id_sppg',$idSppg)->get()->getRowArray();
        if (!$old) return redirect()->to(base_url('keuangan/petty-cash'))->with('error','Transaksi tidak ditemukan atau bukan milik SPPG ini.');
        [$data,$error]=$this->validateInput(); if ($error) return redirect()->back()->withInput()->with('error',$error);
        [$receipt,$uploadError,$newUploaded]=$this->uploadReceipt($old['bukti_file']??null); if ($uploadError) return redirect()->back()->withInput()->with('error',$uploadError);
        $db->transBegin();
        $db->table('petty_cash')->where('id',(int)$id)->where('id_sppg',$idSppg)->update($data+['bukti_file'=>$receipt]);
        if ($db->transStatus()===false || !$this->recalculateLedger($db,$idSppg)) { $db->transRollback(); if ($newUploaded) $this->removeReceipt($receipt); return redirect()->to(base_url('keuangan/petty-cash?edit='.(int)$id))->with('error','Perubahan ditolak karena membuat saldo kas negatif atau gagal disimpan.'); }
        $db->transCommit(); if ($newUploaded && !empty($old['bukti_file'])) $this->removeReceipt($old['bukti_file']);
        return redirect()->to(base_url('keuangan/petty-cash'))->with('success','Transaksi berhasil diperbarui dan saldo seluruh transaksi dihitung ulang.');
    }

    public function delete($id)
    {
        if ($redirect = $this->ensureKeuangan()) return $redirect;
        $db=\Config\Database::connect(); $idSppg=(string)session('id_sppg');
        $old=$db->table('petty_cash')->where('id',(int)$id)->where('id_sppg',$idSppg)->get()->getRowArray();
        if (!$old) return redirect()->to(base_url('keuangan/petty-cash'))->with('error','Transaksi tidak ditemukan atau bukan milik SPPG ini.');
        $db->transBegin(); $db->table('petty_cash')->where('id',(int)$id)->where('id_sppg',$idSppg)->delete();
        if ($db->transStatus()===false || !$this->recalculateLedger($db,$idSppg)) { $db->transRollback(); return redirect()->to(base_url('keuangan/petty-cash'))->with('error','Transaksi gagal dihapus karena perhitungan saldo tidak valid.'); }
        $db->transCommit(); $this->removeReceipt($old['bukti_file']??null);
        return redirect()->to(base_url('keuangan/petty-cash'))->with('success','Transaksi dihapus dan saldo seluruh transaksi dihitung ulang secara kronologis.');
    }
}
