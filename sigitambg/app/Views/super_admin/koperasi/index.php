<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <h5 class="mb-1 fw-bold">Master Koperasi</h5>
                <small class="text-muted">Kelola koperasi dan penugasan beberapa SPPG untuk pengelolaan harga pokok barang.</small>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= base_url('super-admin') ?>" class="btn btn-light border rounded-3">← Kembali</a>
                <a href="<?= base_url('super-admin/koperasi/create') ?>" class="btn btn-primary rounded-3">+ Tambah Koperasi</a>
            </div>
        </div>

        <?php if ($m = session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-3"><?= esc($m) ?></div>
        <?php endif; ?>
        <?php if ($m = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-3"><?= esc($m) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-3 p-md-4">
                <form method="get" action="<?= base_url('super-admin/koperasi') ?>" class="row g-2 align-items-end">
                    <div class="col-md-7">
                        <label class="form-label small text-muted">Cari Koperasi</label>
                        <input type="search" name="q" value="<?= esc($search) ?>" class="form-control rounded-3" placeholder="Kode, nama, alamat, telepon, atau email...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="">Semua Status</option>
                            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-primary rounded-3 flex-grow-1">Cari</button>
                        <?php if ($search !== '' || $status !== ''): ?>
                            <a href="<?= base_url('super-admin/koperasi') ?>" class="btn btn-light border rounded-3">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1 fw-bold">Daftar Koperasi</h6>
                        <small class="text-muted">Data terbaru ditampilkan lebih dahulu.</small>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3"><?= number_format($pager->getTotal()) ?> Koperasi</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Koperasi</th>
                                <th>Kontak</th>
                                <th class="text-center">SPPG</th>
                                <th class="text-center">User</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!$koperasis): ?>
                            <tr><td colspan="6" class="text-center text-muted py-5">Tidak ada data koperasi.</td></tr>
                        <?php endif; ?>
                        <?php foreach ($koperasis as $k): ?>
                            <?php $aktif = ($k['status'] ?? '') === 'active'; ?>
                            <tr>
                                <td>
                                    <strong><?= esc($k['nama_koperasi']) ?></strong><br>
                                    <small class="text-muted"># <?= esc($k['kode_koperasi']) ?></small>
                                </td>
                                <td>
                                    <?= esc($k['telepon'] ?: '-') ?><br>
                                    <small class="text-muted"><?= esc($k['email'] ?: '-') ?></small>
                                </td>
                                <td class="text-center"><span class="badge bg-light text-primary border rounded-pill"><?= number_format($k['jumlah_sppg']) ?></span></td>
                                <td class="text-center"><span class="badge bg-light text-dark border rounded-pill"><?= number_format($k['jumlah_user']) ?></span></td>
                                <td><span class="badge bg-<?= $aktif ? 'success' : 'secondary' ?> rounded-pill"><?= $aktif ? 'Aktif' : 'Nonaktif' ?></span></td>
                                <td>
                                    <div class="d-flex justify-content-end flex-wrap gap-2">
                                        <a href="<?= base_url('super-admin/koperasi/detail/'.$k['id']) ?>" class="btn btn-outline-primary btn-sm rounded-3">SPPG</a>
                                        <a href="<?= base_url('super-admin/koperasi/edit/'.$k['id']) ?>" class="btn btn-outline-primary btn-sm rounded-3">Edit</a>
                                        <form method="post" action="<?= base_url('super-admin/koperasi/toggle/'.$k['id']) ?>" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-outline-<?= $aktif ? 'danger' : 'success' ?> btn-sm rounded-3" onclick="return confirm('<?= $aktif ? 'Nonaktifkan' : 'Aktifkan' ?> koperasi ini?')"><?= $aktif ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                                        </form>
                                        <?php if ((int)$k['jumlah_sppg'] === 0 && (int)$k['jumlah_user'] === 0): ?>
                                            <form method="post" action="<?= base_url('super-admin/koperasi/delete/'.$k['id']) ?>" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-outline-danger btn-sm rounded-3" onclick="return confirm('Hapus koperasi ini secara permanen?')">Hapus</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pager->getPageCount() > 1): ?>
                    <?php
                    $cur = $pager->getCurrentPage();
                    $pages = $pager->getPageCount();
                    $url = function ($p) use ($search, $status) {
                        $params = ['page' => $p];
                        if ($search !== '') $params['q'] = $search;
                        if ($status !== '') $params['status'] = $status;
                        return base_url('super-admin/koperasi') . '?' . http_build_query($params);
                    };
                    ?>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
                        <small class="text-muted">Halaman <?= $cur ?> dari <?= $pages ?> · <?= number_format($pager->getTotal()) ?> koperasi</small>
                        <nav><ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= $cur <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= $cur > 1 ? esc($url($cur-1)) : '#' ?>">‹</a></li>
                            <?php $start = max(1, $cur-2); $end = min($pages, $cur+2); for ($p=$start; $p<=$end; $p++): ?>
                                <li class="page-item <?= $p === $cur ? 'active' : '' ?>"><a class="page-link" href="<?= esc($url($p)) ?>"><?= $p ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?= $cur >= $pages ? 'disabled' : '' ?>"><a class="page-link" href="<?= $cur < $pages ? esc($url($cur+1)) : '#' ?>">›</a></li>
                        </ul></nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
