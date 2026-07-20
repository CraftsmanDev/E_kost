<?php
$role = session()->get('role');
?>

<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>

<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Pengguna</h1>
            <p class="page-subtitle">
                Edit informasi pengguna sistem
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

    <form
        action="<?= base_url('dashboard/pengguna/update/'.$pengguna['id_user'])?>"
        method="post"
        enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-grid">
            <div class="left-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-user"></i>
                        Informasi Pengguna
                    </h2>
                    <div class="field-group">
                        <label>Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama"
                            placeholder="Masukkan nama lengkap"
                            value="<?= esc($pengguna['nama']) ?>"
                            required>
                    </div>
                    <div class="field-group">
                        <label>Username</label>
                        <input
                            type="text"
                            name="username"
                            placeholder="Masukkan username"
                            value="<?= esc($pengguna['username']) ?>"
                            required>
                    </div>
                    <div class="field-group">
                        <label>No HP</label>
                        <input
                            type="text"
                            name="no_hp"
                            placeholder="Masukkan nomor HP"
                            value="<?= esc($pengguna['no_hp']) ?>"
                            required>
                    </div>
                    <div class="field-group">
                        <label>Password Baru</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small>Biarkan kosong jika tidak ingin mengubah password</small>
                    </div>
                    <div class="field-group">
                        <label>Foto Profil</label>
                        <div class="upload-box">
                            <input
                                type="file"
                                id="foto"
                                name="foto"
                                accept="image/*">
                            <label for="foto">
                                <i class="ti ti-cloud-upload"></i>
                                <h3>Upload Foto Profil</h3>
                                <p>JPG / PNG (Maksimal 2 MB)</p>
                                <img id="preview" src="<?= base_url('assets/' . $pengguna['foto']) ?>">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-shield"></i>
                        Role & Status
                    </h2>
                    <div class="field-group">
                        <label>Role</label>
                        <select name="role_id" required>
                            <option value="">Pilih Role</option>
                            <option value="1" <?= $pengguna['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $pengguna['role_id'] == 2 ? 'selected' : '' ?>>Pemilik</option>
                            <option value="3" <?= $pengguna['role_id'] == 3 ? 'selected' : '' ?>>Konsumen</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif" <?= $pengguna['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= $pengguna['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="form-card mt-4">
                    <h2>
                        <i class="ti ti-info-circle"></i>
                        Informasi
                    </h2>
                    <div class="info-box">
                        <ul>
                            <li>
                                Password hanya akan diubah jika diisi pada kolom password baru.
                            </li>
                            <li>
                                Perubahan role akan mempengaruhi hak akses pengguna dalam sistem.
                            </li>
                            <li>
                                Pengguna dengan status Nonaktif tidak dapat login ke sistem.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a
                href="<?= base_url('dashboard/pengguna')?>"
                class="btn-back">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
            <button
                type="submit"
                class="btn-save">
                <i class="ti ti-device-floppy"></i>
                Update Data Pengguna
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const inputFoto = document.getElementById("foto");
const preview   = document.getElementById("preview");

inputFoto.addEventListener("change", function () {
    const file = this.files[0];

    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert("Ukuran file maksimal 2 MB!");
        this.value = "";
        preview.src = "";
        preview.style.display = "none";
        return;
    }
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
    if (!allowedTypes.includes(file.type)) {
        alert("Format file harus JPG atau PNG!");
        this.value = "";
        preview.src = "";
        preview.style.display = "none";
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = "block";
    };
    reader.readAsDataURL(file);
});
</script>
<?= $this->endSection() ?>
