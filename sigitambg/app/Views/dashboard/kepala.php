<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="mb-3">
            <h5 class="mb-1">Dashboard Kepala SPPG</h5>
            <small class="text-muted">Pemeriksaan dan persetujuan pengadaan bahan SPPG.</small>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#1d4ed8,#2563eb);border-radius:20px;">
            <div class="card-body p-4 text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Selamat Datang</small>
                        <h4 class="mb-1"><?= esc(session('full_name') ?: 'Kepala SPPG') ?></h4>
                        <p class="text-white-50 mb-2">Kepala SPPG</p>
                        <span class="badge bg-light text-primary fs-6"><?= esc($sppg['sppg_name'] ?? session('id_sppg')) ?></span>
                    </div>
                    <i class="bi bi-person-badge-fill text-white" style="font-size:58px;"></i>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-4">
                <a href="<?= base_url('kepala/pengadaan?status=waiting_kepala') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-hourglass-split" style="font-size:34px;color:#7c3aed;"></i>
                            <h3 class="mb-1" style="color:#7c3aed;"><?= number_format($pendingPengadaan ?? 0) ?></h3>
                            <small class="text-muted">Menunggu Approval</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a href="<?= base_url('kepala/pengadaan?status=waiting_koperasi') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-check-circle-fill text-success fs-3"></i>
                            <h3 class="text-success mb-1"><?= number_format($approvalSelesai ?? 0) ?></h3>
                            <small class="text-muted">Sudah Diteruskan</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-4">
                <a href="<?= base_url('kepala/pengadaan') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-clipboard-data text-primary fs-3"></i>
                            <h3 class="text-primary mb-1"><?= number_format($totalPengajuan ?? 0) ?></h3>
                            <small class="text-muted">Total Pengajuan</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <h6 class="mb-3">Menu Utama</h6>
        <div class="row g-3">
            <div class="col-6">
                <a href="<?= base_url('kepala/pengadaan?status=waiting_kepala') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-4">
                            <i class="bi bi-clipboard-check" style="font-size:42px;color:#7c3aed;"></i>
                            <h6 class="mt-2 mb-1">Approval Pengadaan</h6>
                            <small class="text-muted">Periksa pengajuan yang telah disetujui Keuangan.</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="<?= base_url('kepala/pengadaan') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-4">
                            <i class="bi bi-clock-history text-primary" style="font-size:42px;"></i>
                            <h6 class="mt-2 mb-1">Riwayat Pengadaan</h6>
                            <small class="text-muted">Lihat seluruh status pengajuan dan proses pengadaan bahan SPPG.</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="alert mt-4 mb-0" style="background:#f5f3ff;border:1px solid #ddd6fe;color:#4c1d95;border-radius:14px;">
            <i class="bi bi-info-circle me-1"></i>
            Pengajuan hanya dapat disetujui setelah diperiksa oleh Keuangan. Setelah disetujui Kepala, pengajuan diteruskan ke Koperasi untuk pengadaan.
        </div>
    </div>
</div>

<?= $this->endSection() ?>
