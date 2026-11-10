<!doctype html><html><head><meta charset="utf-8"><style>
body{font-family:DejaVu Sans,Arial;font-size:9px;color:#222}h1{font-size:20px;margin:0}h2{font-size:14px;margin:4px 0}table{width:100%;border-collapse:collapse;margin-top:14px}th,td{border:1px solid #777;padding:5px}th{background:#e9eef8}.right{text-align:right}.muted{color:#666}.box{border:1px solid #aaa;padding:9px;margin-top:10px}.total{font-size:12px;font-weight:bold;text-align:right;margin-top:12px}.green{color:#198754}.warn{color:#856404}
</style></head><body>
<h1>INVOICE PEMBELIAN BARANG</h1>
<div class="muted">Koperasi: <?= esc($koperasi['nama_koperasi'] ?? '') ?></div>
<div class="box">
<b>No. Pembelian:</b> <?= esc($row['no_pembelian']) ?><br>
<b>Tanggal:</b> <?= date('d/m/Y',strtotime($row['tanggal_pembelian'])) ?><br>
<b>SPPG Tujuan:</b> <?= esc($sppg['sppg_name'] ?? $row['id_sppg']) ?><br>
<b>Pagu/Nilai Permintaan:</b> Rp <?= number_format((float)$nilai_permintaan,0,',','.') ?>
</div>
<table><thead><tr><th>No</th><th>Bahan</th><th>Qty</th><th>Satuan</th><th>Supplier</th><th>Invoice Supplier</th><th>Harga Beli</th><th>Harga SPPG</th><th>Margin</th><th>Total Jual</th></tr></thead><tbody>
<?php $no=1; $totalBeli=0; $totalMargin=0; foreach($details as $d):
$qty=(float)$d['qty_dibeli']; $hargaBeli=(float)($d['harga_beli_snapshot']??0); $hargaSppg=(float)($d['harga_jual_snapshot']??0); if($hargaSppg<=0)$hargaSppg=(float)($d['harga_satuan']??0); $margin=$hargaSppg-$hargaBeli; $beli=$qty*$hargaBeli; $jual=$qty*$hargaSppg; $totalBeli+=$beli; $totalMargin+=$qty*$margin;
?>
<tr><td><?= $no++ ?></td><td><?= esc($d['nama_bahan']) ?></td><td class="right"><?= number_format($qty,2,',','.') ?></td><td><?= esc($d['satuan']) ?></td><td><?= esc($d['nama_supplier'] ?? '-') ?></td><td><?= esc($d['no_invoice_supplier'] ?? '-') ?></td><td class="right">Rp <?= number_format($hargaBeli,0,',','.') ?></td><td class="right">Rp <?= number_format($hargaSppg,0,',','.') ?></td><td class="right">Rp <?= number_format($margin,0,',','.') ?></td><td class="right">Rp <?= number_format($jual,0,',','.') ?></td></tr>
<?php endforeach; ?></tbody></table>
<div class="box">
<b>Biaya Beli Supplier:</b> Rp <?= number_format($totalBeli,0,',','.') ?><br>
<b>Nilai Jual ke SPPG:</b> Rp <?= number_format($grand_total,0,',','.') ?><br>
<b class="green">Margin Koperasi:</b> Rp <?= number_format($totalMargin,0,',','.') ?>
</div>
<?php if(!empty($row['catatan'])):?><div class="box"><b>Catatan:</b><br><?= nl2br(esc($row['catatan'])) ?></div><?php endif;?>
<p style="margin-top:30px">Dokumen ini mencatat pengadaan Koperasi berdasarkan permintaan/pagu SPPG. Harga beli supplier merupakan biaya aktual Koperasi pada transaksi.</p>
</body></html>
