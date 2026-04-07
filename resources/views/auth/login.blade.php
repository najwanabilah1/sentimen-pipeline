

<style>
    .auth-container {
        max-width: 400px;
        margin: 60px auto;
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .auth-container h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
        font-size: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .form-group input::placeholder {
        color: #999;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }

    .form-footer a {
        color: #2563eb;
        text-decoration: none;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    .error-message {
        background: #fecaca;
        color: #dc2626;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .success-message {
        background: #bbf7d0;
        color: #15803d;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
    }
</style>

<div class="auth-container">
    <h2>🔓 Login Akun</h2>

    @if($errors->any())
        <div class="error-message">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
            @error('email')
                <small style="color: #dc2626;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
            @error('password')
                <small style="color: #dc2626;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Login</button>
    </form>
</div>
