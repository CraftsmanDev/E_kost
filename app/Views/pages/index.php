<?php $role = session()->get('role'); ?>
<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<?php if ($role == 'konsumen'): ?>
    <?= $this->include('components/konsumen') ?>
<?php elseif ($role == 'admin'): ?>
    <?= $this->include('components/admin') ?>
<?php elseif ($role == 'pemilik'): ?>
    <?= $this->include('components/pemilik') ?>
<?php endif; ?>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<?php if ($role == 'admin' || $role == 'pemilik'): ?>
<script>
const dataChart = {
    1:  { labels: ['Bulan ini'],
          line1: [<?= $kamarTerisi ?? 0 ?>], line2: [<?= $kamarTersedia ?? 0 ?>] },
    3:  { labels: ['3 bln lalu', '2 bln lalu', 'Bulan ini'],
          line1: [<?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>],
          line2: [<?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>] },
    6:  { labels: ['6 bln lalu','5 bln lalu','4 bln lalu','3 bln lalu','2 bln lalu','Bulan ini'],
          line1: [<?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>, <?= $kamarTerisi ?? 0 ?>],
          line2: [<?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>, <?= $kamarTersedia ?? 0 ?>] },
    12: { labels: ['12 bln','11 bln','10 bln','9 bln','8 bln','7 bln','6 bln','5 bln','4 bln','3 bln','2 bln','Bulan ini'],
          line1: Array(12).fill(<?= $kamarTerisi ?? 0 ?>),
          line2: Array(12).fill(<?= $kamarTersedia ?? 0 ?>) }
};

let lineChart;

function buildLineChart(range) {
    const d = dataChart[range];
    if (lineChart) lineChart.destroy();
    lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: d.labels,
            datasets: [
                {
                    label: '<?= $role == "admin" ? "Pendaftaran baru" : "Kamar terisi" ?>',
                    data: d.line1,
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
                    label: '<?= $role == "admin" ? "Perpanjangan" : "Kamar kosong" ?>',
                    data: d.line2,
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
                tooltip: { mode: 'index', intersect: false }
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

document.addEventListener('DOMContentLoaded', function () {
    buildLineChart(6);
    document.getElementById('rangeSelect').addEventListener('change', e => {
        buildLineChart(+e.target.value);
    });
});
</script>
<?php endif; ?>
<?= $this->endSection() ?>