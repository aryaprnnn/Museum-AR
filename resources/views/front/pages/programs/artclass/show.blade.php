<x-layout title="{{ $artClass->title }}" :mainClass="'light-bg'">
  <div class="program-page">
    <div class="back-top" style="margin-bottom:40px;">
      <a href="{{ route('artclass') }}" class="btn back-btn">Kembali</a>
    </div>
    <div class="program-detail two-column">
      @php
        $imageUrl = $artClass->image
            ? (\Illuminate\Support\Str::startsWith($artClass->image, ['http://', 'https://'])
                ? $artClass->image
                : asset('storage/'.$artClass->image))
            : asset('img/placeholder.png');
      @endphp
      <div class="detail-thumb" style="background-image:url('{{ $imageUrl }}');"></div>
      <div class="detail-body">
        <h1 class="detail-title">{{ $artClass->title }}</h1>
        <h2 class="detail-subtitle">{{ $artClass->description }}</h2>

        <div class="detail-stack-grid theme-detail">
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-layer-group"></i></span>
            <div>
              <h3>Level</h3>
              <p>{{ ucfirst($artClass->level) }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-user-tie"></i></span>
            <div>
              <h3>Instructor</h3>
              <p>{{ $artClass->instructor ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-calendar-alt"></i></span>
            <div>
              <h3>Jadwal</h3>
              <p>{{ $artClass->schedule ?? '-' }}</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-users"></i></span>
            <div>
              <h3>Kuota Tersisa</h3>
              <p>{{ $artClass->available }} kursi tersedia</p>
            </div>
          </div>
          <div class="detail-card">
            <span class="detail-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div>
              <h3>Harga</h3>
              <p>Rp {{ number_format($artClass->price, 0, ',', '.') }}</p>
            </div>
          </div>
        </div>

        @php
          $sessionUser = session('auth_user');
          $isBooked = false;
          $isPending = false;
          if($sessionUser && isset($sessionUser['id'])) {
            $booking = \App\Models\Booking::where('user_id', $sessionUser['id'])
              ->where('bookable_type', \App\Models\ArtClass::class)
              ->where('bookable_id', $artClass->id)
              ->orderByDesc('created_at')
              ->first();
            if($booking) {
              // Midtrans sering menggunakan status lowercase atau uppercase
              $currentStatus = strtolower($booking->payment_status);
              $successStatuses = ['paid', 'settlement', 'capture', 'success']; // Tambahkan 'success'
              if(in_array($currentStatus, $successStatuses)) {
                $isBooked = true;
              } elseif($currentStatus === 'pending') {
                $isPending = true;
              }
            }
          }
        @endphp
        <div id="payment-section" style="margin-top: 20px;">
          @if($isBooked)
            {{-- STATUS: SUDAH BAYAR (HIJAU) --}}
            <div style="margin-bottom:16px;padding:16px;background:#e6fff2;border:1px solid #b2f5d6;border-radius:8px;color:#1a7f4f;font-weight:600;">
              <i class="fas fa-check-circle"></i> Anda sudah mengikuti kelas ini! Selamat belajar dan semoga bermanfaat.
            </div>
            <button class="btn program-btn" style="background: #ccc; cursor: not-allowed; border: none; color: #666;" disabled>
                <i class="fas fa-lock"></i> Sudah Terdaftar
            </button>
          @elseif($isPending)
            {{-- STATUS: MENUNGGU PEMBAYARAN --}}
            <div style="margin-bottom:16px;padding:16px;background:#fffbe6;border:1px solid #ffe58f;border-radius:8px;color:#ad8b00;font-weight:600; font-family: 'Inria Serif', serif;">
              <i class="fas fa-hourglass-half" style="margin-right:8px;"></i> Pendaftaran sedang diproses, silakan selesaikan pembayaran Anda.
            </div>
            <button id="pay-artclass-btn" class="btn program-btn" style="background:#000;color:#fff;border:none;">Lanjutkan Pembayaran</button>
          @elseif($sessionUser)
            {{-- STATUS: BELUM DAFTAR --}}
            <button id="pay-artclass-btn" class="btn program-btn">Bayar &amp; Daftar Sekarang</button>
          @else
            {{-- STATUS: BELUM LOGIN --}}
            <a href="{{ route('login') }}" class="btn program-btn">Login untuk Membayar</a>
          @endif
        </div>
        @if(session('auth_user'))
          <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
                const payBtn = document.getElementById('pay-artclass-btn');
                if (!payBtn) return;
                let isProcessing = false;
                const originalText = payBtn.innerHTML;
                const resetButton = () => {
                    isProcessing = false;
                    payBtn.disabled = false;
                    payBtn.innerHTML = originalText;
                };
                const openSnap = (token) => {
                    window.snap.pay(token, {
                        onSuccess: function(result) { window.location.href = "{{ url('/midtrans/artclass/finish') }}?order_id=" + result.order_id + "&status=" + result.transaction_status; },
                        onPending: function(result) { window.location.href = "{{ url('/midtrans/artclass/finish') }}?order_id=" + result.order_id + "&status=" + result.transaction_status; },
                        onError: function(result) { alert("Terjadi kesalahan pembayaran."); resetButton(); },
                        onClose: function() { resetButton(); }
                    });
                };
                payBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (isProcessing) return;
                    isProcessing = true;
                    payBtn.disabled = true;
                    payBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';
                    fetch("{{ url('/artclass/'.$artClass->id.'/pay-token') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (res.ok && data.token) {
                            openSnap(data.token);
                        } else if (res.status === 409) {
                            if(data.token) openSnap(data.token);
                            else alert(data.message || "Pendaftaran sudah ada, silakan cek email/dashboard.");
                        } else {
                            throw new Error(data.message || 'Gagal memproses pendaftaran.');
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
      </div>
    </div>
  </div>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .program-detail.two-column{display:grid;grid-template-columns:1fr 1.2fr;gap:26px;align-items:start}
    .detail-thumb{height:420px;background-size:cover;background-position:center;border-radius:12px;box-shadow:0 10px 24px rgba(0,0,0,.1)}
    .detail-body{display:flex;flex-direction:column;gap:14px}
    .detail-title{margin:0;font-size:2rem;color:#000}
    .detail-subtitle{margin:0;font-size:1rem;color:#4a4a4a}
    .program-btn:disabled {
      background-color: #d1d1d1 !important;
      color: #888 !important;
      border: 1px solid #ccc !important;
      cursor: not-allowed !important;
      pointer-events: none !important;
      transform: none !important;
      box-shadow: none !important;
    }
    .detail-stack-grid{
      display:grid;
      grid-template-columns:repeat(2,1fr);
      gap:18px 22px;
      margin:18px 0 10px 0;
    }
    .theme-detail{font-family:'Inria Serif',serif;}
    .detail-card{
      display:flex;
      align-items:flex-start;
      background:#F0BB78;
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    .back-top{display:flex;justify-content:flex-start;margin-bottom:40px}
    .back-btn{background:#fff;color:#000;border-color:#000}
    .back-btn:hover{background:#000;color:#fff;border-color:#000}
    @media(max-width:900px){.program-detail.two-column{grid-template-columns:1fr}.detail-thumb{height:300px}}
  </style>
</x-layout>
