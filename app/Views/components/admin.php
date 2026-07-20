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
                        <div class="kpi-delta"><span>Total</span> kost terdaftar</div>
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
                    <div class="kpi-icon" style="background:#FAEEDA">
                        <i class="ti ti-users" style="color:#854F0B"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Total Konsumen</div>
                        <div class="kpi-value"><?= $totalKonsumen ?? 0 ?></div>
                        <div class="kpi-delta"><span>Total</span> konsumen terdaftar</div>
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
            </div>

            <div class="kpi-row">
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
                <div class="kpi">
                    <div class="kpi-icon" style="background:#FEE2E2">
                        <i class="ti ti-clock" style="color:#DC2626"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Menunggu Pembayaran</div>
                        <div class="kpi-value"><?= $pembayaranMenunggu ?? 0 ?></div>
                        <div class="kpi-delta"><span>Perlu</span> diverifikasi</div>
                    </div>
                </div>
                <div class="kpi">
                    <div class="kpi-icon" style="background:#F3E8FF">
                        <i class="ti ti-door-off" style="color:#6B21A8"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Kamar Terisi</div>
                        <div class="kpi-value"><?= $kamarTerisi ?? 0 ?></div>
                        <div class="kpi-delta"><span>Dari</span> <?= $totalKamar ?? 0 ?> total kamar</div>
                    </div>
                </div>
                <div class="kpi">
                    <div class="kpi-icon" style="background:#DBEAFE">
                        <i class="ti ti-building" style="color:#1E40AF"></i>
                    </div>
                    <div class="kpi-body">
                        <div class="kpi-label">Tingkat Hunian</div>
                        <div class="kpi-value">
                            <?= ($totalKamar ?? 0) > 0
                                ? round(($kamarTerisi / $totalKamar) * 100) . '%'
                                : '0%' ?>
                        </div>
                        <div class="kpi-delta"><span>Persentase</span> kamar terisi</div>
                    </div>
                </div>
            </div>

            <div class="kpi-row-2">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">Grafik Pendaftaran Konsumen</div>
                        <select id="rangeSelect">
                            <option value="1">1 bulan terakhir</option>
                            <option value="3">3 bulan terakhir</option>
                            <option value="6" selected>6 bulan terakhir</option>
                            <option value="12">12 bulan terakhir</option>
                        </select>
                    </div>
                    <div class="legend">
                        <span><i class="legend-dot" style="background:#2a78d6"></i> Pendaftaran baru</span>
                        <span><i class="legend-dot" style="background:#1baf7a"></i> Perpanjangan</span>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
                <div class="chart-card notif-card">
                    <div class="chart-header">
                        <div class="chart-title">Notifikasi Penting</div>
                        <?php if (($pembayaranMenunggu ?? 0) > 0): ?>
                            <span class="notif-badge"><?= $pembayaranMenunggu ?> baru</span>
                        <?php endif; ?>
                    </div>
                    <div class="notif-list">
                        <?php if (($pembayaranMenunggu ?? 0) > 0): ?>
                        <div class="notif-item notif-warning">
                            <div class="notif-icon"><i class="ti ti-clock"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">
                                    <strong><?= $pembayaranMenunggu ?> pembayaran</strong> menunggu verifikasi
                                </p>
                                <span class="notif-time"><i class="ti ti-point"></i> Perlu tindakan</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (($kamarTersedia ?? 0) == 0): ?>
                        <div class="notif-item notif-danger">
                            <div class="notif-icon"><i class="ti ti-alert-circle"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">Semua kamar sudah <strong>terisi penuh</strong></p>
                                <span class="notif-time"><i class="ti ti-point"></i> Info hunian</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (($permitaanSewaMenunggu ?? 0) > 0): ?>
                        <div class="notif-item notif-warning">
                            <div class="notif-icon"><i class="ti ti-clock"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">
                                    <strong><?= $permitaanSewaMenunggu ?> permintaan sewa</strong> menunggu persetujuan
                                </p>
                                <span class="notif-time"><i class="ti ti-point"></i> Perlu tindakan</span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (($pembayaranMenunggu ?? 0) == 0 && ($kamarTersedia ?? 0) > 0): ?>
                        <div class="notif-item notif-success">
                            <div class="notif-icon"><i class="ti ti-circle-check"></i></div>
                            <div class="notif-body">
                                <p class="notif-text">Semua pembayaran sudah <strong>terverifikasi</strong></p>
                                <span class="notif-time"><i class="ti ti-point"></i> Tidak ada notifikasi baru</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>