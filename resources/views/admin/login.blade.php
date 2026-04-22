<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ARtifact Museum</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #000000;
            --primary-light: #FFF0DC;
            --accent-gold: #F0BB78;
            --text-dark: #1a1a1a;
            --text-light: #ffffff;
            --danger-bg: #dc3545;
            --success-bg: #d4edda;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inria Serif', serif;
            background-color: var(--primary-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
        }

        .login-container {
            background: #ffffff;
            border: 2px solid var(--primary-dark);
            padding: 50px 40px;
            border-radius: 8px;
            box-shadow: 4px 4px 0px var(--primary-dark);
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header i {
            font-size: 3rem;
            color: var(--primary-dark);
            margin-bottom: 20px;
        }

        .login-header h1 {
            color: var(--primary-dark);
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #666;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            font-family: 'Lexend', sans-serif;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            font-family: 'Lexend', sans-serif;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            background: #fff;
            color: var(--text-dark);
            transition: all 0.3s;
            font-family: 'Lexend', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-dark);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-dark);
            color: var(--text-light);
            border: 2px solid var(--primary-dark);
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 700;
            letter-spacing: 0.05em;
            font-family: 'Inria Serif', serif;
            box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #543A14;
            color: #ffffff;
            border-color: #543A14;
            transform: translateY(-2px);
        }

        .alert {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: 'Lexend', sans-serif;
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }

        .alert-success {
            background: var(--success-bg);
            color: #155724;
            border-left: 4px solid #28a745;
        }
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
