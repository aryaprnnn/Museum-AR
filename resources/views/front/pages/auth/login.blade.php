<x-layout title="Login" :mainClass="'light-bg'">
  <div class="container" style="max-width:600px;padding:30px 20px;">
    <h1 style="text-align:center">Login</h1>
    
    @if($errors->any())
      <div style="background:#fee;color:#c33;padding:16px;border-radius:8px;margin:20px 0;border-left:4px solid #c33;">
        <div style="display:flex;align-items:center;gap:8px;">
          <svg style="width:20px;height:20px;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
          </svg>
          <div>
            <strong style="display:block;margin-bottom:4px;">Login Gagal!</strong>
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('auth.login') }}" style="display:flex;flex-direction:column;gap:12px">
      @csrf
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
      <label>Password</label>
      <input type="password" name="password" required style="padding:10px;border:1px solid #ddd;border-radius:8px">
      <button class="btn" type="submit">Login</button>
    </form>
    <p style="margin-top:10px">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
  </div>
</x-layout>
