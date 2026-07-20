<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Detail Permintaan Sewa</h1>
            <p>Informasi lengkap tentang permintaan penyewaan kamar</p>
        </div>
        <a href="<?= base_url('dashboard/permintaan-sewa') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="detail-header">
        <img src="<?= base_url('uploads/kost/'.$pemesanan['foto_kost']) ?>" class="detail-photo">
        <div class="detail-info">
            <h1><?= esc($pemesanan['nama_kost']) ?></h1>
            <p>
                <i class="ti ti-map-pin"></i>
                <?= esc($pemesanan['alamat_kost']) ?>
            </p>
            <span class="badge"><?= esc($pemesanan['type_kost']) ?></span>
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
                    <td><?= esc($pemesanan['nama']) ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td><?= esc($pemesanan['no_hp']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= esc($pemesanan['alamat_konsumen']) ?></td>
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
                    <td><?= esc($pemesanan['nomor_kamar']) ?></td>
                </tr>
                <tr>
                    <td>Tipe Kamar</td>
                    <td><?= esc($pemesanan['nama_tipe_kamar']) ?></td>
                </tr>
                <tr>
                    <td>Fasilitas Kamar</td>
                    <td><?= esc($pemesanan['nama_fasilitas']) ?></td>
                </tr>
                <tr>
                    <td>Harga Sewa</td>
                    <td>Rp <?= number_format($pemesanan['harga_sewa'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Total Kamar</td>
                    <td><?= esc($pemesanan['total_kamar']) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="detail-grid">
        <div class="form-card">
            <h2>
                <i class="ti ti-armchair"></i>
                Fasilitas Kost
            </h2>
            <?php if (!empty($pemesanan['fasilitas_kost'])): ?>
                <div class="tag-list">
                    <?php foreach (explode(', ', $pemesanan['fasilitas_kost']) as $fas): ?>
                        <span class="tag"><?= esc($fas) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #999;">Tidak ada data fasilitas</p>
            <?php endif; ?>
        </div>

        <div class="form-card">
            <h2>
                <i class="ti ti-list"></i>
                Aturan Kost
            </h2>
            <?php if (!empty($pemesanan['aturan_kost'])): ?>
                <div class="tag-list">
                    <?php foreach (explode(', ', $pemesanan['aturan_kost']) as $aturan): ?>
                        <span class="tag tag-rule"><?= esc($aturan) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #999;">Tidak ada data aturan</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-card" style="margin-top: 20px;">
        <h2>
            <i class="ti ti-calendar"></i>
            Informasi Pemesanan
        </h2>
        <table class="detail-table">
            <tr>
                <td>Tanggal Pemesanan</td>
                <td><?= date('d F Y', strtotime($pemesanan['tanggal_pemesanan'])) ?></td>
            </tr>
            <tr>
                <td>Status Pemesanan</td>
                <td>
                    <?php if ($pemesanan['status_pemesanan'] == 'Menunggu'): ?>
                        <span class="status pending">Menunggu</span>
                    <?php elseif ($pemesanan['status_pemesanan'] == 'Disetujui'): ?>
                        <span class="status available">Disetujui</span>
                    <?php else: ?>
                        <span class="status full">Ditolak</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="form-actions">
        <a href="<?= base_url('dashboard/permintaan-sewa') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <?php if ($pemesanan['status_pemesanan'] == 'Menunggu'): ?>
            <a href="<?= base_url('dashboard/permintaan-sewa/approve/'.$pemesanan['id_pemesanan']) ?>" 
               class="btn-save approve-btn"
               data-message="Apakah Anda yakin ingin menyetujui permintaan sewa ini?">
                <i class="ti ti-check"></i> Setujui
            </a>
            <a href="<?= base_url('dashboard/permintaan-sewa/reject/'.$pemesanan['id_pemesanan']) ?>" 
               class="btn-cancel reject-btn"
               data-message="Apakah Anda yakin ingin menolak permintaan sewa ini?">
                <i class="ti ti-x"></i> Tolak
            </a>
        <?php endif; ?>
    </div>
</div>
<style>
.tag-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.tag {
    background: #e3f2fd;
    color: #1565c0;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}
.tag-rule {
    background: #fce4ec;
    color: #c62828;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle approve button clicks with SweetAlert2
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

    // Handle reject button clicks with SweetAlert2
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