<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rencana Menu <?= esc(date('d-m-Y', strtotime($rencana['tanggal']))) ?></title>
    <style>
        @page { margin: 28px 30px 35px 30px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111827; }
        h1, h2, h3, p { margin: 0; }
        .header { border-bottom: 2px solid #111827; padding-bottom: 10px; margin-bottom: 14px; }
        .title { font-size: 17px; font-weight: bold; }
        .subtitle { font-size: 10px; color: #4b5563; margin-top: 4px; }
        .meta { margin-top: 10px; width: 100%; }
        .meta td { padding: 2px 0; vertical-align: top; }
        .label { width: 105px; font-weight: bold; }
        .section-title { font-size: 12px; font-weight: bold; margin: 14px 0 7px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px; vertical-align: top; }
        th { background: #eef2f7; font-weight: bold; }
        .right { text-align: right; }
        .center { text-align: center; }
        .small { font-size: 8.5px; color: #4b5563; }
        .menu-name { font-weight: bold; font-size: 10.5px; }
        .badge-normal { font-weight: bold; }
        .badge-alergi { font-weight: bold; }
        .composition { margin: 0; padding-left: 13px; }
        .composition li { margin-bottom: 2px; }
        .total-box { margin-top: 8px; border: 1px solid #94a3b8; padding: 8px; }
        .note { background: #f8fafc; border: 1px solid #cbd5e1; padding: 7px; margin-top: 7px; }
        .footer { margin-top: 20px; font-size: 8px; color: #6b7280; }
        .page-break { page-break-before: always; }
        .signature { margin-top: 28px; width: 100%; }
        .signature td { border: 0; width: 50%; text-align: center; padding-top: 25px; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">RENCANA MENU &amp; LEMBAR PRODUKSI DAPUR</div>
    <div class="subtitle">Dokumen kerja bagian masak berdasarkan rencana menu yang telah ditetapkan.</div>

    <table class="meta">
        <tr>
            <td class="label">SPPG</td>
            <td><?= esc($sppg['nama_sppg'] ?? $sppg['nama'] ?? session('id_sppg')) ?></td>
        </tr>
        <tr>
            <td class="label">Tanggal Sajian</td>
            <td><?= esc(date('d F Y', strtotime($rencana['tanggal']))) ?></td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td><?= esc(ucfirst($rencana['status'])) ?></td>
        </tr>
        <?php if (!empty($rencana['catatan'])) : ?>
            <tr>
                <td class="label">Catatan</td>
                <td><?= nl2br(esc($rencana['catatan'])) ?></td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<div class="section-title">1. REKAP MENU YANG HARUS DISIAPKAN</div>

<table>
    <thead>
        <tr>
            <th width="25">No</th>
            <th width="170">Menu</th>
            <th width="65">Jenis</th>
            <th width="65">Jumlah Porsi</th>
            <th>Komposisi</th>
            <th width="150">Catatan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($menuSummary as $i => $menu) : ?>
        <tr>
            <td class="center"><?= $i + 1 ?></td>
            <td>
                <div class="menu-name"><?= esc($menu['nama_menu']) ?></div>
                <?php if (!empty($menu['kategori'])) : ?>
                    <div class="small"><?= esc(ucwords(str_replace('_', ' ', $menu['kategori']))) ?></div>
                <?php endif; ?>
            </td>
            <td class="center">
                <?= $menu['jenis_penggunaan'] === 'alergi' ? 'Alergi' : 'Normal' ?>
            </td>
            <td class="right"><strong><?= number_format((int) $menu['total_target']) ?></strong></td>
            <td>
                <?php if (!empty($menu['komposisi'])) : ?>
                    <ul class="composition">
                    <?php foreach ($menu['komposisi'] as $item) : ?>
                        <li>
                            <strong><?= esc(ucwords(str_replace('_', ' ', $item['jenis'] ?? 'Komposisi'))) ?>:</strong>
                            <?= esc($item['nama_item'] ?? '') ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <span class="small">Komposisi belum tersedia.</span>
                <?php endif; ?>
            </td>
            <td><?= !empty($menu['catatan']) ? nl2br(esc($menu['catatan'])) : '-' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="total-box">
    <strong>Total seluruh porsi yang harus disiapkan: <?= number_format($totalProduksi) ?> porsi</strong>
</div>

<div class="section-title">2. RINCIAN PENERIMA MANFAAT</div>

<table>
    <thead>
        <tr>
            <th width="25">No</th>
            <th>Penerima / Sekolah</th>
            <th width="55">Total PM</th>
            <th width="55">Alergi</th>
            <th>Menu yang Diberikan</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($penerima as $i => $pm) : ?>
        <tr>
            <td class="center"><?= $i + 1 ?></td>
            <td>
                <strong><?= esc($pm['sekolah_nama']) ?></strong>
                <?php if (!empty($pm['catatan_alergi'])) : ?>
                    <div class="small">Alergi: <?= esc($pm['catatan_alergi']) ?></div>
                <?php endif; ?>
            </td>
            <td class="right"><?= number_format((int) ($pm['total_pm'] ?? 0)) ?></td>
            <td class="right"><?= number_format((int) ($pm['jumlah_alergi'] ?? 0)) ?></td>
            <td>
                <?php if (!empty($assignment[$pm['id']])) : ?>
                    <?php foreach ($assignment[$pm['id']] as $item) : ?>
                        <div>
                            <strong><?= esc($item['nama_menu'] ?? 'Menu') ?></strong>
                            — <?= number_format((int) ($item['total_target'] ?? 0)) ?> porsi
                            <span class="small">(<?= ($item['jenis_penggunaan'] ?? '') === 'alergi' ? 'alergi' : 'normal' ?>)</span>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="section-title">3. REKAP PRODUKSI</div>
<table>
    <thead>
        <tr>
            <th>Menu</th>
            <th width="80">Porsi Normal</th>
            <th width="80">Porsi Alergi</th>
            <th width="80">Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($menuSummary as $menu) : ?>
        <tr>
            <td><?= esc($menu['nama_menu']) ?></td>
            <td class="right"><?= number_format((int) $menu['target_normal']) ?></td>
            <td class="right"><?= number_format((int) $menu['target_alergi']) ?></td>
            <td class="right"><strong><?= number_format((int) $menu['total_target']) ?></strong></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th>Total</th>
        <th class="right"><?= number_format($totalNormal) ?></th>
        <th class="right"><?= number_format($totalAlergi) ?></th>
        <th class="right"><?= number_format($totalProduksi) ?></th>
    </tr>
    </tbody>
</table>

<?php if (!empty($rencana['catatan'])) : ?>
    <div class="note">
        <strong>Catatan rencana:</strong><br>
        <?= nl2br(esc($rencana['catatan'])) ?>
    </div>
<?php endif; ?>

<table class="signature">
    <tr>
        <td>
            Disiapkan oleh,<br><br><br>
            __________________________<br>
            Petugas Gizi
        </td>
        <td>
            Diterima oleh,<br><br><br>
            __________________________<br>
            Bagian Masak
        </td>
    </tr>
</table>

<div class="footer">
    Dicetak dari SIGITA &bull; Rencana menu ID <?= (int) $rencana['id'] ?> &bull; <?= date('d-m-Y H:i') ?>
</div>

</body>
</html>
