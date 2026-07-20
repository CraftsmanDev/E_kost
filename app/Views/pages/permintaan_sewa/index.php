<?php
$role = session()->get('role');
?>

<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="dash">

    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?></h1>
            <p class="page-sub">
                Kelola seluruh permintaan penyewaan kamar kost
            </p>
        </div>
    </div>

    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="keyword"
                       placeholder="Cari nama penyewa atau kost...">
            </div>
            <select id="filterStatus" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
        <div class="toolbar-right">
            <select id="perPage" class="filter-select">
                <option value="5">5</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <div class="table-card">
        <div class="table-wrap" id="table-content">
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/table.js') ?>"></script>
<script>
new AjaxTable({
    url: BASE_URL + "dashboard/permintaan-sewa/table",
    keyword: "keyword",
    filters: [
        { name: "filterStatus", param: "status" },
        { name: "perPage", param: "perPage" }
    ]
});
</script>
<?= $this->endSection() ?>