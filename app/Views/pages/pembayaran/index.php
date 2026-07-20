<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title"><?= $title ?></h1>
            <p class="page-sub">
                <?php if ($current_role == 'admin' || $current_role == 'pemilik'): ?>
                    Kelola seluruh pembayaran penyewa yang perlu diverifikasi
                <?php else: ?>
                    Kelola pembayaran sewa kamar Anda
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text"
                       id="keyword"
                       placeholder="<?= ($current_role == 'admin' || $current_role == 'pemilik') ? 'Cari nama penyewa atau kost...' : 'Cari nama kost atau kamar...' ?>">
            </div>
            <select id="filterStatus" class="filter-select">
                <option value="">Semua Status</option>
                <?php if ($current_role == 'admin' || $current_role == 'pemilik'): ?>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                <?php else: ?>
                    <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                    <option value="Menunggu">Menunggu Verifikasi</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                <?php endif; ?>
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
        </div>
        <?php if ($current_role == 'admin' || $current_role == 'pemilik'): ?>
        <div class="toolbar-right">
            <select id="perPage" class="filter-select">
                <option value="5">5</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <?php endif; ?>
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
    url: BASE_URL + "dashboard/pembayaran/table",
    keyword: "keyword",
    filters: [
        { name: "filterStatus", param: "status" },
        { name: "filterBulan", param: "bulan" }
        <?php if ($current_role == 'admin' || $current_role == 'pemilik'): ?>
        ,{ name: "perPage", param: "perPage" }
        <?php endif; ?>
    ]
});
</script>
<?= $this->endSection() ?>