<?php
$role = session()->get('role');
?>
<table class="table">
    <thead>
    <tr>
        <th style="width: 60px;">No</th>
        <?php if ($role == 'admin' || $role == 'pemilik'): ?>
            <th>Penyewa</th>
        <?php endif; ?>
        <th>Kost</th>
        <th>Nomor Kamar</th>
        <th>Tanggal</th>
        <th>Jumlah Pembayaran</th>
        <th>Bukti</th>
        <th>Status</th>
        <th style="width: 120px;">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($data_pembayaran) && is_array($data_pembayaran)): ?>
    <?php
    $page = $pager->getCurrentPage();
        $perPage = $pager->getPerPage();
        $no = 1 + (($page - 1) * $perPage);
        ?>
    <?php foreach ($data_pembayaran as $row): ?>
    <tr>
        <td><span class="table-no"><?= $no++ ?></span></td>
        <?php if ($role == 'admin' || $role == 'pemilik'): ?>
            <td><span class="table-cell-title"><?= esc($row['nama'] ?? '-') ?></span></td>
        <?php endif; ?>
        <td><span class="table-cell-title"><?= esc($row['nama_kost'] ?? '-') ?></span></td>
        <td><span class="table-cell-subtitle"><?= esc($row['nomor_kamar'] ?? '-') ?></span></td>
        <td>
            <span class="table-cell-subtitle">
                <?php
                    $tp = $row['tanggal_pembayaran'] ?? '';
                    $tpValid = $tp && $tp !== '0000-00-00' && $tp !== '0';
                ?>
                <?= $tpValid ? date('d M Y', strtotime($tp)) : '-' ?>
            </span>
        </td>
        <td>
            <span class="kost-price">
                Rp <?= number_format($row['jumlah_pembayaran'] ?? 0, 0, ',', '.') ?>
            </span>
        </td>
        <td>
            <?php if (!empty($row['bukti_pembayaran'])): ?>
                <a href="<?= base_url('uploads/bukti/'.$row['bukti_pembayaran']) ?>"
                target="_blank"
                class="btn-table btn-table-primary">
                    <i class="ti ti-photo"></i>
                </a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
        <td>
            <?php $status = $row['status_pembayaran'] ?? 'Menunggu';
        if ($status == "Menunggu"): ?>
                <span class="table-badge table-badge-warning">Menunggu</span>
            <?php elseif ($status == "Disetujui"): ?>
                <span class="table-badge table-badge-success">Disetujui</span>
            <?php else: ?>
                <span class="table-badge table-badge-danger">Ditolak</span>
            <?php endif; ?>
        </td>
        <td>
            <div class="table-actions">
                <?php if (!empty($row['id_pembayaran'])): ?>
                        <a href="<?= base_url('dashboard/pembayaran/detail/'.$row['id_pembayaran']) ?>"
                        class="btn-table btn-table-info">
                            <i class="ti ti-eye"></i>
                        </a>
                    <?php endif; ?>
                <?php if ($role == 'admin' || $role == 'pemilik'): ?>
                    <?php if (!empty($row['bukti_pembayaran']) && ($row['status_pembayaran'] ?? '') == 'Menunggu'): ?>
                        <a href="<?= base_url('dashboard/pembayaran/approve/'.$row['id_pembayaran']) ?>"
                        class="btn-table btn-table-success approve-btn"
                        data-message="Apakah Anda yakin ingin menyetujui pembayaran ini?">
                            <i class="ti ti-check"></i>
                        </a>

                        <a href="<?= base_url('dashboard/pembayaran/reject/'.$row['id_pembayaran']) ?>"
                        class="btn-table btn-table-danger reject-btn"
                        data-message="Apakah Anda yakin ingin menolak pembayaran ini?">
                            <i class="ti ti-x"></i>
                        </a>
                    <?php endif; ?>
                <?php elseif ($role == 'konsumen'): ?>
                    <?php if (($row['status_pembayaran'] ?? '') == "Menunggu"): ?>
                        <a href="<?= base_url('dashboard/pembayaran/upload-bukti/'.$row['id_pembayaran']) ?>"
                        class="btn-table btn-table-primary">
                            <i class="ti ti-upload"></i>
                        </a>
                    <?php elseif (($row['status_pembayaran'] ?? '') == "Ditolak"): ?>
                        <a href="<?= base_url('dashboard/pembayaran/upload-bukti/'.$row['id_pembayaran']) ?>"
                        class="btn-table btn-table-warning">
                            <i class="ti ti-upload"></i>
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="<?= ($role == 'admin' || $role == 'pemilik') ? 9 : 8 ?>">
            <div class="table-empty">
                <i class="ti ti-receipt"></i>
                <p>
                    <?= ($role == 'konsumen')
                                    ? 'Belum ada pemesanan yang disetujui.'
                                    : 'Belum ada pembayaran yang perlu diverifikasi.' ?>
                </p>
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
            showConfirmApprove(this.dataset.message, () => {
                window.location.href = this.href;
            });
        });
    });

    document.querySelectorAll('.reject-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            showConfirmReject(this.dataset.message, () => {
                window.location.href = this.href;
            });
        });
    });

});
</script>