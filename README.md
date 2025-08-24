# Take Home Test: Sistem Manajemen Gudang Sederhana

Aplikasi web untuk manajemen gudang sederhana yang dibuat menggunakan framework CodeIgniter 4. Aplikasi ini memungkinkan untuk mengelola data master (barang & kategori) serta mencatat transaksi barang masuk dan keluar yang secara otomatis memperbarui stok.

Proyek ini diselesaikan sebagai bagian dari proses seleksi untuk posisi Software Engineer di PT Vadhana International.

---

## Fitur Utama

-   ✅ **Manajemen Kategori:** CRUD untuk data kategori barang.
-   ✅ **Manajemen Barang:** CRUD untuk data barang, lengkap dengan relasi ke tabel kategori.
-   ✅ **Manajemen Pembelian:**
    -   Membuat data master pembelian (Informasi Vendor, Tanggal, dll.).
    -   Menambah, mengubah jumlah, dan menghapus beberapa item barang sekaligus dalam satu transaksi pembelian dengan metode "Update Keseluruhan" yang efisien.
-   ✅ **Transaksi Barang Masuk:** Memproses penerimaan barang berdasarkan data pembelian. Aksi ini secara otomatis **menambah stok** barang dan mengubah status pembelian menjadi "Completed".
-   ✅ **Transaksi Barang Keluar:** Mencatat pengeluaran barang dari gudang dengan validasi stok (stok tidak bisa minus). Aksi ini secara otomatis **mengurangi stok** barang.
-   ✅ **Laporan:** Menampilkan tiga jenis laporan dasar dengan paginasi:
    -   Laporan Stok Barang Terkini
    -   Laporan Barang Masuk
    -   Laporan Barang Keluar
-   ✅ **Layout & Navigasi:** Semua halaman terintegrasi dalam satu layout utama dengan sidebar navigasi untuk kemudahan dan konsistensi UX.
-   ✅ **Database Seeder:** Dilengkapi dengan data dummy yang logis untuk semua fitur, memudahkan proses pengetesan dan review.

---

## Teknologi yang Digunakan

-   **Framework Backend:** CodeIgniter 4
-   **Bahasa:** PHP 8.1+
-   **Database:** MySQL
-   **Styling Frontend:** TailwindCSS (via Play CDN)
-   **Web Server Lokal:** Laragon

---

## Petunjuk Instalasi & Setup

1.  Clone repositori ini atau download ZIP dan ekstrak.
2.  Buka terminal di direktori proyek, jalankan `composer install` untuk menginstal dependensi.
3.  Salin file `env` dan ubah namanya menjadi `.env`.
4.  Buka file `.env` dan sesuaikan konfigurasi database berikut:
    ```
    database.default.hostname = localhost
    database.default.database = gudang_vadhana
    database.default.username = root
    database.default.password = 
    ```
5.  Buat database baru di MySQL dengan nama `gudang_vadhana` (atau sesuai konfigurasi).
6.  Jalankan migrasi untuk membuat semua skema tabel:
    ```bash
    php spark migrate
    ```
7.  Jalankan seeder untuk mengisi database dengan data dummy yang relevan:
    ```bash
    php spark db:seed DatabaseSeeder
    ```
8.  Jalankan server pengembangan:
    ```bash
    php spark serve
    ```
9.  Aplikasi siap diakses di `http://localhost:8080`. Semua halaman dapat diakses melalui menu.

---

## Rencana Pengembangan Selanjutnya

Jika diberi waktu lebih, berikut adalah fitur-fitur yang akan menjadi prioritas selanjutnya:

-   **Otentikasi & Otorisasi:** Mengimplementasikan sistem login, register, dan proteksi route menggunakan library  **Shield** untuk memastikan keamanan aplikasi.
-   **Dashboard:** Membuat halaman utama setelah login yang menampilkan ringkasan data penting dalam bentuk kartu dan grafik (misal: total barang, transaksi hari ini, barang yang stoknya menipis).
-   **Filter Laporan:** Menambahkan fungsionalitas filter berdasarkan rentang tanggal pada semua halaman laporan untuk analisis data yang lebih mendalam.

## Tantangan Selama Pengerjaan

Tantangan utama dalam pengerjaan tes ini adalah proses adaptasi dengan framework CodeIgniter 4, karena ini adalah pengalaman pertama saya menggunakannya. Latar belakang profesional saya selama ini lebih banyak menggunakan framework Laravel (dari versi 9 hingga versi 12 terbaru) dan ReactJS untuk frontend. Proses adaptasi terhadap arsitektur, *helper*, dan *command-line tool* (`spark`) dari CI4 menjadi tantangan, sekaligus kesempatan belajar yang sangat berharga.

Tantangan teknis yang paling signifikan muncul saat melakukan *debugging* pada *fatal error* yang menghasilkan layar putih (`200 OK`) tanpa adanya log. Sebagai pengguna baru CI4, ini cukup membingungkan.

**Cara Menyelesaikan:**

Saya mengatasinya dengan proses eliminasi yang sistematis: memverifikasi Rute, Controller, `BaseController`, hingga melakukan tes "Ground Zero" pada `public/index.php`.

Setelah masalah berhasil diisolasi, saya mengambil keputusan untuk melakukan **refactoring** pada fitur tersebut. Saya mengubah arsitektur dari hapus item individual menjadi metode **"Update Keseluruhan"** (Delete and Re-insert) dalam satu transaksi database.