<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3"><div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div><h5 class="mb-1 fw-bold">Tambah Koperasi</h5><small class="text-muted">Buat master koperasi baru.</small></div>
        <a href="<?= base_url('super-admin/koperasi') ?>" class="btn btn-light border rounded-3">← Kembali</a>
    </div>
    <?php if ($errors = session()->getFlashdata('errors')): ?><div class="alert alert-danger rounded-3"><ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <?php if ($m = session()->getFlashdata('error')): ?><div class="alert alert-danger rounded-3"><?= esc($m) ?></div><?php endif; ?>
    <div class="card border-0 shadow-sm rounded-4"><div class="card-body p-3 p-md-4">
        <form method="post" action="<?= base_url('super-admin/koperasi/store') ?>">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label fw-semibold">Kode Koperasi *</label><input name="kode_koperasi" value="<?= esc(old('kode_koperasi')) ?>" class="form-control rounded-3" maxlength="30" required><small class="text-muted">Huruf, angka, - atau _.</small></div>
                <div class="col-md-8"><label class="form-label fw-semibold">Nama Koperasi *</label><input name="nama_koperasi" value="<?= esc(old('nama_koperasi')) ?>" class="form-control rounded-3" maxlength="150" required></div>
                <div class="col-12"><label class="form-label fw-semibold">Alamat</label><textarea name="alamat" class="form-control rounded-3" rows="3" maxlength="255"><?= esc(old('alamat')) ?></textarea></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Telepon</label><input name="telepon" value="<?= esc(old('telepon')) ?>" class="form-control rounded-3" maxlength="30"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input name="email" value="<?= esc(old('email')) ?>" type="email" class="form-control rounded-3" maxlength="100"></div>
            </div>
            <div class="alert alert-info rounded-3 mt-4 mb-0">Setelah koperasi dibuat, Super Admin dapat memilih beberapa SPPG yang menjadi tanggung jawab koperasi untuk pengelolaan harga pokok barang.</div>
            <div class="d-flex justify-content-end gap-2 mt-4"><a href="<?= base_url('super-admin/koperasi') ?>" class="btn btn-light border rounded-3">Batal</a><button class="btn btn-primary rounded-3">✓ Simpan Koperasi</button></div>
        </form>
    </div></div>
</div></div>
<?= $this->endSection() ?>
