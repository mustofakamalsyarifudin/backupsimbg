<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

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
.badge-status-waiting-kepala{background:#7c3aed!important;color:#fff!important;}
.pagu-over{border-color:#dc3545!important;background:#fff5f5;}
.pagu-safe{border-color:#198754!important;background:#f4fff8;}
.pagu-zero{border-color:#adb5bd!important;background:#f8f9fa;}
</style>

<div class="page-content-wrapper py-3">
<div class="container keuangan-pengadaan-container">

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <h5 class="mb-1"><?= esc($row['kode_transaksi']) ?></h5>
                <small class="text-muted"><?= esc($sppg_name) ?> · <?= date('d/m/Y',strtotime($row['tanggal'])) ?></small>
            </div>
            <?php $statusBadge = match ($row['status'] ?? '') {
                'waiting_finance' => 'bg-warning text-dark',
                'waiting_kepala' => 'badge-status-waiting-kepala',
                'waiting_koperasi' => 'bg-info text-dark',
                'procurement' => 'bg-primary',
                'completed' => 'bg-success',
                'rejected_finance','rejected_kepala' => 'bg-danger',
                default => 'bg-secondary',
            }; ?>
            <span class="badge <?= $statusBadge ?>">
                <?= esc(match ($row['status'] ?? '') {
                    'waiting_finance' => 'Menunggu Keuangan',
                    'waiting_kepala' => 'Menunggu Kepala',
                    'waiting_koperasi' => 'Menunggu Koperasi',
                    'procurement' => 'Diproses Koperasi',
                    'completed' => 'Selesai',
                    'rejected_finance' => 'Ditolak Keuangan',
                    'rejected_kepala' => 'Ditolak Kepala',
                    default => ucwords(str_replace('_',' ', $row['status'] ?? ''))
                }) ?>
            </span>
        </div>
    </div>
</div>

<?php if($pagu_available): ?>
    <?php
        $pagu = (float)$row['pagu_total'];
        $selisih = (float)$pagu_selisih;
        $over = $selisih < 0;
        $pas = $selisih == 0;
    ?>
    <div class="card border shadow-sm mb-3 rounded-4 <?= $over ? 'pagu-over' : ($pas ? 'pagu-zero' : 'pagu-safe') ?>">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <div>
                    <h6 class="fw-bold mb-1"><i class="bi bi-wallet2 me-1"></i>Snapshot Pagu Harian</h6>
                    <small class="text-muted">Snapshot diambil saat Gizi mengirim pengajuan ke Keuangan.</small>
                </div>
                <?php if($over): ?>
                    <span class="badge bg-danger">Melebihi Pagu</span>
                <?php elseif($pas): ?>
                    <span class="badge bg-secondary">Pas Pagu</span>
                <?php else: ?>
                    <span class="badge bg-success">Dalam Pagu</span>
                <?php endif; ?>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Porsi Kecil</small>
                    <strong><?= number_format((int)$row['pagu_porsi_kecil']) ?></strong>
                    <small class="d-block text-muted">× Rp <?= number_format((int)$row['pagu_tarif_kecil'],0,',','.') ?></small>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Porsi Besar</small>
                    <strong><?= number_format((int)$row['pagu_porsi_besar']) ?></strong>
                    <small class="d-block text-muted">× Rp <?= number_format((int)$row['pagu_tarif_besar'],0,',','.') ?></small>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Pagu</small>
                    <strong>Rp <?= number_format($pagu,0,',','.') ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Selisih</small>
                    <strong><?= $selisih < 0 ? '−' : '' ?>Rp <?= number_format(abs($selisih),0,',','.') ?></strong>
                    <small class="d-block text-muted"><?= $over ? 'Kelebihan pengajuan' : ($pas ? 'Tidak ada sisa' : 'Sisa pagu') ?></small>
                </div>
            </div>

            <div class="small text-muted mt-3">
                Snapshot: <?= !empty($row['pagu_snapshot_at']) ? date('d/m/Y H:i', strtotime($row['pagu_snapshot_at'])) : '-' ?>
            </div>

            <?php if($over): ?>
                <div class="alert alert-danger mt-3 mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Total pengajuan melebihi pagu sebesar <strong>Rp <?= number_format(abs($selisih),0,',','.') ?></strong>.
                    Pengajuan tetap dapat diteruskan, tetapi Keuangan wajib memberikan catatan/alasan.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning rounded-4">
        <i class="bi bi-exclamation-triangle me-1"></i>
        Pengajuan ini belum memiliki snapshot pagu. Data lama yang dibuat sebelum fitur pagu tidak dihitung ulang menggunakan PM saat ini.
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <h6>Rincian Pengajuan</h6>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Bahan</th><th>Qty</th><th>Satuan</th><th>Harga</th><th>Total</th></tr></thead>
                <tbody>
                <?php if($details): foreach($details as $d): ?>
                    <tr>
                        <td><?= esc($d['nama_bahan']) ?></td>
                        <td><?= esc($d['qty']) ?></td>
                        <td><?= esc($d['satuan']) ?></td>
                        <td>Rp <?= number_format((float)$d['harga'],0,',','.') ?></td>
                        <td>Rp <?= number_format((float)$d['total_harga'],0,',','.') ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center text-muted">Belum ada rincian bahan.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end fw-bold">Total Pengajuan: Rp <?= number_format($grand_total,0,',','.') ?></div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <h6 class="mb-3">Jejak Pemeriksaan</h6>
        <div class="row g-3">
            <div class="col-md-4"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Keuangan</small><strong><?= $row['finance_reviewed_at'] ? 'Sudah diperiksa' : 'Belum diperiksa' ?></strong><?php if(!empty($row['catatan_keuangan'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($row['catatan_keuangan'])) ?></div><?php endif; ?></div></div>
            <div class="col-md-4"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Kepala SPPG</small><strong><?= $row['kepala_approved_at'] ? 'Sudah diproses' : 'Menunggu' ?></strong><?php if(!empty($row['catatan_approval'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($row['catatan_approval'])) ?></div><?php endif; ?></div></div>
            <div class="col-md-4"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Koperasi</small><strong><?= $row['koperasi_processed_at'] ? 'Sudah diproses' : 'Belum diproses' ?></strong><?php if(!empty($row['koperasi_note'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($row['koperasi_note'])) ?></div><?php endif; ?></div></div>
        </div>
    </div>
</div>

<?php if($row['status']==='waiting_finance'): ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6>Keputusan Keuangan</h6>

        <?php if($pagu_available && $pagu_selisih < 0): ?>
            <div class="alert alert-warning small">
                Karena pengajuan melebihi pagu, kolom catatan di bawah menjadi <strong>wajib</strong>.
                Jelaskan alasan/justifikasi sebelum meneruskan ke Kepala SPPG.
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('keuangan/pengadaan/approve/'.$row['id']) ?>" class="mb-3">
            <?= csrf_field() ?>
            <label class="form-label">
                Catatan Keuangan
                <?php if($pagu_available && $pagu_selisih < 0): ?>
                    <span class="text-danger">(wajib karena melebihi pagu)</span>
                <?php else: ?>
                    <span class="text-muted">(opsional)</span>
                <?php endif; ?>
            </label>
            <textarea name="catatan_keuangan" class="form-control mb-2" rows="3" <?= ($pagu_available && $pagu_selisih < 0) ? 'required' : '' ?> placeholder="Catatan pemeriksaan atau alasan/justifikasi untuk Kepala SPPG..."></textarea>
            <button class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i>Setujui & Kirim ke Kepala
            </button>
        </form>

        <form method="post" action="<?= base_url('keuangan/pengadaan/reject/'.$row['id']) ?>">
            <?= csrf_field() ?>
            <label class="form-label">Alasan Penolakan</label>
            <textarea name="catatan_keuangan" class="form-control mb-2" rows="3" required placeholder="Wajib diisi jika pengajuan dikembalikan ke Gizi."></textarea>
            <button class="btn btn-outline-danger">
                <i class="bi bi-arrow-return-left me-1"></i>Tolak & Kembalikan ke Gizi
            </button>
        </form>
    </div>
</div>
<?php endif; ?>

<a href="<?= base_url('keuangan/pengadaan') ?>" class="btn btn-secondary btn-sm mt-3">
    <i class="bi bi-arrow-left me-1"></i>Kembali
</a>

</div>
</div>

<?= $this->endSection() ?>
