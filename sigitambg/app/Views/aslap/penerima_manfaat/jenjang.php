<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">

                    <?= esc($jenjang['jenjang']) ?>

                </h5>

                <small class="text-muted">

                    <?= esc($pm['sekolah_nama']) ?>

                </small>

            </div>

            <a href="<?= base_url('aslap/penerima-manfaat/detail/' . $pm['id']) ?>" class="btn btn-outline-secondary btn-sm rounded-pill">

                <i class="bi bi-arrow-left me-1"></i>

                Kembali

            </a>

        </div>


        <!-- INFORMASI JENJANG -->
        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">

                        <i class="bi bi-building text-primary fs-5"></i>

                    </div>

                    <div class="ms-3">

                        <h6 class="mb-1">

                            <?= esc($jenjang['jenjang']) ?>

                        </h6>

                        <small class="text-muted">

                            <?= esc($pm['sekolah_nama']) ?>

                        </small>

                    </div>

                </div>

            </div>

        </div>


        <!-- DAFTAR KELOMPOK -->
        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h6 class="mb-1">

                            Kelompok Penerima

                        </h6>

                        <small class="text-muted">

                            Data penerima manfaat pada jenjang ini

                        </small>

                    </div>

                    <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahKelompok">

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah

                    </button>

                </div>


                <?php if (empty($kelas)) : ?>

                    <div class="text-center py-5">

                        <i class="bi bi-people fs-1 text-secondary"></i>

                        <h6 class="mt-3">

                            Belum ada kelompok

                        </h6>

                        <small class="text-muted">

                            Tambahkan kelompok penerima manfaat.

                        </small>

                    </div>

                <?php else : ?>

                    <div class="row g-3">

                        <?php foreach ($kelas as $row) : ?>

                            <div class="col-12">

                                <div class="border rounded-4 p-3">

                                    <div class="d-flex justify-content-between align-items-start">

                                        <div>

                                            <h6 class="mb-1">

                                                <?= esc($row['nama_kelas']) ?>

                                            </h6>

                                            <span class="badge bg-<?= $row['porsi'] === 'besar' ? 'primary' : 'success' ?>">

                                                Porsi
                                                <?= ucfirst($row['porsi']) ?>

                                            </span>

                                        </div>

                                        <div class="dropdown">

                                            <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">

                                                <i class="bi bi-three-dots-vertical"></i>

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">

                                                <li>

                                                    <button type="button" class="dropdown-item" onclick="editKelompok(
                                                            <?= $row['id'] ?>,
                                                            <?= htmlspecialchars(
                                                                json_encode($row['nama_kelas']),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>,
                                                            <?= (int) $row['jumlah_siswa'] ?>,
                                                            <?= (int) $row['jumlah_alergi'] ?>,
                                                            <?= htmlspecialchars(
                                                                json_encode($row['catatan_alergi'] ?? ''),
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>
                                                        )">

                                                        <i class="bi bi-pencil me-2"></i>

                                                        Edit

                                                    </button>

                                                </li>

                                                <li>

                                                    <form action="<?= base_url('aslap/penerima-manfaat/delete-kelas/' . $row['id']) ?>" method="post" onsubmit="return confirm('Hapus kelompok ini?')">

                                                        <?= csrf_field() ?>

                                                        <button type="submit" class="dropdown-item text-danger">

                                                            <i class="bi bi-trash me-2"></i>

                                                            Hapus

                                                        </button>

                                                    </form>

                                                </li>

                                            </ul>

                                        </div>

                                    </div>


                                    <div class="row g-3 mt-2">

                                        <div class="col-6 col-md-4">

                                            <small class="text-muted d-block">

                                                Jumlah

                                            </small>

                                            <strong>

                                                <?= number_format(
                                                    (int) $row['jumlah_siswa'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>

                                                orang

                                            </strong>

                                        </div>


                                        <div class="col-6 col-md-4">

                                            <small class="text-muted d-block">

                                                Alergi

                                            </small>

                                            <strong>

                                                <?= number_format(
                                                    (int) $row['jumlah_alergi'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>

                                                orang

                                            </strong>

                                        </div>


                                        <div class="col-12 col-md-4">

                                            <small class="text-muted d-block">

                                                Catatan Alergi

                                            </small>

                                            <?php if (!empty($row['catatan_alergi'])) : ?>

                                                <span>

                                                    <?= esc($row['catatan_alergi']) ?>

                                                </span>

                                            <?php else : ?>

                                                <span class="text-muted">

                                                    Tidak ada

                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- KETERANGAN PORSI -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h6 class="mb-3">

                    Ketentuan Porsi

                </h6>

                <div class="row g-2">

                    <div class="col-12 col-md-6">

                        <div class="alert alert-success mb-0">

                            <strong>

                                Porsi Kecil

                            </strong>

                            <br>

                            <small>

                                PAUD, TK, SD Kelas 1–3 dan Balita.

                            </small>

                        </div>

                    </div>

                    <div class="col-12 col-md-6">

                        <div class="alert alert-primary mb-0">

                            <strong>

                                Porsi Besar

                            </strong>

                            <br>

                            <small>

                                SD Kelas 4–6, SMP, SMA/SMK,
                                Ibu Hamil, Ibu Menyusui dan Guru/Staf.

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- MODAL TAMBAH KELOMPOK -->
<!-- ========================================================= -->

<div class="modal fade" id="modalTambahKelompok" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <form action="<?= base_url('aslap/penerima-manfaat/store-kelas') ?>" method="post">

                <?= csrf_field() ?>

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Kelompok

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <input type="hidden" name="pm_id" value="<?= $pm['id'] ?>">

                    <input type="hidden" name="jenjang_id" value="<?= $jenjang['id'] ?>">


                    <div class="mb-3">

                        <label class="form-label">

                            Jenjang

                        </label>

                        <input type="text" class="form-control" value="<?= esc($jenjang['jenjang']) ?>" readonly>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Nama Kelompok

                        </label>

                        <select name="nama_kelas" id="namaKelas" class="form-select" required>

                            <option value="">

                                Pilih Kelompok

                            </option>

                            <?php
                            $namaJenjang = strtolower(
                                trim($jenjang['jenjang'])
                            );
                            ?>


                            <?php if ($namaJenjang === 'paud') : ?>

                                <option value="Penerima">

                                    Penerima

                                </option>

                                <option value="Guru/Staf">

                                    Guru/Staf

                                </option>

                            <?php elseif ($namaJenjang === 'tk') : ?>

                                <option value="Penerima">

                                    Penerima

                                </option>

                                <option value="Guru/Staf">

                                    Guru/Staf

                                </option>

                            <?php elseif ($namaJenjang === 'sd') : ?>

                                <option value="Kelas 1">

                                    Kelas 1

                                </option>

                                <option value="Kelas 2">

                                    Kelas 2

                                </option>

                                <option value="Kelas 3">

                                    Kelas 3

                                </option>

                                <option value="Kelas 4">

                                    Kelas 4

                                </option>

                                <option value="Kelas 5">

                                    Kelas 5

                                </option>

                                <option value="Kelas 6">

                                    Kelas 6

                                </option>

                                <option value="Guru/Staf">

                                    Guru/Staf

                                </option>

                            <?php elseif ($namaJenjang === 'smp') : ?>

                                <option value="Kelas 7">

                                    Kelas 7

                                </option>

                                <option value="Kelas 8">

                                    Kelas 8

                                </option>

                                <option value="Kelas 9">

                                    Kelas 9

                                </option>

                                <option value="Guru/Staf">

                                    Guru/Staf

                                </option>

                            <?php elseif (
                                $namaJenjang === 'sma/smk'
                                || $namaJenjang === 'sma'
                                || $namaJenjang === 'smk'
                            ) : ?>

                                <option value="Kelas 10">

                                    Kelas 10

                                </option>

                                <option value="Kelas 11">

                                    Kelas 11

                                </option>

                                <option value="Kelas 12">

                                    Kelas 12

                                </option>

                                <option value="Guru/Staf">

                                    Guru/Staf

                                </option>

                            <?php elseif ($namaJenjang === 'balita') : ?>

                                <option value="Penerima">

                                    Penerima

                                </option>

                            <?php elseif ($namaJenjang === 'ibu hamil') : ?>

                                <option value="Penerima">

                                    Penerima

                                </option>

                            <?php elseif ($namaJenjang === 'ibu menyusui') : ?>

                                <option value="Penerima">

                                    Penerima

                                </option>

                            <?php elseif ($namaJenjang === 'sampel') : ?>

                                <option value="Porsi Besar">

                                    Porsi Besar

                                </option>

                                <option value="Porsi Kecil">

                                    Porsi Kecil

                                </option>

                            <?php endif; ?>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Jumlah Penerima

                        </label>

                        <input type="number" name="jumlah_siswa" class="form-control" min="0" value="0" required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Jumlah Alergi

                        </label>

                        <input type="number" name="jumlah_alergi" class="form-control" min="0" value="0">

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Catatan Alergi

                        </label>

                        <textarea name="catatan_alergi" class="form-control" rows="3" placeholder="Contoh: alergi telur, susu, kacang..."></textarea>

                    </div>


                    <div class="alert alert-info mb-0">

                        <i class="bi bi-info-circle me-1"></i>

                        <small>

                            Porsi besar/kecil akan ditentukan otomatis
                            oleh sistem berdasarkan kelompok yang dipilih.

                        </small>

                    </div>

                </div>


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


<!-- ========================================================= -->
<!-- MODAL EDIT KELOMPOK -->
<!-- ========================================================= -->

<div class="modal fade" id="modalEditKelompok" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <form id="formEditKelompok" method="post">

                <?= csrf_field() ?>

                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Kelompok

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Nama Kelompok

                        </label>

                        <input type="text" id="editNamaKelas" class="form-control" readonly>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Jumlah Penerima

                        </label>

                        <input type="number" name="jumlah_siswa" id="editJumlahSiswa" class="form-control" min="0" required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Jumlah Alergi

                        </label>

                        <input type="number" name="jumlah_alergi" id="editJumlahAlergi" class="form-control" min="0" required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Catatan Alergi

                        </label>

                        <textarea name="catatan_alergi" id="editCatatanAlergi" class="form-control" rows="3"></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" class="btn btn-primary rounded-pill">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?= $this->section('scripts') ?>

<script>
    function editKelompok(
        id,
        nama,
        jumlah,
        alergi,
        catatan
    ) {

        document.getElementById(
            'editNamaKelas'
        ).value = nama;

        document.getElementById(
            'editJumlahSiswa'
        ).value = jumlah;

        document.getElementById(
            'editJumlahAlergi'
        ).value = alergi;

        document.getElementById(
            'editCatatanAlergi'
        ).value = catatan || '';

        document.getElementById(
                'formEditKelompok'
            ).action =
            '<?= base_url('aslap/penerima-manfaat/update-kelas') ?>/' + id;

        const modal =
            new bootstrap.Modal(
                document.getElementById(
                    'modalEditKelompok'
                )
            );

        modal.show();
    }


    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const jumlah =
                document.getElementById(
                    'editJumlahSiswa'
                );

            const alergi =
                document.getElementById(
                    'editJumlahAlergi'
                );

            if (!jumlah || !alergi) {
                return;
            }

            alergi.addEventListener(
                'input',
                function() {

                    const max =
                        parseInt(
                            jumlah.value || 0
                        );

                    if (
                        parseInt(
                            this.value || 0
                        ) > max
                    ) {

                        this.value = max;

                    }

                }
            );

        }
    );
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>