<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Buku</h2>
            
            <form id="form-tambah" method="post" action="proses-edit.php">
                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                <p>
                    <label for="judul">Judul</label><br>
                    <input type="text" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
                </p>
                <p>
                    <label for="pengarang">Pengarang</label><br>
                    <input type="text" id="pengarang" name="pengarang" value="<?php echo $buku['pengarang']; ?>" required>
                </p>
                <p>
                    <label for="tahun">Tahun Terbit</label><br>
                    <input type="number" id="tahun" name="tahun" value="<?php echo $buku['tahun']; ?>" min="1900" max="2026" required>
                </p>
                <p> 
                    <label for="isbn">ISBN</label><br>
                    <input type="text" id="isbn" name="isbn" value="<?php echo $buku['isbn']; ?>">
                </p>
                <p>
                    <label for="stok">Stok</label><br>
                    <input type="number" id="stok" name="stok" value="<?php echo $buku['stok']; ?>" required>
                </p>
                <p>
                    <label for="kategori">Kategori</label><br>
                    <select id="kategori" name="kategori">
                        <option value="fiksi" <?php echo ($buku['kategori'] === 'fiksi') ? 'selected' : ''; ?>>Fiksi</option>
                        <option value="non-fiksi" <?php echo ($buku['kategori'] === 'non-fiksi') ? 'selected' : ''; ?>>Non-Fiksi</option>
                        <option value="referensi" <?php echo ($buku['kategori'] === 'referensi') ? 'selected' : ''; ?>>Referensi</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan Perubahan</button>
                </p>
            </form>
        </section>