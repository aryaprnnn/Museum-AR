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
  <div class="exhibition-banner" style="background-image: url('{{ asset('img/exhibitions-photo.jpg') }}');">
    <div class="exhibition-banner-overlay">
      <div class="exhibition-banner-content">
        <div class="banner-left">
          <p class="banner-text">Beli tiket untuk mengunjungi exhibitions</p>
        </div>
        <div class="banner-right">
          <a href="#" id="open-ticket-modal" class="btn ticket-btn">Beli Tiket</a>
          <!-- Modal -->
          <div id="ticket-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:9999;align-items:center;justify-content:center;animation:fadeIn 0.3s;">
            <div class="modal-content">
              <button id="close-ticket-modal" class="modal-close">&times;</button>
              <h3 class="modal-title">Isi Data Pembeli</h3>
              <form id="ticket-form" class="modal-form">
                @php 
                  $sessionUser = session('auth_user'); 
                  $hasWhatsApp = !empty($sessionUser['whatsapp'] ?? null);
                @endphp

                @if($sessionUser)
                  <input type="hidden" id="customer-email" value="{{ $sessionUser['email'] }}">
                  @if($hasWhatsApp)
                    <input type="hidden" id="customer-phone" value="{{ $sessionUser['whatsapp'] }}">
                    <div style="background: #f0f7ff; padding: 15px; border-radius: 12px; border: 1px solid #d0e1fd; margin-bottom: 15px;">
                      <p style="margin:0 0 5px 0; font-size: 0.85rem; color: #6366f1; font-weight: 600;">Data Pembeli:</p>
                      <strong style="display:block; color: #1e293b;">{{ $sessionUser['email'] }}</strong>
                      <strong style="display:block; color: #1e293b;">{{ $sessionUser['whatsapp'] }}</strong>
                    </div>
                    <p style="font-size: 0.75rem; color: #64748b; margin-top: -5px;">*Tiket akan dikirimkan ke nomor WhatsApp terdaftar.</p>
                  @else
                    <div class="modal-field">
                      <label>Lengkapi Nomor WhatsApp</label>
                      <input type="text" id="customer-phone" placeholder="Contoh: 0812345678" required>
                    </div>
                  @endif
                @else
                  <div class="modal-field">
                    <label>Email</label>
                    <input type="email" id="customer-email" placeholder="Email aktif" required>
                  </div>
                  <div class="modal-field">
                    <label>Nomor WhatsApp</label>
                    <input type="text" id="customer-phone" placeholder="Contoh: 0812345678" required>
                  </div>
                @endif
                <button type="submit" class="btn ticket-btn modal-btn">Lanjut Bayar</button>
                </form>
            </div>
          </div>
          <style>
            @keyframes fadeIn {from{opacity:0}to{opacity:1}}
            #ticket-modal {animation:fadeIn 0.3s;}
            .modal-content {
              background: linear-gradient(135deg,#f8fafc 0%,#e0e7ff 100%);
              padding: 36px 28px 28px 28px;
              border-radius: 18px;
              box-shadow: 0 8px 32px rgba(0,0,0,0.18);
              max-width: 370px;
              width: 100%;
              position: relative;
              display: flex;
              flex-direction: column;
              align-items: stretch;
              gap: 0;
              animation: fadeIn 0.3s;
            }
            .modal-close {
              position: absolute;
              top: 14px;
              right: 16px;
              background: #e0e7ff;
              border: none;
              font-size: 2rem;
              color: #6366f1;
              cursor: pointer;
              border-radius: 50%;
              width: 36px;
              height: 36px;
              transition: background 0.2s;
            }
            .modal-close:hover {
              background: #6366f1;
              color: #fff;
            }
            .modal-title {
              margin-bottom: 18px;
              text-align: center;
              font-size: 1.35rem;
              color: #3730a3;
              font-weight: 600;
            }
            .modal-form {
              display: flex;
              flex-direction: column;
              gap: 18px;
              align-items: stretch;
            }
            .modal-field {
              display: flex;
              flex-direction: column;
              gap: 6px;
            }
            .modal-field label {
              font-size: 0.98rem;
              color: #6366f1;
              font-weight: 500;
              margin-bottom: 2px;
            }
            .modal-field input {
              padding: 10px 14px;
              border-radius: 8px;
              border: 1px solid #c7d2fe;
              font-size: 1rem;
              background: #fff;
              transition: border 0.2s;
            }
            .modal-field input:focus {
              border: 1.5px solid #6366f1;
              outline: none;
            }
            .modal-btn {
              width: 100%;
              margin-top: 10px;
              background: linear-gradient(90deg,#6366f1 0%,#3730a3 100%) !important;
              color: #fff !important;
              font-size: 1.1rem;
              font-weight: 600;
              border-radius: 8px;
              border: none;
              box-shadow: 0 2px 8px rgba(99,102,241,0.08);
              transition: background 0.2s, color 0.2s, transform 0.2s;
            }
            .modal-btn:hover {
              background: linear-gradient(90deg,#3730a3 0%,#6366f1 100%) !important;
              color: #fff !important;
              transform: scale(1.04);
            }
          </style>
          <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
          <script>
            // Modal logic
            const openModalBtn = document.getElementById('open-ticket-modal');
            const modal = document.getElementById('ticket-modal');
            const closeModalBtn = document.getElementById('close-ticket-modal');
            openModalBtn.addEventListener('click', function(e) {
              e.preventDefault();
              modal.style.display = 'flex';
            });
            closeModalBtn.addEventListener('click', function() {
              modal.style.display = 'none';
            });
            window.addEventListener('click', function(e) {
              if(e.target === modal) modal.style.display = 'none';
            });

            document.getElementById('ticket-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const email = document.getElementById('customer-email').value;
                const phone = document.getElementById('customer-phone').value;
                if(!email || !phone) {
                    alert('Email dan nomor HP wajib tersedia.');
                    return;
                }
                const btn = e.target.querySelector('button');
                const originalText = btn.innerText;
                btn.innerText = 'Memproses...';
                btn.disabled = true;
                fetch("{{ route('exhibitions.pay.token', $exhibition->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ email, phone })
                })
                .then(res => res.json())
                .then(data => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    if(data.token) {
                        modal.style.display = 'none';
                        window.snap.pay(data.token);
                    } else {
                        alert(data.error || 'Gagal mendapatkan token pembayaran.');
                    }
                })
                .catch(err => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                    alert('Terjadi kesalahan jaringan.');
                });
            });
          </script>
        </div>
      </div>
    </div>
  </div>

  <style>
    .exhibition-detail{display:flex;flex-direction:column;gap:18px}
    .center{text-align:center}
    .detail-title{margin:0;font-size:2.2rem;color:#000}
    .detail-thumb.wide{height:360px;background-size:cover;background-position:center;border-radius:12px;box-shadow:0 10px 24px rgba(0,0,0,.1)}
    .detail-meta{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
    .detail-item h3{margin:0 0 6px 0;font-size:1rem;color:#000}
    .detail-item p{margin:0;color:#4a4a4a;line-height:1.6}
    .detail-description h3{margin:0 0 6px 0}
    .back-top{display:flex;justify-content:flex-start;margin-bottom:40px}
    .back-btn{background:#fff;color:#000;border-color:#000}
    .back-btn:hover{background:#000;color:#fff;border-color:#000}

    /* Banner full width */
    .exhibition-banner{width:100%;min-height:130px;background-size:cover;background-position:center;margin-top:40px}
    .exhibition-banner-overlay{background:linear-gradient(to right, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%);width:100%;height:100%}
    .exhibition-banner-content{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:40px 24px}
    .banner-text{margin:0;color:#fff;font-size:2rem;font-weight:500}
    .ticket-btn{background-color: #fff !important; color: #000; border: none; padding:8px 70px;font-size:1.5rem;border-radius:8px;transition:transform 0.3s ease, background-color 0.3s ease, color 0.3s ease}
    .ticket-btn:hover{border: none; background: #000 !important; color: #fff;transform:scale(1.08)}
    @media(max-width:900px){.detail-meta{grid-template-columns:1fr}.detail-thumb.wide{height:300px}}
  </style>
</x-layout>
