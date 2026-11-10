<?= $this->extend('layouts/affan') ?><?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container"><style>
.badge-status-draft{background:#6b7280!important;color:#fff!important;}.badge-status-waiting-finance{background:#f59e0b!important;color:#fff!important;}.badge-status-rejected-finance{background:#ef4444!important;color:#fff!important;}.badge-status-waiting-kepala{background:#7c3aed!important;color:#fff!important;}.badge-status-rejected-kepala{background:#ef4444!important;color:#fff!important;}.badge-status-waiting-koperasi{background:#0ea5e9!important;color:#fff!important;}.badge-status-procurement{background:#2563eb!important;color:#fff!important;}.badge-status-completed{background:#22c55e!important;color:#fff!important;}.badge-status-unknown{background:#6b7280!important;color:#fff!important;}
</style>
<?php if(session()->getFlashdata('success')):?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif;?><?php if(session()->getFlashdata('error')):?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif;?>
<div class="card border-0 shadow-sm mb-3"><div class="card-body"><div class="d-flex justify-content-between"><div><h5 class="mb-1"><?= esc($row['kode_transaksi']) ?></h5><small class="text-muted"><?= date('d/m/Y',strtotime($row['tanggal'])) ?></small></div><?php
$currentStatus = trim((string)($row['status'] ?? ''));
if ($currentStatus === '') $currentStatus = 'draft';
$badgeClass = match($currentStatus) {
    'draft' => 'badge-status-draft', 'waiting_finance' => 'badge-status-waiting-finance', 'rejected_finance' => 'badge-status-rejected-finance',
    'waiting_kepala' => 'badge-status-waiting-kepala', 'rejected_kepala' => 'badge-status-rejected-kepala', 'waiting_koperasi' => 'badge-status-waiting-koperasi',
    'procurement' => 'badge-status-procurement', 'completed' => 'badge-status-completed', default => 'badge-status-unknown'
};
$statusLabel = match($currentStatus) {
    'draft' => 'Draft', 'waiting_finance' => 'Menunggu Keuangan', 'rejected_finance' => 'Ditolak Keuangan', 'waiting_kepala' => 'Menunggu Approval Kepala',
    'rejected_kepala' => 'Dikembalikan Kepala', 'waiting_koperasi' => 'Menunggu Koperasi', 'procurement' => 'Diproses Koperasi', 'completed' => 'Selesai',
    default => ucwords(str_replace('_',' ',$currentStatus))
};
?><span class="badge <?= $badgeClass ?>"><?= esc($statusLabel) ?></span></div></div></div>
<div class="card border-0 shadow-sm mb-3"><div class="card-body"><h6>Rincian Bahan</h6><div class="table-responsive"><table class="table"><thead><tr><th>Bahan</th><th>Qty</th><th>Satuan</th><th>Harga</th><th>Total</th></tr></thead><tbody><?php foreach($details as $d):?><tr><td><?= esc($d['nama_bahan']) ?></td><td><?= esc($d['qty']) ?></td><td><?= esc($d['satuan']) ?></td><td>Rp <?= number_format((float)$d['harga'],0,',','.') ?></td><td>Rp <?= number_format((float)$d['total_harga'],0,',','.') ?></td></tr><?php endforeach;?></tbody></table></div><div class="text-end fw-bold">Total: Rp <?= number_format($grand_total,0,',','.') ?></div></div></div>
<div class="card border-0 shadow-sm mb-3"><div class="card-body"><h6>Catatan Keuangan</h6><div class="alert alert-light mb-0"><?= !empty($row['catatan_keuangan']) ? nl2br(esc($row['catatan_keuangan'])) : '<span class="text-muted">Tidak ada catatan dari Keuangan.</span>' ?></div></div></div>
<?php if($row['status']==='waiting_kepala'):?><div class="card border-0 shadow-sm"><div class="card-body"><h6>Keputusan Kepala SPPG</h6><form method="post" action="<?= base_url('kepala/pengadaan/approve/'.$row['id']) ?>" class="mb-3"><label class="form-label">Catatan Kepala <span class="text-muted">(opsional)</span></label><textarea name="catatan_approval" class="form-control mb-2" rows="3" placeholder="Catatan persetujuan atau arahan pengadaan..."></textarea><button class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Setujui & Kirim ke Koperasi</button></form><form method="post" action="<?= base_url('kepala/pengadaan/reject/'.$row['id']) ?>"><label class="form-label">Alasan Penolakan</label><textarea name="catatan_approval" class="form-control mb-2" rows="3" required placeholder="Wajib diisi jika dikembalikan ke Gizi."></textarea><button class="btn btn-outline-danger"><i class="bi bi-arrow-return-left me-1"></i>Tolak & Kembalikan ke Gizi</button></form></div></div><?php elseif(!empty($row['catatan_approval'])):?><div class="card border-0 shadow-sm"><div class="card-body"><h6>Catatan Kepala</h6><div class="alert alert-light mb-0"><?= nl2br(esc($row['catatan_approval'])) ?></div></div></div><?php endif;?>
<a href="<?= base_url('kepala/pengadaan') ?>" class="btn btn-secondary btn-sm mt-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div></div>
<?= $this->endSection() ?>
