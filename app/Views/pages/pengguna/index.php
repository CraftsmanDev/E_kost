<?php
$role = session()->get('role');
?>

<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="dash">

    <div class="pege-header">
        <div>
            <h1 class="page-title">Data Pengguna</h1>
            <p class="page-sub">
                Kelola seluruh data pengguna sistem E-KOST
            </p>
        </div>

        <?php if ($role == 'admin'): ?>
        <a href="<?= base_url('dashboard/pengguna/tambah') ?>" class="btn-tambah">
            <i class="ti ti-plus"></i>
            Tambah Pengguna
        </a>
        <?php endif; ?>
    </div>

    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input
                    type="text"
                    id="keyword"
                    placeholder="Cari nama  kost..."
                >
            </div>
            <select id="filterRole" class="filter-select2">
                <option value="">Semua Role</option>
                <option value="1">Admin</option>
                <option value="2">Pemilik</option>
                <option value="3">Konsumen</option>
            </select>

            <select id="filterStatus" class="filter-select2">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>
        <div class="toolbar-right">
            <select id="perPage">
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
    url: BASE_URL + "dashboard/pengguna/table",
    keyword: "keyword",
    filters: [
        "filterRole",
        "filterStatus",
        "perPage"
    ]
});
</script>

<?= $this->endSection() ?>