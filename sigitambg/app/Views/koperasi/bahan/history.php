<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container"><div class="d-flex justify-content-between align-items-center mb-3"><div><h5 class="fw-bold mb-1">Riwayat Harga</h5><small class="text-muted"><?=esc($bahan['nama_bahan'])?> · <?=esc($bahan['satuan_default'])?></small></div><a href="<?=base_url('koperasi/bahan')?>" class="btn btn-light border rounded-3">← Kembali</a></div><div class="card border-0 shadow-sm rounded-4"><div class="card-body p-3 p-md-4"><div class="alert alert-info rounded-3">Harga SPPG saat ini: <strong><?=(float)$bahan['harga']>0?'Rp '.number_format((float)$bahan['harga'],0,',','.'):'Belum diatur'?></strong></div><div class="table-responsive"><table class="table align-middle" id="tableHargaHistory"><thead><tr><th>Tanggal</th><th>Harga Lama</th><th>Harga Baru</th><th>Keterangan</th></tr></thead><tbody><?php foreach($history as $h):?><tr><td><?=date('d-m-Y H:i',strtotime($h['created_at']))?></td><td>Rp <?=number_format((float)$h['harga_lama'],0,',','.')?></td><td>Rp <?=number_format((float)$h['harga_baru'],0,',','.')?></td><td><?=esc($h['keterangan']?:'-')?></td></tr><?php endforeach;?><?php if(!$history):?><tr><td colspan="4" class="text-center text-muted py-4">Belum ada perubahan harga.</td></tr><?php endif;?></tbody></table></div></div></div></div></div>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('#tableHargaHistory')) new DataTable('#tableHargaHistory', { searchable: true, fixedHeight: true, perPage: 10, perPageSelect: [5, 10, 25, 50, 100] });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
