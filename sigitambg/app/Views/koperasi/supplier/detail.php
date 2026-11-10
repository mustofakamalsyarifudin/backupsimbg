<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <?php if ($m = session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-4"><?= esc($m) ?></div>
        <?php endif; ?>
        <?php if ($m = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4"><?= esc($m) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <h5 class="mb-1 fw-bold"><?= esc($row['nama_supplier']) ?></h5>
                <small class="text-muted"><?= esc($row['kode_supplier']) ?> · PIC <?= esc($row['nama_pic'] ?: '-') ?></small>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('koperasi/supplier/edit/' . $row['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
                <a href="<?= base_url('koperasi/supplier') ?>" class="btn btn-light border">Kembali</a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Data Supplier</h6>
                        <div><strong>PIC:</strong> <?= esc($row['nama_pic'] ?: '-') ?></div>
                        <div><strong>HP/WA:</strong> <?= esc($row['no_hp'] ?: '-') ?></div>
                        <div><strong>Email:</strong> <?= esc($row['email'] ?: '-') ?></div>
                        <div><strong>NPWP/NIK:</strong> <?= esc($row['npwp_nik'] ?: '-') ?></div>
                        <div><strong>Alamat:</strong> <?= nl2br(esc($row['alamat'] ?: '-')) ?></div>
                        <div><strong>Wilayah:</strong> <?= esc($row['kabupaten_kota'] ?: '-') ?>, <?= esc($row['provinsi'] ?: '-') ?></div>
                        <div><strong>Status:</strong> <span class="badge bg-<?= ($row['status'] ?? 'aktif') === 'aktif' ? 'success' : 'secondary' ?> rounded-pill"><?= esc(ucfirst($row['status'] ?? 'aktif')) ?></span></div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">MOU / Perjanjian Kerja Sama</h6>
                        <span class="badge bg-<?= esc($row['mou_state']['class']) ?> rounded-pill"><?= esc($row['mou_state']['label']) ?></span>
                        <?php if (!empty($row['tanggal_mou_mulai'])): ?>
                            <div class="mt-2">Mulai: <strong><?= date('d/m/Y', strtotime($row['tanggal_mou_mulai'])) ?></strong></div>
                        <?php endif; ?>
                        <?php if (!empty($row['tanggal_mou_akhir'])): ?>
                            <div>Berakhir: <strong><?= date('d/m/Y', strtotime($row['tanggal_mou_akhir'])) ?></strong></div>
                        <?php endif; ?>
                        <?php if (($row['mou_state']['days'] ?? null) !== null && $row['mou_state']['days'] >= 0): ?>
                            <div class="small text-muted mt-1">Sisa <?= esc($row['mou_state']['days']) ?> hari.</div>
                        <?php endif; ?>
                        <?php if (!empty($row['catatan'])): ?>
                            <hr>
                            <div><strong>Catatan:</strong><br><?= nl2br(esc($row['catatan'])) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h6 class="fw-bold mb-0">Berkas Penting Supplier</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border btn-sm" data-bs-toggle="modal" data-bs-target="#jenisDoc"><i class="bi bi-gear me-1"></i>Jenis Dokumen</button>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadDoc"><i class="bi bi-upload me-1"></i>Upload Berkas</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Jenis</th><th>Nama</th><th>File</th><th>Upload</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php if (!$docs): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada berkas.</td></tr>
                        <?php else: foreach ($docs as $d): ?>
                            <tr>
                                <td><?= esc($d['nama_jenis']) ?></td>
                                <td><?= esc($d['nama_berkas']) ?></td>
                                <td>
                                    <a target="_blank" rel="noopener" href="<?= base_url($d['file_path']) ?>"><?= esc($d['file_name']) ?></a><br>
                                    <small class="text-muted"><?= number_format(((int) $d['file_size']) / 1024, 0, ',', '.') ?> KB</small>
                                </td>
                                <td><?= !empty($d['created_at']) ? date('d/m/Y H:i', strtotime($d['created_at'])) : '-' ?></td>
                                <td class="text-nowrap">
                                    <a target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary" href="<?= base_url($d['file_path']) ?>" title="Lihat berkas"><i class="bi bi-eye"></i></a>
                                    <form class="d-inline" method="post" action="<?= base_url('koperasi/supplier/document/delete/' . $d['id']) ?>" onsubmit="return confirm('Hapus berkas ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus berkas"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold mb-1">Supplier → Bahan</h6>
                        <small class="text-muted">Atur bahan yang dapat disediakan supplier dan harga beli terbaru.</small>
                    </div>
                    <form method="get" class="d-flex gap-2 align-items-center">
                        <label for="selectSppg" class="small text-muted">SPPG</label>
                        <select id="selectSppg" name="id_sppg" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Pilih SPPG</option>
                            <?php foreach ($assigned as $s): ?>
                                <option value="<?= esc($s['id_sppg']) ?>" <?= (string) $sppgId === (string) $s['id_sppg'] ? 'selected' : '' ?>><?= esc($s['sppg_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <?php if ($sppgId): ?>
                    <hr>
                    <form action="<?= base_url('koperasi/supplier/link-bahan/' . $row['id']) ?>" method="post" class="row g-2 mb-3">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_sppg" value="<?= esc($sppgId) ?>">
                        <div class="col-md-6">
                            <label class="form-label" for="bahanId">Pilih Bahan</label>
                            <select id="bahanId" name="bahan_id" class="form-select" required>
                                <option value="">Pilih bahan...</option>
                                <?php foreach ($available as $b): ?>
                                    <option value="<?= esc($b['id']) ?>"><?= esc($b['nama_bahan']) ?> — <?= esc($b['satuan_default']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="hargaBeli">Harga Beli Supplier</label>
                            <input id="hargaBeli" type="number" name="harga_beli" min="0" step="0.01" class="form-control" placeholder="Harga beli supplier" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100" type="submit">Hubungkan</button></div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle" id="tableSupplierBahan">
                            <thead><tr><th>Bahan</th><th>Satuan</th><th>Harga Beli Supplier</th><th>Harga Jual SPPG</th><th>Margin</th><th>Aksi</th></tr></thead>
                            <tbody>
                            <?php foreach ($linked as $b):
                                $sppgPrice = (float) ($b['harga_jual'] ?? 0);
                                $buyPrice = (float) ($b['harga_beli'] ?? 0);
                                $margin = $sppgPrice - $buyPrice;
                            ?>
                                <tr>
                                    <td class="fw-semibold"><?= esc($b['nama_bahan']) ?><?php if (($b['status'] ?? 'aktif') !== 'aktif'): ?><br><span class="badge bg-secondary">Relasi nonaktif</span><?php endif; ?></td>
                                    <td><?= esc($b['satuan_default']) ?></td>
                                    <td>Rp <?= number_format($buyPrice, 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($sppgPrice > 0): ?>
                                            Rp <?= number_format($sppgPrice, 0, ',', '.') ?><br><small class="text-muted">Harga Master Bahan SPPG</small>
                                        <?php else: ?>
                                            <span class="text-warning fw-semibold">Belum ditetapkan</span><br><small class="text-muted">Atur harga pada Master Bahan</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($sppgPrice > 0): ?>
                                            <span class="<?= $margin < 0 ? 'text-danger' : 'text-success' ?> fw-bold">Rp <?= number_format($margin, 0, ',', '.') ?></span>
                                        <?php else: ?><span class="text-muted">—</span><?php endif; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#price<?= (int) $b['id'] ?>">Harga</button>
                                        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('koperasi/supplier/history-harga/' . $b['id']) ?>">Riwayat</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (!$linked): ?><tr><td colspan="6" class="text-center text-muted py-4">Belum ada bahan yang dihubungkan untuk SPPG ini.</td></tr><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php foreach ($linked as $b): ?>
                        <div class="modal fade" id="price<?= (int) $b['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4">
                                    <form method="post" action="<?= base_url('koperasi/supplier/update-harga/' . $b['id']) ?>">
                                        <?= csrf_field() ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Harga Beli</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="fw-bold mb-1"><?= esc($b['nama_bahan']) ?></p>
                                            <small class="text-muted">Harga Master Bahan SPPG: Rp <?= number_format((float) ($b['harga_jual'] ?? 0), 0, ',', '.') ?></small>
                                            <input type="hidden" name="id_sppg" value="<?= esc($sppgId) ?>">
                                            <div class="mt-3"><label class="form-label">Harga Beli Supplier</label><input type="number" name="harga_beli" class="form-control" min="0" step="0.01" value="<?= esc($b['harga_beli']) ?>" required></div>
                                            <div class="mt-3"><label class="form-label">Berlaku Mulai</label><input type="date" name="berlaku_mulai" class="form-control" value="<?= date('Y-m-d') ?>"></div>
                                            <div class="mt-3"><label class="form-label">Keterangan</label><input name="keterangan" class="form-control" maxlength="255" placeholder="Contoh: update harga mingguan"></div>
                                        </div>
                                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Harga</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info mt-3 mb-0">Pilih SPPG untuk melihat dan menghubungkan bahan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadDoc" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content rounded-4">
        <form method="post" enctype="multipart/form-data" action="<?= base_url('koperasi/supplier/document/upload/' . $row['id']) ?>">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title">Upload Berkas Supplier</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
            <div class="modal-body"><div class="row g-3">
                <div class="col-md-5"><label class="form-label">Jenis Dokumen *</label><select name="jenis_dokumen_id" class="form-select" required><option value="">Pilih...</option><?php foreach ($types as $t): if ($t['status'] === 'aktif'): ?><option value="<?= esc($t['id']) ?>"><?= esc($t['nama_jenis']) ?></option><?php endif; endforeach; ?></select></div>
                <div class="col-md-7"><label class="form-label">Nama Berkas</label><input name="nama_berkas" class="form-control" maxlength="200" placeholder="Contoh: MOU Supplier 2026"></div>
                <div class="col-12"><label class="form-label">File *</label><input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required><div class="form-text">Maksimal 5 MB. PDF/JPG/JPEG/PNG.</div></div>
                <div class="col-12"><label class="form-label">Keterangan</label><input name="keterangan" class="form-control" maxlength="255"></div>
            </div></div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Upload</button></div>
        </form>
    </div></div>
</div>

<div class="modal fade" id="jenisDoc" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content rounded-4">
        <form method="post" action="<?= base_url('koperasi/supplier/jenis/store') ?>">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title">Tambah Jenis Dokumen</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
            <div class="modal-body"><label class="form-label">Nama Jenis Dokumen *</label><input name="nama_jenis" class="form-control" maxlength="100" placeholder="Contoh: Sertifikat Halal" required><label class="form-label mt-3">Keterangan</label><input name="keterangan" class="form-control" maxlength="255"><div class="small text-muted mt-3">Jenis dokumen baru langsung tersedia pada pilihan Upload Berkas.</div></div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Tambah Jenis</button></div>
        </form>
    </div></div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('#tableSupplierBahan');
    if (table && typeof DataTable !== 'undefined') {
        new DataTable(table, { searchable: true, fixedHeight: true, perPage: 10, perPageSelect: [5, 10, 25, 50, 100] });
    }
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
