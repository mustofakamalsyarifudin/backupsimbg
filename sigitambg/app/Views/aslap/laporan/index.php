<?= $this->extend('layouts/affan') ?>

<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">

    <div class="container">

        <div class="d-flex align-items-center mb-3">

            <a href="<?= base_url('dashboard') ?>" class="me-2 text-dark">

                <i class="bi bi-arrow-left fs-4"></i>

            </a>

            <div>

                <h5 class="mb-0">

                    Laporan Aslap

                </h5>

                <small class="text-muted">

                    Rekap kegiatan dan pengeluaran

                </small>

            </div>

        </div>

        <!-- Filter -->

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <form method="get">

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Awal
                        </label>

                        <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Akhir
                        </label>

                        <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" class="form-control">

                    </div>

                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Tampilkan

                        </button>

                        <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)) : ?>

                            <a href="<?= base_url(
                                            'aslap/laporan/export-excel'
                                        ) .
                                            '?tanggal_awal=' .
                                            $tanggal_awal .
                                            '&tanggal_akhir=' .
                                            $tanggal_akhir ?>" class="btn btn-success">

                                <i class="bi bi-file-earmark-excel"></i>

                                Export Excel

                            </a>

                            <a href="<?= base_url('aslap/laporan/pdf') . '?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' .
                                            $tanggal_akhir ?>" class="btn btn-danger">

                                <i class="bi bi-file-earmark-pdf"></i>

                                Export PDF

                            </a>
                        <?php endif; ?>

                    </div>

                </form>

            </div>

        </div>

        <?php if (!empty($laporan)) : ?>

            <!-- Header Laporan -->

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-body">

                    <h4 class="text-center mb-1">

                        LAPORAN ASISTEN LAPANGAN

                    </h4>

                    <h5 class="text-center">

                        <?= esc($sppg['sppg_name']) ?>

                    </h5>

                    <hr>

                    <table class="table table-sm">

                        <tr>

                            <td width="150">

                                Periode

                            </td>

                            <td>

                                <?= date(
                                    'd-m-Y',
                                    strtotime($tanggal_awal)
                                ) ?>

                                s/d

                                <?= date(
                                    'd-m-Y',
                                    strtotime($tanggal_akhir)
                                ) ?>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Asisten Lapangan

                            </td>

                            <td>

                                <?= session('full_name') ?>

                            </td>

                        </tr>

                        <tr>

                            <td>

                                Dicetak

                            </td>

                            <td>

                                <?= date('d-m-Y H:i') ?>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <!-- ============================================================
     RINGKASAN PENERIMA MANFAAT PER JENJANG
============================================================ -->

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header">
                    Ringkasan Penerima Manfaat
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered mb-0">

                            <thead>

                                <tr>

                                    <th>
                                        Jenjang
                                    </th>

                                    <th width="120">
                                        Jumlah
                                    </th>

                                    <th width="120">
                                        Alergi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if (!empty($kategori)) : ?>

                                    <?php
                                    $totalPM = 0;
                                    $totalAlergi = 0;
                                    ?>

                                    <?php foreach ($kategori as $item) : ?>

                                        <?php
                                        $jumlah = (int) ($item['total'] ?? 0);
                                        $alergiJumlah = (int) ($item['total_alergi'] ?? 0);

                                        $totalPM += $jumlah;
                                        $totalAlergi += $alergiJumlah;
                                        ?>

                                        <tr>

                                            <td>
                                                <?= esc(
                                                    $item['jenjang']
                                                        ?? 'Tidak diketahui'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= number_format($jumlah) ?>
                                            </td>

                                            <td>

                                                <span class="badge bg-danger">

                                                    <?= number_format(
                                                        $alergiJumlah
                                                    ) ?>

                                                </span>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                    <tr class="fw-bold">

                                        <td>
                                            TOTAL
                                        </td>

                                        <td>
                                            <?= number_format($totalPM) ?>
                                        </td>

                                        <td>

                                            <span class="badge bg-danger">

                                                <?= number_format(
                                                    $totalAlergi
                                                ) ?>

                                            </span>

                                        </td>

                                    </tr>

                                <?php else : ?>

                                    <tr>

                                        <td colspan="3" class="text-center text-muted">

                                            Tidak ada data

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header">

                    Data Alergi Penerima Manfaat

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm mb-0">

                            <thead>

                                <tr>

                                    <th>Sekolah</th>

                                    <th>Kelas</th>

                                    <th width="80">
                                        Alergi
                                    </th>

                                    <th>
                                        Catatan
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if (!empty($alergi)) : ?>

                                    <?php foreach ($alergi as $item) : ?>

                                        <tr>

                                            <td>

                                                <?= esc(
                                                    $item['sekolah_nama']
                                                ) ?>

                                            </td>

                                            <td>

                                                <?= esc(
                                                    $item['nama_kelas']
                                                ) ?>

                                            </td>

                                            <td class="text-center">

                                                <span class="badge bg-danger">

                                                    <?= $item['jumlah_alergi'] ?>

                                                </span>

                                            </td>

                                            <td>

                                                <?= esc(
                                                    $item['catatan_alergi']
                                                ) ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else : ?>

                                    <tr>

                                        <td colspan="4" class="text-center text-muted">

                                            Tidak ada data alergi

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header">

                    Kegiatan Asisten Lapangan

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm mb-0">

                            <thead>

                                <tr>

                                    <th width="120">

                                        Tanggal

                                    </th>

                                    <th>

                                        Judul Kegiatan

                                    </th>

                                    <th>

                                        Lokasi

                                    </th>

                                    <th width="80">

                                        Foto

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($kegiatan as $item) : ?>

                                    <tr>

                                        <td>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime(
                                                    $item['tanggal']
                                                )
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $item['judul_kegiatan']
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $item['lokasi']
                                            ) ?>

                                        </td>

                                        <td class="text-center">

                                            <?= $item['total_foto'] ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header">

                    Pengeluaran Aslap

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm mb-0">

                            <thead>

                                <tr>

                                    <th width="120">

                                        Tanggal

                                    </th>

                                    <th>

                                        Kategori

                                    </th>

                                    <th>

                                        Uraian

                                    </th>

                                    <th width="120">

                                        Metode

                                    </th>

                                    <th width="150">

                                        Nominal

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($pengeluaran as $item) : ?>

                                    <tr>

                                        <td>

                                            <?= date(
                                                'd-m-Y',
                                                strtotime(
                                                    $item['tanggal']
                                                )
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $item['kategori']
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $item['uraian']
                                            ) ?>

                                        </td>

                                        <td>

                                            <?= esc(
                                                $item['metode_pembayaran']
                                            ) ?>

                                        </td>

                                        <td class="text-end">

                                            Rp <?= number_format(
                                                    $item['nominal'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                            <tfoot>

                                <tr>

                                    <th colspan="4">

                                        Total Pengeluaran

                                    </th>

                                    <th class="text-end">

                                        Rp <?= number_format(
                                                $totalPengeluaran,
                                                0,
                                                ',',
                                                '.'
                                            ) ?>

                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>



        <?php endif; ?>

    </div>

</div>

<?= $this->endSection() ?>