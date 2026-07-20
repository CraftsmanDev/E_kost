    <section class="hero-section">
        <div class="hero-overlay"></div>
        <img src="<?= base_url('assets/rumah-kost.jpg') ?>" alt="Hero" class="hero-bg">
        <div class="hero-content">
            <h1>Temukan kost terbaik<br>di Mimbaan, Situbondo</h1>
            <p>Pilihan kost nyaman, aman, dan sesuai kebutuhanmu</p>
            <div class="search-bar">
                <i class="ti ti-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Cari kost di Mimbaan, Situbondo...">
                <button class="btn-cari" id="btnSearch">Cari</button>
            </div>
        </div>
    </section>
    <div class="filter-bar">
        <div class="filter-left">
            <div class="filter-select" id="hargaFilter">
                <span>Harga</span><i class="ti ti-chevron-down"></i>
                <div class="filter-dropdown" id="hargaDropdown">
                    <div class="price-range">
                        <input type="number" id="minHarga" placeholder="<?= !empty($filterData['price_range']['min_price']) ? 'Min: Rp ' . number_format($filterData['price_range']['min_price'], 0, ',', '.') : 'Min Harga' ?>" min="0">
                        <input type="number" id="maxHarga" placeholder="<?= !empty($filterData['price_range']['max_price']) ? 'Max: Rp ' . number_format($filterData['price_range']['max_price'], 0, ',', '.') : 'Max Harga' ?>" min="0">
                        <button type="button" class="btn-apply-price">Terapkan</button>
                    </div>
                </div>
            </div>
            <div class="filter-select" id="tipeFilter">
                <span>Tipe Kost</span><i class="ti ti-chevron-down"></i>
                <div class="filter-dropdown" id="tipeDropdown">
                    <select id="typeKostSelect" class="dynamic-select">
                        <option value="">Semua Tipe</option>
                       <?php if (!empty($filterData['types'])): ?>
                            <?php foreach ($filterData['types'] as $type): ?>
                                <option value="<?= esc($type['type_kost']) ?>">
                                    <?= esc($type['type_kost']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="filter-select" id="fasilitasFilter">
                <span>Fasilitas</span><i class="ti ti-chevron-down"></i>
                <div class="filter-dropdown" id="fasilitasDropdown">
                    <div id="fasilitasCheckboxes">
                        <?php if (!empty($filterData['fasilitas'])): ?>
                        <?php foreach ($filterData['fasilitas'] as $fas): ?>
                            <label>
                                <input type="checkbox" value="<?= esc($fas['id_fasilitas_kost']) ?>">
                                <?= esc($fas['nama_fasilitas']) ?>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <button type="button" class="btn-apply-fasilitas">Terapkan</button>
                </div>
            </div>
        </div>
        <button class="btn-reset" id="btnReset">
            <i class="ti ti-refresh"></i> Reset Filter
        </button>
    </div>
    <div class="content-area">
        <div class="kost-list" id="kostList">
            <div>
                <?php if (!empty($kostPopuler)): ?>
                <?php foreach ($kostPopuler as $kost): ?>
                <div class="kost-card" data-id="<?= $kost['id_kost'] ?>">
                    <div class="kost-img">
                        <?php if (!empty($kost['foto_kost'])): ?>
                            <img src="<?= base_url('uploads/kost/'.$kost['foto_kost']) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="kost-info">
                        <div class="kost-meta">
                            <h3><?= esc($kost['nama_kost']) ?></h3>
                            <div class="kost-rating">
                                <i class="ti ti-door"></i>
                                <strong><?= $kost['kamar_tersedia'] ?></strong>
                                <span>dari <?= $kost['total_kamar'] ?> kamar</span>
                            </div>
                        </div>
                        <p class="kost-alamat">
                            <i class="ti ti-map-pin"></i>
                            <?= esc($kost['alamat_kost']) ?>
                        </p>
                        <p class="kost-harga">
                            Rp <?= number_format($kost['harga'], 0, ',', '.') ?>
                            <span>/ bulan</span>
                        </p>
                        <a href="<?= base_url('dashboard/kost/detail/'.$kost['id_kost']) ?>" class="btn-detail">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="ti ti-building-off"></i>
                        <p>Belum ada kost tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="show-all-container" id="showAllContainer">
                <button class="btn-show-all" id="btnShowAll">Tampilkan Semua</button>
            </div>
        </div>
        <div class="peta-section">
            <div class="cara-penggunaan">
                <div class="cara-header">
                    <i class="ti ti-info-circle"></i>
                    <h4>Cara Menggunakan</h4>
                </div>

                <ol class="cara-list">
                    <li>Geser atau zoom peta ke area yang ingin dicari.</li>
                    <li>Gunakan filter jika diperlukan (harga, tipe, atau fasilitas).</li>
                    <li>Klik <strong>"Cari di Area Ini"</strong>.</li>
                    <li>Daftar kost akan diperbarui sesuai area peta yang dipilih.</li>
                </ol>

                <div class="cara-catatan">
                    <i class="ti ti-alert-circle"></i>
                    <span><strong>Catatan:</strong> Semakin spesifik area peta, semakin akurat hasil pencarian.</span>
                </div>
            </div>
            <div class="peta-panel">
                <div class="section-head">
                    <h2>Kost di Peta Mimbaan</h2>
                    <a href="#">Lihat Semua di Peta <i class="ti ti-arrow-right"></i></a>
                </div>
                <div class="peta-container" id="map"></div>
                <button class="btn-cari-area" id="btnCariArea">
                    <i class="ti ti-map-pin"></i> Cari di area ini
                </button>
            </div>
        </div>
    </div>
    <div class="fitur-grid">
        <div class="fitur-card">
            <div class="fitur-icon blue"><i class="ti ti-building"></i></div>
            <div>
                <strong>Banyak Pilihan Kost</strong>
                <span>Ratusan kost terverifikasi di Mimbaan</span>
            </div>
        </div>
        <div class="fitur-card">
            <div class="fitur-icon green"><i class="ti ti-cash"></i></div>
            <div>
                <strong>Harga Terbaik</strong>
                <span>Sesuaikan budget kebutuhanmu</span>
            </div>
        </div>
        <div class="fitur-card">
            <div class="fitur-icon amber"><i class="ti ti-map-pin"></i></div>
            <div>
                <strong>Lokasi Strategis</strong>
                <span>Dekat kampus, pasar, dan fasilitas umum</span>
            </div>
        </div>
        <div class="fitur-card">
            <div class="fitur-icon teal"><i class="ti ti-shield-check"></i></div>
            <div>
                <strong>Aman & Terpercaya</strong>
                <span>Kost terverifikasi untuk kenyamananmu</span>
            </div>
        </div>
    </div>
<script>
    function formatRupiah(angka) {
                return angka.replace(/\D/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function setupRupiahInput(id) {
                const input = document.getElementById(id);

                input.addEventListener('input', function (e) {
                    let value = this.value;

                    this.value = formatRupiah(value);
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                setupRupiahInput('minHarga');
                setupRupiahInput('maxHarga');
            });
    document.addEventListener('DOMContentLoaded', function () {
        let map;
        let markers = [];
        let currentFilters = {
            keyword: '',
            type_kost: '',
            min_harga: null,
            max_harga: null,
            fasilitas: [],
            show_all: false
        };

        const BASE_URL = '<?= base_url() ?>';
        
        function initMap() {
           const osm = L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution: '&copy; OpenStreetMap'
                }
            );

            const satellite = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                {
                    attribution: '&copy; Esri'
                }
            );

            map = L.map('map', {
                center: [-7.706, 113.999],
                zoom: 14,
                layers: [satellite] // default satelit
            });

            L.control.layers(
                {
                    "Peta": osm,
                    "Satelit": satellite
                }
            ).addTo(map);

            const kostData = <?= json_encode($mapKost ?? []) ?>;
            addMarkersToMap(kostData);
        }

        function addMarkersToMap(kostData) {
            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            kostData.forEach(function (kost) {
                if (kost.latitude && kost.longitude) {
                    const marker = L.marker([kost.latitude, kost.longitude])
                        .addTo(map)
                        .bindPopup('<strong>' + kost.nama_kost + '</strong><br>' + kost.alamat_kost);
                    markers.push(marker);
                }
            });
        }

        // Filter dropdown toggles
        const hargaFilter = document.getElementById('hargaFilter');
        const tipeFilter = document.getElementById('tipeFilter');
        const fasilitasFilter = document.getElementById('fasilitasFilter');

        if (hargaFilter) {
            hargaFilter.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown('hargaDropdown');
            });
        }

        if (tipeFilter) {
            tipeFilter.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown('tipeDropdown');
            });
        }

        if (fasilitasFilter) {
            fasilitasFilter.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown('fasilitasDropdown');
            });
        }

        // Toggle dropdown with position adjustment
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (!dropdown) return;

            const allDropdowns = document.querySelectorAll('.filter-dropdown');

            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== dropdownId) {
                    dd.classList.remove('show');
                    dd.classList.remove('right-align');
                }
            });


            // Toggle current dropdown
            const isShowing = dropdown.classList.contains('show');

            if (!isShowing) {
                dropdown.classList.add('show');

                // Check if dropdown would overflow right edge
                setTimeout(() => {
                    const rect = dropdown.getBoundingClientRect();
                    const windowWidth = window.innerWidth;

                    if (rect.right > windowWidth) {
                        dropdown.classList.add('right-align');
                    }
                }, 0);
            } else {
                dropdown.classList.remove('show');
                dropdown.classList.remove('right-align');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
                dropdown.classList.remove('right-align');
            });
        });

        // Prevent dropdown close when clicking inside
        document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Type filter select change
        const typeKostSelect = document.getElementById('typeKostSelect');
        if (typeKostSelect) {
            typeKostSelect.addEventListener('change', function() {
                currentFilters.type_kost = this.value;
                applyFilters();
            });
        }

        // Price filter
        const btnApplyPrice = document.querySelector('.btn-apply-price');
        if (btnApplyPrice) {
            btnApplyPrice.addEventListener('click', function() {
                const minHarga = document.getElementById('minHarga');
                const maxHarga = document.getElementById('maxHarga');
                currentFilters.min_harga = minHarga.value.replace(/\./g, '');
                currentFilters.max_harga = maxHarga.value.replace(/\./g, '');
                applyFilters();

                const hargaDropdown = document.getElementById('hargaDropdown');
                if (hargaDropdown) {
                    hargaDropdown.classList.remove('show');
                    hargaDropdown.classList.remove('right-align');
                }
            });
        }

        // Facilities filter
        const btnApplyFasilitas = document.querySelector('.btn-apply-fasilitas');
        if (btnApplyFasilitas) {
            btnApplyFasilitas.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('#fasilitasCheckboxes input[type="checkbox"]:checked');
                currentFilters.fasilitas = Array.from(checkboxes).map(cb => cb.value);
                applyFilters();

                const fasilitasDropdown = document.getElementById('fasilitasDropdown');
                if (fasilitasDropdown) {
                    fasilitasDropdown.classList.remove('show');
                    fasilitasDropdown.classList.remove('right-align');
                }
            });
        }

        // Search functionality
        const btnSearch = document.getElementById('btnSearch');
        const searchInput = document.getElementById('searchInput');

        if (btnSearch && searchInput) {
            btnSearch.addEventListener('click', function() {
                currentFilters.keyword = searchInput.value;
                applyFilters();
            });
        }

        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    currentFilters.keyword = this.value;
                    applyFilters();
                }
            });
        }

        // Reset filters
        const btnReset = document.getElementById('btnReset');
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                currentFilters = {
                    keyword: '',
                    type_kost: '',
                    min_harga: null,
                    max_harga: null,
                    fasilitas: [],
                    show_all: false
                };

                // Reset UI
                if (searchInput) searchInput.value = '';
                const minHarga = document.getElementById('minHarga');
                const maxHarga = document.getElementById('maxHarga');
                if (minHarga) minHarga.value = '';
                if (maxHarga) maxHarga.value = '';
                if (typeKostSelect) typeKostSelect.value = '';
                document.querySelectorAll('#fasilitasCheckboxes input[type="checkbox"]').forEach(cb => {
                    cb.checked = false;
                });

                applyFilters();
            });
        }

        // Show all functionality
        const btnShowAll = document.getElementById('btnShowAll');
        if (btnShowAll) {
            btnShowAll.addEventListener('click', function() {
                currentFilters.show_all = true;
                applyFilters();
                if (this) {
                    this.style.display = 'none';
                }
            });
        }

        const btnCariArea = document.getElementById('btnCariArea');
        btnCariArea.addEventListener('click', function () {
            searchByLocation();
        });

        function applyFilters() {
            const params = new URLSearchParams();
            if (currentFilters.keyword) params.append('keyword', currentFilters.keyword);
            if (currentFilters.type_kost) params.append('type_kost', currentFilters.type_kost);
            if (currentFilters.min_harga) params.append('min_harga', currentFilters.min_harga);
            if (currentFilters.max_harga) params.append('max_harga', currentFilters.max_harga);
            if (currentFilters.fasilitas.length > 0) params.append('fasilitas', currentFilters.fasilitas.join(','));
            if (!currentFilters.show_all) params.append('limit', 5);
            params.append('show_all', currentFilters.show_all);

            const kostList = document.getElementById('kostList');
            if (!kostList) return;

            kostList.innerHTML = '<div class="loading">Memuat data...</div>';

            fetch('<?= base_url('dashboard/search-kost') ?>?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        renderKostList(data.data);
                        const showAllBtn = document.getElementById('btnShowAll');
                        if (showAllBtn) {
                            if (currentFilters.show_all || data.data.length <= 5) {
                                showAllBtn.style.display = 'none';
                            } else {
                                showAllBtn.style.display = 'inline-block';
                            }
                        }
                    } else {
                        kostList.innerHTML = '<div class="empty-state"><i class="ti ti-building-off"></i><p>Gagal memuat data</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    kostList.innerHTML = '<div class="empty-state"><i class="ti ti-building-off"></i><p>Terjadi kesalahan</p></div>';
                });
        }

        function searchByLocation() {

            const bounds = map.getBounds();

            const params = new URLSearchParams();
            params.append('lat', map.getCenter().lat);
            params.append('lng', map.getCenter().lng);
            params.append('radius', 5);
            params.append('north', bounds.getNorth());
            params.append('south', bounds.getSouth());
            params.append('east', bounds.getEast());
            params.append('west', bounds.getWest());
            if (currentFilters.keyword)
                params.append('keyword', currentFilters.keyword);

            if (currentFilters.type_kost)
                params.append('type_kost', currentFilters.type_kost);

            if (currentFilters.min_harga)
                params.append('min_harga', currentFilters.min_harga.replace(/\./g,''));

            if (currentFilters.max_harga)
                params.append('max_harga', currentFilters.max_harga.replace(/\./g,''));

            if (currentFilters.fasilitas.length > 0)
                params.append('fasilitas', currentFilters.fasilitas.join(','));

            console.log("=== Cari Area ===");
            console.log(bounds);

            const kostList = document.getElementById('kostList');
            kostList.innerHTML = '<div class="loading">Mencari di area ini...</div>';
        const url = `${BASE_URL}/dashboard/search-kost-location?${params.toString()}`;
        fetch(url)
                .then(res => {
                    console.log('Response status:', res.status);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    if(data.status === "success"){

                        renderKostList(data.data);

                        addMarkersToMap(data.data);

                    }else{

                        kostList.innerHTML =
                            '<div class="empty-state">Tidak ada kost pada area ini</div>';

                    }
                })
                .catch(err=>{
                    console.error('Error:', err);
                    kostList.innerHTML = '<div class="empty-state"><i class="ti ti-alert-circle"></i><p>Terjadi kesalahan: ' + err.message + '</p></div>';
                });
        }

        function addMarkersToMap(kostData) {
            markers.forEach(m => map.removeLayer(m));
            markers = [];
            kostData.forEach(kost => {
                if (kost.latitude && kost.longitude) {
                    const marker = L.marker([kost.latitude, kost.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <b>${kost.nama_kost}</b><br>
                            ${kost.alamat_kost}
                        `);

                    markers.push(marker);
                }
            });
        }
        
        function renderKostList(kostData) {
            const kostList = document.getElementById('kostList');
            if (!kostList) return;

            if (!kostData || kostData.length === 0) {
                kostList.innerHTML = '<div class="empty-state"><i class="ti ti-building-off"></i><p>Tidak ada kost yang sesuai dengan filter</p></div>';
                return;
            }

            let html = '';
            kostData.forEach(function(kost) {
                html += `
                <div class="kost-card" data-id="${kost.id_kost}">
                    <div class="kost-img">
                        ${kost.foto_kost ? `<img src="${baseUrl('uploads/kost/' + kost.foto_kost)}">` : ''}
                        <button class="btn-fav">
                            <i class="ti ti-heart"></i>
                        </button>
                    </div>
                    <div class="kost-info">
                        <div class="kost-meta">
                            <h3>${escapeHtml(kost.nama_kost)}</h3>
                            <div class="kost-rating">
                                <i class="ti ti-door"></i>
                                <strong>${kost.kamar_tersedia}</strong>
                                <span>dari ${kost.total_kamar} kamar</span>
                            </div>
                        </div>
                        <p class="kost-alamat">
                            <i class="ti ti-map-pin"></i>
                            ${escapeHtml(kost.alamat_kost)}
                        </p>
                        <p class="kost-harga">
                            Rp ${numberFormat(kost.harga)}
                            <span>/ bulan</span>
                        </p>
                        <a href="${baseUrl('dashboard/kost/detail/' + kost.id_kost)}" class="btn-detail">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                `;
            });

            kostList.innerHTML = html;
        }

        // Helper functions
        function baseUrl(path) {
            return '<?= base_url('') ?>' + path;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function numberFormat(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Handle window resize to adjust dropdown positions
        window.addEventListener('resize', function() {
            document.querySelectorAll('.filter-dropdown.show').forEach(dropdown => {
                const rect = dropdown.getBoundingClientRect();
                const windowWidth = window.innerWidth;

                if (rect.right > windowWidth) {
                    dropdown.classList.add('right-align');
                } else {
                    dropdown.classList.remove('right-align');
                }
            });
        });

        const mapElement = document.getElementById('map');
        if (mapElement) {
            initMap();
        }
    });
</script>