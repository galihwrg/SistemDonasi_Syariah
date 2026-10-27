# 🌿 Kuantum Pelopor Indonesia
### Galeri Visual Islami, Wakaf & Donasi Dakwah

Platform galeri visual dakwah syariah modern yang memadukan keindahan karya fotografi Islami, arsitektur masjid, tadabbur alam, dan kaligrafi nusantara dengan narasi hikmah serta kutipan ayat Al-Qur'an (teks Arab & terjemahan).

---

## 📖 Dokumentasi & Desain Sistem

Seluruh rancangan arsitektur sistem, desain antarmuka, dan roadmap pengerjaan magang dapat dibaca secara lengkap pada:
👉 **[PRD.md (Product Requirement Document)](PRD.md)**

---

## ✨ Fitur Utama Sistem

* **Galeri Visual Bebas Wakaf**: Seluruh karya visual berkualitas tinggi dapat dinikmati dan diunduh langsung secara gratis (*1-klik download resolusi asli*).
* **Infaq & Donasi Apresiasi (Midtrans Snap)**: Pengunjung dapat mengalirkan sedekah sukarela untuk kreator dakwah melalui pop-up Midtrans (QRIS, BSI Virtual Account, Transfer Bank).
* **Autentikasi Dual-Tab**: Pendaftaran dan portal masuk khusus untuk publik (*Umum*) dan akademisi (*Mahasiswa*).
* **Verifikasi Kontributor Bertingkat**: Fitur rekening bank terkunci hingga identitas (KTM / KTP) disetujui kurator admin.
* **Manajemen Rekening Aktif**: Pencatatan rekening bank/e-wallet pribadi untuk penyaluran bagi hasil royalti secara manual oleh admin.
* **Waktu Salat & Arah Kiblat**: Dilengkapi jadwal salat 5 waktu otomatis (Aladhan API) dan kompas arah kiblat interaktif.
* **Koleksi Saya (Bookmark)**: Fitur menyimpan karya-karya visual favorit ke folder pribadi.
* **Panel Kurasi & Moderasi Admin**:
  * Antrean Kurasi Foto (*Menunggu Review, Disetujui, Ditolak*).
  * Antrean Konfirmasi Akun Mahasiswa / Umum (Pratinjau KTM/KTP & verifikasi manual).
  * Rekapitulasi Donasi untuk acuan transfer royalti manual ke kontributor.

---

## 🛠️ Tech Stack

* **Backend Framework**: Laravel 11 (PHP 8.2+)
* **Database**: MySQL / MariaDB
* **Frontend UI**: Blade Templates, Tailwind CSS
* **Design Movement**: Refined Organic Editorial (Deep Emerald `#0F382C`, Metallic Gold `#D4AF37`, Eggshell Surface `#F9F9F6`)
* **Payment Gateway**: Midtrans Snap PHP SDK
* **External API**: Aladhan API (Jadwal Salat & Waktu Kiblat)

---

## 🚀 Panduan Menjalankan Sistem Lokal

```bash
# 1. Clone repositori
git clone https://github.com/galihwrg/SistemDonasi_Syariah.git
cd SistemDonasi_Syariah

# 2. Pasang dependensi PHP & Node
composer install
npm install

# 3. Konfigurasi Environment (.env)
cp .env.example .env
php artisan key:generate

# 4. Hubungkan Symlink Storage
php artisan storage:link

# 5. Jalankan Migrasi Database & Seeder
php artisan migrate --seed

# 6. Kompilasi Aset & Jalankan Server
npm run dev
php artisan serve
```

---

## 📄 Lisensi

Dikembangkan sebagai bagian dari program magang & inisiatif dakwah syariah **Kuantum Pelopor Indonesia**.
