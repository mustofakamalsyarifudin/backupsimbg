<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url(
                            'aslap/pengeluaran'
                        ) ?>"
                class="me-2 text-dark">

                <i class="bi bi-arrow-left fs-4"></i>

            </a>

            <div>

                <h5 class="mb-0">

                    Detail Pengeluaran

                </h5>

                <small class="text-muted">

                    Informasi pengeluaran

                </small>

            </div>

        </div>

        <?php if (
            session()->getFlashdata(
                'success'
            )
        ) : ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata(
                    'success'
                ) ?>

            </div>

        <?php endif; ?>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="mb-3">

                    <strong>Tanggal</strong>

                    <br>

                    <?= date(
                        'd-m-Y',
                        strtotime(
                            $pengeluaran['tanggal']
                        )
                    ) ?>

                </div>

                <div class="mb-3">

                    <strong>Kategori</strong>

                    <br>

                    <?= esc(
                        $pengeluaran['kategori']
                    ) ?>

                </div>

                <div class="mb-3">

                    <strong>Nominal</strong>

                    <br>

                    <span class="text-success fw-bold">

                        Rp <?= number_format(
                                $pengeluaran['nominal'],
                                0,
                                ',',
                                '.'
                            ) ?>

                    </span>

                </div>

                <div class="mb-3">

                    <strong>Metode Pembayaran</strong>

                    <br>

                    <?= esc(
                        $pengeluaran['metode_pembayaran']
                    ) ?>

                </div>

                <div class="mb-3">

                    <strong>Uraian</strong>

                    <br>

                    <?= nl2br(
                        esc(
                            $pengeluaran['uraian']
                        )
                    ) ?>

                </div>

                <?php if (
                    !empty($pengeluaran['foto_bukti'])
                ) : ?>

                    <div class="mb-3">

                        <strong>

                            Bukti Pengeluaran

                        </strong>

                        <br><br>

                        <img
                            src="<?= base_url(
                                        'uploads/pengeluaran/' .
                                            $pengeluaran['foto_bukti']
                                    ) ?>"
                            class="img-fluid rounded shadow-sm">

                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="mt-3 d-flex gap-2">

            <a href="<?= base_url(
                            'aslap/pengeluaran/edit/' .
                                $pengeluaran['id']
                        ) ?>"
                class="btn btn-warning">

                <i class="bi bi-pencil"></i>

                Edit

            </a>

            <a href="<?= base_url(
                            'aslap/pengeluaran/delete/' .
                                $pengeluaran['id']
                        ) ?>"
                class="btn btn-danger"
                onclick="return confirm('Hapus data ini?')">

                <i class="bi bi-trash"></i>

                Hapus

            </a>

        </div>

    </div>

</div>

<?= $this->endSection() ?>