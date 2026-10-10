# Rancangan UI/UX & Wireframe — SIMPUS MINI

Dokumen ini berisi spesifikasi perancangan antarmuka (UI) dan alur pengguna (UX) untuk fitur-fitur baru yang akan diimplementasikan pada jobsheet berikutnya.

---

## 1. Aktor & Akses Sistem (Otorisasi)

| Aktor | Peran | Akses Fitur |
| :--- | :--- | :--- |
| **Pengunjung / Anggota** | Pengguna Umum | Beranda, Daftar Buku (Read-Only) |
| **Petugas / Admin** | Pengelola Sistem | Login, Management Buku & Anggota (CRUD), Transaksi Peminjaman & Pengembalian, Riwayat |

---

## 2. Wireframe Fitur Baru (Text-Based UI)

### 2.1 Halaman Login (`login.html`)
```text
+-------------------------------------------------------+
|                     SIMPUS MINI                       |
+-------------------------------------------------------+
|                     [ Form Login ]                    |
|                                                       |
|  Username : [________________________]                |
|  Password : [________________________]                |
|                                                       |
|             [  Masuk  ]                               |
|                                                       |
|  * Khusus untuk Petugas / Administrator               |
+-------------------------------------------------------+

2.2 Dashboard Petugas (dashboard.html)
+-------------------------------------------------------+
| SIMPUS MINI | Dashboard        [ Halo, Admin ] [Keluar]|
+-------------------------------------------------------+
| [Beranda] [Buku] [Anggota] [Peminjaman] [Riwayat]     |
+-------------------------------------------------------+
| RINGKASAN SISTEM                                      |
| +------------+ +------------+ +------------+          |
| | Total Buku | | Total Mhs  | | Dipinjam   |          |
| |    120     | |     45     | |     8      |          |
| +------------+ +------------+ +------------+          |
|                                                       |
| MENU CEPAT:                                           |
| [ + Transaksi Peminjaman ]   [ + Pengembalian Buku ]   |
+-------------------------------------------------------+

2.4 Form Pengembalian & Denda (pengembalian/proses.html)
+-------------------------------------------------------+
| Pengembalian Buku                                     |
+-------------------------------------------------------+
| ID Transaksi  : [ TRX-00214                  ] [Cari] |
| Nama Anggota  : Ahmad Dian (NIM: 220101)              |
| Judul Buku    : Pemrograman Web Modern                |
| Keterlambatan : 2 Hari                                |
| Total Denda   : Rp 4.000 (Rp 2.000 / Hari)            |
|                                                       |
| Status Bayar  : [x] Lunas                             |
|                                                       |
|                 [ Proses Pengembalian ]               |
+-------------------------------------------------------+

3. User Flow (Alur Pengguna)
3.1 Alur Transaksi Peminjaman
[Petugas Login] ---> [Dashboard] ---> [Pilih Menu Peminjaman]
                                              |
                                              v
[Selesai] <--- [Transaksi Tersimpan] <--- [Input Anggota, Buku, & Tgl]

3.2 Alur Transaksi Pengembalian & Denda
[Petugas Login] ---> [Menu Pengembalian] ---> [Cari ID Transaksi]
                                                      |
                                                      v
[Selesai] <--- [Proses Selesai] <--- [Cek Denda & Bayar]

4. Keterhubungan dengan Kode Saat Ini
index.html & CSS Jobsheet 3: Menjadi template dasar (Base Layout) untuk komponen header, nav, main, dan footer.

Form & Tabel saat ini: Rancangan form baru di atas akan memanfaatkan style form dan table yang sudah dibuat pada assets/css/style.css.

