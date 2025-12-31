# Setup Database MySQL untuk Museum AR

## 📋 Langkah-Langkah Setup

### **CARA 1: Menggunakan Laravel Migrations (RECOMMENDED ⭐)**

Cara ini adalah yang paling mudah dan otomatis membuat semua tabel dengan struktur yang benar.

#### **Step 1: Buat Database di phpMyAdmin**
1. Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
2. Klik tab **"Databases"**
3. Di bagian "Create database", masukkan nama: `museum_ar`
4. Pilih **Collation**: `utf8mb4_unicode_ci`
5. Klik **"Create"**

#### **Step 2: Jalankan Migrations**
Buka **Command Prompt / PowerShell** di folder project dan jalankan:

```bash
php artisan migrate
```

**Selesai!** Semua tabel akan otomatis dibuat dengan struktur yang benar.

---

### **CARA 2: Manual menggunakan phpMyAdmin (Jika Cara 1 tidak berhasil)**

#### **Step 1: Buat Database**
1. Buka phpMyAdmin
2. Buat database dengan nama: `museum_ar`

#### **Step 2: Jalankan Script SQL berikut**

**Copy-paste salah satu cara di bawah:**

##### **Opsi A: Salin semua SQL sekaligus**

```sql
-- Database: museum_ar

-- Table: users (Untuk login admin & user)
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `whatsapp` varchar(20),
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: blogs (Untuk artikel/blog)
CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `excerpt` text,
  `content` longtext NOT NULL,
  `image` varchar(255),
  `category` varchar(255),
  `is_published` boolean DEFAULT false,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: collections (Untuk koleksi museum)
CREATE TABLE `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text,
  `image` varchar(255),
  `category` varchar(255),
  `year_acquired` year,
  `artist_creator` varchar(255),
  `materials` text,
  `dimension` varchar(255),
  `condition` varchar(255),
  `historical_significance` text,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: art_classes (Untuk kelas seni)
CREATE TABLE `art_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text,
  `level` varchar(255),
  `instructor_name` varchar(255),
  `schedule` varchar(255),
  `max_participants` int,
  `price` decimal(10,2),
  `image` varchar(255),
  `is_active` boolean DEFAULT true,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: educational_programs (Untuk program edukasi)
CREATE TABLE `educational_programs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text,
  `program_type` varchar(255),
  `target_audience` varchar(255),
  `facilitator_name` varchar(255),
  `schedule` varchar(255),
  `max_participants` int,
  `price` decimal(10,2),
  `image` varchar(255),
  `is_active` boolean DEFAULT true,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: exhibitions (Untuk pameran)
CREATE TABLE `exhibitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text,
  `status` enum('upcoming','ongoing','archived') DEFAULT 'upcoming',
  `start_date` date,
  `end_date` date,
  `location` varchar(255),
  `curator_name` varchar(255),
  `image` varchar(255),
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: bookings (Untuk pemesanan/registrasi)
CREATE TABLE `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint unsigned NOT NULL,
  `bookable_type` varchar(255) NOT NULL,
  `bookable_id` bigint unsigned NOT NULL,
  `booking_code` varchar(255) NOT NULL UNIQUE,
  `participant_name` varchar(255) NOT NULL,
  `institution` varchar(255),
  `experience_level` varchar(255),
  `payment_method` enum('midtrans','manual') DEFAULT 'midtrans',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `status` enum('confirmed','cancelled') DEFAULT 'confirmed',
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache (Untuk cache Laravel)
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cache_locks (Untuk lock cache)
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL PRIMARY KEY,
  `owner` varchar(100),
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: jobs (Untuk background jobs)
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: sessions (Untuk session Laravel)
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint unsigned,
  `ip_address` varchar(45),
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 📊 Penjelasan Database

| Tabel | Fungsi |
|-------|--------|
| **users** | Menyimpan data user & admin |
| **blogs** | Menyimpan artikel/berita |
| **collections** | Menyimpan koleksi museum |
| **art_classes** | Menyimpan data kelas seni |
| **educational_programs** | Menyimpan program edukasi |
| **exhibitions** | Menyimpan data pameran |
| **bookings** | Menyimpan pemesanan/registrasi |
| **sessions** | Menyimpan session user (required by Laravel) |
| **cache** | Cache data (required by Laravel) |
| **jobs** | Background jobs (required by Laravel) |

---

## ✅ Cara Menjalankan Script SQL di phpMyAdmin

1. **Buka phpMyAdmin** → pilih database `museum_ar`
2. Klik tab **"SQL"**
3. **Copy-paste** seluruh SQL script di atas
4. Klik **"Go"** atau **"Execute"**
5. **Selesai!** Semua tabel akan tercipta

---

## 🔐 Data Admin Default (OPSIONAL)

Jika ingin membuat user admin default, gunakan script ini:

```sql
-- Insert admin user (password: admin123 - sudah di-hash)
INSERT INTO `users` 
(`name`, `email`, `password`, `role`, `created_at`, `updated_at`) 
VALUES 
('Admin Museum', 'admin@museum.com', '$2y$12$XXXXXX...', 'admin', NOW(), NOW());
```

**Catatan:** Password harus di-hash menggunakan `bcrypt`. Lebih mudah dibuat via aplikasi.

---

## 🎯 Alternatif: Jika Ingin Testing dengan Seeder

Setelah migrations berhasil, jalankan:

```bash
php artisan db:seed
```

---

## ❓ Jika Ada Masalah

### Error: "Access denied for user 'root'@'localhost'"
- Ubah `DB_PASSWORD` di `.env` sesuai password MySQL Anda
- Default XAMPP biasanya kosong (DB_PASSWORD=)

### Error: "SQLSTATE[HY000]: General error: 1030 Got error..."
- Jalankan: `php artisan migrate:fresh`
- Atau reset database di phpMyAdmin dan jalankan `php artisan migrate` ulang

### Connection Refused
- Pastikan MySQL server sudah berjalan
- Di XAMPP: Start MySQL dari Control Panel

---

**Sekarang Anda siap menggunakan MySQL! 🚀**
