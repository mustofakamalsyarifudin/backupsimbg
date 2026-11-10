<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<style>
    /* Khusus halaman Laporan Keuangan: gunakan ruang desktop lebih optimal. */
    .keuangan-report-wrap { width: 100%; max-width: 1600px; margin: 0 auto; }
    .keuangan-report-wrap .table-responsive { width: 100%; }
    .keuangan-report-wrap table { width: 100% !important; }
    .keuangan-report-wrap .report-summary .alert { min-height: 100%; }
    @media (min-width: 1400px) {
        .keuangan-report-wrap { max-width: 1720px; }
    }
    @media (max-width: 767.98px) {
        .keuangan-report-wrap { padding-left: 0; padding-right: 0; }
    }
</style>
<div class="page-content-wrapper py-3">
    <div class="container-fluid px-3 px-lg-4 keuangan-report-wrap">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">Laporan Keuangan</h5>
                <small class="text-muted"><?= esc($sppg_name) ?></small>
            </div>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-danger btn-sm">Kembali</a>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <form class="row g-2">
                    <div class="col-md-4"><label class="form-label">Dari</label><input type="date" name="from" value="<?= esc($from) ?>" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Sampai</label><input type="date" name="to" value="<?= esc($to) ?>" class="form-control"></div>
                    <div class="col-md-2 align-self-end"><button class="btn btn-primary w-100">Tampilkan</button></div>
                    <div class="col-md-2 align-self-end"><a class="btn btn-outline-danger w-100" href="<?= base_url('keuangan/laporan/pdf?from='.urlencode($from).'&to='.urlencode($to)) ?>"><i class="bi bi-file-pdf me-1"></i>PDF</a></div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6>Pengajuan/Pengadaan Bahan</h6>
                <div class="table-responsive"><table class="table" id="tPurchase">
                    <thead><tr><th>Tanggal</th><th>Kode</th><th>Status</th><th>Total</th></tr></thead>
                    <tbody><?php foreach($purchases as $r): ?><tr><td><?= date('d/m/Y',strtotime($r['tanggal'])) ?></td><td><?= esc($r['kode_transaksi']) ?></td><td><?= esc(ucwords(str_replace('_',' ',$r['status']))) ?></td><td>Rp <?= number_format($r['grand_total'],0,',','.') ?></td></tr><?php endforeach; ?></tbody>
                </table></div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6>Pengeluaran Aslap</h6>
                <div class="table-responsive"><table class="table" id="tExpense">
                    <thead><tr><th>Tanggal</th><th>Kategori</th><th>Uraian</th><th>Nominal</th></tr></thead>
                    <tbody><?php foreach($expenses as $r): ?><tr><td><?= date('d/m/Y',strtotime($r['tanggal'])) ?></td><td><?= esc($r['kategori']) ?></td><td><?= esc($r['uraian']) ?></td><td>Rp <?= number_format($r['nominal'],0,',','.') ?></td></tr><?php endforeach; ?></tbody>
                </table></div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Laporan Petty Cash</h6>
                    <a href="<?= base_url('keuangan/petty-cash') ?>" class="btn btn-outline-primary btn-sm">Buka Buku Kas</a>
                </div>
                <div class="row g-2 mb-3 report-summary">
                    <div class="col-12 col-md-4"><div class="alert alert-success mb-0 py-2">Total Pemasukan: <strong>Rp <?= number_format((float)($cash_summary['masuk']??0),0,',','.') ?></strong></div></div>
                    <div class="col-12 col-md-4"><div class="alert alert-danger mb-0 py-2">Total Pengeluaran: <strong>Rp <?= number_format((float)($cash_summary['keluar']??0),0,',','.') ?></strong></div></div>
                    <div class="col-12 col-md-4"><div class="alert alert-light border mb-0 py-2">Selisih Periode: <strong>Rp <?= number_format((float)($cash_summary['masuk']??0)-(float)($cash_summary['keluar']??0),0,',','.') ?></strong></div></div>
                </div>
                <div class="table-responsive"><table class="table" id="tPettyCash">
                    <thead><tr><th>Tanggal</th><th>Jenis</th><th>Kategori</th><th>Uraian</th><th>Jumlah</th><th>Saldo Akhir</th></tr></thead>
                    <tbody><?php foreach(($petty_cash??[]) as $r): ?><tr><td><?= date('d/m/Y',strtotime($r['tanggal'])) ?></td><td><?= esc(ucfirst($r['jenis'])) ?></td><td><?= esc($r['kategori']) ?></td><td><?= esc($r['deskripsi']??'—') ?></td><td>Rp <?= number_format((float)$r['jumlah'],0,',','.') ?></td><td>Rp <?= number_format((float)$r['saldo_akhir'],0,',','.') ?></td></tr><?php endforeach; ?></tbody>
                </table></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#tPurchase, #tExpense, #tPettyCash').forEach(table => {
        new DataTable(table, { searchable: true, fixedHeight: false, perPage: 10, perPageSelect: [5, 10, 25, 50, 100] });
    });
});
</script>
<?= $this->endSection() ?>
