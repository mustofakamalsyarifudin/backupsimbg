<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<style>
    .sppg-actions {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .sppg-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        min-height: 38px;
        padding: .45rem .8rem;
        border-radius: .75rem;
        font-size: .875rem;
        line-height: 1.2;
        white-space: nowrap;
        font-weight: 500;
    }

    .sppg-action i {
        font-size: .9rem;
        line-height: 1;
    }

    .sppg-action-form {
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .sppg-actions {
            justify-content: flex-start;
            width: 100%;
        }

        .sppg-action {
            min-height: 36px;
            padding: .4rem .7rem;
        }
    }
</style>


<div class="page-content-wrapper py-3">
    <div class="container">

        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="mb-1">Master SPPG</h5>
                <small class="text-muted">Kelola data SPPG, status, dan informasi operasional.</small>
            </div>
            <a href="<?= base_url('super-admin') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <?php if ($m = session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-4">
                <i class="bi bi-check-circle-fill me-1"></i><?= esc($m) ?>
            </div>
        <?php endif; ?>

        <?php if ($m = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <i class="bi bi-exclamation-triangle-fill me-1"></i><?= esc($m) ?>
            </div>
        <?php endif; ?>

        <?php $validation = session()->getFlashdata('errors') ?? []; ?>
        <?php if (isset($validation) && is_array($validation) && $validation): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <strong><i class="bi bi-exclamation-circle me-1"></i>Periksa data berikut:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    <?php foreach ($validation as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;">
                        <i class="bi bi-building-add"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Tambah SPPG</h6>
                        <small class="text-muted">Isi data dasar SPPG baru.</small>
                    </div>
                </div>

                <form method="post" action="<?= base_url('super-admin/sppg/store') ?>" novalidate>
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">ID SPPG <span class="text-danger">*</span></label>
                            <input type="text" name="id_sppg" value="<?= esc(old('id_sppg')) ?>" class="form-control rounded-3 <?= isset($validation['id_sppg']) ? 'is-invalid' : '' ?>" maxlength="20" placeholder="Contoh: Pandak02" required>
                            <div class="form-text">Maks. 20 karakter, tanpa spasi.</div>
                            <?php if (isset($validation['id_sppg'])): ?><div class="invalid-feedback"><?= esc($validation['id_sppg']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold">Nama SPPG <span class="text-danger">*</span></label>
                            <input type="text" name="sppg_name" value="<?= esc(old('sppg_name')) ?>" class="form-control rounded-3 <?= isset($validation['sppg_name']) ? 'is-invalid' : '' ?>" maxlength="100" placeholder="Nama lengkap SPPG" required>
                            <?php if (isset($validation['sppg_name'])): ?><div class="invalid-feedback"><?= esc($validation['sppg_name']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" value="<?= esc(old('email')) ?>" class="form-control rounded-3 <?= isset($validation['email']) ? 'is-invalid' : '' ?>" maxlength="100" placeholder="email@sppg-mbg.net">
                            <?php if (isset($validation['email'])): ?><div class="invalid-feedback"><?= esc($validation['email']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Alamat</label>
                            <textarea name="address" rows="2" class="form-control rounded-3" placeholder="Alamat lengkap SPPG"><?= esc(old('address')) ?></textarea>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Telepon</label>
                            <input type="text" name="phone" value="<?= esc(old('phone')) ?>" class="form-control rounded-3 <?= isset($validation['phone']) ? 'is-invalid' : '' ?>" maxlength="20" placeholder="021...">
                            <?php if (isset($validation['phone'])): ?><div class="invalid-feedback"><?= esc($validation['phone']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Tanggal Berdiri</label>
                            <input type="date" name="established_date" value="<?= esc(old('established_date')) ?>" class="form-control rounded-3 <?= isset($validation['established_date']) ? 'is-invalid' : '' ?>">
                            <?php if (isset($validation['established_date'])): ?><div class="invalid-feedback"><?= esc($validation['established_date']) ?></div><?php endif; ?>
                        </div>
                        <div class="col-12 text-end">
                            <button type="reset" class="btn btn-light rounded-pill px-3 me-1">Reset</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-check-lg me-1"></i>Simpan SPPG</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                    <div>
                        <h6 class="mb-1">Daftar SPPG</h6>
                        <small class="text-muted">Data terbaru ditampilkan lebih dahulu.</small>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3"><?= number_format($pager->getTotal()) ?> SPPG</span>
                </div>

                <form method="get" action="<?= base_url('super-admin/sppg') ?>" class="mb-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="search" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0 border-end-0" placeholder="Cari ID, nama, telepon, atau email SPPG..." autocomplete="off">
                                <button type="submit" class="btn btn-primary px-3">Cari</button>
                            </div>
                        </div>
                        <?php if (!empty($search)): ?>
                            <div class="col-auto">
                                <a href="<?= base_url('super-admin/sppg') ?>" class="btn btn-light rounded-3">
                                    <i class="bi bi-x-lg me-1"></i>Reset
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>

                <?php if (!empty($search)): ?>
                    <div class="alert alert-primary border-0 rounded-3 py-2 px-3 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Menampilkan hasil pencarian untuk <strong><?= esc($search) ?></strong>.
                        Ditemukan <strong><?= number_format($pager->getTotal()) ?></strong> SPPG.
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>SPPG</th>
                                <th>Kontak</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$sppgs): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data SPPG.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($sppgs as $s): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= esc($s['sppg_name']) ?></div>
                                        <small class="text-muted"><i class="bi bi-hash"></i><?= esc($s['id_sppg']) ?></small>
                                    </td>
                                    <td>
                                        <div><?= esc($s['phone'] ?: '-') ?></div>
                                        <small class="text-muted"><?= esc($s['email'] ?: '-') ?></small>
                                    </td>
                                    <td>
                                        <?php if ($s['status'] === 'active'): ?>
                                            <span class="badge bg-success rounded-pill">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="sppg-actions">
                                            <a href="<?= base_url('super-admin/sppg/edit/' . rawurlencode($s['id_sppg'])) ?>" class="btn btn-outline-primary sppg-action">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>Edit</span>
                                            </a>
                                            <form method="post" action="<?= base_url('super-admin/sppg/toggle/' . rawurlencode($s['id_sppg'])) ?>" class="sppg-action-form">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-<?= $s['status'] === 'active' ? 'danger' : 'success' ?> sppg-action" onclick="return confirm('<?= $s['status'] === 'active' ? 'Nonaktifkan' : 'Aktifkan' ?> SPPG ini?')">
                                                    <i class="bi bi-power"></i>
                                                    <span><?= $s['status'] === 'active' ? 'Nonaktifkan' : 'Aktifkan' ?></span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pager->getPageCount() > 1): ?>
                    <?php
                        $currentPage = $pager->getCurrentPage();
                        $pageCount = $pager->getPageCount();
                        $makePageUrl = static function (int $page) use ($search): string {
                            $params = ['page' => $page];
                            if ($search !== '') {
                                $params['q'] = $search;
                            }
                            return base_url('super-admin/sppg') . '?' . http_build_query($params);
                        };
                    ?>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
                        <small class="text-muted">
                            Halaman <?= $currentPage ?> dari <?= $pageCount ?>
                            · <?= number_format($pager->getTotal()) ?> SPPG
                        </small>
                        <nav aria-label="Pagination SPPG">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link rounded-start-3" href="<?= $currentPage > 1 ? esc($makePageUrl($currentPage - 1)) : '#' ?>" aria-label="Sebelumnya">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($pageCount, $currentPage + 2);
                                    if ($startPage > 1):
                                ?>
                                    <li class="page-item"><a class="page-link" href="<?= esc($makePageUrl(1)) ?>">1</a></li>
                                    <?php if ($startPage > 2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
                                <?php endif; ?>

                                <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                                    <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= esc($makePageUrl($page)) ?>"><?= $page ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($endPage < $pageCount): ?>
                                    <?php if ($endPage < $pageCount - 1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
                                    <li class="page-item"><a class="page-link" href="<?= esc($makePageUrl($pageCount)) ?>"><?= $pageCount ?></a></li>
                                <?php endif; ?>

                                <li class="page-item <?= $currentPage >= $pageCount ? 'disabled' : '' ?>">
                                    <a class="page-link rounded-end-3" href="<?= $currentPage < $pageCount ? esc($makePageUrl($currentPage + 1)) : '#' ?>" aria-label="Berikutnya">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
