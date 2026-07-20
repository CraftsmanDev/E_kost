<?php
$role = session()->get('role');
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="<?= base_url('assets/logo-kost.png') ?>" alt="Logo" class="brand-logo">
        <p class="brand-name">SISTEM INFORMASI<br/><span>E_KOST</span></p>
        <button class="sidebar-close" id="sidebarClose">
            <i class="ti ti-chevron-left-pipe"></i>
        </button>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= base_url('dashboard') ?>" class="nav-item active" >
            <i class="ti ti-home"></i>
            <span>Dashboard</span>
        </a>
        <?php if ($role == 'admin') :?>
            <a href="<?= base_url('dashboard/kost') ?>" class="nav-item">
                <i class="ti ti-building-estate"></i>
                <span>Data Kost</span>
            </a>
            <a href="<?= base_url('dashboard/permintaan-sewa') ?>" class="nav-item">
                <i class="ti ti-file-description"></i>
                <span>Permintaan Sewa</span>
            </a>
            <a href="<?= base_url('dashboard/pembayaran') ?>" class="nav-item">
                <i class="ti ti-credit-card"></i>
                <span>Pembayaran</span>
            </a>
            <a href="<?= base_url('dashboard/penghuni') ?>" class="nav-item">
                <i class="ti ti-users-group"></i>
                <span>Data Penghuni</span>
            </a>
            <a href="<?= base_url('dashboard/pengajuan-berhenti') ?>" class="nav-item">
                <i class="ti ti-door-exit"></i>
                <span>Berhenti Sewa</span>
            </a>
            <div class="nav-dropdown">
                <a href="#" class="nav-item dropdown-toggle" id="laporanDropdown">
                    <i class="ti ti-report-analytics"></i>
                    <span>Laporan</span>
                    <i class="ti ti-chevron-down dropdown-arrow"></i>
                </a>
                <div class="dropdown-menu" id="laporanMenu">
                    <a href="<?= base_url('dashboard/laporan-keuangan') ?>" class="nav-item">
                        <i class="ti ti-currency-dollar"></i>
                        <span>Laporan Keuangan</span>
                    </a>
                    <a href="<?= base_url('dashboard/laporan-penyewa') ?>" class="nav-item">
                        <i class="ti ti-users"></i>
                        <span>Laporan Penyewa</span>
                    </a>
                </div>
            </div>
        <?php elseif ($role == 'pemilik'):?>
            <a href="<?= base_url('dashboard/kost') ?>" class="nav-item">
                <i class="ti ti-building-estate"></i>
                <span>Kelola Kost</span>
            </a>
            <a href="<?= base_url('dashboard/permintaan-sewa') ?>" class="nav-item">
                <i class="ti ti-file-description"></i>
                <span>Permintaan Sewa</span>
            </a>
            <a href="<?= base_url('dashboard/penghuni') ?>" class="nav-item">
                <i class="ti ti-users-group"></i>
                <span>Data Penghuni</span>
            </a>
            <a href="<?= base_url('dashboard/pembayaran') ?>" class="nav-item">
                <i class="ti ti-credit-card"></i>
                <span>Pembayaran</span>
            </a>
            <a href="<?= base_url('dashboard/pengajuan-berhenti') ?>" class="nav-item">
                <i class="ti ti-door-exit"></i>
                <span>Berhenti Sewa</span>
            </a>
        <?php elseif ($role == 'konsumen'):?>
            <a href="<?= base_url('dashboard/kost') ?>" class="nav-item">
                <i class="ti ti-building-estate"></i>
                <span>Cari Kost</span>
            </a>
            <a href="<?= base_url('dashboard/permintaan-sewa') ?>" class="nav-item">
                <i class="ti ti-file-description"></i>
                <span>Pesanan Saya</span>
            </a>
            <a href="<?= base_url('dashboard/pembayaran') ?>" class="nav-item">
                <i class="ti ti-credit-card"></i>
                <span>Pembayaran</span>
            </a>
            <a href="<?= base_url('dashboard/penghuni') ?>" class="nav-item">
                <i class="ti ti-users-group"></i>
                <span>Sewa Saya</span>
            </a>
            <a href="<?= base_url('dashboard/pengajuan-berhenti') ?>" class="nav-item">
                <i class="ti ti-door-exit"></i>
                <span>Berhenti Sewa</span>
            </a>
        <?php endif;?>
    </nav>
    <div class="sidebar-divider"></div>
    <nav class="sidebar-nav">
        <?php if ($role == 'pemilik' || $role == 'konsumen') : ?>
            <a href="<?= base_url('dashboard/profile') ?>" class="nav-item">
                <i class="ti ti-user"></i> Profil Saya
            </a>
        <?php elseif ($role == 'admin') : ?>
            <a href="<?= base_url('dashboard/pengguna') ?>" class="nav-item">
                <i class="ti ti-users"></i>
                <span>Data Pengguna</span>
            </a>
        <?php endif;?>
        <a href="<?= base_url('logout') ?>" class="nav-item nav-logout">
            <i class="ti ti-logout"></i> Keluar
        </a>
    </nav>
    <div class="sidebar-location-card" id="locationCard">
        <div class="loc-icon"><i class="ti ti-map-pin"></i></div>
        <div class="loc-info">
            <strong id="locationName">Mendeteksi lokasi...</strong>
            <span>Temukan kost terbaik di daerah Mimbaan dengan mudah.</span>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown toggle
    const dropdownToggle = document.getElementById('laporanDropdown');
    const dropdownMenu = document.getElementById('laporanMenu');
    
    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
            dropdownToggle.classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                dropdownToggle.classList.remove('active');
            }
        });
    }
});
</script>