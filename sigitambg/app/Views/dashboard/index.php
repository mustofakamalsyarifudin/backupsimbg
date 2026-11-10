<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="card bg-primary mb-3">

            <div class="card-body text-white">

                <h4>
                    Halo,
                    <?= session('full_name') ?>
                </h4>

                <p class="mb-1">
                    SPPG :
                    <?= session('id_sppg') ?>
                </p>

                <p class="mb-0">
                    Level :
                    <?= ucfirst(session('user_level')) ?>
                </p>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>