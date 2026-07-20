<table class="table">
    <thead>
        <tr>
            <th style="width: 60px;">No</th>
            <th>Penyewa</th>
            <th>Kontak</th>
            <th>Kost</th>
            <th>Alamat</th>
            <th>Kamar</th>
            <th>Harga Sewa</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data_penghuni)): ?>
        <?php $page = $pager->getCurrentPage();
            $perPage = $pager->getPerPage();
            $no = 1 + (($page - 1) * $perPage);
            foreach ($data_penghuni as $row): ?>
            <tr>
                <td>
                    <span class="table-no"><?= $no++ ?></span>
                </td>
                <td>
                    <span class="table-cell-title"><?= esc($row['nama']) ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle"><?= esc($row['no_hp'] ?? '-') ?></span>
                </td>
                <td>
                    <span class="table-cell-title"><?= esc($row['nama_kost']) ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle"><?= esc($row['alamat_kost'] ?? '-') ?></span>
                </td>
                <td>
                    <div class="table-cell-content">
                        <span class="table-cell-title"><?= esc($row['nomor_kamar'] ?? '-') ?></span>
                        <span class="table-cell-subtitle"><?= esc($row['nama_tipe_kamar'] ?? '-') ?></span>
                    </div>
                </td>
                <td>
                    <span class="kost-price">Rp <?= number_format($row['harga_sewa'] ?? 0, 0, ',', '.') ?></span>
                </td>
                <td>
                    <span class="table-cell-subtitle"><?= !empty($row['tanggal_pemesanan']) ? date('d M Y', strtotime($row['tanggal_pemesanan'])) : '-' ?></span>
                </td>
                <td>
                    <?php
                    $status = $row['status_pemesanan'] ?? 'Menunggu';
                if ($status == "Disetujui"): ?>
                        <span class="table-badge table-badge-success">
                            Aktif
                        </span>
                    <?php elseif ($status == "Berhenti Sewa"): ?>
                        <span class="table-badge table-badge-warning">
                            Berhenti Sewa
                        </span>
                    <?php else: ?>
                        <span class="table-badge table-badge-danger">
                            <?= esc($status) ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">
                    <div class="table-empty">
                        <i class="ti ti-users"></i>
                        <p>Belum ada data penyewa.</p>
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