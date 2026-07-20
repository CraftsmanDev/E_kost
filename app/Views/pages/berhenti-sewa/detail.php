<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Detail Pengajuan Berhenti Sewa</h1>
            <p>Informasi lengkap tentang pengajuan berhenti sewa</p>
        </div>
        <a href="<?= base_url('dashboard/pengajuan-berhenti') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="detail-header">
        <img src="<?= base_url('uploads/kost/'.$pengajuan['foto_kost']) ?>" class="detail-photo">
        <div class="detail-info">
            <h1><?= esc($pengajuan['nama_kost']) ?></h1>
            <p>
                <i class="ti ti-map-pin"></i>
                <?= esc($pengajuan['alamat_kost']) ?>
            </p>
            <span class="badge"><?= esc($pengajuan['type_kost']) ?></span>
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
                    <td><?= esc($pengajuan['nama']) ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td><?= esc($pengajuan['no_hp']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= esc($pengajuan['alamat_konsumen']) ?></td>
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
                    <td><?= esc($pengajuan['nomor_kamar']) ?></td>
                </tr>
                <tr>
                    <td>Harga Sewa</td>
                    <td>Rp <?= number_format($pengajuan['harga_sewa'], 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form-card">
        <h2>
            <i class="ti ti-calendar"></i>
            Informasi Pengajuan
        </h2>
        <table class="detail-table">
            <tr>
                <td>Tanggal Pengajuan</td>
                <td><?= date('d F Y', strtotime($pengajuan['tanggal_pengajuan'])) ?></td>
            </tr>
            <tr>
                <td>Tanggal Berhenti</td>
                <td><?= date('d F Y', strtotime($pengajuan['tanggal_berhenti'])) ?></td>
            </tr>
            <tr>
                <td>Alasan</td>
                <td><?= esc($pengajuan['alasan']) ?></td>
            </tr>
            <?php if(!empty($pengajuan['catatan_admin'])): ?>
            <tr>
                <td>Catatan Admin</td>
                <td><?= esc($pengajuan['catatan_admin']) ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>Status Pengajuan</td>
                <td>
                    <?php if($pengajuan['status_pengajuan']=="Menunggu"): ?>
                        <span class="status pending">Menunggu</span>
                    <?php elseif($pengajuan['status_pengajuan']=="Disetujui"): ?>
                        <span class="status available">Disetujui</span>
                    <?php else: ?>
                        <span class="status full">Ditolak</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="form-actions">
        <a href="<?= base_url('dashboard/pengajuan-berhenti') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <?php if($pengajuan['status_pengajuan']=="Menunggu"): ?>
            <a href="<?= base_url('dashboard/pengajuan-berhenti/approve/'.$pengajuan['id_pengajuan']) ?>" 
               class="btn-save approve-btn"
               data-message="Apakah Anda yakin ingin menyetujui pengajuan berhenti sewa ini?">
                <i class="ti ti-check"></i> Setujui
            </a>
            <a href="<?= base_url('dashboard/pengajuan-berhenti/reject/'.$pengajuan['id_pengajuan']) ?>" 
               class="btn-cancel reject-btn"
               data-message="Apakah Anda yakin ingin menolak pengajuan berhenti sewa ini?">
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