<x-layout title="Educational Program Detail" :mainClass="'light-bg'">
  <div class="container" style="max-width:800px;padding:40px 20px;">
    <a href="{{ route('user.bookings') }}" class="btn" style="background:#fff;color:#000;border-color:#000;margin-bottom:20px;display:inline-block;transition:all 0.3s ease" onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#000'"><i class="fas fa-arrow-left"></i> Kembali ke My Bookings</a>
    
    <div style="background:#fff;border:1px solid #ddd;border-radius:12px;padding:30px;box-shadow:0 4px 12px rgba(0,0,0,0.08)">
      <h1 style="margin:0 0 20px 0;font-size:2rem">Educational Program Detail</h1>
      
      <div style="display:grid;gap:16px;margin-bottom:24px">
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Nama Program</h3>
          <p style="margin:0;font-size:1.2rem;font-weight:600">{{ $program->title }}</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Jadwal</h3>
          <p style="margin:0"><i class="fas fa-calendar-alt"></i> {{ $program->schedule ?? '-' }}</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Lokasi</h3>
          <p style="margin:0"><i class="fas fa-map-marker-alt"></i> {{ $program->location ?? '-' }}</p>
        </div>
        <div style="display:flex;gap:30px;">
            <div>
                <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Jumlah Tiket</h3>
                <p style="margin:0;font-size:1.1rem;font-weight:600">{{ $booking->quantity }}</p>
            </div>
            <div>
                <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Total Harga</h3>
                <p style="margin:0;font-size:1.1rem;font-weight:600">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Booking Code</h3>
          <p style="margin:0;font-family:monospace;font-size:1.1rem;color:#2196F3">{{ $code }}</p>
        </div>
      </div>

      <div style="background:#fffbea;border-left:4px solid #ffc107;padding:16px;border-radius:6px">
        <h3 style="margin:0 0 8px 0;font-size:1rem"><i class="fas fa-exclamation-triangle"></i> Catatan Penting</h3>
        <ul style="margin:0;padding-left:20px;line-height:1.6">
          <li>Sertifikat akan diberikan di akhir sesi.</li>
          <li>Peserta wajib membawa kartu identitas.</li>
          <li>Materi presentasi akan dibagikan via email setelah acara.</li>
        </ul>
      </div>
    </div>
  </div>
</x-layout>
