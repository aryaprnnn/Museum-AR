<x-layout title="My Tickets" :mainClass="'light-bg'">
  <div class="container" style="max-width:1100px;padding:40px 20px;">
    <h1 style="margin-bottom:30px; font-weight:700; color:#333;">My Exhibition Tickets</h1>

    @if($tickets->isEmpty())
      <div style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:12px;padding:24px;text-align:center;">
        <p style="color:#666;font-size:1.1rem;margin-bottom:16px;">Anda belum memiliki tiket pameran.</p>
        <a href="{{ route('exhibitions') }}" class="btn">Lihat Pameran</a>
      </div>
    @else
      <div style="display:flex;flex-direction:column;gap:16px;">
        @foreach($tickets as $ticket)
          <div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
            <div style="flex:1;">
              <h3 style="margin:0 0 6px 0;font-size:1.2rem">{{ $ticket->exhibition->title }}</h3>
              <p style="margin:0;color:#666"><i class="fas fa-user"></i> {{ $ticket->user->name ?? session('auth_user')['name'] }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-ticket-alt"></i> {{ $ticket->order_id }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($ticket->exhibition->start_date)->format('d F Y') }} | <i class="fas fa-map-marker-alt"></i> {{ $ticket->exhibition->location }}</p>
              <p style="margin:0;color:#999;font-size:0.9rem;">Status: <strong>{{ $ticket->status == 'paid' ? 'Confirmed' : ucfirst($ticket->status) }}</strong></p>
            </div>
            <a href="{{ route('user.tickets.show', $ticket->order_id) }}" class="btn" style="margin:0;padding:8px 16px;font-size:0.9rem;white-space:nowrap;margin-left:16px;">View Detail</a>
          </div>
        @endforeach
      </div>
    @endif
    
    <div style="margin-top:30px;">
        <a href="{{ route('user.dashboard') }}" style="color:#555;text-decoration:none;font-weight:600;">&laquo; Kembali ke Dashboard</a>
    </div>
  </div>
</x-layout>
