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
                    <select name="type_kost" required>
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
                <div class="check-group" id="fasilitasList">
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
                <button type="button" class="btn-inline-add" id="toggleFasilitasForm">
                    <i class="ti ti-plus"></i>
                    Tambah Fasilitas Baru
                </button>
                <div class="inline-form-wrapper" id="fasilitasFormWrapper" style="display:none;">
                    <div class="inline-form">
                        <div class="field-group">
                            <label>Nama Fasilitas</label>
                            <input type="text" id="namaFasilitas" placeholder="Contoh : Wi-Fi, AC, dll">
                        </div>
                        <div class="field-group">
                            <label>Deskripsi</label>
                            <input type="text" id="deskripsiFasilitas" placeholder="Deskripsi singkat fasilitas">
                        </div>
                        <div class="inline-form-actions">
                            <button type="button" class="btn-inline-save" id="simpanFasilitas">
                                <i class="ti ti-check"></i>
                                Simpan
                            </button>
                            <button type="button" class="btn-inline-cancel" id="batalFasilitas">
                                <i class="ti ti-x"></i>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card mt-4">
                <h2>
                    <i class="ti ti-book"></i>
                    Aturan Kost
                </h2>
                <p class="form-subtitle">Pilih aturan yang berlaku di kost ini</p>
                <div class="check-group" id="aturanList">
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
                <button type="button" class="btn-inline-add" id="toggleAturanForm">
                    <i class="ti ti-plus"></i>
                    Tambah Aturan Baru
                </button>
                <div class="inline-form-wrapper" id="aturanFormWrapper" style="display:none;">
                    <div class="inline-form">
                        <div class="field-group">
                            <label>Nama Aturan</label>
                            <input type="text" id="namaAturan" placeholder="Contoh : Dilarang merokok">
                        </div>
                        <div class="field-group">
                            <label>Deskripsi Aturan</label>
                            <input type="text" id="deskripsiAturan" placeholder="Deskripsi singkat aturan">
                        </div>
                        <div class="inline-form-actions">
                            <button type="button" class="btn-inline-save" id="simpanAturan">
                                <i class="ti ti-check"></i>
                                Simpan
                            </button>
                            <button type="button" class="btn-inline-cancel" id="batalAturan">
                                <i class="ti ti-x"></i>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-card mt-4">
                <h2>
                    <i class="ti ti-photo"></i>
                    Foto Kost
                </h2>
                <p class="form-subtitle">Upload hingga 10 foto. Foto pertama akan menjadi foto utama.</p>
                <div class="upload-box-multi">
                    <input
                        type="file"
                        id="foto"
                        name="foto_kost[]"
                        accept="image/jpg,image/jpeg,image/png"
                        multiple>
                    <label for="foto">
                        <i class="ti ti-cloud-upload"></i>
                        <h3>
                            Upload Foto Kost
                        </h3>
                        <p>
                            JPG / PNG (Maksimal 2 MB per foto)
                        </p>
                    </label>
                </div>
                <div class="foto-grid" id="fotoGrid"></div>
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
    map.on("click", function (e) { updateLatLng(e.latlng); });
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
const fotoGrid  = document.getElementById("fotoGrid");
inputFoto.addEventListener("change", function () {
    fotoGrid.innerHTML = "";
    const files = Array.from(this.files);
    if (files.length > 10) {
        alert("Maksimal 10 foto!");
        this.value = "";
        return;
    }
    files.forEach(function (file, index) {
        if (file.size > 2 * 1024 * 1024) {
            alert(file.name + " melebihi 2 MB, dilewati.");
            return;
        }
        const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedTypes.includes(file.type)) {
            alert(file.name + " bukan format JPG/PNG, dilewati.");
            return;
        }
        const card = document.createElement("div");
        card.className = "foto-card";
        if (index === 0) {
            card.classList.add("foto-utama");
        }
        const img = document.createElement("img");
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
        const badge = document.createElement("span");
        badge.className = "foto-badge";
        badge.textContent = index === 0 ? "Utama" : "#" + (index + 1);
        card.appendChild(img);
        card.appendChild(badge);
        fotoGrid.appendChild(card);
    });
});

document.getElementById('toggleFasilitasForm').addEventListener('click', function() {
    var wrapper = document.getElementById('fasilitasFormWrapper');
    wrapper.style.display = wrapper.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('batalFasilitas').addEventListener('click', function() {
    document.getElementById('fasilitasFormWrapper').style.display = 'none';
    document.getElementById('namaFasilitas').value = '';
    document.getElementById('deskripsiFasilitas').value = '';
});

document.getElementById('simpanFasilitas').addEventListener('click', function() {
    var nama = document.getElementById('namaFasilitas').value.trim();
    var deskripsi = document.getElementById('deskripsiFasilitas').value.trim();

    if (!nama || !deskripsi) {
        alert('Nama dan deskripsi fasilitas wajib diisi.');
        return;
    }

    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader"></i> Menyimpan...';

    var csrfName = '<?= csrf_token() ?>';
    var csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
    var formData = new FormData();
    formData.append('nama_fasilitas', nama);
    formData.append('deskripsi', deskripsi);
    formData.append(csrfName, csrfInput.value);

    fetch('<?= base_url('dashboard/kost/ajax-tambah-fasilitas') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(result) {
        if (result.success) {
            if (result.csrf_hash) {
                csrfInput.value = result.csrf_hash;
            }
            var label = document.createElement('label');
            label.className = 'check-card';
            label.innerHTML = '<input type="checkbox" name="id_fasilitas[]" value="' + result.data.id_fasilitas_kost + '" checked><div><strong>' + result.data.nama_fasilitas + '</strong><small>' + result.data.deskripsi + '</small></div>';
            document.getElementById('fasilitasList').appendChild(label);

            document.getElementById('fasilitasFormWrapper').style.display = 'none';
            document.getElementById('namaFasilitas').value = '';
            document.getElementById('deskripsiFasilitas').value = '';
        } else {
            alert(result.message);
        }
    })
    .catch(function() {
        alert('Terjadi kesalahan saat menyimpan data.');
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="ti ti-check"></i> Simpan';
    });
});

document.getElementById('toggleAturanForm').addEventListener('click', function() {
    var wrapper = document.getElementById('aturanFormWrapper');
    wrapper.style.display = wrapper.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('batalAturan').addEventListener('click', function() {
    document.getElementById('aturanFormWrapper').style.display = 'none';
    document.getElementById('namaAturan').value = '';
    document.getElementById('deskripsiAturan').value = '';
});

document.getElementById('simpanAturan').addEventListener('click', function() {
    var nama = document.getElementById('namaAturan').value.trim();
    var deskripsi = document.getElementById('deskripsiAturan').value.trim();

    if (!nama || !deskripsi) {
        alert('Nama dan deskripsi aturan wajib diisi.');
        return;
    }

    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader"></i> Menyimpan...';

    var csrfName = '<?= csrf_token() ?>';
    var csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
    var formData = new FormData();
    formData.append('nama_aturan', nama);
    formData.append('deskripsi_aturan', deskripsi);
    formData.append(csrfName, csrfInput.value);

    fetch('<?= base_url('dashboard/kost/ajax-tambah-aturan') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(result) {
        if (result.success) {
            if (result.csrf_hash) {
                csrfInput.value = result.csrf_hash;
            }
            var label = document.createElement('label');
            label.className = 'check-card';
            label.innerHTML = '<input type="checkbox" name="id_aturan[]" value="' + result.data.id_aturan + '" checked><div><strong>' + result.data.nama_aturan + '</strong><small>' + result.data.deskripsi_aturan + '</small></div>';
            document.getElementById('aturanList').appendChild(label);

            document.getElementById('aturanFormWrapper').style.display = 'none';
            document.getElementById('namaAturan').value = '';
            document.getElementById('deskripsiAturan').value = '';
        } else {
            alert(result.message);
        }
    })
    .catch(function() {
        alert('Terjadi kesalahan saat menyimpan data.');
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="ti ti-check"></i> Simpan';
    });
});
</script>
<?= $this->endSection() ?>