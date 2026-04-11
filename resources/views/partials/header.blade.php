<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBTV Review System</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --blue:        #1d4ed8;
            --blue-dark:   #1e3a8a;
            --blue-mid:    #2563eb;
            --blue-light:  #dbeafe;
            --blue-xlight: #eff6ff;
            --red:         #dc2626;
            --white:       #ffffff;
            --off-white:   #f8fafc;
            --gray:        #e2e8f0;
            --text-main:   #0f172a;
            --text-muted:  #64748b;
            --shadow-sm:   0 2px 8px rgba(30, 58, 138, 0.08);
            --shadow-md:   0 6px 24px rgba(30, 58, 138, 0.12);
            --radius-sm:   8px;
            --nav-h:       68px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--off-white);
            color: var(--text-main);
        }

        /* ===================== */
        /* NAVBAR                */
        /* ===================== */
        .navbar {
            height: var(--nav-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            background: var(--white);
            border-bottom: 1px solid var(--gray);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 999;
            gap: 16px;
        }

        /* ===================== */
        /* LOGO                  */
        /* ===================== */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-logo img {
            height: 36px;
            width: auto;
            object-fit: contain;
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .nav-logo-text strong {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .nav-logo-text span {
            font-size: 0.68rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.02em;
        }

        /* ===================== */
        /* NAV LINKS             */
        /* ===================== */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
            justify-content: center;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.855rem;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
            position: relative;
        }

        .nav-links a i {
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .nav-links a:hover {
            color: var(--blue-mid);
            background: var(--blue-xlight);
        }

        .nav-links a.active {
            color: var(--blue-mid);
            background: var(--blue-xlight);
        }

        .nav-links a.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2.5px;
            background: var(--blue-mid);
            border-radius: 2px;
        }

        /* Label teks — sembunyikan di layar sempit */
        .nav-label {
            transition: opacity 0.2s;
        }

        /* ===================== */
        /* AUTH BUTTON           */
        /* ===================== */
        .nav-auth {
            flex-shrink: 0;
        }

        .btn-login-admin {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            background: var(--blue-mid);
            color: var(--white);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 0.845rem;
            font-weight: 700;
            transition: all 0.25s;
            white-space: nowrap;
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.3);
        }

        .btn-login-admin i {
            font-size: 0.85rem;
        }

        .btn-login-admin:hover {
            background: var(--blue-dark);
            color: var(--white);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
        }

        .btn-login-admin:active {
            transform: translateY(0);
        }

        /* ===================== */
        /* HAMBURGER (MOBILE)    */
        /* ===================== */
        .nav-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            transition: background 0.2s;
            background: none;
            border: none;
        }

        .nav-hamburger:hover {
            background: var(--blue-xlight);
        }

        .nav-hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--text-main);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .nav-hamburger.open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .nav-hamburger.open span:nth-child(2) {
            opacity: 0;
        }

        .nav-hamburger.open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* ===================== */
        /* MOBILE MENU DRAWER    */
        /* ===================== */
        .nav-drawer {
            display: none;
            flex-direction: column;
            gap: 4px;
            position: absolute;
            top: var(--nav-h);
            left: 0;
            right: 0;
            background: var(--white);
            border-bottom: 1px solid var(--gray);
            box-shadow: var(--shadow-md);
            padding: 16px 20px 20px;
            z-index: 998;
        }

        .nav-drawer.open {
            display: flex;
        }

        .nav-drawer a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .nav-drawer a i {
            width: 18px;
            text-align: center;
            color: var(--blue-mid);
            font-size: 0.9rem;
        }

        .nav-drawer a:hover,
        .nav-drawer a.active {
            background: var(--blue-xlight);
            color: var(--blue-mid);
        }

        .nav-drawer-divider {
            height: 1px;
            background: var(--gray);
            margin: 8px 0;
        }

        .nav-drawer .btn-login-admin {
            width: 100%;
            justify-content: center;
            margin-top: 4px;
        }

        /* ===================== */
        /* RESPONSIVE            */
        /* ===================== */

        /* Layar sedang: sembunyikan label teks, tampilkan icon saja */
        @media (max-width: 900px) {
            .navbar { padding: 0 32px; }

            .nav-links a {
                padding: 8px 10px;
                gap: 0;
            }

            .nav-label { display: none; }

            .nav-logo-text span { display: none; }

            .btn-login-admin .btn-label { display: none; }

            .btn-login-admin {
                padding: 9px 12px;
                gap: 0;
            }
        }

        /* Layar kecil: hamburger menu */
        @media (max-width: 640px) {
            .navbar { padding: 0 20px; position: sticky; }
            .nav-links  { display: none; }
            .nav-auth   { display: none; }
            .nav-hamburger { display: flex; }
        }

        @media (max-width: 480px) {
            .navbar { padding: 0 16px; }
            .nav-logo-text strong { font-size: 0.875rem; }
        }
    </style>
</head>
<body>

<nav class="navbar">

    {{-- LOGO --}}
    <a href="{{ url('/') }}" class="nav-logo">
        <img src="{{ asset('images/logo.png') }}"
             alt="RBTV"
             onerror="this.style.display='none'">
        <div class="nav-logo-text">
            <strong>RBTV</strong>
            <span>Review System</span>
        </div>
    </a>

    {{-- NAV LINKS (DESKTOP) --}}
    <div class="nav-links">
        <a href="{{ url('/') }}"
           class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="{{ url('/program') }}"
           class="{{ request()->is('program*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i>
            <span class="nav-label">Program</span>
        </a>
        <a href="{{ url('/ulasan') }}"
           class="{{ request()->is('ulasan*') ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span class="nav-label">Ulasan</span>
        </a>
        <a href="{{ url('/tentang') }}"
           class="{{ request()->is('tentang*') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i>
            <span class="nav-label">Tentang</span>
        </a>
        <a href="{{ url('/kontak') }}"
           class="{{ request()->is('kontak*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i>
            <span class="nav-label">Kontak</span>
        </a>
    </div>

    {{-- AUTH BUTTON (DESKTOP) --}}
    <div class="nav-auth">
        <a href="{{ route('login') }}" class="btn-login-admin">
            <i class="fas fa-lock"></i>
            <span class="btn-label">Login Admin</span>
        </a>
    </div>

    {{-- HAMBURGER (MOBILE) --}}
    <button class="nav-hamburger" id="hamburger" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

</nav>

{{-- MOBILE DRAWER --}}
<div class="nav-drawer" id="navDrawer">
    <a href="{{ url('/') }}"
       class="{{ request()->is('/') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Beranda
    </a>
    <a href="{{ url('/program') }}"
       class="{{ request()->is('program*') ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i> Program
    </a>
    <a href="{{ url('/ulasan') }}"
       class="{{ request()->is('ulasan*') ? 'active' : '' }}">
        <i class="fas fa-star"></i> Ulasan
    </a>
    <a href="{{ url('/tentang') }}"
       class="{{ request()->is('tentang*') ? 'active' : '' }}">
        <i class="fas fa-info-circle"></i> Tentang
    </a>
    <a href="{{ url('/kontak') }}"
       class="{{ request()->is('kontak*') ? 'active' : '' }}">
        <i class="fas fa-envelope"></i> Kontak
    </a>

    <div class="nav-drawer-divider"></div>

    <a href="{{ route('login') }}" class="btn-login-admin">
        <i class="fas fa-lock"></i> Login Admin
    </a>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const navDrawer = document.getElementById('navDrawer');

    hamburger.addEventListener('click', function () {
        this.classList.toggle('open');
        navDrawer.classList.toggle('open');
    });

    // Tutup drawer kalau klik di luar
    document.addEventListener('click', function (e) {
        if (!hamburger.contains(e.target) && !navDrawer.contains(e.target)) {
            hamburger.classList.remove('open');
            navDrawer.classList.remove('open');
        }
    });
</script>