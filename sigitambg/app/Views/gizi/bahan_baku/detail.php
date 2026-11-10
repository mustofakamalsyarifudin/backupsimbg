<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">
        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success">

                <?= session()->getFlashdata('success') ?>

            </div>

        <?php endif; ?>
        <div class="card border-0 shadow-sm mb-3">


            <div class="card-body">
                <h5 class="mb-1">

                    <?= $transaksi['kode_transaksi'] ?>

                </h5>

                <small class="text-muted">

                    <?= date(
                        'd F Y',
                        strtotime($transaksi['tanggal'])
                    ) ?>

                </small>

                <?php
                $status = (string) ($transaksi['status'] ?? 'draft');
                $badgeClass = match ($status) {
                    'draft' => 'bg-secondary',
                    'waiting_finance', 'waiting_approval' => 'bg-warning',
                    'rejected_finance', 'rejected_kepala', 'rejected' => 'bg-danger',
                    'waiting_kepala' => 'bg-primary',
                    'waiting_koperasi', 'procurement' => 'bg-info',
                    'completed', 'approved' => 'bg-success',
                    default => 'bg-secondary'
                };
                $badgeLabel = match ($status) {
                    'draft' => 'Draft',
                    'waiting_finance', 'waiting_approval' => 'Menunggu Keuangan',
                    'rejected_finance' => 'Perlu Revisi - Keuangan',
                    'waiting_kepala' => 'Menunggu Kepala',
                    'rejected_kepala' => 'Perlu Revisi - Kepala',
                    'waiting_koperasi' => 'Menunggu Koperasi',
                    'procurement' => 'Sedang Diproses Koperasi',
                    'completed', 'approved' => 'Selesai',
                    'rejected' => 'Ditolak',
                    default => 'Draft'
                };
                ?>
                <span class="badge <?= $badgeClass ?>"><?= esc($badgeLabel) ?></span>
            </div>

        </div>

        <?php if (!empty($transaksi['catatan_keuangan']) || !empty($transaksi['catatan_approval']) || !empty($transaksi['koperasi_note']) || in_array($transaksi['status'], ['waiting_finance','waiting_kepala','waiting_koperasi','procurement','completed','rejected_finance','rejected_kepala'], true)) : ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="mb-3">Status & Catatan Proses</h6>
                    <div class="row g-2">
                        <div class="col-md-4"><div class="p-3 bg-light rounded-3 h-100"><small class="text-muted d-block">Keuangan</small><strong><?= match($transaksi['status']) { 'waiting_finance' => 'Menunggu pemeriksaan', 'rejected_finance' => 'Dikembalikan ke Gizi', default => !empty($transaksi['finance_reviewed_at']) ? 'Sudah diperiksa' : 'Belum diperiksa' } ?></strong><?php if (!empty($transaksi['catatan_keuangan'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($transaksi['catatan_keuangan'])) ?></div><?php endif; ?></div></div>
                        <div class="col-md-4"><div class="p-3 bg-light rounded-3 h-100"><small class="text-muted d-block">Kepala SPPG</small><strong><?= match($transaksi['status']) { 'waiting_kepala' => 'Menunggu approval', 'rejected_kepala' => 'Dikembalikan ke Gizi', default => !empty($transaksi['kepala_approved_at']) ? 'Sudah diproses' : 'Belum diproses' } ?></strong><?php if (!empty($transaksi['catatan_approval'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($transaksi['catatan_approval'])) ?></div><?php endif; ?></div></div>
                        <div class="col-md-4"><div class="p-3 bg-light rounded-3 h-100"><small class="text-muted d-block">Koperasi</small><strong><?= match($transaksi['status']) { 'waiting_koperasi' => 'Menunggu pengadaan', 'procurement' => 'Sedang diproses', 'completed' => 'Selesai', default => 'Belum masuk Koperasi' } ?></strong><?php if (!empty($transaksi['koperasi_note'])): ?><div class="small mt-2">Catatan: <?= nl2br(esc($transaksi['koperasi_note'])) ?></div><?php endif; ?></div></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($transaksi['status'] === 'rejected_finance') : ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <div class="fw-semibold mb-1"><i class="bi bi-arrow-repeat me-1"></i> Pengajuan dikembalikan oleh Keuangan</div>
                <div class="small">Silakan perbaiki daftar bahan atau qty sesuai catatan Keuangan, lalu tekan <strong>Revisi & Ajukan Ulang</strong>. Pengajuan akan diperiksa kembali dari tahap Keuangan.</div>
            </div>
        <?php elseif ($transaksi['status'] === 'rejected_kepala') : ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <div class="fw-semibold mb-1"><i class="bi bi-arrow-repeat me-1"></i> Pengajuan dikembalikan oleh Kepala SPPG</div>
                <div class="small">Silakan perbaiki daftar bahan atau qty sesuai catatan Kepala, lalu tekan <strong>Revisi & Ajukan Ulang</strong>. Pengajuan akan kembali diperiksa dari tahap Keuangan.</div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h6 class="mb-0">

                        Daftar Bahan

                    </h6>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('gizi/bahan-baku') ?>" class="btn btn-danger btn-sm">

                            <i class="bi bi-arrow-left-short me-1"></i>
                            Kembali

                        </a>
                        <?php if (in_array($transaksi['status'], ['draft', 'rejected_finance', 'rejected_kepala'], true)) : ?>

                            <a href="<?= base_url(
                                            'gizi/bahan-baku/ajukan/' .
                                                $transaksi['id']
                                        ) ?>" class="btn btn-success btn-sm" onclick="return confirm('Kirim pengajuan ini ke Keuangan? Setelah dikirim, pengajuan tidak dapat diedit sampai dikembalikan untuk revisi.')">

                                <i class="bi bi-send"></i>

                                <?= in_array($transaksi['status'], ['rejected_finance', 'rejected_kepala'], true) ? 'Revisi & Ajukan Ulang' : 'Ajukan' ?>

                            </a>

                        <?php endif; ?>


                        <?php if (
                            in_array(
                                $transaksi['status'],
                                ['draft', 'rejected', 'rejected_finance', 'rejected_kepala']
                            )
                        ) : ?>

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahBahan">

                                <i class="bi bi-plus-circle"></i>

                                Tambah Bahan

                            </button>

                            <a href="<?= base_url('gizi/bahan') ?>" class="btn btn-info btn-sm" target="_blank">

                                <i class="bi bi-basket me-1"></i>
                                Master Bahan

                            </a>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Bahan</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <?php if (
                                    in_array(
                                        $transaksi['status'],
                                        ['draft', 'rejected', 'rejected_finance', 'rejected_kepala']
                                    )
                                ) : ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($details)) : ?>

                                <?php foreach ($details as $item) : ?>

                                    <tr>

                                        <td><?= esc($item['nama_bahan']) ?></td>

                                        <td><?= $item['qty'] ?></td>

                                        <td><?= esc($item['satuan']) ?></td>

                                        <td>
                                            Rp <?= number_format(
                                                    $item['harga'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>
                                        </td>

                                        <td>
                                            Rp <?= number_format(
                                                    $item['total_harga'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>
                                        </td>

                                        <?php if (
                                            in_array(
                                                $transaksi['status'],
                                                ['draft', 'rejected', 'rejected_finance', 'rejected_kepala']
                                            )
                                        ) : ?>
                                            <td width="100">
                                                <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="<?= $item['id'] ?>" data-bahan="<?= esc($item['nama_bahan']) ?>" data-qty="<?= $item['qty'] ?>" data-satuan="<?= esc($item['satuan']) ?>" data-bs-toggle="modal" data-bs-target="#modalEditQty">

                                                    <i class="bi bi-pencil"></i>

                                                </button>

                                                <a href="<?= base_url(
                                                                'gizi/bahan-baku/delete-detail/' .
                                                                    $item['id']
                                                            ) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus bahan ini?')">

                                                    <i class="bi bi-trash"></i>

                                                </a>
                                            </td>
                                        <?php endif; ?>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="6" class="text-center text-muted">

                                        Belum ada bahan

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>
                    <div class="card border-0 shadow-sm mt-3">

                        <div class="card-body text-end">

                            <h6 class="text-muted">

                                Estimasi Belanja

                            </h6>

                            <h3 class="text-primary mb-0">

                                Rp <?= number_format(
                                        $grand_total,
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>
<div class="modal fade" id="modalTambahBahan" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="<?= base_url('gizi/bahan-baku/store-detail') ?>" method="post">

                <input type="hidden" name="belanja_id" value="<?= $transaksi['id'] ?>">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Bahan

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Bahan

                        </label>

                        <?php
                        $usedBahanIds = [];
                        foreach ($details as $detailItem) {
                            if (isset($detailItem['bahan_id'])) {
                                $usedBahanIds[(string) $detailItem['bahan_id']] = true;
                            }
                        }
                        ?>
                        <select name="bahan_id" class="select2" required>

                            <option value="">
                                Pilih Bahan
                            </option>

                            <?php foreach ($bahans as $bahan) : ?>
                                <?php if (!isset($usedBahanIds[(string) $bahan['id']])) : ?>
                                    <option value="<?= $bahan['id'] ?>" data-satuan="<?= esc($bahan['satuan_default']) ?>" data-harga="<?= (float) ($bahan['harga'] ?? 0) ?>">

                                        <?= esc($bahan['nama_bahan']) ?>

                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>

                        <?php if (count($usedBahanIds) >= count($bahans)) : ?>
                            <div class="form-text text-danger">
                                Semua bahan Master Bahan sudah ada dalam permintaan ini.
                            </div>
                        <?php else : ?>
                            <div class="form-text text-muted">
                                Bahan yang sudah dimasukkan tidak dapat dipilih lagi.
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Satuan

                        </label>

                        <input type="text" id="satuan" class="form-control" readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Qty

                        </label>

                        <input type="number" step="0.01" id="qty" name="qty" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Harga Master Bahan</label>

                        <input type="text" id="hargaMaster" class="form-control" value="Rp 0" readonly>

                        <small id="hargaMasterHelp" class="text-muted">Harga diambil dari Master Bahan milik SPPG saat bahan ditambahkan.</small>

                    </div>

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

<div class="modal fade" id="modalEditQty" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form id="formEditQty" method="post">

                <?= csrf_field() ?>

                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Qty Bahan

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Nama Bahan

                        </label>

                        <input type="text" id="editNamaBahan" class="form-control" readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Satuan

                        </label>

                        <input type="text" id="editSatuan" class="form-control" readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Qty

                        </label>

                        <input type="number" step="0.01" name="qty" id="editQty" class="form-control" required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    function formatRupiah(value) {
        const number = Number(value || 0);
        return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(number);
    }

    $('#modalTambahBahan').on('change', '.select2', function() {

        const selected = $(this).find(':selected');
        const satuan = selected.data('satuan');
        const harga = Number(selected.data('harga') || 0);

        $('#satuan').val(satuan || '');
        $('#hargaMaster').val(formatRupiah(harga));
        $('#hargaMasterHelp').text(
            harga > 0
                ? 'Harga otomatis mengikuti Master Bahan SPPG dan disimpan sebagai snapshot transaksi.'
                : 'Harga bahan ini belum diatur oleh Koperasi; transaksi akan tersimpan dengan harga Rp 0.'
        );

    });

    console.log("jQuery :", typeof $);
    console.log("Select2 :", typeof $.fn.select2);
    $(document).ready(function() {

        $('#modalTambahBahan').on('shown.bs.modal', function() {

            if (!$('.select2').hasClass("select2-hidden-accessible")) {

                $('.select2').select2({

                    dropdownParent: $('#modalTambahBahan'),

                    width: '100%',

                    placeholder: 'Cari bahan...',

                    allowClear: true

                });

            }

        });

    });



    document.querySelectorAll('.btn-edit').forEach(function(btn) {

        btn.addEventListener('click', function() {

            document.getElementById('editNamaBahan').value =
                this.dataset.bahan;

            document.getElementById('editSatuan').value =
                this.dataset.satuan;

            document.getElementById('editQty').value =
                this.dataset.qty;

            document.getElementById('formEditQty').action =
                "<?= base_url('gizi/bahan-baku/update-detail') ?>/" +
                this.dataset.id;

        });

    });
</script>



<?= $this->endSection() ?>