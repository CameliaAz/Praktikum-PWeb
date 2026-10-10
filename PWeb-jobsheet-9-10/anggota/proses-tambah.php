<?php
// Wajib tambahkan ini jika menggunakan $_SESSION
session_start();

require_once '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ambil input dari form dan gunakan trim() untuk membersihkan spasi awal/akhir
    $nama       = trim($_POST['nama'] ?? '');
    $no_anggota = trim($_POST['no_anggota'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $alamat     = trim($_POST['alamat'] ?? '');
    $no_hp      = trim($_POST['no_hp'] ?? '');

    // 2. Validasi input wajib
    if (empty($nama) || empty($no_anggota)) {
        die("Nama dan No. Anggota wajib diisi!");
    }

    try {
        // 3. Query insert ke tabel anggota
        $sql = "INSERT INTO anggota (nama, no_anggota, email, alamat, no_hp) 
                VALUES (:nama, :no_anggota, :email, :alamat, :no_hp)";

        $stmt = $pdo->prepare($sql);

        // 4. Eksekusi query
        $stmt->execute([
            ':nama'       => $nama,
            ':no_anggota' => $no_anggota,
            ':email'      => $email,
            ':alamat'     => $alamat,
            ':no_hp'      => $no_hp
        ]);

        // Set pesan sukses & Redirect ke list.php
        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Anggota berhasil ditambahkan.' // Disesuaikan untuk anggota
        ];

        // 5. Redirect ke halaman list anggota setelah berhasil
        header("Location: list.php");
        exit();

    } catch (PDOException $e) {
        die("Gagal menambah data anggota: " . $e->getMessage());
    }
} else {
    // Jika diakses langsung tanpa submit form, kembalikan ke halaman tambah
    header("Location: tambah.php");
    exit();
}