<?php if (!empty($pager)): ?>
<?php
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
$total = $pager->getTotal();

$start = ($currentPage - 1) * $perPage + 1;
$end = min($currentPage * $perPage, $total);
?>
<div class="showing">
    Showing
    <strong><?= $start ?></strong>
    to
    <strong><?= $end ?></strong>
    of
    <strong><?= $total ?></strong>
    entries
</div>
<?php endif; ?>