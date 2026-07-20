<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.png') ?>">
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Sedang mendaftar...</div>
        <div class="loading-subtext">Mohon tunggu sebentar</div>
    </div>
    <div class="auth-container">
        <div class="auth-wrapper">
            <div class="right-auth">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
                <div class="auth-img">
                    <img src="<?= base_url('assets/rumah-kost.jpg') ?>" alt="Rumah">
                </div>
                <div class="text-auth">
                    <p>Welcome.</p>
                    <span>to our Kost Management System</span>
                </div>
                <div class="accent-bar"></div>
            </div>
            <div class="auth-form">
                <div class="auth-badge">
                    <i class="ti ti-building"></i>
                    Kost Management
                </div>
                <h1 class="auth-title">Login</h1>
                <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
                <div class="auth-divider"></div>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert" style="--bg-al-error: var(--danger);">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('login/store') ?>" method="post" class="form-main">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="ti ti-user input-icon"></i>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="ti ti-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            <i class="ti ti-eye toggle-password" onclick="togglePassword(this)"></i>
                        </div>
                    </div>
                    <button class="btn" type="submit">
                        <i class="ti ti-login"></i> Login
                    </button>
                </form>
                <p class="auth-info">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar</a></p>
                <p class="auth-info">
                    Butuh bantuan?
                    <a href="https://wa.me/6285147194415" target="_blank">
                        Hubungi admin
                    </a>
                </p>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(icon) {
            const input = icon.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';
        });
    </script>
</body>
</html>