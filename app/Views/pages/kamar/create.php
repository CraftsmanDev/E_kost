<?= $this->extend('dashboard') ?>

<?= $this->section('content') ?>
<div class="kost-page">
    <div class="page-header">
        <div>
            <h1>Tambah Data Kamar</h1>
            <p>
                Tambahkan kamar baru untuk kost: <?= esc($kost['nama_kost']) ?>
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
    <form action="<?= base_url('dashboard/kamar/'.$id_kost.'/store') ?>" method="post" enctype="multipart/form-data">
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
                               value="<?= old('nomor_kamar') ?>" 
                               required>
                    </div>
                    <div class="field-group">
                        <label>Harga Sewa (Rp)</label>
                        <input type="number" 
                               name="harga_sewa" 
                               placeholder="Contoh: 500000"
                               value="<?= old('harga_sewa') ?>" 
                               required>
                    </div>
                    <div class="field-group">
                        <label>Tipe Kamar</label>
                        <select name="id_tipe_kamar" id="selectTipeKamar" required>
                            <option value="">Pilih Tipe Kamar</option>
                            <?php foreach ($tipe_kamar as $tipe): ?>
                                <option value="<?= $tipe['id_tipe_kamar'] ?>"
                                        <?= old('id_tipe_kamar') == $tipe['id_tipe_kamar'] ? 'selected' : '' ?>>
                                    <?= esc($tipe['nama_tipe_kamar']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn-inline-add" id="toggleTipeKamarForm" style="margin-top:8px;">
                            <i class="ti ti-plus"></i>
                            Tambah Tipe Kamar Baru
                        </button>
                        <div class="inline-form-wrapper" id="tipeKamarFormWrapper" style="display:none;">
                            <div class="inline-form">
                                <div id="tipeKamarAlert"></div>
                                <div class="field-group">
                                    <label>Nama Tipe Kamar</label>
                                    <input type="text" id="namaTipeKamar" placeholder="Contoh: Standar, VIP, dll">
                                </div>
                                <div class="field-group">
                                    <label>Deskripsi</label>
                                    <input type="text" id="deskripsiTipeKamar" placeholder="Deskripsi singkat tipe kamar">
                                </div>
                                <div class="inline-form-actions">
                                    <button type="button" class="btn-inline-save" id="simpanTipeKamar">
                                        <i class="ti ti-check"></i>
                                        Simpan
                                    </button>
                                    <button type="button" class="btn-inline-cancel" id="batalTipeKamar">
                                        <i class="ti ti-x"></i>
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-group">
                        <label>Fasilitas Kamar</label>
                        <select name="id_fasilitas_kamar" id="selectFasilitasKamar" required>
                            <option value="">Pilih Fasilitas Kamar</option>
                            <?php foreach ($fasilitas_kamar as $fasilitas): ?>
                                <option value="<?= $fasilitas['id_fasilitas_kamar'] ?>"
                                        <?= old('id_fasilitas_kamar') == $fasilitas['id_fasilitas_kamar'] ? 'selected' : '' ?>>
                                    <?= esc($fasilitas['nama_fasilitas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn-inline-add" id="toggleFasilitasKamarForm" style="margin-top:8px;">
                            <i class="ti ti-plus"></i>
                            Tambah Fasilitas Kamar Baru
                        </button>
                        <div class="inline-form-wrapper" id="fasilitasKamarFormWrapper" style="display:none;">
                            <div class="inline-form">
                                <div id="fasilitasKamarAlert"></div>
                                <div class="field-group">
                                    <label>Nama Fasilitas</label>
                                    <input type="text" id="namaFasilitasKamar" placeholder="Contoh: AC, Kipas Angin, dll">
                                </div>
                                <div class="field-group">
                                    <label>Deskripsi</label>
                                    <input type="text" id="deskripsiFasilitasKamar" placeholder="Deskripsi singkat fasilitas">
                                </div>
                                <div class="inline-form-actions">
                                    <button type="button" class="btn-inline-save" id="simpanFasilitasKamar">
                                        <i class="ti ti-check"></i>
                                        Simpan
                                    </button>
                                    <button type="button" class="btn-inline-cancel" id="batalFasilitasKamar">
                                        <i class="ti ti-x"></i>
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field-group">
                        <label>Status Ketersediaan</label>
                        <select name="status_ketersediaan" required>
                            <option value="">Pilih Status</option>
                            <option value="Tersedia" <?= old('status_ketersediaan') == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="Terisi" <?= old('status_ketersediaan') == 'Terisi' ? 'selected' : '' ?>>Terisi</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="right-content">
                <div class="form-card">
                    <h2>
                        <i class="ti ti-bed"></i>
                        Info Kamar
                    </h2>
                    <div class="kamar-slot-info">
                        <div class="slot-progress">
                            <div class="slot-bar">
                                <div class="slot-bar-fill" style="width: <?= $total_kamar > 0 ? ($kamar_terisi / $total_kamar * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                        <div class="slot-details">
                            <span class="slot-used"><strong><?= $kamar_terisi ?></strong> dari <strong><?= $total_kamar ?></strong> kamar sudah terisi</span>
                            <span class="slot-remaining">Sisa: <strong><?= $sisa_slot ?></strong> kamar</span>
                        </div>
                    </div>
                </div>

                <div class="form-card mt-4">
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
                            <li>Pastikan nomor kamar unik untuk setiap kost</li>
                            <li>Harga sewa dapat disesuaikan sesuai tipe dan fasilitas</li>
                            <li>Status kamar akan mempengaruhi ketersediaan saat pemesanan</li>
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
            <?php if ($sisa_slot > 0): ?>
                <button type="submit" class="btn-save">
                    <i class="ti ti-device-floppy"></i>
                    Simpan Data Kamar
                </button>
            <?php else: ?>
                <button type="button" class="btn-save" disabled style="opacity:0.5;cursor:not-allowed;">
                    <i class="ti ti-device-floppy"></i>
                    Kamar Penuh
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function showInlineAlert(elementId, message, type) {
    var el = document.getElementById(elementId);
    el.className = 'inline-alert inline-alert-' + type;
    el.textContent = message;
    el.style.display = 'block';
    setTimeout(function() { el.style.display = 'none'; }, 4000);
}

document.getElementById('toggleTipeKamarForm').addEventListener('click', function() {
    var wrapper = document.getElementById('tipeKamarFormWrapper');
    wrapper.style.display = wrapper.style.display === 'none' ? 'block' : 'none';
    document.getElementById('tipeKamarAlert').style.display = 'none';
});

document.getElementById('batalTipeKamar').addEventListener('click', function() {
    document.getElementById('tipeKamarFormWrapper').style.display = 'none';
    document.getElementById('tipeKamarAlert').style.display = 'none';
    document.getElementById('namaTipeKamar').value = '';
    document.getElementById('deskripsiTipeKamar').value = '';
});

document.getElementById('simpanTipeKamar').addEventListener('click', function() {
    var nama = document.getElementById('namaTipeKamar').value.trim();
    var deskripsi = document.getElementById('deskripsiTipeKamar').value.trim();

    if (!nama || !deskripsi) {
        showInlineAlert('tipeKamarAlert', 'Nama dan deskripsi tipe kamar wajib diisi.', 'danger');
        return;
    }

    var btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader"></i> Menyimpan...';

    var csrfName = '<?= csrf_token() ?>';
    var csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
    var formData = new FormData();
    formData.append('nama_tipe_kamar', nama);
    formData.append('deskripsi_type', deskripsi);
    formData.append(csrfName, csrfInput.value);

    fetch('<?= base_url('dashboard/kamar/ajax-tambah-tipe-kamar') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(result) {
        if (result.success) {
            if (result.csrf_hash) {
                csrfInput.value = result.csrf_hash;
            }
            var select = document.getElementById('selectTipeKamar');
            var option = document.createElement('option');
            option.value = result.data.id_tipe_kamar;
            option.textContent = result.data.nama_tipe_kamar;
            option.selected = true;
            select.appendChild(option);

            document.getElementById('tipeKamarFormWrapper').style.display = 'none';
            document.getElementById('tipeKamarAlert').style.display = 'none';
            document.getElementById('namaTipeKamar').value = '';
            document.getElementById('deskripsiTipeKamar').value = '';
        } else {
            showInlineAlert('tipeKamarAlert', result.message, 'danger');
        }
    })
    .catch(function(err) {
        console.error(err);
        showInlineAlert('tipeKamarAlert', 'Terjadi kesalahan saat menyimpan data.', 'danger');
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="ti ti-check"></i> Simpan';
    });
});

document.getElementById('toggleFasilitasKamarForm').addEventListener('click', function() {
    var wrapper = document.getElementById('fasilitasKamarFormWrapper');
    wrapper.style.display = wrapper.style.display === 'none' ? 'block' : 'none';
    document.getElementById('fasilitasKamarAlert').style.display = 'none';
});

document.getElementById('batalFasilitasKamar').addEventListener('click', function() {
    document.getElementById('fasilitasKamarFormWrapper').style.display = 'none';
    document.getElementById('fasilitasKamarAlert').style.display = 'none';
    document.getElementById('namaFasilitasKamar').value = '';
    document.getElementById('deskripsiFasilitasKamar').value = '';
});

document.getElementById('simpanFasilitasKamar').addEventListener('click', function() {
    var nama = document.getElementById('namaFasilitasKamar').value.trim();
    var deskripsi = document.getElementById('deskripsiFasilitasKamar').value.trim();

    if (!nama || !deskripsi) {
        showInlineAlert('fasilitasKamarAlert', 'Nama dan deskripsi fasilitas kamar wajib diisi.', 'danger');
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

    fetch('<?= base_url('dashboard/kamar/ajax-tambah-fasilitas-kamar') ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(result) {
        if (result.success) {
            if (result.csrf_hash) {
                csrfInput.value = result.csrf_hash;
            }
            var select = document.getElementById('selectFasilitasKamar');
            var option = document.createElement('option');
            option.value = result.data.id_fasilitas_kamar;
            option.textContent = result.data.nama_fasilitas;
            option.selected = true;
            select.appendChild(option);

            document.getElementById('fasilitasKamarFormWrapper').style.display = 'none';
            document.getElementById('fasilitasKamarAlert').style.display = 'none';
            document.getElementById('namaFasilitasKamar').value = '';
            document.getElementById('deskripsiFasilitasKamar').value = '';
        } else {
            showInlineAlert('fasilitasKamarAlert', result.message, 'danger');
        }
    })
    .catch(function(err) {
        console.error(err);
        showInlineAlert('fasilitasKamarAlert', 'Terjadi kesalahan saat menyimpan data.', 'danger');
    })
    .finally(function() {
        btn.disabled = false;
        btn.innerHTML = '<i class="ti ti-check"></i> Simpan';
    });
});
</script>
<?= $this->endSection() ?>