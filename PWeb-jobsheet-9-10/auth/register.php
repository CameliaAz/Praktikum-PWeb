<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Register - SIMPUS Mini";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title; ?></title>
    <!-- Font Inter & FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            display: flex;
            background: #ffffff;
            width: 100%;
            max-width: 1050px;
            min-height: 640px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .login-left {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 22px;
            color: #1e293b;
            margin-bottom: 30px;
        }

        .brand-logo i {
            background: #2563eb;
            color: #ffffff;
            padding: 10px;
            border-radius: 12px;
            font-size: 18px;
        }

        .login-left h2 {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .login-left p.subtitle {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .input-group {
            margin-bottom: 16px;
            position: relative;
        }

        .input-group i.input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .input-group i.toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .input-group i.toggle-password:hover {
            color: #2563eb;
        }

        .input-group input {
            width: 100%;
            padding: 12px 48px 12px 48px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .input-group input:focus {
            outline: none;
            background-color: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
        }

        .register-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
        }

        .register-text a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-right {
            flex: 1.1;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            margin: 12px;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            position: relative;
            color: #ffffff;
            overflow: hidden;
        }

        .login-right::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            bottom: -80px;
            left: -80px;
        }

        .hero-mockup {
            width: 100%;
            max-width: 380px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 24px;
            margin-top: 40px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .hero-mockup i {
            font-size: 54px;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .hero-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item h4 {
            font-size: 18px;
            font-weight: 700;
        }

        .stat-item p {
            font-size: 11px;
            opacity: 0.8;
        }

        .hero-caption {
            text-align: center;
            z-index: 2;
            margin-bottom: 20px;
        }

        .hero-caption h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .hero-caption p {
            font-size: 13px;
            opacity: 0.85;
            max-width: 320px;
            margin: 0 auto;
        }

        @media (max-width: 850px) {
            .login-right {
                display: none;
            }
            .login-left {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-left">
        <div class="brand-logo">
            <i class="fa-solid fa-book-bookmark"></i>
            <span>SIMPUS-Mini</span>
        </div>

        <h2>Create an Account</h2>
        <p class="subtitle">Daftarkan akun petugas baru untuk mulai mengelola perpustakaan.</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-success">
                <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="proses_register.php" method="POST">
            <div class="input-group">
                <i class="fa-regular fa-user input-icon"></i>
                <input type="text" name="username" placeholder="Username" required autocomplete="off">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa-regular fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-shield-halved input-icon"></i>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password" required>
                <i class="fa-regular fa-eye toggle-password" id="toggleConfirmPassword"></i>
            </div>

            <button type="submit" class="btn-login">Daftar Sekarang</button>
        </form>

        <p class="register-text">
            Sudah punya akun? <a href="login.php">Log in</a>
        </p>
    </div>

    <div class="login-right">
        <div class="hero-mockup">
            <i class="fa-solid fa-user-plus"></i>
            <h4 style="font-weight: 600; margin-bottom: 4px;">Akses Penuh Sistem</h4>
            <p style="font-size: 12px; opacity: 0.9;">Manajemen Data Buku & Anggota</p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <h4>Pinjam Buku</h4>
                    <p>Manajemen Peminjaman Buku</p>
                </div>
                <div class="stat-item">
                    <h4>Perpustakaan</h4>
                    <p>Manajemen Perpustakaan</p>
                </div>
            </div>
        </div>

        <div class="hero-caption">
            <h3>Bergabung dengan SIMPUS-Mini</h3>
            <p>Kelola sistem perpustakaan dengan aman, terstruktur, dan antarmuka yang modern.</p>
        </div>
    </div>
</div>

<script>
    // Toggle untuk Password Utama
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Toggle untuk Konfirmasi Password
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');

    toggleConfirmPassword.addEventListener('click', function () {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>