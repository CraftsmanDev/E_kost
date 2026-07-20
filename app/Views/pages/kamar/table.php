<?php
$role = session()->get('role');
?>
<table class="table">
<thead>
<tr>
    <th style="width: 60px;">No</th>
    <th>Nomor Kamar</th>
    <th>Tipe Kamar</th>
    <th>Fasilitas</th>
    <th>Harga Sewa</th>
    <th>Status</th>
    <?php if ($role == 'pemilik' || $role == 'konsumen'): ?>
        <th style="width: 120px;">Aksi</th>
    <?php endif; ?>
</tr>
</thead>
<tbody>
<?php if (!empty($data_kamar)): ?>
<?php
    $no = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage();
    foreach ($data_kamar as $kamar):
        ?>
<tr>
    <td>
        <span class="table-no"><?= $no++ ?></span>
    </td>
    <td>
        <span class="table-cell-title"><?= esc($kamar['nomor_kamar']) ?></span>
    </td>
    <td><?= esc($kamar['nama_tipe_kamar']) ?></td>
    <td><?= esc($kamar['nama_fasilitas']) ?></td>
    <td>
        <span class="kost-price">Rp <?= number_format($kamar['harga_sewa'], 0, ',', '.') ?></span>
    </td>
    <td>
        <span class="table-badge
            <?php
                if ($kamar['status_ketersediaan'] == 'Tersedia') {
                    echo 'table-badge-success';
                } else {
                    echo 'table-badge-danger';
                } ?>">
            <?= esc($kamar['status_ketersediaan']) ?>
        </span>
    </td>
    <?php if ($role == 'pemilik' || $role == 'konsumen'): ?>
    <td>
        <div class="table-actions">
            <?php if ($role == 'pemilik'): ?>
                <a href="<?= base_url('dashboard/kamar/'.$id_kost.'/edit/'.$kamar['id_kamar']) ?>" class="btn-table btn-table-primary" title="Edit">
                    <i class="ti ti-edit"></i>
                </a>

                <a href="<?= base_url('dashboard/kamar/'.$id_kost.'/delete/'.$kamar['id_kamar']) ?>"
                   class="btn-table btn-table-danger delete-btn"
                   data-message="Apakah Anda yakin ingin menghapus kamar <?= esc($kamar['nomor_kamar']) ?>? Tindakan ini tidak dapat dibatalkan!"
                   title="Hapus">
                    <i class="ti ti-trash"></i>
                </a>
            <?php elseif ($role == 'konsumen'): ?>
                <?php if ($kamar['status_ketersediaan'] == 'Tersedia'): ?>
                    <a href="<?= base_url('dashboard/kamar/'.$id_kost.'/pesan/'.$kamar['id_kamar']) ?>"
                       class="btn-table btn-table-success pesan-btn"
                       data-message="Apakah Anda yakin ingin memesan kamar <?= esc($kamar['nomor_kamar']) ?>?"
                       title="Pesan">
                        <i class="ti ti-shopping-cart"></i>
                    </a>
                <?php elseif ($kamar['status_ketersediaan'] == 'Terisi'): ?>
                    <button class="btn-table btn-table-disabled" disabled title="Kamar sudah terisi">
                        <i class="ti ti-lock"></i>
                    </button>
                <?php elseif ($kamar['status_ketersediaan'] == 'Dipesan'): ?>
                    <button class="btn-table btn-table-disabled" disabled title="Kamar sudah dipesan">
                        <i class="ti ti-clock"></i>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </td>
    <?php endif; ?>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7">
        <div class="table-empty">
            <i class="ti ti-bed"></i>
            <p>Data kamar tidak ditemukan.</p>
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
    // Handle delete button clicks with SweetAlert2
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

    // Handle pesan button clicks with SweetAlert2
    const pesanButtons = document.querySelectorAll('.pesan-btn');
    pesanButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin memesan kamar ini?';
            const url = this.getAttribute('href');

            showConfirmDelete(message, function() {
                window.location.href = url;
            });
        });
    });
});
</script>