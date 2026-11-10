<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
        <div><h5 class="mb-1 fw-bold"><?= esc($koperasi['nama_koperasi']) ?></h5><small class="text-muted"># <?= esc($koperasi['kode_koperasi']) ?> · Atur SPPG yang menjadi tanggung jawab koperasi untuk harga pokok barang.</small></div>
        <div class="d-flex gap-2"><a href="<?= base_url('super-admin/koperasi') ?>" class="btn btn-light border rounded-3">← Kembali</a><a href="<?= base_url('super-admin/koperasi/edit/'.$koperasi['id']) ?>" class="btn btn-outline-primary rounded-3">Edit Koperasi</a></div>
    </div>
    <?php if ($m = session()->getFlashdata('success')): ?><div class="alert alert-success rounded-3"><?= esc($m) ?></div><?php endif; ?>
    <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-3"><?= esc($m) ?></div><?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-3"><div class="card-body p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-end">
            <div><h6 class="fw-bold mb-1">SPPG yang Ditangani</h6><small class="text-muted">Centang satu atau beberapa SPPG. Perubahan ini menentukan cakupan koperasi untuk pengelolaan HPP.</small></div>
            <div class="col-md-4"><label class="form-label small text-muted">Cari SPPG</label><input id="searchSppg" class="form-control rounded-3" placeholder="Cari nama atau ID SPPG..."></div>
        </div>
        <form method="post" action="<?= base_url('super-admin/koperasi/assign/'.$koperasi['id']) ?>" id="assignForm">
            <?= csrf_field() ?>
            <div class="d-flex gap-2 mt-3 mb-2"><button type="button" class="btn btn-light border btn-sm rounded-3" id="selectAll">Pilih Semua</button><button type="button" class="btn btn-light border btn-sm rounded-3" id="clearAll">Kosongkan</button><span class="badge bg-primary rounded-pill align-self-center" id="selectedCount">0 SPPG dipilih</span></div>
            <div class="row g-2" id="sppgList">
                <?php foreach ($sppgs as $s): $checked = in_array((string)$s['id_sppg'], $assigned, true); ?>
                    <div class="col-md-6 sppg-item" data-search="<?= esc(strtolower($s['id_sppg'].' '.$s['sppg_name'])) ?>">
                        <label class="border rounded-3 p-3 d-flex gap-3 align-items-start h-100">
                            <input class="form-check-input sppg-check mt-1" type="checkbox" name="id_sppg[]" value="<?= esc($s['id_sppg']) ?>" <?= $checked ? 'checked' : '' ?>>
                            <span><strong><?= esc($s['sppg_name']) ?></strong><br><small class="text-muted"># <?= esc($s['id_sppg']) ?></small></span>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$sppgs): ?><div class="alert alert-warning rounded-3 mt-3 mb-0">Belum ada SPPG aktif. Tambahkan atau aktifkan SPPG terlebih dahulu.</div><?php endif; ?>
            <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary rounded-3" <?= !$sppgs ? 'disabled' : '' ?>>✓ Simpan Penugasan SPPG</button></div>
        </form>
    </div></div>

    <div class="card border-0 shadow-sm rounded-4"><div class="card-body p-3 p-md-4">
        <h6 class="fw-bold mb-1">Riwayat Penugasan</h6><small class="text-muted">SPPG yang pernah ditangani tetap tercatat untuk menjaga histori.</small>
        <div class="table-responsive mt-3"><table class="table table-hover align-middle mb-0"><thead><tr><th>SPPG</th><th>Mulai</th><th>Selesai</th><th>Status</th></tr></thead><tbody>
        <?php foreach ($rows as $r): ?><tr><td><strong><?= esc($r['sppg_name']) ?></strong><br><small class="text-muted"># <?= esc($r['id_sppg']) ?></small></td><td><?= esc($r['tanggal_mulai'] ?: '-') ?></td><td><?= esc($r['tanggal_selesai'] ?: '-') ?></td><td><span class="badge bg-<?= ($r['status'] ?? '') === 'active' ? 'success' : 'secondary' ?> rounded-pill"><?= ($r['status'] ?? '') === 'active' ? 'Aktif' : 'Nonaktif' ?></span></td></tr><?php endforeach; ?>
        <?php if (!$rows): ?><tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat penugasan.</td></tr><?php endif; ?>
        </tbody></table></div>
    </div></div>
</div></div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
(function(){
    const checks = () => Array.from(document.querySelectorAll('.sppg-check'));
    const updateCount = () => { document.getElementById('selectedCount').textContent = checks().filter(c => c.checked).length + ' SPPG dipilih'; };
    document.getElementById('selectAll')?.addEventListener('click', () => { checks().forEach(c => { if (c.closest('.sppg-item').style.display !== 'none') c.checked = true; }); updateCount(); });
    document.getElementById('clearAll')?.addEventListener('click', () => { checks().forEach(c => c.checked = false); updateCount(); });
    checks().forEach(c => c.addEventListener('change', updateCount));
    document.getElementById('searchSppg')?.addEventListener('input', function(){ const q=this.value.toLowerCase().trim(); document.querySelectorAll('.sppg-item').forEach(item => { item.style.display = !q || item.dataset.search.includes(q) ? '' : 'none'; }); });
    updateCount();
})();
</script>
<?= $this->endSection() ?>
