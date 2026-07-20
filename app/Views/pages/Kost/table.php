<?php
$role = session()->get('role');
?>
<table class="table">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Kost</th>
            <th style="width: 100px;">Tipe</th>
            <th style="width: 120px;">Total Kamar</th>
            <th style="width: 150px;">Harga</th>
            <th style="width: 110px;">Status</th>
            <th style="width: 140px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data_kost)): ?>
        <?php $no = !empty($pager) ? 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage() : 1;
            foreach ($data_kost as $kost): ?>
            <tr>
                <td>
                    <span class="table-no"><?= $no++ ?></span>
                </td>
                <td>
                    <div class="kost-cell">
                        <img src="<?= base_url('uploads/kost/' . $kost['foto_kost']) ?>" alt="kost" class="kost-cell-img">
                        <div class="kost-cell-content">
                            <span class="kost-cell-name"><?= esc($kost['nama_kost']) ?></span>
                            <span class="kost-cell-location">
                                <i class="ti ti-map-pin"></i>
                                <?= esc(strlen($kost['alamat_kost']) > 40
                                ? substr($kost['alamat_kost'], 0, 40) . '...'
                                : $kost['alamat_kost']) ?>
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="kost-type-badge <?= esc($kost['type_kost']) ?>"><?= esc($kost['type_kost']) ?></span>
                </td>
                <td>
                    <span class="kost-room-count"><?= esc($kost['kamar_terisi']) ?>/<?= esc($kost['total_kamar']) ?> kamar</span>
                </td>
                <td>
                    <span class="kost-price">Rp <?= number_format($kost['harga'], 0, ',', '.') ?></span>
                </td>
                <td>
                    <span class="table-badge
                        <?php
                                        if ($kost['status_ketersediaan'] == 'Tersedia') {
                                            echo 'table-badge-success';
                                        } elseif ($kost['status_ketersediaan'] == 'Terisi') {
                                            echo 'table-badge-danger';
                                        } else {
                                            echo 'table-badge-warning';
                                        }
                ?>">
                        <?= esc($kost['status_ketersediaan']) ?>
                    </span>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="<?= base_url('dashboard/kost/detail/'.$kost['id_kost']) ?>" class="btn-table btn-table-info" title="Detail">
                            <i class="ti ti-eye"></i>
                        </a>
                        <a href="<?= base_url('dashboard/kamar/'.$kost['id_kost']) ?>" class="btn-table btn-table-primary" title="Kelola Kamar">
                            <i class="ti ti-bed"></i>
                        </a>
                        <?php if ($role == 'pemilik'): ?>
                            <a href="<?= base_url('dashboard/kost/edit/'.$kost['id_kost']) ?>" class="btn-table btn-table-primary" title="Edit">
                                <i class="ti ti-edit"></i>
                            </a>
                            <a href="<?= base_url('dashboard/kost/delete/'.$kost['id_kost']) ?>"
                            class="btn-table btn-table-danger delete-btn"
                            data-message="Apakah Anda yakin ingin menghapus data kost ini? Tindakan ini tidak dapat dibatalkan!"
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
                        <i class="ti ti-home"></i>
                        <p>Data kost tidak ditemukan.</p>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="table-footer">
    <?= $this->include('Pager/showing')?>
    <?php if (!empty($pager)): ?>
    <?= $pager->links('default', 'custom_pagination') ?>
    <?php endif; ?>
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