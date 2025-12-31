# 🧪 DATABASE TESTING & SAMPLE DATA

## 📋 Testing Database Connection

### **Test 1: Cek Database Terhubung (via Command Line)**

```bash
# Masuk ke laravel tinker
php artisan tinker

# Di dalam tinker, jalankan:
DB::connection()->getPdo()
```

**Output (OK):**
```
=> PDOConnection {#5849
     #connection: PDO { ... }
}
```

**Output (ERROR):**
```
SQLSTATE[HY000]: General error: 1030 Got error...
```

Jika error, cek `.env` configuration!

---

### **Test 2: Cek Tabel Terbuat**

Di dalam tinker:
```php
# Cek berapa user
DB::table('users')->count()
# Expected: 0 (atau angka jika sudah ada data)

# Cek struktur tabel users
DB::select("DESCRIBE users")

# Lihat semua tabel
DB::select("SHOW TABLES")
```

---

### **Test 3: Insert Data Test**

Di dalam tinker:
```php
# Insert user
DB::table('users')->insert([
    'name' => 'Test User',
    'email' => 'test@museum.com',
    'password' => bcrypt('password123'),
    'role' => 'user',
    'created_at' => now(),
    'updated_at' => now()
]);

# Cek apakah berhasil
DB::table('users')->where('email', 'test@museum.com')->first()
```

**Expected Output:**
```
=> {#5873
     +"id": 1,
     +"name": "Test User",
     +"email": "test@museum.com",
     +"password": "$2y$12...",
     +"whatsapp": null,
     +"role": "user",
     +"created_at": "2025-12-14 10:30:45",
     +"updated_at": "2025-12-14 10:30:45",
   }
```

---

## 📝 Sample Data untuk Testing

### **1. Insert Sample Users**

**Via tinker:**
```php
# Admin user
DB::table('users')->insert([
    'name' => 'Admin Museum',
    'email' => 'admin@museum.com',
    'password' => bcrypt('admin123'),
    'whatsapp' => '081234567890',
    'role' => 'admin',
    'created_at' => now(),
    'updated_at' => now()
]);

# Regular user
DB::table('users')->insert([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('john123'),
    'whatsapp' => '081234567891',
    'role' => 'user',
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **2. Insert Sample Blogs**

```php
DB::table('blogs')->insert([
    'title' => 'Tips Menggambar untuk Pemula',
    'slug' => 'tips-menggambar-pemula',
    'excerpt' => 'Panduan lengkap menggambar untuk yang baru memulai',
    'content' => 'Lorem ipsum dolor sit amet...',
    'category' => 'Tutorial',
    'is_published' => true,
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('blogs')->insert([
    'title' => 'Koleksi Baru di Museum Kami',
    'slug' => 'koleksi-baru-museum',
    'excerpt' => 'Berita tentang koleksi terbaru yang masuk ke museum',
    'content' => 'Kami dengan bangga mempersembahkan...',
    'category' => 'Berita',
    'is_published' => true,
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **3. Insert Sample Art Classes**

```php
DB::table('art_classes')->insert([
    'title' => 'Sketsa Dasar',
    'slug' => 'sketsa-dasar',
    'description' => 'Belajar garis, bentuk, dan shading untuk fondasi menggambar',
    'level' => 'Pemula',
    'instructor_name' => 'Rina Santoso',
    'schedule' => 'Sabtu 10:00 - 12:00 WIB',
    'max_participants' => 15,
    'price' => 350000,
    'is_active' => true,
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('art_classes')->insert([
    'title' => 'Digital Painting',
    'slug' => 'digital-painting',
    'description' => 'Teknik layer, brush, dan pencahayaan untuk karya digital',
    'level' => 'Lanjutan',
    'instructor_name' => 'Budi Wiryanto',
    'schedule' => 'Minggu 14:00 - 16:00 WIB',
    'max_participants' => 12,
    'price' => 500000,
    'is_active' => true,
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **4. Insert Sample Collections**

```php
DB::table('collections')->insert([
    'name' => 'Keramik Tradisional Jawa',
    'slug' => 'keramik-tradisional-jawa',
    'description' => 'Koleksi keramik dari periode dinasti Majapahit',
    'category' => 'Keramik',
    'year_acquired' => 2020,
    'artist_creator' => 'Master Pengrajin Jawa Kuno',
    'materials' => 'Tanah Liat',
    'dimension' => '15cm x 10cm x 8cm',
    'condition' => 'Baik',
    'historical_significance' => 'Menunjukkan teknik pengerjaan tradisional',
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('collections')->insert([
    'name' => 'Tekstil Batik Lasem',
    'slug' => 'tekstil-batik-lasem',
    'description' => 'Kain batik asli Lasem dengan motif cirebon',
    'category' => 'Tekstil',
    'year_acquired' => 2019,
    'artist_creator' => 'Pengrajin Batik Lasem',
    'materials' => 'Kain Mori, Pewarna Alam',
    'dimension' => '200cm x 120cm',
    'condition' => 'Sangat Baik',
    'historical_significance' => 'Representatif batik Pesisir utara Jawa',
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **5. Insert Sample Educational Programs**

```php
DB::table('educational_programs')->insert([
    'title' => 'Workshop Konservasi Dasar',
    'slug' => 'workshop-konservasi-dasar',
    'description' => 'Praktik menjaga artefak dengan teknik aman dan sederhana',
    'program_type' => 'Workshop',
    'target_audience' => 'Mahasiswa, Kurator Pemula',
    'facilitator_name' => 'Dr. Siti Nurhaliza',
    'schedule' => 'Minggu 10:00 - 16:00 WIB',
    'max_participants' => 20,
    'price' => 250000,
    'is_active' => true,
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('educational_programs')->insert([
    'title' => 'Seminar Sejarah Keramik',
    'slug' => 'seminar-sejarah-keramik',
    'description' => 'Memahami kronologi dan gaya keramik dari berbagai era',
    'program_type' => 'Seminar',
    'target_audience' => 'Mahasiswa, Pegiat Sejarah',
    'facilitator_name' => 'Prof. Adi Pratama',
    'schedule' => 'Minggu 13:00 - 15:00 WIB',
    'max_participants' => 50,
    'price' => 100000,
    'is_active' => true,
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **6. Insert Sample Exhibitions**

```php
DB::table('exhibitions')->insert([
    'title' => 'Jejak Keramik Nusantara',
    'slug' => 'jejak-keramik-nusantara',
    'description' => 'Pameran keramik langka dengan narasi perjalanan maritim',
    'status' => 'ongoing',
    'start_date' => '2025-01-01',
    'end_date' => '2025-02-28',
    'location' => 'Galeri Utama',
    'curator_name' => 'Tim Kurasi Museum',
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('exhibitions')->insert([
    'title' => 'Tekstil & Motif',
    'slug' => 'tekstil-motif',
    'description' => 'Eksplorasi motif kain tradisional dan adaptasi kontemporer',
    'status' => 'upcoming',
    'start_date' => '2025-03-15',
    'end_date' => '2025-04-30',
    'location' => 'Galeri Lantai 2',
    'curator_name' => 'Ibu Ratna Dewi',
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

### **7. Insert Sample Bookings**

```php
DB::table('bookings')->insert([
    'user_id' => 1,
    'bookable_type' => 'App\Models\ArtClass',
    'bookable_id' => 1,
    'booking_code' => 'BKG-2025-001',
    'participant_name' => 'John Doe',
    'experience_level' => 'Pemula',
    'payment_method' => 'midtrans',
    'payment_status' => 'paid',
    'status' => 'confirmed',
    'created_at' => now(),
    'updated_at' => now()
]);

DB::table('bookings')->insert([
    'user_id' => 2,
    'bookable_type' => 'App\Models\EducationalProgram',
    'bookable_id' => 1,
    'booking_code' => 'BKG-2025-002',
    'participant_name' => 'Jane Smith',
    'institution' => 'Universitas Indonesia',
    'payment_method' => 'manual',
    'payment_status' => 'pending',
    'status' => 'confirmed',
    'created_at' => now(),
    'updated_at' => now()
]);
```

---

## 📊 Query Examples

### **Get All Bookings dengan Detail**

```php
# Dalam tinker:
DB::table('bookings')
    ->join('users', 'bookings.user_id', '=', 'users.id')
    ->select('bookings.*', 'users.name', 'users.email')
    ->get();
```

### **Count Total Bookings per User**

```php
DB::table('users')
    ->leftJoin('bookings', 'users.id', '=', 'bookings.user_id')
    ->groupBy('users.id')
    ->selectRaw('users.id, users.name, COUNT(bookings.id) as total_bookings')
    ->get();
```

### **Get Published Blogs**

```php
DB::table('blogs')
    ->where('is_published', true)
    ->orderBy('created_at', 'desc')
    ->get();
```

### **Get Active Art Classes**

```php
DB::table('art_classes')
    ->where('is_active', true)
    ->orderBy('schedule')
    ->get();
```

### **Get Upcoming Exhibitions**

```php
DB::table('exhibitions')
    ->where('status', 'upcoming')
    ->where('start_date', '>=', now())
    ->orderBy('start_date')
    ->get();
```

---

## 🗑️ Delete All Test Data

**HATI-HATI! Ini akan menghapus semua data!**

```php
# Dalam tinker:
DB::table('bookings')->truncate();
DB::table('users')->truncate();
DB::table('blogs')->truncate();
DB::table('collections')->truncate();
DB::table('art_classes')->truncate();
DB::table('educational_programs')->truncate();
DB::table('exhibitions')->truncate();
```

Atau lebih aman dengan `php artisan migrate:fresh`

---

## ✅ Checklist Testing

- [ ] Database terkoneksi
- [ ] 10 tabel terbuat dengan benar
- [ ] Bisa insert user
- [ ] Bisa insert blog
- [ ] Bisa insert art class
- [ ] Bisa insert bookings
- [ ] Bisa query dengan join
- [ ] Foreign keys work (cascade delete)
- [ ] Timestamps otomatis ter-set

---

## 🎯 Next Steps

Setelah testing selesai dan semua OK:

1. Hapus test data: `php artisan migrate:fresh`
2. Buat user admin proper
3. Start server: `php artisan serve`
4. Test login di aplikasi
5. Mulai input data real (blogs, collections, etc)

---

**Database Anda siap untuk production! 🚀**
