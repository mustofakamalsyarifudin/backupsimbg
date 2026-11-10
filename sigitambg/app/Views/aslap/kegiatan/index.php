<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">

                    Kegiatan Aslap

                </h5>

                <small class="text-muted">

                    Dokumentasi kegiatan lapangan

                </small>

            </div>

            <a href="<?= base_url(
                            'aslap/kegiatan/create'
                        ) ?>" class="btn btn-primary btn-sm">

                <i class="bi bi-plus-circle"></i>

                Tambah

            </a>

        </div>
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

                <div class="table-responsive">

                    <table id="datatable" class="table table-bordered align-middle">

                        <thead>

                            <tr>

                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Foto</th>
                                <th width="120">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($kegiatan as $item) : ?>

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
                                            $item['judul_kegiatan']
                                        ) ?>

                                    </td>

                                    <td>

                                        <?= esc(
                                            $item['lokasi']
                                        ) ?>

                                    </td>

                                    <td>

                                        <span class="badge bg-primary">

                                            <i class="bi bi-images"></i>

                                            <?= $item['total_foto'] ?>

                                            Foto

                                        </span>

                                    </td>

                                    <td>

                                        <a href="<?= base_url(
                                                        'aslap/kegiatan/detail/' .
                                                            $item['id']
                                                    ) ?>" class="btn btn-info btn-sm">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="<?= base_url(
                                                        'aslap/kegiatan/edit/' .
                                                            $item['id']
                                                    ) ?>" class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil"></i>

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
    const dataTable = new DataTable(
        "#datatable", {
            searchable: true,
            perPage: 10,
                perPageSelect: [5, 10, 25, 50, 100]
        }
    );
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>