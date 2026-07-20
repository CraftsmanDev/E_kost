<?php
$role = session()->get('role');
?>

<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Data Kost</h1>
            <p class="page-subtitle">
                Lengkapi informasi kost. Pengelolaan kamar dapat dilakukan setelah kost berhasil ditambahkan.
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
    action="<?= base_url('dashboard/kost/store')?>"
    method="post"
    enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="form-grid">
        <div class="left-content">
            <div class="form-card">
                <h2>
                    <i class="ti ti-home"></i>
                    Informasi Kost
                </h2>
                <div class="field-group">
                    <label>Nama Kost</label>
                    <input
                        type="text"
                        name="nama_kost"
                        placeholder="Contoh : Kost ARM House"
                        value="<?= old('nama_kost')?>"
                        required>
                </div>
                <div class="field-group">
                    <label>Alamat Lengkap</label>
                    <textarea
                        rows="4"
                        name="alamat_kost"
                        required><?= old('alamat_kost')?></textarea>
                </div>
                <div class="field-group">
                    <label>Lokasi</label>
                    <input
                        type="text"
                        name="lokasi_kost"
                        value="<?= old('lokasi_kost')?>">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label>Latitude</label>
                        <input
                            id="latitude"
                            type="text"
                            name="latitude"
                            value="<?= old('latitude')?>">
                    </div>
                    <div class="field-group">
                        <label>Longitude</label>
                        <input
                            id="longitude"
                            type="text"
                            name="longitude"
                            value="<?= old('longitude')?>">
                    </div>
                </div>
                <div class="field-group">
                    <button
                        type="button"
                        class="btn-location"
                        id="ambilLokasi">
                        <i class="ti ti-current-location"></i>
                        Ambil Lokasi Saya
                    </button>
                </div>
                <div class="field-group">
                    <div id="map"></div>
                </div>
                <div class="field-group">
                    <label>Deskripsi Kost</label>
                    <textarea
                        rows="5"
                        name="deskripsi_kost"><?= old('deskripsi_kost')?></textarea>
                </div>
                <div class="field-group">
                    <label>Tipe Kost</label>
                    <select name="type_kost">
                        <option value="">Pilih Tipe Kost</option>
                        <option value="PUTRA">Putra</option>
                        <option value="PUTRI">Putri</option>
                        <option value="CAMPUR">Campur</option>
                    </select>
                </div>
                <div class="field-group">
                    <label>Total Kamar</label>
                    <input
                        type="number"
                        name="total_kamar"
                        min="1"
                        placeholder="Jumlah total kamar yang dimiliki"
                        value="<?= old('total_kamar', 1) ?>"
                        required>
                </div>
            </div>
        </div>
        <div class="right-content">
            <div class="form-card">
                <h2>
                    <i class="ti ti-wifi"></i>
                    Fasilitas Kost
                </h2>
                <p class="form-subtitle">Pilih fasilitas yang tersedia di kost ini</p>
                <div class="check-group">
                    <?php foreach ($fasilitas as $item): ?>
                        <label class="check-card">
                            <input
                                type="checkbox"
                                name="id_fasilitas[]"
                                value="<?= $item['id_fasilitas_kost'] ?>">
                            <div>
                                <strong><?= esc($item['nama_fasilitas']) ?></strong>
                                <small><?= esc($item['deskripsi']) ?></small>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-card mt-4">
                <h2>
                    <i class="ti ti-book"></i>
                    Aturan Kost
                </h2>
                <p class="form-subtitle">Pilih aturan yang berlaku di kost ini</p>
                <div class="check-group">
                    <?php foreach ($aturan as $item): ?>
                        <label class="check-card">
                            <input
                                type="checkbox"
                                name="id_aturan[]"
                                value="<?= $item['id_aturan'] ?>">
                            <div>
                                <strong><?= esc($item['nama_aturan']) ?></strong>
                                <small><?= esc($item['deskripsi_aturan']) ?></small>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-card mt-4">
                <h2>
                    <i class="ti ti-photo"></i>
                    Foto Kost
                </h2>
                <div class="upload-box">
                    <input
                        type="file"
                        id="foto"
                        name="foto_kost"
                        accept="image/*">
                    <label for="foto">
                        <i class="ti ti-cloud-upload"></i>
                        <h3>
                            Upload Foto Kost
                        </h3>
                        <p>
                            JPG / PNG (Maksimal 2 MB)
                        </p>
                        <img id="preview">
                    </label>
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
                            Setelah menyimpan data kost, Anda dapat mengelola kamar melalui menu "Kelola Kamar".
                        </li>
                        <li>
                            Pastikan data lokasi sudah benar untuk memudahkan pencarian.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <a
            href="<?= base_url('dashboard/kost')?>"
            class="btn-back">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        <button
            type="submit"
            class="btn-save">
            <i class="ti ti-device-floppy"></i>
            Simpan Data Kost
        </button>
    </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const latInput = document.getElementById("latitude");
    const lngInput = document.getElementById("longitude");
    const defaultLat = -7.7066;
    const defaultLng = 113.9553;
    const map = L.map("map").setView([defaultLat, defaultLng], 13);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "© OpenStreetMap"
    }).addTo(map);
    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
    function updateLatLng(latlng) {
        latInput.value = latlng.lat.toFixed(6);
        lngInput.value = latlng.lng.toFixed(6);
        marker.setLatLng(latlng);
    }
    map.on("click", function () { updateLatLng(e.latlng); });
    marker.on("dragend", function () { updateLatLng(marker.getLatLng()); });
    document.getElementById("ambilLokasi").addEventListener("click", function () {
        if (!navigator.geolocation) {
            alert("Browser tidak mendukung GPS");
            return;
        }
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const latlng = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                updateLatLng(latlng);
                map.setView([latlng.lat, latlng.lng], 17);
            },
            function (err) {
                alert("Lokasi gagal diambil.");
                console.error(err);
            },
            { enableHighAccuracy: true }
        );
    });
    setTimeout(() => map.invalidateSize(), 300);
});
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