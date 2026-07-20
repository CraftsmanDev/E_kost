<table class="table">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Penyewa</th>
            <th>Kost</th>
            <th>Alamat</th>
            <th>Nomor Kamar</th>
            <th>Tanggal Pembayaran</th>
            <th>Jumlah Pembayaran</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data_pembayaran)): ?>
            <?php
            $page = $pager->getCurrentPage();
            $perPage = $pager->getPerPage();
            $no = 1 + (($page - 1) * $perPage);
            foreach ($data_pembayaran as $row):
                ?>
            <tr>
                <td><span class="table-no"><?= $no++ ?></span></td>
                <td>
                    <span class="table-cell-title"><?= $row['nama'] ?></span>
                    <span class="table-cell-subtitle"><?= $row['no_hp'] ?? '-' ?></span>
                </td>
                <td>
                    <span class="table-cell-title"><?= $row['nama_kost'] ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle"><?= $row['alamat_kost'] ?? '-' ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle"><?= $row['nomor_kamar'] ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle">
                        <?= !empty($row['tanggal_pembayaran']) ? date('d M Y', strtotime($row['tanggal_pembayaran'])) : '-' ?>
                    </span>
                </td>
                <td>
                    <span class="kost-price">
                        Rp <?= number_format($row['jumlah_pembayaran'], 0, ',', '.') ?>
                    </span>
                </td>
                <td>
                    <?php
                        $status = $row['status_pembayaran'] ?? 'Menunggu';
                if ($status == 'Menunggu'): ?>
                        <span class="table-badge table-badge-warning">Menunggu</span>
                    <?php elseif ($status == 'Disetujui'): ?>
                        <span class="table-badge table-badge-success">Disetujui</span>
                    <?php else: ?>
                        <span class="table-badge table-badge-danger">Ditolak</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">
                <div class="table-empty">
                    <i class="ti ti-receipt"></i>
                    <p>Belum ada data pembayaran.</p>
                </div>
            </td>
        </tr>

    <?php endif; ?>

    </tbody>
</table>

<?php if (isset($pager) && $pager !== null): ?>
<div class="table-footer">
    <?= $this->include('Pager/showing')?>
    <?= $pager->links('default', 'custom_pagination') ?>
</div>
<?php endif; ?>