<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <a href="<?= base_url('gizi/kegiatan/detail/' . $kegiatan['id']) ?>" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="mb-0">Edit Kegiatan</h5>
                <small class="text-muted">Perbarui informasi kegiatan Ahli Gizi</small>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('gizi/kegiatan/update/' . $kegiatan['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="mb-3">Informasi Kegiatan</h6>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control"
                               value="<?= esc(old('tanggal', $kegiatan['tanggal'])) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Kegiatan</label>
                        <select name="jenis_kegiatan_id" id="jenis" class="form-select select2" required>
                            <option value="">Pilih Jenis Kegiatan</option>
                            <?php foreach ($jenis as $j) : ?>
                                <option value="<?= $j['id'] ?>"
                                        data-icon="<?= esc($j['icon']) ?>"
                                        data-warna="<?= esc($j['warna']) ?>"
                                    <?= (string) old('jenis_kegiatan_id', $kegiatan['jenis_kegiatan_id']) === (string) $j['id'] ? 'selected' : '' ?>>
                                    <?= esc($j['nama_kegiatan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="previewJenis" class="mb-3"></div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi</label>
                        <select id="lokasi" name="lokasi" class="form-select select2" required>
                            <option value="">Pilih Lokasi</option>
                            <?php foreach ($sekolah as $nama) : ?>
                                <option value="<?= esc($nama) ?>"
                                    <?= old('lokasi', $kegiatan['lokasi_nama']) === $nama ? 'selected' : '' ?>>
                                    🏫 <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                            <option disabled>───────────────</option>
                            <option value="Dapur SPPG" <?= old('lokasi', $kegiatan['lokasi_nama']) === 'Dapur SPPG' ? 'selected' : '' ?>>🏢 Dapur SPPG</option>
                            <option value="Gudang" <?= old('lokasi', $kegiatan['lokasi_nama']) === 'Gudang' ? 'selected' : '' ?>>📦 Gudang</option>
                            <option disabled>───────────────</option>
                            <?php
                                $knownLocations = array_merge(array_values($sekolah), ['Dapur SPPG', 'Gudang']);
                                $isOther = !in_array($kegiatan['lokasi_nama'], $knownLocations, true);
                            ?>
                            <option value="lainnya" <?= $isOther ? 'selected' : '' ?>>📍 Lainnya</option>
                        </select>
                    </div>

                    <div id="lokasiLain" class="mb-3 <?= $isOther ? '' : 'd-none' ?>">
                        <label class="form-label fw-bold">Nama Lokasi Lainnya</label>
                        <input type="text" name="lokasi_manual" class="form-control"
                               value="<?= $isOther ? esc(old('lokasi_manual', $kegiatan['lokasi_nama'])) : esc(old('lokasi_manual')) ?>"
                               placeholder="Masukkan lokasi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" rows="5" class="form-control" required><?= esc(old('deskripsi', $kegiatan['deskripsi'])) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body">
                    <h6 class="mb-3">Dokumentasi</h6>

                    <?php if (!empty($foto)) : ?>
                        <div class="row g-2 mb-3">
                            <?php foreach ($foto as $f) : ?>
                                <div class="col-4 col-md-3">
                                    <a href="<?= base_url('uploads/kegiatan/' . $f['foto']) ?>" target="_blank">
                                        <img src="<?= base_url('uploads/kegiatan/' . $f['foto']) ?>" class="img-fluid rounded border shadow-sm">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <small class="text-muted d-block mb-2">Foto lama tetap tersimpan. Upload di bawah untuk menambahkan dokumentasi baru.</small>
                    <?php endif; ?>

                    <input type="file" id="foto" name="foto[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Maksimal 5 MB per foto.</small>
                    <div id="previewFoto" class="row mt-3 g-2"></div>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(function () {
    $('.select2').select2({ width: '100%' });

    function updateJenisPreview() {
        const opt = $('#jenis option:selected')[0];
        if (!opt || !opt.value) {
            $('#previewJenis').html('');
            return;
        }
        $('#previewJenis').html(
            '<span class="badge bg-' + opt.dataset.warna + '">' +
            '<i class="bi ' + opt.dataset.icon + '"></i> ' +
            $('<div>').text(opt.text.trim()).html() +
            '</span>'
        );
    }

    function updateLokasi() {
        $('#lokasiLain').toggleClass('d-none', $('#lokasi').val() !== 'lainnya');
    }

    $('#jenis').on('change', updateJenisPreview);
    $('#lokasi').on('change', updateLokasi);
    updateJenisPreview();
    updateLokasi();

    $('#foto').on('change', function () {
        $('#previewFoto').html('');
        Array.from(this.files).forEach(function (file) {
            if (file.size > 5 * 1024 * 1024) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#previewFoto').append(
                    '<div class="col-4 col-md-3"><img src="' + e.target.result + '" class="img-fluid rounded border shadow-sm"></div>'
                );
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
<?= $this->endSection() ?>
