<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- Judul -->

        <div class="mb-3">

            <h5 class="mb-1">
                Dashboard
            </h5>

            <small class="text-muted">
                Sistem Pengelolaan Program Gizi MBG
            </small>

        </div>

        <!-- Profile Card -->

        <div class="card border-0 shadow-sm mb-3" style="
                background: linear-gradient(135deg,#1e3a8a,#2563eb);
                border-radius:20px;
                overflow:hidden;
            ">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-white-50">
                            Selamat Datang
                        </small>

                        <h4 class="mt-2 mb-2 text-white fw-bold">

                            <?= session('full_name') ?>

                        </h4>

                        <p class="mb-1 text-white-50">

                            Asisten Lapangan

                        </p>

                        <small class="text-white">

                            <?= session('id_sppg') ?>

                        </small>

                    </div>

                    <div>

                        <i class="bi bi-person-badge text-white-50" style="font-size:70px;"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Warning -->

        <?php if ($belumLengkap > 0) : ?>

            <div class="alert alert-warning">

                <i class="bi bi-exclamation-triangle-fill"></i>

                Ada

                <strong>

                    <?= $belumLengkap ?>

                </strong>

                data penerima manfaat yang belum lengkap.

            </div>

        <?php endif; ?>

        <!-- Statistik -->

        <div class="row g-2 mb-3">

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-primary mb-1">

                            <?= number_format($totalPM) ?>

                        </h4>

                        <small>

                            Penerima Manfaat

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-success mb-1">

                            <?= number_format($porsiBesar) ?>

                        </h4>

                        <small>

                            Porsi Besar

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-warning mb-1">

                            <?= number_format($porsiKecil) ?>

                        </h4>

                        <small>

                            Porsi Kecil

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-danger mb-1">

                            <?= number_format($totalAlergi) ?>

                        </h4>

                        <small>

                            Total Alergi

                        </small>

                    </div>

                </div>

            </div>
            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-success mb-1">

                            <?= number_format($totalKegiatan) ?>

                        </h4>

                        <small>

                            Total Kegiatan

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h4 class="text-danger mb-1">

                            <?= 'Rp ' .
                                number_format(
                                    $pengeluaranBulanIni,
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                        </h4>

                        <small>

                            Pengeluaran Bulan Ini

                        </small>

                    </div>

                </div>

            </div>

        </div>

        <!-- Menu -->

        <div class="row g-3 mb-3">

            <div class="col-6">

                <a href="<?= base_url('aslap/penerima-manfaat') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-people-fill fs-1 text-primary"></i>

                            <h6 class="mt-2">

                                Penerima Manfaat

                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('aslap/kegiatan') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-journal-text fs-1 text-success"></i>

                            <h6 class="mt-2">

                                Kegiatan

                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('aslap/laporan') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-file-earmark-text fs-1 text-warning"></i>

                            <h6 class="mt-2">

                                Laporan

                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('aslap/pengeluaran') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm text-center">

                        <div class="card-body">

                            <i class="bi bi-cash-stack fs-1 text-danger"></i>

                            <h6 class="mt-2">

                                Pengeluaran

                            </h6>

                        </div>

                    </div>

                </a>

            </div>

        </div>

        <!-- ============================================================
     RINGKASAN PENERIMA MANFAAT PER JENJANG
============================================================ -->

        <div class="card border-0 shadow-sm mt-3">

            <div class="card-header">
                Ringkasan Penerima Manfaat
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-sm table-bordered mb-0">

                        <thead>

                            <tr>

                                <th>Jenjang</th>

                                <th width="100">
                                    Jumlah
                                </th>

                                <th width="100">
                                    Alergi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($kategori)) : ?>

                                <?php foreach ($kategori as $item) : ?>

                                    <tr>

                                        <td>

                                            <?= esc(
                                                $item['jenjang']
                                                    ?? 'Tidak diketahui'
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= number_format(
                                                (int) ($item['total']
                                                    ?? 0
                                                )
                                            ) ?>

                                        </td>

                                        <td>

                                            <span class="badge bg-danger">

                                                <?= number_format(
                                                    (int) ($item['total_alergi']
                                                        ?? 0
                                                    )
                                                ) ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="3" class="text-center text-muted">

                                        Belum ada data

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>