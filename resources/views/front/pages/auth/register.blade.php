<x-layout title="Register" :mainClass="'light-bg'">
    <style>
        .login-page-wrapper {
            position: relative;
            min-height: calc(100vh - 85px); /* Adjust based on header/footer height */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .login-chip {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 20px;
            background: #543a14be;
            backdrop-filter: blur(20px) saturate(1%);
            -webkit-backdrop-filter: blur(20px) saturate(1%);
            border: 1px solid #FFF0DC;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .login-chip h1 {
            color: #fff;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1px;
            text-align: center;
        }

        .login-chip label {
            color: #eee;
            margin-bottom: 5px;
            display: block;
            font-size: 0.9em;
        }

        .login-chip input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        .login-chip input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .login-chip button {
            width: 100%;
            padding: 12px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 10px;
        }

        .login-chip button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .login-chip a {
            color: #fff;
            text-decoration: underline;
        }
        
        /* Error styling adapted for dark theme */
        .error-box {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ffbdc3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>

    <div class="login-page-wrapper">
        {{-- Video Background --}}
        <video autoplay muted loop playsinline class="video-background">
            <source src="{{ asset('video/museumV.mp4') }}" type="video/mp4">
        </video>

        {{-- Glassmorphism Chip --}}
        <div class="login-chip">
            <h1>Register</h1>
            
            @if($errors->any())
                <div class="error-box">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <svg style="width:20px;height:20px;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong>Registrasi Gagal!</strong>
                            <ul style="margin: 5px 0 0 0; padding-left: 15px; font-size: 0.9em;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap">
                </div>

                <div style="margin-bottom: 20px;">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email Address">
                </div>

                <div style="margin-bottom: 20px;">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Password">
                </div>

                <div style="margin-bottom: 20px;">
                    <label>Nomor WhatsApp</label>
                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="08xxxxxxxxxx">
                </div>

                <button type="submit">DAFTAR</button>
            </form>

            <p style="margin-top: 20px; text-align: center; font-size: 0.9em; color: rgba(255,255,255,0.8);">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </div>
</x-layout>
