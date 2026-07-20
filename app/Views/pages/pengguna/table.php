<?php $role = session()->get('role'); ?>
<table class="table">
<thead>
<tr>
    <th style="width: 60px;">No</th>
    <th>Pengguna</th>
    <th>Username</th>
    <th>Role</th>
    <th>No HP</th>
    <th>Status</th>
    <th style="width: 120px;">Aksi</th>
</tr>
</thead>
<tbody>
<?php if (!empty($data_pengguna)): ?>
<?php
    $currentPage = service('request')->getGet('page') ?? 1;
    $perPage = $pager->getPerPage();
    $no = ($currentPage - 1) * $perPage + 1;
    foreach ($data_pengguna as $row):
        ?>
<tr>
    <td>
        <span class="table-no"><?= $no++ ?></span>
    </td>
    <td>
        <div class="table-cell">
            <img src="<?= base_url('assets/'.$row['foto']) ?>" alt="" class="table-cell-img">
            <div class="table-cell-content">
                <span class="table-cell-title"><?= $row['nama'] ?></span>
                <span class="table-cell-subtitle">ID #<?= $row['id_user'] ?></span>
            </div>
        </div>
    </td>
    <td>
        <span class="table-cell-subtitle"><?= $row['username'] ?></span>
    </td>
    <td>
        <?php
                if ($row['role_id'] == 1) {
                    echo '<span class="table-badge table-badge-primary">Admin</span>';
                } elseif ($row['role_id'] == 2) {
                    echo '<span class="table-badge table-badge-warning">Pemilik</span>';
                } else {
                    echo '<span class="table-badge table-badge-success">Konsumen</span>';
                }
        ?>
    </td>
    <td>
        <span class="table-cell-subtitle"><?= $row['no_hp'] ?></span>
    </td>
    <td>
        <?php if ($row['status'] == "Aktif"): ?>
            <span class="table-badge table-badge-success">
            Aktif
            </span>
        <?php else: ?>
            <span class="table-badge table-badge-danger">
            Nonaktif
            </span>
        <?php endif; ?>
    </td>
    <td>
        <div class="table-actions">
            <?php if ($role == 'admin'): ?>
            <a href="<?= base_url('dashboard/pengguna/detail/'.$row['id_user']) ?>" class="btn-table btn-table-info" title="Detail">
                <i class="ti ti-eye"></i>
            </a>
            <a href="<?= base_url('dashboard/pengguna/edit/'.$row['id_user']) ?>" class="btn-table btn-table-warning" title="Edit">
                <i class="ti ti-edit"></i>
            </a>
            <?php if ($row['id_user'] != session()->get('user_id')): ?>
            <a href="<?= base_url('dashboard/pengguna/hapus/'.$row['id_user']) ?>" class="btn-table btn-table-danger delete-btn" title="Hapus" data-nama="<?= esc($row['nama']) ?>">
                <i class="ti ti-trash"></i>
            </a>
            <?php if ($row['status'] == 'Aktif'): ?>
            <a href="<?= base_url('dashboard/pengguna/toggle-status/'.$row['id_user']) ?>" class="btn-table btn-table-secondary toggle-status-btn" title="Nonaktifkan" data-nama="<?= esc($row['nama']) ?>" data-status="nonaktif">
                <i class="ti ti-player-pause"></i>
            </a>
            <?php else: ?>
            <a href="<?= base_url('dashboard/pengguna/toggle-status/'.$row['id_user']) ?>" class="btn-table btn-table-success toggle-status-btn" title="Aktifkan" data-nama="<?= esc($row['nama']) ?>" data-status="aktif">
                <i class="ti ti-player-play"></i>
            </a>
            <?php endif; ?>
            <?php endif; ?>
            <?php else: ?>
            <a href="<?= base_url('dashboard/pengguna/detail/'.$row['id_user']) ?>" class="btn-table btn-table-info" title="Detail">
                <i class="ti ti-eye"></i>
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
        <p>Belum ada data pengguna.</p>
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
