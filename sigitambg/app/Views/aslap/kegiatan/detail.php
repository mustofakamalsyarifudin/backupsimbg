<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">
        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('success') ?>

            </div>

        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger">

                <?= session()->getFlashdata('error') ?>

            </div>

        <?php endif; ?>
        <div class="card border-0 shadow-sm">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <a href="<?= base_url('aslap/kegiatan') ?>" class="btn btn-secondary btn-sm">

                        <i class="bi bi-arrow-left"></i>

                        Kembali

                    </a>

                    <div>

                        <a href="<?= base_url(
                                        'aslap/kegiatan/edit/' .
                                            $kegiatan['id']
                                    ) ?>" class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil"></i>

                            Edit

                        </a>

                        <a href="<?= base_url(
                                        'aslap/kegiatan/delete/' .
                                            $kegiatan['id']
                                    ) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kegiatan ini?')">

                            <i class="bi bi-trash"></i>

                            Hapus

                        </a>

                    </div>

                </div>

                <h5>

                    <?= esc(
                        $kegiatan['judul_kegiatan']
                    ) ?>

                </h5>

                <p class="text-muted">

                    <?= date(
                        'd-m-Y',
                        strtotime(
                            $kegiatan['tanggal']
                        )
                    ) ?>

                </p>

                <p>

                    <strong>Lokasi :</strong>

                    <?= esc(
                        $kegiatan['lokasi']
                    ) ?>

                </p>

                <p>

                    <?= nl2br(
                        esc(
                            $kegiatan['deskripsi']
                        )
                    ) ?>

                </p>

            </div>

        </div>
        <div class="card border-0 shadow-sm mt-3">

            <div class="card-body">

                <form action="<?= base_url(
                                    'aslap/kegiatan/upload-foto/' .
                                        $kegiatan['id']
                                ) ?>" method="post" enctype="multipart/form-data">

                    <label class="form-label">

                        Tambah Dokumentasi

                    </label>

                    <input type="file" name="foto[]" class="form-control" multiple accept="image/*">

                    <button type="submit" class="btn btn-primary btn-sm mt-2">

                        <i class="bi bi-upload"></i>

                        Upload Foto

                    </button>

                </form>

            </div>

        </div>

        <div class="row mt-3">

            <?php foreach ($foto as $item) : ?>

                <div class="col-6 mb-3">

                    <div class="card border-0 shadow-sm">

                        <img src="<?= base_url(
                                        'uploads/kegiatan/' .
                                            $item['foto']
                                    ) ?>" class="img-fluid rounded-top">

                        <div class="card-body p-2 text-center">

                            <a href="<?= base_url(
                                            'aslap/kegiatan/delete-foto/' .
                                                $item['id']
                                        ) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus foto ini?')">

                                <i class="bi bi-trash"></i>

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>