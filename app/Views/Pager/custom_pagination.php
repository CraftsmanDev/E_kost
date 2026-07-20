<?php if ($pager->getPageCount() > 1): ?>
<div class="compact-pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="page-btn" title="First">
            <i class="ti ti-chevrons-left"></i>
        </a>
        <a href="<?= $pager->getPrevious() ?>" class="page-btn" title="Previous">
            <i class="ti ti-chevron-left"></i>
        </a>
    <?php endif; ?>
    <?php foreach ($pager->links() as $link): ?>
        <a href="<?= $link['uri'] ?>"
           class="page-number <?= $link['active'] ? 'active' : '' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach; ?>
    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="page-btn" title="Next">
            <i class="ti ti-chevron-right"></i>
        </a>
        <a href="<?= $pager->getLast() ?>" class="page-btn" title="Last">
            <i class="ti ti-chevrons-right"></i>
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>