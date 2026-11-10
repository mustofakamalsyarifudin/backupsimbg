<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="mb-1">Edit SPPG</h5>
                <small class="text-muted">Perbarui informasi SPPG tanpa mengubah ID SPPG.</small>
            </div>
            <a href="<?= base_url('super-admin/sppg') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <?php if ($m = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= esc($m) ?></div>
        <?php endif; ?>

        <?php $errors = session()->getFlashdata('errors') ?? []; ?>
        <?php if ($errors): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <strong>Periksa data berikut:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    <?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h6 class="mb-0"><?= esc($sppg['sppg_name']) ?></h6>
                        <small class="text-muted">ID SPPG: <?= esc($sppg['id_sppg']) ?></small>
                    </div>
                </div>

                <form method="post" action="<?= base_url('super-admin/sppg/update/' . rawurlencode($sppg['id_sppg'])) ?>" novalidate>
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">ID SPPG</label>
                            <input type="text" class="form-control rounded-3 bg-light" value="<?= esc($sppg['id_sppg']) ?>" readonly>
                            <div class="form-text">ID tidak diubah agar relasi data SPPG tetap aman.</div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Nama SPPG <span class="text-danger">*</span></label>
                            <input type="text" name="sppg_name" value="<?= esc(old('sppg_name', $sppg['sppg_name'])) ?>" class="form-control rounded-3" maxlength="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" value="<?= esc(old('email', $sppg['email'])) ?>" class="form-control rounded-3" maxlength="100" placeholder="email@sppg-mbg.net">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Telepon</label>
                            <input type="text" name="phone" value="<?= esc(old('phone', $sppg['phone'])) ?>" class="form-control rounded-3" maxlength="20">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Alamat</label>
                            <textarea name="address" rows="4" class="form-control rounded-3" placeholder="Alamat lengkap SPPG"><?= esc(old('address', $sppg['address'])) ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tanggal Berdiri</label>
                            <input type="date" name="established_date" value="<?= esc(old('established_date', $sppg['established_date'])) ?>" class="form-control rounded-3">
                            <div class="mt-3 p-3 rounded-4 bg-light">
                                <small class="text-muted d-block">Status saat ini</small>
                                <span class="badge bg-<?= $sppg['status'] === 'active' ? 'success' : 'secondary' ?> rounded-pill mt-1">
                                    <?= $sppg['status'] === 'active' ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                                <small class="text-muted d-block mt-2">Status diubah dari halaman Master SPPG.</small>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                            <a href="<?= base_url('super-admin/sppg') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-check-lg me-1"></i>Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
