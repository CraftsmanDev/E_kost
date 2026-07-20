<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Status Penghuni</h1>
            <p class="page-sub">Ubah status pemesanan penghuni kost</p>
        </div>
    </div>

    <div class="form-card">
        <h3 class="form-subtitle">Informasi Penghuni</h3>
        <div class="info-box">
            <ul>
                <li>
                    <span>Nama Penghuni</span>
                    <span><?= esc($penghuni['nama'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Kost</span>
                    <span><?= esc($penghuni['nama_kost'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Kamar</span>
                    <span><?= esc($penghuni['nomor_kamar'] ?? '-') ?></span>
                </li>
                <li>
                    <span>Status Saat Ini</span>
                    <span class="table-badge table-badge-success"><?= esc($penghuni['status_pemesanan']) ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="form-card">
        <h3 class="form-subtitle">Edit Status</h3>
        <form action="<?= base_url('dashboard/penghuni/update/'.$penghuni['id_pemesanan']) ?>" method="post">
            <?= csrf_field(); ?>
            <div class="field-group">
                <label>Status Pemesanan</label>
                <select name="status_pemesanan" required>
                    <option value="Disetujui" <?= $penghuni['status_pemesanan'] == 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="Ditolak" <?= $penghuni['status_pemesanan'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    <option value="Selesai" <?= $penghuni['status_pemesanan'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="alert-danger mt-4">
                <i class="ti ti-alert-circle"></i>
                <span>Penting: Perubahan status akan memengaruhi status pemesanan dan ketersediaan kamar.</span>
            </div>
            <div class="form-actions mt-4">
                <a href="<?= base_url('dashboard/penghuni/detail/'.$penghuni['id_pemesanan']) ?>" class="btn-back">
                    <i class="ti ti-arrow-left"></i>
                    Kembali
                </a>
                <button type="submit" class="btn-save">
                    <i class="ti ti-device-floppy"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
