<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Fasilitas Kost</h1>
            <p class="page-subtitle">Tambah data fasilitas kost baru</p>
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

    <form action="<?= base_url('dashboard/fasilitas-kost/simpan') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-grid">
            <div class="left-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-tool"></i>
                        Informasi Fasilitas
                    </h2>
                    <div class="field-group">
                        <label>Nama Fasilitas</label>
                        <input
                            type="text"
                            name="nama_fasilitas"
                            placeholder="Masukkan nama fasilitas"
                            value="<?= old('nama_fasilitas') ?>"
                            required>
                    </div>
                    <div class="field-group">
                        <label>Deskripsi</label>
                        <textarea
                            name="deskripsi"
                            rows="4"
                            placeholder="Masukkan deskripsi fasilitas"
                            required><?= old('deskripsi') ?></textarea>
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
                            <li>Fasilitas kost akan digunakan sebagai pilihan saat menambah atau mengedit data kost.</li>
                            <li>Pastikan nama fasilitas jelas dan mudah dipahami.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="<?= base_url('dashboard/fasilitas-kost') ?>" class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
            <button type="submit" class="btn-save">
                <i class="ti ti-device-floppy"></i>
                Simpan Data Fasilitas
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
