<?php
$isEdit = !empty($row['id']);
$oldKodeSupplier = trim((string) old('kode_supplier'));
if ($oldKodeSupplier === '') {
    $oldKodeSupplier = (string) ($row['kode_supplier'] ?? ($kodeSupplier ?? ''));
}
?>
<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<div class="page-content-wrapper py-3">
    <div class="container" style="max-width: 1180px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1 fw-bold"><?= $isEdit ? 'Edit Supplier' : 'Tambah Supplier' ?></h5>
                <small class="text-muted">Data supplier berlaku pada Koperasi yang sedang login.</small>
            </div>
            <a href="<?= base_url('koperasi/supplier') ?>" class="btn btn-light border rounded-3">← Kembali</a>
        </div>

        <?php if ($m = session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-4"><?= esc($m) ?></div>
        <?php endif; ?>
        <?php if ($m = session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-4"><?= esc($m) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" action="<?= base_url($isEdit ? 'koperasi/supplier/update/' . $row['id'] : 'koperasi/supplier/store') ?>">
            <?= csrf_field() ?>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Identitas Supplier</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kode Supplier *</label>
                            <input name="kode_supplier" class="form-control bg-light" maxlength="40" value="<?= esc($oldKodeSupplier) ?>" readonly required>
                            <div class="form-text"><i class="bi bi-magic me-1"></i>Kode dibuat otomatis berdasarkan Kode Koperasi.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Nama Supplier *</label>
                            <input name="nama_supplier" class="form-control" maxlength="200" value="<?= esc(old('nama_supplier', $row['nama_supplier'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama PIC *</label>
                            <input name="nama_pic" class="form-control" maxlength="150" value="<?= esc(old('nama_pic', $row['nama_pic'] ?? '')) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. HP/WhatsApp</label>
                            <input name="no_hp" class="form-control" maxlength="50" value="<?= esc(old('no_hp', $row['no_hp'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= esc(old('email', $row['email'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">NPWP/NIK</label>
                            <input name="npwp_nik" class="form-control" maxlength="50" value="<?= esc(old('npwp_nik', $row['npwp_nik'] ?? '')) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"><?= esc(old('alamat', $row['alamat'] ?? '')) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kabupaten/Kota</label>
                            <input name="kabupaten_kota" class="form-control" value="<?= esc(old('kabupaten_kota', $row['kabupaten_kota'] ?? '')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi</label>
                            <input name="provinsi" class="form-control" value="<?= esc(old('provinsi', $row['provinsi'] ?? '')) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Bahan yang Disediakan Supplier</h6>
                    <small class="text-muted d-block mb-3">Pilih bahan yang memang dapat disediakan supplier kepada Koperasi. Harga di sini adalah <strong>harga beli awal dari supplier</strong> dan dapat diperbarui beserta histori pada Detail Supplier.</small>

                    <?php if (empty($assigned)): ?>
                        <div class="alert alert-warning mb-0 rounded-3">Koperasi belum memiliki SPPG yang terhubung. Hubungkan SPPG terlebih dahulu sebelum memilih bahan supplier.</div>
                    <?php else: ?>
                        <div id="supplierBahanRows"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-3" id="btnTambahBahanSupplier">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Bahan
                        </button>
                        <div class="form-text mt-2">Satu supplier dapat menyediakan banyak bahan dan dapat melayani beberapa SPPG.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">MOU / Perjanjian Kerja Sama</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mou_mulai" id="tanggalMouMulai" class="form-control" value="<?= esc(old('tanggal_mou_mulai', $row['tanggal_mou_mulai'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_mou_akhir" id="tanggalMouAkhir" class="form-control" value="<?= esc(old('tanggal_mou_akhir', $row['tanggal_mou_akhir'] ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status Supplier</label>
                            <select name="status" class="form-select">
                                <option value="aktif" <?= old('status', $row['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status', $row['status'] ?? 'aktif') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0 py-2 rounded-3 small">
                        Jika mengunggah dokumen MOU/Surat Kerja Sama, tanggal mulai dan tanggal berakhir MOU wajib diisi. Sistem memberikan warning 30 hari sebelum jatuh tempo.
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <div>
                            <h6 class="fw-bold mb-1">Berkas / Dokumen Supplier</h6>
                            <small class="text-muted">Berkas dapat diunggah langsung saat membuat atau mengedit supplier. Maksimal 5 MB per file.</small>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-3" id="btnTambahBerkas">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Berkas
                        </button>
                    </div>
                    <div id="documentRows"></div>
                    <div id="emptyDocumentState" class="border rounded-3 p-3 text-center text-muted small">
                        Belum ada berkas yang dipilih. Klik <strong>Tambah Berkas</strong> untuk mengunggah NIB, NPWP, MOU, KTP PIC, sertifikat, atau dokumen lainnya.
                    </div>
                    <div class="form-text mt-2">Format yang diizinkan: <strong>PDF, JPG, JPEG, PNG</strong>. Untuk dokumen MOU, pilih jenis <strong>Surat Kerja Sama / MOU</strong>.</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3"><?= esc(old('catatan', $row['catatan'] ?? '')) ?></textarea>
                </div>
            </div>

            <?php if ($isEdit): ?>
                <div class="alert alert-info rounded-4 small">
                    Berkas dan bahan yang sudah tersimpan tetap aman. Baris bahan baru dari form ini akan ditambahkan ke supplier. Untuk mengubah harga bahan yang sudah terhubung, gunakan halaman Detail Supplier agar histori harga tetap tercatat.
                </div>
            <?php endif; ?>

            <div class="d-flex gap-2 mb-4">
                <button class="btn btn-primary"><i class="bi bi-save me-1"></i><?= $isEdit ? 'Simpan Perubahan' : 'Simpan Supplier' ?></button>
                <a href="<?= base_url('koperasi/supplier') ?>" class="btn btn-light border">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.getElementById('documentRows');
    const emptyState = document.getElementById('emptyDocumentState');
    const addButton = document.getElementById('btnTambahBerkas');
    const bahanRows = document.getElementById('supplierBahanRows');
    const addBahanButton = document.getElementById('btnTambahBahanSupplier');

    const types = <?= json_encode(array_map(static function ($t) {
        return ['id' => (int)$t['id'], 'name' => $t['nama_jenis']];
    }, $types ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    const sppgs = <?= json_encode(array_map(static function ($s) {
        return ['id' => (string)$s['id_sppg'], 'name' => $s['sppg_name']];
    }, $assigned ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    const bahanOptions = <?= json_encode(array_map(static function ($list) {
        return array_map(static function ($b) {
            return ['id' => (int)$b['id'], 'name' => $b['nama_bahan'], 'unit' => $b['satuan_default'] ?? ''];
        }, $list);
    }, $bahanOptions ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    function refreshEmptyState() { if (emptyState) emptyState.classList.toggle('d-none', rows.children.length > 0); }
    function escapeHtml(value) { return String(value).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'",'&#039;'); }

    function addDocumentRow() {
        const index = rows.children.length;
        const wrapper = document.createElement('div');
        wrapper.className = 'document-row border rounded-3 p-3 mb-3 bg-light-subtle';
        wrapper.innerHTML = `<div class="d-flex justify-content-between align-items-center mb-2"><div class="fw-semibold">Berkas #${index+1}</div><button type="button" class="btn btn-sm btn-outline-danger btn-remove-document"><i class="bi bi-trash"></i> Hapus</button></div><div class="row g-3"><div class="col-md-4"><label class="form-label">Jenis Dokumen *</label><select name="document_type[]" class="form-select document-type" required><option value="">Pilih jenis dokumen...</option>${types.map(t=>`<option value="${t.id}">${escapeHtml(t.name)}</option>`).join('')}</select></div><div class="col-md-4"><label class="form-label">Nama Berkas</label><input name="document_name[]" class="form-control" maxlength="200" placeholder="Contoh: MOU Supplier 2026"></div><div class="col-md-4"><label class="form-label">File *</label><input type="file" name="document_file[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required></div><div class="col-12"><label class="form-label">Keterangan</label><input name="document_note[]" class="form-control" maxlength="255" placeholder="Keterangan dokumen (opsional)"></div></div>`;
        rows.appendChild(wrapper); refreshEmptyState(); renumberRows();
    }
    function renumberRows() { [...rows.querySelectorAll('.document-row')].forEach((r,i)=>{ const t=r.querySelector('.fw-semibold'); if(t)t.textContent=`Berkas #${i+1}`; }); }
    if (addButton) addButton.addEventListener('click', addDocumentRow);
    if (rows) rows.addEventListener('click', function(e){ const b=e.target.closest('.btn-remove-document'); if(!b)return; b.closest('.document-row').remove(); refreshEmptyState(); renumberRows(); });

    function bahanSelectHtml(sppgId, selectedValue='') {
        const list = bahanOptions[sppgId] || [];
        return `<select name="supplier_bahan_ref[]" class="form-select bahan-select" required><option value="">Pilih bahan...</option>${list.map(b=>{const v=sppgId+'|'+b.id;return `<option value="${v}" ${v===selectedValue?'selected':''}>${escapeHtml(b.name)} — ${escapeHtml(b.unit)}</option>`}).join('')}</select>`;
    }
    function addBahanRow() {
        if (!bahanRows) return;
        const wrapper=document.createElement('div'); wrapper.className='supplier-bahan-row border rounded-3 p-3 mb-2 bg-light-subtle';
        const defaultSppg=sppgs.length?sppgs[0].id:'';
        wrapper.innerHTML=`<div class="row g-2 align-items-end"><div class="col-md-4"><label class="form-label">SPPG</label><select class="form-select sppg-select"><option value="">Pilih SPPG...</option>${sppgs.map(s=>`<option value="${escapeHtml(s.id)}" ${s.id===defaultSppg?'selected':''}>${escapeHtml(s.name)}</option>`).join('')}</select></div><div class="col-md-4"><label class="form-label">Bahan</label><div class="bahan-holder">${bahanSelectHtml(defaultSppg)}</div></div><div class="col-md-3"><label class="form-label">Harga Beli Supplier</label><input type="number" name="supplier_bahan_price[]" min="0" step="0.01" class="form-control" placeholder="0" required></div><div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100 btn-remove-bahan" title="Hapus"><i class="bi bi-trash"></i></button></div></div>`;
        bahanRows.appendChild(wrapper);
    }
    if (addBahanButton) addBahanButton.addEventListener('click', addBahanRow);
    if (bahanRows) bahanRows.addEventListener('change', function(e){ if(!e.target.classList.contains('sppg-select'))return; const row=e.target.closest('.supplier-bahan-row'); row.querySelector('.bahan-holder').innerHTML=bahanSelectHtml(e.target.value); });
    if (bahanRows) bahanRows.addEventListener('click', function(e){ const b=e.target.closest('.btn-remove-bahan'); if(b)b.closest('.supplier-bahan-row').remove(); });

    const form=document.querySelector('form');
    if (form) form.addEventListener('submit', function(event){
        const start=document.getElementById('tanggalMouMulai').value, end=document.getElementById('tanggalMouAkhir').value;
        if(start&&end&&end<start){event.preventDefault();alert('Tanggal berakhir MOU tidak boleh lebih awal dari tanggal mulai.');return;}
        const mouSelected=[...document.querySelectorAll('.document-type option:checked')].some(o=>/mou|kerja sama/i.test(o.textContent||''));
        if(mouSelected&&(!start||!end)){event.preventDefault();alert('Jika mengunggah dokumen MOU/Surat Kerja Sama, tanggal mulai dan tanggal berakhir MOU wajib diisi.');}
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
