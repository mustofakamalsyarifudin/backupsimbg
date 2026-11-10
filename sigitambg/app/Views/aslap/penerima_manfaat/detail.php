<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">
                    Detail Penerima Manfaat
                </h5>

                <small class="text-muted">
                    Informasi sekolah/posyandu dan jenjang
                </small>

            </div>

            <a href="<?= base_url('aslap/penerima-manfaat') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">

                <i class="bi bi-arrow-left me-1"></i>

                Kembali

            </a>

        </div>


        <!-- INFORMASI PENERIMA MANFAAT -->
        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <h5 class="mb-1">

                            <?= esc($pm['sekolah_nama']) ?>

                        </h5>

                        <small class="text-muted">

                            <?= esc($pm['sekolah_alamat']) ?>

                        </small>

                    </div>

                    <span class="badge bg-primary rounded-pill">

                        <?= esc($pm['kategori']) ?>

                    </span>

                </div>


                <hr>


                <div class="row g-3">

                    <div class="col-12 col-md-6">

                        <small class="text-muted d-block">
                            Nama Sekolah / Posyandu
                        </small>

                        <strong>
                            <?= esc($pm['sekolah_nama']) ?>
                        </strong>

                    </div>


                    <div class="col-12 col-md-6">

                        <small class="text-muted d-block">
                            Kategori
                        </small>

                        <strong>
                            <?= esc($pm['kategori']) ?>
                        </strong>

                    </div>


                    <div class="col-12">

                        <small class="text-muted d-block">
                            Alamat
                        </small>

                        <strong>
                            <?= esc($pm['sekolah_alamat']) ?>
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- JENJANG -->
        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h6 class="mb-1">
                            Jenjang
                        </h6>

                        <small class="text-muted">
                            Jenjang pendidikan pada sekolah/posyandu ini
                        </small>

                    </div>


                    <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahJenjang">

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Jenjang

                    </button>

                </div>


                <?php if (empty($jenjang)) : ?>

                    <div class="text-center py-5">

                        <i class="bi bi-diagram-3 fs-1 text-secondary"></i>

                        <h6 class="mt-3">
                            Belum ada jenjang
                        </h6>

                        <small class="text-muted">
                            Silakan tambahkan jenjang terlebih dahulu.
                        </small>

                    </div>

                <?php else : ?>

                    <div class="row g-3">

                        <?php foreach ($jenjang as $j) : ?>

                            <div class="col-12 col-md-6 col-lg-4">

                                <div class="card border shadow-none rounded-4 h-100">

                                    <div class="card-body">

                                        <div class="d-flex align-items-center mb-3">

                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;">

                                                <i class="bi bi-building text-primary fs-5"></i>

                                            </div>

                                            <div class="ms-3">

                                                <h6 class="mb-0">

                                                    <?= esc($j['jenjang']) ?>

                                                </h6>

                                                <small class="text-muted">

                                                    Jenjang pendidikan

                                                </small>

                                            </div>

                                        </div>


                                        <div class="d-grid">

                                            <div class="d-flex gap-2">

                                                <!-- DETAIL JENJANG -->
                                                <a href="<?= base_url('aslap/penerima-manfaat/jenjang/' . $j['id']) ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                                                    <i class="bi bi-eye"></i>
                                                </a>


                                                <!-- HAPUS JENJANG -->
                                                <form action="<?= base_url('aslap/penerima-manfaat/delete-jenjang/' . $j['id']) ?>" method="post" class="m-0" onsubmit="return confirm(
        'Yakin ingin menghapus jenjang <?= esc($j['jenjang'], 'js') ?>?\n\n' +
        'Semua data kelas/kelompok di dalam jenjang ini juga akan dihapus.'
    );">

                                                    <?= csrf_field() ?>

                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill" title="Hapus Jenjang">
                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </form>

                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- INFORMASI TAMBAHAN -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h6 class="mb-3">

                    Informasi

                </h6>


                <div class="row g-3">

                    <div class="col-12 col-md-3">

                        <small class="text-muted d-block">
                            Total Penerima
                        </small>

                        <h5 class="mb-0">

                            <?= number_format(
                                (int) ($pm['total_siswa'] ?? 0),
                                0,
                                ',',
                                '.'
                            ) ?>

                        </h5>

                    </div>


                    <div class="col-12 col-md-3">

                        <small class="text-muted d-block">
                            Porsi Besar
                        </small>

                        <h5 class="mb-0">

                            <?= number_format(
                                (int) ($pm['porsi_besar'] ?? 0),
                                0,
                                ',',
                                '.'
                            ) ?>

                        </h5>

                    </div>


                    <div class="col-12 col-md-3">

                        <small class="text-muted d-block">
                            Porsi Kecil
                        </small>

                        <h5 class="mb-0">

                            <?= number_format(
                                (int) ($pm['porsi_kecil'] ?? 0),
                                0,
                                ',',
                                '.'
                            ) ?>

                        </h5>

                    </div>
                    <div class="col-12 col-md-3">

                        <small class="text-muted d-block">
                            Total Alergi
                        </small>

                        <h5 class="mb-0">

                            <?= number_format($jumlah_alergi ?? 0) ?>

                        </h5>

                    </div>

                </div>

            </div>

        </div>

        <!-- ============================================================
     INFORMASI ALERGI PER JENJANG
============================================================ -->

        <div class="card border-0 shadow-sm rounded-4 mb-4 mt-3">

            <div class="card-body p-4">

                <div class="mb-3">

                    <h5 class="fw-bold mb-1">
                        Informasi Alergi
                    </h5>

                    <p class="text-muted mb-0">
                        Rekap alergi berdasarkan jenjang pendidikan/kelompok.
                    </p>

                </div>


                <?php if (!empty($alergiPerJenjang)) : ?>

                    <div class="row g-3">

                        <?php foreach ($alergiPerJenjang as $item) : ?>

                            <div class="col-md-6">

                                <div class="border rounded-4 p-3 h-100">

                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                        <h6 class="fw-bold mb-0">
                                            <?= esc($item['jenjang']) ?>
                                        </h6>

                                        <span class="badge bg-danger rounded-pill">

                                            <?= (int) $item['jumlah_alergi'] ?>

                                            orang

                                        </span>

                                    </div>


                                    <?php if (!empty($item['catatan'])) : ?>

                                        <div class="mt-3">

                                            <div class="small text-muted mb-2">
                                                Catatan Alergi
                                            </div>

                                            <?php foreach ($item['catatan'] as $catatan) : ?>

                                                <div class="mb-2">

                                                    <div class="fw-semibold">
                                                        <?= esc($catatan['kelas']) ?>
                                                    </div>

                                                    <div class="small text-muted">
                                                        <?= esc($catatan['catatan']) ?>
                                                    </div>

                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                    <?php else : ?>

                                        <div class="small text-muted mt-2">
                                            Tidak ada catatan alergi.
                                        </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>

                    <div class="text-muted">
                        Belum ada data alergi.
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </div>

</div>


<!-- ============================================================
     MODAL TAMBAH JENJANG / KELOMPOK
     ============================================================ -->
<div class="modal fade" id="modalTambahJenjang" tabindex="-1" aria-labelledby="modalTambahJenjangLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <form action="<?= base_url('aslap/penerima-manfaat/store-jenjang') ?>" method="post">

                <?= csrf_field() ?>

                <!-- ====================================================
                     HEADER
                     ==================================================== -->
                <div class="modal-header">

                    <h5 class="modal-title" id="modalTambahJenjangLabel">
                        <?= ($pm['kategori'] === 'B3')
                            ? 'Tambah Kelompok'
                            : 'Tambah Jenjang'
                        ?>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <!-- ====================================================
                     BODY
                     ==================================================== -->
                <div class="modal-body">

                    <input type="hidden" name="pm_id" value="<?= $pm['id'] ?>">


                    <!-- =================================================
                         SEKOLAH / POSYANDU
                         ================================================= -->
                    <div class="mb-3">

                        <label class="form-label">
                            Sekolah / Posyandu
                        </label>

                        <input type="text" class="form-control" value="<?= esc($pm['sekolah_nama']) ?>" readonly>

                    </div>


                    <!-- =================================================
                         KATEGORI
                         ================================================= -->
                    <div class="mb-3">

                        <label class="form-label">
                            Kategori
                        </label>

                        <input type="text" class="form-control" value="<?= esc($pm['kategori']) ?>" readonly>

                    </div>


                    <!-- =================================================
                         JENJANG / KELOMPOK
                         ================================================= -->
                    <div class="mb-3">

                        <label for="jenjang" class="form-label">

                            <?= ($pm['kategori'] === 'B3')
                                ? 'Kelompok'
                                : 'Jenjang'
                            ?>

                        </label>


                        <select name="jenjang" id="jenjang" class="form-select" required>

                            <option value="">
                                <?= ($pm['kategori'] === 'B3')
                                    ? 'Pilih Kelompok'
                                    : 'Pilih Jenjang'
                                ?>
                            </option>


                            <?php if ($pm['kategori'] === 'B3') : ?>

                                <!-- =====================================
                                     KHUSUS B3
                                     ===================================== -->

                                <option value="Balita">
                                    Balita
                                </option>

                                <option value="Ibu Hamil">
                                    Ibu Hamil
                                </option>

                                <option value="Ibu Menyusui">
                                    Ibu Menyusui
                                </option>

                                <option value="Sampel">
                                    Sampel
                                </option>


                            <?php else : ?>

                                <!-- =====================================
                                     PESERTA DIDIK
                                     ===================================== -->

                                <option value="PAUD">
                                    PAUD
                                </option>

                                <option value="TK">
                                    TK
                                </option>

                                <option value="SD">
                                    SD
                                </option>

                                <option value="SMP">
                                    SMP
                                </option>

                                <option value="SMA/SMK">
                                    SMA/SMK
                                </option>

                                <option value="Sampel">
                                    Sampel
                                </option>

                            <?php endif; ?>

                        </select>

                    </div>


                    <!-- =================================================
                         INFORMASI SAMPel
                         ================================================= -->
                    <div id="infoSampel" class="alert alert-info rounded-3 d-none">

                        <div class="d-flex">

                            <i class="bi bi-info-circle me-2"></i>

                            <div>

                                <strong>Sampel</strong>

                                <div class="small mt-1">

                                    Sampel dianggap sebagai kelompok
                                    tersendiri. Porsi <strong>Besar</strong>
                                    atau <strong>Kecil</strong> akan
                                    ditentukan pada bagian detail kelompok.

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         INFORMASI B3
                         ================================================= -->
                    <?php if ($pm['kategori'] === 'B3') : ?>

                        <div class="alert alert-light border rounded-3">

                            <div class="d-flex">

                                <i class="bi bi-info-circle me-2 text-primary"></i>

                                <div>

                                    <strong>Kelompok B3</strong>

                                    <div class="small text-muted mt-1">

                                        Pilih kelompok penerima manfaat
                                        sesuai data Posyandu.

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- ====================================================
                     FOOTER
                     ==================================================== -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">

                        Batal

                    </button>


                    <button type="submit" class="btn btn-primary rounded-pill">

                        <i class="bi bi-check-circle me-1"></i>

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ============================================================
     SCRIPT SAMPel
     ============================================================ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectJenjang =
            document.getElementById('jenjang');

        const infoSampel =
            document.getElementById('infoSampel');


        if (!selectJenjang) {
            return;
        }


        selectJenjang.addEventListener('change', function() {

            if (this.value === 'Sampel') {

                infoSampel.classList.remove('d-none');

            } else {

                infoSampel.classList.add('d-none');

            }

        });

    });
</script>

<?= $this->endSection() ?>