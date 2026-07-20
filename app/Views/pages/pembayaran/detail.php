<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Detail Pembayaran</h1>
            <p>Informasi lengkap tentang pembayaran penyewa</p>
        </div>
    </div>
    
    <div class="detail-header">
        <img src="<?= base_url('uploads/kost/'.$pembayaran['foto_kost']) ?>" class="detail-photo">
        <div class="detail-info">
            <h1><?= esc($pembayaran['nama_kost']) ?></h1>
            <p>
                <i class="ti ti-map-pin"></i>
                <?= esc($pembayaran['alamat_kost']) ?>
            </p>
            <span class="badge"><?= esc($pembayaran['type_kost']) ?></span>
        </div>
    </div>
    
    <div class="detail-grid">
        <div class="form-card">
            <h2>
                <i class="ti ti-user"></i>
                Informasi Penyewa
            </h2>
            <table class="detail-table">
                <tr>
                    <td>Nama</td>
                    <td><?= esc($pembayaran['nama']) ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td><?= esc($pembayaran['no_hp']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= esc($pembayaran['alamat']) ?></td>
                </tr>
            </table>
        </div>
        
        <div class="form-card">
            <h2>
                <i class="ti ti-home"></i>
                Informasi Kamar
            </h2>
            <table class="detail-table">
                <tr>
                    <td>Nomor Kamar</td>
                    <td><?= esc($pembayaran['nomor_kamar']) ?></td>
                </tr>
                <tr>
                    <td>Harga Sewa</td>
                    <td>Rp <?= number_format($pembayaran['harga_sewa'], 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form-card" style="margin-top: 20px;">
        <h2>
            <i class="ti ti-credit-card"></i>
            Informasi Pembayaran
        </h2>
        <table class="detail-table">
            <tr>
                <td>Tanggal Pemesanan</td>
                <td><?= date('d F Y', strtotime($pembayaran['tanggal_pemesanan'])) ?></td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran</td>
                <td><?php
                    $tp = $pembayaran['tanggal_pembayaran'] ?? '';
                    echo ($tp && $tp !== '0000-00-00' && $tp !== '0')
                        ? date('d F Y', strtotime($tp))
                        : '-';
                ?></td>
            </tr>
            <tr>
                <td>Jumlah Pembayaran</td>
                <td>Rp <?= number_format($pembayaran['jumlah_pembayaran'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Bukti Pembayaran</td>
                <td>
                    <a href="<?= base_url('uploads/bukti/'.$pembayaran['bukti_pembayaran']) ?>" 
                       target="_blank" 
                       class="btn-icon btn-primary">
                        <i class="ti ti-photo"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td>
                    <?php if ($pembayaran['status_pembayaran'] == "Menunggu"): ?>
                        <span class="status pending">Menunggu</span>
                    <?php elseif ($pembayaran['status_pembayaran'] == "Disetujui"): ?>
                        <span class="status available">Disetujui</span>
                    <?php else: ?>
                        <span class="status full">Ditolak</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="form-actions">
        <a href="<?= base_url('dashboard/pembayaran') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <?php if ($pembayaran['status_pembayaran'] == "Menunggu"): ?>
            <a href="<?= base_url('dashboard/pembayaran/approve/'.$pembayaran['id_pembayaran']) ?>" 
               class="btn-save approve-btn"
               data-message="Apakah Anda yakin ingin menyetujui pembayaran ini?">
                <i class="ti ti-check"></i> Setujui
            </a>
            <a href="<?= base_url('dashboard/pembayaran/reject/'.$pembayaran['id_pembayaran']) ?>" 
               class="btn-cancel reject-btn"
               data-message="Apakah Anda yakin ingin menolak pembayaran ini?">
                <i class="ti ti-x"></i> Tolak
            </a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const approveButton = document.querySelector('.approve-btn');
    if (approveButton) {
        approveButton.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menyetujui ini?';
            const url = this.getAttribute('href');
            showConfirmApprove(message, function() {
                window.location.href = url;
            });
        });
    }

    const rejectButton = document.querySelector('.reject-btn');
    if (rejectButton) {
        rejectButton.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menolak ini?';
            const url = this.getAttribute('href');
            showConfirmReject(message, function() {
                window.location.href = url;
            });
        });
    }
});
</script>
<?= $this->endSection() ?>