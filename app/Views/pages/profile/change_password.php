<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Ubah Password</h1>
            <p class="page-sub">Perbarui password akun Anda untuk keamanan</p>
        </div>
        <div class="page-actions">
            <a href="<?= base_url('dashboard/profile') ?>" class="btn-back">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="form-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="width: 80px; height: 80px; background: #fee2e2; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="ti ti-lock" style="font-size: 36px; color: #dc2626;"></i>
            </div>
            <h3 class="form-subtitle" style="margin-bottom: 8px;">Keamanan Akun</h3>
            <p style="color: #6b7280; font-size: 13px;">Pastikan password Anda kuat dan unik</p>
        </div>

        <form action="<?= base_url('dashboard/profile/change-password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="field-group">
                <label for="current_password">
                    <i class="ti ti-key"></i> Password Saat Ini *
                </label>
                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Masukkan password saat ini" required>
                <?php if (isset($errors['current_password'])): ?>
                    <div class="alert-danger"><?= $errors['current_password'] ?></div>
                <?php endif; ?>
            </div>

            <div class="field-group">
                <label for="new_password">
                    <i class="ti ti-lock"></i> Password Baru *
                </label>
                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Masukkan password baru" required minlength="6">
                <?php if (isset($errors['new_password'])): ?>
                    <div class="alert-danger"><?= $errors['new_password'] ?></div>
                <?php endif; ?>
                <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                    <i class="ti ti-info-circle"></i> Minimal 6 karakter, gunakan kombinasi huruf dan angka
                </small>
            </div>

            <div class="field-group">
                <label for="confirm_password">
                    <i class="ti ti-lock-check"></i> Konfirmasi Password Baru *
                </label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required minlength="6">
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="alert-danger"><?= $errors['confirm_password'] ?></div>
                <?php endif; ?>
            </div>

            <div class="alert-danger mt-4" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                <i class="ti ti-alert-triangle"></i>
                <span>Penting: Pastikan Anda mengingat password baru Anda. Gunakan password yang tidak mudah ditebak.</span>
            </div>

            <div class="form-actions mt-4">
                <a href="<?= base_url('dashboard/profile') ?>" class="btn-back">
                    <i class="ti ti-x"></i> Batal
                </a>
                <button type="submit" class="btn-save">
                    <i class="ti ti-device-floppy"></i> Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    
    if (newPassword && confirmPassword) {
        // Real-time password match validation
        confirmPassword.addEventListener('input', function() {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#dc2626';
            } else {
                confirmPassword.style.borderColor = '#d1fae5';
            }
        });
        
        newPassword.addEventListener('input', function() {
            if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#dc2626';
            } else {
                confirmPassword.style.borderColor = '#d1fae5';
            }
        });
    }
});
</script>
<?= $this->endSection() ?>