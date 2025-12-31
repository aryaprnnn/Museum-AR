# Panduan Email Reminder untuk Booking

## 📋 Yang Sudah Dibuat:

### 1. **Migration untuk Kolom Reminder**
File: `database/migrations/2025_12_14_100000_add_reminder_fields_to_bookings_table.php`
- Menambah kolom `event_date` (tanggal acara)
- Menambah kolom `reminder_sent_at` (kapan reminder terkirim)
- Menambah kolom `reminder_enabled` (on/off reminder)

### 2. **Email Templates**
- **Booking Confirmation** (`resources/views/emails/booking-confirmation.blade.php`)
  - Email yang dikirim saat booking pertama kali dibuat
  - Berisi detail booking lengkap
  
- **Booking Reminder** (`resources/views/emails/booking-reminder.blade.php`)
  - Email pengingat yang dikirim sebelum acara
  - Mengingatkan tanggal, waktu, dan status pembayaran

### 3. **Mailable Classes**
- `app/Mail/BookingConfirmationMail.php` - untuk email konfirmasi
- `app/Mail/BookingReminderMail.php` - untuk email reminder

### 4. **Console Command**
File: `app/Console/Commands/SendBookingReminders.php`
- Command untuk mengirim reminder otomatis
- Bisa diatur berapa hari sebelum acara

### 5. **Scheduler** (sudah di-setup di `routes/console.php`)
- Reminder 1 hari sebelum acara: jam 09:00
- Reminder 3 hari sebelum acara: jam 10:00

---

## 🚀 Cara Setup:

### Step 1: Jalankan Migration
```bash
php artisan migrate
```

### Step 2: Konfigurasi Email di `.env`

**Untuk Testing (menggunakan Mailtrap atau Log):**
```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@artifactmuseum.com"
MAIL_FROM_NAME="ARtifact Museum"
```

**Untuk Production (menggunakan Gmail):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@artifactmuseum.com"
MAIL_FROM_NAME="ARtifact Museum"
```

**Untuk Production (menggunakan SendGrid/Mailgun):**
Bisa pakai service lain seperti SendGrid, Mailgun, Amazon SES, dll.

### Step 3: Setup Queue (Opsional tapi Direkomendasikan)
```bash
# Pastikan sudah ada di .env
QUEUE_CONNECTION=database

# Jalankan queue worker
php artisan queue:work
```

### Step 4: Test Kirim Email Manual

**Test Email Reminder:**
```bash
php artisan bookings:send-reminders --days=1
```

**Untuk booking spesifik (lewat Tinker):**
```bash
php artisan tinker

# Di dalam tinker:
$booking = \App\Models\Booking::first();
\Mail::to($booking->user->email)->send(new \App\Mail\BookingReminderMail($booking));
```

### Step 5: Aktifkan Scheduler

**Untuk Development:**
```bash
# Jalankan scheduler setiap menit
php artisan schedule:work
```

**Untuk Production (di server):**
Tambahkan cron job:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📧 Cara Menggunakan di Controller:

### Saat Booking Dibuat (Kirim Konfirmasi):
```php
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

// Di controller saat booking berhasil dibuat
$booking = Booking::create([
    // ... data booking
    'event_date' => $request->event_date, // Penting!
    'reminder_enabled' => true,
]);

// Kirim email konfirmasi
Mail::to($booking->user->email)->send(new BookingConfirmationMail($booking));
```

### Kirim Reminder Manual:
```php
use App\Mail\BookingReminderMail;

Mail::to($booking->user->email)->send(new BookingReminderMail($booking));
```

---

## ⚙️ Kustomisasi Reminder:

### Ubah Waktu Pengiriman
Edit di `routes/console.php`:
```php
// Kirim reminder 2 hari sebelum jam 8 pagi
Schedule::command('bookings:send-reminders --days=2')
    ->dailyAt('08:00')
    ->timezone('Asia/Jakarta');
```

### Nonaktifkan Reminder untuk Booking Tertentu
```php
$booking->update(['reminder_enabled' => false]);
```

### Lihat Log Email (Development)
Email tersimpan di: `storage/logs/laravel.log` (jika pakai `MAIL_MAILER=log`)

---

## 🧪 Testing:

1. **Buat booking baru dengan event_date**
2. **Set event_date jadi besok:**
```php
$booking = Booking::find(1);
$booking->update(['event_date' => now()->addDay()]);
```
3. **Jalankan command:**
```bash
php artisan bookings:send-reminders --days=1
```
4. **Cek email di log atau inbox**

---

## 📝 Catatan Penting:

1. **Event Date harus diisi** saat booking dibuat
2. **User harus punya email** yang valid
3. **Scheduler harus running** untuk kirim otomatis
4. **Queue direkomendasikan** untuk performa lebih baik
5. **Email service** harus dikonfigurasi dengan benar di `.env`

---

## 🔧 Troubleshooting:

**Email tidak terkirim?**
- Cek konfigurasi `.env`
- Cek log: `storage/logs/laravel.log`
- Pastikan queue running (jika pakai queue)
- Test koneksi SMTP

**Scheduler tidak jalan?**
- Pastikan `php artisan schedule:work` running (dev)
- Pastikan cron job sudah setup (production)
- Cek timezone di config

**Reminder terkirim berkali-kali?**
- Cek kolom `reminder_sent_at` sudah terisi
- Pastikan logic di command benar

---

Silakan tanyakan jika ada yang perlu dijelaskan lebih lanjut! 🚀
