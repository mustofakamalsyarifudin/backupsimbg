<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? 'SPPG MBG' ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/vanilla-dataTables.min.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>

    <!-- Header -->

    <div class="header-area" id="headerArea">

        <div class="container">

            <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">

                <!-- <div class="back-button">
                    <a href="#">
                        <i class="bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#menuSPPG"></i>
                    </a>
                </div> -->

                <div class="page-heading">
                    <h6 class="mb-0">SPPG MBG</h6>
                </div>

                <div>
                    <a href="<?= base_url('logout') ?>">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- Sidebar -->

    <!-- <div class="offcanvas offcanvas-start" tabindex="-1" id="menuSPPG">

        <div class="offcanvas-header">

            <h5>
                <?= session('full_name') ?>
            </h5>

            <button class="btn-close" data-bs-dismiss="offcanvas"></button>

        </div>

        <div class="offcanvas-body">

            <ul class="list-group">

                <li class="list-group-item">
                    Dashboard
                </li>

                <li class="list-group-item">
                    Profil
                </li>

                <li class="list-group-item">
                    Logout
                </li>

            </ul>

        </div>

    </div> -->

    <!-- Content -->

    <?= $this->renderSection('content') ?>

    <!-- Bottom Menu -->

    <div class="footer-nav-area" id="footerNav">

        <div class="container px-0">

            <div class="footer-nav position-relative">

                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">

                    <li class="active">
                        <a href="<?= base_url('dashboard') ?>">
                            <i class="bi bi-house"></i>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <!-- <a href="#">
                            <i class="bi bi-grid"></i>
                            Menu
                        </a> -->
                    </li>

                    <li>
                        <a href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/active.js') ?>"></script>
    <script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>