<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/profile.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.png') ?>">
</head>
<body>
    <div class="loading-overlay" id="logoutLoadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Sedang logout...</div>
        <div class="loading-subtext">Mohon tunggu sebentar</div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="app-layout">
        <?= $this->include('layouts/sidebar.php')?>
        <div class="main-wrapper">
            <?= $this->include('layouts/header.php')?>
            <main class="content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="display:none;">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" style="display:none;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning" style="display:none;">
                        <?= session()->getFlashdata('warning') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert alert-info" style="display:none;">
                        <?= session()->getFlashdata('info') ?>
                    </div>
                <?php endif; ?>
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="app-footer">
                <div class="footer-content">
                    <p class="footer-copyright">
                        &copy; <?= date('Y') ?> E-KOST. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const BASE_URL = "<?= base_url('') ?>";
</script>
<?= $this->renderSection('scripts') ?>
<script src="<?= base_url('js/script.js')?>"></script>
<script src="<?= base_url('js/notifications.js')?>"></script>
</body>
</html>