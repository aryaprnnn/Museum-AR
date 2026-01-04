<x-layout title="Ticket Detail" :mainClass="'light-bg'">
  <div class="container" style="max-width:800px;padding:40px 20px;">
    <a href="{{ route('user.tickets') }}" class="btn" style="background:#fff;color:#000;border-color:#000;margin-bottom:20px;display:inline-block;transition:all 0.3s ease" onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='#fff';this.style.color='#000'"><i class="fas fa-arrow-left"></i> Kembali ke My Tickets</a>
    
    <div style="background:#fff;border:1px solid #ddd;border-radius:12px;padding:30px;box-shadow:0 4px 12px rgba(0,0,0,0.08)">
      <h1 style="margin:0 0 20px 0;font-size:2rem">Ticket Detail</h1>
      
      <div style="display:grid;gap:16px;margin-bottom:24px">
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Nama Pameran</h3>
          <p style="margin:0;font-size:1.2rem;font-weight:600">{{ $ticket->exhibition->title }}</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Tanggal</h3>
          <p style="margin:0"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($ticket->exhibition->start_date)->format('d F Y') }}</p>
        </div>
         <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Lokasi</h3>
          <p style="margin:0"><i class="fas fa-map-marker-alt"></i> {{ $ticket->exhibition->location }}</p>
        </div>
        <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Ticket Code</h3>
          <p style="margin:0;font-family:monospace;font-size:1.1rem;color:#2196F3">{{ $ticket->order_id }}</p>
        </div>
         <div>
          <h3 style="margin:0 0 6px 0;color:#555;font-size:0.95rem">Status</h3>
          <span style="background-color: {{ $ticket->status == 'paid' || $ticket->status == 'confirmed' ? '#d1e7dd' : '#fff3cd' }}; color: {{ $ticket->status == 'paid' || $ticket->status == 'confirmed' ? '#0f5132' : '#856404' }}; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
            {{ $ticket->status == 'paid' ? 'CONFIRMED' : strtoupper($ticket->status) }}
          </span>
        </div>
      </div>

      <div style="background:#fffbea;border-left:4px solid #ffc107;padding:16px;border-radius:6px">
        <h3 style="margin:0 0 8px 0;font-size:1rem"><i class="fas fa-exclamation-triangle"></i> Catatan Penting</h3>
        <ul style="margin:0;padding-left:20px;line-height:1.6">
          <li>Tunjukkan kode tiket ini di pintu masuk museum.</li>
          <li>Dilarang membawa makanan dan minuman ke dalam area pameran.</li>
          <li>Harap menjaga ketenangan selama berada di dalam museum.</li>
        </ul>
      </div>
    </div>
  </div>
</x-layout>
