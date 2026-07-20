<?= $this->extend('dashboard') ?>
<?= $this->section('content') ?>
<div class="dash">
    <div class="page-header">
        <div>
            <h1 class="page-title">Upload Bukti Pembayaran</h1>
            <p class="page-sub">
                Unggah bukti transfer pembayaran kamar kost
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="payment-info">
                <h3>Informasi Pembayaran</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>ID Pembayaran:</label>
                        <span class="badge-code">
                            <?= $pembayaran['id_pembayaran'] ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Nama Kost:</label>
                        <span><?= $pembayaran['nama_kost'] ?></span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Kamar:</label>
                        <span><?= $pembayaran['nomor_kamar'] ?></span>
                    </div>
                    <div class="info-item">
                        <label>Harga Sewa Kamar:</label>
                        <span class="amount">
                            Rp <?= number_format($pembayaran['harga_sewa'], 0, ',', '.') ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Jumlah Pembayaran:</label>
                        <span class="amount">
                            Rp <?= number_format($pembayaran['jumlah_pembayaran'], 0, ',', '.') ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pembayaran:</label>
                        <span><?php
                            $tp = $pembayaran['tanggal_pembayaran'] ?? '';
                            echo ($tp && $tp !== '0000-00-00' && $tp !== '0')
                                ? date('d M Y', strtotime($tp))
                                : '-';
                        ?></span>
                    </div>

                    <?php if (!empty($pembayaran['nama_bank']) && !empty($pembayaran['nomor_rekening'])): ?>
                    <div class="info-item rekening-info">
                        <label>Transfer ke Rekening:</label>
                        <span class="rekening">
                            <i class="ti ti-building-bank"></i>
                            <?= esc($pembayaran['nama_bank']) ?> - <?= esc($pembayaran['nomor_rekening']) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <form action="<?= base_url('dashboard/pembayaran/upload-bukti/' . $pembayaran['id_pemesanan']) ?>"
                  method="post"
                  enctype="multipart/form-data"
                  class="upload-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="bukti_pembayaran">
                        <i class="ti ti-photo"></i> Bukti Pembayaran
                    </label>
                    <input type="file"
                           id="bukti_pembayaran"
                           name="bukti_pembayaran"
                           class="form-control"
                           accept="image/jpeg,image/jpg,image/png"
                           onchange="handleFileSelect(event)"
                           required>
                    <small class="text-muted">
                        Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB
                    </small>
                    <?php if (isset($errors['bukti_pembayaran'])): ?>
                        <div class="text-danger"><?= $errors['bukti_pembayaran'] ?></div>
                    <?php endif; ?>
                </div>

                <div id="imagePreview" class="image-preview" style="display:none;">
                    <img id="previewImg" src="" alt="Preview Bukti">
                </div>

                <div id="ocrStatus" class="ocr-status" style="display:none;">
                    <div class="ocr-loading">
                        <i class="ti ti-loader"></i>
                        <span id="ocrStatusText">Menganalisa gambar...</span>
                    </div>
                    <div class="ocr-progress">
                        <div class="ocr-progress-bar" id="ocrProgressBar"></div>
                    </div>
                </div>

                <div id="ocrResult" class="ocr-result" style="display:none;">
                    <i class="ti ti-circle-check"></i>
                    <span>Nominal terdeteksi: <strong id="detectedAmount"></strong></span>
                    <small>Anda bisa mengubah nominal jika terdeteksi salah</small>
                </div>

                <input type="hidden" id="hargaSewa" value="<?= $pembayaran['harga_sewa'] ?>">

                <div class="form-group">
                    <label for="jumlah_pembayaran">
                        <i class="ti ti-currency-rupiah"></i> Nominal Pembayaran (Rp)
                    </label>
                    <input type="number"
                           id="jumlah_pembayaran"
                           name="jumlah_pembayaran"
                           class="form-control"
                           placeholder="Masukkan nominal pembayaran"
                           min="0"
                           oninput="validateNominal()"
                           required>
                    <small class="text-muted">
                        Nominal akan terisi otomatis dari bukti pembayaran. Anda bisa mengubahnya manual jika perlu.
                    </small>
                </div>

                <div id="warningMessage" class="warning-message" style="display:none;">
                    <i class="ti ti-alert-triangle"></i>
                    <span>Nominal pembayaran kurang dari harga sewa kamar (<strong id="hargaSewaText"></strong>). Silakan periksa kembali.</span>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('dashboard/pembayaran') ?>"
                       class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="ti ti-upload"></i> Upload Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.payment-info {
    margin-bottom: 20px;
}

.payment-info h3 {
    margin-bottom: 15px;
    color: #333;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item label {
    font-weight: 600;
    color: #666;
    margin-bottom: 5px;
}

.info-item span {
    color: #333;
}

.badge-code {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 14px;
}

.amount {
    font-weight: 700;
    color: #2e7d32;
    font-size: 16px;
}

.rekening-info {
    grid-column: 1 / -1;
}

.rekening {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff3e0;
    color: #e65100;
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 15px;
    border: 1px solid #ffe0b2;
}

.rekening i {
    font-size: 18px;
}

.upload-form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-group label i {
    margin-right: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-primary {
    background: #1976d2;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

.image-preview {
    margin-bottom: 20px;
    text-align: center;
}

.image-preview img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    object-fit: contain;
}

.ocr-status {
    margin-bottom: 20px;
    padding: 15px;
    background: #e3f2fd;
    border-radius: 8px;
    border: 1px solid #bbdefb;
}

.ocr-loading {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #1565c0;
    font-weight: 500;
}

.ocr-loading i {
    font-size: 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.ocr-progress {
    margin-top: 10px;
    width: 100%;
    height: 6px;
    background: #bbdefb;
    border-radius: 3px;
    overflow: hidden;
}

.ocr-progress-bar {
    height: 100%;
    width: 0%;
    background: #1976d2;
    border-radius: 3px;
    transition: width 0.3s;
}

.ocr-result {
    margin-bottom: 20px;
    padding: 12px 16px;
    background: #e8f5e9;
    border-radius: 8px;
    border: 1px solid #c8e6c9;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    color: #2e7d32;
}

.ocr-result i {
    font-size: 20px;
}

.ocr-result small {
    display: block;
    width: 100%;
    color: #666;
    font-size: 12px;
    margin-top: 2px;
}

.warning-message {
    margin-bottom: 20px;
    padding: 12px 16px;
    background: #fff3e0;
    border-radius: 8px;
    border: 1px solid #ffe0b2;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #e65100;
    font-size: 14px;
}

.warning-message i {
    font-size: 20px;
    flex-shrink: 0;
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script>
function validateNominal() {
    const jumlah = parseInt(document.getElementById('jumlah_pembayaran').value) || 0;
    const hargaSewa = parseInt(document.getElementById('hargaSewa').value) || 0;
    const warning = document.getElementById('warningMessage');
    const hargaText = document.getElementById('hargaSewaText');
    const submitBtn = document.getElementById('submitBtn');

    if (jumlah > 0 && jumlah < hargaSewa) {
        hargaText.textContent = 'Rp ' + hargaSewa.toLocaleString('id-ID');
        warning.style.display = 'flex';
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
    } else {
        warning.style.display = 'none';
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
    }
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;

    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const ocrStatus = document.getElementById('ocrStatus');
    const ocrResult = document.getElementById('ocrResult');
    const ocrStatusText = document.getElementById('ocrStatusText');
    const ocrProgressBar = document.getElementById('ocrProgressBar');
    const jumlahInput = document.getElementById('jumlah_pembayaran');

    const reader = new FileReader();
    reader.onload = function(e) {
        previewImg.src = e.target.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(file);

    ocrStatus.style.display = 'block';
    ocrResult.style.display = 'none';
    ocrStatusText.textContent = 'Menganalisa gambar...';
    ocrProgressBar.style.width = '0%';

    Tesseract.recognize(file, 'eng', {
        logger: m => {
            if (m.status === 'recognizing text') {
                const pct = Math.round(m.progress * 100);
                ocrProgressBar.style.width = pct + '%';
                ocrStatusText.textContent = 'Membaca teks... ' + pct + '%';
            } else if (m.status === 'loading language traineddata') {
                ocrStatusText.textContent = 'Memuat data bahasa...';
            } else if (m.status === 'initializing api') {
                ocrStatusText.textContent = 'Menyiapkan OCR...';
            }
        }
    }).then(({ data: { text } }) => {
        ocrProgressBar.style.width = '100%';
        ocrStatusText.textContent = 'Selesai!';

        const nominal = extractNominal(text);

        if (nominal) {
            jumlahInput.value = nominal;
            document.getElementById('detectedAmount').textContent = 'Rp ' + nominal.toLocaleString('id-ID');
            ocrResult.style.display = 'flex';
            validateNominal();
        } else {
            ocrStatusText.textContent = 'Nominal tidak terdeteksi. Silakan isi manual.';
            ocrProgressBar.style.width = '0%';
            setTimeout(() => { ocrStatus.style.display = 'none'; }, 3000);
        }
    }).catch(err => {
        ocrStatusText.textContent = 'Gagal menganalisa gambar. Silakan isi manual.';
        ocrProgressBar.style.width = '0%';
        setTimeout(() => { ocrStatus.style.display = 'none'; }, 3000);
    });
}

function extractNominal(text) {
    const patterns = [
        /Rp\.?\s*([\d.,]+)/gi,
        /(\d{1,3}(?:\.\d{3})+(?:,\d{2})?)/g,
        /(\d{1,3}(?:\.\d{3})+)/g,
        /total[:\s]*Rp\.?\s*([\d.,]+)/gi,
        /jumlah[:\s]*Rp\.?\s*([\d.,]+)/gi,
        /nominal[:\s]*Rp\.?\s*([\d.,]+)/gi,
        /transfer[:\s]*Rp\.?\s*([\d.,]+)/gi,
        /bayar[:\s]*Rp\.?\s*([\d.,]+)/gi
    ];

    let amounts = [];

    for (const pattern of patterns) {
        let match;
        pattern.lastIndex = 0;
        while ((match = pattern.exec(text)) !== null) {
            let val = match[1] || match[0];
            val = val.replace(/Rp\.?\s*/gi, '').trim();
            val = val.replace(/\./g, '').replace(',', '.');
            const num = parseFloat(val);
            if (!isNaN(num) && num > 0) {
                amounts.push(Math.round(num));
            }
        }
    }

    if (amounts.length === 0) return null;

    amounts.sort((a, b) => b - a);
    return amounts[0];
}
</script>
<?= $this->endSection() ?>
