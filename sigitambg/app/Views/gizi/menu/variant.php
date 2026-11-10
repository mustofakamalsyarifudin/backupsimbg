<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <form method="post"
              action="<?= base_url('gizi/menu/varian/store/' . $master['id']) ?>">

            <?= csrf_field() ?>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <a href="<?= base_url('gizi/menu/detail/' . $master['id']) ?>"
                           class="btn btn-outline-secondary btn-sm me-2">
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        <div>
                            <h5 class="mb-0">Buat Varian Menu</h5>
                            <small class="text-muted">
                                Dasar: <?= esc($master['nama_menu']) ?>
                            </small>
                        </div>
                    </div>

                    <?php if (session('error')) : ?>
                        <div class="alert alert-danger">
                            <?= esc(session('error')) ?>
                        </div>
                    <?php endif; ?>

                    <div class="alert alert-info">
                        Master Menu <strong><?= esc($master['nama_menu']) ?></strong>
                        tidak diubah. Sistem membuat salinan baru yang dapat diedit.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Nama Menu Varian <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="nama_menu"
                               class="form-control"
                               value="<?= esc(old('nama_menu', $master['nama_menu'] . ' - Varian')) ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>

                        <select name="kategori" class="form-select">
                            <?php foreach ($categories as $cat) :
                                $value = $cat['kategori'];
                            ?>
                                <option value="<?= esc($value) ?>"
                                    <?= old('kategori', $master['kategori'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= esc(ucwords(str_replace('_', ' ', $value))) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan</label>

                        <textarea name="catatan"
                                  class="form-control"
                                  rows="3"><?= esc(old('catatan', $master['catatan'] ?? '')) ?></textarea>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">

                    <h6 class="mb-3">Komposisi Menu</h6>

                    <?php
                    $fields = [
                        'karbohidrat'    => 'Karbohidrat',
                        'protein_nabati' => 'Protein Nabati',
                        'protein_hewani' => 'Protein Hewani',
                        'sayuran'        => 'Sayuran',
                        'buah'           => 'Buah',
                        'other'          => 'Lainnya',
                    ];
                    ?>

                    <?php foreach ($fields as $name => $label) : ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <?= esc($label) ?>
                            </label>

                            <input type="text"
                                   name="<?= esc($name) ?>"
                                   class="form-control"
                                   value="<?= esc(old($name, $komposisi[$name] ?? '')) ?>">
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

            <div class="d-flex gap-2 mb-4">
                <a href="<?= base_url('gizi/menu/detail/' . $master['id']) ?>"
                   class="btn btn-outline-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-copy me-1"></i>
                    Buat Varian
                </button>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>
