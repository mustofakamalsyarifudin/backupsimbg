<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <h5 class="mb-3">

            Data Penerima Manfaat

        </h5>

        <div class="row g-3 mb-3">

            <div class="col-6">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>

                            <?= number_format(
                                $ringkasan['total_pm'] ?? 0
                            ) ?>

                        </h3>

                        <small>

                            Total PM

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>

                            <?= number_format(
                                $totalAlergi
                            ) ?>

                        </h3>

                        <small>

                            Total Alergi

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>

                            <?= number_format(
                                $ringkasan['porsi_besar'] ?? 0
                            ) ?>

                        </h3>

                        <small>

                            Porsi Besar

                        </small>

                    </div>

                </div>

            </div>

            <div class="col-6">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>

                            <?= number_format(
                                $ringkasan['porsi_kecil'] ?? 0
                            ) ?>

                        </h3>

                        <small>

                            Porsi Kecil

                        </small>

                    </div>

                </div>

            </div>

        </div>

        <div class="card">

            <div class="card-body">

                <h6 class="mb-3">

                    Rincian PM

                </h6>


                <div class="mb-3">

                    <input type="text" id="searchPM" class="form-control" placeholder="Cari sekolah atau kelas...">

                </div>




                <?php

                $grouped = [];

                foreach ($detail as $item) {

                    $grouped[$item['sekolah_nama']][] = $item;
                }
                ?>
                <div class="accordion" id="accordionPM">

                    <?php

                    $no = 1;

                    foreach ($grouped as
                        $sekolah =>
                        $kelasList) :

                        $totalSekolah = 0;

                        foreach ($kelasList as
                            $k) {

                            $totalSekolah +=
                                $k['jumlah_siswa'];
                        }

                    ?>

                        <div class="accordion-item pm-item mb-2 border rounded-3">

                            <h2 class="accordion-header">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pm<?= $no ?>">

                                    <div>

                                        <strong>

                                            <?= esc(
                                                $sekolah
                                            ) ?>

                                        </strong>

                                        <br>

                                        <small>

                                            Total PM :
                                            <?= number_format(
                                                $totalSekolah
                                            ) ?>

                                        </small>

                                    </div>

                                </button>

                            </h2>

                            <div id="pm<?= $no ?>" class="accordion-collapse collapse" data-search="<?= strtolower(
                                                                                                        $sekolah . ' ' .
                                                                                                            implode(
                                                                                                                ' ',
                                                                                                                array_column(
                                                                                                                    $kelasList,
                                                                                                                    'nama_kelas'
                                                                                                                )
                                                                                                            )
                                                                                                    ) ?>">

                                <div class="accordion-body p-0">

                                    <ul class="list-group list-group-flush">

                                        <?php foreach ($kelasList
                                            as $kelas) : ?>

                                            <li class="list-group-item">

                                                <div class="d-flex justify-content-between">

                                                    <div>

                                                        <strong>

                                                            <?= esc(
                                                                $kelas['nama_kelas']
                                                            ) ?>

                                                        </strong>

                                                        <?php if (
                                                            !empty($kelas['catatan_alergi'])
                                                        ) : ?>

                                                            <br>

                                                            <small class="text-danger">

                                                                <?= esc(
                                                                    $kelas['catatan_alergi']
                                                                ) ?>

                                                            </small>

                                                        <?php endif; ?>

                                                    </div>

                                                    <div class="text-end">

                                                        <?php
                                                        $normal =
                                                            $kelas['jumlah_siswa']
                                                            -
                                                            $kelas['jumlah_alergi'];
                                                        ?>

                                                        <div class="d-flex gap-1">

                                                            <span class="badge bg-success">

                                                                <?= number_format($normal) ?>

                                                                normal

                                                            </span>

                                                            <?php if ($kelas['jumlah_alergi'] > 0) : ?>

                                                                <span class="badge bg-danger">

                                                                    <?= number_format(
                                                                        $kelas['jumlah_alergi']
                                                                    ) ?>

                                                                    alergi

                                                                </span>

                                                            <?php endif; ?>

                                                            <span class="badge bg-primary">

                                                                <?= number_format(
                                                                    $kelas['jumlah_siswa']
                                                                ) ?>

                                                                siswa

                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>

                                            </li>

                                        <?php endforeach; ?>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    <?php

                        $no++;

                    endforeach;

                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->section('scripts') ?>
<script>
    document
        .getElementById(
            'searchPM'
        )
        .addEventListener(
            'keyup',
            function() {

                let keyword =
                    this.value
                    .toLowerCase();

                document
                    .querySelectorAll(
                        '.pm-item'
                    )
                    .forEach(function(item) {

                        let text =
                            item.innerText
                            .toLowerCase();

                        if (
                            text.indexOf(
                                keyword
                            ) > -1
                        ) {

                            item.style.display =
                                '';

                        } else {

                            item.style.display =
                                'none';
                        }

                    });

            }
        );
</script>

<?= $this->endSection() ?>
<?= $this->endSection() ?>