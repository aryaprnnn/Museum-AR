<x-layout title="Account Settings" :mainClass="'light-bg'">
  <div class="container" style="max-width:700px;padding:40px 20px;">
    <h1 style="margin-bottom:30px"><i class="fas fa-cog"></i> Account Settings</h1>
    
    @if(session('success'))
      <div style="background-color:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px">
        {{ session('success') }}
      </div>
    @endif
    
    <form method="POST" action="/user/settings/update" style="display:flex;flex-direction:column;gap:20px">
      @csrf
      <div>
        <label style="display:block;margin-bottom:6px;font-weight:500">Nama Lengkap</label>
        <input type="text" name="name" value="{{ session('auth_user')['name'] ?? '' }}" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-size:1rem">
        @error('name')<span style="color:red;font-size:0.9rem">{{ $message }}</span>@enderror
      </div>
      <div>
        <label style="display:block;margin-bottom:6px;font-weight:500">Email</label>
        <input type="email" name="email" value="{{ session('auth_user')['email'] ?? '' }}" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-size:1rem">
        @error('email')<span style="color:red;font-size:0.9rem">{{ $message }}</span>@enderror
      </div>
      <div>
        <label style="display:block;margin-bottom:6px;font-weight:500">Password Baru (opsional)</label>
        <input type="password" name="new_password" placeholder="Kosongkan jika tidak ingin mengubah" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-size:1rem">
        @error('new_password')<span style="color:red;font-size:0.9rem">{{ $message }}</span>@enderror
      </div>
      <div>
        <label style="display:block;margin-bottom:6px;font-weight:500">Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;font-size:1rem">
      </div>
      <button class="btn" type="submit" style="align-self:flex-start">Simpan Perubahan</button>
    </form>
  </div>
</x-layout>
