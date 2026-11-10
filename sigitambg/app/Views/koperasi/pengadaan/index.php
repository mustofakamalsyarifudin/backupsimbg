<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5>Pengadaan Bahan dari SPPG</h5>
                <small class="text-muted">Pengajuan yang telah disetujui Kepala SPPG dan menjadi tanggung jawab Koperasi.</small>
            </div>
            <a href="<?= base_url('koperasi') ?>" class="btn btn-danger btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form class="row g-2">
                    <div class="col-md-6"><input name="q" value="<?= esc($q ?? '') ?>" class="form-control" placeholder="Cari kode transaksi/catatan..."></div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="">Semua status</option>
                            <?php foreach (['waiting_koperasi'=>'Menunggu Koperasi','procurement'=>'Sedang Diproses','completed'=>'Selesai'] as $v=>$label): ?>
                                <option value="<?= $v ?>" <?= (($status ?? '') === $v) ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-2 p-md-3">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle" id="tablePengadaanKop">
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>SPPG</th><th>Kode</th><th>Status</th><th>Total</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php foreach ($rows as $r): ?>
                                <?php
                                $currentStatus = (string) ($r['status'] ?? '');
                                $tanggal = $r['tanggal'] ?? null;
                                $id = (int) ($r['id'] ?? 0);
                                $idSppg = (string) ($r['id_sppg'] ?? '');
                                $kode = (string) ($r['kode_transaksi'] ?? '-');
                                $sppgName = (string) ($r['sppg_name'] ?? ($names[$idSppg] ?? '-'));
                                $grandTotal = (float) ($r['grand_total'] ?? 0);
                                $badge = match ($currentStatus) {
                                    'waiting_koperasi' => 'warning',
                                    'procurement' => 'primary',
                                    'completed' => 'success',
                                    default => 'secondary',
                                };
                                $label = match ($currentStatus) {
                                    'waiting_koperasi' => 'Menunggu Koperasi',
                                    'procurement' => 'Sedang Diproses',
                                    'completed' => 'Selesai',
                                    default => ucwords(str_replace('_', ' ', $currentStatus)),
                                };
                                ?>
                                <tr>
                                    <td><?= $tanggal ? date('d/m/Y', strtotime((string) $tanggal)) : '-' ?></td>
                                    <td><?= esc($sppgName) ?></td>
                                    <td><?= esc($kode) ?></td>
                                    <td><span class="badge bg-<?= $badge ?>"><?= esc($label) ?></span></td>
                                    <td>Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($id > 0): ?>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url('koperasi/pengadaan/detail/' . $id) ?>"><i class="bi bi-eye"></i> Detail</a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pengajuan yang masuk ke Koperasi.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const t = document.querySelector('#tablePengadaanKop');
    if (t) new DataTable(t, { searchable: true, fixedHeight: true, perPage: 10, perPageSelect: [5, 10, 25, 50, 100] });
});
</script>
<?= $this->endSection() ?>
