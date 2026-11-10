<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login SPPG MBG</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

</head>

<body>

    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="internet-connection-status" id="internetStatus"></div>

    <div class="login-wrapper d-flex align-items-center justify-content-center">

        <div class="custom-container">

            <div class="text-center px-4">

                <img class="login-intro-img" src="<?= base_url('assets/img/logo_sigita.jpg') ?>" alt="">

                <h4 class="mt-3">
                    Satuan Pelayanan Pemenuhan Gizi
                </h4>

                <p>
                    Sistem Pengelolaan Program Makan Bergizi Gratis
                </p>

            </div>

            <div class="register-form mt-4">

                <?php if (session()->getFlashdata('error')) : ?>

                    <div class="alert alert-danger">

                        <?= session()->getFlashdata('error') ?>

                    </div>

                <?php endif; ?>

                <form method="post" action="<?= base_url('login') ?>">

                    <div class="form-group">

                        <input class="form-control" type="email" name="email" placeholder="Email" required>

                    </div>

                    <div class="form-group position-relative">

                        <input class="form-control" id="psw-input" type="password" name="password" placeholder="Password" required>

                        <div class="position-absolute" id="password-visibility">

                            <i class="bi bi-eye"></i>
                            <i class="bi bi-eye-slash"></i>

                        </div>

                    </div>

                    <button class="btn btn-primary w-100" type="submit">

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/active.js') ?>"></script>

</body>

</html>