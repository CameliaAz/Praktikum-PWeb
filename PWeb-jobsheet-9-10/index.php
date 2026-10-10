<?php
$page_title = "SIMPUS | BERANDA";
// Memanggil header (yang otomatis membuka <main>)
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
?>

<section>
  <h2>Selamat Datang Di Sistem Perpustakaan</h2>
  <p>
    Sebuah Aplikasi sederhana untuk mengelola buku dan anggota
    perpustakaan
  </p>
</section>

<section>
  <h2>Ringkasan</h2>
  <div class="stats-grid">
    <article>
      <h3>Total Buku</h3>
       <p><?php echo $totalBuku; ?></p>
    </article>
    <article>
      <h3>Total Anggota</h3>
      <p><?php echo $totalAnggota; ?></p>
    </article>
    <article>
      <h3>Sedang Dipinjam</h3>
      <p>3</p>
    </article>
    <article>
      <h3>Buku Masuk</h3>
      <p>5</p>
    </article>
  </div>
</section>


<?php
// Memanggil footer (yang otomatis menutup </main>)
include __DIR__ . '/includes/footer.php';
?>