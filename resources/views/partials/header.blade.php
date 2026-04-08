<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>RBTV Review System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
}

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 60px;
    
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    
    border-bottom: 1px solid rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 999;
}

/* LOGO */
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    height: 42px;
}

.logo span {
    font-weight: 700;
    font-size: 18px;
    color: #1e293b;
}

/* NAV LINKS */
.nav-links {
    display: flex;
    align-items: center;
    gap: 30px;
}

.nav-links a {
    text-decoration: none;
    color: #475569;
    font-size: 14px;
    position: relative;
    transition: 0.3s;
}

/* Hover underline animation */
.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0%;
    height: 2px;
    background: #2563eb;
    transition: 0.3s;
}

.nav-links a:hover {
    color: #2563eb;
}

.nav-links a:hover::after {
    width: 100%;
}

/* AUTH BUTTON */
.auth-buttons {
    display: flex;
    align-items: center;
}

/* BUTTON */
.btn-login {
    padding: 10px 22px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    border-radius: 999px;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .navbar {
        padding: 15px 20px;
    }

    .nav-links {
        display: none;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="RBTV">
        <span>Program Review</span>
    </div>

    <div class="nav-links">
        <a href="{{ url('/') }}">Beranda</a>
        <a href="{{ url('/program') }}">Program</a>
        <a href="{{ url('/ulasan') }}">Ulasan</a>
        <a href="{{ url('/tentang') }}">Tentang</a>
        <a href="{{ url('/kontak') }}">Kontak</a>
    </div>

    <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn-login">Login Admin</a>
    </div>
</div>

</body>
</html>