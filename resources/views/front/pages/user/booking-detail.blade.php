<x-layout title="Booking Detail" :mainClass="'light-bg'">
  <div class="container" style="max-width:800px;padding:40px 20px;">
    <a href="{{ route('user.bookings') }}" class="btn" style="background:#fff;color:#000;border-color:#000;margin-bottom:20px;display:inline-block;transition:all 0.3s ease" onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#000'"><i class="fas fa-arrow-left"></i> Kembali ke My Bookings</a>
    
    <div style="background:#fff;border:1px solid #ddd;border-radius:12px;padding:30px;box-shadow:0 4px 12px rgba(0,0,0,0.08)">
      <h1 style="margin:0 0 20px 0;font-size:2rem">Booking Detail</h1>
      
      <div style="display:grid;gap:16px;margin-bottom:24px">
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Nama Kelas</h3>
          <p style="margin:0;font-size:1.2rem;font-weight:600">Sketsa Dasar</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Tanggal & Waktu</h3>
          <p style="margin:0"><i class="fas fa-calendar-alt"></i> 20 Jan 2025, 10:00 - 12:00 WIB</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Booking Code</h3>
          <p style="margin:0;font-family:monospace;font-size:1.1rem;color:#2196F3">{{ $code }}</p>
        </div>
      </div>

      <div style="background:#fffbea;border-left:4px solid #ffc107;padding:16px;border-radius:6px">
        <h3 style="margin:0 0 8px 0;font-size:1rem"><i class="fas fa-exclamation-triangle"></i> Catatan Penting</h3>
        <ul style="margin:0;padding-left:20px;line-height:1.6">
          <li>Harap datang 15 menit sebelum kelas dimulai.</li>
          <li>Bawa alat tulis dan sketsa Anda sendiri.</li>
          <li>Pembatalan dapat dilakukan maksimal 24 jam sebelum jadwal.</li>
        </ul>
      </div>
    </div>
  </div>
</x-layout>
