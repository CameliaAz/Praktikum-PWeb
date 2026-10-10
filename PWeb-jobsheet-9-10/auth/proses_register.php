<?php
session_start();
// 1. Menerima data dari form POST dengan null coalescing operator (??) dan trim
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
// 2. Validasi Server-Side
$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($username === '') {
    $errors[] = "Username wajib diisi.";
}
if (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter.";
}
// 3. Jika ada Error: Simpan pesan error di Session Flash & Redirect kembali ke form
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: register.php');
    exit;
}
// 4. Jika Valid: Simpan data ke database
require_once __DIR__ . '/../includes/koneksi.php';
// Cek apakah username sudah digunakan
$cek = $pdo->prepare("SELECT id FROM users WHERE username = :username");
$cek->execute(['username' => $username]);
if ($cek->fetch()) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
    header('Location: register.php');
    exit;
}
// Jika username belum digunakan, simpan data ke database
$stmt = $pdo->prepare(
    "INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'petugas')"
);
$stmt->execute([
    'nama' => $nama,
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
]);

// Set pesan sukses & Redirect ke login.php
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Registrasi berhasil. Silakan login.'
];
header('Location: login.php');
exit;

