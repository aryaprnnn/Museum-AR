# 🗄️ DATABASE ARCHITECTURE & RELATIONSHIPS

## 📊 Entity Relationship Diagram (ERD)

```
┌─────────────────────────────────────────────────────────────────┐
│                         MUSEUM AR DATABASE                      │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────┐
│     USERS        │
├──────────────────┤
│ id (PK)          │◄───────┐
│ name             │        │
│ email (UNIQUE)   │        │ (1:N)
│ password         │        │
│ whatsapp         │        │
│ role (admin)     │        │
│ timestamps       │        │
└──────────────────┘        │
                            │
                            │
                    ┌───────┴─────────┐
                    │                 │
          ┌─────────▼─────────┐  ┌──────────────────┐
          │    BOOKINGS       │  │   SESSIONS       │
          ├───────────────────┤  ├──────────────────┤
          │ id (PK)           │  │ id (PK)          │
          │ user_id (FK)      │  │ user_id (FK)     │
          │ bookable_type     │  │ ip_address       │
          │ bookable_id       │  │ payload          │
          │ booking_code      │  │ last_activity    │
          │ participant_name  │  │ timestamps       │
          │ payment_status    │  └──────────────────┘
          │ status            │
          │ timestamps        │
          └───────────────────┘
                    │
        ┌───────────┴──────────────┐
        │                          │
        │ (points to either:)      │
        │                          │
   ┌────▼──────────────┐  ┌───────▼──────────────┐
   │  ART_CLASSES      │  │ EDUCATIONAL_PROGRAMS │
   ├───────────────────┤  ├──────────────────────┤
   │ id (PK)           │  │ id (PK)              │
   │ title             │  │ title                │
   │ slug (UNIQUE)     │  │ slug (UNIQUE)        │
   │ description       │  │ description          │
   │ level             │  │ program_type         │
   │ instructor_name   │  │ facilitator_name     │
   │ schedule          │  │ schedule             │
   │ max_participants  │  │ max_participants     │
   │ price             │  │ price                │
   │ image             │  │ image                │
   │ is_active         │  │ is_active            │
   │ timestamps        │  │ timestamps           │
   └───────────────────┘  └──────────────────────┘


┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
│     BLOGS        │  │  COLLECTIONS     │  │   EXHIBITIONS    │
├──────────────────┤  ├──────────────────┤  ├──────────────────┤
│ id (PK)          │  │ id (PK)          │  │ id (PK)          │
│ title            │  │ name             │  │ title            │
│ slug (UNIQUE)    │  │ slug (UNIQUE)    │  │ slug (UNIQUE)    │
│ excerpt          │  │ description      │  │ description      │
│ content          │  │ image            │  │ status           │
│ image            │  │ category         │  │ start_date       │
│ category         │  │ year_acquired    │  │ end_date         │
│ is_published     │  │ artist_creator   │  │ location         │
│ timestamps       │  │ materials        │  │ curator_name     │
│                  │  │ dimension        │  │ image            │
│                  │  │ condition        │  │ timestamps       │
│                  │  │ hist_signif      │  │                  │
│                  │  │ timestamps       │  │                  │
└──────────────────┘  └──────────────────┘  └──────────────────┘


┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
│     CACHE        │  │      JOBS        │  │    SESSIONS      │
├──────────────────┤  ├──────────────────┤  ├──────────────────┤
│ key (PK)         │  │ id (PK)          │  │ id (PK)          │
│ value            │  │ queue            │  │ user_id (FK)     │
│ expiration       │  │ payload          │  │ ip_address       │
│                  │  │ attempts         │  │ user_agent       │
│                  │  │ reserved_at      │  │ payload          │
│                  │  │ available_at     │  │ last_activity    │
│                  │  │ created_at       │  │                  │
└──────────────────┘  └──────────────────┘  └──────────────────┘
```

---

## 🔗 Relationship Mapping

| Tabel 1 | Relasi | Tabel 2 | Deskripsi |
|---------|--------|---------|-----------|
| **users** | 1:N | **bookings** | 1 user bisa banyak bookings |
| **art_classes** | 1:N | **bookings** | 1 class bisa banyak bookings |
| **educational_programs** | 1:N | **bookings** | 1 program bisa banyak bookings |
| **users** | 1:1 | **sessions** | 1 user = 1 session aktif |
| **blogs** | - | - | Standalone (tidak ada relasi) |
| **collections** | - | - | Standalone (tidak ada relasi) |
| **exhibitions** | - | - | Standalone (tidak ada relasi) |

---

## 📝 Field Types Reference

### **String/Text**
- `varchar(255)` = Text pendek (hingga 255 karakter)
- `text` = Text panjang (hingga 65KB)
- `longtext` = Text sangat panjang (hingga 4GB)

### **Numbers**
- `bigint unsigned` = Angka besar positif (untuk ID)
- `int` = Angka standar
- `decimal(10,2)` = Angka dengan 2 desimal (untuk harga: 99.99)
- `tinyint(1)` = Boolean (true=1, false=0)

### **Date & Time**
- `date` = Tanggal saja (2025-12-14)
- `timestamp` = Waktu lengkap (2025-12-14 10:30:45)

### **Special**
- `enum` = Pilihan dari list yang ditentukan
  - Contoh: `enum('user','admin')` = hanya bisa user atau admin
  - Contoh: `enum('pending','paid','failed')` = hanya 3 pilihan

---

## 🔑 Primary & Foreign Keys

### **Primary Key (PK)**
- Identifier unik untuk setiap baris
- Tidak boleh kosong
- Tidak boleh duplikat
- Biasanya field `id`

### **Foreign Key (FK)**
- Menghubungkan tabel ke tabel lain
- Referensi ke Primary Key tabel lain
- Contoh: `bookings.user_id` → `users.id`
- Cascade: Jika user dihapus, bookingnya juga dihapus

---

## 📊 Contoh Data Flow

### **Scenario: User Mendaftar Kelas Seni**

```
1. User login
   └─> Cek session di tabel SESSIONS
       └─> session.user_id = users.id

2. User browse kelas seni
   └─> Ambil data dari USERS → ART_CLASSES

3. User klik "Daftar"
   └─> Insert ke BOOKINGS:
       {
         user_id: 1,
         bookable_type: 'App\Models\ArtClass',
         bookable_id: 5,
         booking_code: 'BKG-2025-001',
         participant_name: 'John Doe',
         payment_status: 'pending'
       }

4. User bayar via Midtrans
   └─> Update BOOKINGS:
       {
         payment_status: 'paid',
         status: 'confirmed'
       }

5. Admin dashboard
   └─> Query BOOKINGS dengan join ke USERS & ART_CLASSES
       SELECT b.*, u.name, ac.title
       FROM bookings b
       JOIN users u ON b.user_id = u.id
       JOIN art_classes ac ON b.bookable_id = ac.id
```

---

## 📈 Data Growth Estimation

| Tabel | Typical Growth | Notes |
|-------|---|---|
| **users** | 50-500/year | User baru daftar |
| **blogs** | 50-100/year | Artikel museum |
| **collections** | 100-500 | Koleksi fisik (jarang bertambah) |
| **art_classes** | 10-20 | Kelas yang tersedia |
| **educational_programs** | 5-15 | Program workshop/seminar |
| **exhibitions** | 6-24/year | Pameran baru |
| **bookings** | 100-1000/year | Tergantung pengunjung |

---

## 🔒 Backup & Maintenance

### **Backup Database Regular**
```bash
# Di Command Prompt/PowerShell
mysqldump -u root -p museum_ar > backup_museum_ar.sql
```

### **Restore dari Backup**
```bash
mysql -u root -p museum_ar < backup_museum_ar.sql
```

---

## 🎯 Indexing Strategy

**Fields yang sudah di-index otomatis:**
- `id` (Primary Key)
- `slug` (UNIQUE - untuk lookup cepat)
- `email` (UNIQUE - untuk login)
- `user_id` dalam bookings (Foreign Key)

**Fields yang bisa di-index nanti (jika perlu):**
- `created_at` (untuk sorting by date)
- `is_published` (untuk filter blog)
- `status` dalam bookings (untuk filter status)

---

## 📊 Storage Estimation

Dengan 1000 users, 500 collections, 200 bookings:
- **Total size**: ~10-20 MB
- **Grows to**: ~50-100 MB dalam 5 tahun

(Sangat kecil, tidak perlu khawatir tentang storage)

---

## 🎓 SQL Queries Umum

### **Get All Bookings dengan Detail User & Class**
```sql
SELECT 
    b.booking_code,
    b.participant_name,
    u.name as user_name,
    u.email,
    ac.title as class_title,
    b.payment_status,
    b.created_at
FROM bookings b
JOIN users u ON b.user_id = u.id
JOIN art_classes ac ON b.bookable_id = ac.id AND b.bookable_type = 'App\\Models\\ArtClass'
ORDER BY b.created_at DESC;
```

### **Get Published Blogs**
```sql
SELECT * FROM blogs 
WHERE is_published = true 
ORDER BY created_at DESC;
```

### **Count Total Bookings per User**
```sql
SELECT u.id, u.name, COUNT(b.id) as total_bookings
FROM users u
LEFT JOIN bookings b ON u.id = b.user_id
GROUP BY u.id, u.name;
```

---

## 💡 Tips & Best Practices

1. **Selalu gunakan timestamps**
   - `created_at` = kapan record dibuat
   - `updated_at` = kapan record terakhir diupdate

2. **Gunakan slug untuk URL-friendly**
   - Gunakan slug bukannya ID untuk URL
   - `/blog/5` ❌
   - `/blog/tips-menggambar-yang-benar` ✓

3. **Foreign Key Cascade**
   - Jika user dihapus, bookingnya otomatis dihapus
   - Mencegah orphaned records

4. **Enum for Fixed Values**
   - Payment status hanya: pending, paid, failed
   - Role hanya: user, admin
   - Status hanya: confirmed, cancelled

---

**Sekarang Anda memahami struktur database Museum AR! 🎉**
