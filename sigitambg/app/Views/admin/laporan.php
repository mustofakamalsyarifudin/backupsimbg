<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container">
<h5>Laporan Seluruh SPPG</h5><small class="text-muted">Ringkasan lintas SPPG. Data operasional tetap terpisah berdasarkan SPPG.</small>
<div class="card mt-3"><div class="card-body"><form method="get" class="row g-2"><div class="col-md-3"><label class="form-label">Dari</label><input type="date" name="from" class="form-control" value="<?= esc($from) ?>"></div><div class="col-md-3"><label class="form-label">Sampai</label><input type="date" name="to" class="form-control" value="<?= esc($to) ?>"></div><div class="col-md-4"><label class="form-label">SPPG</label><select name="id_sppg" class="form-select"><option value="">Semua SPPG</option><?php foreach($sppgs as $s): ?><option value="<?= esc($s['id_sppg']) ?>" <?= $idSppg===$s['id_sppg']?'selected':'' ?>><?= esc($s['sppg_name']) ?></option><?php endforeach; ?></select></div><div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Tampilkan</button></div></form></div></div>
<div class="card mt-3"><div class="table-responsive"><table class="table table-sm mb-0"><thead><tr><th>SPPG</th><th>PM</th><th>Porsi Besar</th><th>Porsi Kecil</th><th>Kegiatan</th><th>Pengeluaran</th></tr></thead><tbody>
<?php foreach($summary as $r): ?><tr><td><strong><?= esc($r['sppg_name']) ?></strong><br><small><?= esc($r['id_sppg']) ?></small></td><td><?= number_format($r['total_pm']) ?></td><td><?= number_format($r['porsi_besar']) ?></td><td><?= number_format($r['porsi_kecil']) ?></td><td><?= number_format($r['kegiatan']) ?></td><td>Rp <?= number_format($r['pengeluaran'],0,',','.') ?></td></tr><?php endforeach; ?>
<?php if(!$summary): ?><tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data.</td></tr><?php endif; ?></tbody></table></div></div>
</div></div>
<?= $this->endSection() ?>
