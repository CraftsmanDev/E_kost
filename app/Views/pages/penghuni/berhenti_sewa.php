<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengajuan Berhenti Sewa</h1>
            <p class="page-subtitle">
                Isi formulir berikut untuk mengajukan penghentian masa sewa.
            </p>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('dashboard/pengajuan-berhenti/storeExit/'.$pemesanan['id_pemesanan']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-grid">

            <div class="left-content">

                <div class="form-card">
                    <h2>
                        <i class="ti ti-door-exit"></i>
                        Informasi Pengajuan
                    </h2>

                    <div class="field-group">
                        <label>Nama Kost</label>
                        <input type="text" value="<?= esc($kost['nama_kost']) ?>" readonly>
                    </div>

                    <div class="field-group">
                        <label>Nomor Kamar</label>
                        <input type="text" value="<?= esc($kamar['nomor_kamar']) ?>" readonly>
                    </div>

                    <div class="field-group">
                        <label>Tanggal Pengajuan</label>
                        <input type="date"
                               name="tanggal_pengajuan"
                               value="<?= date('Y-m-d') ?>"
                               readonly>
                    </div>

                    <div class="field-group">
                        <label>Tanggal Berhenti</label>
                        <input type="date"
                               name="tanggal_berhenti"
                               min="<?= date('Y-m-d') ?>"
                               required>
                    </div>

                    <div class="field-group">
                        <label>Alasan Berhenti</label>
                        <textarea
                            name="alasan"
                            rows="5"
                            placeholder="Tuliskan alasan berhenti menyewa..."
                            required></textarea>
                    </div>

                </div>

            </div>

            <div class="right-content">

                <div class="form-card">
                    <h2>
                        <i class="ti ti-info-circle"></i>
                        Informasi
                    </h2>

                    <div class="info-box">
                        <ul>
                            <li>Pengajuan akan ditinjau oleh pemilik kost.</li>
                            <li>Silakan pilih tanggal berhenti sesuai rencana.</li>
                            <li>Setelah disetujui, status sewa akan diperbarui.</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

        <div class="form-actions">

            <a href="<?= base_url('dashboard/permintaan-sewa') ?>"
               class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>

            <button type="submit"
                    class="btn-save">
                <i class="ti ti-send"></i>
                Ajukan Berhenti Sewa
            </button>

        </div>

    </form>

</div>

<?= $this->endSection() ?>