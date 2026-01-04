<x-layout title="My Dashboard" :mainClass="'light-bg'">
  <div class="container" style="max-width:1100px;padding:40px 20px;">
    <h1 style="margin-bottom:30px;font-size:2.5rem">Hi, {{ $user->name ?? 'Pengunjung' }}</h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:20px;margin-bottom:40px">
      <div style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
        <h3 style="margin:0 0 10px 0;font-size:1.1rem;color:#555"><i class="fas fa-palette"></i> Bookings (Art & Edu)</h3>
        <p style="font-size:2rem;font-weight:600;margin:0 0 10px 0;color:#000">{{ $artclassBookings->count() + $educlassBookings->count() }}</p>
        <a href="{{ route('user.bookings') }}" class="btn" style="padding:6px 12px;font-size:0.9rem;">View Bookings</a>
      </div>
      <div style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
        <h3 style="margin:0 0 10px 0;font-size:1.1rem;color:#555"><i class="fas fa-ticket-alt"></i> My Exhibition Tickets</h3>
        <p style="font-size:2rem;font-weight:600;margin:0 0 10px 0;color:#000">{{ \App\Models\Ticket::where('user_id', $user->id)->count() }}</p>
        <a href="{{ route('user.tickets') }}" class="btn" style="padding:6px 12px;font-size:0.9rem;">View Tickets</a>
      </div>
    </div>

    <div style="background:#fff;border:1px solid #ddd;border-radius:12px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.05)">
      <h2 style="margin:0 0 16px 0;font-size:1.4rem"><i class="fas fa-calendar-alt"></i> Upcoming Schedule</h2>
      <ul style="list-style:none;padding:0;margin:0">
        @php
          $upcoming = collect([]);
          foreach($artclassBookings as $b) if($b->bookable && $b->bookable->schedule) $upcoming->push(['title'=>$b->bookable->title,'schedule'=>$b->bookable->schedule,'type'=>'ArtClass']);
          foreach($educlassBookings as $b) if($b->bookable && $b->bookable->schedule) $upcoming->push(['title'=>$b->bookable->title,'schedule'=>$b->bookable->schedule,'type'=>'EduClass']);
          
          // Add Exhibitions
          $tickets = \App\Models\Ticket::where('user_id', $user->id)->with('exhibition')->get();
          foreach($tickets as $t) {
              if($t->exhibition) {
                  $start = optional($t->exhibition->start_date)->format('d M Y');
                  $end = optional($t->exhibition->end_date)->format('d M Y');
                  $sched = $start . ($end ? ' - ' . $end : '');
                  if($t->exhibition->time) $sched .= ' | ' . $t->exhibition->time;
                  
                  $upcoming->push([
                      'title' => $t->exhibition->title,
                      'schedule' => $sched,
                      'type' => 'Exhibition'
                  ]);
              }
          }
        @endphp
        @forelse($upcoming->sortBy('schedule')->take(5) as $item)
          <li style="padding:12px 0;border-bottom:1px solid #eee">
            <strong>{{ $item['title'] }}</strong> <span style="color:#888">({{ $item['type'] }})</span> – {{ $item['schedule'] }}
          </li>
        @empty
          <li style="padding:12px 0;color:#888">Belum ada jadwal booking yang akan datang.</li>
        @endforelse
      </ul>
    </div>
  </div>
</x-layout>
