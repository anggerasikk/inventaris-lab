# 📦 Sistem Inventaris Laboratorium

> Aplikasi manajemen inventaris laboratorium berbasis web dengan fitur peminjaman barang terintegrasi

![Laravel](https://img.shields.io/badge/Laravel-12.39.0-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3.26-777BB4?style=for-the-badge&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.1.3-7952B3?style=for-the-badge&logo=bootstrap)
![MySQL](https://img.shields.io/badge/MySQL-8.0-00758F?style=for-the-badge&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)


---

## 📖 Tentang Project

**Sistem Inventaris Laboratorium** adalah aplikasi web modern yang dirancang untuk mengelola inventaris barang di laboratorium dengan sistem peminjaman terintegrasi. Aplikasi ini memungkinkan:

- 📊 Manajemen data barang secara real-time
- 👥 Sistem role-based (Admin, Mahasiswa, Dosen)
- 📋 Proses peminjaman barang dengan approval workflow
- 📄 Upload surat permohonan peminjaman
- 📱 Interface responsif untuk mobile/tablet/desktop
- 💾 Tracking stok otomatis saat peminjaman disetujui

---

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi & Otorisasi
- ✅ Registrasi pengguna (Mahasiswa/Dosen/Admin)
- ✅ Login dengan role-based access control
- ✅ Password hashing & security
- ✅ Session management

### 📦 Manajemen Barang (Admin)
- ✅ CRUD barang (Create, Read, Update, Delete)
- ✅ Kategorisasi barang (Elektronik, Alat, Bahan, Perkakas, Lainnya)
- ✅ Tracking lokasi dan kondisi barang
- ✅ Status ketersediaan barang
- ✅ Real-time stok update
- ✅ Backup barang yang dihapus (soft delete)

### 🤝 Sistem Peminjaman
- ✅ User (Mahasiswa/Dosen) dapat melihat daftar barang tersedia
- ✅ Form peminjaman dengan:
  - Pemilihan barang
  - Jumlah peminjaman
  - Tanggal pinjam & kembali
  - Keperluan/purpose
  - Upload surat permohonan (PDF/DOC/DOCX/JPG/PNG - Max 2MB)
  - No. HP peminjam

### ✅ Approval Workflow (Admin)
- ✅ Dashboard peminjaman dengan status filtering
- ✅ Approve/Reject peminjaman dengan catatan
- ✅ Mark as returned (konfirmasi pengembalian)
- ✅ Automatic stock decrease saat approved
- ✅ Automatic stock increase saat returned

###  Interface Responsif
- ✅ Mobile-first design
- ✅ Navbar sticky saat scroll
- ✅ Responsive tables dengan horizontal scroll
- ✅ Touch-friendly buttons (min-height 44px)
- ✅ Optimized untuk semua screen sizes

### 📊 Fitur Reporting (Dalam Pengembangan)
- 🔄 Laporan inventaris
- 🔄 Laporan peminjaman
- 🔄 Export ke PDF/Excel

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.39.0
- **Language**: PHP 8.3.26
- **Database**: MySQL 8.0
- **Authentication**: Laravel Auth (custom RegisterController)
- **ORM**: Eloquent
- **Design Pattern**: Observer Pattern (untuk auto stock update)

### Frontend
- **CSS Framework**: Bootstrap 5.1.3
- **Icons**: Font Awesome 6.0.0
- **Templating**: Blade (Laravel)
- **Responsiveness**: CSS Media Queries + Bootstrap Grid

### Tools & Dependencies
- **Composer**: Package management
- **Artisan**: CLI commands
- **NPM/Vite**: Asset bundling (jika diperlukan)

---

## 🚀 Instalasi

### Prasyarat
- PHP 8.3+
- MySQL 8.0+
- Composer
- Git

### Langkah 1: Clone Repository
```bash
git clone https://github.com/anggerasikk/inventaris-lab.git
cd inventaris-lab
```

### Langkah 2: Install Dependencies
```bash
composer install
```

### Langkah 3: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Langkah 4: Database Configuration
Edit file `.env` dan atur database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_lab
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 5: Migrasi Database
```bash
php artisan migrate
php artisan storage:link
```

### Langkah 6: Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://127.0.0.1:8000`

---

## ⚙️ Konfigurasi

### File Storage Configuration
Pastikan direktori storage sudah writable:
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 📖 Penggunaan

### Akun Admin
1. Register atau gunakan akun dengan role `admin`
2. Login ke dashboard admin
3. Kelola barang, approve/reject peminjaman

### Akun User (Mahasiswa/Dosen)
1. Register memilih role Mahasiswa atau Dosen
2. Login ke dashboard user
3. Lihat barang tersedia → Pinjam barang → Upload surat → Submit
4. Tunggu persetujuan dari admin
5. Lihat riwayat peminjaman

### Admin Actions
- **Dashboard**: Overview peminjaman pending/approved
- **Data Barang**: Kelola CRUD barang inventaris
- **Peminjaman**: Approve/Reject dengan catatan
- **Konfirmasi Pengembalian**: Mark as returned saat barang dikembalikan

### User Actions
- **Lihat Barang**: Browse barang tersedia untuk dipinjam
- **Detail Barang**: Lihat spesifikasi & kondisi
- **Ajukan Peminjaman**: Form dengan upload dokumen
- **Riwayat**: Tracking status peminjaman

---

## 🗄️ Struktur Database

### Tabel Utama

#### `users`
```sql
id, name, email, password, role (mahasiswa/dosen/admin), created_at, updated_at
```

#### `items`
```sql
id, name, description, quantity, category, location, condition, is_available, created_at, updated_at
```

#### `borrowings`
```sql
id, user_id, item_id, quantity, borrow_date, return_date, actual_return_date, 
status (pending/approved/rejected/returned), purpose, borrower_type, phone_number, 
letter_path, admin_notes, created_at, updated_at
```

### Relasi
- `User` hasMany `Borrowing`
- `Item` hasMany `Borrowing`
- `Borrowing` belongsTo `User` & `Item`

---

## 🎯 Fitur Lanjutan

### Observer Pattern untuk Auto Stock Update
File: `app/Observers/BorrowingObserver.php`

```php
// Saat status → approved: quantity berkurang otomatis
// Saat status → returned: quantity bertambah otomatis
// Saat status → rejected: tidak ada perubahan stok
```

### Responsive Design
- Sticky header untuk easy navigation
- Responsive tables dengan horizontal scroll
- Mobile-optimized buttons & forms
- CSS Media queries untuk breakpoints

---

## ✅ Completed Features
- [x] User authentication & registration (role-based)
- [x] CRUD barang dengan kategori
- [x] Sistem peminjaman dengan approval
- [x] Auto stock management via Observer
- [x] Upload surat permohonan
- [x] Responsive design (mobile/tablet/desktop)
- [x] User read-only item view
- [x] Admin CRUD protection
- [x] Admin approval workflow
- [x] Header sticky navigation
- [x] Dropdown cleanup (remove profile)
- [x] Available quantity display untuk users
- [x] Form improvement (barang, jumlah, no HP dalam 1 row)

---

## 🗂️ Struktur Folder Project

```
inventaris-lab/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ItemController.php
│   │   │   ├── BorrowingController.php
│   │   │   └── Auth/RegisterController.php
│   │   ├── Middleware/
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Item.php
│   │   └── Borrowing.php
│   ├── Observers/
│   │   └── BorrowingObserver.php
│   ├── Notifications/
│   │   └── BorrowingStatusNotification.php
│   └── Providers/
│       └── AppServiceProvider.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── items/
│   │   │   ├── index.blade.php
│   │   │   ├── list.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── borrowings/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── history.blade.php
│   │   │   └── partials/
│   │   │       └── borrowing-table.blade.php
│   │   └── auth/
│   ├── css/
│   └── js/
├── database/
│   ├── migrations/
│   │   ├── 2025_11_24_034441_create_items_table.php
│   │   ├── 2025_11_24_034539_create_borrowings_table.php
│   │   └── 2025_12_25_add_letter_to_borrowings.php
│   └── seeders/
├── routes/
│   ├── web.php
│   └── console.php
├── storage/
│   ├── app/public/borrowing_letters/
│   └── logs/
├── public/
├── .env.example
├── composer.json
├── README.md
└── artisan
```

---

## 🔧 Development Commands

### Database
```bash
php artisan migrate                 # Run migrations
php artisan migrate:refresh         # Refresh database
php artisan migrate:reset           # Reset database
php artisan db:seed                 # Seed database
```

### Cache & Assets
```bash
php artisan cache:clear             # Clear cache
php artisan view:clear              # Clear views
php artisan config:cache            # Cache config
php artisan storage:link            # Create storage symlink
```

### Server
```bash
php artisan serve                   # Development server
php artisan tinker                  # Interactive shell
```

---

## 📝 License

Project ini licensed under the MIT License - lihat file [LICENSE](LICENSE) untuk details.

---

## 👨‍💻 Author

**Anggerasikk**
- GitHub: [@anggerasikk](https://github.com/anggerasikk) [@fathka](https://github.com/fathka) [NAJELA-SKY](https://github.com/NAJELA-SKY)
- Project: Sistem Inventaris Laboratorium

---

## 🎉 Terima Kasih

Terima kasih telah menggunakan Sistem Inventaris Laboratorium!

---

<div align="center">

**⭐ Jika project ini membantu Anda, jangan lupa untuk beri star! ⭐**

Made with ❤️ 

</div>

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
