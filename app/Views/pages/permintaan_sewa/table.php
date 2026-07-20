<?php
$role = session()->get('role');
?>
<table class="table">
<thead>
<tr>
    <th style="width: 60px;">No</th>
    <th>Penyewa</th>
    <th>Kost</th>
    <th>Tanggal Pemesanan</th>
    <th>Status</th>
    <th style="width: 120px;">Aksi</th>
</tr>
</thead>

<tbody>
    <?php if (!empty($data_pemesanan) && is_array($data_pemesanan)): ?>
    <?php
        $page = $pager->getCurrentPage();
        $perPage = $pager->getPerPage();
        $no = 1 + (($page - 1) * $perPage);
        foreach ($data_pemesanan as $row): ?>
        <tr>
            <td><span class="table-no"><?= $no++ ?></span></td>

            <td>
                <div class="table-cell">
                    <div class="table-cell-content">
                        <span class="table-cell-title"><?= esc($row['nama'] ?? '-') ?></span>
                        <span class="table-cell-subtitle"><?= esc($row['alamat'] ?? '-') ?></span>
                    </div>
                </div>
            </td>

            <td>
                <div class="table-cell">
                    <div class="table-cell-content">
                        <span class="table-cell-title"><?= esc($row['nama_kost'] ?? '-') ?></span>
                        <span class="table-cell-subtitle">Kamar <?= esc($row['nomor_kamar'] ?? '-') ?></span>
                    </div>
                </div>
            </td>

            <td>
                <span class="table-cell-subtitle">
                    <?= !empty($row['tanggal_pemesanan'])
                            ? date('d M Y', strtotime($row['tanggal_pemesanan']))
                            : '-' ?>
                </span>
            </td>

            <td>
                <?php if (($row['status_pemesanan'] ?? '') == 'Menunggu'): ?>
                    <span class="table-badge table-badge-warning">Menunggu</span>
                <?php elseif (($row['status_pemesanan'] ?? '') == 'Disetujui'): ?>
                    <span class="table-badge table-badge-success">Disetujui</span>
                <?php elseif (($row['status_pemesanan'] ?? '') == 'Berhenti_Sewa'): ?>
                    <span class="table-badge table-badge-warning">Berhenti Sewa</span>
                <?php elseif (($row['status_pemesanan'] ?? '') == 'Ditolak'): ?>
                    <span class="table-badge table-badge-danger">Ditolak</span>
                <?php endif; ?>
            </td>

            <td>
                <div class="table-actions">
                    <a href="<?= base_url('dashboard/permintaan-sewa/detail/'.$row['id_pemesanan']) ?>"
                    class="btn-table btn-table-info"
                    title="Detail">
                        <i class="ti ti-eye"></i>
                    </a>
                    <?php if ($role == 'admin'): ?>
                        <?php if (($row['status_pemesanan'] ?? '') == 'Menunggu'): ?>
                            <a href="<?= base_url('dashboard/permintaan-sewa/approve/'.$row['id_pemesanan']) ?>"
                            class="btn-table btn-table-success approve-btn"
                            data-message="Apakah Anda yakin ingin menyetujui permintaan sewa ini?"
                            title="Setujui">
                                <i class="ti ti-check"></i>
                            </a>

                            <a href="<?= base_url('dashboard/permintaan-sewa/reject/'.$row['id_pemesanan']) ?>"
                            class="btn-table btn-table-danger reject-btn"
                            data-message="Apakah Anda yakin ingin menolak permintaan sewa ini?"
                            title="Tolak">
                                <i class="ti ti-x"></i>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="6">
            <div class="table-empty">
                <i class="ti ti-calendar"></i>
                <p>Belum ada permintaan sewa.</p>
            </div>
        </td>
    </tr>
    <?php endif; ?>
</tbody>
</table>
<?php if (!empty($pager) && is_object($pager)): ?>
<div class="table-footer">
    <?= $this->include('Pager/showing')?>
    <?= $pager->links('default', 'custom_pagination') ?>
</div>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.approve-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.dataset.message || 'Apakah Anda yakin?';
            const url = this.getAttribute('href');

            showConfirmApprove(message, function() {
                window.location.href = url;
            });
        });
    });

    document.querySelectorAll('.reject-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.dataset.message || 'Apakah Anda yakin?';
            const url = this.getAttribute('href');

            showConfirmReject(message, function() {
                window.location.href = url;
            });
        });
    });

});
</script>