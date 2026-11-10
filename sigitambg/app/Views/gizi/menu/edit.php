<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- FLASH MESSAGE -->
        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success alert-dismissible fade show">

                <?= esc(session()->getFlashdata('success')) ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= esc(session()->getFlashdata('error')) ?>

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
                    Edit Master Menu
                </h5>

                <small class="text-muted">

                    <?= esc(
                        $sppg['sppg_name']
                            ?? session('id_sppg')
                    ) ?>

                </small>

            </div>

        </div>


        <!-- FORM -->
        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-primary text-white rounded-top-4">

                <h5 class="mb-1">

                    <i class="bi bi-cup-hot me-1"></i>

                    Edit Master Menu

                </h5>

                <small>
                    Perbarui informasi dan komposisi menu
                </small>

            </div>


            <div class="card-body">

                <form action="<?= base_url(
                                    'gizi/menu/update/' . $menu['id']
                                ) ?>" method="post" enctype="multipart/form-data">

                    <?= csrf_field() ?>


                    <!-- NAMA MENU -->
                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Nama Menu
                            <span class="text-danger">*</span>

                        </label>

                        <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Ayam Sayur" value="<?= esc(
                                                                                                                                    $menu['nama_menu'] ?? ''
                                                                                                                                ) ?>" required>

                    </div>


                    <!-- KATEGORI -->
                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Kategori
                            <span class="text-danger">*</span>

                        </label>

                        <select name="kategori" class="form-select" required>

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            <option value="makanan_utama" <?= ($menu['kategori'] ?? '') === 'makanan_utama'
                                                                ? 'selected'
                                                                : '' ?>>
                                Makanan Utama
                            </option>

                            <option value="makanan_tambahan" <?= ($menu['kategori'] ?? '') === 'makanan_tambahan'
                                                                    ? 'selected'
                                                                    : '' ?>>
                                Makanan Tambahan
                            </option>

                            <option value="minuman" <?= ($menu['kategori'] ?? '') === 'minuman'
                                                        ? 'selected'
                                                        : '' ?>>
                                Minuman
                            </option>

                            <option value="buah" <?= ($menu['kategori'] ?? '') === 'buah'
                                                        ? 'selected'
                                                        : '' ?>>
                                Buah
                            </option>

                            <option value="lainnya" <?= ($menu['kategori'] ?? '') === 'lainnya'
                                                        ? 'selected'
                                                        : '' ?>>
                                Lainnya
                            </option>

                        </select>

                    </div>


                    <hr class="my-4">


                    <!-- KOMPOSISI -->
                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-list-check me-1"></i>

                        Komposisi Menu

                    </h6>

                    <div class="alert alert-info small">

                        <i class="bi bi-info-circle me-1"></i>

                        Komposisi merupakan bagian dari Master Menu.
                        Jika komposisi diubah, menu dapat dianggap
                        sebagai varian/menu baru pada tahap
                        penyusunan rencana menu.

                    </div>


                    <!-- KARBOHIDRAT -->
                    <div class="mb-3">

                        <label class="form-label">

                            Karbohidrat

                        </label>

                        <input type="text" name="karbohidrat" class="form-control" placeholder="Contoh: Nasi Putih, Kentang, Roti" value="<?= esc(
                                                                                                                                                $komposisi['karbohidrat'] ?? ''
                                                                                                                                            ) ?>">

                    </div>


                    <!-- PROTEIN NABATI -->
                    <div class="mb-3">

                        <label class="form-label">

                            Protein Nabati

                        </label>

                        <input type="text" name="protein_nabati" class="form-control" placeholder="Contoh: Tempe, Tahu" value="<?= esc(
                                                                                                                                    $komposisi['protein_nabati'] ?? ''
                                                                                                                                ) ?>">

                    </div>


                    <!-- PROTEIN HEWANI -->
                    <div class="mb-3">

                        <label class="form-label">

                            Protein Hewani

                        </label>

                        <input type="text" name="protein_hewani" class="form-control" placeholder="Contoh: Ayam, Ikan, Telur" value="<?= esc(
                                                                                                                                            $komposisi['protein_hewani'] ?? ''
                                                                                                                                        ) ?>">

                    </div>


                    <!-- SAYURAN -->
                    <div class="mb-3">

                        <label class="form-label">

                            Sayuran

                        </label>

                        <input type="text" name="sayuran" class="form-control" placeholder="Contoh: Bayam, Wortel" value="<?= esc(
                                                                                                                                $komposisi['sayuran'] ?? ''
                                                                                                                            ) ?>">

                    </div>


                    <!-- BUAH -->
                    <div class="mb-3">

                        <label class="form-label">

                            Buah

                        </label>

                        <input type="text" name="buah" class="form-control" placeholder="Contoh: Pisang, Jeruk" value="<?= esc(
                                                                                                                            $komposisi['buah'] ?? ''
                                                                                                                        ) ?>">

                    </div>


                    <!-- OTHER -->
                    <div class="mb-3">

                        <label class="form-label">

                            Other / Lainnya

                        </label>

                        <input type="text" name="other" class="form-control" placeholder="Contoh: Susu, Teh, Kerupuk, dll" value="<?= esc(
                                                                                                                                        $komposisi['other'] ?? ''
                                                                                                                                    ) ?>">

                    </div>


                    <!-- CATATAN -->
                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Catatan

                        </label>

                        <textarea name="catatan" rows="3" class="form-control" placeholder="Catatan khusus mengenai menu"><?= esc(
                                                                                                                                $menu['catatan'] ?? ''
                                                                                                                            ) ?></textarea>

                    </div>


                    <!-- FOTO LAMA -->
                    <?php if (!empty($menu['foto_menu'])) : ?>

                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Foto Menu Saat Ini

                            </label>

                            <div class="text-center">

                                <img src="<?= base_url(
                                                'uploads/menu/' .
                                                    $menu['foto_menu']
                                            ) ?>" class="img-fluid rounded-4 shadow-sm" style="
                                        max-height:250px;
                                        max-width:100%;
                                        object-fit:cover;
                                    " alt="<?= esc(
                                                $menu['nama_menu']
                                            ) ?>">

                            </div>

                        </div>

                    <?php endif; ?>


                    <!-- FOTO BARU -->
                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Ganti Foto Menu

                        </label>

                        <input type="file" name="foto_menu" class="form-control" accept="image/*" capture="environment">

                        <small class="text-muted">

                            Kosongkan jika tidak ingin mengganti
                            foto menu.

                        </small>

                    </div>


                    <!-- TOMBOL -->
                    <div class="d-flex gap-2">

                        <a href="<?= base_url(
                                        'gizi/menu/list'
                                    ) ?>" class="btn btn-outline-secondary flex-fill">

                            <i class="bi bi-arrow-left me-1"></i>

                            Batal

                        </a>


                        <button type="submit" class="btn btn-primary flex-fill">

                            <i class="bi bi-save me-1"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>