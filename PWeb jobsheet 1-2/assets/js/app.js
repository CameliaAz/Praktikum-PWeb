// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}


// ===== Konfirmasi hapus (front-end only, belum ke server) =====
// function initHapusConfirm() {
//     document.querySelectorAll(".btn-hapus").forEach(function (btn) {
//         btn.addEventListener("click", function () {
//             const row = btn.closest("tr");
//             const nama = row ? row.querySelector("td")?.textContent : "data ini";
//             const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
//             if (yakin && row) {
//                 row.remove();
//             }
//         });
//     });
// }

// Tombol Hapus kini berada di dalam <form class="form-hapus" method="post">
// yang benar-benar mengirim request DELETE ke server (buku/hapus.php,
// anggota/hapus.php). Konfirmasi dilakukan pada event "submit" agar bisa
// dibatalkan (preventDefault) sebelum request terkirim.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;

    /* ===== MENGELUARKAN PERINGATAN BERWARNA MERAH JIKA STOK >=0 ===== */
    span.style.color = "#d9534f";        // Warna merah error
    span.style.fontSize = "0.85rem";      // Ukuran teks sedikit lebih kecil
    span.style.display = "block";         // Memaksa turun ke baris baru di bawah input
    span.style.marginTop = "0.25rem";     // Memberi sedikit jarak dari kotak input

    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        const tahun = form.querySelector("[name='tahun_terbit'], [name='tahun_terbit']");
        const tahunSekarang = new Date().getFullYear();
        if (tahun) {
            const valTahun = parseInt(tahun.value);
            if (!tahun.value || isNaN(valTahun)) {
                tampilkanError(tahun, "Tahun terbit wajib diisi.");
                valid = false;
            } else if (valTahun < 1900 || valTahun > tahunSekarang) {
                tampilkanError(tahun, `Tahun harus antara 1900 - ${tahunSekarang}.`);
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const valStok = parseInt(stok.value);
            if (stok.value.trim() === "" || isNaN(valStok)) {
                tampilkanError(stok, "Stok wajib diisi angka.");
                valid = false;
            } else if (valStok < 0) {
                tampilkanError(stok, "Stok tidak boleh bernilai negatif.");
                valid = false; // Mencegah submit jika stok < 0
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function(){
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
