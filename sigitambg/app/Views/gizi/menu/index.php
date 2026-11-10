<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-0">
                    Daftar Menu
                </h5>

                <small class="text-muted">
                    <?= esc($sppg['sppg_name']) ?>
                </small>

            </div>
            <a href="<?= base_url('gizi/menu/create') ?>" class="btn btn-primary btn-sm">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah

            </a>

        </div>

        <!-- Card Table -->

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <table class="w-100" id="tableMenu">

                    <thead>

                        <tr>

                            <th>
                                Nama Menu
                            </th>

                            <th>Komposisi</th>

                            <th width="20%">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($menus as $menu) : ?>

                            <tr>

                                <td>

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <br>

                                            <strong>

                                                <?= esc($menu['nama_menu']) ?>

                                            </strong>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    <?php if (!empty($menu['komposisi'])) : ?>

                                        <?php
                                        $items = array_map(
                                            static fn($item) => $item['nama_item'],
                                            $menu['komposisi']
                                        );
                                        ?>

                                        <?= esc(implode(' • ', $items)) ?>

                                    <?php else : ?>

                                        <span class="text-muted">
                                            Belum ada komposisi
                                        </span>

                                    <?php endif; ?>
                                </td>


                                <td>

                                    <div class="d-flex gap-1">

                                        <a href="<?= base_url('gizi/menu/detail/' . $menu['id']) ?>" class="btn btn-sm btn-primary">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="<?= base_url('gizi/menu/edit/' . $menu['id']) ?>" class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <a href="<?= base_url('gizi/menu/delete/' . $menu['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus menu ini?')">

                                            <i class="bi bi-trash"></i>

                                        </a>
                                        <a href="<?= base_url('gizi/menu/varian/' . $menu['id']) ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-copy me-1"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        let table = document.querySelector("#tableMenu");

        if (table) {

            new DataTable(table, {

                searchable: true,

                fixedHeight: true,

                perPage: 10,
                perPageSelect: [5, 10, 25, 50, 100]

            });

        }

    });
</script>

<?= $this->endSection() ?>