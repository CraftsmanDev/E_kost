<?php 
$role = session()->get('role');
?>
<?= $this->extend('dashboard') ?>

<?= $this->section('content') ?>
<?php if ($role == 'konsumen'): ?>
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <img src="<?= base_url('assets/rumah-kost2.jpg') ?>" alt="Hero" class="hero-bg">
        <div class="hero-content">
            <h1>Temukan kost terbaik<br>di Mimbaan, Situbondo</h1>
            <p>Pilihan kost nyaman, aman, dan sesuai kebutuhanmu</p>
            <div class="search-bar">
                <i class="ti ti-search search-icon"></i>
                <input type="text" placeholder="Cari kost di Mimbaan, Situbondo...">
                <button class="btn-cari">Cari</button>
            </div>
        </div>
    </section>
    <div class="filter-bar">
        <div class="filter-left">
            <div class="filter-select">
                <span>Harga</span><i class="ti ti-chevron-down"></i>
            </div>
            <div class="filter-select">
                <span>Tipe Kost</span><i class="ti ti-chevron-down"></i>
            </div>
            <div class="filter-pill active-pill">
                <i class="ti ti-gender-male"></i> Kost Putra
            </div>
            <div class="filter-pill">
                <i class="ti ti-gender-female"></i> Kost Putri
            </div>
            <div class="filter-select">
                <span>Fasilitas</span><i class="ti ti-chevron-down"></i>
            </div>
        </div>
        <button class="btn-reset">
            <i class="ti ti-refresh"></i> Reset Filter
        </button>
    </div>
    <div class="content-area">
        <div class="kost-list">
            <div class="section-head">
                <h2>Rekomendasi Kost Populer</h2>
                <a href="<?= base_url('kost') ?>">Lihat Semua <i class="ti ti-arrow-right"></i></a>
            </div>

            <div class="kost-card">
                <div class="kost-img">
                    <img src="<?= base_url('assets/kost-ARM.jpeg')?>" alt="ARM-KOST">
                    <button class="btn-fav"><i class="ti ti-heart"></i></button>
                </div>
                <div class="kost-info">
                    <div class="kost-meta">
                        <h3>ARM</h3>
                        <div class="kost-rating">
                            <i class="ti ti-star-filled"></i>
                            <strong>4.7</strong>
                            <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi debitis sapiente quaerat.</span>
                        </div>
                    </div>
                    <p class="kost-alamat"><i class="ti ti-map-pin"></i> mimbaan panji situbondo</p>
                    <p class="kost-harga">Rp 300.000 <span>/ bulan</span></p>
                    <div class="kost-fasilitas">
                        <span class="fas-tag">kost murah</span>
                    </div>
                    <a href="" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- PETA -->
        <div class="peta-panel">
            <div class="section-head">
                <h2>Kost di Peta Mimbaan</h2>
                <a href="#">Lihat Semua di Peta <i class="ti ti-arrow-right"></i></a>
            </div>
            <div class="peta-container" id="map"></div>
            <button class="btn-cari-area">
                <i class="ti ti-map-pin"></i> Cari di area ini
            </button>
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
<?php elseif($role == 'admin'):?>
<div class="content">
  <div class="dash">
    <div class="kpi-row">
      <div class="kpi">
        <div class="kpi-icon" style="background:#EAF3DE">
          <i class="ti ti-building-community" style="color:#3B6D11"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Total kost</div>
          <div class="kpi-value">10</div>
          <div class="kpi-delta"><span>+3</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#E6F1FB">
          <i class="ti ti-door" style="color:#185FA5"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Kamar tersedia</div>
          <div class="kpi-value">24</div>
          <div class="kpi-delta"><span>+5</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#FAEEDA">
          <i class="ti ti-users" style="color:#854F0B"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Total konsumen</div>
          <div class="kpi-value">87</div>
          <div class="kpi-delta"><span>+12</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#E1F5EE">
          <i class="ti ti-cash" style="color:#0F6E56"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Pendapatan</div>
          <div class="kpi-value">Rp 42 jt</div>
          <div class="kpi-delta"><span>+8%</span> dari bulan lalu</div>
        </div>
      </div>
    </div>
    <div class="kpi-row-2">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik pendaftaran konsumen</div>
                <select id="rangeSelect">
                <option value="1">1 bulan terakhir</option>
                <option value="3">3 bulan terakhir</option>
                <option value="6" selected>6 bulan terakhir</option>
                <option value="12">12 bulan terakhir</option>
                </select>
            </div>
            <div class="legend">
                <span><i class="legend-dot" style="background:#2a78d6"></i>Pendaftaran baru</span>
                <span><i class="legend-dot" style="background:#1baf7a"></i>Perpanjangan</span>
            </div>
            <div class="chart-wrap">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik pendapatan</div>
                <select id="rangeSelectPendapatan">
                <option value="1">1 bulan terakhir</option>
                <option value="3">3 bulan terakhir</option>
                <option value="6" selected>6 bulan terakhir</option>
                <option value="12">12 bulan terakhir</option>
                </select>
            </div>
            <div class="legend">
                <span><i class="legend-dot" style="background:#f59e0b"></i>Pendapatan (Rp)</span>
            </div>
            <div class="chart-wrap">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="chart-card notif-card">
        <div class="chart-header">
            <div class="chart-title">Notifikasi penting</div>
            <span class="notif-badge">3 baru</span>
        </div>
        <div class="notif-list">
            <div class="notif-item notif-danger">
                <div class="notif-icon"><i class="ti ti-alert-circle"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Pembayaran <strong>Kamar 3A</strong> telah jatuh tempo</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 2 jam lalu</span>
                </div>
            </div>
            <div class="notif-item notif-warning">
                <div class="notif-icon"><i class="ti ti-user-plus"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Permintaan sewa baru dari <strong>Budi Santoso</strong></p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 5 jam lalu</span>
                </div>
            </div>
            <div class="notif-item notif-info">
                <div class="notif-icon"><i class="ti ti-tool"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Laporan kerusakan <strong>Kamar 2B</strong> — AC tidak dingin</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 1 hari lalu</span>
                </div>
            </div>
            <div class="notif-item notif-success">
                <div class="notif-icon"><i class="ti ti-check"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Pembayaran <strong>Kamar 1C</strong> berhasil diterima</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 2 hari lalu</span>
                </div>
            </div>
            <div class="notif-item notif-warning">
                <div class="notif-icon"><i class="ti ti-calendar-x"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Kontrak <strong>Kamar 4D</strong> berakhir dalam 7 hari</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 3 hari lalu</span>
                </div>
            </div>
        </div>
            <a href="#" class="notif-lihat-semua">Lihat semua notifikasi <i class="ti ti-arrow-right"></i></a>
        </div>
    </div>
  </div>

</div>
<?php elseif($role == 'pemilik'): ?>
<div class="content">
  <div class="dash">
    <div class="kpi-row">
      <div class="kpi">
        <div class="kpi-icon" style="background:#EAF3DE">
          <i class="ti ti-building-community" style="color:#3B6D11"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Total kost</div>
          <div class="kpi-value">10</div>
          <div class="kpi-delta"><span>+3</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#E6F1FB">
          <i class="ti ti-door" style="color:#185FA5"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Kamar tersedia</div>
          <div class="kpi-value">24</div>
          <div class="kpi-delta"><span>+5</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#FAEEDA">
          <i class="ti ti-users" style="color:#854F0B"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Total konsumen</div>
          <div class="kpi-value">87</div>
          <div class="kpi-delta"><span>+12</span> dari bulan lalu</div>
        </div>
      </div>
      <div class="kpi">
        <div class="kpi-icon" style="background:#E1F5EE">
          <i class="ti ti-cash" style="color:#0F6E56"></i>
        </div>
        <div class="kpi-body">
          <div class="kpi-label">Pendapatan</div>
          <div class="kpi-value">Rp 42 jt</div>
          <div class="kpi-delta"><span>+8%</span> dari bulan lalu</div>
        </div>
      </div>
    </div>
    <div class="kpi-row-2">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik pendaftaran konsumen</div>
                <select id="rangeSelect">
                <option value="1">1 bulan terakhir</option>
                <option value="3">3 bulan terakhir</option>
                <option value="6" selected>6 bulan terakhir</option>
                <option value="12">12 bulan terakhir</option>
                </select>
            </div>
            <div class="legend">
                <span><i class="legend-dot" style="background:#2a78d6"></i>Pendaftaran baru</span>
                <span><i class="legend-dot" style="background:#1baf7a"></i>Perpanjangan</span>
            </div>
            <div class="chart-wrap">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Grafik pendapatan</div>
                <select id="rangeSelectPendapatan">
                <option value="1">1 bulan terakhir</option>
                <option value="3">3 bulan terakhir</option>
                <option value="6" selected>6 bulan terakhir</option>
                <option value="12">12 bulan terakhir</option>
                </select>
            </div>
            <div class="legend">
                <span><i class="legend-dot" style="background:#f59e0b"></i>Pendapatan (Rp)</span>
            </div>
            <div class="chart-wrap">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="chart-card notif-card">
        <div class="chart-header">
            <div class="chart-title">Notifikasi penting</div>
            <span class="notif-badge">3 baru</span>
        </div>
        <div class="notif-list">
            <div class="notif-item notif-danger">
                <div class="notif-icon"><i class="ti ti-alert-circle"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Pembayaran <strong>Kamar 3A</strong> telah jatuh tempo</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 2 jam lalu</span>
                </div>
            </div>
            <div class="notif-item notif-warning">
                <div class="notif-icon"><i class="ti ti-user-plus"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Permintaan sewa baru dari <strong>Budi Santoso</strong></p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 5 jam lalu</span>
                </div>
            </div>
            <div class="notif-item notif-info">
                <div class="notif-icon"><i class="ti ti-tool"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Laporan kerusakan <strong>Kamar 2B</strong> — AC tidak dingin</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 1 hari lalu</span>
                </div>
            </div>
            <div class="notif-item notif-success">
                <div class="notif-icon"><i class="ti ti-check"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Pembayaran <strong>Kamar 1C</strong> berhasil diterima</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 2 hari lalu</span>
                </div>
            </div>
            <div class="notif-item notif-warning">
                <div class="notif-icon"><i class="ti ti-calendar-x"></i></div>
                <div class="notif-body">
                    <p class="notif-text">Kontrak <strong>Kamar 4D</strong> berakhir dalam 7 hari</p>
                    <span class="notif-time"><i class="ti ti-clock"></i> 3 hari lalu</span>
                </div>
            </div>
        </div>
            <a href="#" class="notif-lihat-semua">Lihat semua notifikasi <i class="ti ti-arrow-right"></i></a>
        </div>
    </div>
  </div>
</div>
<?php endif;?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<?php if ($role == 'konsumen'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    const map = L.map('map').setView([-7.706, 114.012], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([-7.706, 114.012]).addTo(map).bindPopup('ARM Kost');
});
</script>
<?php elseif ($role == 'admin'): ?>
<script>
// Data Pendaftaran
const dataPendaftaran = {
    1:  { labels: ['Jun'],
          new: [32], renew: [18] },
    3:  { labels: ['Apr','Mei','Jun'],
          new: [21,28,32], renew: [12,15,18] },
    6:  { labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
          new: [14,18,22,21,28,32], renew: [8,10,13,12,15,18] },
    12: { labels: ['Jul','Agt','Sep','Okt','Nov','Des','Jan','Feb','Mar','Apr','Mei','Jun'],
          new: [9,11,13,15,14,20,14,18,22,21,28,32],
          renew: [5,6,7,8,8,11,8,10,13,12,15,18] }
};

//  Data Pendapatan (dalam jutaan Rp)
const dataPendapatan = {
    1:  { labels: ['Jun'],
          income: [42] },
    3:  { labels: ['Apr','Mei','Jun'],
          income: [35,38,42] },
    6:  { labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
          income: [28,30,33,35,38,42] },
    12: { labels: ['Jul','Agt','Sep','Okt','Nov','Des','Jan','Feb','Mar','Apr','Mei','Jun'],
          income: [20,22,24,26,25,30,28,30,33,35,38,42] }
};

let lineChart, barChart;

// ── Grafik Pendaftaran (Line) ────────────────────────────────
function buildLineChart(range) {
    const d = dataPendaftaran[range];
    if (lineChart) lineChart.destroy();

    lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: d.labels,
            datasets: [
                {
                    label: 'Pendaftaran baru',
                    data: d.new,
                    borderColor: '#2a78d6',
                    backgroundColor: 'rgba(42,120,214,0.08)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#2a78d6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Perpanjangan',
                    data: d.renew,
                    borderColor: '#1baf7a',
                    backgroundColor: 'rgba(27,175,122,0.07)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#1baf7a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y}`
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#e1e0d9' },
                    ticks: { color: '#9ca3af', font: { size: 12 } },
                    border: { color: '#e1e0d9' }
                },
                y: {
                    grid: { color: '#e1e0d9' },
                    ticks: { color: '#9ca3af', font: { size: 12 }, precision: 0 },
                    border: { color: 'transparent' },
                    beginAtZero: true
                }
            }
        }
    });
}

// ── Grafik Pendapatan (Bar) ───────────────────────────────────
function buildBarChart(range) {
    const d = dataPendapatan[range];
    if (barChart) barChart.destroy();

    barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: d.labels,
            datasets: [
                {
                    label: 'Pendapatan (jt)',
                    data: d.income,
                    backgroundColor: 'rgba(245,158,11,0.15)',
                    borderColor: '#f59e0b',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` Rp ${ctx.parsed.y} jt`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 12 } },
                    border: { color: '#e1e0d9' }
                },
                y: {
                    grid: { color: '#e1e0d9' },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 12 },
                        callback: val => 'Rp ' + val + ' jt'
                    },
                    border: { color: 'transparent' },
                    beginAtZero: true
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    buildLineChart(6);
    buildBarChart(6);

    document.getElementById('rangeSelect').addEventListener('change', e => {
        buildLineChart(+e.target.value);
    });

    document.getElementById('rangeSelectPendapatan').addEventListener('change', e => {
        buildBarChart(+e.target.value);
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>