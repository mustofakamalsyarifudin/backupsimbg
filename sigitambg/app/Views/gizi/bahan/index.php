<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
            <div>
                <h5 class="mb-0">Master Bahan Baku</h5>
                <small class="text-muted">
                    Dikelola oleh Koperasi
                </small>
            </div>

            <?php if (session('user_level') === 'gizi') : ?>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('gizi/bahan/request') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list-check me-1"></i> Request Saya
                    </a>
                    <a href="<?= base_url('gizi/bahan/request/create') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Request Bahan Baru
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (session('user_level') === 'koperasi') : ?>
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <h6 class="mb-3">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Bahan
                </h6>

                <form action="<?= base_url('gizi/bahan/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Nama Bahan</label>
                            <input type="text" name="nama_bahan" class="form-control"
                                   placeholder="Contoh: Beras Premium" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Satuan</label>
                            <select name="satuan_default" class="form-select" required>
                                <option value="">Pilih Satuan</option>
                                <option value="Kg">Kg</option>
                                <option value="Gram">Gram</option>
                                <option value="Liter">Liter</option>
                                <option value="Ml">Ml</option>
                                <option value="Butir">Butir</option>
                                <option value="Buah">Buah</option>
                                <option value="Ekor">Ekor</option>
                                <option value="Ikat">Ikat</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Pack">Pack</option>
                                <option value="Box">Box</option>
                                <option value="Dus">Dus</option>
                                <option value="Karung">Karung</option>
                                <option value="Sak">Sak</option>
                                <option value="Botol">Botol</option>
                                <option value="Jerigen">Jerigen</option>
                                <option value="Lembar">Lembar</option>
                                <option value="Batang">Batang</option>
                                <option value="Bungkus">Bungkus</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Harga Awal</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" class="form-control"
                                       min="0" step="0.01" value="0" required>
                            </div>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="submit" title="Simpan">
                                <i class="bi bi-save"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-text mt-2">
                        Harga awal ditetapkan oleh Koperasi. Perubahan harga akan tercatat dalam riwayat.
                    </div>
                </form>
            </div>
        </div>
        <?php else : ?>
        <div class="alert alert-info border-0 rounded-4 shadow-sm mb-3">
            <i class="bi bi-info-circle me-1"></i>
            Anda dapat melihat Master Bahan Baku. Penambahan, perubahan harga, perubahan status, dan riwayat harga dikelola oleh Koperasi.
        </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Daftar Master Bahan</h6>
                    <span class="badge bg-primary"><?= count($bahans) ?> bahan</span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="tableBahan">
                        <thead>
                            <tr>
                                <th>Nama Bahan</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bahans as $bahan) : ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($bahan['nama_bahan']) ?></td>
                                <td><span class="badge bg-secondary"><?= esc($bahan['satuan_default']) ?></span></td>
                                <td>Rp <?= number_format((float) $bahan['harga'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($bahan['status'] === 'aktif') : ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (session('user_level') === 'koperasi') : ?>
                                    <div class="d-flex gap-1">
                                        <button type="button"
                                                class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $bahan['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <a href="<?= base_url('gizi/bahan/history/' . $bahan['id']) ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Riwayat harga">
                                            <i class="bi bi-clock-history"></i>
                                        </a>

                                        <form action="<?= base_url('gizi/bahan/toggle-status/' . $bahan['id']) ?>"
                                              method="post"
                                              class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                    title="Ubah status">
                                                <i class="bi bi-power"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <?php else : ?>
                                        <span class="text-muted small">Lihat saja</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <?php if (session('user_level') === 'koperasi') : ?>
                            <div class="modal fade" id="editModal<?= $bahan['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('gizi/bahan/update/' . $bahan['id']) ?>" method="post">
                                            <?= csrf_field() ?>

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Master Bahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Bahan</label>
                                                    <input type="text" name="nama_bahan" class="form-control"
                                                           value="<?= esc($bahan['nama_bahan']) ?>" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Satuan</label>
                                                    <select name="satuan_default" class="form-select" required>
                                                        <?php foreach (['Kg','Gram','Liter','Ml','Butir','Buah','Ekor','Ikat','Pcs','Pack','Box','Dus','Karung','Sak','Botol','Jerigen','Lembar','Batang','Bungkus'] as $satuan) : ?>
                                                            <option value="<?= $satuan ?>" <?= $bahan['satuan_default'] === $satuan ? 'selected' : '' ?>>
                                                                <?= $satuan ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Harga Saat Ini</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" name="harga" class="form-control"
                                                               min="0" step="0.01"
                                                               value="<?= esc($bahan['harga']) ?>" required>
                                                    </div>
                                                    <div class="form-text">
                                                        Jika harga diubah, perubahan akan masuk riwayat harga.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#tableBahan');
    if (table) {
        new DataTable(table, {
            searchable: true,
            fixedHeight: true,
            perPage: 10, perPageSelect: [5, 10, 25, 50, 100]
        });
    }
});
</script>
<?= $this->endSection() ?>
