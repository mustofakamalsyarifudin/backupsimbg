<?= $this->extend('layouts/affan') ?>
<?= $this->section('content') ?>
<style>
.user-filter .form-control,.user-filter .form-select{min-height:42px;border-radius:.8rem}
.user-actions{display:flex;flex-wrap:wrap;gap:.4rem;justify-content:flex-end}
.user-actions form{margin:0}
.user-action{border-radius:.75rem;white-space:nowrap}
.user-table td{vertical-align:middle}
.user-email{font-size:.78rem;color:#6c75a6}
.role-badge{font-size:.72rem;padding:.38rem .55rem;border-radius:999px}
@media(max-width:767.98px){.user-actions{justify-content:flex-start}.user-table{min-width:760px}}
</style>
<div class="page-content-wrapper py-3"><div class="container">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div><h5 class="mb-1">Manajemen User</h5><small class="text-muted">Kelola seluruh akun, role, SPPG, Koperasi, dan status user.</small></div>
        <div class="d-flex gap-2"><a href="<?= base_url('super-admin') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a><a href="<?= base_url('super-admin/users/create') ?>" class="btn btn-primary btn-sm rounded-pill px-3"><i class="bi bi-person-plus me-1"></i>Buat User</a></div>
    </div>
    <?php if ($m=session()->getFlashdata('success')): ?><div class="alert alert-success border-0 shadow-sm rounded-4"><i class="bi bi-check-circle-fill me-1"></i><?= esc($m) ?></div><?php endif; ?>
    <?php if ($m=session()->getFlashdata('error')): ?><div class="alert alert-danger border-0 shadow-sm rounded-4"><i class="bi bi-exclamation-triangle-fill me-1"></i><?= esc($m) ?></div><?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-3"><div class="card-body p-3 p-md-4">
        <form method="get" action="<?= base_url('super-admin/users') ?>" class="user-filter">
            <div class="row g-2 align-items-end">
                <div class="col-md-6"><label class="form-label small fw-semibold">Cari User</label><input name="q" value="<?= esc($search) ?>" class="form-control" placeholder="Nama, username, email, role, SPPG, koperasi..."></div>
                <div class="col-md-2"><label class="form-label small fw-semibold">Role</label><select name="level" class="form-select"><option value="">Semua Role</option><?php foreach($levels as $l): ?><option value="<?= esc($l) ?>" <?= $level===$l?'selected':'' ?>><?= esc(ucwords(str_replace('_',' ',$l))) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-2"><label class="form-label small fw-semibold">Status</label><select name="status" class="form-select"><option value="">Semua</option><option value="active" <?= $status==='active'?'selected':'' ?>>Aktif</option><option value="inactive" <?= $status==='inactive'?'selected':'' ?>>Nonaktif</option></select></div>
                <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary flex-fill rounded-pill"><i class="bi bi-search me-1"></i>Cari</button><a href="<?= base_url('super-admin/users') ?>" class="btn btn-light rounded-pill">Reset</a></div>
            </div>
        </form>
    </div></div>

    <div class="card border-0 shadow-sm rounded-4"><div class="card-body p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3"><div><h6 class="mb-1">Daftar User</h6><small class="text-muted">User terbaru ditampilkan lebih dahulu.</small></div><span class="badge bg-primary rounded-pill px-3"><?= number_format($pager->getTotal()) ?> user</span></div>
        <div class="table-responsive"><table class="table table-hover user-table mb-0"><thead><tr><th>Nama</th><th>Role</th><th>SPPG/Koperasi</th><th>Status</th><th class="text-end">Aksi</th></tr></thead><tbody>
        <?php if (!$users): ?><tr><td colspan="5" class="text-center text-muted py-5">Tidak ada user yang sesuai pencarian.</td></tr><?php endif; ?>
        <?php foreach($users as $u): $isActive=($u['status']??'active')==='active'; $place=$u['sppg_name'] ?? ($u['nama_koperasi'] ?? '-'); ?>
        <tr><td><strong><?= esc($u['full_name']) ?></strong><br><span class="user-email"><?= esc($u['email'] ?? $u['username']) ?></span></td><td><span class="badge bg-light text-primary border role-badge"><?= esc(ucwords(str_replace('_',' ',$u['user_level']))) ?></span></td><td><?= esc($place) ?></td><td><span class="badge bg-<?= $isActive?'success':'secondary' ?> rounded-pill"><?= $isActive?'Aktif':'Nonaktif' ?></span></td><td><div class="user-actions">
            <a href="<?= base_url('super-admin/users/edit/'.$u['id']) ?>" class="btn btn-outline-primary btn-sm user-action"><i class="bi bi-pencil-square me-1"></i>Edit</a>
            <form method="post" action="<?= base_url('super-admin/users/toggle/'.$u['id']) ?>"><?= csrf_field() ?><button class="btn btn-outline-<?= $isActive?'danger':'success' ?> btn-sm user-action" <?= (int)$u['id']===(int)session('user_id')?'disabled':'' ?>><i class="bi bi-power me-1"></i><?= $isActive?'Nonaktifkan':'Aktifkan' ?></button></form>
            <form method="post" action="<?= base_url('super-admin/users/reset-password/'.$u['id']) ?>"><?= csrf_field() ?><button class="btn btn-outline-warning btn-sm user-action" onclick="return confirm('Reset password user ini?')" <?= (int)$u['id']===(int)session('user_id')?'disabled':'' ?>><i class="bi bi-key me-1"></i>Reset</button></form>
            <form method="post" action="<?= base_url('super-admin/users/delete/'.$u['id']) ?>"><?= csrf_field() ?><button class="btn btn-outline-danger btn-sm user-action" onclick="return confirm('Hapus user ini secara permanen? Data aktivitas yang memiliki relasi user akan tetap dipertahankan bila database menggunakan SET NULL.')" <?= (int)$u['id']===(int)session('user_id')?'disabled':'' ?>><i class="bi bi-trash3 me-1"></i>Hapus</button></form>
        </div></td></tr>
        <?php endforeach; ?></tbody></table></div>
        <?php if ($pager->getPageCount()>1): ?><div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4"><small class="text-muted">Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?> · <?= number_format($pager->getTotal()) ?> user</small><nav><ul class="pagination pagination-sm mb-0"><?php $cur=$pager->getCurrentPage();$pages=$pager->getPageCount();$url=function($p)use($search,$level,$status){$x=['page'=>$p];if($search!=='')$x['q']=$search;if($level!=='')$x['level']=$level;if($status!=='')$x['status']=$status;return base_url('super-admin/users').'?'.http_build_query($x);}; ?><li class="page-item <?= $cur<=1?'disabled':'' ?>"><a class="page-link" href="<?= $cur>1?esc($url($cur-1)):'#' ?>">‹</a></li><?php $start=max(1,$cur-2);$end=min($pages,$cur+2);if($start>1): ?><li class="page-item"><a class="page-link" href="<?= esc($url(1)) ?>">1</a></li><?php if($start>2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif;endif;for($p=$start;$p<=$end;$p++): ?><li class="page-item <?= $p===$cur?'active':'' ?>"><a class="page-link" href="<?= esc($url($p)) ?>"><?= $p ?></a></li><?php endfor;if($end<$pages):if($end<$pages-1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?><li class="page-item"><a class="page-link" href="<?= esc($url($pages)) ?>"><?= $pages ?></a></li><?php endif; ?><li class="page-item <?= $cur>=$pages?'disabled':'' ?>"><a class="page-link" href="<?= $cur<$pages?esc($url($cur+1)):'#' ?>">›</a></li></ul></nav></div><?php endif; ?>
    </div></div>
</div></div>
<?= $this->endSection() ?>
