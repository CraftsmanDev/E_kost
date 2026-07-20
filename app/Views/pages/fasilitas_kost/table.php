<table class="table">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Nama Fasilitas</th>
            <th>Deskripsi</th>
            <th style="width: 140px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data_fasilitas)): ?>
        <?php
            $currentPage = service('request')->getGet('page') ?? 1;
            $perPage = !empty($pager) ? $pager->getPerPage() : 10;
            $no = ($currentPage - 1) * $perPage + 1;
            foreach ($data_fasilitas as $row):
        ?>
        <tr>
            <td>
                <span class="table-no"><?= $no++ ?></span>
            </td>
            <td>
                <div class="table-cell">
                    <div class="table-cell-content">
                        <span class="table-cell-title"><?= esc($row['nama_fasilitas']) ?></span>
                    </div>
                </div>
            </td>
            <td>
                <span class="table-cell-subtitle">
                    <?= esc(strlen($row['deskripsi']) > 60
                        ? substr($row['deskripsi'], 0, 60) . '...'
                        : $row['deskripsi']) ?>
                </span>
            </td>
            <td>
                <div class="table-actions">
                    <a href="<?= base_url('dashboard/fasilitas-kost/edit/'.$row['id_fasilitas_kost']) ?>" class="btn-table btn-table-warning" title="Edit">
                        <i class="ti ti-edit"></i>
                    </a>
                    <a href="<?= base_url('dashboard/fasilitas-kost/hapus/'.$row['id_fasilitas_kost']) ?>"
                       class="btn-table btn-table-danger delete-btn"
                       data-message="Apakah Anda yakin ingin menghapus fasilitas ini? Tindakan ini tidak dapat dibatalkan!"
                       title="Hapus">
                        <i class="ti ti-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="4">
                <div class="table-empty">
                    <i class="ti ti-tool"></i>
                    <p>Belum ada data fasilitas kost.</p>
                </div>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="table-footer">
    <?= $this->include('Pager/showing') ?>
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
