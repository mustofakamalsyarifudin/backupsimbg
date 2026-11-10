<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
<div class="container-fluid px-3 px-lg-4" style="max-width:1400px;margin:auto">
<style>
.invoice-paper{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:clamp(1rem,3vw,2.5rem)}
.invoice-table th,.invoice-table td{vertical-align:middle}
@page{size:A4 portrait;margin:12mm}
@media print{
  /* Hilangkan seluruh kerangka aplikasi saat mencetak; hanya invoice yang terlihat. */
  html,body{background:#fff!important;margin:0!important;padding:0!important;width:100%!important;min-height:0!important}
  body *{visibility:hidden!important}
  .invoice-paper,.invoice-paper *{visibility:visible!important}
  .invoice-paper{position:absolute!important;left:0!important;top:0!important;width:100%!important;max-width:none!important;margin:0!important;padding:0!important;border:0!important;border-radius:0!important;box-shadow:none!important;background:#fff!important}
  .page-content-wrapper,.container-fluid{display:block!important;width:100%!important;max-width:none!important;margin:0!important;padding:0!important}
  .no-print,header,nav,footer,.footer-nav,.navbar,.fixed-bottom,.fixed-top{display:none!important}
  .table-responsive{overflow:visible!important}
  .invoice-table{width:100%!important;border-collapse:collapse!important;font-size:10pt!important}
  .invoice-table th,.invoice-table td{padding:5px!important}
  .invoice-paper .border-bottom{break-inside:avoid}
  .invoice-paper tr{break-inside:avoid}
  .invoice-paper .alert{border:1px solid #ddd!important;background:#fff!important;color:#333!important}
  *{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important}
}
</style>
<div class="d-flex justify-content-between align-items-center gap-2 mb-3 no-print">
 <div><h5 class="mb-1">Invoice Pembayaran Koperasi</h5><small class="text-muted">Tagihan atas pengadaan yang sudah selesai</small></div>
 <div class="d-flex gap-2"><button class="btn btn-primary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak / Simpan PDF</button><a class="btn btn-outline-secondary btn-sm" href="<?= base_url('keuangan/pengadaan/detail/'.$row['id']) ?>">Kembali</a></div>
</div>
<div class="invoice-paper shadow-sm">
 <div class="row g-3 pb-4 border-bottom">
  <div class="col-sm-7"><h3 class="fw-bold mb-1">INVOICE</h3><div class="text-muted">Tagihan Pembayaran Pengadaan Bahan</div><div class="mt-3 fw-semibold">Kepada:</div><div><?= esc($sppg_name) ?></div><?php if(!empty($row['sppg_address'])): ?><div class="text-muted small"><?= nl2br(esc($row['sppg_address'])) ?></div><?php endif; ?></div>
  <div class="col-sm-5 text-sm-end"><div class="text-muted small">Nomor Invoice</div><div class="fs-5 fw-bold"><?= esc($invoice_number) ?></div><div class="text-muted small mt-2">Nomor Pengadaan</div><div class="fw-semibold"><?= esc($row['kode_transaksi']) ?></div><div class="text-muted small mt-2">Tanggal Pengadaan</div><div><?= !empty($row['tanggal']) ? date('d/m/Y',strtotime($row['tanggal'])) : '-' ?></div><div class="text-muted small mt-2">Nomor Pembelian Koperasi</div><div><?= esc($purchase['no_pembelian'] ?? '-') ?></div></div>
 </div>
 <div class="table-responsive mt-4"><table class="table table-bordered invoice-table">
  <thead class="table-light"><tr><th style="width:48px">No.</th><th>Nama Bahan</th><th>Qty Dibeli</th><th>Satuan</th><th class="text-end">Harga Satuan</th><th class="text-end">Jumlah</th></tr></thead><tbody>
  <?php if(!empty($details)): foreach($details as $i=>$d): ?>
   <tr><td><?= $i+1 ?></td><td><?= esc($d['nama_bahan'] ?? '-') ?></td><td><?= number_format((float)($d['qty_dibeli'] ?? 0),2,',','.') ?></td><td><?= esc($d['satuan'] ?? '-') ?></td><td class="text-end">Rp <?= number_format((float)($d['harga_satuan'] ?? 0),0,',','.') ?></td><td class="text-end">Rp <?= number_format((float)($d['total_harga'] ?? 0),0,',','.') ?></td></tr>
  <?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted">Tidak ada rincian pembelian.</td></tr><?php endif; ?>
  </tbody><tfoot><tr><th colspan="5" class="text-end">TOTAL TAGIHAN</th><th class="text-end fs-6">Rp <?= number_format((float)$invoice_total,0,',','.') ?></th></tr></tfoot>
 </table></div>
 <div class="row mt-4 g-3"><div class="col-md-7"><div class="fw-semibold">Catatan</div><div class="text-muted small"><?= !empty($purchase['catatan']) ? nl2br(esc($purchase['catatan'])) : 'Invoice ini diterbitkan berdasarkan data pembelian koperasi pada SIGITA.' ?></div><div class="alert alert-warning small mt-3 mb-0"><strong>Status:</strong> Pengadaan selesai. Invoice ini menjadi acuan jumlah tagihan yang perlu dibayarkan kepada koperasi; status pembayaran belum dicatat melalui halaman ini.</div></div><div class="col-md-5 text-md-center"><div class="mb-5">Hormat kami,</div><div class="fw-semibold">Koperasi</div><small class="text-muted">Penerbit tagihan</small></div></div>
</div>
</div></div>
<?= $this->endSection() ?>
