<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #d9eaf7;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>

</head>

<body>

    <h2 class="text-center">
        LAPORAN ASISTEN LAPANGAN
    </h2>

    <h3 class="text-center">
        <?= esc($sppg['sppg_name']) ?>
    </h3>

    <table>

        <tr>

            <td width="180">
                Periode
            </td>

            <td>

                <?= !empty($tanggal_awal)
                    ? date(
                        'd-m-Y',
                        strtotime(
                            $tanggal_awal
                        )
                    )
                    : '-' ?>

                s/d

                <?= !empty($tanggal_akhir)
                    ? date(
                        'd-m-Y',
                        strtotime(
                            $tanggal_akhir
                        )
                    )
                    : '-' ?>
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
                Tanggal Cetak
            </td>

            <td>
                <?= date('d-m-Y H:i') ?>
            </td>

        </tr>

    </table>

    <br>

    <h4>
        1. Ringkasan Penerima Manfaat
    </h4>

    <table>

        <thead>

            <tr>

                <th>
                    Jenjang
                </th>

                <th>
                    Jumlah
                </th>

                <th>
                    Alergi
                </th>

            </tr>

        </thead>

        <tbody>

            <?php

            $totalPM = 0;
            $totalAlergi = 0;

            ?>

            <?php if (!empty($kategori)) : ?>

                <?php foreach ($kategori as $item) : ?>

                    <?php

                    $jumlah =
                        (int) ($item['total']
                            ?? 0
                        );

                    $jumlahAlergi =
                        (int) ($item['total_alergi']
                            ?? 0
                        );

                    $totalPM +=
                        $jumlah;

                    $totalAlergi +=
                        $jumlahAlergi;

                    ?>

                    <tr>

                        <td>
                            <?= esc(
                                $item['jenjang']
                                    ?? 'Tidak diketahui'
                            ) ?>
                        </td>

                        <td class="text-right">
                            <?= number_format(
                                $jumlah
                            ) ?>
                        </td>

                        <td class="text-right">
                            <?= number_format(
                                $jumlahAlergi
                            ) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                <tr>

                    <th>
                        TOTAL
                    </th>

                    <th class="text-right">
                        <?= number_format(
                            $totalPM
                        ) ?>
                    </th>

                    <th class="text-right">
                        <?= number_format(
                            $totalAlergi
                        ) ?>
                    </th>

                </tr>

            <?php else : ?>

                <tr>

                    <td colspan="3" class="text-center">
                        Tidak ada data
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

    <br>

    <h4>
        2. Data Alergi
    </h4>

    <table>

        <thead>

            <tr>

                <th width="35%">
                    Sekolah
                </th>

                <th width="15%">
                    Kelas
                </th>

                <th width="10%">
                    Jumlah
                </th>

                <th width="40%">
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

                            <?= number_format(
                                $item['jumlah_alergi']
                            ) ?>

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

                    <td colspan="4" class="text-center">

                        Tidak ada data alergi

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

    <br>

    <h4>
        3. Kegiatan Asisten Lapangan
    </h4>

    <table>

        <thead>

            <tr>

                <th width="12%">
                    Tanggal
                </th>

                <th width="25%">
                    Kegiatan
                </th>

                <th width="20%">
                    Lokasi
                </th>

                <th width="43%">
                    Deskripsi
                </th>

            </tr>

        </thead>

        <tbody>

            <?php if (!empty($kegiatan)) : ?>

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

                        <td class="small">

                            <?= esc(
                                $item['deskripsi']
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <tr>

                    <th colspan="3">

                        Jumlah Kegiatan

                    </th>

                    <th>

                        <?= count(
                            $kegiatan
                        ) ?>

                    </th>

                </tr>

            <?php else : ?>

                <tr>

                    <td colspan="4" class="text-center">

                        Tidak ada kegiatan

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>


    <br>

    <h4>
        4. Pengeluaran Asisten Lapangan
    </h4>

    <table>

        <thead>

            <tr>

                <th width="12%">
                    Tanggal
                </th>

                <th width="15%">
                    Kategori
                </th>

                <th width="28%">
                    Uraian
                </th>

                <th width="15%">
                    Metode
                </th>

                <th width="15%">
                    Nominal
                </th>

                <th width="15%">
                    Bukti
                </th>

            </tr>

        </thead>

        <tbody>

            <?php if (!empty($pengeluaran)) : ?>

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

                        <td class="text-right">

                            Rp <?= number_format(
                                    $item['nominal'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>

                        </td>

                        <td class="text-center">

                            <?= empty($item['foto_bukti'])
                                ? 'Tidak Ada'
                                : 'Ada' ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <tr>

                    <th colspan="4">

                        TOTAL PENGELUARAN

                    </th>

                    <th colspan="2">

                        Rp <?= number_format(
                                $totalPengeluaran,
                                0,
                                ',',
                                '.'
                            ) ?>

                    </th>

                </tr>

            <?php else : ?>

                <tr>

                    <td colspan="6" class="text-center">

                        Tidak ada pengeluaran

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>

    <br><br><br>

    <table style="border:none;">

        <tr>

            <td style="
    border:none;
    width:50%;
    text-align:center;
    ">

                Asisten Lapangan

                <br><br><br><br><br>

                <b>

                    <?= session(
                        'full_name'
                    ) ?>

                </b>

            </td>

            <td style="
    border:none;
    width:50%;
    text-align:center;
    ">

                Mengetahui,

                <br>

                Kepala SPPG

                <br><br><br><br><br>

                ____________________

            </td>

        </tr>

    </table>
</body>


</html>