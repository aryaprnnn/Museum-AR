<x-layout title="Join Educational Program" :mainClass="'light-bg'">
  <div class="container" style="max-width:700px;padding:30px 20px;">
    <h1>Form Join Educational Program</h1>
    @if($errors->any())
      <div style="background:#fee;color:#c33;padding:12px;border-radius:8px;margin-bottom:16px;">
        @foreach($errors->all() as $error)
          <p style="margin:4px 0;">{{ $error }}</p>
        @endforeach
      </div>
    @endif
    <form method="POST" action="{{ route('educational-program.join.submit') }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      
      @if(isset($selectedProgramId))
        @php
          $selectedProgram = $programs->firstWhere('id', $selectedProgramId);
        @endphp
        <div style="background:#f0f8ff;border:1px solid #0066cc;border-radius:8px;padding:16px;margin-bottom:8px;">
          <label style="font-weight:600;color:#0066cc;margin-bottom:8px;display:block;">Program yang Dipilih:</label>
          <div style="font-size:1.1rem;font-weight:bold;color:#333;margin-bottom:4px;">{{ $selectedProgram->title }}</div>
          <div style="color:#666;font-size:0.9rem;">Tipe: {{ ucfirst($selectedProgram->type) }}</div>
          @if($selectedProgram->schedule)
            <div style="color:#666;font-size:0.9rem;">Jadwal: {{ $selectedProgram->schedule }}</div>
          @endif
        </div>
        <input type="hidden" name="program_id" value="{{ $selectedProgramId }}">
      @else
        <label>Pilih Program Edukasi</label>
        <select name="program_id" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
          <option value="">-- Pilih Program --</option>
          @foreach($programs as $program)
            <option value="{{ $program->id }}">{{ $program->title }} ({{ ucfirst($program->type) }})</option>
          @endforeach
        </select>
      @endif
      <label>Nama Peserta</label>
      <input type="text" name="participant_name" value="{{ old('participant_name') }}" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
      <label>Institusi (Opsional)</label>
      <input type="text" name="institution" value="{{ old('institution') }}" style="padding:10px;border:1px solid #ddd;border-radius:8px">
      <label>Metode Pembayaran</label>
      <select name="payment_method" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
        <option value="midtrans">Midtrans (recommended)</option>
        <option value="manual">Manual Transfer</option>
      </select>
      <button class="btn" type="submit">Lanjutkan Pembayaran</button>
    </form>
  </div>
</x-layout>
