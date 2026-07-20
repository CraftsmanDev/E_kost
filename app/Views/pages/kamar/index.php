<?php
$role = session()->get('role');
?>
<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Data Kamar</h1>
            <p class="page-sub">Kelola kamar untuk kost: <?= esc($kost['nama_kost']) ?></p>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('dashboard/kost') ?>" class="btn-back">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
            <?php if ($role == 'pemilik' && $sisa_slot > 0):?>
                <a href="<?= base_url('dashboard/kamar/'.$id_kost.'/create')?>" class="btn-tambah">
                    <i class="ti ti-plus"></i> Tambah Kamar
                </a>
            <?php elseif ($role == 'pemilik' && $sisa_slot <= 0):?>
                <span class="btn-tambah" style="opacity:0.5;cursor:not-allowed;" title="Semua kamar sudah terisi">
                    <i class="ti ti-plus"></i> Kamar Penuh
                </span>
            <?php endif;?>
        </div>
    </div>

    <div class="kost-info-card">
        <div class="kost-info-content">
            <img src="<?= base_url('uploads/kost/' . $kost['foto_kost']) ?>" alt="kost" class="kost-thumb">
            <div class="kost-details">
                <h3><?= esc($kost['nama_kost']) ?></h3>
                <p>
                    <i class="ti ti-map-pin"></i>
                    <?= esc($kost['alamat_kost']) ?>
                </p>
                <span class="badge"><?= esc($kost['type_kost']) ?></span>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="ti ti-bed"></i>
            </div>
            <div class="stat-info">
                <h4>Total Kamar</h4>
                <p id="stat-total">0</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon available">
                <i class="ti ti-check"></i>
            </div>
            <div class="stat-info">
                <h4>Tersedia</h4>
                <p id="stat-tersedia">0</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon full">
                <i class="ti ti-x"></i>
            </div>
            <div class="stat-info">
                <h4>Terisi</h4>
                <p id="stat-terisi">0</p>
            </div>
        </div>
    </div>

    <div class="table-toolbar">
        <div class="toolbar-left">
            <div class="search-input">
                <i class="ti ti-search"></i>
                <input type="text" id="keyword" placeholder="Cari nomor kamar...">
            </div>
            <select class="filter-select" id="filterStatus">
                <option value="">Semua status</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Terisi">Terisi</option>
            </select>
        </div>
        <div class="toolbar-right">
            <select id="perPage" class="filter-select">
                <option value="5">5</option>
                <option value="10" selected>10</option>
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
const kostId = '<?= $id_kost ?>';

// Load statistics
function loadStats() {
    fetch(`${BASE_URL}dashboard/kamar/${kostId}/stats`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('stat-total').textContent = data.total;
            document.getElementById('stat-tersedia').textContent = data.tersedia;
            document.getElementById('stat-terisi').textContent = data.terisi;
        })
        .catch(error => console.error('Error loading stats:', error));
}

new AjaxTable({
    url: BASE_URL + "dashboard/kamar/" + kostId + "/table",
    keyword: "keyword",
    filters: [
        { name: "filterStatus", param: "status" },
        { name: "perPage", param: "perPage" }
    ],
    onSuccess: function() {
        loadStats();
    }
});

// Load stats on page load
loadStats();
</script>
<?= $this->endSection() ?>