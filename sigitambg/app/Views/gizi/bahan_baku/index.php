<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>
<style>
.badge-status { font-weight: 600; }
.badge-status-waiting-finance { background:#f59e0b!important; color:#fff!important; }
.badge-status-rejected { background:#ef4444!important; color:#fff!important; }
.badge-status-waiting-kepala { background:#7c3aed!important; color:#fff!important; }
.badge-status-waiting-koperasi { background:#0891b2!important; color:#fff!important; }
.badge-status-procurement { background:#2563eb!important; color:#fff!important; }
.badge-status-completed { background:#16a34a!important; color:#fff!important; }
.badge-status-draft { background:#94a3b8!important; color:#fff!important; }
</style>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h5 class="mb-0">
                    Bahan Baku
                </h5>

                <small class="text-muted">
                    Daftar transaksi pembelian bahan baku
                </small>

            </div>
            <div class="d-flex gap-2">

                <a href="<?= base_url('gizi/bahan-baku/create') ?>" class="btn btn-primary btn-sm">

                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Transaksi

                </a>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <table class="table" id="tableBahanBaku">

                    <thead>

                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th width="80">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($transaksi as $row) : ?>

                            <tr>

                                <td>

                                    <?= date(
                                        'd/m/Y',
                                        strtotime($row['tanggal'])
                                    ) ?>

                                </td>

                                <td>

                                    <?php

                                    $status = (string) ($row['status'] ?? 'draft');
                                    $badge = match ($status) {
                                        'draft' => 'badge-status badge-status-draft',
                                        'waiting_finance', 'waiting_approval' => 'badge-status badge-status-waiting-finance',
                                        'rejected_finance', 'rejected_kepala', 'rejected' => 'badge-status badge-status-rejected',
                                        'waiting_kepala' => 'badge-status badge-status-waiting-kepala',
                                        'waiting_koperasi' => 'badge-status badge-status-waiting-koperasi',
                                        'procurement' => 'badge-status badge-status-procurement',
                                        'completed' => 'badge-status badge-status-completed',
                                        'approved' => 'badge-status badge-status-completed',
                                        default => 'badge-status badge-status-draft'
                                    };

                                    ?>

                                    <span class="badge bg-<?= $badge ?>">
                                        <?= match ($status) {
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
                                        } ?>
                                    </span>

                                </td>

                                <td>

                                    Rp <?= number_format(
                                            $row['grand_total'],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>

                                </td>

                                <td>

                                    <div class="d-flex gap-1 align-items-center">

                                        <a href="<?= base_url('gizi/bahan-baku/detail/' . $row['id']) ?>"
                                           class="btn btn-sm btn-primary"
                                           title="Lihat transaksi">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <?php if ($status === 'draft') : ?>
                                            <form action="<?= base_url('gizi/bahan-baku/delete/' . $row['id']) ?>"
                                                  method="post"
                                                  class="d-inline"
                                                  onsubmit="return confirmDeleteBahanBaku(this);">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus Draft">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?= base_url('assets/js/vanilla-dataTables.min.js') ?>"></script>

<script>
    function confirmDeleteBahanBaku(form) {
        return confirm(
            'Hapus transaksi Draft ini?\n\n' +
            'Seluruh detail bahan di dalam transaksi juga akan dihapus.\n' +
            'Data yang sudah dihapus tidak dapat dikembalikan.'
        );
    }

    document.addEventListener("DOMContentLoaded", function() {

        const table = document.querySelector("#tableBahanBaku");

        if (table) {

            new DataTable(table, {

                searchable: true,

                fixedHeight: true,

                perPage: 10, perPageSelect: [5, 10, 25, 50, 100]

            });

        }

    });
</script>

<?= $this->endSection() ?>