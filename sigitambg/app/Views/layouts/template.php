<?= $this->include('layouts/header') ?>

<?= $this->include('layouts/navbar') ?>

<div class="container-fluid mt-3">

    <?= $this->renderSection('content') ?>

</div>

<?= $this->include('layouts/footer') ?>