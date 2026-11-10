<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
<div class="container keuangan-pengadaan-container">
<style>
/* Lebarkan konten modul Keuangan tanpa memengaruhi halaman lain. */
.keuangan-pengadaan-container {
    width: calc(100% - 2rem);
    max-width: 1120px !important;
    margin-left: auto;
    margin-right: auto;
}
@media (max-width: 767.98px) {
    .keuangan-pengadaan-container {
        width: 100%;
        max-width: 100% !important;
        padding-left: .75rem;
        padding-right: .75rem;
    }
}
.keuangan-pengadaan-page .card { border-radius: 14px; }
.keuangan-pengadaan-page .table-card-body { padding: .75rem; }
.badge-status-waiting-kepala{background:#7c3aed!important;color:#fff!important;}
.pagu-over{color:#dc3545;font-weight:700;}
.pagu-safe{color:#198754;font-weight:700;}
.pagu-zero{color:#6c757d;font-weight:700;}
#tableKeuangan { min-width: 1040px; }
#tableKeuangan th, #tableKeuangan td { white-space: nowrap; }
#tableKeuangan th:nth-child(2), #tableKeuangan td:nth-child(2) { white-space: normal; min-width: 180px; }
#tableKeuangan th:nth-child(3), #tableKeuangan td:nth-child(3) { min-width: 190px; }
#tableKeuangan th:nth-child(5), #tableKeuangan td:nth-child(5) { min-width: 120px; }
#tableKeuangan th:nth-child(6), #tableKeuangan td:nth-child(6) { min-width: 150px; }
.keuangan-pengadaan-page .alert { border-radius: 12px; }
@media (min-width: 768px) { .keuangan-pengadaan-page .table-card-body { padding: 1rem; } }
@media (max-width: 575.98px) {
    .keuangan-pengadaan-page .page-title-row { gap: .75rem; align-items: flex-start!important; }
    .keuangan-pengadaan-page .page-title-row h5 { font-size: 1rem; }
    .keuangan-pengadaan-page .page-title-row .btn { flex-shrink: 0; }
    .keuangan-pengadaan-page .filter-card .card-body { padding: .75rem; }
    .keuangan-pengadaan-page .table-card-body { padding: .5rem; }
    .keuangan-pengadaan-page .alert { font-size: .78rem; }
}
</style>
<div class="d-flex justify-content-between align-items-center mb-3 page-title-row">
 <div><h5 class="mb-1">Pengajuan Pembelian Bahan</h5><small class="text-muted"><?= esc($sppg_name) ?></small></div>
 <a href="<?= base_url('dashboard') ?>" class="btn btn-danger btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if(session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if(session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="alert alert-light border shadow-sm mb-3 small">
 <div class="fw-semibold mb-1"><i class="bi bi-info-circle me-1"></i>Pagu harian</div>
 Pagu pada setiap pengajuan adalah <strong>snapshot</strong> jumlah PM dari Aslap saat Gizi mengirim pengajuan. Tarif: porsi kecil <strong>Rp8.000</strong> dan porsi besar <strong>Rp10.000</strong>. Perubahan data PM setelah snapshot tidak mengubah pagu pengajuan tersebut.
</div>
<div class="card border-0 shadow-sm mb-3 filter-card">
 <div class="card-body p-3">
  <form class="row g-2">
   <div class="col-12 col-md-6"><input name="q" value="<?= esc($q) ?>" class="form-control" placeholder="Cari kode transaksi/catatan..."></div>
   <div class="col-12 col-md-4"><select name="status" class="form-select"><option value="">Semua status</option><?php foreach(['waiting_finance'=>'Menunggu Keuangan','rejected_finance'=>'Ditolak Keuangan','waiting_kepala'=>'Menunggu Kepala','rejected_kepala'=>'Ditolak Kepala','waiting_koperasi'=>'Menunggu Koperasi','procurement'=>'Diproses Koperasi','completed'=>'Selesai'] as $v=>$label):?><option value="<?= $v ?>" <?= $status===$v?'selected':'' ?>><?= $label ?></option><?php endforeach;?></select></div>
   <div class="col-12 col-md-2"><button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
  </form>
 </div>
</div>
<div class="card border-0 shadow-sm keuangan-pengadaan-page">
 <div class="table-card-body">
  <div class="table-responsive">
   <table class="table table-sm table-hover align-middle mb-0" id="tableKeuangan">
    <thead><tr><th>Tanggal</th><th>SPPG</th><th>Pagu</th><th>Total Pengajuan</th><th>Selisih</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php if(!empty($rows)): foreach($rows as $r):
 $paguAvailable=!empty($r['pagu_available']); $pagu=$paguAvailable?(float)$r['pagu_total']:null; $total=(float)$r['grand_total']; $selisih=$r['pagu_selisih_live'];
 $status=(string)($r['status']??''); if($status==='')$status='draft';
 $statusLabel=match($status){'draft'=>'Draft','waiting_finance'=>'Menunggu Keuangan','waiting_kepala'=>'Menunggu Kepala','waiting_koperasi'=>'Menunggu Koperasi','procurement'=>'Diproses Koperasi','completed'=>'Selesai','rejected_finance'=>'Ditolak Keuangan','rejected_kepala'=>'Ditolak Kepala',default=>ucwords(str_replace('_',' ',$status))};
 $statusClass=match($status){'waiting_finance'=>'bg-warning text-dark','waiting_kepala'=>'badge-status-waiting-kepala','waiting_koperasi'=>'bg-info text-dark','procurement'=>'bg-primary','completed'=>'bg-success','rejected_finance','rejected_kepala'=>'bg-danger',default=>'bg-secondary'};
?>
<tr>
 <td><?= date('d/m/Y',strtotime($r['tanggal'])) ?></td>
 <td><?= esc($sppg_name) ?></td>
 <td><?php if($paguAvailable): ?><div class="fw-semibold">Rp <?= number_format($pagu,0,',','.') ?></div><small class="text-muted">Kecil <?= number_format((int)$r['pagu_porsi_kecil']) ?> · Besar <?= number_format((int)$r['pagu_porsi_besar']) ?></small><?php else: ?><span class="text-muted">Belum ada snapshot</span><?php endif; ?></td>
 <td class="fw-semibold">Rp <?= number_format($total,0,',','.') ?></td>
 <td><?php if($paguAvailable): ?><span class="<?= $selisih<0?'pagu-over':($selisih>0?'pagu-safe':'pagu-zero') ?>"><?= $selisih<0?'−':'' ?>Rp <?= number_format(abs($selisih),0,',','.') ?></span><small class="d-block text-muted"><?= $selisih<0?'Melebihi pagu':($selisih>0?'Sisa pagu':'Pas pagu') ?></small><?php else: ?><span class="text-muted">—</span><?php endif; ?></td>
 <td><span class="badge <?= $statusClass ?>"><?= esc($statusLabel) ?></span></td>
 <td class="text-nowrap">
  <a href="<?= base_url('keuangan/pengadaan/detail/'.$r['id']) ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> <span class="d-none d-sm-inline">Detail</span></a>
  <?php if (($r['status'] ?? '') === 'completed'): ?>
   <a href="<?= base_url('keuangan/pengadaan/invoice/'.$r['id']) ?>" class="btn btn-success btn-sm mt-1 mt-md-0"><i class="bi bi-receipt"></i> Invoice</a>
  <?php endif; ?>
 </td>
</tr>
<?php endforeach; else: ?><tr><td colspan="7" class="text-center text-muted py-4">Belum ada pengajuan pembelian.</td></tr><?php endif; ?>
</tbody></table>
  </div>
 </div>
</div>
</div></div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
<script>document.addEventListener('DOMContentLoaded',()=>{const t=document.querySelector('#tableKeuangan');if(t)new DataTable(t,{searchable:true,fixedHeight:false,perPage:10,perPageSelect:[5,10,25,50,100]});});</script>
<?= $this->endSection() ?>
