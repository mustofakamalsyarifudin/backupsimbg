<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex align-items-center mb-3">

                    <a href="<?= base_url('aslap/kegiatan') ?>" class="me-2 text-dark">

                        <i class="bi bi-arrow-left fs-4"></i>

                    </a>

                    <div>

                        <h5 class="mb-0">

                            Tambah Kegiatan

                        </h5>

                        <small class="text-muted">

                            Input kegiatan lapangan

                        </small>

                    </div>

                </div>

                <hr>

                <form action="<?= base_url(
                                    'aslap/kegiatan/store'
                                ) ?>" method="post" enctype="multipart/form-data">

                    <div class="mb-3">

                        <label class="form-label">

                            Tanggal

                        </label>

                        <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Judul Kegiatan

                        </label>

                        <input type="text" name="judul_kegiatan" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Lokasi

                        </label>

                        <input type="text" name="lokasi" class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Deskripsi

                        </label>

                        <textarea name="deskripsi" rows="5" class="form-control"></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Dokumentasi

                        </label>

                        <input type="file" name="foto[]" class="form-control" multiple accept="image/*">

                        <small class="text-muted">

                            Bisa upload beberapa foto sekaligus

                        </small>

                    </div>

                    <button type="submit" class="btn btn-primary">

                        Simpan

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>