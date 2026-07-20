<?php
$role = session()->get('role');
$data_penghuni = $data_penghuni ?? [];
$no = 1;
?>
<table class="table">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Penghuni</th>
            <th>Kost</th>
            <th>Kamar</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
            <th style="width: 140px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($data_penghuni) && is_array($data_penghuni)): ?>
        <?php foreach ($data_penghuni as $row): ?>
        <tr>
            <td>
                <span class="table-no"><?= $no++ ?></span>
            </td>
            <td>
            <div class="table-cell">
                <div class="table-cell-content">
                    <span class="table-cell-title"><?= esc($row['nama']) ?></span>
                    <span class="table-cell-subtitle"><?= esc($row['alamat']) ?></span>
                    <span class="table-cell-subtitle"><?= esc($row['no_hp']) ?></span>
                </div>
            </div>
            </td>
            <td>
                <span class="table-cell-title"><?= esc($row['nama_kost']) ?></span>
            </td>
            <td>
                <div class="table-cell-content">
                    <span class="table-cell-title"><?= esc($row['nomor_kamar'] ?? '-') ?></span>
                    <span class="table-cell-subtitle"><?= esc($row['nama_tipe_kamar'] ?? '-') ?></span>
                </div>
            </td>
            <td>
                <span class="table-cell-subtitle"><?= date('d M Y', strtotime($row['tanggal_pemesanan'])) ?></span>
            </td>
            <td>
                <span class="table-badge table-badge-success">
                    Aktif
                </span>
            </td>
            <td>
                <div class="table-actions">
                    <a href="<?= base_url('dashboard/penghuni/detail/'.$row['id_pemesanan']) ?>" class="btn-table btn-table-info" title="Detail">
                        <i class="ti ti-eye"></i>
                    </a>
                    <?php if ($role == 'pemilik' && !empty($row['id_kamar'])): ?>
                        <a href="<?= base_url('dashboard/kamar/'.$row['id_kost'].'/edit/'.$row['id_kamar']) ?>" class="btn-table btn-table-primary" title="Edit Kamar">
                            <i class="ti ti-bed"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($role == 'admin'): ?>
                        <a href="<?= base_url('dashboard/penghuni/edit/'.$row['id_pemesanan']) ?>"
                        class="btn-table btn-table-warning"
                        title="Edit Status">
                            <i class="ti ti-edit"></i>
                        </a>
                        <a href="<?= base_url('dashboard/penghuni/delete/'.$row['id_pemesanan']) ?>"
                        class="btn-table btn-table-danger delete-btn"
                        data-message="Apakah Anda yakin ingin menghapus data penghuni ini? Tindakan ini tidak dapat dibatalkan!"
                        title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">
                    <div class="table-empty">
                        <i class="ti ti-users"></i>
                        <p>Belum ada penghuni.</p>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="table-footer">
    <?= $this->include('Pager/showing')?>
    <?= $pager->links('default', 'custom_pagination') ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menghapus data ini?';
            const url = this.getAttribute('href');

            showConfirmDelete(message, function() {
                window.location.href = url;
            });
        });
    });
});
</script>