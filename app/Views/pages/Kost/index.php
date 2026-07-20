<?php
$role = session()->get('role');
?>
<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Kost</h1>
            <p class="page-subtitle">Kelola seluruh data kost yang terdaftar</p>
        </div>
        <?php if ($role == 'pemilik'):?>
            <a href="<?= base_url('dashboard/add/kost')?>" class="btn-tambah">
                <i class="ti ti-plus"></i> Tambah Kost
            </a>
        <?php endif;?>
    </div>
    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="keyword" placeholder="Cari nama atau lokasi kost...">
            </div>
            <select class="filter-select" id="filterTipe">
                <option value="">Semua tipe</option>
                <option value="PUTRA">Putra</option>
                <option value="PUTRI">Putri</option>
                <option value="CAMPUR">Campur</option>
            </select>
            <select class="filter-select" id="filterStatus">
                <option value="">Semua status</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Penuh">Penuh</option>
            </select>
        </div>
         <div class="toolbar-right">
            <select id="perPage" class="filter-select">
                <option value="5">5</option>
                <option value="10">10</option>
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
<script src="<?= base_url('js/table.js')?>"></script>
<script>
new AjaxTable({
    url: BASE_URL + "dashboard/kost/table",
    keyword: "keyword",
    filters: [
        { name: "filterTipe", param: "type" },
        { name: "filterStatus", param: "status" },
        { name: "perPage", param: "perPage" }
    ]
});
</script>
<?= $this->endSection() ?>