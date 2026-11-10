<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <div class="mb-3">
            <h5 class="mb-1">Dashboard Super Admin</h5>
            <small class="text-muted">Pusat kendali dan monitoring seluruh SPPG</small>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;overflow:hidden;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50">Selamat Datang</small>
                        <h4 class="text-white fw-bold mt-2 mb-1"><?= esc(session('full_name') ?: 'Super Admin') ?></h4>
                        <p class="text-white-50 mb-2">Administrator Pusat SIGITA</p>
                        <span class="badge bg-light text-primary">Akses seluruh SPPG</span>
                    </div>
                    <div>
                        <i class="bi bi-shield-lock-fill text-white-50" style="font-size:68px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3"><h6>Menu Utama</h6></div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <a href="<?= base_url('super-admin/sppg') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-building text-primary" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Master SPPG</h6>
                            <small class="text-muted">Kelola SPPG</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= base_url('super-admin/koperasi') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-shop text-success" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Master Koperasi</h6>
                            <small class="text-muted">Atur koperasi & SPPG</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= base_url('super-admin/users') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-people-fill text-danger" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Manajemen User</h6>
                            <small class="text-muted">Kelola seluruh akun</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= base_url('super-admin/aktivitas') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-person-lines-fill text-warning" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Audit Aktivitas</h6>
                            <small class="text-muted">Jejak aktivitas pengguna</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= base_url('admin/laporan') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-bar-chart-fill text-info" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Laporan</h6>
                            <small class="text-muted">Semua SPPG</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="<?= base_url('admin/laporan') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body text-center py-3">
                            <i class="bi bi-clipboard-data-fill text-primary" style="font-size:38px;"></i>
                            <h6 class="mt-2 mb-0">Monitoring SPPG</h6>
                            <small class="text-muted">Ringkasan pusat</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="mb-3"><h6>Ringkasan Sistem</h6></div>
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-primary mb-1"><?= number_format($activeSppg) ?></h3>
                    <small>SPPG Aktif</small>
                    <div class="mt-1"><small class="text-muted"><?= number_format($inactiveSppg) ?> nonaktif</small></div>
                </div></div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-success mb-1"><?= number_format($activeUser) ?></h3>
                    <small>User Aktif</small>
                    <div class="mt-1"><small class="text-muted"><?= number_format($inactiveUser) ?> nonaktif</small></div>
                </div></div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-warning mb-1"><?= number_format($activeKoperasi) ?></h3>
                    <small>Koperasi Aktif</small>
                    <div class="mt-1"><small class="text-muted"><?= number_format($assignedSppg) ?> penugasan SPPG</small></div>
                </div></div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-danger mb-1"><?= number_format($totalPM) ?></h3>
                    <small>Total Penerima Manfaat</small>
                </div></div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-info mb-1"><?= number_format($totalKegiatan) ?></h3>
                    <small>Total Kegiatan</small>
                </div></div>
            </div>
            <div class="col-6">
                <div class="card border-0 shadow-sm"><div class="card-body text-center">
                    <h3 class="text-danger mb-1"><?= number_format($pendingRequest) ?></h3>
                    <small>Request Bahan Menunggu</small>
                </div></div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">Distribusi User Berdasarkan Role</h6>
                        <small class="text-muted">Ringkasan seluruh akun di SIGITA</small>
                    </div>
                    <span class="badge bg-primary"><?= number_format($totalUser) ?> user</span>
                </div>
                <div class="row g-2">
                    <?php
                    $roleLabels = [
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'kepala' => 'Kepala',
                        'gizi' => 'Gizi',
                        'keuangan' => 'Keuangan',
                        'aslap' => 'Aslap',
                        'koperasi' => 'Koperasi',
                    ];
                    foreach ($roleLabels as $role => $label):
                        $jumlah = $roleCounts[$role] ?? 0;
                    ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="border rounded-3 p-2 d-flex justify-content-between align-items-center">
                            <small><?= esc($label) ?></small>
                            <strong><?= number_format($jumlah) ?></strong>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-1">SPPG Terbaru</h6>
                        <small class="text-muted">SPPG yang terakhir ditambahkan</small>
                    </div>
                    <a href="<?= base_url('super-admin/sppg') ?>" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>SPPG</th><th>User</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php if (!$recentSppgs): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data SPPG.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentSppgs as $sppg): ?>
                                <tr>
                                    <td><strong><?= esc($sppg['sppg_name']) ?></strong><br><small class="text-muted"><?= esc($sppg['id_sppg']) ?></small></td>
                                    <td><?= number_format($sppg['jumlah_user']) ?></td>
                                    <td><span class="badge bg-<?= $sppg['status'] === 'active' ? 'success' : 'secondary' ?>"><?= esc($sppg['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
