<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="mb-3">

            <h5 class="mb-1">
                Transaksi Bahan Baku
            </h5>

            <small class="text-muted">
                Buat transaksi pembelian bahan baku
            </small>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form action="<?= base_url('gizi/bahan-baku/store') ?>" method="post" enctype="multipart/form-data">

                    <div class="mb-3">

                        <label class="form-label">

                            Kode Transaksi

                        </label>

                        <input type="text" class="form-control" value="<?= $kode_transaksi ?>" readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Tanggal Belanja

                        </label>

                        <input type="date" name="tanggal" class="form-control" required>

                    </div>
                    <div class="mb-3">

                        <label class="form-label">

                            Sumber Pengadaan

                        </label>

                        <select name="sumber_pengadaan" class="form-select" required>

                            <option value="koperasi">

                                Koperasi

                            </option>

                            <option value="mandiri">

                                Pembelian Mandiri

                            </option>

                        </select>

                    </div>
                    <div class="mb-3">

                        <label class="form-label">

                            Foto Struk (Opsional)

                        </label>

                        <input type="file" name="foto_struk" class="form-control" accept="image/*" capture="environment">
                        <small class="text-muted">

                            Upload jika pembelian dilakukan langsung.

                        </small>
                        <img id="previewStruk" class="img-fluid rounded border mt-2 d-none">
                    </div>
                    <div class="d-grid">

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-arrow-right-circle me-1"></i>

                            Simpan & Lanjutkan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.querySelector('[name="foto_struk"]');

        if (!input) return;

        input.addEventListener('change', function(e) {

            const file = e.target.files[0];

            if (!file) return;

            const preview = document.getElementById('previewStruk');

            preview.src = URL.createObjectURL(file);

            preview.classList.remove('d-none');

        });

    });
</script>
<?= $this->endSection() ?>