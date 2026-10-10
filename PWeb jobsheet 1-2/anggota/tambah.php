<?php
$page_title = "SIMPUS | TAMBAH ANGGOTA";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Anggota</h2>
    <!-- Menampilkan Flash Message jika ada error dari proses_tambah.php -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <form id="form-tambah" method="post" action="proses-tambah.php" novalidate>
        <p>
            <label for="nama">Nama</label><br>
            <input type="text" id="nama" name="nama" required>
        </p>
        <p>
            <label for="no_anggota">No. Anggota</label><br>
            <input type="text" id="no_anggota" name="no_anggota" required>
        </p>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email">
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat">
        </p>
        <p>
            <label for="no_hp">No. HP</label><br>
            <input type="text" id="no_hp" name="no_hp">
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>