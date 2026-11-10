<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0">Rencana Menu</h5>
                <small class="text-muted">Pengaturan menu berdasarkan tanggal.</small>
            </div>

            <a href="<?= base_url('gizi/rencana-menu/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Buat Rencana
            </a>
        </div>

        <?php if (session('error')) : ?>
            <div class="alert alert-danger"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <?php if (session('success')) : ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('gizi/rencana-menu') ?>">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                   value="<?= esc($tanggalMulai ?? '') ?>">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                   value="<?= esc($tanggalAkhir ?? '') ?>">
                        </div>
                        <div class="col-12 col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="<?= base_url('gizi/rencana-menu') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($tanggalMulai) || !empty($tanggalAkhir)) : ?>
                        <div class="small text-muted mt-2">
                            Menampilkan rencana dari
                            <strong><?= $tanggalMulai ? date('d-m-Y', strtotime($tanggalMulai)) : 'awal data' ?></strong>
                            sampai
                            <strong><?= $tanggalAkhir ? date('d-m-Y', strtotime($tanggalAkhir)) : 'terbaru' ?></strong>.
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                <?php if (empty($rencana)) : ?>

                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calendar2-x fs-1"></i>
                        <div class="mt-2">Belum ada rencana menu pada periode tersebut.</div>
                    </div>

                <?php else : ?>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($rencana as $row) : ?>
                                <tr>
                                    <td class="fw-semibold">
                                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                                    </td>

                                    <td>
                                        <?php if ($row['status'] === 'ditetapkan') : ?>
                                            <span class="badge bg-success">Ditetapkan</span>
                                        <?php elseif ($row['status'] === 'dibatalkan') : ?>
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($row['status'] === 'dibatalkan' && !empty($row['alasan_pembatalan']) ? $row['alasan_pembatalan'] : ($row['catatan'] ?? '-')) ?></td>

                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('gizi/rencana-menu/detail/' . $row['id']) ?>"
                                               class="btn btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <?php if ($row['status'] === 'draft') : ?>
                                                <a href="<?= base_url('gizi/rencana-menu/edit/' . $row['id']) ?>"
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            <?php elseif ($row['status'] === 'ditetapkan') : ?>
                                                <a href="<?= base_url('gizi/rencana-menu/pdf/' . $row['id']) ?>"
                                                   class="btn btn-outline-danger" title="Cetak PDF" target="_blank">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </a>
                                            <?php elseif ($row['status'] === 'dibatalkan') : ?>
                                                <a href="<?= base_url('gizi/rencana-menu/create?tanggal=' . urlencode($row['tanggal'])) ?>"
                                                   class="btn btn-outline-primary" title="Buat rencana pengganti">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    $pagerGroup = 'rencanaMenu';
                    $currentPage = $pager->getCurrentPage($pagerGroup);
                    $pageCount = $pager->getPageCount($pagerGroup);
                    $totalRows = $pager->getTotal($pagerGroup);
                    $perPage = $pager->getPerPage($pagerGroup);
                    $firstRow = $totalRows > 0 ? (($currentPage - 1) * $perPage) + 1 : 0;
                    $lastRow = min($currentPage * $perPage, $totalRows);
                    $makePageUrl = static function (int $page) use ($tanggalMulai, $tanggalAkhir): string {
                        $params = ['page_rencanaMenu' => $page];
                        if ($tanggalMulai !== '') $params['tanggal_mulai'] = $tanggalMulai;
                        if ($tanggalAkhir !== '') $params['tanggal_akhir'] = $tanggalAkhir;
                        return base_url('gizi/rencana-menu') . '?' . http_build_query($params);
                    };
                    ?>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                        <div class="small text-muted">
                            Menampilkan <?= number_format($firstRow) ?>–<?= number_format($lastRow) ?>
                            dari <?= number_format($totalRows) ?> rencana.
                        </div>

                        <?php if ($pageCount > 1) : ?>
                            <nav aria-label="Pagination Rencana Menu">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= $currentPage > 1 ? esc($makePageUrl($currentPage - 1)) : '#' ?>">&laquo;</a>
                                    </li>

                                    <?php
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($pageCount, $currentPage + 2);
                                    for ($page = $startPage; $page <= $endPage; $page++) :
                                    ?>
                                        <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= esc($makePageUrl($page)) ?>"><?= $page ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= $currentPage >= $pageCount ? 'disabled' : '' ?>">
                                        <a class="page-link" href="<?= $currentPage < $pageCount ? esc($makePageUrl($currentPage + 1)) : '#' ?>">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
