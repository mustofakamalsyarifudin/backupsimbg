<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<style>
    .koperasi-pembelian-page .container-wide { width: min(1500px, calc(100% - 24px)); margin-inline: auto; }
    .koperasi-pembelian-page .table-pembelian-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .koperasi-pembelian-page #tablePembelianDetail { width: 100%; min-width: 1500px; margin-bottom: 0; font-size: .86rem; }
    .koperasi-pembelian-page #tablePembelianDetail th,
    .koperasi-pembelian-page #tablePembelianDetail td { white-space: nowrap; vertical-align: middle; }
    .koperasi-pembelian-page .supplier-select { min-width: 230px; }
    .koperasi-pembelian-page .invoice-input { min-width: 145px; }
    .koperasi-pembelian-page .price-input { min-width: 115px; }
    .koperasi-pembelian-page .summary-box { min-width: 145px; }
    .koperasi-pembelian-page .select2-container { min-width: 230px; }
    .koperasi-pembelian-page .select2-container--default .select2-selection--single {
        height: 31px; border: 1px solid #b9d0ff; border-radius: .375rem; padding: 1px 8px;
    }
    .koperasi-pembelian-page .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 27px; font-size: .875rem; }
    .koperasi-pembelian-page .select2-container--default .select2-selection--single .select2-selection__arrow { height: 29px; }
    .supplier-price-note { font-size: .72rem; color: #6c757d; margin-top: 3px; }
    .price-update-option { display: none; margin-top: 4px; font-size: .72rem; white-space: normal; min-width: 220px; }
    .price-update-option.show { display: block; }
    @media (max-width: 768px) { .koperasi-pembelian-page .container-wide { width: calc(100% - 12px); } }
</style>

<div class="page-content-wrapper py-3 koperasi-pembelian-page">
    <div class="container-wide">
        <?php if($m=session()->getFlashdata('success')):?><div class="alert alert-success rounded-3"><?=esc($m)?></div><?php endif;?>
        <?php if($m=session()->getFlashdata('error')):?><div class="alert alert-danger rounded-3"><?=esc($m)?></div><?php endif;?>

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="mb-1">Pembelian <?=esc($row['no_pembelian'])?></h5>
                <small class="text-muted"><?=esc($sppg_name)?></small>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-danger btn-sm" target="_blank" href="<?=base_url('koperasi/pembelian/pdf/'.$row['id'])?>"><i class="bi bi-file-pdf me-1"></i>Invoice PDF</a>
                <a href="<?=base_url('koperasi/pembelian')?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>

        <form method="post" action="<?=base_url('koperasi/pembelian/update/'.$row['id'])?>">
            <?=csrf_field()?>
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Pembelian</label>
                            <input type="date" name="tanggal_pembelian" class="form-control" value="<?=esc($row['tanggal_pembelian'])?>" <?=$row['status']==='dikirim'?'disabled':''?> required>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2" <?=$row['status']==='dikirim'?'disabled':''?>><?=esc($row['catatan']??'')?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info rounded-3">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Harga SPPG dan qty permintaan adalah data yang sudah ditetapkan pada pengajuan.</strong>
                Koperasi tidak mengubah harga tersebut. Yang dikelola di sini adalah supplier, harga beli supplier, qty yang benar-benar dibeli, dan margin Koperasi.
            </div>

            <div class="alert alert-warning rounded-3">
                <i class="bi bi-shield-check me-1"></i>
                <strong>Pagu permintaan:</strong> Rp <?=number_format($nilai_permintaan,0,',','.')?>.
                Qty dibeli tidak boleh melebihi qty permintaan. Jika harga supplier berubah, perubahan tersebut memengaruhi biaya dan margin Koperasi, bukan pagu SPPG.
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <h6 class="fw-bold mb-0">Barang yang Dibeli</h6>
                        <small class="text-muted">Supplier dicari berdasarkan nama/kode dan dibatasi sesuai SPPG serta bahan.</small>
                    </div>

                    <div class="table-pembelian-wrap">
                        <table class="table align-middle" id="tablePembelianDetail">
                            <thead>
                                <tr>
                                    <th>Bahan</th>
                                    <th>Diminta</th>
                                    <th>Dibeli</th>
                                    <th>Satuan</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli Supplier</th>
                                    <th>Harga SPPG</th>
                                    <th>Margin</th>
                                    <th>Total Jual</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($details as $d):
                                $buy=(float)($d['harga_beli_snapshot']??$d['harga_beli_default']??0);
                                $sell=(float)($d['harga_jual_snapshot']??0);
                                if ($sell <= 0) $sell=(float)($d['harga_satuan']??0);
                                $m=$sell-$buy;
                                $disabled=$row['status']==='dikirim'?'disabled':'';
                            ?>
                                <tr data-bahan-id="<?=esc($d['bahan_id'])?>">
                                    <td class="fw-semibold"><?=esc($d['nama_bahan'])?></td>
                                    <td class="requested-qty"><?=esc($d['qty_diminta'])?></td>
                                    <td style="min-width:90px">
                                        <input type="number" step="0.01" min="0" max="<?=esc($d['qty_diminta'])?>" name="item[<?=$d['id']?>][qty_dibeli]" value="<?=esc($d['qty_dibeli'])?>" class="form-control form-control-sm calc qty" <?=$disabled?> required>
                                        <div class="supplier-price-note">Maks. <?=esc($d['qty_diminta'])?></div>
                                    </td>
                                    <td><?=esc($d['satuan'])?></td>
                                    <td>
                                        <select name="item[<?=$d['id']?>][supplier_id]" class="form-select form-select-sm supplier-select supplier-choice" data-placeholder="Cari nama supplier..." <?=$disabled?> required>
                                            <option value=""></option>
                                            <?php foreach(($d['supplier_options'] ?? []) as $sb): ?>
                                                <option value="<?=esc($sb['supplier_id'])?>"
                                                    data-supplier-bahan-id="<?=esc($sb['id'])?>"
                                                    data-harga-beli="<?=esc($sb['harga_beli'])?>"
                                                    <?=((int)($d['selected_supplier_id']??0)===(int)$sb['supplier_id'])?'selected':''?>>
                                                    <?=esc($sb['nama_supplier'])?> — <?=esc($sb['kode_supplier'])?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="item[<?=$d['id']?>][supplier_bahan_id]" class="supplier-bahan-id" value="<?=esc($d['supplier_bahan_id'] ?? '')?>">
                                        <input type="hidden" name="item[<?=$d['id']?>][no_invoice_supplier]" value="<?=esc($d['no_invoice_supplier'] ?? ('INV-' . ($row['no_pembelian'] ?? ('PB-' . $row['id']))) )?>">
                                        <?php if (empty($d['supplier_options'])): ?>
                                            <div class="text-danger small mt-1">Belum ada supplier aktif yang terhubung dengan bahan ini.</div>
                                        <?php endif; ?>
                                    </td>
<td>
                                        <input type="number" step="0.01" min="0" name="item[<?=$d['id']?>][harga_beli_snapshot]" value="<?=esc($buy)?>" class="form-control form-control-sm calc buy price-input" data-master-price="<?=esc($buy)?>" <?=$disabled?> required>
                                        <div class="price-update-option">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="item[<?=$d['id']?>][update_supplier_price]" value="1" class="form-check-input update-supplier-price" <?=$disabled?>>
                                                Jadikan harga ini harga supplier terbaru
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" value="<?=esc($sell)?>" class="form-control form-control-sm price-input sell" readonly aria-label="Harga SPPG">
                                        <div class="supplier-price-note">Dari permintaan/pagu SPPG</div>
                                    </td>
                                    <td class="margin-cell fw-bold">Rp <?=number_format($m,0,',','.')?></td>
                                    <td class="total-cell">Rp <?=number_format((float)$d['total_harga'],0,',','.')?></td>
                                    <td>
                                        <input name="item[<?=$d['id']?>][keterangan]" value="<?=esc($d['keterangan']??'')?>" class="form-control form-control-sm" placeholder="Opsional" <?=$disabled?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-2 justify-content-end mt-3">
                        <div class="col-6 col-md-3 col-xl-2 summary-box"><div class="small text-muted">Pagu / Nilai Permintaan</div><div class="fw-bold">Rp <?=number_format($nilai_permintaan,0,',','.')?></div></div>
                        <div class="col-6 col-md-3 col-xl-2 summary-box"><div class="small text-muted">Biaya Beli Supplier</div><div class="fw-bold" id="totalBeli">Rp <?=number_format($total_beli,0,',','.')?></div></div>
                        <div class="col-6 col-md-3 col-xl-2 summary-box"><div class="small text-muted">Nilai Jual ke SPPG</div><div class="fw-bold" id="totalJual">Rp <?=number_format($grand_total,0,',','.')?></div></div>
                        <div class="col-6 col-md-3 col-xl-2 summary-box"><div class="small text-muted">Margin Koperasi</div><div class="fw-bold text-success" id="totalMargin">Rp <?=number_format($total_margin,0,',','.')?></div></div>
                        <div class="col-6 col-md-2 col-xl-1 summary-box"><div class="small text-muted">Margin %</div><div class="fw-bold" id="marginPct"><?=number_format($margin_persen,2,',','.')?>%</div></div>
                    </div>
                </div>
            </div>

            <?php if($row['status']!=='dikirim'):?>
                <button class="btn btn-primary mb-3"><i class="bi bi-save me-1"></i>Simpan Pembelian</button>
            <?php endif;?>
        </form>

        <?php if($row['status']==='draft'):?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold">Konfirmasi Pembelian</h6>
                    <p class="small text-muted">Pastikan supplier, invoice, harga beli supplier, dan qty dibeli sudah benar. Harga SPPG mengikuti permintaan dan tidak diedit di sini.</p>
                    <form method="post" action="<?=base_url('koperasi/pembelian/dibeli/'.$row['id'])?>">
                        <?=csrf_field()?><button class="btn btn-success"><i class="bi bi-check-circle me-1"></i>Tandai Sudah Dibeli</button>
                    </form>
                </div>
            </div>
        <?php elseif($row['status']==='dibeli'):?>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold">Pengiriman ke SPPG</h6>
                    <p class="small text-muted">Setelah barang benar-benar disiapkan dan dikirim ke SPPG, tandai sebagai dikirim.</p>
                    <form method="post" action="<?=base_url('koperasi/pembelian/kirim/'.$row['id'])?>">
                        <?=csrf_field()?><button class="btn btn-primary"><i class="bi bi-truck me-1"></i>Tandai Dikirim ke SPPG</button>
                    </form>
                </div>
            </div>
        <?php else:?>
            <div class="alert alert-success rounded-3"><i class="bi bi-check-circle me-1"></i>Barang telah ditandai dikirim ke SPPG pada <?=!empty($row['dikirim_at'])?date('d/m/Y H:i',strtotime($row['dikirim_at'])):'-'?>.</div>
        <?php endif;?>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    function rp(n){return 'Rp '+new Intl.NumberFormat('id-ID').format(Math.round(n));}

    function calc(){
        let beli=0,jual=0,margin=0;
        document.querySelectorAll('#tablePembelianDetail tbody tr').forEach(tr=>{
            const q=Math.max(0,parseFloat(tr.querySelector('.qty')?.value||0));
            const b=Math.max(0,parseFloat(tr.querySelector('.buy')?.value||0));
            const s=Math.max(0,parseFloat(tr.querySelector('.sell')?.value||0));
            const m=s-b, t=q*s;
            tr.querySelector('.margin-cell').textContent=rp(m);
            tr.querySelector('.total-cell').textContent=rp(t);
            beli+=q*b; jual+=t; margin+=q*m;
        });
        document.getElementById('totalBeli').textContent=rp(beli);
        document.getElementById('totalJual').textContent=rp(jual);
        document.getElementById('totalMargin').textContent=rp(margin);
        document.getElementById('marginPct').textContent=(beli?((margin/beli)*100):0).toFixed(2).replace('.',',')+'%';
    }

    if (window.jQuery && $.fn.select2) {
        $('.supplier-choice').select2({
            width: '100%',
            placeholder: 'Cari nama supplier...',
            allowClear: true
        });
    }

    $('.supplier-choice').on('change', function(){
        const tr=this.closest('tr');
        const opt=this.options[this.selectedIndex];
        const sbId=opt?.dataset?.supplierBahanId||'';
        const harga=opt?.dataset?.hargaBeli;
        const hidden=tr.querySelector('.supplier-bahan-id');
        const buy=tr.querySelector('.buy');
        const optionBox=tr.querySelector('.price-update-option');
        const checkbox=tr.querySelector('.update-supplier-price');
        if(hidden) hidden.value=sbId;
        if(harga !== undefined && harga !== '' && parseFloat(harga) >= 0){
            buy.value=harga;
            buy.dataset.masterPrice=harga;
            if(optionBox) optionBox.classList.remove('show');
            if(checkbox) checkbox.checked=false;
        }
        calc();
    });

    document.querySelectorAll('.buy').forEach(input=>{
        input.addEventListener('input', function(){
            const tr=this.closest('tr');
            const master=parseFloat(this.dataset.masterPrice||0);
            const current=parseFloat(this.value||0);
            const box=tr.querySelector('.price-update-option');
            const checkbox=tr.querySelector('.update-supplier-price');
            if(box) box.classList.toggle('show', Math.abs(master-current)>0.00001 && tr.querySelector('.supplier-choice')?.value);
            if(Math.abs(master-current)<=0.00001 && checkbox) checkbox.checked=false;
            calc();
        });
    });

    document.querySelectorAll('.qty').forEach(input=>input.addEventListener('input',calc));
    calc();
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
