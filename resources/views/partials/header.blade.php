<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>RBTV Review System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- GLOBAL STYLE -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7fb;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: relative;
            z-index: 999;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        .logo span {
            font-weight: 600;
            color: #2c3e50;
        }

        .nav-links a {
            margin-left: 25px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .nav-links a:hover {
            color: #2563eb;
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-login {
            padding: 8px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .btn-register {
            padding: 8px 20px;
            background: transparent;
            color: #2563eb;
            border: 1px solid #2563eb;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-register:hover {
            background: #f0f9ff;
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