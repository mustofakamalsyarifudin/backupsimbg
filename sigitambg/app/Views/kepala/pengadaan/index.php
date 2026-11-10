<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
<div class="container">
<style>
.kepala-pengadaan-page .card { border-radius: 14px; }
.kepala-pengadaan-page .table-card-body { padding: .75rem; }
.badge-status-draft{background:#6b7280!important;color:#fff!important;}
.badge-status-waiting-finance{background:#f59e0b!important;color:#fff!important;}
.badge-status-rejected-finance{background:#ef4444!important;color:#fff!important;}
.badge-status-waiting-kepala{background:#7c3aed!important;color:#fff!important;}
.badge-status-rejected-kepala{background:#ef4444!important;color:#fff!important;}
.badge-status-waiting-koperasi{background:#0ea5e9!important;color:#fff!important;}
.badge-status-procurement{background:#2563eb!important;color:#fff!important;}
.badge-status-completed{background:#22c55e!important;color:#fff!important;}
.badge-status-unknown{background:#6b7280!important;color:#fff!important;}
#tableKepala { min-width: 760px; }
#tableKepala th, #tableKepala td { white-space: nowrap; }
#tableKepala th:nth-child(2), #tableKepala td:nth-child(2) { white-space: normal; min-width: 190px; }
#tableKepala th:nth-child(3), #tableKepala td:nth-child(3) { min-width: 180px; }
@media (min-width: 768px) { .kepala-pengadaan-page .table-card-body { padding: 1rem; } }
@media (max-width: 575.98px) {
    .kepala-pengadaan-page .page-title-row { gap: .75rem; align-items: flex-start!important; }
    .kepala-pengadaan-page .page-title-row h5 { font-size: 1rem; }
    .kepala-pengadaan-page .page-title-row .btn { flex-shrink: 0; }
    .kepala-pengadaan-page .filter-card .card-body { padding: .75rem; }
    .kepala-pengadaan-page .table-card-body { padding: .5rem; }
}
</style>
<div class="d-flex justify-content-between align-items-center mb-3 page-title-row">
    <div><h5 class="mb-1">Approval Pengadaan Bahan</h5><small class="text-muted"><?= esc($sppg_name) ?></small></div>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-danger btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if(session()->getFlashdata('success')):?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif;?>
<?php if(session()->getFlashdata('error')):?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif;?>
<div class="card border-0 shadow-sm mb-3 filter-card">
 <div class="card-body p-3">
  <form class="row g-2">
   <div class="col-12 col-md-6"><input name="q" value="<?= esc($q) ?>" class="form-control" placeholder="Cari kode transaksi/catatan..."></div>
   <div class="col-12 col-md-4"><select name="status" class="form-select"><option value="">Semua status</option><?php foreach(['waiting_kepala'=>'Menunggu Approval Kepala','rejected_kepala'=>'Dikembalikan Kepala','waiting_koperasi'=>'Menunggu Koperasi','procurement'=>'Diproses Koperasi','completed'=>'Selesai'] as $v=>$label):?><option value="<?= $v ?>" <?= $status===$v?'selected':'' ?>><?= $label ?></option><?php endforeach;?></select></div>
   <div class="col-12 col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
  </form>
 </div>
</div>
<div class="card border-0 shadow-sm kepala-pengadaan-page">
 <div class="table-card-body">
  <div class="table-responsive">
   <table class="table table-sm table-hover align-middle mb-0" id="tableKepala">
    <thead><tr><th>Tanggal</th><th>Kode</th><th>Status</th><th>Total</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r):
 $currentStatus=trim((string)($r['status']??'')); if($currentStatus==='')$currentStatus='draft';
 $badge=match($currentStatus){'draft'=>'badge-status-draft','waiting_finance'=>'badge-status-waiting-finance','rejected_finance'=>'badge-status-rejected-finance','waiting_kepala'=>'badge-status-waiting-kepala','rejected_kepala'=>'badge-status-rejected-kepala','waiting_koperasi'=>'badge-status-waiting-koperasi','procurement'=>'badge-status-procurement','completed'=>'badge-status-completed',default=>'badge-status-unknown'};
 $label=match($currentStatus){'draft'=>'Draft','waiting_finance'=>'Menunggu Keuangan','rejected_finance'=>'Ditolak Keuangan','waiting_kepala'=>'Menunggu Approval Kepala','rejected_kepala'=>'Dikembalikan Kepala','waiting_koperasi'=>'Menunggu Koperasi','procurement'=>'Diproses Koperasi','completed'=>'Selesai',default=>ucwords(str_replace('_',' ',$currentStatus))};
?>
<tr><td><?= date('d/m/Y',strtotime($r['tanggal'])) ?></td><td><?= esc($r['kode_transaksi']) ?></td><td><span class="badge <?= $badge ?>"><?= esc($label) ?></span></td><td>Rp <?= number_format($r['grand_total'],0,',','.') ?></td><td><a class="btn btn-primary btn-sm" href="<?= base_url('kepala/pengadaan/detail/'.$r['id']) ?>"><i class="bi bi-eye"></i> <span class="d-none d-sm-inline">Detail</span></a></td></tr>
<?php endforeach; ?></tbody></table>
  </div>
 </div>
</div>
</div></div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
<script>document.addEventListener('DOMContentLoaded',()=>{const t=document.querySelector('#tableKepala');if(t)new DataTable(t,{searchable:true,fixedHeight:false,perPage: 10, perPageSelect: [5, 10, 25, 50, 100]});});</script>
<?= $this->endSection() ?>
