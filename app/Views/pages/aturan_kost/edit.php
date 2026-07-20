<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Aturan Kost</h1>
            <p class="page-subtitle">Edit informasi aturan kost</p>
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

    <form action="<?= base_url('dashboard/aturan-kost/update/'.$aturan['id_aturan']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-grid">
            <div class="left-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-list"></i>
                        Informasi Aturan
                    </h2>
                    <div class="field-group">
                        <label>Nama Aturan</label>
                        <input
                            type="text"
                            name="nama_aturan"
                            placeholder="Masukkan nama aturan"
                            value="<?= esc($aturan['nama_aturan']) ?>"
                            required>
                    </div>
                    <div class="field-group">
                        <label>Deskripsi</label>
                        <textarea
                            name="deskripsi_aturan"
                            rows="4"
                            placeholder="Masukkan deskripsi aturan"
                            required><?= esc($aturan['deskripsi_aturan']) ?></textarea>
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
                            <li>Perubahan aturan akan berlaku untuk semua kost yang menggunakan aturan ini.</li>
                            <li>Pastikan nama aturan jelas dan mudah dipahami oleh penyewa.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="<?= base_url('dashboard/aturan-kost') ?>" class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
            <button type="submit" class="btn-save">
                <i class="ti ti-device-floppy"></i>
                Update Data Aturan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
