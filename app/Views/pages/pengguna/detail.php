<?php
$role = session()->get('role');
?>

<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pengguna</h1>
            <p class="page-subtitle">Informasi lengkap tentang pengguna sistem</p>
        </div>
    </div>
    
    <div class="detail-header">
        <img src="<?= base_url('assets/'.$pengguna['foto']) ?>" class="detail-photo">
        <div class="detail-info">
            <h1><?= esc($pengguna['nama']) ?></h1>
            <p>
                <i class="ti ti-id"></i>
                ID #<?= $pengguna['id_user'] ?>
            </p>
            <span class="badge"><?= esc($pengguna['username']) ?></span>
        </div>
    </div>
    
    <div class="detail-grid">
        <div class="form-card">
            <h2>
                <i class="ti ti-user"></i>
                Informasi Pengguna
            </h2>
            <table class="detail-table">
                <tr>
                    <td>Nama Lengkap</td>
                    <td><?= esc($pengguna['nama']) ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><?= esc($pengguna['username']) ?></td>
                </tr>
                <tr>
                    <td>No HP</td>
                    <td><?= esc($pengguna['no_hp']) ?></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>
                        <?php
                        if ($pengguna['role_id'] == 1) {
                            echo '<span class="table-badge table-badge-primary">Admin</span>';
                        } elseif ($pengguna['role_id'] == 2) {
                            echo '<span class="table-badge table-badge-warning">Pemilik</span>';
                        } else {
                            echo '<span class="table-badge table-badge-success">Konsumen</span>';
                        }
?>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <?php if ($pengguna['status'] == "Aktif"): ?>
                            <span class="table-badge table-badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="table-badge table-badge-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Dibuat</td>
                    <td><?= date('d/m/Y H:i', strtotime($pengguna['created_at'])) ?></td>
                </tr>
                <tr>
                    <td>Tanggal Diupdate</td>
                    <td><?= date('d/m/Y H:i', strtotime($pengguna['updated_at'])) ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form-actions">
        <a href="<?= base_url('dashboard/pengguna') ?>" class="btn-back">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        <?php if ($role == 'admin' && $pengguna['id_user'] != session()->get('user_id')): ?>
        <a href="<?= base_url('dashboard/pengguna/edit/'.$pengguna['id_user']) ?>" class="btn-save">
            <i class="ti ti-edit"></i>
            Edit Pengguna
        </a>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
