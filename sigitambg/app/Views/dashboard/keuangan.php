<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container">
<div class="mb-3"><h5 class="mb-1">Dashboard Keuangan</h5><small class="text-muted">Pengendalian pengajuan pembelian dan rekap keuangan SPPG</small></div>
<div class="card border-0 shadow-sm mb-3" style="background:linear-gradient(135deg,#1d4ed8,#2563eb);border-radius:20px"><div class="card-body p-4 text-white"><small class="text-white-50">SPPG</small><h4 class="mb-1"><?= esc($sppg_name) ?></h4><small class="text-white-50">Selamat datang, <?= esc(session('full_name')) ?></small></div></div>
<div class="row g-3 mb-3">
<?php $cards = [
    ['value' => $waiting_finance ?? 0, 'label' => 'Menunggu Pemeriksaan', 'color' => 'warning', 'icon' => 'hourglass-split'],
    ['value' => $waiting_kepala ?? 0, 'label' => 'Menunggu Kepala', 'color' => 'primary', 'icon' => 'person-check'],
    ['value' => $waiting_koperasi ?? 0, 'label' => 'Menunggu Koperasi', 'color' => 'success', 'icon' => 'truck'],
    ['value' => $total_pengeluaran ?? 0, 'label' => 'Pengeluaran Aslap', 'color' => 'danger', 'icon' => 'cash-stack', 'currency' => true],
]; ?>
<?php foreach ($cards as $c): ?>
<div class="col-6 col-md-3"><div class="card border-0 shadow-sm h-100"><div class="card-body text-center"><i class="bi bi-<?= esc($c['icon']) ?> text-<?= esc($c['color']) ?> fs-3"></i><h4 class="text-<?= esc($c['color']) ?> mt-2 mb-1"><?= !empty($c['currency']) ? 'Rp ' . number_format((float) $c['value'], 0, ',', '.') : number_format((int) $c['value']) ?></h4><small class="text-muted"><?= esc($c['label']) ?></small></div></div></div>
<?php endforeach; ?></div>
<div class="row g-3"><div class="col-12 col-md-4"><a href="<?= base_url('keuangan/pengadaan') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm h-100"><div class="card-body"><i class="bi bi-cart-check fs-2 text-primary"></i><h6 class="mt-2 mb-0">Pengajuan Pembelian</h6><small class="text-muted">Periksa, setujui, atau tolak pengajuan Gizi.</small></div></div></a></div><div class="col-12 col-md-4"><a href="<?= base_url('keuangan/petty-cash') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm h-100"><div class="card-body"><i class="bi bi-wallet2 fs-2 text-warning"></i><h6 class="mt-2 mb-0">Petty Cash</h6><small class="text-muted">Catat uang kas masuk, pengeluaran tunai, dan saldo kas.</small></div></div></a></div><div class="col-12 col-md-4"><a href="<?= base_url('keuangan/laporan') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm h-100"><div class="card-body"><i class="bi bi-file-earmark-bar-graph fs-2 text-success"></i><h6 class="mt-2 mb-0">Laporan Keuangan</h6><small class="text-muted">Lihat pengadaan, pengeluaran Aslap, dan laporan petty cash.</small></div></div></a></div></div>
</div></div>
<?= $this->endSection() ?>
