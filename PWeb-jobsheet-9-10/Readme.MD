* **Nama:** [Camelia Azzahra]
* **NIM:** [264107023014]
* **Kelas:** [Teknik Informatika - 2G]
=======================================================================
=======================================================================

# LAPORAN PRAKTIKUM PEMOGRAMAN WEB SEMESTER 3

# JOBSHEET 9 - CRUD, Pagination dan Search Realtime

## 1. Tujuan Praktikum
* Melengkapi fitur aplikasi dengan dua operasi terakhir dari siklus CRUD, yaitu **Update (Ubah)** dan **Delete (Hapus)**.
* Menerapkan praktik keamanan basis data menggunakan prepared statements serta klausul pengaman (`WHERE`) pada operasi perubahan dan penghapusan data.
* Mengamankan proses penghapusan data dengan mewajibkan metode HTTP `POST` guna mencegah eksekusi tidak disengaja oleh *crawler* atau tautan eksternal.
* Mengimplementasikan **Pagination** (`LIMIT`/`OFFSET`) dan **Pencarian Sisi Server** (`WHERE ... ILIKE ...`) untuk menangani volume data yang besar.

---

## 2. Sub-CPMK
* Membangun dan mengintegrasikan fitur CRUD penuh pada proyek web berbasis PHP dan PostgreSQL.

---

## 3. Perubahan Utama dari Jobsheet 8
Sesuai dengan pembaruan pada Jobsheet 9, berikut adalah komponen baru yang ditambahkan:
* **Fitur Update:** Penambahan file `buku/edit.php`, `buku/proses_edit.php`, `anggota/edit.php`, dan `anggota/proses_edit.php` yang berfungsi menampilkan data lama ke dalam form serta menyimpan perubahannya ke database.
* **Fitur Delete:** Penambahan file `buku/hapus.php` dan `anggota/hapus.php` yang dikonfigurasi khusus hanya menerima metode HTTP `POST`.
* **Transformasi Tombol Hapus:** Tombol hapus di halaman `list.php` diubah dari tombol polos biasa menjadi elemen `<form class="form-hapus" method="post">` sungguhan.
* **Konfirmasi JavaScript:** Skrip pada `assets/js/app.js` (`initHapusConfirm`) disesuaikan agar menangani dialog konfirmasi pada *event* `submit` (sehingga mendukung fungsi `preventDefault()`), menggantikan *event click* sebelumnya.
* **Pagination & Server-side Search:** Halaman `list.php` pada modul buku dan anggota kini dilengkapi dengan penomoran halaman (`LIMIT`/`OFFSET`, 5 baris per halaman) serta pencarian berbasis server (`WHERE ... ILIKE ...`) menggunakan form metode `GET`.

---

## 4. Struktur Folder Proyek

```text
jobsheet-09/
├── index.php
├── includes/                         # Berisi file header.php, footer.php, koneksi.php
├── buku/
│   ├── list.php                      # Read + Pagination + Server Search + Form Hapus
│   ├── tambah.php, proses_tambah.php # Create (dari Jobsheet 8)
│   ├── edit.php                      # BARU — Form Edit terisi data lama
│   ├── proses_edit.php               # BARU — Proses UPDATE ke database
│   └── hapus.php                     # BARU — Proses DELETE (Proteksi POST)
├── anggota/                          # Struktur paralel dengan folder buku/
│   ├── list.php, tambah.php, proses_tambah.php
│   ├── edit.php, proses_edit.php, hapus.php
├── assets/
│   ├── css/style.css                 # Styling tambahan (btn-edit, pagination, form)
│   └── js/app.js                     # Logika konfirmasi hapus via event submit
├── docs/wireframe.md                 # Dokumentasi UI/UX (identik Jobsheet 8)
└── README.md
```

## 4. Hasil Praktikum
### 4.1 Update Data (edit.php & proses_edit.php)
Mengambil parameter ID dari URL ($_GET['id']) untuk melakukan kueri pencarian data lama.

Menampilkan data tersebut ke dalam atribut value="..." di dalam form HTML.

Mengeksekusi perintah SQL UPDATE ... SET ... WHERE id = :id secara aman untuk memperbarui data di database PostgreSQL.

**Bukti Implementasi Kode**
```// Mengambil data lama berdasarkan ID
$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);
```
```// 4. Jalankan UPDATE jika data valid
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
```

### 4.2 Delete Data (hapus.php)
Membatasi akses skrip penghapusan dengan memvalidasi $_SERVER['REQUEST_METHOD'] === 'POST'. Hal ini mencegah data terhapus secara tidak sengaja apabila URL diakses langsung melalui address bar.
**Bukti Implementasi Kode**

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa dipicu tanpa sengaja lewat link/preview crawler.
```if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Buku berhasil dihapus.'];
}

header('Location: list.php');
exit;
```

### 4.3 Pagination & Pencarian Sisi Server
Pagination: Menggunakan parameter LIMIT (jumlah baris per halaman, yaitu 3) dan OFFSET (titik awal data) yang diikat menggunakan tipe data integer (PDO::PARAM_INT).

Pencarian Server-side: Memanfaatkan operator ILIKE pada PostgreSQL agar proses pencarian bersifat case-insensitive (tidak membedakan huruf besar dan kecil) serta mampu mencari data lintas seluruh halaman.

**Bukti Implementasi Kode**
```$perPage = 5;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw OR pengarang ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
```
**Hasil Implementasi**
![pagination](img/pagination.png)

![realtime search](img/realtime-search.png)

## 6. Cara Menjalankan Aplikasi
**Opsi 1 — Menggunakan PHP Built-in Server**
* Buka terminal atau command prompt, lalu arahkan direktori ke folder proyek.

* Jalankan perintah:
`` php -S localhost:8000 ``

* Buka browser dan akses: http://localhost:8080/index.php.

## Kesimpulan
Berdasarkan praktikum yang telah dilakukan pada Jobsheet 9, dapat disimpulkan bahwa:

**Penyempurnaan Siklus CRUD:** Aplikasi SIMPUS-Mini kini memiliki fungsionalitas penuh yang mencakup Create, Read, Update, dan Delete. Fitur Update mmembuat proses pengubahan data menjadi lebih aman, sementara fitur Delete dilindungi menggunakan metode HTTP POST untuk mencegah eksekusi penghapusan yang tidak disengaja.

**Pencarian & Halaman Lebih Rapi:** Dengan adanya fitur Pagination (pembatas halaman) dan pencarian langsung dari server (ILIKE), aplikasi jadi lebih ringan dan bisa mencari data di semua halaman dengan mudah.

**Peningkatan Pengalaman Pengguna & Keamanan:** Integrasi antarmuka melalui penyesuaian gaya CSS tombol aksi (Edit dan Hapus) serta validasi konfirmasi berbasis event submit pada JavaScript berhasil menciptakan alur interaksi aplikasi yang lebih nyaman dan aman.

# JOBSHEET 10 - Autentikasi dan Manajemen Sesi (SIMPUS-Mini)

## 1. Tujuan Praktikum
Mahasiswa diharapkan mampu:
1. Memahami konsep manajemen sesi (*session management*) menggunakan PHP untuk mengontrol hak akses halaman.
2. Mengimplementasikan sistem autentikasi pengguna meliputi proses *Login* dan *Register* yang terhubung dengan basis data relasional (PostgreSQL).
3. Menerapkan pengamanan data kredensial menggunakan fungsi *password hashing* (`password_hash` dan `password_verify`).
4. Merancang antarmuka pengguna (*User Interface*) yang modern, responsif, dan ramah pengguna untuk sistem manajemen perpustakaan.
---

## 2. Hasil Praktikum
1. **Antarmuka Login Modern (`/auth/login.php`)**:
   * Berhasil merancang halaman login berbasis *split-screen* dua kolom yang responsif dan estetis.
   * Dilengkapi dengan ikon interaktif (*FontAwesome*) pada kolom input username dan password, serta fitur **Show/Hide Password** (ikon mata) berbasis JavaScript untuk melihat atau menyembunyikan sandi.
   * Sistem penanganan *error* berhasil menampilkan peringatan dinamis jika login gagal.
   ![tampilan login simpus mini](img/login.png)

2. **Antarmuka Registrasi (`/auth/register.php`)**:
   * Halaman registrasi dibangun dengan gaya visual yang konsisten dan selaras dengan halaman login.
   * Kolom input dilengkapi validasi ganda untuk *Password* dan *Konfirmasi Password*, masing-masing juga dilengkapi fitur *Show/Hide Password* independen.
   ![tampilan register simpus mini](img/register.png)

3. **Manajemen Sesi & Proteksi Rute**:
   * Penggunaan fungsi `session_status() === PHP_SESSION_NONE` berhasil mencegah munculnya *notice error* akibat pemanggilan sesi ganda.
   * Sistem *guard* rute berfungsi secara otomatis untuk mengamankan halaman utama (*dashboard/buku*) agar hanya bisa diakses oleh pengguna yang sudah memiliki sesi aktif.
   ![tampilan login simpus mini](img/login.png)

---

## 3. Penjelasan

* **Manajemen Sesi (*Session Management*)**: PHP menggunakan penyimpanan sisi server untuk melacak status login pengguna. Dengan memeriksa keberadaan sesi (`$_SESSION['user_id']`), aplikasi dapat membatasi hak akses halaman secara ketat. Jika pengguna mencoba mengakses halaman manajemen buku tanpa melakukan login terlebih dahulu, sistem akan secara otomatis mengarahkannya kembali ke halaman autentikasi.
* **Keamanan Kredensial (*Password Hashing*)**: Data sandi yang diinputkan oleh pengguna pada proses registrasi diamankan menggunakan fungsi enkripsi satu arah (*secure password hashing*) sebelum disimpan ke dalam basis data PostgreSQL, sehingga keamanan akun petugas perpustakaan tetap terjaga.
* **Antarmuka Pengguna (*UI/UX*)**: Pendekatan desain modern menggunakan tata letak *split-screen* memberikan pengalaman pengguna (*user experience*) yang bersih dan profesional, sangat ideal untuk sistem informasi skala mini seperti manajemen perpustakaan digital.

---

## 3. Kesimpulan

Praktikum Jobsheet 10 berhasil diselesaikan dengan mengimplementasikan sistem autentikasi dan manajemen sesi pada proyek **SIMPUS-Mini**. Integrasi antara antarmuka web modern (*split-screen UI* dengan fitur *show/hide password*), logika backend PHP, dan basis data PostgreSQL berjalan dengan baik.
Melalui praktikum ini, kita telah mempelajari dan menerapkan konsep dasar *authentication* (autentikasi) serta *authorization* (otorisasi) hak akses. Saat ini, sistem **SIMPUS-Mini** telah memiliki keamanan, di mana pengguna diwajibkan untuk melakukan *login* terlebih dahulu sebelum dapat mengakses dan melakukan operasi CRUD (Create, Read, Update, Delete) pada data perpustakaan.

