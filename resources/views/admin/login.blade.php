<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ARtifact Museum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background:#000;min-height:100vh;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
        body::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg, rgba(20,20,20,0.9) 0%, rgba(40,40,40,0.9) 100%);z-index:-1}
        .login-wrapper{display:flex;align-items:center;justify-content:center;min-height:100vh;width:100%;padding:20px}
        .login-container{background:#1a1a1a;border:1px solid #333;padding:50px 40px;border-radius:8px;box-shadow:0 20px 60px rgba(0,0,0,0.5);width:100%;max-width:420px}
        .login-header{text-align:center;margin-bottom:40px}
        .login-header i{font-size:3rem;color:#fff;margin-bottom:20px}
        .login-header h1{color:#fff;font-size:2rem;font-weight:400;letter-spacing:0.05em;margin-bottom:8px}
        .login-header p{color:#999;font-size:0.95rem;letter-spacing:0.03em}
        .form-group{margin-bottom:24px}
        .form-group label{display:block;color:#ccc;margin-bottom:8px;font-weight:500;font-size:0.9rem}
        .form-group input{width:100%;padding:12px 16px;border:1px solid #333;border-radius:4px;font-size:1rem;background:#0f0f0f;color:#fff;transition:all 0.3s}
        .form-group input:focus{outline:none;border-color:#666;background:#1a1a1a}
        .form-group input::placeholder{color:#666}
        .btn{width:100%;padding:12px;background:#000;color:#fff;border:2px solid #fff;border-radius:4px;font-size:1rem;cursor:pointer;transition:all 0.3s;font-weight:600;letter-spacing:0.05em}
        .btn:hover{background:#fff;color:#000}
        .alert{padding:16px;margin-bottom:24px;border-radius:4px;font-size:0.9rem}
        .alert-error{background:#fee;color:#c33;border-left:4px solid #c33}
        .alert-success{background:#d4edda;color:#155724;border-left:4px solid #28a745}
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-museum"></i>
                <h1>Admin Login</h1>
                <p>ARtifact Museum</p>
            </div>
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle" style="margin-right:8px"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right:8px"></i>
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="admin@museum.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn">Login to Admin Panel</button>
            </form>
        </div>
    </div>
</body>
</html>
