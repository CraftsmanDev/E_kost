<?= $this->extend('dashboard') ?>

<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Edit Data Kamar</h1>
            <p>
                Edit kamar <?= esc($kamar['nomor_kamar']) ?> untuk kost: <?= esc($kost['nama_kost']) ?>
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
    <form action="<?= base_url('dashboard/kamar/'.$id_kost.'/update/'.$id_kamar) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-grid">
            <div class="left-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-home"></i>
                        Informasi Kamar
                    </h2>
                    <div class="field-group">
                        <label>Nomor Kamar</label>
                        <input type="text" 
                               name="nomor_kamar" 
                               placeholder="Contoh: 101, 102, A1"
                               value="<?= old('nomor_kamar', $kamar['nomor_kamar']) ?>" 
                               required>
                    </div>
                    <div class="field-group">
                        <label>Harga Sewa (Rp)</label>
                        <input type="number" 
                               name="harga_sewa" 
                               placeholder="Contoh: 500000"
                               value="<?= old('harga_sewa', $kamar['harga_sewa']) ?>" 
                               required>
                    </div>
                    <div class="field-group">
                        <label>Tipe Kamar</label>
                        <select name="id_tipe_kamar" required>
                            <option value="">Pilih Tipe Kamar</option>
                            <?php foreach ($tipe_kamar as $tipe): ?>
                                <option value="<?= $tipe['id_tipe_kamar'] ?>" 
                                        <?= (old('id_tipe_kamar', $kamar['id_tipe_kamar']) == $tipe['id_tipe_kamar']) ? 'selected' : '' ?>>
                                    <?= esc($tipe['nama_tipe_kamar']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Fasilitas Kamar</label>
                        <select name="id_fasilitas_kamar" required>
                            <option value="">Pilih Fasilitas Kamar</option>
                            <?php foreach ($fasilitas_kamar as $fasilitas): ?>
                                <option value="<?= $fasilitas['id_fasilitas_kamar'] ?>" 
                                        <?= (old('id_fasilitas_kamar', $kamar['id_fasilitas_kamar']) == $fasilitas['id_fasilitas_kamar']) ? 'selected' : '' ?>>
                                    <?= esc($fasilitas['nama_fasilitas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Status Ketersediaan</label>
                        <select name="status_ketersediaan" required>
                            <option value="">Pilih Status</option>
                            <option value="Tersedia" <?= (old('status_ketersediaan', $kamar['status_ketersediaan']) == 'Tersedia') ? 'selected' : '' ?>>Tersedia</option>
                            <option value="Terisi" <?= (old('status_ketersediaan', $kamar['status_ketersediaan']) == 'Terisi') ? 'selected' : '' ?>>Terisi</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="right-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-info-circle"></i>
                        Informasi Kost
                    </h2>
                    <p class="form-subtitle">Kost tempat kamar ini berada</p>
                    <div class="kost-preview">
                        <img src="<?= base_url('uploads/kost/' . $kost['foto_kost']) ?>" alt="kost" class="kost-thumb">
                        <div class="kost-details">
                            <h3><?= esc($kost['nama_kost']) ?></h3>
                            <p>
                                <i class="ti ti-map-pin"></i>
                                <?= esc($kost['alamat_kost']) ?>
                            </p>
                            <span class="badge badge-<?= strtolower($kost['type_kost']) ?>"><?= esc($kost['type_kost']) ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="form-card mt-4">
                    <h2>
                        <i class="ti ti-alert-circle"></i>
                        Informasi
                    </h2>
                    <div class="info-box">
                        <ul>
                            <li>Perubahan data kamar akan mempengaruhi pemesanan yang sedang berlangsung</li>
                            <li>Status kamar akan mempengaruhi ketersediaan saat pemesanan</li>
                            <li>Pastikan data yang diinput sudah benar sebelum menyimpan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= base_url('dashboard/kamar/'.$id_kost) ?>" class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
            <button type="submit" class="btn-save">
                <i class="ti ti-device-floppy"></i>
                Update Data Kamar
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>