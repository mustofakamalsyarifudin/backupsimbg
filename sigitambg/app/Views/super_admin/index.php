<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container">
<h5>Super Admin</h5><p class="text-muted">Kontrol pusat seluruh SPPG, Koperasi, Admin, dan User.</p>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="row g-3">
<?php foreach ([['SPPG',$total_sppg,'bi-building','super-admin/sppg'],['User',$total_user,'bi-people','super-admin/users'],['Koperasi',$total_koperasi,'bi-shop','super-admin/koperasi'],['Admin',$total_admin,'bi-person-gear','super-admin/users'],['Penerima Manfaat',$total_pm,'bi-mortarboard','#']] as $c): ?>
<div class="col-6 col-lg-3"><a href="<?= $c[3]==='#'?'#':base_url($c[3]) ?>" class="text-decoration-none"><div class="card h-100"><div class="card-body"><i class="bi <?= $c[2] ?> fs-3"></i><div class="text-muted small mt-2"><?= esc($c[0]) ?></div><h4><?= number_format((int)$c[1],0,',','.') ?></h4></div></div></a></div>
<?php endforeach; ?></div>
<div class="card mt-3"><div class="card-body"><h6>Administrasi</h6><div class="d-grid gap-2 d-md-flex"><a class="btn btn-primary" href="<?= base_url('super-admin/sppg') ?>">Master SPPG</a><a class="btn btn-primary" href="<?= base_url('super-admin/koperasi') ?>">Master Koperasi</a><a class="btn btn-primary" href="<?= base_url('super-admin/users') ?>">Manajemen User</a></div></div></div>
</div></div>
<?= $this->endSection() ?>
