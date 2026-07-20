<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Detail Kost</h1>
            <p>Informasi lengkap tentang kost dan kamar yang tersedia</p>
        </div>
    </div>
    
    <div class="detail-header">
        <img src="<?= base_url('uploads/kost/'.$kost['foto_kost']) ?>" class="detail-photo">
        <div class="detail-info">
            <h1><?= esc($kost['nama_kost']) ?></h1>
            <p>
                <i class="ti ti-map-pin"></i>
                <?= esc($kost['alamat_kost']) ?>
            </p>
            <span class="badge"><?= esc($kost['type_kost']) ?></span>
        </div>
    </div>
    
    <div class="detail-grid">
        <div class="form-card">
            <h2>
                <i class="ti ti-info-circle"></i>
                Informasi Kost
            </h2>
            <table class="detail-table">
                <tr>
                    <td>Pemilik</td>
                    <td><?= esc($kost['nama_pemilik']) ?></td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td><?= esc($kost['lokasi_kost']) ?></td>
                </tr>
                <tr>
                    <td>Total Kamar</td>
                    <td><?= esc($kost['total_kamar']) ?> kamar (<?= esc($kost['kamar_terisi']) ?> terisi)</td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td><?= $kost['latitude'] ?></td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td><?= $kost['longitude'] ?></td>
                </tr>
            </table>
        </div>
        <div class="form-card">
            <h2>
                <i class="ti ti-wifi"></i>
                Fasilitas Kost
            </h2>
            <div class="fasilitas-grid">
                <?php if (!empty($kost['fasilitas'])): ?>
                    <?php foreach ($kost['fasilitas'] as $fasilitas): ?>
                        <div class="fasilitas-item">
                            <i class="ti ti-check"></i>
                            <span><?= esc($fasilitas['nama_fasilitas']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-data">Tidak ada fasilitas</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-card">
            <h2>
                <i class="ti ti-book"></i>
                Aturan Kost
            </h2>
            <div class="aturan-list">
                <?php if (!empty($kost['aturan'])): ?>
                    <?php foreach ($kost['aturan'] as $index => $aturan): ?>
                        <div class="aturan-item">
                            <div class="aturan-number"><?= $index + 1 ?></div>
                            <div class="aturan-content">
                                <h4><?= esc($aturan['nama_aturan']) ?></h4>
                                <p><?= esc($aturan['deskripsi_aturan']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-data">Tidak ada aturan</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <a href="<?= base_url('dashboard/kost') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        <?php if (session()->get('role') == 'pemilik'): ?>
            <a href="<?= base_url('dashboard/kamar/'.$kost['id_kost']) ?>" class="btn-add">
                <i class="ti ti-bed"></i>
                Kelola Kamar
            </a>
            <a href="<?= base_url('dashboard/kost/edit/'.$kost['id_kost']) ?>" class="btn-save">
                <i class="ti ti-edit"></i>
                Edit Kost
            </a>
        <?php endif;?>
    </div>
</div>

<?= $this->endSection() ?>