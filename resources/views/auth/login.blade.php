<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Manajemen Admin RBTV</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #dc2626; /* Merah RBTV */
            --primary-dark: #991b1b;
            --accent: #ef4444;
            --glass: rgba(255, 255, 255, 0.92);
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== BACKGROUND CREATIVE ===== */
        .bg-wallpaper {
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4') center/cover no-repeat;
            z-index: -2;
            transform: scale(1.1);
            filter: brightness(0.4);
            animation: zoomBg 20s infinite alternate;
        }

        @keyframes zoomBg {
            from { transform: scale(1); }
            to { transform: scale(1.15); }
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(153, 27, 27, 0.6), rgba(0, 0, 0, 0.8));
            z-index: -1;
        }

        /* ===== GLASS CARD LOGIN ===== */
        .card-login {
            width: 100%;
            max-width: 420px;
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 45px;
            margin: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.4);
            animation: slideUp 0.8s ease-out;
            position: relative;
            z-index: 10;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-box {
            background: white;
            width: 75px;
            height: 75px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 15px rgba(220, 38, 38, 0.15);
            transition: var(--transition);
        }

        .logo-box:hover { transform: scale(1.05) rotate(5deg); }

        h4 { font-weight: 800; color: var(--primary-dark); letter-spacing: -0.5px; margin-bottom: 5px; }

        /* ===== FORM STYLE ===== */
        label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-left: 2px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: block;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 1.5px solid #fecaca;
            background: rgba(255, 255, 255, 0.9);
            transition: var(--transition);
            font-size: 0.95rem;
            color: #1e293b;
        }

        .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
            transform: translateY(-2px);
            outline: none;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--primary);
            opacity: 0.5;
            z-index: 5;
            padding: 5px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .toggle-password:hover { opacity: 1; color: var(--primary-dark); }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 14px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 20px;
            transition: var(--transition);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(220, 38, 38, 0.3);
            filter: brightness(1.1);
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
            margin-top: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .forgot-link:hover { color: var(--primary-dark); text-decoration: underline; }

        .error-msg {
            background: rgba(220, 38, 38, 0.08);
            color: #b91c1c;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary);
        }

        .success-msg {
            background: rgba(22, 163, 74, 0.08);
            color: #15803d;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-bottom: 20px;
            border-left: 4px solid #16a34a;
        }
    </style>
</head>
<body>

    <div class="bg-wallpaper"></div>
    <div class="bg-overlay"></div>

    <div class="card-login">
        <div class="text-center mb-4">
            <div class="logo-box">
                <img src="{{ asset('logo-rbtv.png') }}" width="50" alt="Logo RBTV">
            </div>
            <h4>Manajemen RBTV</h4>
            <p class="text-muted small">Silakan login untuk akses dashboard</p>
        </div>

        @if($errors->any())
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="success-msg">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-control" 
                       placeholder="admin@rbtv.co.id" 
                       required value="{{ old('email') }}">
            </div>

            <div class="mb-2">
                <label>Kata Sandi</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-control" 
                           placeholder="••••••••" required>
                    <span class="toggle-password" onclick="togglePassword('password')">
                        <i class="fa-solid fa-eye" id="password-icon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div style="margin-top: 30px; border-bottom: 1px solid rgba(220, 38, 38, 0.1);"></div>

        <div class="text-center mt-4">
            <p class="text-muted" style="font-size: 0.75rem;">
                &copy; 2026 <strong>RBTV Management</strong> <br> Bengkulu, Indonesia.
            </p>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>