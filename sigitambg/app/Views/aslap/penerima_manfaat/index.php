<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="mb-1">

                    Penerima Manfaat

                </h5>

                <small class="text-muted">

                    Data sekolah dan penerima manfaat

                </small>

            </div>

            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPM">

                <i class="bi bi-plus-circle"></i>

                Tambah

            </button>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table id="datatable" class="table table-bordered align-middle">

                        <thead>

                            <tr>

                                <th>Nama Sekolah/Posyandu</th>
                                <!-- <th>Jenis</th> -->
                                <th>Total PM</th>
                                <th>Alergi</th>
                                <th width="120">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($pms)) : ?>

                                <?php foreach ($pms as $pm) : ?>

                                    <tr>

                                        <td>

                                            <strong>

                                                <?= esc($pm['sekolah_nama']) ?>

                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                <?= esc($pm['sekolah_alamat']) ?>

                                            </small>

                                        </td>

                                        <!-- <td>

                                            <?= esc($pm['sub_kategori']) ?>

                                        </td> -->
                                        <td class="text-center">

                                            <span class="badge bg-primary">

                                                <?= number_format(
                                                    $pm['total_siswa']
                                                ) ?>

                                            </span>

                                        </td>

                                        <td class="text-center">

                                            <span class="badge bg-danger">

                                                <?= number_format(
                                                    $pm['total_alergi']
                                                ) ?>

                                            </span>

                                        </td>

                                        <td>

                                            <a href="<?= base_url(
                                                            'aslap/penerima-manfaat/detail/' .
                                                                $pm['id']
                                                        ) ?>" class="btn btn-info btn-sm">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                            <a href="<?= base_url(
                                                            'aslap/penerima-manfaat/delete/' .
                                                                $pm['id']
                                                        ) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus PM ini?')">

                                                <i class="bi bi-trash"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="5" class="text-center text-muted">

                                        Belum ada data penerima manfaat

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal Tambah -->

<div class="modal fade" id="modalTambahPM" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="<?= base_url('aslap/penerima-manfaat/store') ?>" method="post">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Penerima Manfaat

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Nama Sekolah/Posyandu

                        </label>

                        <input type="text" name="sekolah_nama" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Alamat

                        </label>

                        <textarea name="sekolah_alamat" class="form-control" rows="2"></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Kategori

                        </label>

                        <select name="kategori" id="kategori" class="form-select" required>

                            <option value="">
                                Pilih Kategori
                            </option>

                            <option value="Peserta Didik">
                                Peserta Didik
                            </option>

                            <option value="B3">
                                B3
                            </option>

                        </select>

                    </div>

                    <!-- <div class="mb-3">

                        <label class="form-label">

                            Sub Kategori

                        </label>

                        <select name="sub_kategori" id="sub_kategori" class="form-select" required>

                            <option value="">
                                Pilih Kategori Dulu
                            </option>

                        </select>

                    </div> -->

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?= $this->section('scripts') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const table = document.querySelector('#datatable');

        if (table) {

            new DataTable('#datatable', {

                searchable: true,
                fixedHeight: true,
                perPage: 10, perPageSelect: [5, 10, 25, 50, 100]

            });

        }

    });


    document.getElementById('kategori')
        .addEventListener('change', function() {

            let sub =
                document.getElementById('sub_kategori');

            sub.innerHTML = '';

            if (this.value === 'Peserta Didik') {

                sub.innerHTML = `
            <option value="PAUD">PAUD</option>
            <option value="TK">TK</option>
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
            <option value="SMA">SMA</option>
        `;

            }

            if (this.value === 'B3') {

                sub.innerHTML = `
            <option value="Balita">Balita</option>
            <option value="Ibu Hamil">Ibu Hamil</option>
            <option value="Ibu Menyusui">Ibu Menyusui</option>
        `;

            }

        });
</script>

<?= $this->endSection() ?>
<?= $this->endSection() ?>