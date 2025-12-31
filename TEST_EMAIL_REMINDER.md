# 🧪 Cara Test Email Reminder - Step by Step

## Step 1: Jalankan Migration
```bash
php artisan migrate
```

## Step 2: Buat Data Booking untuk Testing

Buka Tinker:
```bash
php artisan tinker
```

Lalu jalankan kode ini di dalam Tinker:
```php
// Ambil user pertama (atau user yang punya email)
$user = \App\Models\User::first();

// Ambil Art Class atau Educational Program pertama
$artClass = \App\Models\ArtClass::first();

// Buat booking dengan event_date besok
$booking = \App\Models\Booking::create([
    'user_id' => $user->id,
    'bookable_type' => \App\Models\ArtClass::class,
    'bookable_id' => $artClass->id,
    'booking_code' => 'TEST-' . strtoupper(substr(md5(time()), 0, 8)),
    'participant_name' => $user->name,
    'institution' => 'Testing Institution',
    'experience_level' => 'beginner',
    'payment_method' => 'midtrans',
    'payment_status' => 'paid',
    'status' => 'confirmed',
    'event_date' => now()->addDay(), // Besok
    'reminder_enabled' => true
]);

echo "Booking created with ID: " . $booking->id;
exit
```

## Step 3: Test Kirim Email Konfirmasi

### Cara 1: Lewat Tinker
```bash
php artisan tinker
```

```php
$booking = \App\Models\Booking::first();
\Mail::to($booking->user->email)->send(new \App\Mail\BookingConfirmationMail($booking));
echo "Email konfirmasi terkirim!";
exit
```

### Cara 2: Cek Log Email
Kalau pakai `MAIL_MAILER=log`, cek di:
```
storage/logs/laravel.log
```

## Step 4: Test Kirim Email Reminder

```bash
php artisan bookings:send-reminders --days=1
```

Output yang diharapkan:
```
Sending reminders for bookings on 2025-12-15
✓ Sent reminder to user@email.com for booking TEST-ABC123
=== Summary ===
Reminders sent: 1
Failed: 0
Total processed: 1
```

## Step 5: Lihat Email yang Terkirim

### Jika pakai MAIL_MAILER=log:
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 100

# Atau buka file langsung:
# storage/logs/laravel.log
```

### Jika pakai Mailtrap (Recommended untuk Testing):
1. Daftar di https://mailtrap.io (gratis)
2. Update `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@artifactmuseum.com"
MAIL_FROM_NAME="ARtifact Museum"
```
3. Email akan masuk ke inbox Mailtrap

## Step 6: Test Scheduler Otomatis

### Development Mode:
```bash
php artisan schedule:work
```

Scheduler akan jalan setiap menit dan cek apakah ada reminder yang perlu dikirim.

### Test Manual (tanpa tunggu waktu):
```bash
# Test reminder 1 hari sebelum
php artisan bookings:send-reminders --days=1

# Test reminder 3 hari sebelum
php artisan bookings:send-reminders --days=3
```

## 🎯 Skenario Testing Lengkap:

### Skenario 1: Booking Besok
```bash
php artisan tinker
```
```php
$booking = \App\Models\Booking::first();
$booking->update(['event_date' => now()->addDay()]);
exit
```
```bash
php artisan bookings:send-reminders --days=1
# Harus terkirim!
```

### Skenario 2: Booking 3 Hari Lagi
```bash
php artisan tinker
```
```php
$booking = \App\Models\Booking::first();
$booking->update(['event_date' => now()->addDays(3), 'reminder_sent_at' => null]);
exit
```
```bash
php artisan bookings:send-reminders --days=3
# Harus terkirim!
```

### Skenario 3: Booking Sudah Kirim Reminder (Tidak Kirim Lagi)
```bash
php artisan bookings:send-reminders --days=1
# Tidak ada yang terkirim karena reminder_sent_at sudah ada
```

## 🔍 Troubleshooting:

### "No bookings found for reminders"
**Penyebab:**
- Tidak ada booking dengan event_date yang sesuai
- Reminder sudah pernah dikirim (reminder_sent_at terisi)
- Status bukan 'confirmed'
- reminder_enabled = false

**Solusi:**
```bash
php artisan tinker
```
```php
// Cek booking yang ada
\App\Models\Booking::whereNotNull('event_date')->get();

// Reset reminder
$booking = \App\Models\Booking::first();
$booking->update(['reminder_sent_at' => null]);
```

### Email Tidak Masuk
**Cek:**
1. Koneksi email di `.env` benar
2. Cek spam folder
3. Cek `storage/logs/laravel.log` untuk error

### Email Kosong / Tidak Tampil
**Cek:**
- User punya relasi ke booking
- Booking punya relasi ke bookable (ArtClass/EducationalProgram)

```bash
php artisan tinker
```
```php
$booking = \App\Models\Booking::first();
$booking->user; // Harus ada
$booking->bookable; // Harus ada (ArtClass atau EducationalProgram)
```

## 📊 Cek Status Reminder:

```bash
php artisan tinker
```
```php
// Lihat semua booking dengan event_date
\App\Models\Booking::whereNotNull('event_date')
    ->get(['id', 'booking_code', 'event_date', 'reminder_sent_at', 'reminder_enabled']);

// Lihat booking yang belum kirim reminder
\App\Models\Booking::whereNotNull('event_date')
    ->whereNull('reminder_sent_at')
    ->where('reminder_enabled', true)
    ->get();
```

## ✅ Checklist Testing:

- [ ] Migration berhasil dijalankan
- [ ] Booking dibuat dengan event_date
- [ ] Email konfirmasi terkirim saat booking dibuat
- [ ] Email reminder terkirim dengan command manual
- [ ] reminder_sent_at terisi setelah reminder terkirim
- [ ] Email tidak terkirim lagi jika reminder_sent_at sudah ada
- [ ] Scheduler berjalan otomatis (schedule:work)
- [ ] Email tampil dengan benar (cek di log atau mailtrap)

---

**Tips:** Untuk testing lebih mudah, gunakan Mailtrap.io (gratis) sebagai inbox testing email!
