<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Aturan Kost</h1>
            <p class="page-subtitle">Kelola seluruh data aturan kost</p>
        </div>
        <a href="<?= base_url('dashboard/aturan-kost/tambah') ?>" class="btn-tambah">
            <i class="ti ti-plus"></i> Tambah Aturan
        </a>
    </div>

    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="keyword" placeholder="Cari nama aturan...">
            </div>
        </div>
        <div class="toolbar-right">
            <select id="perPage" class="filter-select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
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
    url: BASE_URL + "dashboard/aturan-kost/table",
    keyword: "keyword",
    filters: [
        { name: "perPage", param: "perPage" }
    ]
});
</script>
<?= $this->endSection() ?>
