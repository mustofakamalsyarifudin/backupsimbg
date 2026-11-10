<?php

namespace App\Controllers\Koperasi;

use App\Models\MasterBahanModel;
use App\Models\MasterBahanHargaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Bahan extends BaseKoperasi
{
    protected MasterBahanModel $bahanModel;
    protected MasterBahanHargaModel $hargaModel;

    public function __construct()
    {
        parent::__construct();
        $this->bahanModel = new MasterBahanModel();
        $this->hargaModel = new MasterBahanHargaModel();
    }

    public function index()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;

        $sppgs = $this->assignedSppgs();
        $idSppg = $this->activeSppgId();
        $q = trim((string) $this->request->getGet('q'));
        $status = trim((string) $this->request->getGet('status'));

        $bahans = [];
        if ($idSppg) {
            $builder = $this->bahanModel
                ->where('id_sppg', $idSppg);
            if ($q !== '') {
                $builder->groupStart()
                    ->like('nama_bahan', $q)
                    ->orLike('satuan_default', $q)
                    ->groupEnd();
            }
            if (in_array($status, ['aktif', 'nonaktif'], true)) {
                $builder->where('status', $status);
            }
            $bahans = $builder
                ->orderBy('status', 'DESC')
                ->orderBy('nama_bahan', 'ASC')
                ->findAll();
        }

        // Katalog bersama: bahan yang sudah tersedia di SPPG lain yang masih ditangani koperasi.
        // Tidak membuat master global baru; setiap SPPG tetap memiliki record sendiri sehingga
        // satuan dan harga dapat berbeda antar-SPPG.
        $ids = array_map(static fn(array $row): string => (string) $row['id_sppg'], $sppgs);
        $catalog = [];
        $catalogModel = new MasterBahanModel();
        if ($ids) {
            $catalogBuilder = $catalogModel
                ->whereIn('id_sppg', $ids)
                ->where('status', 'aktif');
            if ($idSppg) {
                $catalogBuilder->where('id_sppg !=', $idSppg);
            }
            if ($q !== '') {
                $catalogBuilder->groupStart()
                    ->like('nama_bahan', $q)
                    ->orLike('satuan_default', $q)
                    ->groupEnd();
            }
            $catalog = $catalogBuilder
                ->orderBy('nama_bahan', 'ASC')
                ->orderBy('id_sppg', 'ASC')
                ->findAll();
        }

        $catalogSppgNames = [];
        foreach ($sppgs as $row) {
            $catalogSppgNames[(string) $row['id_sppg']] = $row['sppg_name'];
        }

        // Semua SPPG yang ditangani dapat menjadi tujuan salin. SPPG sumber
        // tetap divalidasi dan dikecualikan lagi di method copy().
        $copyTargets = $sppgs;

        return view('koperasi/bahan/index', [
            'title' => 'Master Bahan & Harga',
            'sppgs' => $sppgs,
            'activeSppg' => $idSppg,
            'bahans' => $bahans,
            'pager' => $this->bahanModel->pager,
            'catalogPager' => $catalogModel->pager,
            'catalog' => $catalog,
            'catalogSppgNames' => $catalogSppgNames,
            'copyTargets' => $copyTargets,
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $idSppg = $this->activeSppgId();
        if (!$idSppg) return redirect()->back()->with('error', 'Belum ada SPPG aktif yang ditugaskan kepada Koperasi.');

        $nama = trim((string) $this->request->getPost('nama_bahan'));
        $satuan = trim((string) $this->request->getPost('satuan_default'));
        if ($nama === '' || $satuan === '') {
            return redirect()->back()->withInput()->with('error', 'Nama bahan dan satuan wajib diisi. Harga tidak perlu diisi saat membuat bahan baru.');
        }

        $exists = $this->bahanModel->where('id_sppg', $idSppg)->where('nama_bahan', $nama)->first();
        if ($exists) return redirect()->back()->withInput()->with('error', 'Bahan tersebut sudah tersedia untuk SPPG aktif.');

        $id = $this->bahanModel->insert([
            'id_sppg' => $idSppg,
            'nama_bahan' => $nama,
            'satuan_default' => $satuan,
            'harga' => 0,
            'status' => 'aktif',
            'created_by' => session('user_id'),
            'updated_by' => session('user_id'),
        ], true);

        if (!$id) return redirect()->back()->withInput()->with('error', 'Bahan gagal ditambahkan.');
        return redirect()->to(base_url('koperasi/bahan'))->with('success', 'Bahan berhasil ditambahkan. Harga untuk SPPG ini dapat diatur kemudian.');
    }

    public function copy()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;

        $sourceId = (int) $this->request->getPost('source_id');
        $targetIds = $this->request->getPost('target_sppg');
        $copyPrice = $this->request->getPost('copy_price') === '1';

        if ($sourceId <= 0 || !is_array($targetIds)) {
            return redirect()->back()->with('error', 'Bahan sumber dan minimal satu SPPG tujuan wajib dipilih.');
        }

        $source = $this->bahanModel->find($sourceId);
        if (!$source || !$this->hasAssignedSppg((string) $source['id_sppg'])) {
            return redirect()->back()->with('error', 'Bahan sumber tidak berasal dari SPPG yang ditangani Koperasi ini.');
        }
        if (($source['status'] ?? 'nonaktif') !== 'aktif') {
            return redirect()->back()->with('error', 'Bahan sumber sedang nonaktif dan tidak dapat disalin.');
        }

        $assignedIds = array_map(static fn(array $row): string => (string) $row['id_sppg'], $this->assignedSppgs());
        $targetIds = array_values(array_unique(array_map('strval', $targetIds)));
        $targetIds = array_values(array_intersect($targetIds, $assignedIds));
        $targetIds = array_values(array_filter($targetIds, static fn(string $id): bool => $id !== (string) $source['id_sppg']));

        if (!$targetIds) return redirect()->back()->with('error', 'Tidak ada SPPG tujuan yang valid.');

        $created = 0;
        $skipped = 0;
        $price = $copyPrice ? (float) ($source['harga'] ?? 0) : 0;
        foreach ($targetIds as $targetId) {
            $exists = $this->bahanModel
                ->where('id_sppg', $targetId)
                ->where('nama_bahan', $source['nama_bahan'])
                ->first();
            if ($exists) {
                $skipped++;
                continue;
            }

            $newId = $this->bahanModel->insert([
                'id_sppg' => $targetId,
                'nama_bahan' => $source['nama_bahan'],
                'satuan_default' => $source['satuan_default'],
                'harga' => $price,
                'status' => 'aktif',
                'created_by' => session('user_id'),
                'updated_by' => session('user_id'),
            ], true);
            if ($newId) $created++;
        }

        $message = "Bahan berhasil disalin ke {$created} SPPG.";
        if ($skipped) $message .= " {$skipped} SPPG dilewati karena bahan sudah tersedia.";
        if (!$copyPrice) $message .= ' Harga tidak disalin; setiap SPPG dapat menetapkan harga sendiri.';
        return redirect()->back()->with('success', $message);
    }

    public function exportExcel()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;

        $idSppg = $this->activeSppgId();
        if (!$idSppg || !$this->hasAssignedSppg((string) $idSppg)) {
            return redirect()->back()->with('error', 'Pilih SPPG yang ditangani Koperasi terlebih dahulu.');
        }

        // Ekspor seluruh master bahan untuk SPPG aktif, bukan hanya hasil pencarian/tampilan tabel.
        $bahans = $this->bahanModel
            ->where('id_sppg', $idSppg)
            ->orderBy('nama_bahan', 'ASC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Master Bahan');
        $headers = ['ID Bahan', 'Nama Bahan', 'Satuan', 'Harga'];
        foreach ($headers as $i => $header) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . '1', $header);
        }

        $rowNo = 2;
        foreach ($bahans as $bahan) {
            // ID digunakan sebagai kunci yang stabil supaya edit nama tidak salah dianggap bahan baru.
            $sheet->setCellValue('A' . $rowNo, (int) $bahan['id']);
            $sheet->setCellValueExplicit('B' . $rowNo, (string) $bahan['nama_bahan'], DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNo, (string) $bahan['satuan_default'], DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNo, (float) ($bahan['harga'] ?? 0));
            $rowNo++;
        }

        $lastRow = max(1, $rowNo - 1);
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FF1D4ED8');
        $sheet->getStyle('A1:D1')->getAlignment()->setVertical('center');
        $sheet->getRowDimension(1)->setRowHeight(24);
        $sheet->getColumnDimension('A')->setWidth(14);
        $sheet->getColumnDimension('B')->setWidth(34);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(20);
        if ($lastRow >= 2) {
            $sheet->getStyle('D2:D' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.##');
        }
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:D' . $lastRow);

        $safeSppg = preg_replace('/[^A-Za-z0-9_-]/', '_', (string) $idSppg);
        $fileName = 'Master_Bahan_' . $safeSppg . '_' . date('Ymd_His') . '.xlsx';
        $tmp = tempnam(sys_get_temp_dir(), 'sigita_bahan_') . '.xlsx';
        (new Xlsx($spreadsheet))->save($tmp);

        return $this->response->download($tmp, null)->setFileName($fileName);
    }

    public function templateExcel()
    {
        // Kompatibilitas untuk tautan lama: unduh data bahan SPPG aktif, bukan template contoh.
        return $this->exportExcel();
    }

    public function importExcel()
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $idSppg = $this->activeSppgId();
        if (!$idSppg) {
            return redirect()->back()->with('error', 'Pilih SPPG terlebih dahulu sebelum import Excel.');
        }

        $file = $this->request->getFile('file_excel');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File Excel tidak ditemukan atau tidak valid.');
        }
        if (!in_array(strtolower($file->getClientExtension()), ['xlsx', 'xls'], true)) {
            return redirect()->back()->with('error', 'Format file harus Excel .xlsx atau .xls.');
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5 MB.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Throwable $e) {
            log_message('error', 'Import master bahan gagal: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'File Excel tidak dapat dibaca. Pastikan formatnya sesuai template SIGITA.');
        }

        if (!$rows || count($rows) < 2) {
            return redirect()->back()->with('error', 'File Excel belum memiliki data bahan.');
        }

        $header = array_map(static fn($v) => strtolower(trim((string) $v)), $rows[1]);
        $normalizeHeader = static function($value): string {
            return strtolower(preg_replace('/[^a-z0-9]+/i', '', (string) $value));
        };
        $findHeader = static function(array $header, array $aliases) use ($normalizeHeader): ?string {
            foreach ($header as $col => $value) {
                $normalized = $normalizeHeader($value);
                foreach ($aliases as $alias) {
                    if ($normalized === $normalizeHeader($alias)) return $col;
                }
            }
            return null;
        };
        $idCol = $findHeader($header, ['ID Bahan', 'ID']);
        $nameCol = $findHeader($header, ['Nama Bahan', 'Nama']);
        $unitCol = $findHeader($header, ['Satuan', 'Satuan Default']);
        $priceCol = $findHeader($header, ['Harga', 'Harga SPPG', 'Harga Saat Ini']);

        if (!$nameCol || !$unitCol) {
            return redirect()->back()->with('error', 'Kolom wajib tidak ditemukan. Gunakan header: Nama Bahan, Satuan, Harga. Kolom ID Bahan bersifat opsional.');
        }

        $created = 0;
        $updatedName = 0;
        $updatedUnit = 0;
        $updatedPrice = 0;
        $unchanged = 0;
        $errors = [];
        $seenNames = [];
        $seenIds = [];

        foreach ($rows as $rowNo => $row) {
            if ($rowNo === 1) continue;
            $bahanIdRaw = $idCol ? trim((string) ($row[$idCol] ?? '')) : '';
            $nama = trim((string) ($row[$nameCol] ?? ''));
            $satuan = trim((string) ($row[$unitCol] ?? ''));
            $rawPrice = $priceCol ? ($row[$priceCol] ?? '') : '';

            if ($nama === '' && $satuan === '' && ($rawPrice === '' || $rawPrice === null)) continue;
            if ($nama === '' || $satuan === '') {
                $errors[] = "Baris {$rowNo}: Nama Bahan dan Satuan wajib diisi.";
                continue;
            }
            if (mb_strlen($nama) > 100 || mb_strlen($satuan) > 50) {
                $errors[] = "Baris {$rowNo}: panjang Nama Bahan/Satuan melebihi batas.";
                continue;
            }

            if ($bahanIdRaw !== '' && (!ctype_digit($bahanIdRaw) || (int) $bahanIdRaw <= 0)) {
                $errors[] = "Baris {$rowNo}: ID Bahan harus berupa bilangan bulat positif atau dikosongkan untuk bahan baru.";
                continue;
            }
            if ($bahanIdRaw !== '') {
                if (isset($seenIds[$bahanIdRaw])) {
                    $errors[] = "Baris {$rowNo}: ID Bahan duplikat di file Excel (sama dengan baris {$seenIds[$bahanIdRaw]}). Baris dilewati.";
                    continue;
                }
                $seenIds[$bahanIdRaw] = $rowNo;
            }

            $priceProvided = $rawPrice !== '' && $rawPrice !== null;
            $price = 0;
            if ($priceProvided) {
                if (is_string($rawPrice)) {
                    $clean = preg_replace('/[^0-9,.-]/', '', trim($rawPrice));
                    $lastComma = strrpos($clean, ',');
                    $lastDot = strrpos($clean, '.');
                    if ($lastComma !== false && $lastDot !== false) {
                        // 15.000,50 -> 15000.50 ; 15,000.50 -> 15000.50
                        if ($lastComma > $lastDot) {
                            $clean = str_replace('.', '', $clean);
                            $clean = str_replace(',', '.', $clean);
                        } else {
                            $clean = str_replace(',', '', $clean);
                        }
                    } elseif ($lastComma !== false) {
                        $parts = explode(',', $clean);
                        $clean = (count($parts) === 2 && strlen($parts[1]) <= 2)
                            ? $parts[0] . '.' . $parts[1]
                            : str_replace(',', '', $clean);
                    } elseif ($lastDot !== false) {
                        $parts = explode('.', $clean);
                        $clean = (count($parts) === 2 && strlen($parts[1]) <= 2)
                            ? $clean
                            : str_replace('.', '', $clean);
                    }
                    $rawPrice = $clean;
                }
                if (!is_numeric($rawPrice) || (float) $rawPrice < 0) {
                    $errors[] = "Baris {$rowNo}: Harga harus angka >= 0.";
                    continue;
                }
                $price = (float) $rawPrice;
            }

            $nameKey = mb_strtolower(preg_replace('/\s+/u', ' ', $nama), 'UTF-8');
            if (isset($seenNames[$nameKey])) {
                $errors[] = "Baris {$rowNo}: nama bahan duplikat di file Excel (sama dengan baris {$seenNames[$nameKey]}). Baris dilewati.";
                continue;
            }
            $seenNames[$nameKey] = $rowNo;

            if ($bahanIdRaw !== '') {
                // ID wajib berasal dari SPPG aktif supaya file tidak bisa mengubah bahan SPPG lain.
                $existing = $this->bahanModel
                    ->where('id_sppg', $idSppg)
                    ->where('id', (int) $bahanIdRaw)
                    ->first();
                if (!$existing) {
                    $errors[] = "Baris {$rowNo}: ID Bahan {$bahanIdRaw} tidak ditemukan pada SPPG aktif. Pastikan ID tidak diubah.";
                    continue;
                }
                $duplicateName = $this->bahanModel
                    ->where('id_sppg', $idSppg)
                    ->where('nama_bahan', $nama)
                    ->where('id !=', (int) $bahanIdRaw)
                    ->first();
                if ($duplicateName) {
                    $errors[] = "Baris {$rowNo}: nama bahan sudah digunakan oleh bahan lain pada SPPG ini.";
                    continue;
                }
            } else {
                // Mendukung template lama: jika nama sudah ada, perbarui; jika belum, tambahkan.
                $existing = $this->bahanModel
                    ->where('id_sppg', $idSppg)
                    ->where('nama_bahan', $nama)
                    ->first();
            }

            if (!$existing) {
                $newId = $this->bahanModel->insert([
                    'id_sppg' => $idSppg,
                    'nama_bahan' => $nama,
                    'satuan_default' => $satuan,
                    'harga' => $priceProvided ? $price : 0,
                    'status' => 'aktif',
                    'created_by' => session('user_id'),
                    'updated_by' => session('user_id'),
                ], true);
                if ($newId) $created++;
                else $errors[] = "Baris {$rowNo}: gagal menyimpan bahan.";
                continue;
            }

            $changes = [];
            $nameChanged = (string) $existing['nama_bahan'] !== $nama;
            $unitChanged = (string) $existing['satuan_default'] !== $satuan;
            $priceChanged = $priceProvided && (float) $existing['harga'] !== $price;
            if ($nameChanged) $changes['nama_bahan'] = $nama;
            if ($unitChanged) $changes['satuan_default'] = $satuan;
            if ($priceChanged) $changes['harga'] = $price;

            if ($changes) {
                $changes['updated_by'] = session('user_id');
                $db = \Config\Database::connect();
                $db->transBegin();
                $saved = $this->bahanModel->update($existing['id'], $changes);
                $historySaved = true;
                if ($saved && $priceChanged) {
                    $historyId = $this->hargaModel->insert([
                        'bahan_id' => $existing['id'],
                        'harga_lama' => (float) $existing['harga'],
                        'harga_baru' => $price,
                        'diubah_oleh' => session('user_id'),
                        'keterangan' => 'Import Excel oleh Koperasi',
                    ], true);
                    $historySaved = (bool) $historyId;
                }
                if (!$saved || !$historySaved || !$db->transStatus()) {
                    $db->transRollback();
                    $errors[] = "Baris {$rowNo}: perubahan gagal disimpan; tidak ada perubahan yang diterapkan pada baris ini.";
                    continue;
                }
                $db->transCommit();
                if ($nameChanged) $updatedName++;
                if ($unitChanged) $updatedUnit++;
                if ($priceChanged) $updatedPrice++;
            } else {
                $unchanged++;
            }
        }

        $summary = "Import selesai: {$created} bahan baru, {$updatedName} nama diperbarui, {$updatedUnit} satuan diperbarui, {$updatedPrice} harga diperbarui, {$unchanged} baris tidak berubah.";
        if ($errors) {
            $summary .= ' Ada ' . count($errors) . ' baris bermasalah.';
            session()->setFlashdata('import_errors', array_slice($errors, 0, 20));
        }
        return redirect()->to(base_url('koperasi/bahan'))->with('success', $summary);
    }

    public function updateUnit($id)
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $idSppg = $this->activeSppgId();
        $bahan = $this->bahanModel->where('id', $id)->where('id_sppg', $idSppg)->first();
        if (!$bahan) return redirect()->back()->with('error', 'Bahan tidak ditemukan pada SPPG aktif.');

        $satuan = trim((string) $this->request->getPost('satuan_default'));
        if ($satuan === '' || mb_strlen($satuan) > 50) {
            return redirect()->back()->withInput()->with('error', 'Satuan wajib diisi dan maksimal 50 karakter.');
        }

        $this->bahanModel->update($id, [
            'satuan_default' => $satuan,
            'updated_by' => session('user_id'),
        ]);
        return redirect()->back()->with('success', 'Satuan bahan berhasil diperbarui untuk SPPG ini.');
    }

    public function updateHarga($id)
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $idSppg = $this->activeSppgId();
        $bahan = $this->bahanModel->where('id', $id)->where('id_sppg', $idSppg)->first();
        if (!$bahan) return redirect()->back()->with('error', 'Bahan tidak ditemukan pada SPPG aktif.');

        $harga = $this->request->getPost('harga');
        if ($harga === null || $harga === '' || !is_numeric($harga) || (float) $harga < 0) return redirect()->back()->withInput()->with('error', 'Harga harus berupa angka dan tidak boleh negatif.');
        $harga = (float) $harga;
        $hargaLama = (float) $bahan['harga'];

        $this->bahanModel->update($id, ['harga' => $harga, 'updated_by' => session('user_id')]);
        if ($harga !== $hargaLama) {
            $this->hargaModel->insert([
                'bahan_id' => $id,
                'harga_lama' => $hargaLama,
                'harga_baru' => $harga,
                'diubah_oleh' => session('user_id'),
                'keterangan' => 'Perubahan harga oleh Koperasi',
            ]);
        }
        return redirect()->back()->with('success', 'Harga bahan berhasil diperbarui.');
    }

    public function history($id)
    {
        if ($redirect = $this->ensureKoperasi()) return $redirect;
        $idSppg = $this->activeSppgId();
        $bahan = $this->bahanModel->where('id', $id)->where('id_sppg', $idSppg)->first();
        if (!$bahan) return redirect()->back()->with('error', 'Bahan tidak ditemukan pada SPPG aktif.');

        $history = $this->hargaModel
            ->where('bahan_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('koperasi/bahan/history', [
            'title' => 'Riwayat Harga',
            'bahan' => $bahan,
            'history' => $history,
            'pager' => $this->hargaModel->pager,
        ]);
    }
}
