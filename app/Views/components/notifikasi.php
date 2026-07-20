<div class="notif-btn" id="notifBtn">
    <i class="ti ti-bell"></i>
    <span class="notif-badge" id="notifBadge">0</span>
    <div class="notif-popup" id="notifPopup">
        <div class="notif-header">
            <h4>Notifikasi</h4>
            <div class="notif-header-actions">
                <span class="notif-count" id="headerNotifCount">0 Baru</span>
                <button class="mark-all-read" id="markAllReadBtn">
                    <i class="ti ti-check"></i> Tandai Semua
                </button>
            </div>
        </div>
        <div class="notif-list" id="notifList">
            <div class="notif-loading">
                <i class="ti ti-loader"></i> Memuat notifikasi...
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notifBtn = document.getElementById('notifBtn');
    const notifPopup = document.getElementById('notifPopup');
    const notifList = document.getElementById('notifList');
    const notifBadge = document.getElementById('notifBadge');
    const headerNotifCount = document.getElementById('headerNotifCount');
    const markAllReadBtn = document.getElementById('markAllReadBtn');

    if (notifBtn && notifPopup) {
        loadNotifications();
        loadUnreadCount();

        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifPopup.classList.toggle('active');

            if (notifPopup.classList.contains('active')) {
                loadNotifications();
            }
        });

        document.addEventListener('click', function(e) {
            if (!notifBtn.contains(e.target) && !notifPopup.contains(e.target)) {
                notifPopup.classList.remove('active');
            }
        });

        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                markAllAsRead();
            });
        }

        setInterval(function() {
            loadUnreadCount();
        }, 30000);
    }

    function loadNotifications() {
        notifList.innerHTML = `
            <div class="notif-loading">
                <i class="ti ti-loader"></i> Memuat notifikasi...
            </div>
        `;

        fetch(BASE_URL + 'dashboard/notifikasi/get?limit=8')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success' && data.data && data.data.length > 0) {
                    renderNotifications(data.data);
                } else {
                    notifList.innerHTML = `
                        <div class="notif-empty">
                            <i class="ti ti-bell-off"></i>
                            <p>Tidak ada notifikasi</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                notifList.innerHTML = `
                    <div class="notif-error">
                        <i class="ti ti-alert-circle"></i>
                        <p>Gagal memuat notifikasi</p>
                    </div>
                `;
            });
    }

    function renderNotifications(notifications) {
        notifList.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            notifList.innerHTML = `
                <div class="notif-empty">
                    <i class="ti ti-bell-off"></i>
                    <p>Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }

        notifications.forEach(notif => {
            const item = document.createElement('div');
            item.className = 'notif-item' + (notif.status_baca ? '' : ' unread');
            item.dataset.id = notif.id_notifikasi;

            const iconClass = getIconClass(notif.tipe);
            const iconStyle = getIconStyle(notif.tipe);

            item.innerHTML = `
                <div class="notif-icon" style="${iconStyle}">
                    <i class="ti ${iconClass}"></i>
                </div>
                <div class="notif-content">
                    <p>${escapeHtml(notif.judul || 'Notifikasi')}</p>
                    <span class="notif-time">
                        <i class="ti ti-clock"></i>
                        ${escapeHtml(notif.relative_time || 'Baru saja')}
                    </span>
                </div>
            `;

            item.addEventListener('click', function() {
                if (notif.link) {
                    // Mark as read and update UI immediately
                    markAsReadAndUpdate(notif.id_notifikasi);

                    const url = notif.link.startsWith('http')
                        ? notif.link
                        : BASE_URL.replace(/\/$/, '') + '/' + notif.link.replace(/^\//, '');

                    window.location.href = url;
                }
            });

            notifList.appendChild(item);
        });
    }

    function loadUnreadCount() {
        fetch(BASE_URL + 'dashboard/notifikasi/unread-count')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success' && typeof data.count !== 'undefined') {
                    updateUnreadCount(data.count);
                } else {
                    updateUnreadCount(0);
                }
            })
            .catch(error => {
                console.error('Error loading unread count:', error);
                updateUnreadCount(0);
            });
    }

    function updateUnreadCount(count) {
        if (count > 0) {
            notifBadge.style.display = 'flex';
            notifBadge.textContent = count > 99 ? '99+' : count;
            headerNotifCount.textContent = count + ' Baru';

            if (!notifBtn.classList.contains('bell-animation')) {
                notifBtn.classList.add('bell-animation');

                setTimeout(() => {
                    notifBtn.classList.remove('bell-animation');
                }, 500);
            }
        } else {
            notifBadge.style.display = 'none';
            headerNotifCount.textContent = '0 Baru';
        }

        // Also hide the header count badge when no unread notifications
        const headerCountBadge = document.querySelector('.notif-count');
        if (headerCountBadge) {
            if (count > 0) {
                headerCountBadge.style.display = 'inline-flex';
                headerCountBadge.textContent = count + ' Baru';
            } else {
                headerCountBadge.style.display = 'none';
            }
        }
    }

    function markAsRead(id) {
        fetch(BASE_URL + 'dashboard/notifikasi/mark-read/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const item = document.querySelector(`.notif-item[data-id="${id}"]`);

                if (item) {
                    item.classList.remove('unread');
                }

                loadUnreadCount();
            }
        })
        .catch(error => {
            console.error('Error marking as read:', error);
        });
    }

    function markAsReadAndUpdate(id) {
        // Immediately update UI for better UX
        const item = document.querySelector(`.notif-item[data-id="${id}"]`);
        if (item) {
            item.classList.remove('unread');
        }

        // Get current count and decrement immediately
        const currentCount = parseInt(notifBadge.textContent) || 0;
        if (currentCount > 0) {
            updateUnreadCount(currentCount - 1);
        }

        // Then make the API call to mark as read on server
        fetch(BASE_URL + 'dashboard/notifikasi/mark-read/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Refresh count from server to ensure accuracy
                loadUnreadCount();
            }
        })
        .catch(error => {
            console.error('Error marking as read:', error);
            // Revert UI update on error
            if (item) {
                item.classList.add('unread');
            }
            loadUnreadCount();
        });
    }

    function markAllAsRead() {
        fetch(BASE_URL + 'dashboard/notifikasi/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                document.querySelectorAll('.notif-item.unread')
                    .forEach(item => item.classList.remove('unread'));

                // Immediately update UI to 0 for better UX
                updateUnreadCount(0);

                // Then refresh from server to ensure accuracy
                loadUnreadCount();
            }
        })
        .catch(error => {
            console.error('Error marking all as read:', error);
        });
    }

    function getIconClass(tipe) {
        const icons = {
            user: 'ti-user-plus',
            booking: 'ti-file-description',
            payment: 'ti-credit-card',
            tenant: 'ti-users',
            system: 'ti-settings',
            activity: 'ti-activity',
            success: 'ti-check',
            info: 'ti-info-circle',
            warning: 'ti-alert-triangle',
            error: 'ti-alert-circle'
        };

        return icons[tipe] || 'ti-bell';
    }

    function getIconStyle(tipe) {
        const styles = {
            user: 'background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#185FA5;',
            booking: 'background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;',
            payment: 'background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;',
            tenant: 'background:linear-gradient(135deg,#e0e7ff,#c7d2fe);color:#4f46e5;',
            system: 'background:linear-gradient(135deg,#f3f4f6,#e5e7eb);color:#4b5563;',
            activity: 'background:linear-gradient(135deg,#fce7f3,#fbcfe8);color:#db2777;',
            success: 'background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669;',
            info: 'background:linear-gradient(135deg,#dbeafe,#bfdbfe);color:#185FA5;',
            warning: 'background:linear-gradient(135deg,#fef3c7,#fde68a);color:#d97706;',
            error: 'background:linear-gradient(135deg,#fee2e2,#fecaca);color:#dc2626;'
        };

        return styles[tipe] || 'background:linear-gradient(135deg,#e5e7eb,#d1d5db);color:#4b5563;';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
