<?php
$isEdit = !empty($rencana);
$action = $isEdit
    ? base_url('gizi/rencana-menu/update/' . $rencana['id'])
    : base_url('gizi/rencana-menu/store');

$selectedMenus = [];

foreach ($detailMenu ?? [] as $detail) {
    $selectedMenus[(int) $detail['menu_id']] = $detail;
}

$assignment = $assignment ?? [];
?>

<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>

<div class="page-content-wrapper py-3">
    <div class="container">

        <form method="post" action="<?= esc($action) ?>" id="rencanaMenuForm">
            <?= csrf_field() ?>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">

                    <div class="d-flex align-items-center mb-3">
                        <a href="<?= base_url('gizi/rencana-menu') ?>"
                           class="btn btn-outline-secondary btn-sm me-2">
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        <div>
                            <h5 class="mb-0">
                                <?= $isEdit ? 'Edit Rencana Menu' : 'Buat Rencana Menu' ?>
                            </h5>
                            <small class="text-muted">
                                Pilih beberapa menu dan tentukan penerima manfaatnya.
                            </small>
                        </div>
                    </div>

                    <?php if (session('error')) : ?>
                        <div class="alert alert-danger">
                            <?= esc(session('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session('success')) : ?>
                        <div class="alert alert-success">
                            <?= esc(session('success')) ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Rencana Menu</label>
                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= esc(old('tanggal', $rencana['tanggal'] ?? ($tanggalAwal ?? date('Y-m-d')))) ?>"
                            required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Catatan Rencana</label>
                        <textarea
                            name="catatan"
                            class="form-control"
                            rows="2"
                            placeholder="Catatan umum rencana menu..."><?= esc(old('catatan', $rencana['catatan'] ?? '')) ?></textarea>
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Menu yang Disajikan</h6>
                            <small class="text-muted">
                                Satu tanggal dapat menggunakan beberapa menu.
                            </small>
                        </div>

                        <span class="badge bg-primary" id="jumlahMenuTerpilih">0 menu</span>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="search"
                                id="cariMenu"
                                class="form-control"
                                placeholder="Cari nama menu..."
                                autocomplete="off">
                        </div>
                        <small class="text-muted">
                            Ketik nama menu untuk mempersempit daftar. Pilih menu untuk membuka komposisi dan pengaturan penerima.
                        </small>
                    </div>

                    <div id="menuList">

                    <?php if (empty($menu)) : ?>

                        <div class="alert alert-warning mb-0">
                            Belum ada Master Menu. Buat menu terlebih dahulu.
                        </div>

                    <?php else : ?>

                        <?php foreach ($menu as $item) :
                            $menuId = (int) $item['id'];
                            $isSelected = isset($selectedMenus[$menuId]);
                            $jenis = $selectedMenus[$menuId]['jenis_penggunaan'] ?? 'normal';
                            $menuAssignments = [];

                            foreach ($assignment as $pmId => $items) {
                                if (isset($items[$menuId])) {
                                    $menuAssignments[(int) $pmId] = $items[$menuId];
                                }
                            }
                        ?>

                            <div
                                class="menu-card border rounded-4 p-3 mb-3 <?= $isSelected ? 'border-primary bg-primary-subtle' : '' ?>"
                                data-menu-card="<?= $menuId ?>"
                                data-menu-name="<?= esc(strtolower($item['nama_menu'])) ?>"
                                data-selected-order="<?= $isSelected ? array_search($menuId, array_keys($selectedMenus), true) + 1 : 0 ?>">

                                <div class="d-flex gap-3 align-items-start">

                                    <div class="pt-1">
                                        <input
                                            type="checkbox"
                                            class="form-check-input menu-check"
                                            name="menu_id[]"
                                            value="<?= $menuId ?>"
                                            data-menu-id="<?= $menuId ?>"
                                            <?= $isSelected ? 'checked' : '' ?>>
                                    </div>

                                    <div class="flex-grow-1">

                                        <div class="d-flex justify-content-between gap-2">
                                            <div>
                                                <div class="fw-bold">
                                                    <?= esc($item['nama_menu']) ?>
                                                </div>

                                                <?php if (!empty($item['kategori'])) : ?>
                                                    <span class="badge bg-light text-dark border mt-1">
                                                        <?= esc(ucwords(str_replace('_', ' ', $item['kategori']))) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="text-end">
                                                <span class="badge bg-primary target-menu-total"
                                                      data-total-for="<?= $menuId ?>">
                                                    0 PM
                                                </span>
                                            </div>
                                        </div>

                                        <?php if (!empty($item['catatan'])) : ?>
                                            <small class="text-muted d-block mt-1">
                                                <?= esc($item['catatan']) ?>
                                            </small>
                                        <?php endif; ?>

                                        <div class="menu-composition mt-3" <?= $isSelected ? '' : 'style="display:none"' ?>>
                                            <div class="small fw-bold text-primary mb-1">
                                                <i class="bi bi-list-check me-1"></i> Komposisi Menu
                                            </div>
                                            <?php $komposisiItem = $komposisiMenu[$menuId] ?? []; ?>
                                            <?php if (!empty($komposisiItem)) : ?>
                                                <div class="row g-2">
                                                    <?php foreach ($komposisiItem as $komp) : ?>
                                                        <div class="col-12 col-md-6">
                                                            <div class="border rounded-3 p-2 bg-light">
                                                                <span class="text-muted small">
                                                                    <?= esc(ucwords(str_replace('_', ' ', $komp['jenis']))) ?>
                                                                </span>
                                                                <div class="fw-semibold">
                                                                    <?= esc($komp['nama_item']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else : ?>
                                                <div class="text-muted small">Komposisi belum diisi.</div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="menu-details" <?= $isSelected ? '' : 'style="display:none"' ?>>

                                        <div class="row g-2 mt-2">

                                            <div class="col-md-4">
                                                <label class="form-label small fw-bold">
                                                    Jenis Penggunaan
                                                </label>

                                                <select
                                                    name="jenis_penggunaan[<?= $menuId ?>]"
                                                    class="form-select jenis-menu"
                                                    data-menu-id="<?= $menuId ?>"
                                                    <?= $isSelected ? '' : 'disabled' ?>>

                                                    <option value="normal" <?= $jenis === 'normal' ? 'selected' : '' ?>>
                                                        Menu Normal
                                                    </option>

                                                    <option value="alergi" <?= $jenis === 'alergi' ? 'selected' : '' ?>>
                                                        Menu Alergi
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-8">
                                                <label class="form-label small fw-bold">
                                                    Catatan Menu
                                                </label>

                                                <input
                                                    type="text"
                                                    name="catatan_menu[<?= $menuId ?>]"
                                                    class="form-control"
                                                    value="<?= esc(old(
                                                        'catatan_menu.' . $menuId,
                                                        $selectedMenus[$menuId]['catatan'] ?? ''
                                                    )) ?>"
                                                    placeholder="Contoh: tanpa kecap, tanpa pedas..."
                                                    <?= $isSelected ? '' : 'disabled' ?>>
                                            </div>

                                        </div>

                                        <div class="mt-3 menu-penerima-wrapper"
                                             data-wrapper-for="<?= $menuId ?>"
                                             <?= $isSelected ? '' : 'style="display:none"' ?>>

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <div class="fw-bold small">
                                                        Penerima Manfaat
                                                    </div>
                                                    <small class="text-muted">
                                                        Menu normal otomatis memilih PM tanpa alergi.
                                                        Menu alergi dipilih petugas.
                                                    </small>
                                                </div>

                                                <span class="badge bg-secondary menu-warning"
                                                      data-warning-for="<?= $menuId ?>">
                                                    Belum dipilih
                                                </span>
                                            </div>

                                            <div class="table-responsive border rounded-3">
                                                <table class="table table-sm align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="45">Pilih</th>
                                                            <th>Sekolah / Penerima</th>
                                                            <th width="150">Total PM</th>
                                                            <th width="150">Alergi</th>
                                                            <th width="180">Target Menu</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    <?php foreach ($penerima as $pm) :
                                                        $pmId = (int) $pm['id'];
                                                        $normalPm = (int) ($pm['normal_pm'] ?? 0);
                                                        $alergiPm = (int) ($pm['jumlah_alergi'] ?? 0);
                                                        $totalPm = (int) ($pm['total_pm'] ?? 0);

                                                        $saved = $menuAssignments[$pmId] ?? null;
                                                        $savedTarget = $saved['target'] ?? null;

                                                        $defaultChecked =
                                                            $saved !== null ||
                                                            ($isSelected && $jenis === 'normal' && $normalPm > 0);

                                                        if ($savedTarget !== null) {
                                                            $targetValue = (int) $savedTarget;
                                                        } elseif ($jenis === 'normal') {
                                                            $targetValue = $normalPm;
                                                        } else {
                                                            $targetValue = $alergiPm;
                                                        }

                                                        if ($targetValue < 0) {
                                                            $targetValue = 0;
                                                        }
                                                    ?>

                                                        <tr class="pm-row"
                                                            data-menu-id="<?= $menuId ?>"
                                                            data-pm-id="<?= $pmId ?>"
                                                            data-total="<?= $totalPm ?>"
                                                            data-normal="<?= $normalPm ?>"
                                                            data-alergi="<?= $alergiPm ?>">

                                                            <td>
                                                                <input
                                                                    type="checkbox"
                                                                    class="form-check-input pm-check"
                                                                    name="penerima[<?= $menuId ?>][]"
                                                                    value="<?= $pmId ?>"
                                                                    data-menu-id="<?= $menuId ?>"
                                                                    data-pm-id="<?= $pmId ?>"
                                                                    <?= $defaultChecked ? 'checked' : '' ?>
                                                                    <?= $isSelected ? '' : 'disabled' ?>>
                                                            </td>

                                                            <td>
                                                                <div class="fw-semibold">
                                                                    <?= esc($pm['sekolah_nama']) ?>
                                                                </div>

                                                                <?php if (!empty($pm['sub_kategori'])) : ?>
                                                                    <small class="text-muted">
                                                                        <?= esc($pm['sub_kategori']) ?>
                                                                    </small>
                                                                <?php endif; ?>

                                                                <?php if ($alergiPm > 0) : ?>
                                                                    <div>
                                                                        <small class="text-danger">
                                                                            ⚠ <?= number_format($alergiPm) ?> PM alergi
                                                                        </small>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td>
                                                                <?= number_format($totalPm) ?>
                                                            </td>

                                                            <td>
                                                                <span class="<?= $alergiPm > 0 ? 'text-danger fw-bold' : 'text-muted' ?>">
                                                                    <?= number_format($alergiPm) ?>
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    min="0"
                                                                    max="<?= $jenis === 'normal' ? $normalPm : $alergiPm ?>"
                                                                    name="target[<?= $menuId ?>][<?= $pmId ?>]"
                                                                    class="form-control form-control-sm pm-target"
                                                                    data-menu-id="<?= $menuId ?>"
                                                                    data-pm-id="<?= $pmId ?>"
                                                                    data-manual="<?= ($jenis === 'alergi' && $savedTarget !== null) ? '1' : '0' ?>"
                                                                    value="<?= $defaultChecked ? $targetValue : 0 ?>"
                                                                    <?= $defaultChecked && $jenis === 'alergi' ? '' : 'readonly' ?>
                                                                    <?= $isSelected ? '' : 'disabled' ?>>
                                                                <small class="text-muted target-help"
                                                                       data-help-for="<?= $menuId ?>-<?= $pmId ?>"></small>
                                                            </td>

                                                        </tr>

                                                        <?php if ($alergiPm > 0) : ?>
                                                            <tr class="pm-note-row" data-menu-id="<?= $menuId ?>" data-pm-id="<?= $pmId ?>">
                                                                <td></td>
                                                                <td colspan="4">
                                                                    <small class="text-muted">
                                                                        <strong>Catatan alergi:</strong>
                                                                        <?= esc(
                                                                            !empty($pm['catatan_alergi'])
                                                                                ? $pm['catatan_alergi']
                                                                                : 'Catatan alergi belum diisi.'
                                                                        ) ?>
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        </div><!-- .menu-details -->

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                    </div><!-- #menuList -->

                    <div id="menuTidakDitemukan" class="alert alert-light border d-none mb-0">
                        Menu tidak ditemukan. Coba kata kunci lain.
                    </div>

                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">

                    <h6 class="mb-3">Ringkasan Pembagian Menu</h6>

                    <div id="coverageSummary"></div>

                    <div class="alert alert-info mb-0 mt-3">
                        <strong>Catatan:</strong>
                        data penerima manfaat tidak diubah.
                        Sistem hanya membuat penetapan menu untuk rencana tanggal ini.
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2 mb-4">

                <a href="<?= base_url('gizi/rencana-menu') ?>"
                   class="btn btn-outline-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    <?= $isEdit ? 'Simpan Perubahan' : 'Simpan sebagai Draft' ?>
                </button>

            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const pmData = <?= json_encode(
        array_values(
            array_map(
                static function ($pm) {
                    return [
                        'id' => (int) $pm['id'],
                        'name' => $pm['sekolah_nama'],
                        'total' => (int) ($pm['total_pm'] ?? 0),
                        'normal' => (int) ($pm['normal_pm'] ?? 0),
                        'alergi' => (int) ($pm['jumlah_alergi'] ?? 0),
                    ];
                },
                $penerima
            )
        ),
        JSON_UNESCAPED_UNICODE
    ) ?>;

    const cards = Array.from(document.querySelectorAll('.menu-card'));
    const menuList = document.getElementById('menuList');
    const cariMenu = document.getElementById('cariMenu');
    const menuTidakDitemukan = document.getElementById('menuTidakDitemukan');
    let selectionSequence = Math.max(0, ...cards.map(c => Number(c.dataset.selectedOrder || 0)));

    function getCard(menuId) {
        return document.querySelector('.menu-card[data-menu-card="' + menuId + '"]');
    }

    function getJenis(menuId) {
        const select = document.querySelector('.jenis-menu[data-menu-id="' + menuId + '"]');
        return select ? select.value : 'normal';
    }

    function getSelectedCardsByJenis(jenis) {
        return Array.from(menuList.querySelectorAll('.menu-card'))
            .filter(card => {
                const check = card.querySelector('.menu-check');
                return check && check.checked && getJenis(card.dataset.menuCard) === jenis;
            })
            .sort((a, b) => Number(a.dataset.selectedOrder || 999999) - Number(b.dataset.selectedOrder || 999999));
    }

    function clearMenuRecipients(menuId) {
        const card = getCard(menuId);
        if (!card) return;

        card.querySelectorAll('.pm-check').forEach(function (check) {
            check.checked = false;
        });

        card.querySelectorAll('.pm-target').forEach(function (target) {
            target.value = 0;
            target.dataset.manual = '0';
        });
    }

    function refreshMenu(menuId, initialLoad = false) {
        const card = getCard(menuId);
        if (!card) return;

        const menuCheck = card.querySelector('.menu-check');
        const selected = menuCheck.checked;
        const select = card.querySelector('.jenis-menu');
        const wrapper = card.querySelector('.menu-penerima-wrapper');
        const details = card.querySelector('.menu-details');
        const composition = card.querySelector('.menu-composition');

        if (select) select.disabled = !selected;
        card.querySelectorAll('input[name^="catatan_menu"]').forEach(el => el.disabled = !selected);
        card.querySelectorAll('.pm-check, .pm-target').forEach(el => el.disabled = !selected);

        if (wrapper) wrapper.style.display = selected ? '' : 'none';
        if (details) details.style.display = selected ? '' : 'none';
        if (composition) composition.style.display = selected ? '' : 'none';

        if (!selected) {
            card.classList.remove('border-primary', 'bg-primary-subtle');
            card.classList.add('border');
            updateMenuTotal(menuId);
            return;
        }

        card.classList.add('border-primary', 'bg-primary-subtle');

        // Pada saat halaman pertama kali dibuka, data alergi yang sudah tersimpan
        // harus dipertahankan. Saat petugas benar-benar memilih/mengubah jenis,
        // data lama harus di-reset agar tidak membawa target menu sebelumnya.
        applyMenuLogic(menuId, !initialLoad);
    }

    function applyMenuLogic(menuId, resetBeforeApply = false) {
        const jenis = getJenis(menuId);
        const card = getCard(menuId);
        if (!card) return;

        if (resetBeforeApply) {
            clearMenuRecipients(menuId);
        }

        card.querySelectorAll('.pm-row[data-menu-id="' + menuId + '"]').forEach(function (row) {
            const check = row.querySelector('.pm-check');
            const target = row.querySelector('.pm-target');
            const normal = Number(row.dataset.normal || 0);
            const alergi = Number(row.dataset.alergi || 0);

            if (jenis === 'normal') {
                check.checked = normal > 0;
                target.value = normal > 0 ? normal : 0;
                target.max = normal;
                target.readOnly = true;
                target.dataset.manual = '0';

                const help = card.querySelector(
                    '.target-help[data-help-for="' + menuId + '-' + row.dataset.pmId + '"]'
                );
                if (help) {
                    help.textContent = normal > 0
                        ? 'Otomatis: ' + normal.toLocaleString('id-ID') + ' PM non-alergi'
                        : 'Tidak ada PM non-alergi';
                }
            } else {
                // Menu alergi selalu dimulai kosong ketika jenis diubah/dipilih.
                // Pada edit awal, nilai tersimpan tidak disentuh.
                if (resetBeforeApply) {
                    check.checked = false;
                    target.value = 0;
                    target.dataset.manual = '0';
                }
                target.max = alergi;
                target.readOnly = false;
            }
        });

        if (jenis === 'alergi') {
            recalculateAllergyTargets();
        }

        updateMenuTotal(menuId);
        updateAllCoverage();
    }

    function sortMenuCards() {
        const allCards = Array.from(menuList.querySelectorAll('.menu-card'));

        allCards.sort(function (a, b) {
            const aSelected = a.querySelector('.menu-check').checked;
            const bSelected = b.querySelector('.menu-check').checked;

            if (aSelected !== bSelected) return aSelected ? -1 : 1;

            if (aSelected && bSelected) {
                const aJenis = getJenis(a.dataset.menuCard);
                const bJenis = getJenis(b.dataset.menuCard);

                // Menu normal selalu di atas menu alergi.
                if (aJenis !== bJenis) return aJenis === 'normal' ? -1 : 1;

                // Dalam kelompok yang sama, ikuti urutan petugas memilih.
                return Number(a.dataset.selectedOrder || 999999) - Number(b.dataset.selectedOrder || 999999);
            }

            // Menu yang belum dipilih tetap rapi berdasarkan nama.
            return a.dataset.menuName.localeCompare(b.dataset.menuName, 'id');
        });

        allCards.forEach(card => menuList.appendChild(card));
    }

    function filterMenus() {
        const keyword = (cariMenu.value || '').trim().toLowerCase();
        let visible = 0;

        menuList.querySelectorAll('.menu-card').forEach(function (card) {
            const match = !keyword || card.dataset.menuName.includes(keyword);
            card.classList.toggle('d-none', !match);
            if (match) visible++;
        });

        menuTidakDitemukan.classList.toggle('d-none', visible > 0);
    }

    /**
     * Pembagian PM alergi bersifat berurutan berdasarkan urutan menu alergi
     * dipilih petugas.
     *
     * Contoh alergi = 6:
     *   Alergi 1 target 2 -> sisa 4
     *   Alergi 2 maksimal 4
     *   Alergi 2 target 3 -> sisa 1
     *   Alergi 3 maksimal 1
     *
     * Setiap target tetap dapat diisi petugas, tetapi tidak boleh melebihi
     * sisa setelah menu alergi sebelumnya.
     */
    function recalculateAllergyTargets() {
        const allergyCards = getSelectedCardsByJenis('alergi');

        pmData.forEach(function (pm) {
            let remaining = Number(pm.alergi || 0);

            allergyCards.forEach(function (card) {
                const menuId = card.dataset.menuCard;
                const row = card.querySelector('.pm-row[data-pm-id="' + pm.id + '"]');
                if (!row) return;

                const check = row.querySelector('.pm-check');
                const target = row.querySelector('.pm-target');
                if (!check || !target) return;

                // Batas menu saat ini harus memakai sisa SEBELUM alokasi.
                // Jika max memakai sisa SETELAH alokasi, target=6 akan
                // berubah menjadi value=6 dengan max=0 sehingga browser
                // menganggap form invalid dan submit tidak berjalan.
                const availableBefore = remaining;
                const current = Math.max(0, Number(target.value || 0));
                const allowed = check.checked ? Math.min(current, availableBefore) : 0;

                target.max = availableBefore;

                if (check.checked) {
                    target.value = allowed;
                    remaining -= allowed;
                } else {
                    target.value = 0;
                }

                const help = card.querySelector(
                    '.target-help[data-help-for="' + menuId + '-' + pm.id + '"]'
                );
                if (help) {
                    help.textContent = remaining > 0
                        ? 'Sisa alergi tersedia: ' + remaining.toLocaleString('id-ID') + ' PM'
                        : 'Sisa alergi: 0 PM';
                }
            });
        });

        allergyCards.forEach(card => updateMenuTotal(card.dataset.menuCard));
    }

    function updateMenuTotal(menuId) {
        let total = 0;

        const card = getCard(menuId);
        if (!card) return;

        card.querySelectorAll('.pm-row').forEach(function (row) {
            const check = row.querySelector('.pm-check');
            const target = row.querySelector('.pm-target');

            if (check && check.checked) {
                total += Number(target.value || 0);
            }
        });

        const badge = document.querySelector('.target-menu-total[data-total-for="' + menuId + '"]');
        if (badge) badge.textContent = total.toLocaleString('id-ID') + ' PM';

        const warning = document.querySelector('.menu-warning[data-warning-for="' + menuId + '"]');
        if (!warning) return;

        const jenis = getJenis(menuId);
        let selected = 0;

        card.querySelectorAll('.pm-check:checked').forEach(function () {
            selected++;
        });

        if (selected === 0) {
            warning.className = 'badge bg-secondary menu-warning';
            warning.textContent = 'Belum dipilih';
        } else if (jenis === 'alergi') {
            warning.className = 'badge bg-warning text-dark menu-warning';
            warning.textContent = selected + ' penerima dipilih';
        } else {
            warning.className = 'badge bg-success menu-warning';
            warning.textContent = selected + ' penerima otomatis';
        }
    }

    function updateAllCoverage() {
        const assigned = {};
        let totalPm = 0;

        pmData.forEach(function (pm) {
            totalPm += pm.total;
            assigned[pm.id] = 0;
        });

        menuList.querySelectorAll('.menu-card').forEach(function (card) {
            const menuCheck = card.querySelector('.menu-check');
            if (!menuCheck || !menuCheck.checked) return;

            card.querySelectorAll('.pm-row').forEach(function (row) {
                const check = row.querySelector('.pm-check');
                const target = row.querySelector('.pm-target');

                if (check && check.checked) {
                    const pmId = Number(row.dataset.pmId);
                    assigned[pmId] = (assigned[pmId] || 0) + Number(target.value || 0);
                }
            });
        });

        let belum = 0;
        let lebih = 0;
        let rows = '';

        pmData.forEach(function (pm) {
            const jumlah = assigned[pm.id] || 0;

            if (jumlah < pm.total) belum += pm.total - jumlah;
            if (jumlah > pm.total) lebih += jumlah - pm.total;

            let status = '';
            if (jumlah === pm.total) {
                status = '<span class="badge bg-success">Lengkap</span>';
            } else if (jumlah < pm.total) {
                status = '<span class="badge bg-warning text-dark">Kurang ' +
                    (pm.total - jumlah).toLocaleString('id-ID') + ' PM</span>';
            } else {
                status = '<span class="badge bg-danger">Lebih ' +
                    (jumlah - pm.total).toLocaleString('id-ID') + ' PM</span>';
            }

            rows += '<tr>' +
                '<td>' + escapeHtml(pm.name) + '</td>' +
                '<td>' + pm.total.toLocaleString('id-ID') + '</td>' +
                '<td>' + jumlah.toLocaleString('id-ID') + '</td>' +
                '<td>' + status + '</td>' +
                '</tr>';
        });

        let alertClass = 'alert-success';
        let message = 'Seluruh penerima manfaat sudah mendapatkan menu.';

        if (belum > 0) {
            alertClass = 'alert-warning';
            message = 'Masih ada ' + belum.toLocaleString('id-ID') + ' PM yang belum mendapatkan menu.';
        }

        if (lebih > 0) {
            alertClass = 'alert-danger';
            message = 'Terdapat ' + lebih.toLocaleString('id-ID') + ' PM yang terhitung ganda.';
        }

        document.getElementById('coverageSummary').innerHTML =
            '<div class="alert ' + alertClass + '"><strong>' + message + '</strong></div>' +
            '<div class="table-responsive"><table class="table table-sm align-middle">' +
            '<thead class="table-light"><tr>' +
            '<th>Penerima</th><th>Total PM</th><th>Sudah Mendapat Menu</th><th>Status</th>' +
            '</tr></thead><tbody>' + rows + '</tbody></table></div>';
    }

    function escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    document.querySelectorAll('.menu-check').forEach(function (check) {
        check.addEventListener('change', function () {
            const card = this.closest('.menu-card');

            if (this.checked) {
                selectionSequence++;
                card.dataset.selectedOrder = selectionSequence;
                refreshMenu(this.dataset.menuId, false);
            } else {
                card.dataset.selectedOrder = 0;
                refreshMenu(this.dataset.menuId, false);
            }

            sortMenuCards();
            recalculateAllergyTargets();
            filterMenus();
            updateMenuCounter();
            updateAllCoverage();
        });
    });

    document.querySelectorAll('.jenis-menu').forEach(function (select) {
        select.addEventListener('change', function () {
            const card = this.closest('.menu-card');
            if (card && !Number(card.dataset.selectedOrder || 0)) {
                selectionSequence++;
                card.dataset.selectedOrder = selectionSequence;
            }

            // Jenis berubah = semua pilihan/target dari jenis sebelumnya dibuang.
            applyMenuLogic(this.dataset.menuId, true);
            sortMenuCards();
            recalculateAllergyTargets();
            updateMenuTotal(this.dataset.menuId);
            updateAllCoverage();
        });
    });

    document.querySelectorAll('.pm-check').forEach(function (check) {
        check.addEventListener('change', function () {
            const row = this.closest('.pm-row');
            const target = row.querySelector('.pm-target');
            const jenis = getJenis(this.dataset.menuId);

            if (!this.checked) {
                target.value = 0;
                target.dataset.manual = '0';
            } else if (Number(target.value || 0) === 0) {
                if (jenis === 'normal') {
                    target.value = Number(row.dataset.normal || 0);
                } else {
                    // Untuk alergi, checkbox hanya memilih PM.
                    // Target tetap diisi petugas dan dibatasi oleh sisa alergi.
                    target.value = 0;
                }
            }

            target.readOnly = jenis === 'normal';

            if (jenis === 'alergi') {
                target.dataset.manual = '1';
                recalculateAllergyTargets();
            }

            updateMenuTotal(this.dataset.menuId);
            updateAllCoverage();
        });
    });

    document.querySelectorAll('.pm-target').forEach(function (input) {
        input.addEventListener('input', function () {
            const row = this.closest('.pm-row');
            const jenis = getJenis(this.dataset.menuId);
            const max = jenis === 'normal'
                ? Number(row.dataset.normal || 0)
                : Number(this.max || row.dataset.alergi || 0);

            let value = Math.max(0, Number(this.value || 0));
            if (value > max) value = max;
            this.value = value;

            const check = row.querySelector('.pm-check');

            if (jenis === 'alergi') {
                this.dataset.manual = '1';
                if (value > 0) check.checked = true;
                if (value === 0) check.checked = false;
                recalculateAllergyTargets();
            } else {
                check.checked = value > 0;
            }

            updateMenuTotal(this.dataset.menuId);
            updateAllCoverage();
        });
    });

    if (cariMenu) cariMenu.addEventListener('input', filterMenus);

    function updateMenuCounter() {
        const count = document.querySelectorAll('.menu-check:checked').length;
        document.getElementById('jumlahMenuTerpilih').textContent = count.toLocaleString('id-ID') + ' menu';
    }

    // Submit Draft: pastikan form benar-benar dikirim dan pengguna mendapat
    // indikator visual bahwa proses penyimpanan sedang berjalan.
    const rencanaMenuForm = document.getElementById('rencanaMenuForm');
    const btnSimpan = rencanaMenuForm ? rencanaMenuForm.querySelector('button[type=\"submit\"]') : null;

    if (rencanaMenuForm) {
        rencanaMenuForm.addEventListener('submit', function () {
            // Gunakan native validation. Jika ada field invalid, tampilkan
            // pesan browser agar penyebab submit tertahan tidak tersembunyi.
            if (!rencanaMenuForm.checkValidity()) {
                rencanaMenuForm.reportValidity();
                return;
            }

            if (btnSimpan) {
                btnSimpan.disabled = true;
                btnSimpan.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan Draft...';
            }
        });
    }

    // Inisialisasi tanpa menghapus data alergi yang sudah tersimpan pada Edit.
    document.querySelectorAll('.menu-check').forEach(function (check) {
        refreshMenu(check.dataset.menuId, true);
    });

    sortMenuCards();
    filterMenus();
    recalculateAllergyTargets();
    updateMenuCounter();
    updateAllCoverage();

});
</script>

<?= $this->endSection() ?>
