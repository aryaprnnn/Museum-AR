<x-layout title="Book Art Class" :mainClass="'light-bg'">
  <div class="container" style="max-width:700px;padding:30px 20px;">
    <h1>Form Booking Art Class</h1>
    @if($errors->any())
      <div style="background:#fee;color:#c33;padding:12px;border-radius:8px;margin-bottom:16px;">
        @foreach($errors->all() as $error)
          <p style="margin:4px 0;">{{ $error }}</p>
        @endforeach
      </div>
    @endif
    <form method="POST" action="{{ route('artclass.book.submit') }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      
      @if(isset($selectedClassId))
        @php
          $selectedClass = $artClasses->firstWhere('id', $selectedClassId);
        @endphp
        <div style="background:#f0f8ff;border:1px solid #0066cc;border-radius:8px;padding:16px;margin-bottom:8px;">
          <label style="font-weight:600;color:#0066cc;margin-bottom:8px;display:block;">Art Class yang Dipilih:</label>
          <div style="font-size:1.1rem;font-weight:bold;color:#333;margin-bottom:4px;">{{ $selectedClass->title }}</div>
          <div style="color:#666;font-size:0.9rem;">Level: {{ ucfirst($selectedClass->level) }}</div>
          @if($selectedClass->price)
            <div style="color:#666;font-size:0.9rem;">Harga: Rp {{ number_format($selectedClass->price, 0, ',', '.') }}</div>
          @endif
        </div>
        <input type="hidden" name="artclass_id" value="{{ $selectedClassId }}">
      @else
        <label>Pilih Art Class</label>
        <select name="artclass_id" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
          <option value="">-- Pilih Kelas --</option>
          @foreach($artClasses as $class)
            <option value="{{ $class->id }}">{{ $class->title }} ({{ ucfirst($class->level) }})</option>
          @endforeach
        </select>
      @endif
      <label>Nama Peserta</label>
      <input type="text" name="participant_name" value="{{ old('participant_name') }}" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
      <label>Level Pengalaman (Opsional)</label>
      <select name="experience_level" style="padding:10px;border:1px solid #ddd;border-radius:8px">
        <option value="">-- Tidak Ada --</option>
        <option value="pemula">Pemula</option>
        <option value="menengah">Menengah</option>
        <option value="lanjutan">Lanjutan</option>
      </select>
      <label>Metode Pembayaran</label>
      <select name="payment_method" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
        <option value="midtrans">Midtrans (recommended)</option>
        <option value="manual">Manual Transfer</option>
      </select>
      <button class="btn" type="submit">Lanjutkan Pembayaran</button>
    </form>
  </div>
</x-layout>
