<x-layout title="{{ $program->title }}" :mainClass="'light-bg'">
  <div class="program-page">
    <div class="back-top">
      <a href="{{ route('educational-program') }}" class="btn back-btn">Kembali</a>
    </div>
    <div class="program-detail two-column">
      @php
        $imageUrl = $program->image
            ? (\Illuminate\Support\Str::startsWith($program->image, ['http://', 'https://'])
                ? $program->image
                : asset('storage/'.$program->image))
            : asset('img/placeholder.png');
      @endphp
      <div class="detail-thumb" style="background-image:url('{{ $imageUrl }}');"></div>
      <div class="detail-body">
        <h1 class="detail-title">{{ $program->title }}</h1>
        <h2 class="detail-subtitle">{{ $program->description }}</h2>

        <div class="detail-stack-grid theme-detail">
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div>
              <h3>Harga</h3>
              <p>Rp {{ number_format($program->price ?? 0, 0, ',', '.') }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-certificate"></i></span>
            <div>
              <h3>Tipe Program</h3>
              <p>{{ ucfirst($program->type) }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-users"></i></span>
            <div>
              <h3>Target Peserta</h3>
              <p>{{ $program->target_audience ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-gift"></i></span>
            <div>
              <h3>Manfaat</h3>
              <p>{{ $program->benefits ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-calendar-alt"></i></span>
            <div>
              <h3>Jadwal</h3>
              <p>{{ $program->schedule ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-map-marker-alt"></i></span>
            <div>
              <h3>Lokasi</h3>
              <p>{{ $program->location ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-chalkboard-teacher"></i></span>
            <div>
              <h3>Fasilitator</h3>
              <p>{{ $program->facilitator ?? '-' }}</p>
            </div>
          </div>
        </div>


        @php
          $sessionUser = session('auth_user');
          $isJoined = false;
          $isPending = false;
          if($sessionUser && isset($sessionUser['id'])) {
            $booking = \App\Models\Booking::where('user_id', $sessionUser['id'])
                ->where('bookable_type', \App\Models\EducationalProgram::class)
                ->where('bookable_id', $program->id)
                ->orderByDesc('created_at')
                ->first();
            if($booking) {
              if($booking->payment_status === 'paid') {
                $isJoined = true;
              } elseif($booking->payment_status === 'pending') {
                $isPending = true;
              }
            }
          }
        @endphp

        <div id="payment-section" style="margin-top: 20px;">
          @if($isJoined)
            {{-- STATUS: SUDAH BAYAR --}}
            <div style="margin-bottom:16px;padding:16px;background:#e6fff2;border:1px solid #b2f5d6;border-radius:8px;color:#1a7f4f;font-weight:600;">
              <i class="fas fa-check-circle"></i> Anda sudah mengikuti program ini! Selamat belajar.
            </div>
            <button class="btn program-btn disabled-btn" style="background: #ccc; cursor: not-allowed;" disabled>
                <i class="fas fa-lock"></i> Sudah Terdaftar
            </button>

          @elseif($isPending)
            {{-- STATUS: MENUNGGU PEMBAYARAN --}}
            <div style="margin-bottom:16px;padding:16px;background:#fffbe6;border:1px solid #ffe58f;border-radius:8px;color:#ad8b00;font-weight:600;">
              <i class="fas fa-hourglass-half"></i> Pendaftaran sedang diproses, silakan selesaikan pembayaran Anda.
            </div>
            <button id="pay-educlass-btn" class="btn program-btn">Lanjutkan Pembayaran</button>

          @elseif($sessionUser)
            {{-- STATUS: BELUM DAFTAR --}}
            <button id="pay-educlass-btn" class="btn program-btn">Bayar &amp; Daftar Sekarang</button>
          @else
            {{-- STATUS: BELUM LOGIN --}}
            <a href="{{ route('login') }}" class="btn program-btn">Login untuk Membayar</a>
          @endif
        </div>

        @if($sessionUser && !$isJoined)
          <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const payBtn = document.getElementById('pay-educlass-btn');
              if (payBtn) {
                let isProcessing = false;
                payBtn.addEventListener('click', function(e) {
                  e.preventDefault();
                  if(isProcessing) return;
                  isProcessing = true;
                  payBtn.disabled = true;
                  const originalText = payBtn.innerHTML;
                  payBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghubungkan...';

                  fetch("{{ url('/educlass/'.$program->id.'/pay') }}", {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                  })
                  .then(async res => {
                    if (!res.ok) {
                      let msg = 'Gagal memproses pendaftaran.';
                      try { const err = await res.json(); msg = err.message || msg; } catch(e) {}
                      alert(msg);
                      payBtn.disabled = false;
                      payBtn.innerHTML = originalText;
                      isProcessing = false;
                      return;
                    }
                    return res.json();
                  })
                  .then(data => {
                    if(data && data.token) {
                      window.snap.pay(data.token, {
                        onSuccess: function(result) { window.location.href = "{{ url('/midtrans/educlass/finish') }}"; },
                        onPending: function(result) { window.location.href = "{{ url('/midtrans/educlass/finish') }}"; },
                        onError: function(result) { 
                          alert("Pembayaran gagal."); 
                          payBtn.disabled = false;
                          payBtn.innerHTML = originalText;
                          isProcessing = false;
                        },
                        onClose: function() {
                          payBtn.disabled = false;
                          payBtn.innerHTML = originalText;
                          isProcessing = false;
                        }
                      });
                    } else {
                      payBtn.disabled = false;
                      payBtn.innerHTML = originalText;
                      isProcessing = false;
                    }
                  })
                  .catch(err => {
                    alert(err.message);
                    payBtn.disabled = false;
                    payBtn.innerHTML = originalText;
                    isProcessing = false;
                  });
                });
              }
            });
          </script>
        @endif
      </div>
    </div>
  </div>

  <style>
    .program-detail.two-column{display:grid;grid-template-columns:1fr 1.2fr;gap:26px;align-items:start}
    .detail-thumb{height:420px;background-size:cover;background-position:center;border-radius:12px;box-shadow:0 10px 24px rgba(0,0,0,.1)}
    .detail-body{display:flex;flex-direction:column;gap:18px}
    .detail-title{margin:0;font-size:2rem;color:#000;font-family:'Inria Serif',serif;}
    .detail-subtitle{margin:0;font-size:1rem;color:#4a4a4a;font-family:'Inria Serif',serif;}
    .theme-detail{
      font-family:'Inria Serif',serif;
    }
    .detail-stack-grid{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:18px 22px;
      margin:18px 0 10px 0;
    }
    .detail-card{
      display:flex;
      align-items:flex-start;
      background:#fff;
      border-radius:14px;
      box-shadow:0 8px 32px rgba(0,0,0,0.13);
      padding:20px 18px;
      gap:16px;
      min-height:90px;
      transition:box-shadow .2s,transform .2s;
      border:none;
    }
    .detail-card:hover{
      box-shadow:0 16px 48px rgba(0,0,0,0.18);
      transform:translateY(-2px) scale(1.01);
    }
    .detail-icon{
      font-size:2rem;
      color:#1a1a1a;
      margin-right:12px;
      flex-shrink:0;
      margin-top:2px;
      opacity:0.7;
    }
    .detail-card h3{margin:0 0 4px 0;font-size:1.08rem;color:#222;font-family:'Inria Serif',serif;}
    .detail-card p{margin:0;color:#4a4a4a;line-height:1.6;font-size:1.08rem;}
    .back-top{display:flex;justify-content:flex-start;margin-bottom:40px}
    .back-btn{background:#fff;color:#000;border-color:#000}
    .back-btn:hover{background:#000;color:#fff;border-color:#000}
    @media(max-width:900px){
      .program-detail.two-column{grid-template-columns:1fr}
      .detail-thumb{height:300px}
      .detail-stack-grid{grid-template-columns:1fr}
    }
  </style>
  <!-- Font Awesome CDN for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</x-layout>
