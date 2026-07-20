<?= $this->extend('dashboard') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <h1><?= esc($title) ?></h1>
    <div class="header-actions">
        <button class="btn btn-primary" id="markAllReadBtn">
            <i class="ti ti-check"></i> Tandai Semua Sudah Dibaca
        </button>
    </div>
</div>

<div class="content-body">
    <div class="notification-container">
        <?php if (!empty($notifikasi)): ?>
            <div class="notification-list">
                <?php foreach ($notifikasi as $notif): ?>
                    <div class="notification-item <?= $notif['status_baca'] ? 'read' : 'unread' ?>" data-id="<?= $notif['id_notifikasi'] ?>">
                        <div class="notification-icon">
                            <i class="ti <?= getNotificationIcon($notif['tipe']) ?>"></i>
                        </div>
                        <div class="notification-content">
                            <h4><?= esc($notif['judul']) ?></h4>
                            <p><?= esc($notif['pesan']) ?></p>
                            <div class="notification-meta">
                                <span class="notification-time">
                                    <i class="ti ti-clock"></i> 
                                    <?= getRelativeTime($notif['created_at']) ?>
                                </span>
                                <?php if ($notif['link']): ?>
                                    <a href="<?= base_url($notif['link']) ?>" class="notification-link">
                                        <i class="ti ti-arrow-right"></i> Lihat Detail
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="notification-actions">
                            <?php if (!$notif['status_baca']): ?>
                                <button class="btn btn-sm btn-outline mark-read-btn" data-id="<?= $notif['id_notifikasi'] ?>">
                                    <i class="ti ti-check"></i>
                                </button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-outline delete-btn" data-id="<?= $notif['id_notifikasi'] ?>">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (isset($pager) && $pager): ?>
                <div class="pagination">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="notification-empty">
                <i class="ti ti-bell-off"></i>
                <h3>Tidak Ada Notifikasi</h3>
                <p>Anda belum memiliki notifikasi saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read buttons
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.dataset.id;
            markAsRead(id);
        });
    });

    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = this.dataset.id;
            if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                deleteNotification(id);
            }
        });
    });

    // Mark all as read button
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            markAllAsRead();
        });
    }

    // Click on notification item
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            const link = this.querySelector('.notification-link');
            if (link) {
                const id = this.dataset.id;
                markAsRead(id);
                setTimeout(() => {
                    window.location.href = link.href;
                }, 300);
            }
        });
    });

    function markAsRead(id) {
        fetch('<?= base_url('notifikasi/mark-read/') ?>' + id, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const item = document.querySelector(`.notification-item[data-id="${id}"]`);
                if (item) {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    const btn = item.querySelector('.mark-read-btn');
                    if (btn) btn.remove();
                }
            }
        })
        .catch(error => {
            console.error('Error marking as read:', error);
        });
    }

    function markAllAsRead() {
        fetch('<?= base_url('notifikasi/mark-all-read') ?>', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    const btn = item.querySelector('.mark-read-btn');
                    if (btn) btn.remove();
                });
            }
        })
        .catch(error => {
            console.error('Error marking all as read:', error);
        });
    }

    function deleteNotification(id) {
        fetch('<?= base_url('notifikasi/delete/') ?>' + id, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const item = document.querySelector(`.notification-item[data-id="${id}"]`);
                if (item) {
                    item.remove();
                    // Check if no notifications left
                    if (document.querySelectorAll('.notification-item').length === 0) {
                        location.reload();
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
        });
    }
});

function getRelativeTime(datetime) {
    const time = new Date(datetime).getTime();
    const now = new Date().getTime();
    const diff = Math.floor((now - time) / 1000);

    if (diff < 60) return 'Baru saja';
    if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
    if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
    if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
    return new Date(time).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
}
</script>

<style>
.notification-container {
    max-width: 800px;
    margin: 0 auto;
}

.notification-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    transition: all 0.2s;
}

.notification-item:hover {
    border-color: #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
}

.notification-item.unread {
    background: #f0f9ff;
    border-left: 4px solid #3b82f6;
}

.notification-item.read {
    opacity: 0.8;
}

.notification-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    border-radius: 50%;
    flex-shrink: 0;
}

.notification-icon i {
    font-size: 1.5rem;
    color: #6b7280;
}

.notification-content {
    flex: 1;
}

.notification-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.notification-content p {
    margin: 0 0 0.75rem 0;
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
}

.notification-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.notification-time {
    font-size: 0.75rem;
    color: #9ca3af;
}

.notification-link {
    font-size: 0.875rem;
    color: #3b82f6;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.notification-link:hover {
    text-decoration: underline;
}

.notification-actions {
    display: flex;
    gap: 0.5rem;
}

.notification-actions .btn {
    padding: 0.5rem;
    min-width: auto;
}

.notification-empty {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
}

.notification-empty i {
    font-size: 4rem;
    margin-bottom: 1rem;
    display: block;
}

.notification-empty h3 {
    margin: 0 0 0.5rem 0;
    color: #6b7280;
}

.notification-empty p {
    margin: 0;
}
</style>
<?php

function getNotificationIcon($tipe) {
    $icons = [
        'user' => 'ti-user-plus',
        'booking' => 'ti-file-description',
        'payment' => 'ti-credit-card',
        'tenant' => 'ti-users',
        'system' => 'ti-settings',
        'activity' => 'ti-activity',
        'success' => 'ti-check',
        'info' => 'ti-info-circle',
        'warning' => 'ti-alert-triangle',
        'error' => 'ti-alert-circle'
    ];
    return $icons[$tipe] ?? 'ti-bell';
}

function getRelativeTime($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    if ($diff < 60) return 'Baru saja';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';
    return date('d M Y', $time);
}
?>
<?= $this->endSection() ?>
