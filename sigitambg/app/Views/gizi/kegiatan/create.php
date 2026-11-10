<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- Header -->

        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('gizi/kegiatan') ?>" class="btn btn-outline-secondary btn-sm me-2">

                <i class="bi bi-arrow-left"></i>

            </a>

            <div>

                <h5 class="mb-0">

                    Tambah Kegiatan

                </h5>

                <small class="text-muted">

                    Catat aktivitas harian Ahli Gizi

                </small>

            </div>

        </div>

        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger">

                <?= session()->getFlashdata('error') ?>

            </div>

        <?php endif; ?>

        <form action="<?= base_url('gizi/kegiatan/store') ?>" method="post" enctype="multipart/form-data">

            <?= csrf_field() ?>

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h6 class="mb-3">

                        Informasi Kegiatan

                    </h6>

                    <!-- tanggal -->

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Tanggal

                        </label>

                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>

                    </div>

                    <!-- jenis -->

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Jenis Kegiatan

                        </label>

                        <select name="jenis_kegiatan_id" id="jenis" class="form-select select2" required>

                            <option value="">

                                Pilih Jenis Kegiatan

                            </option>

                            <?php foreach ($jenis as $j) : ?>

                                <option value="<?= $j['id'] ?>" data-icon="<?= esc($j['icon']) ?>" data-warna="<?= esc($j['warna']) ?>">

                                    <?= esc($j['nama_kegiatan']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <!-- preview badge -->

                    <div id="previewJenis" class="mb-3">

                    </div>

                    <!-- lokasi -->

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Lokasi

                        </label>

                        <select id="lokasi" name="lokasi" class="form-select select2" required>

                            <option value="">
                                Pilih Lokasi
                            </option>

                            <?php foreach ($sekolah as $nama) : ?>

                                <option value="<?= esc($nama) ?>">

                                    🏫 <?= esc($nama) ?>

                                </option>

                            <?php endforeach; ?>

                            <option disabled>
                                ───────────────
                            </option>

                            <option value="Dapur SPPG">

                                🏢 Dapur SPPG

                            </option>

                            <option value="Gudang">

                                📦 Gudang

                            </option>

                            <option disabled>
                                ───────────────
                            </option>

                            <option value="lainnya">

                                📍 Lainnya

                            </option>

                        </select>

                    </div>


                    <!-- lokasi lain -->

                    <div id="lokasiLain" class="d-none">

                        <input type="text" name="lokasi_manual" class="form-control" placeholder="Masukkan lokasi">

                    </div>

                    <!-- deskripsi -->

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Deskripsi

                        </label>

                        <textarea name="deskripsi" rows="5" class="form-control" placeholder="Tuliskan kegiatan yang dilakukan..." required></textarea>

                    </div>

                </div>

            </div>

            <!-- FOTO -->

            <div class="card border-0 shadow-sm rounded-4 mt-3">

                <div class="card-body">

                    <h6 class="mb-3">

                        Dokumentasi Foto

                    </h6>

                    <input type="file" id="foto" name="foto[]" class="form-control" multiple accept="image/*">

                    <small class="text-muted">

                        Bisa memilih beberapa foto sekaligus.

                    </small>

                    <div id="previewFoto" class="row mt-3 g-2">

                    </div>

                </div>

            </div>

            <!-- tombol -->

            <div class="d-grid mt-3">

                <button class="btn btn-primary rounded-pill">

                    <i class="bi bi-save me-1"></i>

                    Simpan Kegiatan

                </button>

            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(function() {

        $('.select2').select2({

            width: '100%'

        });

    });

    /* preview badge */

    $('#jenis').change(function() {

        let opt = this.options[this.selectedIndex];

        if (opt.value == "") {

            $('#previewJenis').html('');

            return;

        }

        $('#previewJenis').html(

            '<span class="badge bg-' +

            opt.dataset.warna +

            '"><i class="bi ' +

            opt.dataset.icon +

            '"></i> ' +

            opt.text +

            '</span>'

        );

    });

    /* lokasi */

    $('#lokasi').change(function() {

        if ($(this).val() == "lainnya") {

            $('#lokasiLain').removeClass('d-none');

        } else {

            $('#lokasiLain').addClass('d-none');

        }

    });

    /* preview foto */

    $('#foto').on('change', function() {

        $('#previewFoto').html('');

        Array.from(this.files).forEach(function(file) {

            let reader = new FileReader();

            reader.onload = function(e) {

                $('#previewFoto').append(

                    '<div class="col-4">' +

                    '<img src="' +

                    e.target.result +

                    '" class="img-fluid rounded border shadow-sm">' +

                    '</div>'

                );

            };

            reader.readAsDataURL(file);

        });

    });
</script>

<?= $this->endSection() ?>