    <div class="content">
        <div class="dash">
            <div class="kpi-row">
                <div class="kpi">
                    <div class="kpi-icon" style="background:#EAF3DE">
                        <i class="ti ti-building-community" style="color:#3B6D11"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Total Kost</div>
                        <div class="kpi-value"><?= $totalKost ?? 0 ?></div>
                        <div class="kpi-delta"><span>Total</span> kost milikmu</div>
                    </div>
                </div>
                <div class="kpi">
                    <div class="kpi-icon" style="background:#E6F1FB">
                        <i class="ti ti-door" style="color:#185FA5"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Kamar Tersedia</div>
                        <div class="kpi-value"><?= $kamarTersedia ?? 0 ?></div>
                        <div class="kpi-delta"><span>Dari</span> <?= $totalKamar ?? 0 ?> total kamar</div>
                    </div>
                </div>
                <div class="kpi">
                    <div class="kpi-icon" style="background:#E1F5EE">
                        <i class="ti ti-users" style="color:#0F6E56"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Total Penghuni</div>
                        <div class="kpi-value"><?= $totalPenghuni ?? 0 ?></div>
                        <div class="kpi-delta"><span>Penyewa</span> aktif saat ini</div>
                    </div>
                </div>
                <div class="kpi">
                    <div class="kpi-icon" style="background:#FEF3C7">
                        <i class="ti ti-cash" style="color:#D97706"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Total Pendapatan</div>
                        <div class="kpi-value">Rp <?= number_format($pendapatan ?? 0, 0, ',', '.') ?></div>
                        <div class="kpi-delta"><span>Pembayaran</span> disetujui</div>
                    </div>
                </div>
            </div>

            <div class="kpi-row-2">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Grafik Okupansi Kost</div>
                        <select id="rangeSelect">
                            <option value="1">1 bulan terakhir</option>
                            <option value="3">3 bulan terakhir</option>
                            <option value="6" selected>6 bulan terakhir</option>
                            <option value="12">12 bulan terakhir</option>
                        </select>
                    </div>
                    <div class="legend">
                        <span><i class="legend-dot" style="background:#2a78d6"></i> Kamar terisi</span>
                        <span><i class="legend-dot" style="background:#1baf7a"></i> Kamar kosong</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="chart-card notif-card">
                    <div class="chart-header">
                        <div class="chart-title">Ringkasan Hunian</div>
                    </div>
                    <div class="notif-list">
                        <div class="notif-item notif-info">
                            <div class="notif-icon"><i class="ti ti-door"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">
                                    <strong><?= $kamarTerisi ?? 0 ?> kamar</strong> sedang terisi
                                </p>
                                <span class="notif-time"><i class="ti ti-point"></i> Status hunian</span>
                            </div>
                        </div>
                        <div class="notif-item notif-success">
                            <div class="notif-icon"><i class="ti ti-door-enter"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">
                                    <strong><?= $kamarTersedia ?? 0 ?> kamar</strong> masih tersedia
                                </p>
                                <span class="notif-time"><i class="ti ti-point"></i> Siap disewa</span>
                            </div>
                        </div>
                        <div class="notif-item notif-warning">
                            <div class="notif-icon"><i class="ti ti-chart-bar"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">
                                    Tingkat hunian
                                    <strong>
                                        <?= ($totalKamar ?? 0) > 0
                                            ? round(($kamarTerisi / $totalKamar) * 100) . '%'
                                            : '0%' ?>
                                    </strong>
                                </p>
                                <span class="notif-time"><i class="ti ti-point"></i> Dari total kamar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>