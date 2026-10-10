<?php
$page_title = "SIMPUS | TAMBAH BUKU";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Buku</h2>
            <!-- Menampilkan Flash Message jika ada error dari proses_tambah.php -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
            <form id="form-tambah" method="post" action="proses-tambah.php" novalidate>
    <p>
        <label for="judul">Judul</label><br>
        <input type="text" id="judul" name="judul" required>
    </p>
    <p>
        <label for="pengarang">Pengarang</label><br>
        <input type="text" id="pengarang" name="pengarang" required>
    </p>
    <p>
        <label for="tahun">Tahun Terbit</label><br>
        <input type="number" id="tahun" name="tahun_terbit" min="1900" max="2026" required>
    </p>
    <p>
        <label for="isbn">ISBN</label><br>
        <input type="text" id="isbn" name="isbn">
    </p>
    <p>
        <label for="stok">Stok</label><br>
        <input type="number" id="stok" name="stok" required>
    </p>
    <p>
        <label for="kategori">Kategori</label><br>
        <select id="kategori" name="kategori">
            <option value="fiksi">Fiksi</option>
            <option value="non-fiksi">Non-Fiksi</option>
            <option value="referensi">Referensi</option>
        </select>
    </p>
    <p>
        <button type="submit">Simpan</button>
    </p>
    </form>
        </section>
    <?php include __DIR__ . '/../includes/footer.php'; ?> 
</body>
</html>