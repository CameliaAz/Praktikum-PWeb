<?php
session_start();

require_once __DIR__ . '/../includes/koneksi.php';
// 1. Menerima data dari form POST dengan null coalescing operator (??) dan trim
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
// 2. Validasi Server-Side
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// 3. Jika valid: Simpan data user di Session & Redirect ke index.php
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    header('Location: ../index.php');
    exit;
}
// 4. Jika tidak valid: Simpan pesan error di Session Flash & Redirect kembali ke form
$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;