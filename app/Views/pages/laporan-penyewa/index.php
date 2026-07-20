<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?></h1>
            <p class="page-sub">Laporan data penyewa kost yang aktif</p>
        </div>
        <div class="header-actions">
            <a href="#" class="btn-add" id="exportBtn">
                <i class="ti ti-download"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="keyword" placeholder="Cari nama penyewa atau kost...">
            </div>
            <select id="filterStatus" class="filter-select">
                <option value="">Semua Status</option>
                <option value="Disetujui">Aktif</option>
                <option value="Selesai">Selesai</option>
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
document.getElementById('exportBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const keyword = document.getElementById('keyword').value;
    const status = document.getElementById('filterStatus').value;
    
    let url = '<?= base_url('dashboard/laporan-penyewa/export') ?>?';
    const params = [];
    if (keyword) params.push('keyword=' + encodeURIComponent(keyword));
    if (status) params.push('status=' + encodeURIComponent(status));
    
    window.location.href = url + params.join('&');
});

new AjaxTable({
    url: BASE_URL + "dashboard/laporan-penyewa/table",
    keyword: "keyword",
    filters: [
        { name: "filterStatus", param: "status" }
    ]
});
</script>
<?= $this->endSection() ?>