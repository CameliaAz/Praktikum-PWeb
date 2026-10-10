<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

// 1. Ambil ID dan data dari form POST
$id        = $_POST['id'] ?? null;
$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun'] ?? '';
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = $_POST['stok'] ?? '';
$kategori  = trim($_POST['kategori'] ?? '');

// Jika tidak ada ID, kembalikan ke list.php
if (!$id) {
    header('Location: list.php');
    exit;
}

// 2. Validasi Server-Side
$errors = [];

if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > (int)date('Y')) {
    $errors[] = "Tahun tidak valid.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

// 3. Jika ada error, kembalikan ke form edit.php beserta id-nya
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'danger',
        'message' => implode('<br>', $errors)
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

// 4. Jalankan UPDATE jika data valid
$stmt = $pdo->prepare(
    "UPDATE buku SET 
        judul = :judul, 
        pengarang = :pengarang, 
        tahun = :tahun, 
        isbn = :isbn, 
        stok = :stok, 
        kategori = :kategori 
     WHERE id = :id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
    'id'        => $id,
]);

// 5. Berikan flash message sukses & redirect ke list.php
$_SESSION['flash'] = [
    'type'    => 'success',
    'message' => 'Data buku berhasil diperbarui!'
];

header('Location: list.php');
exit;