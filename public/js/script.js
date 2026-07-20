document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');
    function closeSidebar() {
        if (sidebar && sidebarOverlay) {
            sidebar.classList.remove('visible');
            sidebar.classList.add('hidden');
            sidebarOverlay.classList.remove('active');
        }
    }
    function openSidebar() {
        if (sidebar && sidebarOverlay) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('visible');
            sidebarOverlay.classList.add('active');
        }
    }
    function toggleSidebar() {
        if (sidebar && sidebarOverlay) {
            if (sidebar.classList.contains('visible')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
    }
    function initSidebarState() {
        if (window.innerWidth >= 993) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('visible');
            sidebarOverlay.classList.remove('active');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('visible');
            sidebarOverlay.classList.remove('active');
        }
    }

    if (menuToggle && sidebar && sidebarOverlay) {
        initSidebarState();

        menuToggle.addEventListener('click', toggleSidebar);

        sidebarOverlay.addEventListener('click', closeSidebar);

        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        const navItems = sidebar.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function () {
                if (window.innerWidth < 993) {
                    closeSidebar();
                }
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sidebar.classList.contains('visible')) {
                closeSidebar();
            }
        });
        window.addEventListener('resize', function () {
            initSidebarState();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const logoutLinks = document.querySelectorAll('a[href*="logout"]');
    const loadingOverlay = document.getElementById('logoutLoadingOverlay');

    logoutLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            loadingOverlay.classList.add('active');
            setTimeout(() => {
                window.location.href = this.href;
            }, 500);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const locationCard = document.getElementById('locationCard');
    const locationName = document.getElementById('locationName');

    if (locationCard && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.address) {
                            const city = data.address.city || data.address.town || data.address.village || data.address.suburb || 'Lokasi Tidak Diketahui';
                            const country = data.address.country || '';
                            const locationText = country ? `${city}, ${country}` : city;
                            locationName.textContent = locationText;
                        } else {
                            locationName.textContent = 'Lokasi Terdeteksi';
                        }
                    })
                    .catch(error => {
                        locationName.textContent = 'Lokasi Terdeteksi';
                        locationSubtext.textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                    });
            },
            function (error) {
                locationName.textContent = 'Mimbaan, Situbondo';
                locationSubtext.textContent = 'Gagal mendeteksi lokasi';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        locationName.textContent = 'Mimbaan, Situbondo';
        locationSubtext.textContent = 'Geolocation tidak tersedia';
    }
});