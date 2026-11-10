<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm mb-0 justify-content-end">
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <a class="page-link rounded-start-pill" href="<?= $pager->getPrevious() ?: '#' ?>" aria-label="Sebelumnya">&laquo;</a>
        </li>
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>
        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link rounded-end-pill" href="<?= $pager->getNext() ?: '#' ?>" aria-label="Berikutnya">&raquo;</a>
        </li>
    </ul>
</nav>
<?php endif; ?>
