<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><h5 class="mb-0">Dashboard Admin</h5><small class="text-muted">Cakupan SPPG sesuai penugasan Super Admin</small></div>
    </div>
    <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
    <div class="card mb-3"><div class="card-body">
        <form method="post" action="<?= base_url('admin/select-sppg') ?>" class="row g-2 align-items-end">
            <?= csrf_field() ?><div class="col-md-9"><label class="form-label">SPPG yang dipantau</label>
            <select name="id_sppg" class="form-select"><option value="">Semua SPPG dalam cakupan</option><?php foreach ($sppgs as $s): ?><option value="<?= esc($s['id_sppg']) ?>" <?= $selected === $s['id_sppg'] ? 'selected' : '' ?>><?= esc($s['sppg_name']) ?> (<?= esc($s['id_sppg']) ?>)</option><?php endforeach; ?></select></div>
            <div class="col-md-3"><button class="btn btn-primary w-100">Tampilkan</button></div>
        </form>
    </div></div>
    <div class="row g-3 mb-3">
        <?php foreach ([['SPPG Terpantau',$summary['total_sppg'],'bi-building'],['Penerima Manfaat',$summary['total_pm'],'bi-people'],['Sekolah/Unit',$summary['total_sekolah'],'bi-mortarboard'],['Kegiatan',$summary['total_kegiatan'],'bi-calendar-check']] as $c): ?>
        <div class="col-6 col-lg-3"><div class="card h-100"><div class="card-body"><i class="bi <?= $c[2] ?> fs-3"></i><div class="text-muted small mt-2"><?= esc($c[0]) ?></div><h4 class="mb-0"><?= number_format((int)$c[1],0,',','.') ?></h4></div></div></div>
        <?php endforeach; ?>
    </div>
    <div class="card"><div class="card-body"><h6>SPPG dalam Cakupan</h6><div class="list-group list-group-flush">
    <?php foreach ($sppgs as $s): ?><a class="list-group-item list-group-item-action d-flex justify-content-between" href="<?= base_url('admin?id_sppg='.rawurlencode($s['id_sppg'])) ?>"><span><?= esc($s['sppg_name']) ?></span><small><?= esc($s['id_sppg']) ?></small></a><?php endforeach; ?>
    <?php if (!$sppgs): ?><div class="text-muted">Belum ada SPPG yang ditugaskan.</div><?php endif; ?></div></div></div>
</div></div>
<?= $this->endSection() ?>
