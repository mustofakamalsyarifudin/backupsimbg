<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- HEADER -->
        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('gizi/menu/list') ?>" class="btn btn-outline-secondary btn-sm me-2">

                <i class="bi bi-arrow-left"></i>

            </a>

            <div>

                <h5 class="mb-0">
                    Detail Menu
                </h5>

                <small class="text-muted">
                    <?= esc($sppg['sppg_name'] ?? session('id_sppg')) ?>
                </small>

            </div>

        </div>


        <!-- =====================================================
             INFORMASI MENU
        ====================================================== -->

        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <h4 class="mb-3">

                    <?= esc($menu['nama_menu']) ?>

                </h4>


                <!-- FOTO MENU -->

                <?php if (!empty($menu['foto_menu'])) : ?>

                    <div class="text-center mb-3">

                        <img src="<?= base_url(
                                        'uploads/menu/' . $menu['foto_menu']
                                    ) ?>" class="img-fluid rounded-4 shadow-sm" style="
                                max-height: 220px;
                                max-width: 100%;
                                object-fit: cover;
                            " alt="<?= esc($menu['nama_menu']) ?>">

                    </div>

                <?php endif; ?>


                <!-- KATEGORI -->

                <?php if (!empty($menu['kategori'])) : ?>

                    <div class="mb-3">

                        <span class="badge bg-primary">
                            <?= esc(
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $menu['kategori']
                                    )
                                )
                            ) ?>
                        </span>

                    </div>

                <?php endif; ?>


                <!-- CATATAN -->

                <?php if (!empty($menu['catatan'])) : ?>

                    <div class="mt-3">

                        <h6 class="mb-2">
                            Catatan
                        </h6>

                        <p class="text-muted mb-0">

                            <?= nl2br(
                                esc($menu['catatan'])
                            ) ?>

                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- =====================================================
             KOMPOSISI MENU
        ====================================================== -->

        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <h6 class="mb-3">

                    Komposisi Menu

                </h6>


                <?php if (!empty($komposisi)) : ?>

                    <div class="list-group">

                        <?php foreach ($komposisi as $item) : ?>

                            <div class="list-group-item">

                                <div class="fw-bold text-primary mb-1">

                                    <?= esc(
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $item['jenis']
                                            )
                                        )
                                    ) ?>

                                </div>

                                <div>

                                    <?= esc(
                                        $item['nama_item']
                                    ) ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>

                    <div class="text-center text-muted py-3">

                        <i class="bi bi-info-circle fs-4"></i>

                        <div class="mt-2">

                            Belum ada komposisi menu.

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- =====================================================
             INFORMASI MASTER MENU
        ====================================================== -->

        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <h6 class="mb-3">

                    Informasi Master Menu

                </h6>

                <div class="row">

                    <div class="col-6 mb-3">

                        <small class="text-muted d-block">
                            Nama Menu
                        </small>

                        <strong>
                            <?= esc($menu['nama_menu']) ?>
                        </strong>

                    </div>


                    <div class="col-6 mb-3">

                        <small class="text-muted d-block">
                            Kategori
                        </small>

                        <strong>
                            <?= esc(
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $menu['kategori']
                                    )
                                )
                            ) ?>
                        </strong>

                    </div>


                    <div class="col-6">

                        <small class="text-muted d-block">
                            Jumlah Komposisi
                        </small>

                        <strong>
                            <?= count($komposisi ?? []) ?>
                        </strong>

                        <small class="text-muted">
                            item
                        </small>

                    </div>


                    <div class="col-6">

                        <small class="text-muted d-block">
                            Dibuat
                        </small>

                        <strong>

                            <?php if (!empty($menu['created_at'])) : ?>

                                <?= date(
                                    'd-m-Y',
                                    strtotime(
                                        $menu['created_at']
                                    )
                                ) ?>

                            <?php else : ?>

                                -

                            <?php endif; ?>

                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             INFORMASI
        ====================================================== -->

        <div class="alert alert-info border-0 rounded-4">

            <div class="d-flex">

                <div class="me-2">

                    <i class="bi bi-info-circle-fill"></i>

                </div>

                <div>

                    <strong>
                        Informasi
                    </strong>

                    <div class="small mt-1">

                        Master menu dapat digunakan kembali
                        dalam penyusunan rencana menu pada
                        tanggal yang berbeda.

                    </div>

                    <div class="small mt-1">

                        Penentuan jumlah porsi, penerima manfaat,
                        dan menu khusus berdasarkan alergi akan
                        dilakukan pada tahap rencana menu dan
                        distribusi.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>