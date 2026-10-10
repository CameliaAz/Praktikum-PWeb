<?php
session_start();

// 1. Menerima data dari form POST dengan null coalescing operator (??) dan trim
$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun_terbit'] ?? '';
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = $_POST['stok'] ?? '';
$kategori  = trim($_POST['kategori'] ?? '');

// 2. Validasi Server-Side
$errors = [];

if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

// 3. Jika ada Error: Simpan pesan error di Session Flash & Redirect kembali ke form
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit; // Wajib dipanggil untuk menghentikan skrip
}

// 4. Jika Valid: Simpan data ke $_SESSION['buku']
require_once __DIR__ . '/../includes/koneksi.php';

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)
     RETURNING id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
]);

// Set pesan sukses & Redirect ke list.php
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Buku berhasil ditambahkan.'
];

header('Location: list.php');
exit;