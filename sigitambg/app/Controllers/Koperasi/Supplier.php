<?php

namespace App\Controllers\Koperasi;

use App\Models\MasterBahanModel;
use App\Models\MasterJenisDokumenSupplierModel;
use App\Models\SupplierBahanHargaModel;
use App\Models\SupplierBahanModel;
use App\Models\SupplierKoperasiBerkasModel;
use App\Models\SupplierKoperasiModel;

class Supplier extends BaseKoperasi
{
    private SupplierKoperasiModel $supplier;
    private MasterJenisDokumenSupplierModel $jenis;
    private SupplierKoperasiBerkasModel $berkas;
    private SupplierBahanModel $supplierBahan;
    private SupplierBahanHargaModel $harga;
    private MasterBahanModel $bahan;

    public function __construct()
    {
        parent::__construct();
        $this->supplier = new SupplierKoperasiModel();
        $this->jenis = new MasterJenisDokumenSupplierModel();
        $this->berkas = new SupplierKoperasiBerkasModel();
        $this->supplierBahan = new SupplierBahanModel();
        $this->harga = new SupplierBahanHargaModel();
        $this->bahan = new MasterBahanModel();
    }

    private function supplierForKoperasi(int $id): ?array
    {
        return $this->supplier->where('id', $id)->where('koperasi_id', $this->koperasiId())->first();
    }

    /** Generate the next supplier code for the currently logged-in cooperative. */
    private function generateSupplierCode(): string
    {
        $koperasi = $this->koperasiModel->find($this->koperasiId());
        $kodeKoperasi = strtoupper(trim((string) ($koperasi['kode_koperasi'] ?? 'KOP')));
        $kodeKoperasi = preg_replace('/[^A-Z0-9-]/', '', $kodeKoperasi) ?: 'KOP';
        $prefix = $kodeKoperasi . '-SUP-';
        $maxNumber = 0;

        $existing = $this->supplier->select('kode_supplier')
            ->where('koperasi_id', $this->koperasiId())
            ->findAll();

        foreach ($existing as $supplierRow) {
            $existingCode = trim((string) ($supplierRow['kode_supplier'] ?? ''));
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/i', $existingCode, $matches)) {
                $maxNumber = max($maxNumber, (int) $matches[1]);
            }
        }

        return sprintf('%s%04d', $prefix, $maxNumber + 1);
    }

    /** Data lookup required by the create/edit supplier form. */
    private function supplierFormOptions(): array
    {
        $assigned = $this->assignedSppgs();
        $types = $this->jenis->where('status', 'aktif')->orderBy('nama_jenis', 'ASC')->findAll();
        $bahanOptions = [];

        foreach ($assigned as $sppg) {
            $sppgId = trim((string) ($sppg['id_sppg'] ?? ''));
            if ($sppgId === '') {
                continue;
            }

            $bahanOptions[$sppgId] = $this->bahan
                ->where('id_sppg', $sppgId)
                ->where('status', 'aktif')
                ->orderBy('nama_bahan', 'ASC')
                ->findAll();
        }

        return compact('assigned', 'types', 'bahanOptions');
    }

    /** Validate selected SPPG/material pairs sent by the supplier form. */
    private function collectSubmittedSupplierBahanRows(?string &$error = null): array
    {
        $error = null;
        $refs = $this->request->getPost('supplier_bahan_ref');
        $prices = $this->request->getPost('supplier_bahan_price');

        if ($refs === null || $refs === '' || $refs === []) {
            return [];
        }
        if (!is_array($refs)) {
            $error = 'Daftar bahan supplier tidak valid. Silakan muat ulang form.';
            return [];
        }
        if (!is_array($prices)) {
            $prices = [];
        }

        $rows = [];
        $seen = [];
        foreach ($refs as $index => $ref) {
            $ref = trim((string) $ref);
            if ($ref === '') {
                continue;
            }

            $parts = explode('|', $ref, 2);
            if (count($parts) !== 2) {
                $error = 'Pilihan SPPG dan bahan tidak valid.';
                return [];
            }
            $sppgId = trim($parts[0]);
            $bahanId = (int) $parts[1];
            if ($bahanId <= 0 || !$this->hasAssignedSppg($sppgId)) {
                $error = 'SPPG yang dipilih tidak terhubung dengan koperasi ini.';
                return [];
            }

            $bahan = $this->bahan
                ->where('id', $bahanId)
                ->where('id_sppg', $sppgId)
                ->where('status', 'aktif')
                ->first();
            if (!$bahan) {
                $error = 'Bahan yang dipilih tidak aktif atau bukan milik SPPG tersebut.';
                return [];
            }

            if (isset($seen[$bahanId])) {
                $error = 'Bahan yang sama dipilih lebih dari sekali. Hapus pilihan yang duplikat.';
                return [];
            }
            $seen[$bahanId] = true;

            $priceValue = $prices[$index] ?? null;
            if ($priceValue === null || $priceValue === '' || !is_numeric($priceValue) || (float) $priceValue < 0) {
                $error = 'Harga beli supplier wajib berupa angka nol atau lebih.';
                return [];
            }

            $rows[] = [
                'bahan_id' => $bahanId,
                'harga_beli' => (float) $priceValue,
            ];
        }

        return $rows;
    }

    /** Add new material links; existing links are left untouched to preserve price history. */
    private function appendSupplierBahanRows(int $supplierId, array $rows): bool
    {
        foreach ($rows as $row) {
            $existing = $this->supplierBahan
                ->where('supplier_id', $supplierId)
                ->where('bahan_id', (int) $row['bahan_id'])
                ->first();
            if ($existing) {
                continue;
            }

            $inserted = $this->supplierBahan->insert([
                'supplier_id' => $supplierId,
                'bahan_id' => (int) $row['bahan_id'],
                'harga_beli' => (float) $row['harga_beli'],
                'status' => 'aktif',
                'created_by' => session('user_id'),
                'updated_by' => session('user_id'),
            ]);
            if (!$inserted) {
                return false;
            }
        }

        return true;
    }

    private function mouState(?string $end): array
    {
        if (!$end) return ['key' => 'none', 'label' => 'Belum diatur', 'class' => 'secondary', 'days' => null];
        $today = new \DateTimeImmutable('today');
        $date = new \DateTimeImmutable($end);
        $days = (int)$today->diff($date)->format('%r%a');
        if ($days < 0) return ['key' => 'expired', 'label' => 'MOU Kedaluwarsa', 'class' => 'danger', 'days' => $days];
        if ($days <= 7) return ['key' => 'urgent', 'label' => 'MOU Mendesak Diperpanjang', 'class' => 'warning', 'days' => $days];
        if ($days <= 30) return ['key' => 'warning', 'label' => 'Segera Perpanjang MOU', 'class' => 'warning', 'days' => $days];
        return ['key' => 'active', 'label' => 'MOU Masih Berlaku', 'class' => 'success', 'days' => $days];
    }

    public function index()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $q = trim((string)$this->request->getGet('q'));
        $status = trim((string)$this->request->getGet('status'));
        $rows = $this->supplier->where('koperasi_id', $this->koperasiId());
        if ($q !== '') {
            $rows->groupStart()->like('kode_supplier', $q)->orLike('nama_supplier', $q)->orLike('nama_pic', $q)->orLike('no_hp', $q)->groupEnd();
        }
        if (in_array($status, ['aktif','nonaktif'], true)) $rows->where('status', $status);
        $rows = $rows->orderBy('status','DESC')->orderBy('nama_supplier','ASC')->findAll();
        foreach ($rows as &$row) $row['mou_state'] = $this->mouState($row['tanggal_mou_akhir'] ?? null);
        unset($row);

        return view('koperasi/supplier/index', [
            'title'=>'Master Supplier', 'rows'=>$rows, 'q'=>$q, 'status'=>$status,
            'jenis'=>$this->jenis->where('status','aktif')->orderBy('nama_jenis')->findAll(),
        ]);
    }

    public function create()
    {
        if ($r = $this->ensureKoperasi()) return $r;

        $kodeSupplier = trim((string) old('kode_supplier'));
        if ($kodeSupplier === '') {
            $kodeSupplier = $this->generateSupplierCode();
        }

        $formOptions = $this->supplierFormOptions();
        return view('koperasi/supplier/form', array_merge($formOptions, [
            'title' => 'Tambah Supplier',
            'row' => null,
            'kodeSupplier' => $kodeSupplier,
        ]));
    }

    public function store()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $data = $this->validateSupplierInput();
        if ($data instanceof \CodeIgniter\HTTP\RedirectResponse) return $data;

        $bahanError = null;
        $bahanRows = $this->collectSubmittedSupplierBahanRows($bahanError);
        if ($bahanError !== null) return redirect()->back()->withInput()->with('error', $bahanError);

        // Do not rely on a readonly HTML field; generate the code again server-side.
        $data['kode_supplier'] = $this->generateSupplierCode();
        $kode = $data['kode_supplier'];
        if ($this->supplier->where('koperasi_id',$this->koperasiId())->where('kode_supplier',$kode)->first()) {
            return redirect()->back()->withInput()->with('error','Kode Supplier sudah digunakan oleh Koperasi ini.');
        }
        $data['koperasi_id'] = $this->koperasiId();
        $data['created_by'] = session('user_id');
        $data['id_sppg'] = null;

        $db = \Config\Database::connect();
        $db->transBegin();
        $id = $this->supplier->insert($data, true);
        if (!$id || !$this->appendSupplierBahanRows((int) $id, $bahanRows) || $db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error','Supplier atau relasi bahan gagal disimpan. Tidak ada perubahan yang disimpan.');
        }
        $db->transCommit();
        $this->seedDefaultDocumentTypes();
        return redirect()->to(base_url('koperasi/supplier/detail/'.$id))->with('success','Supplier berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->supplierForKoperasi($id);
        if (!$row) return redirect()->to(base_url('koperasi/supplier'))->with('error','Supplier tidak ditemukan.');
        $formOptions = $this->supplierFormOptions();
        return view('koperasi/supplier/form', array_merge($formOptions, ['title'=>'Edit Supplier','row'=>$row]));
    }

    public function update(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->supplierForKoperasi($id);
        if (!$row) return redirect()->to(base_url('koperasi/supplier'))->with('error','Supplier tidak ditemukan.');
        $data = $this->validateSupplierInput();
        if ($data instanceof \CodeIgniter\HTTP\RedirectResponse) return $data;
        $bahanError = null;
        $bahanRows = $this->collectSubmittedSupplierBahanRows($bahanError);
        if ($bahanError !== null) return redirect()->back()->withInput()->with('error', $bahanError);

        $dupe = $this->supplier->where('koperasi_id',$this->koperasiId())->where('kode_supplier',$data['kode_supplier'])->where('id !=',$id)->first();
        if ($dupe) return redirect()->back()->withInput()->with('error','Kode Supplier sudah digunakan oleh supplier lain.');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transBegin();
        $updated = $this->supplier->update($id,$data);
        if ($updated === false || !$this->appendSupplierBahanRows($id, $bahanRows) || $db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error','Perubahan supplier atau relasi bahan gagal disimpan.');
        }
        $db->transCommit();
        return redirect()->to(base_url('koperasi/supplier/detail/'.$id))->with('success','Data supplier berhasil diperbarui.');
    }

    public function detail(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->supplierForKoperasi($id);
        if (!$row) return redirect()->to(base_url('koperasi/supplier'))->with('error','Supplier tidak ditemukan.');
        $types = $this->jenis->orderBy('status','DESC')->orderBy('nama_jenis')->findAll();
        $docs = $this->berkas->select('supplier_koperasi_berkas.*, master_jenis_dokumen_supplier.nama_jenis')
            ->join('master_jenis_dokumen_supplier','master_jenis_dokumen_supplier.id = supplier_koperasi_berkas.jenis_dokumen_id')
            ->where('supplier_id',$id)->orderBy('supplier_koperasi_berkas.created_at','DESC')->findAll();
        $assigned = $this->assignedSppgs();
        $sppgId = trim((string)$this->request->getGet('id_sppg'));
        if ($sppgId === '' || !$this->hasAssignedSppg($sppgId)) $sppgId = (string)($this->activeSppgId() ?? '');
        $linked = [];
        $available = [];
        if ($sppgId !== '') {
            $linked = $this->supplierBahan->select('supplier_bahan.*, master_bahan.nama_bahan, master_bahan.satuan_default, master_bahan.harga AS harga_jual_master')
                ->join('master_bahan','master_bahan.id = supplier_bahan.bahan_id')
                ->where('supplier_bahan.supplier_id',$id)->where('master_bahan.id_sppg',$sppgId)
                ->orderBy('master_bahan.nama_bahan')->findAll();

            // Harga SPPG pada Detail Supplier selalu berasal dari Master Bahan
            // untuk SPPG yang sedang dipilih. Permintaan SPPG adalah snapshot
            // historis untuk transaksi yang sudah dibuat, bukan sumber harga master.
            // Jika harga Master Bahan masih 0, tampilkan sebagai belum ditetapkan.
            foreach ($linked as &$lb) {
                $masterPrice = (float)($lb['harga_jual_master'] ?? 0);
                $lb['harga_jual'] = $masterPrice;
                $lb['harga_jual_source'] = $masterPrice > 0 ? 'master_bahan' : 'belum_diatur';
            }
            unset($lb);

            $linkedIds = array_map(static fn($x)=>(int)$x['bahan_id'],$linked);
            $builder = $this->bahan->where('id_sppg',$sppgId)->where('status','aktif')->orderBy('nama_bahan');
            if ($linkedIds) $builder->whereNotIn('id',$linkedIds);
            $available = $builder->findAll();
        }
        $row['mou_state'] = $this->mouState($row['tanggal_mou_akhir'] ?? null);
        return view('koperasi/supplier/detail', compact('row','types','docs','assigned','sppgId','linked','available'));
    }

    public function delete(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row = $this->supplierForKoperasi($id);
        if (!$row) return redirect()->back()->with('error','Supplier tidak ditemukan.');
        $used = $this->supplierBahan->where('supplier_id',$id)->countAllResults();
        if ($used > 0) return redirect()->back()->with('error','Supplier sudah terhubung dengan bahan. Nonaktifkan supplier jika tidak digunakan lagi.');
        $this->supplier->update($id,['status'=>'nonaktif','updated_at'=>date('Y-m-d H:i:s')]);
        return redirect()->to(base_url('koperasi/supplier'))->with('success','Supplier dinonaktifkan.');
    }

    public function storeJenis()
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $nama = trim((string)$this->request->getPost('nama_jenis'));
        $ket = trim((string)$this->request->getPost('keterangan'));
        if ($nama === '' || mb_strlen($nama)>100) return redirect()->back()->with('error','Nama jenis dokumen wajib diisi.');
        $exists = $this->jenis->where('nama_jenis',$nama)->first();
        if ($exists) return redirect()->back()->with('error','Jenis dokumen tersebut sudah ada.');
        $this->jenis->insert(['nama_jenis'=>$nama,'status'=>'aktif','keterangan'=>$ket ?: null,'created_by'=>session('user_id')]);
        return redirect()->back()->with('success','Jenis dokumen berhasil ditambahkan.');
    }

    public function toggleJenis(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $row=$this->jenis->find($id); if(!$row)return redirect()->back()->with('error','Jenis dokumen tidak ditemukan.');
        $this->jenis->update($id,['status'=>$row['status']==='aktif'?'nonaktif':'aktif']);
        return redirect()->back()->with('success','Status jenis dokumen diperbarui.');
    }

    public function uploadDocument(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        if (!$this->supplierForKoperasi($id)) return redirect()->back()->with('error','Supplier tidak ditemukan.');
        $typeId=(int)$this->request->getPost('jenis_dokumen_id'); $name=trim((string)$this->request->getPost('nama_berkas')); $ket=trim((string)$this->request->getPost('keterangan'));
        $type=$this->jenis->where('id',$typeId)->where('status','aktif')->first();
        $file=$this->request->getFile('file');
        if(!$type || !$file || !$file->isValid()) return redirect()->back()->with('error','Jenis dokumen dan berkas wajib dipilih.');
        if($file->getSize()>5*1024*1024) return redirect()->back()->with('error','Ukuran berkas maksimal 5 MB.');
        $allowed=['application/pdf','image/jpeg','image/png'];
        if(!in_array($file->getMimeType(),$allowed,true)) return redirect()->back()->with('error','Format berkas yang diizinkan: PDF, JPG/JPEG, PNG.');
        $dir=FCPATH.'uploads/supplier'; if(!is_dir($dir)) mkdir($dir,0775,true);
        $newName=$file->getRandomName(); $file->move($dir,$newName);
        $this->berkas->insert(['supplier_id'=>$id,'jenis_dokumen_id'=>$typeId,'nama_berkas'=>$name?:$type['nama_jenis'],'file_name'=>$file->getClientName(),'file_path'=>'uploads/supplier/'.$newName,'file_type'=>$file->getMimeType(),'file_size'=>$file->getSize(),'keterangan'=>$ket?:null,'created_by'=>session('user_id')]);
        return redirect()->back()->with('success','Berkas supplier berhasil diunggah.');
    }

    public function deleteDocument(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $doc=$this->berkas->find($id); if(!$doc)return redirect()->back()->with('error','Berkas tidak ditemukan.');
        if(!$this->supplierForKoperasi((int)$doc['supplier_id']))return redirect()->back()->with('error','Akses berkas ditolak.');
        $path=FCPATH.$doc['file_path']; if(is_file($path))@unlink($path); $this->berkas->delete($id);
        return redirect()->back()->with('success','Berkas berhasil dihapus.');
    }

    public function linkBahan(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        if (!$this->supplierForKoperasi($id)) return redirect()->back()->with('error','Supplier tidak ditemukan.');
        $bahanId=(int)$this->request->getPost('bahan_id'); $harga=(float)$this->request->getPost('harga_beli'); $sppg=trim((string)$this->request->getPost('id_sppg'));
        if(!$bahanId || !$this->hasAssignedSppg($sppg))return redirect()->back()->with('error','Bahan/SPPG tidak valid.');
        $bahan=$this->bahan->where('id',$bahanId)->where('id_sppg',$sppg)->where('status','aktif')->first(); if(!$bahan)return redirect()->back()->with('error','Bahan tidak ditemukan.');
        if($harga<0)return redirect()->back()->with('error','Harga beli tidak boleh negatif.');
        $existing=$this->supplierBahan->where('supplier_id',$id)->where('bahan_id',$bahanId)->first();
        if($existing){
            if($harga !== (float)$existing['harga_beli']){
                $this->harga->insert(['supplier_bahan_id'=>$existing['id'],'harga_lama'=>$existing['harga_beli'],'harga_baru'=>$harga,'berlaku_mulai'=>date('Y-m-d'),'diubah_oleh'=>session('user_id'),'keterangan'=>'Perubahan harga supplier oleh Koperasi','created_at'=>date('Y-m-d H:i:s')]);
                $this->supplierBahan->update($existing['id'],['harga_beli'=>$harga,'updated_by'=>session('user_id')]);
            }
        } else {
            $sbid=$this->supplierBahan->insert(['supplier_id'=>$id,'bahan_id'=>$bahanId,'harga_beli'=>$harga,'status'=>'aktif','created_by'=>session('user_id'),'updated_by'=>session('user_id')],true);
            $this->harga->insert(['supplier_bahan_id'=>$sbid,'harga_lama'=>0,'harga_baru'=>$harga,'berlaku_mulai'=>date('Y-m-d'),'diubah_oleh'=>session('user_id'),'keterangan'=>'Harga awal supplier','created_at'=>date('Y-m-d H:i:s')]);
        }
        return redirect()->to(base_url('koperasi/supplier/detail/'.$id.'?id_sppg='.urlencode($sppg)))->with('success','Bahan berhasil dihubungkan ke supplier dan harga beli dicatat.');
    }

    public function updateHargaBahan(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $sb=$this->supplierBahan->find($id); if(!$sb)return redirect()->back()->with('error','Relasi supplier-bahan tidak ditemukan.');
        if(!$this->supplierForKoperasi((int)$sb['supplier_id']))return redirect()->back()->with('error','Akses ditolak.');
        $harga=(float)$this->request->getPost('harga_beli'); $mulai=trim((string)$this->request->getPost('berlaku_mulai')) ?: date('Y-m-d'); $ket=trim((string)$this->request->getPost('keterangan'));
        if($harga<0)return redirect()->back()->with('error','Harga beli tidak boleh negatif.');
        if($harga !== (float)$sb['harga_beli']){
            $this->harga->insert(['supplier_bahan_id'=>$id,'harga_lama'=>$sb['harga_beli'],'harga_baru'=>$harga,'berlaku_mulai'=>$mulai,'diubah_oleh'=>session('user_id'),'keterangan'=>$ket?:'Perubahan harga supplier oleh Koperasi','created_at'=>date('Y-m-d H:i:s')]);
            $this->supplierBahan->update($id,['harga_beli'=>$harga,'updated_by'=>session('user_id')]);
        }
        $sppg=$this->request->getPost('id_sppg'); return redirect()->to(base_url('koperasi/supplier/detail/'.$sb['supplier_id'].'?id_sppg='.urlencode((string)$sppg)))->with('success','Harga beli supplier berhasil diperbarui dan dicatat dalam histori.');
    }

    public function unlinkBahan(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $sb=$this->supplierBahan->find($id); if(!$sb || !$this->supplierForKoperasi((int)$sb['supplier_id']))return redirect()->back()->with('error','Relasi tidak ditemukan.');
        $this->supplierBahan->update($id,['status'=>'nonaktif','updated_by'=>session('user_id')]);
        return redirect()->back()->with('success','Relasi supplier-bahan dinonaktifkan. Histori harga tetap aman.');
    }

    public function historyHarga(int $id)
    {
        if ($r = $this->ensureKoperasi()) return $r;
        $sb=$this->supplierBahan->find($id); if(!$sb || !$this->supplierForKoperasi((int)$sb['supplier_id']))return redirect()->back()->with('error','Relasi tidak ditemukan.');
        $supplier=$this->supplierForKoperasi((int)$sb['supplier_id']);
        $bahan=$this->bahan->find($sb['bahan_id']);
        $history=$this->harga->where('supplier_bahan_id',$id)->orderBy('created_at','DESC')->findAll();
        return view('koperasi/supplier/history_harga',compact('supplier','bahan','sb','history'));
    }

    private function validateSupplierInput()
    {
        $kode=trim((string)$this->request->getPost('kode_supplier')); $nama=trim((string)$this->request->getPost('nama_supplier')); $pic=trim((string)$this->request->getPost('nama_pic'));
        if($nama===''||$pic==='')return redirect()->back()->withInput()->with('error','Nama Supplier dan Nama PIC wajib diisi.');
        if($kode==='')$kode=$this->generateSupplierCode();
        $mulai=trim((string)$this->request->getPost('tanggal_mou_mulai')); $akhir=trim((string)$this->request->getPost('tanggal_mou_akhir'));
        if($mulai!==''&&$akhir!==''&&$akhir<$mulai)return redirect()->back()->withInput()->with('error','Tanggal berakhir MOU tidak boleh lebih awal dari tanggal mulai.');
        $email=trim((string)$this->request->getPost('email')); if($email!==''&&!filter_var($email,FILTER_VALIDATE_EMAIL))return redirect()->back()->withInput()->with('error','Format email supplier tidak valid.');
        return ['kode_supplier'=>$kode,'nama_supplier'=>$nama,'nama_pic'=>$pic,'no_hp'=>trim((string)$this->request->getPost('no_hp'))?:null,'alamat'=>trim((string)$this->request->getPost('alamat')),'kabupaten_kota'=>trim((string)$this->request->getPost('kabupaten_kota'))?:null,'provinsi'=>trim((string)$this->request->getPost('provinsi'))?:null,'npwp_nik'=>trim((string)$this->request->getPost('npwp_nik'))?:null,'email'=>$email?:null,'tanggal_mou_mulai'=>$mulai?:null,'tanggal_mou_akhir'=>$akhir?:null,'status'=>$this->request->getPost('status')==='nonaktif'?'nonaktif':'aktif','catatan'=>trim((string)$this->request->getPost('catatan'))?:null];
    }

    private function seedDefaultDocumentTypes(): void
    {
        $defaults=['NIB','NPWP','KTP PIC','Akta/Legalitas','Surat Kerja Sama / MOU','Sertifikat','Dokumen Rekening','Dokumen Lainnya'];
        foreach($defaults as $name){if(!$this->jenis->where('nama_jenis',$name)->first())$this->jenis->insert(['nama_jenis'=>$name,'status'=>'aktif','created_by'=>session('user_id')]);}
    }
}
