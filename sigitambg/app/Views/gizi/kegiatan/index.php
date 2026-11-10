<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- Header -->

        <div class="mb-3">

            <h5 class="mb-1">

                Kegiatan Gizi

            </h5>

            <small class="text-muted">

                Catat seluruh aktivitas Ahli Gizi setiap hari.

            </small>

        </div>

        <!-- Tombol Tambah -->

        <div class="mb-3 text-end">

            <a href="<?= base_url('gizi/kegiatan/create') ?>" class="btn btn-primary rounded-pill">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah Kegiatan

            </a>

        </div>

        <!-- Search -->

        <?php if (!empty($kegiatan)) : ?>

            <div class="mb-3">

                <input type="text" id="searchKegiatan" class="form-control" placeholder="Cari kegiatan, lokasi atau deskripsi...">

            </div>

        <?php endif; ?>

        <!-- Empty Data -->

        <?php if (empty($kegiatan)) : ?>

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="bi bi-journal-x fs-1 text-secondary"></i>

                    <h5 class="mt-3">

                        Belum Ada Kegiatan

                    </h5>

                    <p class="text-muted mb-4">

                        Catat kegiatan monitoring, edukasi,
                        maupun evaluasi yang dilakukan hari ini.

                    </p>

                    <a href="<?= base_url('gizi/kegiatan/create') ?>" class="btn btn-primary rounded-pill">

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Kegiatan

                    </a>

                </div>

            </div>

        <?php else : ?>

            <!-- Jika hasil pencarian kosong -->

            <div id="emptySearch" class="card border-0 shadow-sm rounded-4 d-none">

                <div class="card-body text-center py-5">

                    <i class="bi bi-search fs-1 text-secondary"></i>

                    <h6 class="mt-3">

                        Data tidak ditemukan

                    </h6>

                    <small class="text-muted">

                        Coba gunakan kata kunci yang lain.

                    </small>

                </div>

            </div>

            <!-- List Card -->

            <?php foreach ($kegiatan as $row) : ?>

                <div class="card border-0 shadow-sm rounded-4 mb-3 kegiatan-card" data-search="<?= strtolower(

                                                                                                    $row['nama_kegiatan'] . ' ' .
                                                                                                        $row['lokasi_nama'] . ' ' .
                                                                                                        $row['tanggal'] . ' ' .
                                                                                                        strip_tags($row['deskripsi'])

                                                                                                ) ?>">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <span class="badge bg-<?= esc($row['warna']) ?>">

                                <i class="bi <?= esc($row['icon']) ?>"></i>

                                <?= esc($row['nama_kegiatan']) ?>

                            </span>

                            <small class="text-muted">

                                <?= date('d-m-Y', strtotime($row['tanggal'])) ?>

                            </small>

                        </div>

                        <h6 class="mt-3 mb-1">

                            <i class="bi bi-geo-alt-fill text-danger"></i>

                            <?= esc($row['lokasi_nama']) ?>

                        </h6>

                        <p class="text-muted mb-3">

                            <?= character_limiter(

                                strip_tags($row['deskripsi']),

                                100

                            ) ?>

                        </p>

                        <div class="d-flex justify-content-between align-items-center">

                            <small class="text-muted">

                                <i class="bi bi-images"></i>

                                <?= $row['jumlah_foto'] ?> Foto

                            </small>

                            <a href="<?= base_url('gizi/kegiatan/detail/' . $row['id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill">

                                Detail

                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.getElementById('searchKegiatan');

        if (!input) return;

        input.addEventListener('keyup', function() {

            let keyword = this.value.toLowerCase();

            let cards = document.querySelectorAll('.kegiatan-card');

            let tampil = 0;

            cards.forEach(function(card) {

                let isi = card.dataset.search;

                if (isi.indexOf(keyword) > -1) {

                    card.style.display = '';

                    tampil++;

                } else {

                    card.style.display = 'none';

                }

            });

            const kosong = document.getElementById('emptySearch');

            if (kosong) {

                if (tampil == 0) {

                    kosong.classList.remove('d-none');

                } else {

                    kosong.classList.add('d-none');

                }

            }

        });

    });
</script>

<?= $this->endSection() ?>