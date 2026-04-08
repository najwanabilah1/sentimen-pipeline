@extends('layouts.app')

@section('content')

<style>
    /* Import Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary: #2563eb;
        --primary-gradient: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
        --dark: #0f172a;
        --slate-500: #64748b;
        --slate-100: #f1f5f9;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: #f8fafc;
        color: var(--dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.5;
    }

    /* Agar konten tidak mepet ke ujung tab/browser */
    .main-wrapper {
        padding: 0 4% 80px 4%; /* Memberi ruang di kiri dan kanan */
    }

    /* ===================== */
    /* HERO SECTION - REFINED */
    /* ===================== */
    .hero {
        position: relative;
        min-height: 400px; /* Ukuran lebih proporsional */
        background: url('{{ asset("assets/img/hero.jpg") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        border-radius: 30px; /* Lebih subtle */
        overflow: hidden;
        margin: 20px 0 60px 0;
        animation: fadeIn 0.8s ease-out;
    }

    .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 650px;
        padding: 3rem;
    }

    .hero h1 {
        font-size: 2.5rem; /* Ukuran lebih kecil dan rapi */
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin-bottom: 1rem;
        color: white;
    }

    .hero p {
        font-size: 1rem;
        color: #cbd5e1;
        margin-bottom: 2rem;
        font-weight: 400;
    }

    .btn-hero {
        background: var(--primary-gradient);
        padding: 12px 24px;
        color: white !important;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    /* ===================== */
    /* SECTION HEADERS */
    /* ===================== */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header-title h2 {
        font-size: 1.5rem; /* Kecil tapi tegas */
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.2rem;
    }

    .header-title .accent-line {
        width: 40px;
        height: 4px;
        background: var(--primary);
        border-radius: 10px;
    }

    .btn-view-all {
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition);
    }

    /* ===================== */
    /* BERITA GRID */
    /* ===================== */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 4rem;
    }

    .card-news {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-news:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .img-wrapper { height: 180px; overflow: hidden; }
    .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .card-news-body { padding: 1.25rem; }

    .badge-kategori {
        background: #eff6ff;
        color: var(--primary);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        display: inline-block;
    }

    .card-news h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .text-date { font-size: 0.8rem; color: var(--slate-500); margin-bottom: 1.25rem; }

    .btn-detail {
        padding: 10px;
        border-radius: 8px;
        background: #f8fafc;
        color: var(--dark);
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        display: block;
        border: 1px solid #e2e8f0;
        transition: var(--transition);
    }

    .btn-detail:hover { background: var(--dark); color: white; }

    /* ===================== */
    /* ULASAN SLIDER */
    /* ===================== */
    .ulasan-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 20px;
        scrollbar-width: none;
    }
    .ulasan-wrapper::-webkit-scrollbar { display: none; }

    .ulasan-card {
        flex: 0 0 320px;
        background: white;
        padding: 1.5rem;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        transition: var(--transition);
    }

    .stars { color: #fbbf24; font-size: 0.8rem; margin-bottom: 0.75rem; }
    .ulasan-text { font-size: 0.9rem; color: #475569; font-style: italic; margin-bottom: 1.5rem; }

    .user-profile { display: flex; align-items: center; gap: 12px; }
    .avatar-placeholder {
        width: 35px; height: 35px;
        background: var(--primary-gradient);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 700;
    }

    /* ===================== */
    /* CTA BANNER */
    /* ===================== */
    .cta-banner {
        background: var(--dark);
        padding: 60px 30px;
        border-radius: 30px;
        text-align: center;
        color: white;
        margin-top: 4rem;
    }

    .cta-banner h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem; }
    .cta-banner p { font-size: 0.95rem; color: #94a3b8; margin-bottom: 2rem; }

    /* Simple Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .main-wrapper { padding: 0 15px 50px 15px; }
        .hero { min-height: 350px; border-radius: 20px; }
        .hero-content { padding: 2rem; }
        .hero h1 { font-size: 2rem; }
    }
</style>

<div class="main-wrapper">
    <div class="hero">
        <div class="hero-content">
            <h1>Inspirasi Dalam <br> Setiap Berita.</h1>
            <p>Platform interaktif untuk meninjau dan memberikan masukan terhadap program-program RBTV.</p>
            <a href="{{ url('ulasan') }}" class="btn-hero">
                Beri Ulasan Sekarang <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="container-fluid p-0">
        <div class="section-header">
            <div class="header-title">
                <h2>Berita Terkini</h2>
                <div class="accent-line"></div>
            </div>
            <a href="{{ url('program') }}" class="btn-view-all">Lihat Semua</a>
        </div>

        <div class="berita-grid">
            @foreach($berita as $row)
            <div class="card-news">
                <div class="img-wrapper">
                    <img src="{{ asset('images/'.$row->gambar_berita) }}" alt="{{ $row->judul_berita }}">
                </div>
                <div class="card-news-body">
                    <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                    <h3>{{ $row->judul_berita }}</h3>
                    <div class="text-date">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($row->tanggal_berita)->translatedFormat('d M Y') }}
                    </div>
                    <a href="{{ url('detail/'.$row->id_berita) }}" class="btn-detail">Detail Berita</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section-header">
            <div class="header-title">
                <h2>Ulasan Penonton</h2>
                <div class="accent-line"></div>
            </div>
        </div>

        <div class="ulasan-wrapper">
            @foreach($ulasan as $row)
            <div class="ulasan-card">
                <div class="stars">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $row->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
                <p class="ulasan-text">"{{ Str::limit($row->isi_ulasan_raw, 100) }}"</p>
                <div class="user-profile">
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr($row->nama_user, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $row->nama_user }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ $row->judul_berita }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cta-banner">
            <h2>Suara Anda, Perubahan Kami.</h2>
            <p>Bantu kami menyajikan berita yang lebih berkualitas melalui ulasan Anda.</p>
            <a href="{{ url('ulasan') }}" class="btn-hero" style="background: white; color: var(--dark) !important;">
                Mulai Tulis Ulasan
            </a>
        </div>
    </div>
</div>

@endsection