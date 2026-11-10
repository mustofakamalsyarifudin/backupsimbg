<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- Header -->

        <div class="mb-3">

            <h5 class="mb-1">
                Dashboard
            </h5>

            <small class="text-muted">
                Sistem Pengelolaan Program Gizi MBG
            </small>

        </div>

        <!-- Card User -->

        <div class="card border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#1d4ed8,#2563eb); border-radius:20px;">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-white-50">
                            Selamat Datang
                        </small>

                        <h4 class="text-white mb-1">
                            <?= session('full_name') ?>
                        </h4>

                        <p class="text-white-50 mb-1">
                            Petugas Gizi
                        </p>

                        <span class="badge bg-light text-primary fs-6">
                            <?= esc($sppg['sppg_name']) ?>
                        </span>
                    </div>

                    <div>

                        <i class="bi bi-person-circle text-white" style="font-size:60px;"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Menu Cepat -->

        <div class="row g-3 mb-4">
            <div class="col-12">

                <a href="<?= base_url('gizi/rencana-menu') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 rounded-4">

                        <div class="card-body text-center py-3">

                            <i class="bi bi-menu-up text-danger" style="font-size:40px;"></i>

                            <h6 class="mt-2 mb-0">
                                Rancang Menu Harian
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('gizi/kegiatan') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 rounded-4">

                        <div class="card-body text-center py-3">

                            <i class="bi bi-calendar-check-fill text-primary" style="font-size:40px;"></i>

                            <h6 class="mt-2 mb-0">
                                Kegiatan
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('gizi/menu/list') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 rounded-4">

                        <div class="card-body text-center py-3">

                            <i class="bi bi-card-list text-success" style="font-size:40px;"></i>

                            <h6 class="mt-2 mb-0">
                                Daftar Menu
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('gizi/bahan-baku') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 rounded-4">

                        <div class="card-body text-center py-3">

                            <i class="bi bi-basket2-fill text-warning" style="font-size:40px;"></i>

                            <h6 class="mt-2 mb-0">
                                Bahan Baku
                            </h6>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('gizi/data-pm') ?>" class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 rounded-4">

                        <div class="card-body text-center py-3">

                            <i class="bi bi-graph-up-arrow text-danger" style="font-size:40px;"></i>

                            <h6 class="mt-2 mb-0">
                                Penerima Manfaat
                            </h6>

                        </div>

                    </div>

                </a>

            </div>
        </div>

        <!-- Ringkasan -->

        <div class="mb-3">

            <h6>
                Ringkasan Gizi
            </h6>

        </div>

        <div class="row g-3 mb-4">

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h3 class="text-primary">

                            <?= number_format(
                                $totalPM
                            ) ?>

                        </h3>

                        <small>

                            Total PM

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h3 class="text-success">

                            <?= number_format(
                                $porsiBesar
                            ) ?>

                        </h3>

                        <small>

                            Porsi Besar

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h3 class="text-warning">

                            <?= number_format(
                                $porsiKecil
                            ) ?>

                        </h3>

                        <small>

                            Porsi Kecil

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h3 class="text-danger">

                            <?= number_format(
                                $totalAlergi
                            ) ?>

                        </h3>

                        <small>

                            PM Alergi

                        </small>

                    </div>

                </div>

            </div>

        </div>
        <!-- Menu Terakhir -->

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="mb-3">

                    Menu Terakhir

                </h6>

                <a href="<?= base_url('gizi/menu/list') ?>" class="list-group-item list-group-item-action rounded">

                    <i class="bi bi-clock-history"></i>

                    Lihat seluruh menu yang telah dibuat

                </a>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>