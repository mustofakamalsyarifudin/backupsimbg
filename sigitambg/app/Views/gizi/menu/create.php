<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- FLASH MESSAGE -->
        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success alert-dismissible fade show">

                <?= session()->getFlashdata('success') ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= session()->getFlashdata('error') ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <!-- HEADER -->
        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('gizi/menu/list') ?>" class="btn btn-outline-secondary btn-sm me-2">

                <i class="bi bi-arrow-left"></i>

            </a>

            <div>

                <h5 class="mb-0">
                    Tambah Master Menu
                </h5>

                <small class="text-muted">
                    <?= esc(session('id_sppg')) ?>
                </small>

            </div>

        </div>


        <!-- CARD -->
        <div class="card shadow-sm border-0">

            <!-- HEADER CARD -->
            <div class="card-header bg-primary text-white">

                <h5 class="mb-1">

                    <i class="bi bi-cup-hot me-1"></i>

                    Form Master Menu

                </h5>

                <small>
                    Masukkan menu beserta komposisinya
                </small>

            </div>


            <div class="card-body">

                <form action="<?= base_url('gizi/menu/store') ?>" method="post" enctype="multipart/form-data">

                    <?= csrf_field() ?>


                    <!-- =====================================================
                         INFORMASI MENU
                    ====================================================== -->

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-info-circle me-1"></i>

                        Informasi Menu

                    </h6>


                    <!-- NAMA MENU -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Nama Menu

                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Ayam Sayur" value="<?= old('nama_menu') ?>" required maxlength="150">

                        <div class="form-text">

                            Gunakan nama yang jelas dan mudah dikenali.

                        </div>

                    </div>


                    <!-- KATEGORI -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Kategori Menu

                            <span class="text-danger">*</span>

                        </label>

                        <select name="kategori" class="form-select" required>

                            <option value="">
                                Pilih Kategori
                            </option>

                            <option value="makanan_utama" <?= old('kategori') === 'makanan_utama'
                                                                ? 'selected'
                                                                : '' ?>>
                                Makanan Utama
                            </option>

                            <option value="makanan_tambahan" <?= old('kategori') === 'makanan_tambahan'
                                                                    ? 'selected'
                                                                    : '' ?>>
                                Makanan Tambahan
                            </option>

                            <option value="minuman" <?= old('kategori') === 'minuman'
                                                        ? 'selected'
                                                        : '' ?>>
                                Minuman
                            </option>

                            <option value="buah" <?= old('kategori') === 'buah'
                                                        ? 'selected'
                                                        : '' ?>>
                                Buah
                            </option>

                            <option value="lainnya" <?= old('kategori') === 'lainnya'
                                                        ? 'selected'
                                                        : '' ?>>
                                Lainnya
                            </option>

                        </select>

                    </div>


                    <hr class="my-4">


                    <!-- =====================================================
                         KOMPOSISI
                    ====================================================== -->

                    <h6 class="fw-bold mb-1">

                        <i class="bi bi-list-check me-1"></i>

                        Komposisi Menu

                    </h6>

                    <p class="text-muted small mb-3">

                        Masukkan komponen yang terdapat dalam menu.

                    </p>


                    <!-- KARBOHIDRAT -->
                    <div class="mb-3">

                        <label class="form-label">

                            Karbohidrat

                        </label>

                        <input type="text" name="karbohidrat" class="form-control" placeholder="Contoh: Nasi Putih" value="<?= old('karbohidrat') ?>" maxlength="255">

                    </div>


                    <!-- PROTEIN NABATI -->
                    <div class="mb-3">

                        <label class="form-label">

                            Protein Nabati

                        </label>

                        <input type="text" name="protein_nabati" class="form-control" placeholder="Contoh: Tempe / Tahu" value="<?= old('protein_nabati') ?>" maxlength="255">

                    </div>


                    <!-- PROTEIN HEWANI -->
                    <div class="mb-3">

                        <label class="form-label">

                            Protein Hewani

                        </label>

                        <input type="text" name="protein_hewani" class="form-control" placeholder="Contoh: Ayam / Ikan / Telur" value="<?= old('protein_hewani') ?>" maxlength="255">

                    </div>


                    <!-- SAYURAN -->
                    <div class="mb-3">

                        <label class="form-label">

                            Sayuran

                        </label>

                        <input type="text" name="sayuran" class="form-control" placeholder="Contoh: Wortel + Buncis" value="<?= old('sayuran') ?>" maxlength="255">

                    </div>


                    <!-- BUAH -->
                    <div class="mb-3">

                        <label class="form-label">

                            Buah

                        </label>

                        <input type="text" name="buah" class="form-control" placeholder="Contoh: Pisang / Jeruk" value="<?= old('buah') ?>" maxlength="255">

                    </div>


                    <!-- OTHER -->
                    <div class="mb-3">

                        <label class="form-label">

                            Other / Lainnya

                        </label>

                        <input type="text" name="other" class="form-control" placeholder="Contoh: Teh / Susu / Kerupuk" value="<?= old('other') ?>" maxlength="255">

                    </div>


                    <!-- INFO PERUBAHAN KOMPOSISI -->
                    <div class="alert alert-warning border-0 rounded-3">

                        <div class="d-flex">

                            <i class="bi bi-exclamation-triangle me-2"></i>

                            <div>

                                <strong>Perhatian</strong>

                                <div class="small mt-1">

                                    Jika komposisi menu berbeda dari
                                    menu yang sudah tersimpan, buat
                                    <strong>Master Menu baru</strong>
                                    dengan nama menu yang berbeda.

                                    Menu yang sudah tersimpan tidak
                                    digunakan untuk menggantikan menu lain.

                                </div>

                            </div>

                        </div>

                    </div>


                    <hr class="my-4">


                    <!-- =====================================================
                         FOTO
                    ====================================================== -->

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-image me-1"></i>

                        Foto Menu

                    </h6>


                    <div class="mb-3">

                        <label class="form-label">

                            Foto Menu

                        </label>

                        <input type="file" name="foto_menu" id="foto_menu" class="form-control" accept="image/jpeg,image/png,image/webp">

                        <div class="form-text">

                            Format JPG, PNG, atau WEBP.

                        </div>

                    </div>


                    <!-- PREVIEW -->
                    <div class="text-center mb-3">

                        <img id="previewFoto" class="img-fluid rounded shadow-sm" style="
                                display:none;
                                max-height:250px;
                                object-fit:contain;
                            " alt="Preview Foto Menu">

                    </div>


                    <!-- =====================================================
                         CATATAN
                    ====================================================== -->

                    <div class="mb-3">

                        <label class="form-label">

                            Catatan

                        </label>

                        <textarea name="catatan" rows="3" class="form-control" placeholder="Catatan khusus menu" maxlength="1000"><?= old('catatan') ?></textarea>

                    </div>


                    <!-- =====================================================
                         BUTTON
                    ====================================================== -->

                    <div class="d-flex gap-2">

                        <a href="<?= base_url('gizi/menu/list') ?>" class="btn btn-light flex-fill">

                            <i class="bi bi-x-circle me-1"></i>

                            Batal

                        </a>


                        <button type="submit" class="btn btn-primary flex-fill">

                            <i class="bi bi-save me-1"></i>

                            Simpan Master Menu

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<?= $this->section('scripts') ?>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const input =
                document.getElementById('foto_menu');

            const preview =
                document.getElementById('previewFoto');


            if (!input || !preview) {
                return;
            }


            input.addEventListener(
                'change',
                function(event) {

                    const file =
                        event.target.files[0];


                    if (!file) {

                        preview.src = '';
                        preview.style.display = 'none';

                        return;
                    }


                    /**
                     * Pastikan file berupa gambar
                     */
                    if (
                        !file.type.startsWith('image/')
                    ) {

                        preview.src = '';
                        preview.style.display = 'none';

                        return;
                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function(e) {

                            preview.src =
                                e.target.result;

                            preview.style.display =
                                'block';

                        };


                    reader.readAsDataURL(file);

                }
            );

        }
    );
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>