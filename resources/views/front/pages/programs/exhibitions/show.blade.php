<x-layout title="{{ $exhibition->title }}" :mainClass="'light-bg'">
  <div class="program-page">
    <div class="back-top">
      <a href="{{ route('exhibitions') }}" class="btn back-btn">Kembali</a>
    </div>
    <div class="exhibition-detail">
      <h1 class="detail-title center">{{ $exhibition->title }}</h1>
      @php
        $imageUrl = $exhibition->image
            ? (\Illuminate\Support\Str::startsWith($exhibition->image, ['http://', 'https://'])
                ? $exhibition->image
                : asset('storage/'.$exhibition->image))
            : asset('img/placeholder.png');
      @endphp
      <div class="detail-thumb wide" style="background-image:url('{{ $imageUrl }}');"></div>

      <div class="detail-meta">
        <div class="detail-item">
          <h3>Kurator</h3>
          <p>{{ $exhibition->curator ?? '-' }}</p>
        </div>
        <div class="detail-item">
          <h3>Periode</h3>
          <p>{{ optional($exhibition->start_date)->format('d M Y') }} - {{ optional($exhibition->end_date)->format('d M Y') }} {{ $exhibition->time ? ' | '.$exhibition->time : '' }}</p>
        </div>
        <div class="detail-item">
          <h3>Lokasi</h3>
          <p>{{ $exhibition->location ?? '-' }}</p>
        </div>
      </div>

      <div class="detail-description">
        <h3>Deskripsi</h3>
        <p>{{ $exhibition->description }}</p>
      </div>

      
    </div>
  </div>

  <!-- Banner CTA di atas footer -->
  <div class="exhibition-banner">
    <div class="banner-bg-layer" style="background-image: url('{{ asset('img/exhibitions-photo.jpg') }}');"></div>
    <div class="banner-gradient-overlay"></div>
    <div class="exhibition-banner-overlay">
      <div class="exhibition-banner-content">
        <div class="banner-left">
          <p class="banner-text">Beli tiket untuk mengunjungi exhibitions</p>
        </div>
        <div class="banner-right">
            @php
                $sessionUser = session('auth_user');
                $isBooked = false;
                $isPending = false;
                if($sessionUser && isset($sessionUser['id'])) {
                    // Cek TIKET (bukan booking) khusus untuk exhibition ini
                    // Exhibition uses Ticket model, distinct from Booking
                    $ticket = \App\Models\Ticket::where('user_id', $sessionUser['id'])
                        ->where('exhibition_id', $exhibition->id)
                        ->orderByDesc('created_at')
                        ->first();
                    
                    if($ticket) {
                        // Ticket status is simple 'paid' or 'pending' usually (controller sets to 'paid' immediately for free)
                        $currentStatus = strtolower($ticket->status); 
                        $successStatuses = ['paid', 'settlement', 'capture', 'success'];
                        if(in_array($currentStatus, $successStatuses)) {
                            $isBooked = true;
                        } elseif($currentStatus === 'pending') {
                            $isPending = true;
                        }
                    }
                }
            @endphp

            @if($isBooked)
                {{-- STATUS: SUDAH BAYAR --}}
                <button class="btn ticket-btn" style="background: #ccc !important; color: #666 !important; cursor: not-allowed; border: none;" disabled>
                    <i class="fas fa-lock"></i> Anda sudah mendaftar
                </button>
            @elseif($isPending)
                {{-- STATUS: PENDING --}}
                <button id="pay-exhibition-btn" class="btn ticket-btn">Lanjutkan Pembayaran</button>
            @elseif($sessionUser)
                {{-- STATUS: BARU (LOGGED IN) --}}
                <button id="pay-exhibition-btn" class="btn ticket-btn">Daftar Pameran</button>
            @else
                {{-- STATUS: BLM LOGIN --}}
                <a href="{{ route('login') }}" class="btn ticket-btn">Login untuk Mendaftar</a>
            @endif
        </div>
      </div>
    </div>
  </div>

  @if(session('auth_user'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const payBtn = document.getElementById('pay-exhibition-btn');
          if (!payBtn) return;
          
          let isProcessing = false;
          const originalText = payBtn.innerHTML;
          
          const resetButton = () => {
              isProcessing = false;
              payBtn.disabled = false;
              payBtn.innerHTML = originalText;
          };

          payBtn.addEventListener('click', function(e) {
              e.preventDefault();
              if (isProcessing) return;
              
              isProcessing = true;
              payBtn.disabled = true;
              payBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';

              fetch("{{ route('exhibitions.pay.token', $exhibition->id) }}", {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({})
              })
              .then(async res => {
                  const data = await res.json();
                  if (res.ok && data.status === 'success') {
                      window.location.href = data.redirect_url;
                  } else {
                      // Fallback error handling
                      alert(data.message || 'Gagal memproses pendaftaran.');
                      resetButton();
                  }
              })
              .catch(err => {
                  alert(err.message);
                  resetButton();
              });
          });
      });
    </script>
  @endif



  <style>
    .exhibition-detail{display:flex;flex-direction:column;gap:18px}
    .center{text-align:center}
    .detail-title{margin:0;font-size:2.2rem;color:#000}
    .detail-thumb.wide{height:360px;background-size:cover;background-position:center;border-radius:12px;box-shadow:0 10px 24px rgba(0,0,0,.1)}
    .detail-meta{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    .detail-item {
        background: #FFF8F0;
        border: 1px solid #EBE0D0;
        border-radius: 12px;
        padding: 16px 20px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .detail-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #D4C5B0;
    }
    .detail-item h3{margin:0 0 6px 0;font-size:0.95rem;color:#8B7355;text-transform:uppercase;letter-spacing:0.05em;font-weight:600}
    .detail-item p{margin:0;color:#1a1a1a;line-height:1.4;font-size:1.1rem;font-weight:500}
    .detail-description {
        background: #FFF8F0;
        border: 1px solid #EBE0D0;
        border-radius: 12px;
        padding: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .detail-description:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #D4C5B0;
    }
    .detail-description h3{margin:0 0 12px 0;font-size:1.1rem;color:#8B7355;text-transform:uppercase;letter-spacing:0.05em;font-weight:600}
    .detail-description p{margin:0;color:#1a1a1a;line-height:1.8;font-size:1.05rem}
    .back-top{display:flex;justify-content:flex-start;margin-bottom:40px}
    .back-btn{background:#fff;color:#000;border-color:#000}
    .back-btn:hover{background:#000;color:#fff;border-color:#000}

    /* Banner full width */
    .exhibition-banner{
        width:100%;
        min-height:130px;
        margin-top:0; /* Remove gap for blending */
        position: relative;
        overflow: hidden;
        padding: 80px 0 40px 0; /* More top padding for fade */
    }
    .banner-bg-layer {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100%; height: 100%;
        background-size: cover;
        background-position: center;
        filter: grayscale(100%) blur(4px); /* B/W + Blur */
        transform: scale(1.1); /* Zoom in to hide blur edges */
        z-index: 1;
    }
    .banner-gradient-overlay {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 150px; /* Fade height */
        background: linear-gradient(to bottom, #FFF0DC 10%, rgba(255, 240, 220, 0) 100%);
        z-index: 2;
        pointer-events: none;
    }
    .exhibition-banner-overlay{
        position: relative;
        z-index: 3;
        width:100%;
        height:100%;
    }
    .exhibition-banner-content{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:40px 24px;}
    .banner-text{margin:0;color:#fff;font-size:2rem;font-weight:700}
    .ticket-btn{background-color: #fff !important; color: #000; border: none; padding:8px 70px;font-size:1.5rem;font-weight:700;border-radius:8px;transition:transform 0.3s ease, background-color 0.3s ease, color 0.3s ease}
    .ticket-btn:hover{border: none; background: #000 !important; color: #fff;transform:scale(1.08)}
    @media(max-width:900px){
        .detail-meta{grid-template-columns:1fr}
        .detail-thumb.wide{height:300px}
        
        /* Banner Mobile Fix */
        .exhibition-banner-content {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px;
        }
        .banner-left {
            margin-bottom: 20px;
        }
        .banner-text {
            font-size: 1.5rem;
        }
        .ticket-btn {
            width: 100%;
            padding: 12px 20px;
            font-size: 1.1rem;
        }
    }
  </style>
</x-layout>
