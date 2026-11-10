<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('aslap/pengeluaran') ?>"
                class="me-2 text-dark">

                <i class="bi bi-arrow-left fs-4"></i>

            </a>

            <div>

                <h5 class="mb-0">

                    Tambah Pengeluaran

                </h5>

                <small class="text-muted">

                    Input biaya operasional lapangan

                </small>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">
                <form action="<?= base_url(
                                    'aslap/pengeluaran/update/' .
                                        $pengeluaran['id']
                                ) ?>">

                    <div class="mb-3">

                        <label class="form-label">

                            Tanggal

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="<?= $pengeluaran['tanggal'] ?>"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Kategori

                        </label>

                        <input
                            type="text"
                            name="kategori"
                            class="form-control"
                            placeholder="BBM, Parkir, Tol, ATK dll"
                            value="<?= esc(
                                        $pengeluaran['kategori']
                                    ) ?>"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Nominal

                        </label>

                        <input
                            type="text"
                            id="nominal"
                            class="form-control"
                            placeholder="0"
                            value="<?= number_format(
                                        $pengeluaran['nominal'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>"
                            required>

                        <input
                            type="hidden"
                            name="nominal"
                            value="<?= $pengeluaran['nominal'] ?>"
                            id="nominal_value">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Uraian

                        </label>

                        <textarea
                            name="uraian"
                            rows="4"
                            class="form-control"><?= esc(
                                                        $pengeluaran['uraian']
                                                    ) ?></textarea>

                    </div>
                    <div class="mb-3">

                        <label class="form-label">

                            Metode Pembayaran

                        </label>

                        <select
                            name="metode_pembayaran"
                            class="form-select"
                            required>

                            <option <?= $pengeluaran['metode_pembayaran'] == 'Tunai'
                                        ? 'selected' : '' ?> value="Tunai">
                                Tunai
                            </option>

                            <option <?= $pengeluaran['metode_pembayaran'] == 'Transfer'
                                        ? 'selected' : '' ?> value="Transfer">
                                Transfer
                            </option>

                            <option <?= $pengeluaran['metode_pembayaran'] == 'QIRIS'
                                        ? 'selected' : '' ?> value="QRIS">
                                QRIS
                            </option>

                        </select>

                    </div>
                    <div class="mb-3">

                        <label class="form-label">

                            Foto Bukti

                        </label>
                        <?php if (
                            !empty($pengeluaran['foto_bukti'])
                        ) : ?>

                            <img
                                src="<?= base_url(
                                            'uploads/pengeluaran/' .
                                                $pengeluaran['foto_bukti']
                                        ) ?>"
                                class="img-fluid rounded mb-2"
                                style="max-height:200px;">

                        <?php endif; ?>
                        <input
                            type="file"
                            name="foto_bukti"
                            class="form-control"
                            accept="image/*">

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
<?= $this->section('scripts') ?>

<script>
    const nominal =
        document.getElementById(
            'nominal'
        );

    const nominalValue =
        document.getElementById(
            'nominal_value'
        );

    nominal.addEventListener(
        'input',
        function() {

            let angka =
                this.value.replace(
                    /\D/g,
                    ''
                );

            nominalValue.value =
                angka;

            this.value =
                new Intl.NumberFormat(
                    'id-ID'
                ).format(
                    angka
                );
        }
    );
</script>

<?= $this->endSection() ?>
<?= $this->endSection() ?>