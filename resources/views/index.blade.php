@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --secondary: #ef4444;
        --secondary-dark: #dc2626;
        --accent: #4f46e5;
        --bg-light: #f8fafc;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
    }

    /* ===================== */
    /* HERO SECTION */
    /* ===================== */
    .hero {
        position: relative;
        min-height: 450px;
        background: url('{{ asset("assets/img/hero.jpg") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        color: white;
        margin-bottom: 2rem;
    }

    .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(15, 23, 42, 0.9), rgba(30, 64, 175, 0.4));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        padding: 2rem;
        margin-left: auto;
        margin-right: auto;
    }

    @media (min-width: 992px) {
        .hero-content { margin-left: 5%; }
    }

    .hero h1 {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }

    .hero p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .btn-hero {
        background: var(--secondary);
        padding: 14px 28px;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-hero:hover {
        background: var(--secondary-dark);
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ===================== */
    /* SECTION HEADERS */
    /* ===================== */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        color: var(--text-main);
    }

    .section-header a {
        text-decoration: none;
        font-size: 0.875rem;
        color: var(--primary);
        font-weight: 600;
        background: rgba(37, 99, 235, 0.1);
        padding: 8px 16px;
        border-radius: 99px;
        transition: 0.3s;
    }

    .section-header a:hover {
        background: var(--primary);
        color: white;
    }

    .subtitle {
        margin-top: -1.5rem;
        margin-bottom: 2rem;
        color: var(--text-muted);
    }

    /* ===================== */
    /* BERITA GRID (RESPONSIVE) */
    /* ===================== */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 4rem;
    }

    .card-news {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-news:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow);
    }

    .card-news img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-news-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .badge-kategori {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #eff6ff;
        color: var(--primary);
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        width: fit-content;
        margin-bottom: 0.75rem;
    }

    .card-news h3 {
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .text-date {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .btn-detail {
        margin-top: auto;
        background: var(--primary);
        color: white;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: var(--primary-dark);
        color: white;
    }

    /* ===================== */
    /* ULASAN HORIZONTAL SCROLL */
    /* ===================== */
    .ulasan-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding: 10px 5px 30px;
        scrollbar-width: thin;
    }

    .ulasan-wrapper::-webkit-scrollbar { height: 6px; }
    .ulasan-wrapper::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .ulasan-card {
        flex: 0 0 320px;
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .ulasan-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .badge-news-ref {
        background: var(--accent);
        color: white;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        text-decoration: none;
    }

    .news-mini-info {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 8px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .news-mini-info img {
        width: 45px; height: 45px;
        border-radius: 6px; object-fit: cover;
    }

    .news-mini-title {
        font-size: 0.8rem;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .stars { color: #fbbf24; margin-bottom: 0.75rem; }

    .ulasan-text {
        font-size: 0.95rem;
        font-style: italic;
        color: #475569;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .user-footer {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .user-footer::before {
        content: "";
        width: 24px; height: 2px; background: var(--secondary);
    }

    /* ===================== */
    /* CTA SECTION */
    /* ===================== */
    .cta-banner {
        background: linear-gradient(135deg, var(--accent), var(--secondary));
        padding: 80px 20px;
        border-radius: 24px;
        text-align: center;
        color: white;
        margin: 4rem 0;
    }

    .cta-banner h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; }
    .cta-banner p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem; }
    
    .btn-cta {
        background: white;
        color: var(--text-main);
        padding: 14px 32px;
        border-radius: 99px;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-cta:hover {
        background: #f1f5f9;
        transform: scale(1.05);
        color: var(--primary);
    }
</style>

<div class="hero">
    <div class="container-fluid">
        <div class="hero-content">
            <h1>Sistem Review Program RBTV</h1>
            <p>Platform ulasan terpercaya untuk program berita RBTV. Suara Anda adalah inspirasi kami untuk menyajikan informasi yang lebih akurat dan tajam.</p>
            <a href="{{ url('ulasan') }}" class="btn-hero">Beri Ulasan Sekarang</a>
        </div>
    </div>
</div>

<div class="container">

    <div class="section-header">
        <h2>Berita Terkini</h2>
        <a href="{{ url('program') }}">Lihat Semua</a>
    </div>
    <p class="subtitle">Update informasi terbaru dari redaksi RBTV</p>

    <div class="berita-grid">
        @foreach($berita as $row)
        <div class="card-news">
            <img src="{{ asset('images/'.$row->gambar_berita) }}" alt="{{ $row->judul_berita }}">
            <div class="card-news-body">
                <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                <h3>{{ $row->judul_berita }}</h3>
                <p class="text-date">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($row->tanggal_berita)->translatedFormat('d F Y') }}
                </p>
                <a href="{{ url('detail/'.$row->id_berita) }}" class="btn-detail">Baca Detail</a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="section-header">
        <h2>Ulasan Pengguna</h2>
        <a href="{{ url('ulasan') }}">Semua Ulasan</a>
    </div>
    <p class="subtitle">Feedback nyata dari penonton setia kami</p>

    <div class="ulasan-wrapper">
        @foreach($ulasan as $row)
        <div class="ulasan-card">
            <div class="top-content">
                <div class="ulasan-header">
                    <span class="badge-kategori m-0">{{ $row->kategori_berita }}</span>
                    <a href="{{ url('detail?judul='.urlencode($row->judul_berita).'&kategori='.$row->kategori_berita) }}" class="badge-news-ref">Program</a>
                </div>

                <div class="news-mini-info">
                    <img src="{{ asset('images/'.($row->gambar_berita ?? 'default.jpg')) }}">
                    <div class="news-mini-title">{{ $row->judul_berita }}</div>
                </div>

                <div class="stars">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $row->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>

                <p class="ulasan-text">"{{ $row->isi_ulasan_raw }}"</p>
            </div>

            <div class="user-footer">
                {{ $row->nama_user }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="cta-banner">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2>Mari Berkontribusi!</h2>
                <p>Ulasan Anda sangat berarti untuk kualitas jurnalisme kami. Bantu kami menjadi lebih baik hari ini.</p>
                <a href="{{ url('ulasan') }}" class="btn-cta shadow">Mulai Beri Ulasan</a>
            </div>
        </div>
    </div>

</div>

@endsection