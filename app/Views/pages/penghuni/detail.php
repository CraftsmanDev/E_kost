<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Penghuni</h1>
            <p class="page-sub">Informasi lengkap penghuni kost</p>
        </div>
    </div>

    <!-- Data Penghuni -->
    <div class="form-card">
        <h3 class="form-subtitle">Data Penghuni</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Nama Penghuni</span>
                    <span><?= esc($penghuni['nama'] ?? '-') ?></span>
                </li>
                <li>
                    <span>No. HP</span>
                    <span><?= esc($penghuni['no_hp'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Alamat</span>
                    <span><?= esc($penghuni['alamat'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Status Pemesanan</span>
                    <span class="table-badge table-badge-success"><?= esc($penghuni['status_pemesanan']) ?></span>
                </li>
                <li>
                    <span>Tanggal Masuk</span>
                    <span><?= !empty($penghuni['tanggal_pemesanan']) ? date('d M Y', strtotime($penghuni['tanggal_pemesanan'])) : '-' ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Data Kost -->
    <div class="form-card">
        <h3 class="form-subtitle">Data Kost</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Nama Kost</span>
                    <span><?= esc($penghuni['nama_kost'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Alamat Kost</span>
                    <span><?= esc($penghuni['alamat_kost'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Tipe Kost</span>
                    <span class="kost-type-badge <?= esc($penghuni['type_kost'] ?? '') ?>"><?= esc($penghuni['type_kost'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Total Kamar</span>
                    <span><?= esc($penghuni['total_kamar'] ?? '-') ?> kamar</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Data Kamar -->
    <div class="form-card">
        <h3 class="form-subtitle">Data Kamar</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Nomor Kamar</span>
                    <span class="table-cell-title"><?= esc($penghuni['nomor_kamar'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Tipe Kamar</span>
                    <span><?= esc($penghuni['nama_tipe_kamar'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Harga Sewa</span>
                    <span class="kost-price">Rp <?= !empty($penghuni['harga_sewa']) ? number_format($penghuni['harga_sewa'], 0, ',', '.') : '0' ?></span>
                </li>
                <li>
                    <span>Status Kamar</span>
                    <span class="table-badge table-badge-danger"><?= esc($penghuni['status_ketersediaan'] ?? 'Terisi') ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Fasilitas Kost -->
    <div class="form-card">
        <h3 class="form-subtitle">Fasilitas Kost</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Fasilitas</span>
                    <span><?= !empty($penghuni['fasilitas_kost']) ? nl2br(esc($penghuni['fasilitas_kost'])) : '-' ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Fasilitas Kamar -->
    <div class="form-card">
        <h3 class="form-subtitle">Fasilitas Kamar</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Fasilitas</span>
                    <span><?= !empty($penghuni['fasilitas_kamar']) ? nl2br(esc($penghuni['fasilitas_kamar'])) : '-' ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Aturan Kost -->
    <div class="form-card">
        <h3 class="form-subtitle">Aturan Kost</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Aturan</span>
                    <span><?= !empty($penghuni['aturan_kost']) ? nl2br(esc($penghuni['aturan_kost'])) : '-' ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Pembayaran -->
    <div class="form-card">
        <h3 class="form-subtitle">Informasi Pembayaran</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Status Pembayaran</span>
                    <span class="table-badge table-badge-success"><?= esc($penghuni['status_pembayaran'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Jumlah Pembayaran</span>
                    <span class="kost-price">Rp <?= !empty($penghuni['jumlah_pembayaran']) ? number_format($penghuni['jumlah_pembayaran'], 0, ',', '.') : '0' ?></span>
                </li>
                <li>
                    <span>Tanggal Pembayaran</span>
                    <span><?= !empty($penghuni['tanggal_pembayaran']) ? date('d M Y', strtotime($penghuni['tanggal_pembayaran'])) : '-' ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="form-actions">
        <a href="<?= base_url('dashboard/penghuni') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        <?php if ($role == 'pemilik' && !empty($penghuni['id_kamar'])): ?>
            <a href="<?= base_url('dashboard/kamar/'.$penghuni['id_kost'].'/edit/'.$penghuni['id_kamar']) ?>" class="btn-save">
                <i class="ti ti-edit"></i>
                Edit Kamar
            </a>
        <?php endif; ?>
        <?php if ($role == 'admin'): ?>
            <a href="<?= base_url('dashboard/penghuni/edit/'.$penghuni['id_pemesanan']) ?>" class="btn-save">
                <i class="ti ti-edit"></i>
                Edit Status
            </a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
