<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="profile-hero">
        <a href="<?= base_url('dashboard/profile/edit') ?>" class="btn-profile-action primary profile-edit-btn">
            <i class="ti ti-edit"></i> Edit Profil
        </a>
        
        <div class="profile-header-content">
            <div class="profile-avatar-container">
                <?php if (!empty($user['foto'])): ?>
                    <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="Foto Profil" class="profile-avatar">
                <?php else: ?>
                    <img src="<?= base_url('assets/icon-profile.png') ?>" alt="Foto Profil" class="profile-avatar">
                <?php endif; ?>
            </div>
            <div class="profile-user-info">
                <h2><?= htmlspecialchars($user['nama']) ?></h2>
                <div class="role-badge">
                    <?php if ($role == 'konsumen'): ?>
                        <i class="ti ti-user"></i> Konsumen
                    <?php elseif ($role == 'pemilik'): ?>
                        <i class="ti ti-building-estate"></i> Pemilik Kost
                    <?php elseif ($role == 'admin'): ?>
                        <i class="ti ti-shield"></i> Admin
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($role == 'pemilik'): ?>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">12</div>
                <div class="stat-label">Kost Terdaftar</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">45</div>
                <div class="stat-label">Kamar Tersedia</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">28</div>
                <div class="stat-label">Penghuni Aktif</div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-card-header">
                <i class="ti ti-user-circle"></i>
                <h3>Informasi Akun</h3>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-at"></i> Username
                </div>
                <div class="info-item-value highlight"><?= htmlspecialchars($user['username']) ?></div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-id-badge"></i> Role
                </div>
                <div class="info-item-value">
                    <?php
                    if ($role == 'konsumen') {
                        echo 'Konsumen';
                    } elseif ($role == 'pemilik') {
                        echo 'Pemilik Kost';
                    } elseif ($role == 'admin') {
                        echo 'Admin';
                    }
?>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="info-card-header">
                <i class="ti ti-user"></i>
                <h3>Data Pribadi</h3>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-user"></i> Nama Lengkap
                </div>
                <div class="info-item-value"><?= htmlspecialchars($user['nama']) ?></div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-phone"></i> No. HP
                </div>
                <div class="info-item-value"><?= htmlspecialchars($user['no_hp']) ?></div>
            </div>
            <?php if (!empty($profile['alamat'])): ?>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-map-pin"></i> Alamat
                </div>
                <div class="info-item-value"><?= htmlspecialchars($profile['alamat']) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($role == 'pemilik' && (!empty($profile['nama_bank']) || !empty($profile['nomor_rekening']))): ?>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-building-bank"></i> Nama Bank
                </div>
                <div class="info-item-value"><?= htmlspecialchars($profile['nama_bank'] ?? '-') ?></div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-hashtag"></i> Nomor Rekening
                </div>
                <div class="info-item-value"><?= htmlspecialchars($profile['nomor_rekening'] ?? '-') ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="info-card">
            <div class="info-card-header">
                <i class="ti ti-shield"></i>
                <h3>Keamanan</h3>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="ti ti-lock"></i> Password
                </div>
                <div class="info-item-value password-mask">••••••••</div>
            </div>
            <div style="margin-top: 20px;">
                <a href="<?= base_url('dashboard/profile/change-password') ?>" class="btn-profile-action secondary">
                    <i class="ti ti-key"></i> Ganti Password
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>