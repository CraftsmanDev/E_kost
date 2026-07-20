<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="edit-profile-container">
        <div class="profile-header">
            <h1>Edit Profil</h1>
            <p>Perbarui informasi profil dan tampilan Anda</p>
        </div>

        <div class="edit-form-card">
            <form action="<?= base_url('dashboard/profile/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="photo-upload-section">
                    <div class="photo-preview-container">
                        <?php if (!empty($user['foto'])): ?>
                            <img src="<?= base_url('uploads/profile/' . $user['foto']) ?>" alt="Foto Profil" class="photo-preview" id="photoPreview">
                        <?php else: ?>
                            <img src="<?= base_url('assets/icon-profile.png') ?>" alt="Foto Profil" class="photo-preview" id="photoPreview">
                        <?php endif; ?>
                    </div>
                    <div class="upload-btn-wrapper">
                        <button class="upload-btn" type="button">
                            <i class="ti ti-camera"></i> Ganti Foto
                        </button>
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png">
                    </div>
                    <p class="help-text">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB</p>
                </div>

                <div class="form-section">
                    <div class="form-section-title">
                        <i class="ti ti-user"></i>
                        Informasi Pribadi
                    </div>

                    <div class="row-2">
                        <div class="form-group-modern">
                            <label for="nama">
                                <i class="ti ti-user"></i> Nama Lengkap *
                            </label>
                            <input type="text" id="nama" name="nama" class="form-control-modern" 
                                   value="<?= htmlspecialchars($user['nama']) ?>" required placeholder="Masukkan nama lengkap">
                            <?php if (isset($errors['nama'])): ?>
                                <div class="error-message"><?= $errors['nama'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group-modern">
                            <label for="username">
                                <i class="ti ti-at"></i> Username *
                            </label>
                            <input type="text" id="username" name="username" class="form-control-modern" 
                                   value="<?= htmlspecialchars($user['username']) ?>" required placeholder="Masukkan username">
                            <?php if (isset($errors['username'])): ?>
                                <div class="error-message"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label for="no_hp">
                            <i class="ti ti-phone"></i> No. HP *
                        </label>
                        <input type="text" id="no_hp" name="no_hp" class="form-control-modern" 
                               value="<?= htmlspecialchars($user['no_hp']) ?>" required placeholder="Masukkan nomor HP">
                        <?php if (isset($errors['no_hp'])): ?>
                            <div class="error-message"><?= $errors['no_hp'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group-modern">
                        <label for="alamat">
                            <i class="ti ti-map-pin"></i> Alamat
                        </label>
                        <textarea id="alamat" name="alamat" class="form-control-modern" rows="3" 
                                  placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($profile['alamat'] ?? '') ?></textarea>
                    </div>

                    <?php if ($role == 'pemilik'): ?>
                    <div class="form-section-title" style="margin-top: 20px;">
                        <i class="ti ti-credit-card"></i>
                        Data Rekening
                    </div>
                    <div class="row-2">
                        <div class="form-group-modern">
                            <label for="nama_bank">
                                <i class="ti ti-building-bank"></i> Nama Bank
                            </label>
                            <select id="nama_bank" name="nama_bank" class="form-control-modern">
                                <option value="">Pilih Bank</option>
                                <?php
                                $banks = ['BCA', 'BRI', 'BNI', 'Mandiri', 'CIMB Niaga', 'Danamon', 'Permata', 'BSI', 'BTN', 'Maybank', 'Bank Mega', 'Neo Commerce', 'Blu by BCA Digital', 'Seabank', 'Jago', 'Lainnya'];
                                $selectedBank = $profile['nama_bank'] ?? '';
                                foreach ($banks as $bank):
                                ?>
                                    <option value="<?= $bank ?>" <?= $selectedBank === $bank ? 'selected' : '' ?>><?= $bank ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group-modern">
                            <label for="nomor_rekening">
                                <i class="ti ti-hashtag"></i> Nomor Rekening
                            </label>
                            <input type="text" id="nomor_rekening" name="nomor_rekening" class="form-control-modern" 
                                   value="<?= htmlspecialchars($profile['nomor_rekening'] ?? '') ?>" placeholder="Masukkan nomor rekening">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form-actions-modern">
                    <a href="<?= base_url('dashboard/profile') ?>" class="btn-modern secondary">
                        <i class="ti ti-x"></i> Batal
                    </a>
                    <button type="submit" class="btn-modern primary">
                        <i class="ti ti-device-floppy"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('foto');
    const photoPreview = document.getElementById('photoPreview');
    
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    photoInput.value = '';
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid. Gunakan JPG, JPEG, atau PNG.');
                    photoInput.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
<?= $this->endSection() ?>