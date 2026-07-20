<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.png') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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
                    <p>Create Account.</p>
                    <span>
                        Mulai perjalanan Anda bersama E-KOST. Kelola seluruh operasional kost
                        dalam satu sistem yang cepat, aman, dan mudah digunakan.
                    </span>
                </div>
                <div class="accent-bar"></div>
            </div>
            <div class="auth-form">
                <div class="auth-badge">
                    <img src="<?= base_url('assets/logo-kost.png')?>" alt="logo" class="logo">
                    Kost Management
                </div>
                <h1 class="auth-title">Registrasi</h1>
                <p class="auth-subtitle">
                    Buat akun baru untuk melanjutkan
                </p>
                <div class="auth-divider"></div>
                <form action="<?= base_url('register/store') ?>" method="post" class="form-main">

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="ti ti-user input-icon"></i>
                            <input type="text" name="name" id="name"
                                class="form-control"
                                placeholder="John Doe" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="ti ti-user input-icon"></i>
                            <input type="text" name="username" id="username"
                                class="form-control"
                                placeholder="Username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role">Daftar Sebagai</label>
                        <div class="input-wrapper">
                            <i class="ti ti-users input-icon"></i>
                            <select name="role" id="role"
                                class="form-control" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <option value="konsumen">Konsumen</option>
                                <option value="pemilik">Pemilik Kos</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">No. Handphone</label>
                        <div class="input-wrapper">
                            <i class="ti ti-phone input-icon"></i>
                            <input type="text" name="phone" id="phone"
                                class="form-control"
                                placeholder="08123456789" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="ti ti-lock input-icon"></i>
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="••••••••"
                                required>
                        </div>
                        <small class="form-text" id="passwordHelp">
                            Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
                        </small>
                        <div class="form-text" id="passwordStrength"></div>
                    </div>

                    <button class="btn" type="submit">
                        <i class="ti ti-user-plus"></i> Registrasi
                    </button>
                </form>
                <p class="auth-info">
                    Sudah punya akun?
                    <a href="<?= base_url('login') ?>">Login</a>
                </p>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.classList.add('active');
        });
        const password = document.getElementById('password');
        const strength = document.getElementById('passwordStrength');
        password.addEventListener('input', function () {
            const value = this.value;
            let score = 0;
            if (value.length >= 8) score++;
            if (/[a-z]/.test(value)) score++;
            if (/[A-Z]/.test(value)) score++;
            if (/\d/.test(value)) score++;
            if (/[^A-Za-z0-9]/.test(value)) score++;
            switch(score){
                case 0:
                case 1:
                case 2:
                    strength.innerHTML = '<span style="color:red">Password Lemah</span>';
                    break;
                case 3:
                case 4:
                    strength.innerHTML = '<span style="color:orange">Password Sedang</span>';
                    break;
                case 5:
                    strength.innerHTML = '<span style="color:green">Password Kuat</span>';
                    break;
            }
        });
    </script>
</body>
</html>