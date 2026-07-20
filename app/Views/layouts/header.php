<header class="topbar">
    <button class="menu-toggle"><i class="ti ti-menu-2"></i></button>
        <div class="topbar-right">
            <?= view('components/notifikasi') ?>
            <div class="user-info">
                <?php
                $userPhoto = session()->get('foto');
            if (!empty($userPhoto)): ?>
                    <img src="<?= base_url('uploads/profile/' . $userPhoto) ?>" alt="User" class="user-avatar">
                <?php else: ?>
                    <img src="<?= base_url('assets/icon-profile.png') ?>" alt="User" class="user-avatar">
                <?php endif; ?>
                <span>Halo, <?= session()->get('username') ?? 'Ahmad' ?></span>
            </div>
        </div>
</header>