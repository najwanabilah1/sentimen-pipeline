@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --blue:        #1d4ed8;
        --blue-dark:   #1e3a8a;
        --blue-mid:    #2563eb;
        --blue-light:  #dbeafe;
        --blue-xlight: #eff6ff;
        --red:         #dc2626;
        --red-dark:    #b91c1c;
        --white:       #ffffff;
        --off-white:   #f8fafc;
        --gray:        #e2e8f0;
        --text-main:   #0f172a;
        --text-muted:  #64748b;
        --shadow-sm:   0 2px 8px rgba(30, 58, 138, 0.08);
        --shadow-md:   0 6px 24px rgba(30, 58, 138, 0.12);
        --shadow-lg:   0 16px 48px rgba(30, 58, 138, 0.18);
        --radius:      14px;
        --radius-sm:   8px;
        --page-px:     48px;   /* horizontal page padding */
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--off-white);
        color: var(--text-main);
    }

    /* ===================== */
    /* PAGE PADDING WRAPPER  */
    /* ===================== */
    .page-px {
        padding-left:  var(--page-px);
        padding-right: var(--page-px);
    }

    /* ===================== */
    /* HERO                  */
    /* ===================== */
    .hero {
        position: relative;
        min-height: 480px;
        background: url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
        display: flex;
        align-items: center;
        color: var(--white);
    }

    .hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg,
            rgba(30, 58, 138, 0.95) 0%,
            rgba(29, 78, 216, 0.75) 55%,
            rgba(220, 38, 38, 0.30) 100%);
        z-index: 1;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        width: 100%;
        padding: 60px var(--page-px);
    }

    .hero-content {
        max-width: 600px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.3);
        color: var(--white);
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        padding: 6px 16px;
        border-radius: 99px;
        margin-bottom: 1.25rem;
    }

    .hero h1 {
        font-size: clamp(2rem, 4.5vw, 3.2rem);
        font-weight: 800;
        line-height: 1.15;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
    }

    .hero h1 span { color: #fbbf24; }

    .hero p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 2.25rem;
        line-height: 1.8;
        max-width: 500px;
    }

    .hero-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: var(--red);
        padding: 13px 28px;
        color: var(--white);
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.4);
    }

    .btn-hero-primary:hover {
        background: var(--red-dark);
        transform: translateY(-2px);
        color: var(--white);
    }

    .btn-hero-secondary {
        background: rgba(255,255,255,0.13);
        backdrop-filter: blur(8px);
        border: 1.5px solid rgba(255,255,255,0.35);
        padding: 13px 24px;
        color: var(--white);
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.22);
        color: var(--white);
    }

    /* ===================== */
    /* MAIN WRAPPER          */
    /* ===================== */
    .main-content {
        padding: 56px var(--page-px) 64px;
    }

    /* ===================== */
    /* SECTION HEADER        */
    /* ===================== */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .section-header h2 {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0;
        color: var(--text-main);
        letter-spacing: -0.02em;
        position: relative;
        padding-left: 15px;
    }

    .section-header h2::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 72%;
        background: var(--blue-mid);
        border-radius: 4px;
    }

    .btn-lihat-semua {
        text-decoration: none;
        font-size: 0.78rem;
        color: var(--blue-mid);
        font-weight: 700;
        background: var(--blue-xlight);
        padding: 7px 16px;
        border-radius: 99px;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-lihat-semua:hover {
        background: var(--blue-mid);
        color: var(--white);
    }

    .section-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
        margin-bottom: 24px;
        font-weight: 500;
    }

    /* ===================== */
    /* BERITA GRID           */
    /* ===================== */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(255px, 1fr));
        gap: 22px;
        margin-bottom: 56px;
    }

    .card-news {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-news:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--blue-light);
    }

    .card-news-img-wrap {
        overflow: hidden;
        height: 185px;
        flex-shrink: 0;
        background: var(--blue-xlight);
    }

    .card-news-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .card-news:hover .card-news-img-wrap img {
        transform: scale(1.06);
    }

    .card-news-body {
        padding: 1.15rem 1.25rem 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .badge-kategori {
        display: inline-block;
        font-size: 0.67rem;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        background: var(--blue-xlight);
        color: var(--blue-mid);
        padding: 4px 10px;
        border-radius: 5px;
        font-weight: 700;
        margin-bottom: 0.65rem;
        width: fit-content;
    }

    .card-news h3 {
        font-size: 0.96rem;
        font-weight: 700;
        line-height: 1.48;
        margin-bottom: 0.5rem;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .text-date {
        font-size: 0.775rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 1rem;
        margin-top: 4px;
    }

    .btn-detail {
        background: var(--blue-mid);
        color: var(--white);
        text-align: center;
        padding: 9px 14px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.82rem;
        transition: all 0.2s;
        display: block;
        margin-top: auto;
    }

    .btn-detail:hover {
        background: var(--blue-dark);
        color: var(--white);
        transform: translateY(-1px);
    }

    /* ===================== */
    /* ULASAN SCROLL         */
    /* ===================== */
    .ulasan-wrapper {
        display: flex;
        gap: 18px;
        overflow-x: auto;
        padding: 4px 2px 24px;
        scrollbar-width: thin;
        scrollbar-color: var(--gray) transparent;
        margin-bottom: 56px;
    }

    .ulasan-wrapper::-webkit-scrollbar { height: 5px; }
    .ulasan-wrapper::-webkit-scrollbar-track { background: transparent; }
    .ulasan-wrapper::-webkit-scrollbar-thumb { background: var(--gray); border-radius: 10px; }

    .ulasan-card {
        flex: 0 0 295px;
        background: var(--white);
        padding: 1.35rem;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--shadow-sm);
        transition: all 0.25s;
    }

    .ulasan-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    .ulasan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.85rem;
    }

    .badge-program {
        background: var(--blue-mid);
        color: var(--white);
        font-size: 0.66rem;
        padding: 4px 9px;
        border-radius: 5px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        text-decoration: none;
        transition: 0.2s;
    }

    .badge-program:hover {
        background: var(--blue-dark);
        color: var(--white);
    }

    .news-mini-info {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 8px 10px;
        background: var(--off-white);
        border: 1px solid var(--gray);
        border-radius: var(--radius-sm);
        margin-bottom: 0.85rem;
    }

    .news-mini-info img {
        width: 42px;
        height: 42px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
        background: var(--blue-xlight);
    }

    .news-mini-title {
        font-size: 0.76rem;
        font-weight: 700;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .stars {
        color: #f59e0b;
        margin-bottom: 0.55rem;
        font-size: 0.82rem;
        display: flex;
        gap: 2px;
    }

    .ulasan-text {
        font-size: 0.86rem;
        font-style: italic;
        color: #475569;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.1rem;
        line-height: 1.65;
    }

    .user-footer {
        font-weight: 700;
        font-size: 0.83rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
        border-top: 1px solid var(--gray);
        padding-top: 0.8rem;
    }

    .user-footer::before {
        content: "";
        width: 18px;
        height: 3px;
        background: var(--red);
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* ===================== */
    /* CTA BANNER            */
    /* ===================== */
    .cta-banner {
        background: linear-gradient(130deg, var(--blue-dark) 0%, var(--blue-mid) 50%, var(--red) 100%);
        padding: 64px 48px;
        border-radius: 18px;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .cta-banner::before {
        content: "";
        position: absolute;
        top: -70px; right: -70px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .cta-banner::after {
        content: "";
        position: absolute;
        bottom: -90px; left: -50px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .cta-banner h2 {
        font-size: clamp(1.55rem, 3.5vw, 2.2rem);
        font-weight: 800;
        margin-bottom: 0.8rem;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 1;
    }

    .cta-banner p {
        font-size: 0.96rem;
        opacity: 0.88;
        margin-bottom: 2rem;
        line-height: 1.75;
        position: relative;
        z-index: 1;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-cta {
        background: var(--white);
        color: var(--blue-mid);
        padding: 13px 32px;
        border-radius: 99px;
        font-weight: 800;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.18);
    }

    .btn-cta:hover {
        background: var(--off-white);
        transform: translateY(-2px) scale(1.03);
        color: var(--blue-dark);
    }

    /* ===================== */
    /* RESPONSIVE            */
    /* ===================== */
    @media (max-width: 991px) {
        :root { --page-px: 32px; }
    }

    @media (max-width: 768px) {
        :root { --page-px: 20px; }
        .hero { min-height: 400px; }
        .berita-grid { grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; }
        .ulasan-card { flex: 0 0 270px; }
        .cta-banner { padding: 48px 24px; border-radius: 14px; }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .hero h1 { font-size: 1.75rem; }
        .hero-actions { flex-direction: column; }
        .btn-hero-primary,
        .btn-hero-secondary { justify-content: center; }
        .berita-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- ======================== --}}
{{-- HERO                     --}}
{{-- ======================== --}}
<div class="hero">
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-broadcast-tower"></i>
                Platform Ulasan RBTV
            </div>
            <h1>Sistem Review Program <span>RBTV</span></h1>
            <p>Platform ulasan terpercaya untuk program berita RBTV. Suara Anda adalah inspirasi kami untuk menyajikan informasi yang lebih akurat dan tajam.</p>
            <div class="hero-actions">
                <a href="{{ url('ulasan') }}" class="btn-hero-primary">
                    <i class="fas fa-star"></i>
                    Beri Ulasan Sekarang
                </a>
                <a href="{{ url('program') }}" class="btn-hero-secondary">
                    <i class="fas fa-play-circle"></i>
                    Lihat Program
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ======================== --}}
{{-- MAIN CONTENT             --}}
{{-- ======================== --}}
<div class="main-content">

    {{-- ===================== --}}
    {{-- BERITA TERKINI        --}}
    {{-- ===================== --}}
    <div class="section-header">
        <h2>Berita Terkini</h2>
        <a href="{{ url('program') }}" class="btn-lihat-semua">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <p class="section-subtitle">Update informasi terbaru dari redaksi RBTV</p>

    <div class="berita-grid">
        @forelse($berita as $row)
            <div class="card-news">
                <div class="card-news-img-wrap">
                    <img src="{{ asset('uploads/' . $row->gambar_berita) }}"
                         alt="{{ $row->judul_berita }}"
                         onerror="this.src='{{ asset('images/default.jpg') }}'">
                </div>
                <div class="card-news-body">
                    <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                    <h3>{{ $row->judul_berita }}</h3>
                    <p class="text-date">
                        <i class="far fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($row->tanggal_berita)->translatedFormat('d F Y') }}
                    </p>
                    <a href="{{ url('detail/' . $row->id_berita) }}" class="btn-detail">
                        <i class="fas fa-arrow-right me-1"></i> Baca Detail
                    </a>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada berita tersedia.</p>
        @endforelse
    </div>

    {{-- ===================== --}}
    {{-- ULASAN PENGGUNA       --}}
    {{-- ===================== --}}
    <div class="section-header">
        <h2>Ulasan Pengguna</h2>
        <a href="{{ url('ulasan') }}" class="btn-lihat-semua">
            Semua Ulasan <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <p class="section-subtitle">Feedback nyata dari penonton setia kami</p>

    <div class="ulasan-wrapper">
        @forelse($ulasan as $row)
            <div class="ulasan-card">
                <div>
                    <div class="ulasan-header">
                        <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                        <a href="{{ url('detail/' . $row->id_berita) }}"
                           class="badge-program">
                            Detail Berita
                        </a>
                    </div>

                    <div class="news-mini-info">
                        <img src="{{ asset('uploads/' . ($row->gambar_berita ?? 'default.jpg')) }}"
                             alt="{{ $row->judul_berita }}"
                             onerror="this.src='{{ asset('images/default.jpg') }}'">
                        <div class="news-mini-title">{{ $row->judul_berita }}</div>
                    </div>

                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $row->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>

                    <p class="ulasan-text">"{{ $row->isi_ulasan_raw }}"</p>
                </div>

                <div class="user-footer">
                    {{ $row->nama_user }}
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada ulasan tersedia.</p>
        @endforelse
    </div>

    {{-- ===================== --}}
    {{-- CTA BANNER            --}}
    {{-- ===================== --}}
    <div class="cta-banner">
        <h2>Bantu Kami Meningkatkan Kualitas Program</h2>
        <p>Ulasan Anda sangat berarti untuk kualitas jurnalisme kami. Bantu kami menjadi lebih baik hari ini.</p>
        <a href="{{ url('ulasan') }}" class="btn-cta">
            <i class="fas fa-pen-alt"></i>
            Mulai Beri Ulasan
        </a>
    </div>

</div>

@endsection