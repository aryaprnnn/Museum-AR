# ✅ CHECKLIST SETUP DATABASE MYSQL

Gunakan checklist ini untuk memastikan setup berhasil dengan sempurna!

---

## 📋 PRE-SETUP CHECKLIST

- [ ] **MySQL Server sudah running**
  - XAMPP: Start MySQL dari Control Panel
  - Atau verify di Services (Windows)

- [ ] **phpMyAdmin dapat diakses**
  - Buka: `http://localhost/phpmyadmin`
  - Status: OK/Connected

- [ ] **File `.env` sudah diupdate**
  - `DB_CONNECTION=mysql` ✓
  - `DB_HOST=127.0.0.1` ✓
  - `DB_PORT=3306` ✓
  - `DB_DATABASE=museum_ar` ✓
  - `DB_USERNAME=root` ✓
  - `DB_PASSWORD=` (kosong, sesuai XAMPP default) ✓

---

## 🛠️ SETUP CHECKLIST

### **Opsi A: Via Laravel Migrations (RECOMMENDED)**

- [ ] **Step 1: Buat database di phpMyAdmin**
  - Buka phpMyAdmin: `http://localhost/phpmyadmin`
  - Klik "Databases"
  - Masukkan nama: `museum_ar`
  - Collation: `utf8mb4_unicode_ci`
  - Klik "Create"
  - **Hasil:** Database kosong sudah terbuat

- [ ] **Step 2: Jalankan migrations**
  ```bash
  # Buka Command Prompt/PowerShell di folder project
  # Pastikan di path: C:\Users\kmary\Museum_AR\
  php artisan migrate
  ```
  - **Expected Output:**
    ```
    Migrating: 2025_12_14_000000_create_users_table
    Migrated: 2025_12_14_000000_create_users_table
    Migrating: 2025_12_14_072502_create_blogs_table
    Migrated: 2025_12_14_072502_create_blogs_table
    ... (dan tabel lainnya)
    ```

- [ ] **Step 3: Verifikasi tabel berhasil dibuat**
  - Buka phpMyAdmin
  - Pilih database `museum_ar`
  - Lihat di sidebar kiri, apakah sudah ada 10 tabel:
    - [ ] users
    - [ ] blogs
    - [ ] collections
    - [ ] art_classes
    - [ ] educational_programs
    - [ ] exhibitions
    - [ ] bookings
    - [ ] cache
    - [ ] jobs
    - [ ] sessions

---

### **Opsi B: Via phpMyAdmin (Manual)**

- [ ] **Step 1: Buat database di phpMyAdmin**
  - Buka: `http://localhost/phpmyadmin`
  - Klik "Databases"
  - Masukkan: `museum_ar`
  - Collation: `utf8mb4_unicode_ci`
  - Klik "Create"

- [ ] **Step 2: Pilih database `museum_ar`**
  - Klik pada nama database di sidebar

- [ ] **Step 3: Akses tab SQL**
  - Klik tab "SQL" di menu bar

- [ ] **Step 4: Copy-Paste SQL Script**
  - Buka file: `database/create_tables.sql`
  - Copy SEMUA isi file
  - Paste ke dalam form SQL di phpMyAdmin
  - Klik tombol "Go" atau "Execute"

- [ ] **Step 5: Verifikasi**
  - Refresh halaman phpMyAdmin
  - Apakah 10 tabel sudah terbuat?

---

## 🧪 POST-SETUP VERIFICATION

### **Test 1: Cek Connection via Command Line**
```bash
php artisan tinker
```

Di dalam tinker:
```php
DB::connection()->getPdo();
```

**Expected:** Tidak ada error (jika ada error, berarti config DB salah)

---

### **Test 2: Cek Tabel Kosong**

Di dalam tinker (lanjut dari Test 1):
```php
DB::table('users')->count();
```

**Expected:** Output `0` (artinya tabel users ada tapi kosong, BENAR!)

---

### **Test 3: Lihat Struktur Tabel**

Di phpMyAdmin:
1. Pilih database `museum_ar`
2. Klik tabel `users`
3. Klik tab "Structure"
4. Verifikasi field ada:
   - [ ] id (Primary Key)
   - [ ] name
   - [ ] email
   - [ ] password
   - [ ] whatsapp
   - [ ] role
   - [ ] created_at
   - [ ] updated_at

---

### **Test 4: Cek Foreign Keys (Relasi)**

Di phpMyAdmin:
1. Pilih tabel `bookings`
2. Klik tab "Structure"
3. Lihat ada relation dari `user_id` ke `users.id`
4. **Verifikasi:** Foreign key `user_id` sudah ter-setup

---

## ✨ FINAL CHECKLIST

Sebelum mulai coding, pastikan:

- [ ] Database `museum_ar` terbuat ✓
- [ ] Semua 10 tabel terbuat ✓
- [ ] Tidak ada error saat test connection ✓
- [ ] Foreign keys sudah ter-setup ✓
- [ ] File `.env` sudah benar ✓
- [ ] Bisa akses phpMyAdmin ✓

---

## 🚀 SIAP PRODUCTION?

Jika semua checklist DONE, Anda siap untuk:

1. **Membuat user/admin:**
   ```bash
   php artisan tinker
   > $user = new App\Models\User();
   > $user->name = 'Admin Museum';
   > $user->email = 'admin@museum.com';
   > $user->password = bcrypt('admin123');
   > $user->role = 'admin';
   > $user->save();
   ```

2. **Run server:**
   ```bash
   php artisan serve
   ```

3. **Akses aplikasi:**
   - URL: `http://localhost:8000`
   - Admin Login: `admin@museum.com` / `admin123`

---

## 🆘 JIKA ADA MASALAH

### **Error: "SQLSTATE[HY000]: General error: 1030"**
- Jalankan: `php artisan migrate:fresh`
- Atau hapus semua tabel di phpMyAdmin dan jalankan `php artisan migrate`

### **Error: "Access denied for user 'root'@'localhost'"**
- Edit `.env`: ubah `DB_PASSWORD` sesuai password MySQL Anda
- Default XAMPP: `DB_PASSWORD=` (kosong)

### **Error: "Can't connect to MySQL server"**
- Pastikan MySQL running di XAMPP Control Panel
- Atau start service: `net start MySQL`

### **Tabel tidak muncul di phpMyAdmin**
- Refresh halaman browser
- Atau close/open tab phpMyAdmin
- Cek di phpMyAdmin apakah memilih database `museum_ar` yang benar

---

## 📊 STRUKTUR DATABASE FINAL

```
museum_ar (Database)
├── users (Pengguna & Admin)
├── blogs (Artikel)
├── collections (Koleksi Museum)
├── art_classes (Kelas Seni)
├── educational_programs (Program Edukasi)
├── exhibitions (Pameran)
├── bookings (Registrasi/Pemesanan)
├── sessions (Session User)
├── cache (Cache Data)
└── jobs (Background Jobs)
```

---

## 📞 NEXT STEPS

Setelah database siap:

1. [ ] Buat admin user via tinker atau SQL
2. [ ] Run: `php artisan serve`
3. [ ] Test login admin
4. [ ] Mulai input data (blog, koleksi, kelas, dll)
5. [ ] Testing seluruh fitur aplikasi

---

**SELAMAT! Database setup sudah selesai! 🎉**

Jika ada pertanyaan, silakan check file:
- `DATABASE_SETUP.md` (Panduan detail)
- `SETUP_MYSQL_QUICK.md` (Panduan cepat)
- `database/create_tables.sql` (SQL script)
