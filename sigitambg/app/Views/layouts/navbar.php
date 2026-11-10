<div class="bg-primary text-white p-3">

    <div class="container-fluid">

        <strong>SPPG MBG</strong>

        <span class="float-end">

            <?= session('full_name') ?>

            |
            <?= session('user_level') ?>

            |
            <a href="<?= base_url('logout') ?>" class="text-white">
                Logout
            </a>

        </span>

    </div>

</div>