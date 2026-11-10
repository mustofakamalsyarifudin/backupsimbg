<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <h5 class="mb-1 fw-bold">Master Supplier</h5>
                <small class="text-muted">Supplier dikelola pada level Koperasi dan dapat dihubungkan ke banyak bahan.</small>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('koperasi') ?>" class="btn btn-light border rounded-3">← Kembali</a>
                <a href="<?= base_url('koperasi/supplier/create') ?>" class="btn btn-primary rounded-3"><i class="bi bi-plus-lg me-1"></i>Tambah Supplier</a>
            </div>
        </div>

        <?php if ($m = session()->getFlashdata('success')): ?><div class="alert alert-success rounded-4"><?= esc($m) ?></div><?php endif; ?>
        <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-4"><?= esc($m) ?></div><?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <form method="get" id="supplierSearchForm" class="row g-2">
                    <div class="col-md-7">
                        <label for="supplierSearch" class="form-label small fw-semibold">Cari Supplier</label>
                        <input id="supplierSearch" name="q" value="<?= esc($q) ?>" class="form-control rounded-3" placeholder="Ketik kode, nama, PIC, HP, atau email..." autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="supplierStatus" class="form-label small fw-semibold">Status</label>
                        <select id="supplierStatus" name="status" class="form-select rounded-3">
                            <option value="">Semua Status</option>
                            <option value="aktif" <?= $status === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= $status === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                        <a href="<?= base_url('koperasi/supplier') ?>" class="btn btn-light border">Reset</a>
                    </div>
                </form>
                <small class="text-muted d-block mt-2">Pencarian diperbarui otomatis saat Anda mengetik.</small>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-2 p-md-3">
                <div class="table-responsive">
                    <table class="table align-middle" id="tableSupplier">
                        <thead><tr><th>Kode</th><th>Supplier</th><th>PIC / Kontak</th><th>Wilayah</th><th>MOU</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php if ($rows): foreach ($rows as $r): $ms = $r['mou_state']; ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($r['kode_supplier']) ?></td>
                                <td><?= esc($r['nama_supplier']) ?><br><small class="text-muted"><?= esc($r['email'] ?: '-') ?></small></td>
                                <td><?= esc($r['nama_pic'] ?: '-') ?><br><small class="text-muted"><?= esc($r['no_hp'] ?: '-') ?></small></td>
                                <td><?= esc($r['kabupaten_kota'] ?: '-') ?><br><small class="text-muted"><?= esc($r['provinsi'] ?: '-') ?></small></td>
                                <td>
                                    <span class="badge bg-<?= esc($ms['class']) ?> rounded-pill"><?= esc($ms['label']) ?></span>
                                    <?php if (!empty($r['tanggal_mou_akhir'])): ?><br><small class="text-muted">s/d <?= date('d/m/Y', strtotime($r['tanggal_mou_akhir'])) ?></small><?php endif; ?>
                                </td>
                                <td><span class="badge bg-<?= ($r['status'] === 'aktif' ? 'success' : 'secondary') ?> rounded-pill"><?= esc(ucfirst($r['status'])) ?></span></td>
                                <td class="text-nowrap">
                                    <a class="btn btn-sm btn-primary" href="<?= base_url('koperasi/supplier/detail/' . $r['id']) ?>" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a class="btn btn-sm btn-outline-warning" href="<?= base_url('koperasi/supplier/edit/' . $r['id']) ?>" title="Edit"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada supplier yang sesuai dengan pencarian.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('supplierSearchForm');
    const search = document.getElementById('supplierSearch');
    const status = document.getElementById('supplierStatus');
    let timer = null;
    if (form && search) {
        search.addEventListener('input', function () {
            window.clearTimeout(timer);
            timer = window.setTimeout(() => form.requestSubmit(), 450);
        });
    }
    if (form && status) status.addEventListener('change', () => form.requestSubmit());
    const table = document.querySelector('#tableSupplier');
    if (table && typeof DataTable !== 'undefined') {
        new DataTable(table, { searchable: true, fixedHeight: true, perPage: 10, perPageSelect: [5, 10, 25, 50, 100] });
    }
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
