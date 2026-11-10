<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <div class="d-flex align-items-center mb-3">
            <a href="<?= base_url('gizi/bahan') ?>" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0">Riwayat Harga Bahan</h5>
                <small class="text-muted"><?= esc($bahan['nama_bahan']) ?></small>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="mb-3">
                    <strong>Harga saat ini:</strong>
                    Rp <?= number_format((float) $bahan['harga'], 0, ',', '.') ?>
                    / <?= esc($bahan['satuan_default']) ?>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Harga Lama</th>
                                <th>Harga Baru</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($history)) : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada perubahan harga.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($history as $row) : ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                                    <td>Rp <?= number_format((float) $row['harga_lama'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format((float) $row['harga_baru'], 0, ',', '.') ?></td>
                                    <td><?= esc($row['keterangan'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
