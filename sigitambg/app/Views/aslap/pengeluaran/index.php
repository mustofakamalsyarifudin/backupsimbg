<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('success') ?>

            </div>

        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">

                    Pengeluaran Aslap

                </h5>

                <small class="text-muted">

                    Data biaya operasional lapangan

                </small>

            </div>

            <a href="<?= base_url(
                            'aslap/pengeluaran/create'
                        ) ?>"
                class="btn btn-primary btn-sm">

                <i class="bi bi-plus-circle"></i>

                Tambah

            </a>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table
                        id="datatable"
                        class="table table-bordered align-middle">

                        <thead>

                            <tr>

                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                                <th width="120">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($pengeluaran as $item) : ?>

                                <tr>

                                    <td>

                                        <?= date(
                                            'd-m-Y',
                                            strtotime(
                                                $item['tanggal']
                                            )
                                        ) ?>

                                    </td>

                                    <td>

                                        <?= esc(
                                            $item['kategori']
                                        ) ?>

                                    </td>

                                    <td class="text-end">

                                        <strong class="text-success">

                                            Rp <?= number_format(
                                                    $item['nominal'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>

                                        </strong>

                                    </td>

                                    <td>

                                        <span class="badge bg-info">

                                            <?= esc(
                                                $item['metode_pembayaran']
                                            ) ?>

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <?php if (
                                            !empty($item['foto_bukti'])
                                        ) : ?>

                                            <img
                                                src="<?= base_url(
                                                            'uploads/pengeluaran/' .
                                                                $item['foto_bukti']
                                                        ) ?>"
                                                width="50"
                                                height="50"
                                                style="
                                                    object-fit:cover;
                                                    border-radius:8px;
                                                ">

                                        <?php else : ?>

                                            -

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <a href="<?= base_url(
                                                        'aslap/pengeluaran/detail/' .
                                                            $item['id']
                                                    ) ?>"
                                            class="btn btn-info btn-sm">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="<?= base_url(
                                                        'aslap/pengeluaran/edit/' .
                                                            $item['id']
                                                    ) ?>"
                                            class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <a href="<?= base_url(
                                                        'aslap/pengeluaran/delete/' .
                                                            $item['id']
                                                    ) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus data ini?')">

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->section('scripts') ?>

<script>
    if (
        document.querySelector(
            '#datatable'
        )
    ) {

        new DataTable(
            '#datatable', {
                searchable: true,
                perPage: 10,
                perPageSelect: [5, 10, 25, 50, 100]
            }
        );

    }
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>