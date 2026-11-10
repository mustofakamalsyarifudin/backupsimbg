<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('gizi/kegiatan') ?>" class="btn btn-outline-secondary btn-sm me-2">

                <i class="bi bi-arrow-left"></i>

            </a>

            <div>

                <h5 class="mb-0">

                    Detail Kegiatan

                </h5>

                <small class="text-muted">

                    Informasi kegiatan Ahli Gizi

                </small>

            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <span class="badge bg-<?= esc($kegiatan['warna']) ?>">

                        <i class="bi <?= esc($kegiatan['icon']) ?>"></i>

                        <?= esc($kegiatan['nama_kegiatan']) ?>

                    </span>

                    <small class="text-muted">

                        <?= date('d-m-Y', strtotime($kegiatan['tanggal'])) ?>

                    </small>

                </div>

                <hr>

                <div class="mb-2">

                    <i class="bi bi-geo-alt-fill text-danger"></i>

                    <?= esc($kegiatan['lokasi_nama']) ?>

                </div>

                <div class="mb-2">

                    <i class="bi bi-person-fill text-primary"></i>

                    <?= session('full_name') ?>

                </div>

                <div class="mb-3">

                    <i class="bi bi-images text-success"></i>

                    <?= count($foto) ?> Dokumentasi

                </div>

                <div class="border rounded-3 p-3 bg-light">

                    <?= nl2br(esc($kegiatan['deskripsi'])) ?>

                </div>

            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-3">

            <div class="card-body">

                <h6 class="mb-3">

                    Dokumentasi

                </h6>

                <?php if (empty($foto)) : ?>

                    <div class="text-center text-muted py-4">

                        <i class="bi bi-images fs-1"></i>

                        <p class="mb-0">

                            Belum ada dokumentasi.

                        </p>

                    </div>

                <?php else : ?>

                    <div class="row">

                        <?php foreach ($foto as $f) : ?>

                            <div class="col-6 mb-3">

                                <a href="<?= base_url('uploads/kegiatan/' . $f['foto']) ?>" target="_blank">

                                    <img src="<?= base_url('uploads/kegiatan/' . $f['foto']) ?>" class="img-fluid rounded shadow-sm">

                                </a>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="row mt-3">

            <div class="col-6">

                <a href="<?= base_url('gizi/kegiatan/edit/' . $kegiatan['id']) ?>" class="btn btn-warning w-100">

                    <i class="bi bi-pencil"></i>

                    Edit

                </a>

            </div>

            <div class="col-6">

                <a href="<?= base_url('gizi/kegiatan/delete/' . $kegiatan['id']) ?>" onclick="return confirm('Yakin menghapus kegiatan ini?')" class="btn btn-danger w-100">

                    <i class="bi bi-trash"></i>

                    Hapus

                </a>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>