<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <div class="d-flex align-items-center mb-3">
            <a href="<?= base_url('gizi/rencana-menu') ?>"
               class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>
                <h5 class="mb-0">Detail Rencana Menu</h5>
                <small class="text-muted">
                    <?= date('d-m-Y', strtotime($rencana['tanggal'])) ?>
                </small>
            </div>
        </div>

        <?php if (session('error')) : ?>
            <div class="alert alert-danger"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <?php if (session('success')) : ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1">
                            Rencana Menu
                        </h5>

                        <div class="text-muted">
                            <?= date('d F Y', strtotime($rencana['tanggal'])) ?>
                        </div>
                    </div>

                    <?php if ($rencana['status'] === 'ditetapkan') : ?>
                        <span class="badge bg-success">
                            Ditetapkan
                        </span>
                    <?php elseif ($rencana['status'] === 'dibatalkan') : ?>
                        <span class="badge bg-danger">
                            Dibatalkan
                        </span>
                    <?php else : ?>
                        <span class="badge bg-warning text-dark">
                            Draft
                        </span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($rencana['catatan'])) : ?>
                    <div class="alert alert-info mt-3 mb-0">
                        <?= nl2br(esc($rencana['catatan'])) ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if ($rencana['status'] === 'dibatalkan') : ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <div class="fw-bold mb-1">Rencana ini dibatalkan</div>
                <?php if (!empty($rencana['alasan_pembatalan'])) : ?>
                    <div><strong>Alasan:</strong> <?= nl2br(esc($rencana['alasan_pembatalan'])) ?></div>
                <?php endif; ?>
                <?php if (!empty($rencana['dibatalkan_at'])) : ?>
                    <small class="d-block mt-1">Dibatalkan pada <?= date('d-m-Y H:i', strtotime($rencana['dibatalkan_at'])) ?></small>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">

                <h6 class="mb-3">Menu yang Disajikan</h6>

                <?php foreach ($detailMenu as $menu) : ?>

                    <div class="border rounded-3 p-3 mb-2">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">
                                    <?= esc($menu['nama_menu']) ?>
                                </div>

                                <?php if (!empty($menu['kategori'])) : ?>
                                    <small class="text-muted">
                                        <?= esc(ucwords(str_replace('_', ' ', $menu['kategori']))) ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <?php if ($menu['jenis_penggunaan'] === 'alergi') : ?>
                                <span class="badge bg-danger">
                                    Menu Alergi
                                </span>
                            <?php else : ?>
                                <span class="badge bg-success">
                                    Menu Normal
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($menu['catatan'])) : ?>
                            <small class="text-muted d-block mt-2">
                                <?= esc($menu['catatan']) ?>
                            </small>
                        <?php endif; ?>

                        <?php $komposisi = $komposisiMenu[(int) ($menu['menu_id'] ?? 0)] ?? []; ?>
                        <?php if (!empty($komposisi)) : ?>
                            <div class="mt-3 pt-3 border-top">
                                <div class="fw-semibold text-primary mb-2">
                                    <i class="bi bi-list-check me-1"></i> Komposisi Menu
                                </div>

                                <div class="row g-2">
                                    <?php foreach ($komposisi as $item) : ?>
                                        <div class="col-12 col-md-6">
                                            <div class="bg-light rounded-3 px-3 py-2 h-100">
                                                <div class="small text-muted">
                                                    <?= esc(ucwords(str_replace('_', ' ', $item['jenis'] ?? 'Komposisi'))) ?>
                                                </div>
                                                <div class="fw-semibold">
                                                    <?= esc($item['nama_item'] ?? '') ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="mt-3 pt-3 border-top">
                                <div class="small text-muted">
                                    Komposisi belum tersedia.
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">

                <h6 class="mb-3">Status Penerima Manfaat</h6>

                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Penerima</th>
                                <th>Total PM</th>
                                <th>Sudah Mendapat Menu</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($penerima as $pm) :

                            $jumlah = 0;

                            foreach ($assignment[$pm['id']] ?? [] as $item) {
                                $jumlah += (int) ($item['total_target'] ?? 0);
                            }

                            $total = (int) ($pm['total_pm'] ?? 0);
                        ?>

                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($pm['sekolah_nama']) ?>
                                    </div>

                                    <?php if (!empty($pm['catatan_alergi'])) : ?>
                                        <small class="text-danger">
                                            ⚠ <?= esc($pm['catatan_alergi']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>

                                <td><?= number_format($total) ?></td>

                                <td><?= number_format($jumlah) ?></td>

                                <td>
                                    <?php if ($jumlah === $total) : ?>
                                        <span class="badge bg-success">
                                            Lengkap
                                        </span>
                                    <?php elseif ($jumlah < $total) : ?>
                                        <span class="badge bg-warning text-dark">
                                            Kurang <?= number_format($total - $jumlah) ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">
                                            Lebih <?= number_format($jumlah - $total) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <?php if (!empty($assignment[$pm['id']])) : ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="small text-muted">
                                            <strong>Menu:</strong>

                                            <?php foreach ($assignment[$pm['id']] as $item) : ?>
                                                <span class="badge bg-light text-dark border me-1">
                                                    <?= esc($item['nama_menu'] ?? 'Menu') ?>
                                                    —
                                                    <?= number_format((int) ($item['total_target'] ?? 0)) ?> PM
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                $totalPm = (int) ($coverage['total'] ?? 0);
                $assigned = (int) ($coverage['assigned'] ?? 0);
                $belum = (int) ($coverage['belum'] ?? 0);
                $lebih = (int) ($coverage['lebih'] ?? 0);
                ?>

                <?php if ($belum > 0) : ?>
                    <div class="alert alert-warning mb-0">
                        ⚠️ Masih ada
                        <strong><?= number_format($belum) ?></strong>
                        PM yang belum mendapatkan menu.
                    </div>
                <?php elseif ($lebih > 0) : ?>
                    <div class="alert alert-danger mb-0">
                        ⚠️ Terdapat
                        <strong><?= number_format($lebih) ?></strong>
                        PM yang terhitung ganda.
                    </div>
                <?php else : ?>
                    <div class="alert alert-success mb-0">
                        ✅ Seluruh
                        <strong><?= number_format($totalPm) ?></strong>
                        PM sudah mendapatkan menu.
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if ($rencana['status'] === 'draft') : ?>

            <div class="d-flex flex-wrap gap-2 mb-4">

                <a href="<?= base_url('gizi/rencana-menu/edit/' . $rencana['id']) ?>"
                   class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </a>

                <form method="post" action="<?= base_url('gizi/rencana-menu/tetapkan/' . $rencana['id']) ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success"
                            onclick="return confirm('Tetapkan rencana menu ini? Setelah ditetapkan, rencana tidak dapat diedit.');">
                        <i class="bi bi-check-circle me-1"></i>
                        Tetapkan
                    </button>
                </form>

                <a href="<?= base_url('gizi/rencana-menu/delete/' . $rencana['id']) ?>"
                   class="btn btn-outline-danger"
                   onclick="return confirm('Hapus rencana menu draft ini?');">
                    <i class="bi bi-trash me-1"></i>
                    Hapus
                </a>

            </div>

        <?php elseif ($rencana['status'] === 'ditetapkan') : ?>

            <div class="card border-0 border-danger shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-2">
                        <div class="text-danger fs-4"><i class="bi bi-lock-fill"></i></div>
                        <div>
                            <div class="fw-bold">Rencana menu terkunci</div>
                            <div class="small text-muted">
                                Rencana yang sudah ditetapkan tidak dapat diedit. Jika ada perubahan menu,
                                batalkan rencana ini lalu buat rencana pengganti.
                            </div>
                        </div>
                    </div>

                    <hr>

                    <form method="post" action="<?= base_url('gizi/rencana-menu/batalkan/' . $rencana['id']) ?>"
                          onsubmit="return confirm('Batalkan rencana menu ini? Data lama tidak akan dihapus dan tetap menjadi riwayat.');">
                        <?= csrf_field() ?>

                        <label class="form-label fw-bold">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea name="alasan_pembatalan" class="form-control mb-2" rows="3"
                                  placeholder="Contoh: bahan utama tidak tersedia sehingga menu perlu diganti." required></textarea>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-1"></i>
                            Batalkan Rencana
                        </button>
                    </form>
                </div>
            </div>

        <?php elseif ($rencana['status'] === 'dibatalkan') : ?>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="<?= base_url('gizi/rencana-menu/create?tanggal=' . urlencode($rencana['tanggal'])) ?>"
                   class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Buat Rencana Pengganti
                </a>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
