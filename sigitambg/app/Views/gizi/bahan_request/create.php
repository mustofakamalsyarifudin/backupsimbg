<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <a href="<?= base_url('gizi/bahan/request') ?>" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0">Request Bahan Baru</h5>
                <small class="text-muted">Ajukan bahan yang belum tersedia di Master Bahan</small>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger rounded-4"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="alert alert-info border-0 rounded-4">
                    <i class="bi bi-info-circle me-1"></i>
                    Request ini tidak memerlukan jumlah kebutuhan. Setelah disetujui Koperasi, bahan akan tersedia di Master Bahan dan dapat dipilih pada transaksi.
                </div>

                <form action="<?= base_url('gizi/bahan/request/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Bahan</label>
                        <input type="text" name="nama_bahan" class="form-control" value="<?= old('nama_bahan') ?>" placeholder="Contoh: Keju Mozzarella" required maxlength="150">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <select name="satuan" class="form-select" required>
                            <option value="">Pilih Satuan</option>
                            <?php foreach (['Kg','Gram','Liter','Ml','Butir','Buah','Ekor','Ikat','Pcs','Pack','Box','Dus','Karung','Sak','Botol','Jerigen','Lembar','Batang','Bungkus'] as $satuan) : ?>
                                <option value="<?= $satuan ?>" <?= old('satuan') === $satuan ? 'selected' : '' ?>><?= $satuan ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan / Alasan</label>
                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Jelaskan mengapa bahan diperlukan."><?= old('keterangan') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('gizi/bahan/request') ?>" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Kirim Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
