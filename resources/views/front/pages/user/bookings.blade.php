<x-layout title="My Bookings" :mainClass="'light-bg'">
  <div class="container" style="max-width:1100px;padding:40px 20px;">
    <h1 style="margin-bottom:30px"><i class="fas fa-calendar-check"></i> My Bookings</h1>
    
    @if(session('success'))
      <div style="background:#efe;color:#3c3;padding:12px;border-radius:8px;margin-bottom:16px;">
        {{ session('success') }}
      </div>
    @endif

    @if($artclassBookings->count() > 0)
      <h2 style="font-size:1.4rem;margin-bottom:16px">Art Classes</h2>
      <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:40px">
        @foreach($artclassBookings as $booking)
          @php
            $artClass = $booking->bookable;
            $imageUrl = $artClass && $artClass->image
                ? (\Illuminate\Support\Str::startsWith($artClass->image, ['http://', 'https://'])
                    ? $artClass->image
                    : asset('storage/'.$artClass->image))
                : asset('img/placeholder.png');
          @endphp
          <div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
            <div style="flex:1;">
              <h3 style="margin:0 0 6px 0;font-size:1.2rem">{{ $artClass->title ?? '-' }}</h3>
              <p style="margin:0;color:#666"><i class="fas fa-user"></i> {{ $booking->participant_name }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-ticket-alt"></i> {{ $booking->booking_code }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-calendar-alt"></i> {{ $artClass->schedule ?? '-' }}</p>
              <p style="margin:0;color:#999;font-size:0.9rem;">Status: <strong>{{ ucfirst($booking->status) }}</strong></p>
            </div>
            <a href="{{ route('user.booking.detail', $booking->booking_code) }}" class="btn" style="margin:0;padding:8px 16px;font-size:0.9rem;white-space:nowrap;margin-left:16px;">View Detail</a>
          </div>
        @endforeach
      </div>
    @endif

    @if($educlassBookings->count() > 0)
      <h2 style="font-size:1.4rem;margin-bottom:16px">Educational Programs</h2>
      <div style="display:flex;flex-direction:column;gap:16px">
        @foreach($educlassBookings as $booking)
          @php
            $program = $booking->bookable;
            $imageUrl = $program && $program->image
                ? (\Illuminate\Support\Str::startsWith($program->image, ['http://', 'https://'])
                    ? $program->image
                    : asset('storage/'.$program->image))
                : asset('img/placeholder.png');
          @endphp
          <div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
            <div style="flex:1;">
              <h3 style="margin:0 0 6px 0;font-size:1.2rem">{{ $program->title ?? '-' }}</h3>
              <p style="margin:0;color:#666"><i class="fas fa-user"></i> {{ $booking->participant_name }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-ticket-alt"></i> {{ $booking->booking_code }}</p>
              <p style="margin:0;color:#666"><i class="fas fa-calendar-alt"></i> {{ $program->schedule }} | <i class="fas fa-map-marker-alt"></i> {{ $program->location }}</p>
              <p style="margin:0;color:#999;font-size:0.9rem;">Status: <strong>{{ ucfirst($booking->status) }}</strong></p>
            </div>
            <a href="{{ route('user.educational.detail', $booking->booking_code) }}" class="btn" style="margin:0;padding:8px 16px;font-size:0.9rem;white-space:nowrap;margin-left:16px;">View Detail</a>
          </div>
        @endforeach
      </div>
    @endif

    @if($artclassBookings->count() === 0 && $educlassBookings->count() === 0)
      <div style="text-align:center;padding:80px 20px;background:#f9f9f9;border-radius:12px;">
        <svg style="width: 100px; height: 100px; margin: 0 auto 24px; opacity: 0.2;" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
        </svg>
        <h2 style="color:#333;margin-bottom:12px;font-size:1.5rem;">Belum Ada Booking</h2>
        <p style="color:#666;margin-bottom:24px;">Anda belum melakukan booking untuk art class atau program edukasi</p>
        <a href="{{ route('artclass') }}" class="btn" style="margin-top:16px;">Mulai Booking</a>
      </div>
    @endif
  </div>
</x-layout>
