<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="mb-3">

            <h5 class="mb-1">
                Tambah User
            </h5>

            <small class="text-muted">
                <?= session('id_sppg') ?>
            </small>

        </div>

        <div class="card">

            <div class="card-body">
                <?php if (session()->getFlashdata('error')) : ?>

                    <div class="alert alert-danger">

                        <?= session()->getFlashdata('error') ?>

                    </div>

                <?php endif; ?>
                <form action="<?= base_url('master/users/store') ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input type="text" name="full_name" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" name="email" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password" name="password" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Level User
                        </label>

                        <select name="user_level" class="form-select" required>

                            <option value="">
                                Pilih Level
                            </option>

                            <option value="gizi">
                                Gizi
                            </option>

                            <option value="keuangan">
                                Keuangan
                            </option>

                            <option value="aslap">
                                Aslap
                            </option>

                        </select>

                    </div>

                    <button type="submit" class="btn btn-primary w-100">

                        Simpan User

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>