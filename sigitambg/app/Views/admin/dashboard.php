<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
<div class="container">
    <h5 class="mb-1">Dashboard Admin</h5>
    <small class="text-muted">Monitoring seluruh SPPG</small>
    <div class="row g-3 mt-2">
        <div class="col-6"><div class="card"><div class="card-body"><small>SPPG Aktif</small><h3><?= number_format($totalSppg) ?></h3></div></div></div>
        <div class="col-6"><div class="card"><div class="card-body"><small>User Aktif</small><h3><?= number_format($totalUser) ?></h3></div></div></div>
        <div class="col-6"><div class="card"><div class="card-body"><small>Total Penerima</small><h3><?= number_format($totalPM) ?></h3></div></div></div>
        <div class="col-6"><div class="card"><div class="card-body"><small>Kegiatan</small><h3><?= number_format($totalKegiatan) ?></h3></div></div></div>
    </div>
    <div class="card mt-3"><div class="card-body">
        <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-primary btn-sm">Monitoring User</a>
        <a href="<?= base_url('admin/laporan') ?>" class="btn btn-outline-primary btn-sm">Laporan Semua SPPG</a>
        <?php if (session('user_level') === 'super_admin'): ?>
            <a href="<?= base_url('super-admin/sppg') ?>" class="btn btn-primary btn-sm">Master SPPG</a>
            <a href="<?= base_url('super-admin/koperasi') ?>" class="btn btn-primary btn-sm">Master Koperasi</a>
            <a href="<?= base_url('super-admin/users') ?>" class="btn btn-primary btn-sm">Manajemen User</a>
        <?php endif; ?>
    </div></div>
</div>
</div>
<?= $this->endSection() ?>
