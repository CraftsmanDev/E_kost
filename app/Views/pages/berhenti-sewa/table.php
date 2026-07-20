<?php $role = session()->get('role'); ?>
<table class="table">
<thead>
<tr>
    <th style="width: 60px;">No</th>
    <th>Penyewa</th>
    <th>Kost</th>
    <th>Tanggal Berhenti</th>
    <th>Alasan</th>
    <th>Status</th>
    <th style="width: 120px;">Aksi</th>
</tr>
</thead>
<tbody>
<?php if (!empty($data_pengajuan)): ?>
<?php
    $page = $pager->getCurrentPage();
    $perPage = $pager->getPerPage();
    $no = 1 + (($page - 1) * $perPage);
    foreach ($data_pengajuan as $row):
        ?>
<tr>
    <td>
        <span class="table-no"><?= $no++ ?></span>
    </td>
    <td>
        <div class="table-cell">
            <div class="table-cell-content">
                <span class="table-cell-title"><?= esc($row['nama']) ?></span>
                <span class="table-cell-subtitle"><?= esc($row['no_hp']) ?></span>
            </div>
        </div>
    </td>
    <td>
        <span class="table-cell-title"><?= esc($row['nama_kost']) ?></span>
    </td>
    <td>
        <span class="table-cell-subtitle"><?= date('d M Y', strtotime($row['tanggal_berhenti'])) ?></span>
    </td>
    <td>
        <span class="table-cell-subtitle"><?= esc($row['alasan']) ?></span>
    </td>
    <td>
    <?php if ($row['status_pengajuan'] == "Menunggu"): ?>
        <span class="table-badge table-badge-warning">
        Menunggu
        </span>
    <?php elseif ($row['status_pengajuan'] == "Disetujui"): ?>
        <span class="table-badge table-badge-success">
        Disetujui
        </span>
    <?php else: ?>
        <span class="table-badge table-badge-danger">
        Ditolak
        </span>
    <?php endif; ?>
    </td>
    <td>
        <div class="table-actions">
            <a href="<?= base_url('dashboard/pengajuan-berhenti/detail/'.$row['id_pengajuan']) ?>" class="btn-table btn-table-info" title="Detail">
                <i class="ti ti-eye"></i>
            </a>
            <?php if ($role == 'admin'): ?>
                <?php if ($row['status_pengajuan'] == "Menunggu"): ?>
                    <a href="<?= base_url('dashboard/pengajuan-berhenti/approve/'.$row['id_pengajuan']) ?>"
                    class="btn-table btn-table-success approve-btn"
                    data-message="Apakah Anda yakin ingin menyetujui pengajuan berhenti sewa ini?"
                    title="Setujui">
                        <i class="ti ti-check"></i>
                    </a>
                    <a href="<?= base_url('dashboard/pengajuan-berhenti/reject/'.$row['id_pengajuan']) ?>"
                    class="btn-table btn-table-danger reject-btn"
                    data-message="Apakah Anda yakin ingin menolak pengajuan berhenti sewa ini?"
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
    <td colspan="7">
        <div class="table-empty">
            <i class="ti ti-calendar-off"></i>
            <p>Belum ada pengajuan berhenti sewa.</p>
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
    // Handle approve button clicks with SweetAlert2
    const approveButtons = document.querySelectorAll('.approve-btn');
    approveButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menyetujui ini?';
            const url = this.getAttribute('href');

            showConfirmApprove(message, function() {
                window.location.href = url;
            });
        });
    });

    // Handle reject button clicks with SweetAlert2
    const rejectButtons = document.querySelectorAll('.reject-btn');
    rejectButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menolak ini?';
            const url = this.getAttribute('href');

            showConfirmReject(message, function() {
                window.location.href = url;
            });
        });
    });
});
</script>