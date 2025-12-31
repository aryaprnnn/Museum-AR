# 🗄️ PANDUAN LENGKAP SETUP DATABASE MYSQL

## 📍 Lokasi File Penting
- **Konfigurasi DB**: `.env` (sudah diupdate otomatis)
- **SQL Script**: `database/create_tables.sql`
- **Panduan Detail**: `DATABASE_SETUP.md`

---

## 🚀 LANGKAH-LANGKAH CEPAT (5 MENIT)

### **Step 1: Pastikan MySQL Running**
- Jika pakai **XAMPP**: Buka XAMPP Control Panel → Start **MySQL**
- Tunggu sampai status MySQL menjadi **"Running"**

### **Step 2: Buat Database di phpMyAdmin**
1. Buka browser, ketik: `http://localhost/phpmyadmin`
2. Klik **"Databases"** di menu atas
3. Isi "Database name": `museum_ar`
4. Collation: `utf8mb4_unicode_ci` (pilih dari dropdown)
5. Klik **"Create"**

✅ Database `museum_ar` sudah terbuat!

### **Step 3: Import SQL Script (PILIH SALAH SATU)**

#### **OPSI A: Via Laravel Migrations (PALING MUDAH) ⭐**
```bash
# Buka Command Prompt/PowerShell di folder project
php artisan migrate
```
**Selesai!** Semua tabel otomatis terbuat.

---

#### **OPSI B: Via phpMyAdmin (Manual)**

1. **Klik database `museum_ar`**
2. **Klik tab "SQL"**
3. **Buka file**: `database/create_tables.sql`
4. **Copy semua isi file tersebut**
5. **Paste ke dalam form SQL di phpMyAdmin**
6. **Klik "Go" atau "Execute"**

✅ Semua tabel langsung terbuat!

---

## 📋 DAFTAR TABEL YANG AKAN DIBUAT

| No | Tabel | Fungsi | Jumlah Field |
|----|-------|--------|--------------|
| 1 | `users` | Pengguna & Admin | 7 |
| 2 | `blogs` | Artikel/Berita | 9 |
| 3 | `collections` | Koleksi Museum | 13 |
| 4 | `art_classes` | Kelas Seni | 12 |
| 5 | `educational_programs` | Program Edukasi | 12 |
| 6 | `exhibitions` | Pameran | 11 |
| 7 | `bookings` | Registrasi/Pemesanan | 11 |
| 8 | `sessions` | Session User | 6 |
| 9 | `cache` | Cache Data | 3 |
| 10 | `jobs` | Background Jobs | 7 |

**Total: 10 Tabel**

---

## 🔍 DETAIL STRUKTUR TABEL

### 1. **users** - Data Pengguna
```
id (Primary Key)
name ← Nama lengkap
email ← Email unik (untuk login)
password ← Password terenkripsi
whatsapp ← No WhatsApp (opsional)
role ← 'user' atau 'admin'
created_at & updated_at ← Timestamp otomatis
```

**Contoh Data:**
| id | name | email | role |
|----|------|-------|------|
| 1 | Admin Museum | admin@museum.com | admin |
| 2 | John Doe | john@example.com | user |

---

### 2. **blogs** - Artikel/Berita
```
id, title, slug, excerpt, content, image, category
is_published (true/false), created_at, updated_at
```

**Contoh:** Artikel tentang pameran, berita museum, tips seni, dll

---

### 3. **collections** - Koleksi Museum
```
id, name, slug, description, image, category
year_acquired, artist_creator, materials
dimension, condition, historical_significance
created_at, updated_at
```

**Contoh:** Lukisan, patung, keramik, tekstil, dll dari koleksi museum

---

### 4. **art_classes** - Kelas Seni
```
id, title, slug, description, level
instructor_name, schedule, max_participants, price, image
is_active, created_at, updated_at
```

**Contoh:** Sketsa Dasar, Lukis Cat Air, Digital Painting, dll

---

### 5. **educational_programs** - Program Edukasi
```
id, title, slug, description, program_type
target_audience, facilitator_name, schedule
max_participants, price, image
is_active, created_at, updated_at
```

**Contoh:** Workshop Konservasi, Seminar Sejarah, dll

---

### 6. **exhibitions** - Pameran
```
id, title, slug, description, status
(upcoming/ongoing/archived)
start_date, end_date, location
curator_name, image, created_at, updated_at
```

**Contoh:** Pameran Keramik, Tekstil Tradisional, AR Experience, dll

---

### 7. **bookings** - Registrasi/Pemesanan
```
id, user_id (FK ke users)
bookable_type, bookable_id
booking_code (unik - kode pemesanan)
participant_name, institution
experience_level, payment_method
payment_status, status, created_at, updated_at
```

**Contoh:** Daftar kelas, daftar seminar, beli tiket pameran

---

### 8. **sessions** - Session User (Required Laravel)
```
id, user_id, ip_address, user_agent
payload, last_activity
```

**Fungsi:** Menyimpan data session user yang sedang login

---

### 9. **cache** - Cache Data (Required Laravel)
```
key (Primary Key), value, expiration
```

**Fungsi:** Menyimpan data cache untuk performa aplikasi

---

### 10. **jobs** - Background Jobs (Required Laravel)
```
id, queue, payload, attempts
reserved_at, available_at, created_at
```

**Fungsi:** Untuk menjalankan task di background

---

## ✅ VERIFIKASI SETUP

Setelah selesai, lakukan verifikasi:

### **Via Command Line:**
```bash
# Test koneksi database
php artisan tinker
# Di dalam tinker, ketik:
DB::table('users')->count()
# Jika keluar angka (0 atau lebih), berarti OK!
```

### **Via phpMyAdmin:**
1. Pilih database `museum_ar`
2. Lihat apakah sudah ada 10 tabel di sebelah kiri
3. Klik salah satu tabel untuk melihat struktur

---

## 🚨 TROUBLESHOOTING

### **Error: "SQLSTATE[HY000]: General error: 1030"**
**Solusi:**
```bash
php artisan migrate:fresh
# atau hapus semua tabel di phpMyAdmin dan jalankan migrate lagi
```

### **Error: "Access denied for user 'root'@'localhost'"**
**Solusi:** Edit `.env`:
```
DB_USERNAME=root
DB_PASSWORD=     # (kosong jika XAMPP default)
```

### **Error: "Can't connect to MySQL server"**
**Solusi:**
- Pastikan MySQL service sudah started
- Di XAMPP: Start MySQL dari Control Panel
- Di Windows: `Services` → cari `MySQL` → Start

### **Error: "Unknown database 'museum_ar'"**
**Solusi:** Buat database terlebih dahulu di phpMyAdmin

---

## 📝 TESTING DATA (OPSIONAL)

Jika ingin menambah sample data untuk testing:

```bash
# Jalankan seeders (jika ada)
php artisan db:seed
```

Atau manual insert di phpMyAdmin:
```sql
INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES ('Test User', 'test@museum.com', bcrypt('password123'), 'user', NOW(), NOW());
```

---

## 🎯 NEXT STEPS

Setelah database siap:

1. **Jalankan server Laravel:**
   ```bash
   php artisan serve
   ```

2. **Akses aplikasi:**
   ```
   http://localhost:8000
   ```

3. **Login admin:**
   - Email: admin@museum.com
   - Password: admin123 (atau yang Anda set)

4. **Mulai mengelola:**
   - Tambah blog
   - Tambah koleksi
   - Tambah kelas seni
   - Kelola pameran
   - dll

---

## 📞 SUPPORT

Jika masih ada masalah:
1. Cek `.env` file - pastikan `DB_CONNECTION=mysql`
2. Cek `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`
3. Pastikan MySQL sudah running
4. Coba `php artisan migrate:fresh` untuk reset database

**Selamat! Database Anda sudah siap! 🎉**
