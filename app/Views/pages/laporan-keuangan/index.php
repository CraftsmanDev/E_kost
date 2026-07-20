<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?></h1>
            <p class="page-sub">Laporan keuangan dan pendapatan dari penyewa kost</p>
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
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
            <select id="filterBulan" class="filter-select">
                <option value="">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <select id="filterTahun" class="filter-select">
                <option value="">Semua Tahun</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
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
    const bulan = document.getElementById('filterBulan').value;
    const tahun = document.getElementById('filterTahun').value;
    let url = '<?= base_url('dashboard/laporan-keuangan/export') ?>?';
    const params = [];
    if (keyword) params.push('keyword=' + encodeURIComponent(keyword));
    if (status) params.push('status=' + encodeURIComponent(status));
    if (bulan) params.push('bulan=' + encodeURIComponent(bulan));
    if (tahun) params.push('tahun=' + encodeURIComponent(tahun));
    window.location.href = url + params.join('&');
});

new AjaxTable({
    url: BASE_URL + "dashboard/laporan-keuangan/table",
    keyword: "keyword",
    filters: [
        { name: "filterStatus", param: "status" },
        { name: "filterBulan", param: "bulan" },
        { name: "filterTahun", param: "tahun" }
    ]
});
</script>
<?= $this->endSection() ?>