<?php

namespace App\Controllers\Gizi;

use App\Controllers\BaseController;
use App\Models\MenuGiziModel;
use App\Models\MenuKomposisiModel;
use App\Models\PenerimaManfaatModel;
use App\Models\PMKelasModel;
use App\Models\RencanaMenuDetailModel;
use App\Models\RencanaMenuModel;
use App\Models\RencanaMenuPenerimaDetailModel;
use App\Models\RencanaMenuPenerimaModel;
use App\Models\SppgModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class RencanaMenu extends BaseController
{
    protected RencanaMenuModel $rencanaMenuModel;
    protected RencanaMenuDetailModel $rencanaMenuDetailModel;
    protected RencanaMenuPenerimaModel $rencanaMenuPenerimaModel;
    protected RencanaMenuPenerimaDetailModel $rencanaMenuPenerimaDetailModel;
    protected PenerimaManfaatModel $penerimaManfaatModel;
    protected PMKelasModel $pmKelasModel;
    protected MenuGiziModel $menuGiziModel;
    protected MenuKomposisiModel $menuKomposisiModel;

    public function __construct()
    {
        $this->rencanaMenuModel = new RencanaMenuModel();
        $this->rencanaMenuDetailModel = new RencanaMenuDetailModel();
        $this->rencanaMenuPenerimaModel = new RencanaMenuPenerimaModel();
        $this->rencanaMenuPenerimaDetailModel = new RencanaMenuPenerimaDetailModel();
        $this->penerimaManfaatModel = new PenerimaManfaatModel();
        $this->pmKelasModel = new PMKelasModel();
        $this->menuGiziModel = new MenuGiziModel();
        $this->menuKomposisiModel = new MenuKomposisiModel();
    }

    public function index()
    {
        $tanggalMulai = trim((string) $this->request->getGet('tanggal_mulai'));
        $tanggalAkhir = trim((string) $this->request->getGet('tanggal_akhir'));

        if ($tanggalMulai !== '' && $tanggalAkhir !== '' && $tanggalMulai > $tanggalAkhir) {
            return redirect()
                ->to(base_url('gizi/rencana-menu'))
                ->with('error', 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
        }

        $builder = $this->rencanaMenuModel
            ->where('id_sppg', session('id_sppg'));

        if ($tanggalMulai !== '') {
            $builder->where('tanggal >=', $tanggalMulai);
        }

        if ($tanggalAkhir !== '') {
            $builder->where('tanggal <=', $tanggalAkhir);
        }

        $builder
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC');

        $rencana = $builder->paginate(10, 'rencanaMenu');

        return view('gizi/rencana_menu/index', [
            'title'        => 'Rencana Menu',
            'rencana'      => $rencana,
            'pager'        => $this->rencanaMenuModel->pager,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
        ]);
    }

    public function create()
    {
        $tanggalAwal = trim((string) $this->request->getGet('tanggal'));
        $data = $this->formData();

        return view('gizi/rencana_menu/create', [
            'title'       => 'Buat Rencana Menu',
            'menu'        => $data['menu'],
            'komposisiMenu' => $data['komposisiMenu'],
            'penerima'    => $data['penerima'],
            'detailMenu'  => [],
            'assignment'  => [],
            'rencana'     => null,
            'tanggalAwal' => $tanggalAwal,
        ]);
    }

    public function store()
    {
        $idSppg = session('id_sppg');

        $tanggal = trim((string) $this->request->getPost('tanggal'));
        $catatan = trim((string) $this->request->getPost('catatan'));

        if ($tanggal === '') {
            return redirect()->back()->withInput()->with('error', 'Tanggal rencana menu wajib diisi.');
        }

        $existing = $this->rencanaMenuModel
            ->where('id_sppg', $idSppg)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['draft', 'ditetapkan'])
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Rencana menu untuk tanggal tersebut sudah tersedia.');
        }

        // DRAFT boleh disimpan dalam kondisi belum lengkap.
        // Validasi pembagian PM hanya dilakukan saat rencana ditetapkan.
        $payload = $this->normalizePost();

        $db = db_connect();
        $db->transStart();

        $rencanaId = $this->rencanaMenuModel->insert([
            'id_sppg'    => $idSppg,
            'tanggal'    => $tanggal,
            'status'     => 'draft',
            'catatan'    => $catatan !== '' ? $catatan : null,
            'created_by' => session('user_id'),
        ], true);

        if (!$rencanaId) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Rencana menu gagal dibuat.');
        }

        $this->saveAssignments($rencanaId, $payload);

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'RencanaMenu::store gagal: {error}', [
                'error' => json_encode($db->error()),
            ]);

            return redirect()->back()->withInput()->with('error', 'Rencana menu gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->to(base_url('gizi/rencana-menu/edit/' . $rencanaId))
            ->with('success', 'Rencana menu berhasil dibuat sebagai draft.');
    }

    public function edit($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] !== 'draft') {
            return redirect()
                ->to(base_url('gizi/rencana-menu/detail/' . $id))
                ->with('error', 'Rencana menu yang sudah tidak berstatus Draft tidak dapat diedit.');
        }

        $data = $this->formData($id);

        return view('gizi/rencana_menu/edit', [
            'title'      => 'Edit Rencana Menu',
            'menu'       => $data['menu'],
            'komposisiMenu' => $data['komposisiMenu'],
            'penerima'   => $data['penerima'],
            'detailMenu' => $data['detailMenu'],
            'assignment' => $data['assignment'],
            'rencana'    => $rencana,
        ]);
    }

    public function update($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] !== 'draft') {
            return redirect()
                ->to(base_url('gizi/rencana-menu/detail/' . $id))
                ->with('error', 'Rencana menu yang sudah tidak berstatus Draft tidak dapat diedit.');
        }

        // DRAFT boleh diperbarui dalam kondisi belum lengkap.
        // Validasi pembagian PM hanya dilakukan saat rencana ditetapkan.
        $payload = $this->normalizePost();

        $tanggal = trim((string) $this->request->getPost('tanggal'));
        $catatan = trim((string) $this->request->getPost('catatan'));

        if ($tanggal === '') {
            return redirect()->back()->withInput()->with('error', 'Tanggal rencana menu wajib diisi.');
        }

        $duplicate = $this->rencanaMenuModel
            ->where('id_sppg', session('id_sppg'))
            ->where('tanggal', $tanggal)
            ->where('id !=', $id)
            ->whereIn('status', ['draft', 'ditetapkan'])
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'Sudah ada rencana menu lain pada tanggal tersebut.');
        }

        $db = db_connect();
        $db->transStart();

        $this->rencanaMenuModel->update($id, [
            'tanggal' => $tanggal,
            'catatan' => $catatan !== '' ? $catatan : null,
        ]);

        $this->clearAssignments($id);
        $this->saveAssignments($id, $payload);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Rencana menu gagal diperbarui.');
        }

        return redirect()
            ->to(base_url('gizi/rencana-menu/edit/' . $id))
            ->with('success', 'Rencana menu berhasil diperbarui.');
    }

    public function detail($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $detailMenu = $this->rencanaMenuDetailModel
            ->where('rencana_menu_id', $id)
            ->findAll();

        $menuMap = [];
        $menuIds = array_values(array_unique(array_map(
            static fn ($detail) => (int) ($detail['menu_id'] ?? 0),
            $detailMenu
        )));

        if (!empty($menuIds)) {
            $menus = $this->menuGiziModel
                ->whereIn('id', $menuIds)
                ->where('id_sppg', session('id_sppg'))
                ->findAll();

            foreach ($menus as $menu) {
                $menuMap[(int) $menu['id']] = $menu;
            }
        }

        // Ambil komposisi seluruh menu yang dipakai dalam rencana ini
        // sekaligus agar halaman detail tidak melakukan query berulang.
        $komposisiMenu = [];
        if (!empty($menuIds)) {
            $komposisiRows = $this->menuKomposisiModel
                ->whereIn('menu_id', $menuIds)
                ->orderBy('menu_id', 'ASC')
                ->orderBy('id', 'ASC')
                ->findAll();

            foreach ($komposisiRows as $komposisi) {
                $komposisiMenu[(int) $komposisi['menu_id']][] = $komposisi;
            }
        }

        foreach ($detailMenu as &$detail) {
            $menuId = (int) ($detail['menu_id'] ?? 0);
            $menu = $menuMap[$menuId] ?? null;

            $detail['nama_menu'] = $menu['nama_menu'] ?? 'Menu tidak ditemukan';
            $detail['kategori'] = $menu['kategori'] ?? '';
            $detail['foto_menu'] = $menu['foto_menu'] ?? '';
            $menuMap[$menuId] = $detail['nama_menu'];
        }
        unset($detail);

        $penerima = $this->rencanaMenuPenerimaModel
            ->where('rencana_menu_id', $id)
            ->orderBy('sekolah_nama', 'ASC')
            ->findAll();

        $assignment = [];

        foreach ($penerima as $pm) {
            $assignment[$pm['id']] = $this->rencanaMenuPenerimaDetailModel
                ->where('rencana_menu_penerima_id', $pm['id'])
                ->findAll();

            foreach ($assignment[$pm['id']] as &$item) {
                $item['nama_menu'] = $menuMap[$item['menu_id']] ?? ($item['nama_menu'] ?? 'Menu');
            }
        }

        $coverage = $this->buildCoverage($penerima, $assignment);

        return view('gizi/rencana_menu/detail', [
            'title'      => 'Detail Rencana Menu',
            'rencana'    => $rencana,
            'detailMenu'     => $detailMenu,
            'komposisiMenu' => $komposisiMenu,
            'penerima'      => $penerima,
            'assignment' => $assignment,
            'coverage'   => $coverage,
        ]);
    }

    /**
     * Cetak PDF rencana menu yang sudah ditetapkan.
     * PDF berisi rekap produksi, komposisi menu, dan rincian penerima.
     */
    public function pdf($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] !== 'ditetapkan') {
            return redirect()
                ->to(base_url('gizi/rencana-menu/detail/' . $id))
                ->with('error', 'PDF hanya dapat dicetak untuk rencana menu yang sudah ditetapkan.');
        }

        $detailMenu = $this->rencanaMenuDetailModel
            ->where('rencana_menu_id', $id)
            ->orderBy('id', 'ASC')
            ->findAll();

        $menuIds = array_values(array_unique(array_map(
            static fn ($row) => (int) ($row['menu_id'] ?? 0),
            $detailMenu
        )));

        $menuMap = [];
        $komposisiMenu = [];

        if (!empty($menuIds)) {
            $menus = $this->menuGiziModel
                ->whereIn('id', $menuIds)
                ->where('id_sppg', session('id_sppg'))
                ->findAll();

            foreach ($menus as $menu) {
                $menuMap[(int) $menu['id']] = $menu;
            }

            $komposisiRows = $this->menuKomposisiModel
                ->whereIn('menu_id', $menuIds)
                ->orderBy('menu_id', 'ASC')
                ->orderBy('id', 'ASC')
                ->findAll();

            foreach ($komposisiRows as $row) {
                $komposisiMenu[(int) $row['menu_id']][] = $row;
            }
        }

        $menuSummary = [];
        foreach ($detailMenu as $detail) {
            $menuId = (int) ($detail['menu_id'] ?? 0);
            $menu = $menuMap[$menuId] ?? [];

            $menuSummary[$menuId] = [
                'menu_id'          => $menuId,
                'nama_menu'        => $menu['nama_menu'] ?? ($detail['nama_menu'] ?? 'Menu'),
                'kategori'         => $menu['kategori'] ?? '',
                'jenis_penggunaan' => $detail['jenis_penggunaan'] ?? 'normal',
                'catatan'          => $detail['catatan'] ?? '',
                'komposisi'        => $komposisiMenu[$menuId] ?? [],
                'target_normal'    => 0,
                'target_alergi'    => 0,
                'total_target'     => 0,
            ];
        }

        $penerima = $this->rencanaMenuPenerimaModel
            ->where('rencana_menu_id', $id)
            ->orderBy('sekolah_nama', 'ASC')
            ->findAll();

        $assignment = [];
        $totalNormal = 0;
        $totalAlergi = 0;

        foreach ($penerima as $pm) {
            $assignment[$pm['id']] = $this->rencanaMenuPenerimaDetailModel
                ->where('rencana_menu_penerima_id', $pm['id'])
                ->orderBy('id', 'ASC')
                ->findAll();

            foreach ($assignment[$pm['id']] as &$item) {
                $menuId = (int) ($item['menu_id'] ?? 0);
                $item['nama_menu'] = $menuMap[$menuId]['nama_menu'] ?? ($item['nama_menu'] ?? 'Menu');

                if (!isset($menuSummary[$menuId])) {
                    $menuSummary[$menuId] = [
                        'menu_id'          => $menuId,
                        'nama_menu'        => $item['nama_menu'],
                        'kategori'         => '',
                        'jenis_penggunaan' => $item['jenis_penggunaan'] ?? 'normal',
                        'catatan'          => $item['catatan'] ?? '',
                        'komposisi'        => $komposisiMenu[$menuId] ?? [],
                        'target_normal'    => 0,
                        'target_alergi'    => 0,
                        'total_target'     => 0,
                    ];
                }

                $target = (int) ($item['total_target'] ?? 0);
                $jenis = $item['jenis_penggunaan'] ?? 'normal';

                if ($jenis === 'alergi') {
                    $menuSummary[$menuId]['target_alergi'] += $target;
                    $totalAlergi += $target;
                } else {
                    $menuSummary[$menuId]['target_normal'] += $target;
                    $totalNormal += $target;
                }

                $menuSummary[$menuId]['total_target'] += $target;
            }
            unset($item);
        }

        $menuSummary = array_values($menuSummary);
        $sppg = (new SppgModel())
            ->where('id_sppg', session('id_sppg'))
            ->first() ?? [];

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $html = view('gizi/rencana_menu/pdf', [
            'rencana'       => $rencana,
            'sppg'          => $sppg,
            'menuSummary'   => $menuSummary,
            'penerima'      => $penerima,
            'assignment'    => $assignment,
            'totalNormal'   => $totalNormal,
            'totalAlergi'   => $totalAlergi,
            'totalProduksi' => $totalNormal + $totalAlergi,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream(
            'rencana-menu-' . date('Y-m-d', strtotime($rencana['tanggal'])) . '.pdf',
            ['Attachment' => false]
        );

        exit;
    }

    /**
     * Batalkan rencana yang sudah ditetapkan tanpa menghapus data.
     * Rencana yang dibatalkan tetap menjadi histori dan tidak dapat diedit.
     */
    public function batalkan($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] === 'dibatalkan') {
            return redirect()->back()->with('error', 'Rencana menu sudah dibatalkan.');
        }

        if ($rencana['status'] !== 'ditetapkan') {
            return redirect()->back()->with('error', 'Hanya rencana yang sudah ditetapkan yang dapat dibatalkan.');
        }

        $alasan = trim((string) $this->request->getPost('alasan_pembatalan'));

        if ($alasan === '') {
            return redirect()->back()->with('error', 'Alasan pembatalan wajib diisi.');
        }

        $updated = $this->rencanaMenuModel->update($id, [
            'status'             => 'dibatalkan',
            'dibatalkan_at'      => date('Y-m-d H:i:s'),
            'dibatalkan_by'      => session('user_id'),
            'alasan_pembatalan'  => $alasan,
        ]);

        if (!$updated) {
            log_message('error', 'RencanaMenu::batalkan gagal ID {id}: {error}', [
                'id'    => $id,
                'error' => json_encode($this->rencanaMenuModel->errors()),
            ]);

            return redirect()->back()->with('error', 'Rencana menu gagal dibatalkan.');
        }

        return redirect()
            ->to(base_url('gizi/rencana-menu/detail/' . $id))
            ->with('success', 'Rencana menu berhasil dibatalkan. Data lama tetap tersimpan sebagai riwayat.');
    }

    public function delete($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] !== 'draft') {
            return redirect()->back()->with('error', 'Hanya rencana draft yang dapat dihapus.');
        }

        $db = db_connect();
        $db->transStart();

        $this->clearAssignments($id);
        $this->rencanaMenuDetailModel
            ->where('rencana_menu_id', $id)
            ->delete();

        $this->rencanaMenuModel->delete($id);

        $db->transComplete();

        return redirect()
            ->to(base_url('gizi/rencana-menu'))
            ->with(
                $db->transStatus() === false ? 'error' : 'success',
                $db->transStatus() === false
                    ? 'Rencana menu gagal dihapus.'
                    : 'Rencana menu berhasil dihapus.'
            );
    }

    public function tetapkan($id)
    {
        $rencana = $this->getRencana($id);

        if (!$rencana) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($rencana['status'] !== 'draft') {
            return redirect()->back()->with('error', 'Hanya rencana Draft yang dapat ditetapkan.');
        }

        $jumlahMenu = $this->rencanaMenuDetailModel
            ->where('rencana_menu_id', $id)
            ->countAllResults();

        if ($jumlahMenu === 0) {
            return redirect()->back()->with('error', 'Rencana belum memiliki menu.');
        }

        $penerima = $this->rencanaMenuPenerimaModel
            ->where('rencana_menu_id', $id)
            ->findAll();

        $assignment = [];

        foreach ($penerima as $pm) {
            $assignment[$pm['id']] = $this->rencanaMenuPenerimaDetailModel
                ->where('rencana_menu_penerima_id', $pm['id'])
                ->findAll();
        }

        $coverage = $this->buildCoverage($penerima, $assignment);

        if ($coverage['belum'] > 0) {
            return redirect()->back()->with(
                'error',
                'Rencana belum lengkap. Masih ada ' . number_format($coverage['belum']) . ' PM yang belum mendapatkan menu.'
            );
        }

        if ($coverage['lebih'] > 0) {
            return redirect()->back()->with(
                'error',
                'Rencana tidak dapat ditetapkan karena terdapat ' . number_format($coverage['lebih']) . ' PM yang terhitung ganda.'
            );
        }

        $this->rencanaMenuModel->update($id, [
            'status'        => 'ditetapkan',
            'ditetapkan_at' => date('Y-m-d H:i:s'),
            'ditetapkan_by' => session('user_id'),
        ]);

        return redirect()
            ->to(base_url('gizi/rencana-menu/detail/' . $id))
            ->with('success', 'Rencana menu berhasil ditetapkan.');
    }

    private function formData(?int $rencanaId = null): array
    {
        $idSppg = session('id_sppg');

        $menu = $this->menuGiziModel
            ->where('id_sppg', $idSppg)
            ->orderBy('nama_menu', 'ASC')
            ->findAll();

        // Komposisi ditampilkan di kartu menu, tetapi detail hanya dibuka
        // setelah menu dipilih oleh petugas.
        $komposisiMenu = [];
        foreach ($menu as $item) {
            $komposisi = $this->menuKomposisiModel
                ->where('menu_id', (int) $item['id'])
                ->orderBy('id', 'ASC')
                ->findAll();

            $komposisiMenu[(int) $item['id']] = $komposisi;
        }

        $penerima = $this->penerimaManfaatModel
            ->where('id_sppg', $idSppg)
            ->orderBy('sekolah_nama', 'ASC')
            ->findAll();

        foreach ($penerima as &$pm) {
            $alergi = $this->pmKelasModel
                ->selectSum('jumlah_alergi')
                ->where('pm_id', $pm['id'])
                ->first();

            $pm['jumlah_alergi'] = (int) ($alergi['jumlah_alergi'] ?? 0);
            $pm['total_pm'] = (int) ($pm['total_siswa'] ?? 0);
            $pm['normal_pm'] = max(0, $pm['total_pm'] - $pm['jumlah_alergi']);
            $pm['catatan_alergi'] = $this->getCatatanAlergi((int) $pm['id']);
        }

        $detailMenu = [];
        $assignment = [];

        if ($rencanaId !== null) {
            $detailMenu = $this->rencanaMenuDetailModel
                ->where('rencana_menu_id', $rencanaId)
                ->findAll();

            $rows = $this->rencanaMenuPenerimaModel
                ->where('rencana_menu_id', $rencanaId)
                ->findAll();

            foreach ($rows as $row) {
                $assignment[$row['pm_id']] = [];

                $details = $this->rencanaMenuPenerimaDetailModel
                    ->where('rencana_menu_penerima_id', $row['id'])
                    ->findAll();

                foreach ($details as $detail) {
                    $assignment[$row['pm_id']][$detail['menu_id']] = [
                        'target' => (int) $detail['total_target'],
                        'jenis'  => $detail['jenis_penggunaan'],
                        'catatan'=> $detail['catatan'] ?? '',
                    ];
                }
            }
        }

        return compact('menu', 'komposisiMenu', 'penerima', 'detailMenu', 'assignment');
    }

    private function getRencana($id): ?array
    {
        return $this->rencanaMenuModel
            ->where('id', $id)
            ->where('id_sppg', session('id_sppg'))
            ->first();
    }

    private function normalizePost(): array
    {
        $menuIds = $this->request->getPost('menu_id');
        $jenis = $this->request->getPost('jenis_penggunaan') ?? [];
        $catatan = $this->request->getPost('catatan_menu') ?? [];
        $penerima = $this->request->getPost('penerima') ?? [];
        $target = $this->request->getPost('target') ?? [];

        $menus = [];

        if (is_array($menuIds)) {
            foreach ($menuIds as $menuId) {
                $menuId = (int) $menuId;

                if ($menuId <= 0) {
                    continue;
                }

                $jenisMenu = $jenis[$menuId] ?? 'normal';

                if (!in_array($jenisMenu, ['normal', 'alergi'], true)) {
                    $jenisMenu = 'normal';
                }

                $menus[$menuId] = [
                    'jenis'   => $jenisMenu,
                    'catatan' => trim((string) ($catatan[$menuId] ?? '')),
                ];
            }
        }

        $assignments = [];

        foreach ($menus as $menuId => $menu) {
            $selected = $penerima[$menuId] ?? [];

            if (!is_array($selected)) {
                continue;
            }

            foreach ($selected as $pmId) {
                $pmId = (int) $pmId;

                if ($pmId <= 0) {
                    continue;
                }

                $postedTarget = (int) ($target[$menuId][$pmId] ?? 0);

                $assignments[$pmId][$menuId] = [
                    'target' => max(0, $postedTarget),
                    'jenis'  => $menu['jenis'],
                    'catatan'=> $menu['catatan'],
                ];
            }
        }

        return [
            'menus'       => $menus,
            'assignments' => $assignments,
        ];
    }

    private function validateAssignments(array $payload): ?string
    {
        $pmMap = [];

        $penerima = $this->penerimaManfaatModel
            ->where('id_sppg', session('id_sppg'))
            ->findAll();

        foreach ($penerima as $pm) {
            $alergi = $this->pmKelasModel
                ->selectSum('jumlah_alergi')
                ->where('pm_id', $pm['id'])
                ->first();

            $pmMap[(int) $pm['id']] = [
                'total'   => (int) ($pm['total_siswa'] ?? 0),
                'alergi'  => (int) ($alergi['jumlah_alergi'] ?? 0),
                'normal'  => max(
                    0,
                    (int) ($pm['total_siswa'] ?? 0) -
                    (int) ($alergi['jumlah_alergi'] ?? 0)
                ),
            ];
        }

        foreach ($payload['assignments'] as $pmId => $menus) {
            if (!isset($pmMap[$pmId])) {
                return 'Terdapat penerima manfaat yang tidak valid.';
            }

            $normal = 0;
            $alergi = 0;

            foreach ($menus as $menuId => $assignment) {
                $target = (int) $assignment['target'];

                if ($target <= 0) {
                    continue;
                }

                if ($assignment['jenis'] === 'normal') {
                    $normal += $target;

                    if ($target !== $pmMap[$pmId]['normal']) {
                        return 'Target menu normal untuk penerima manfaat ID ' . $pmId .
                            ' harus sama dengan jumlah PM tanpa alergi (' .
                            $pmMap[$pmId]['normal'] . ').';
                    }
                } else {
                    $alergi += $target;

                    if ($target > $pmMap[$pmId]['alergi']) {
                        return 'Target menu alergi melebihi jumlah PM alergi pada salah satu penerima manfaat.';
                    }
                }
            }

            if ($normal > $pmMap[$pmId]['normal']) {
                return 'Pembagian menu normal melebihi jumlah PM tanpa alergi.';
            }

            if ($alergi > $pmMap[$pmId]['alergi']) {
                return 'Pembagian menu alergi melebihi jumlah PM alergi.';
            }

            if (($normal + $alergi) > $pmMap[$pmId]['total']) {
                return 'Total menu untuk salah satu penerima manfaat melebihi jumlah PM.';
            }
        }

        return null;
    }

    private function saveAssignments(int $rencanaId, array $payload): void
    {
        $pmIds = array_keys($payload['assignments']);

        foreach ($pmIds as $pmId) {
            $pm = $this->penerimaManfaatModel
                ->where('id', $pmId)
                ->where('id_sppg', session('id_sppg'))
                ->first();

            if (!$pm) {
                continue;
            }

            $alergi = $this->pmKelasModel
                ->selectSum('jumlah_alergi')
                ->where('pm_id', $pmId)
                ->first();

            $totalAlergi = (int) ($alergi['jumlah_alergi'] ?? 0);

            $assignments = $payload['assignments'][$pmId] ?? [];

            $positiveAssignments = array_filter(
                $assignments,
                static fn ($item) => (int) ($item['target'] ?? 0) > 0
            );

            if (empty($positiveAssignments)) {
                continue;
            }

            $penerimaId = $this->rencanaMenuPenerimaModel->insert([
                'rencana_menu_id' => $rencanaId,
                'pm_id'          => $pmId,
                'sekolah_nama'   => $pm['sekolah_nama'],
                'kategori'       => $pm['kategori'] ?? null,
                'sub_kategori'   => $pm['sub_kategori'] ?? null,
                'porsi_besar'    => (int) ($pm['porsi_besar'] ?? 0),
                'porsi_kecil'    => (int) ($pm['porsi_kecil'] ?? 0),
                'total_pm'       => (int) ($pm['total_siswa'] ?? 0),
                'jumlah_alergi'  => $totalAlergi,
                'catatan_alergi' => $this->getCatatanAlergi($pmId),
                'catatan'       => null,
            ], true);

            foreach ($positiveAssignments as $menuId => $assignment) {
                $menu = $this->menuGiziModel
                    ->where('id', $menuId)
                    ->where('id_sppg', session('id_sppg'))
                    ->first();

                if (!$menu) {
                    continue;
                }

                $target = (int) $assignment['target'];
                $jenis = $assignment['jenis'];

                $this->rencanaMenuPenerimaDetailModel->insert([
                    'rencana_menu_penerima_id' => $penerimaId,
                    'menu_id'                 => $menuId,
                    'nama_menu'               => $menu['nama_menu'],
                    'jenis_penggunaan'        => $jenis,
                    'target_porsi_besar'      => 0,
                    'target_porsi_kecil'      => 0,
                    'total_target'            => $target,
                    'catatan'                 => $assignment['catatan'] ?: null,
                ]);
            }
        }

        foreach ($payload['menus'] as $menuId => $menu) {
            $exists = $this->rencanaMenuDetailModel
                ->where('rencana_menu_id', $rencanaId)
                ->where('menu_id', $menuId)
                ->first();

            if (!$exists) {
                $this->rencanaMenuDetailModel->insert([
                    'rencana_menu_id'  => $rencanaId,
                    'menu_id'          => $menuId,
                    'jenis_penggunaan' => $menu['jenis'],
                    'catatan'          => $menu['catatan'] ?: null,
                ]);
            }
        }
    }

    private function clearAssignments(int $rencanaId): void
    {
        $penerima = $this->rencanaMenuPenerimaModel
            ->where('rencana_menu_id', $rencanaId)
            ->findAll();

        foreach ($penerima as $row) {
            $this->rencanaMenuPenerimaDetailModel
                ->where('rencana_menu_penerima_id', $row['id'])
                ->delete();
        }

        $this->rencanaMenuPenerimaModel
            ->where('rencana_menu_id', $rencanaId)
            ->delete();
    }

    private function getCatatanAlergi(int $pmId): ?string
    {
        $rows = $this->pmKelasModel
            ->where('pm_id', $pmId)
            ->where('jumlah_alergi >', 0)
            ->findAll();

        $catatan = [];

        foreach ($rows as $row) {
            $text = trim((string) ($row['catatan_alergi'] ?? ''));

            if ($text !== '') {
                $catatan[] = ($row['nama_kelas'] ?? 'Kelompok') . ': ' . $text;
            }
        }

        return empty($catatan) ? null : implode(' | ', $catatan);
    }

    private function buildCoverage(array $penerima, array $assignment): array
    {
        $belum = 0;
        $lebih = 0;
        $total = 0;
        $assigned = 0;

        foreach ($penerima as $pm) {
            $totalPm = (int) ($pm['total_pm'] ?? 0);
            $total += $totalPm;

            $jumlah = 0;

            foreach ($assignment[$pm['id']] ?? [] as $item) {
                $jumlah += (int) ($item['total_target'] ?? 0);
            }

            $assigned += $jumlah;

            if ($jumlah < $totalPm) {
                $belum += $totalPm - $jumlah;
            }

            if ($jumlah > $totalPm) {
                $lebih += $jumlah - $totalPm;
            }
        }

        return [
            'total'    => $total,
            'assigned' => $assigned,
            'belum'    => $belum,
            'lebih'    => $lebih,
        ];
    }
}
