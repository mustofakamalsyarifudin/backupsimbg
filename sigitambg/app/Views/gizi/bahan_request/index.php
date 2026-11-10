<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success rounded-4"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger rounded-4"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0">Request Bahan Baru</h5>
                <small class="text-muted">Riwayat request bahan ke Koperasi</small>
            </div>
            <a href="<?= base_url('gizi/bahan/request/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Request Bahan
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <?php if (!$requests) : ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada request bahan.
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Bahan</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($requests as $item) : ?>
                                <tr>
                                    <td><?= date('d-m-Y', strtotime($item['created_at'])) ?></td>
                                    <td class="fw-semibold"><?= esc($item['nama_bahan']) ?></td>
                                    <td><?= esc($item['satuan']) ?></td>
                                    <td><?= esc($item['keterangan'] ?: '-') ?></td>
                                    <td>
                                        <?php
                                        $badge = match ($item['status']) {
                                            'menunggu' => 'warning',
                                            'diproses' => 'info',
                                            'dipenuhi' => 'success',
                                            'ditolak' => 'danger',
                                            default => 'secondary',
                                        };
                                        ?>
                                        <span class="badge bg-<?= $badge ?>"><?= ucfirst($item['status']) ?></span>
                                        <?php if ($item['status'] === 'ditolak' && $item['rejection_reason']) : ?>
                                            <div class="small text-danger mt-1"><?= esc($item['rejection_reason']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
