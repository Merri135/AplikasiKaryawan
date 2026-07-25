# Aplikasi Karyawan

## Deskripsi

Aplikasi Karyawan merupakan aplikasi berbasis web yang dirancang untuk membantu perusahaan dalam mengelola data karyawan secara terpusat. Aplikasi ini menyediakan berbagai fitur seperti pengelolaan data departemen, data karyawan, pengajuan cuti, serta manajemen pengguna berdasarkan hak akses.

Sistem dikembangkan menggunakan framework Laravel dengan konsep MVC (Model-View-Controller) dan mendukung REST API sehingga dapat diintegrasikan dengan aplikasi lain maupun diuji menggunakan Postman.

Note: Pada Pembuatan aplikasi ini saya menggunakan aplikasi dari studi kasus dari saya magang dan untuk hal itu saya juga sudah meminta konfimasi dari pihak perusahaannya. terima kasih.

---

## Fitur Utama

### HRD
- CRUD data User

  
### HRD
- Login dan Logout
- Dashboard
- Manajemen Departemen
- Manajemen Karyawan
- Manajemen Kehadiran
- Manajemen Jenis Cuti
- Persetujuan Cuti
- Laporan Data

### Supervisor
- Login
- Dashboard
- Menyetujui atau Menolak Pengajuan Cuti
- Melihat Riwayat Pengajuan Cuti

### Karyawan
- Login
- Dashboard
- Melihat Profil
- Mengajukan Cuti
- Melihat Status Pengajuan Cuti

---

## Teknologi

- Laravel 12
- PHP 8.x
- MySQL
- Bootstrap 5
- Blade Template
- REST API
- Postman
- Composer

---

## Struktur Hak Akses

| Role | Hak Akses |
|-------|-----------|
| Admin | Mengelola CRUD data USER |
| HRD | Mengelola seluruh data |
| Supervisor | Menyetujui cuti dan menolak cuti |
| Karyawan | melihat profil, dan pengajuan cuti |

---

## REST API

Endpoint yang tersedia:

### Departemen

| Method | Endpoint |
|---------|----------|
| GET | /api/departemen |
| GET | /api/departemen/{id} |
| POST | /api/departemen |
| PUT | /api/departemen/{id} |
| DELETE | /api/departemen/{id} |

### Karyawan

| Method | Endpoint |
|---------|----------|
| GET | /api/karyawan |
| GET | /api/karyawan/{id} |
| POST | /api/karyawan |
| PUT | /api/karyawan/{id} |
| DELETE | /api/karyawan/{id} |

---

# Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/username/aplikasi-karyawan.git
```

Masuk ke folder project

```bash
cd aplikasi-karyawan
```

---

## 2. Install Dependency

```bash
composer install
```

---

## 3. Copy File Environment

```bash
cp .env.example .env
```

Windows

```bash
copy .env.example .env
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Konfigurasi Database

Buka file

```
.env
```

ubah menjadi

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appkaryawan
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Migrasi Database

```bash
php artisan migrate
```

Jika menggunakan Seeder

```bash
php artisan db:seed
```

atau

```bash
php artisan migrate:fresh --seed
```

---

## 7. Storage Link

```bash
php artisan storage:link
```

---

## 8. Menjalankan Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui

```
http://127.0.0.1:8000
```

---

# Pengembang

**Nama Proyek:** Aplikasi Karyawan

**Framework:** Laravel

**Bahasa Pemrograman:** PHP

**Database:** MySQL

**Arsitektur:** MVC (Model-View-Controller)

**API:** REST API
