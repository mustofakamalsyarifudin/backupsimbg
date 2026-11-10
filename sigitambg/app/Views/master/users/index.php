<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h5 class="mb-0">Manajemen User</h5>
                <small class="text-muted">
                    <?= session('id_sppg') ?>
                </small>
            </div>

            <a href="<?= base_url('master/users/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>

        </div>

        <!-- Search -->

        <div class="mb-3">

            <input type="text" class="form-control" id="searchUser" placeholder="Cari nama atau email user...">

        </div>

        <!-- User List -->

        <div id="userList">

            <?php foreach ($users as $user) : ?>

                <div class="card mb-3 user-card">

                    <div class="card-body">

                        <h6 class="mb-1">
                            <?= esc($user['full_name']) ?>
                        </h6>

                        <p class="text-muted mb-2">
                            <?= esc($user['email']) ?>
                        </p>

                        <div class="mb-2">

                            <span class="badge bg-primary">
                                <?= ucfirst($user['user_level']) ?>
                            </span>

                            <span class="badge bg-secondary">
                                <?= esc($user['id_sppg']) ?>
                            </span>

                        </div>

                        <div class="d-flex gap-2">

                            <a href="#" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>

                            <a href="#" class="btn btn-info btn-sm">
                                <i class="bi bi-key"></i>
                                Reset
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    document.getElementById('searchUser').addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();

        document.querySelectorAll('.user-card').forEach(function(card) {

            let text = card.innerText.toLowerCase();

            if (text.includes(keyword)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }

        });

    });
</script>

<?= $this->endSection() ?>