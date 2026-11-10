<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container py-3" style="max-width:1100px;">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Audit Aktivitas User</h4>
            <p class="text-muted mb-0">Riwayat aktivitas pengguna di seluruh SPPG.</p>
        </div>
        <a href="<?= base_url(session('user_level') === 'super_admin' ? 'super-admin' : 'admin') ?>" class="btn btn-outline-primary">← Kembali</a>
    </div>

    <?php if ($msg = session('success')): ?><div class="alert alert-success"><?= esc($msg) ?></div><?php endif; ?>
    <?php if ($msg = session('error')): ?><div class="alert alert-danger"><?= esc($msg) ?></div><?php endif; ?>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">Aktivitas Hari Ini</small><h3 class="mb-0 text-primary"><?= number_format($summary['today']) ?></h3></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">User Aktif Beraktivitas</small><h3 class="mb-0 text-success"><?= number_format($summary['unique_today']) ?></h3></div></div></div>
        <div class="col-12 col-md-4"><div class="card border-0 shadow-sm rounded-4 h-100"><div class="card-body"><small class="text-muted">Login Berhasil Hari Ini</small><h3 class="mb-0 text-info"><?= number_format($summary['login_today']) ?></h3></div></div></div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">
            <form method="get" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label small">Pencarian</label>
                    <input type="text" name="q" value="<?= esc($q) ?>" class="form-control" placeholder="Nama, email, aktivitas, SPPG...">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small">Role</label>
                    <select name="level" class="form-select"><option value="">Semua</option><?php foreach ($levels as $item): ?><option value="<?= esc($item) ?>" <?= $level === $item ? 'selected' : '' ?>><?= esc(ucwords(str_replace('_',' ',$item))) ?></option><?php endforeach; ?></select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small">SPPG</label>
                    <select name="id_sppg" class="form-select"><option value="">Semua</option><?php foreach ($sppgs as $sppg): ?><option value="<?= esc($sppg['id_sppg']) ?>" <?= $id_sppg === $sppg['id_sppg'] ? 'selected' : '' ?>><?= esc($sppg['sppg_name']) ?></option><?php endforeach; ?></select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small">Modul</label>
                    <select name="module" class="form-select"><option value="">Semua</option><?php foreach ($modules as $item): ?><option value="<?= esc($item['module']) ?>" <?= $module === $item['module'] ? 'selected' : '' ?>><?= esc($item['module']) ?></option><?php endforeach; ?></select>
                </div>
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1" type="submit">Cari</button>
                    <a href="<?= base_url('super-admin/aktivitas') ?>" class="btn btn-light">Reset</a>
                </div>
                <div class="col-6 col-md-2"><label class="form-label small">Dari</label><input type="date" name="start" value="<?= esc($start) ?>" class="form-control"></div>
                <div class="col-6 col-md-2"><label class="form-label small">Sampai</label><input type="date" name="end" value="<?= esc($end) ?>" class="form-control"></div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div><h6 class="mb-1">Riwayat Aktivitas</h6><small class="text-muted">Setiap request terautentikasi dicatat tanpa menyimpan password.</small></div>
                <span class="badge bg-primary"><?= number_format(count($activities)) ?> data</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Waktu</th><th>User</th><th>Role</th><th>SPPG</th><th>Modul</th><th>Aktivitas</th></tr></thead>
                    <tbody>
                    <?php if (!$activities): ?><tr><td colspan="6" class="text-center text-muted py-4">Belum ada aktivitas yang tercatat.</td></tr>
                    <?php else: foreach ($activities as $row): ?>
                        <tr>
                            <td class="text-nowrap"><small><?= esc(date('d-m-Y H:i', strtotime($row['created_at']))) ?></small></td>
                            <td><strong><?= esc($row['full_name'] ?: $row['username']) ?></strong><br><small class="text-muted"><?= esc($row['username']) ?></small></td>
                            <td><span class="badge bg-light text-dark"><?= esc(ucwords(str_replace('_',' ', $row['user_level']))) ?></span></td>
                            <td><?= esc($row['sppg_name'] ?: '-') ?></td>
                            <td><?= esc($row['module']) ?></td>
                            <td><?= esc($row['activity']) ?><br><small class="text-muted"><?= esc($row['method']) ?> <?= esc($row['uri']) ?></small></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3"><?= $pager->only(['page'])->links() ?></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
