<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
  <div class="container">

    <!-- Header Dashboard, diselaraskan dengan dashboard Gizi -->
    <div class="mb-3">
      <h5 class="mb-1">Dashboard</h5>
      <small class="text-muted">Sistem Pengelolaan Program Gizi MBG</small>
    </div>

    <!-- Kartu identitas Koperasi: mengikuti tata letak kartu Selamat Datang Gizi -->
    <div class="card border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#1d4ed8,#2563eb); border-radius:20px;">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center">
          <div class="me-3">
            <small class="text-white-50">Selamat Datang</small>
            <h4 class="text-white mb-1">Koperasi <?= esc($koperasi['nama_koperasi'] ?? '') ?></h4>
            <p class="text-white-50 mb-1">Pengelolaan harga bahan dan pelayanan request bahan dari SPPG.</p>
            <span class="badge bg-light text-primary mt-1"># <?= esc($koperasi['kode_koperasi'] ?? '') ?></span>
          </div>
          <div class="flex-shrink-0">
            <i class="bi bi-building text-white" style="font-size:60px;" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </div>

    <?php if ($m=session()->getFlashdata('success')): ?><div class="alert alert-success rounded-4"><?= esc($m) ?></div><?php endif; ?>
    <?php if ($m=session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-4"><?= esc($m) ?></div><?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-3"><div class="card-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-2"><div><h6 class="fw-bold mb-1">SPPG yang Ditangani</h6><small class="text-muted">Pilih SPPG aktif sebelum mengatur Master Bahan.</small></div><span class="badge bg-primary rounded-pill"><?= count($sppgs) ?> SPPG</span></div>
        <?php if ($sppgs): ?><form action="<?= base_url('koperasi/sppg/select') ?>" method="post" class="row g-2 align-items-end"><?= csrf_field() ?><div class="col-md-9"><select name="id_sppg" class="form-select rounded-3" required><?php foreach($sppgs as $s): ?><option value="<?= esc($s['id_sppg']) ?>" <?= (string)$activeSppg===(string)$s['id_sppg']?'selected':'' ?>><?= esc($s['sppg_name']) ?> — <?= esc($s['id_sppg']) ?></option><?php endforeach; ?></select></div><div class="col-md-3"><button class="btn btn-primary w-100 rounded-3">Pilih SPPG</button></div></form><?php else: ?><div class="alert alert-warning mb-0 rounded-3">Belum ada SPPG aktif yang ditugaskan oleh Super Admin.</div><?php endif; ?>
    </div></div>

    <div class="row g-3 mb-3"><div class="col-6 col-lg-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">SPPG Ditangani</small><div class="fs-2 fw-bold"><?= count($sppgs) ?></div></div></div></div><div class="col-6 col-lg-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">Request Menunggu</small><div class="fs-2 fw-bold text-warning"><?= $pendingRequests ?></div></div></div></div><div class="col-6 col-lg-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">Master Bahan</small><div class="fs-2 fw-bold"><?= $totalBahan ?></div></div></div></div></div>

    <div class="row g-3"><div class="col-md-4"><a href="<?=base_url('koperasi/supplier')?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-exclamation-triangle text-warning fs-1"></i><h5 class="fw-bold mt-3 mb-1">MOU Supplier</h5><p class="text-muted mb-0"><strong><?=esc($mouWarning)?></strong> akan berakhir ≤ 30 hari · <strong><?=esc($mouExpired)?></strong> sudah kedaluwarsa.</p></div></div></a></div><div class="col-md-4"><a href="<?=base_url('koperasi/supplier')?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-truck text-primary fs-1"></i><h5 class="fw-bold mt-3 mb-1">Master Supplier</h5><p class="text-muted mb-0">Kelola supplier, MOU, berkas, bahan yang disediakan, dan histori harga beli.</p></div></div></a></div><div class="col-md-4"><a href="<?= base_url('koperasi/bahan') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-box-seam text-primary fs-1"></i><h5 class="fw-bold mt-3 mb-1">Master Bahan & Harga</h5><p class="text-muted mb-0">Kelola bahan dan harga untuk SPPG yang dipilih.</p></div></div></a></div><div class="col-md-4"><a href="<?= base_url('koperasi/request-bahan') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-inbox text-success fs-1"></i><h5 class="fw-bold mt-3 mb-1">Request Bahan dari SPPG</h5><p class="text-muted mb-0">Terima atau tolak permintaan bahan baru dari SPPG.</p></div></div></a></div><div class="col-md-4"><a href="<?= base_url('koperasi/pengadaan') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-cart-check text-warning fs-1"></i><h5 class="fw-bold mt-3 mb-1">Pengadaan & Pembelian</h5><p class="text-muted mb-0">Siapkan pembelian bahan yang telah disetujui dan kirim ke SPPG.</p></div></div></a></div><div class="col-md-4"><a href="<?= base_url('koperasi/pembelian') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-receipt text-info fs-1"></i><h5 class="fw-bold mt-3 mb-1">Pembelian Koperasi</h5><p class="text-muted mb-0">Catat supplier, qty aktual, harga aktual, dan status pengiriman.</p></div></div></a></div><div class="col-md-4"><a href="<?= base_url('koperasi/laporan-pembelian') ?>" class="text-decoration-none"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body p-4"><i class="bi bi-file-earmark-bar-graph text-danger fs-1"></i><h5 class="fw-bold mt-3 mb-1">Laporan Pembelian</h5><p class="text-muted mb-0">Rekap pembelian per periode dan SPPG serta PDF laporan.</p></div></div></a></div></div>
</div></div>
<?= $this->endSection() ?>
