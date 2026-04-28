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
        --page-px:     48px;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--off-white);
        color: var(--text-main);
    }

    /* ===================== */
    /* HERO                  */
    /* ===================== */
    .tentang-hero {
        background: linear-gradient(110deg,
            rgba(30, 58, 138, 0.97) 0%,
            rgba(37, 99, 235, 0.88) 55%,
            rgba(29, 78, 216, 0.75) 100%);
        color: var(--white);
        padding: 72px var(--page-px);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .tentang-hero::before {
        content: "";
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .tentang-hero::after {
        content: "";
        position: absolute;
        bottom: -80px; left: -40px;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .tentang-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 620px;
        margin: 0 auto;
    }

    .tentang-hero-badge {
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

    .tentang-hero h1 {
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    .tentang-hero p {
        font-size: 1rem;
        opacity: 0.88;
        line-height: 1.8;
        margin: 0;
    }

    /* ===================== */
    /* MAIN WRAPPER          */
    /* ===================== */
    .tentang-page {
        padding: 56px var(--page-px) 72px;
    }

    /* ===================== */
    /* SECTION HEADER        */
    /* ===================== */
    .section {
        margin-bottom: 56px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }

    .section-header h2 {
        font-size: 1.35rem;
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

    .section-header i {
        color: var(--blue-mid);
        font-size: 1.1rem;
    }

    .section-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
        margin-bottom: 24px;
        font-weight: 500;
        padding-left: 15px;
    }

    /* ===================== */
    /* TENTANG PROYEK        */
    /* ===================== */
    .card-box {
        background: var(--white);
        padding: 32px 36px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        color: #334155;
        line-height: 1.85;
        font-size: 0.95rem;
        text-align: justify;
    }

    .card-box p + p {
        margin-top: 16px;
    }

    .card-box strong {
        color: var(--text-main);
        font-weight: 700;
    }

    /* ===================== */
    /* FITUR GRID            */
    /* ===================== */
    .fitur-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .fitur-card {
        background: var(--white);
        padding: 24px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .fitur-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    .fitur-card h4 i {
        font-size: 0.9rem;      /* sesuaikan ukuran */
        color: var(--blue-mid); /* atau warna lain */
        margin-right: 6px;
    }

    .fitur-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }

    .fitur-card p {
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.65;
        margin: 0;
    }

    /* ===================== */
    /* VISI MISI             */
    /* ===================== */
    .visi-misi {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .vm-card {
        background: var(--white);
        padding: 28px 32px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        border-left: 4px solid var(--blue-mid);
        box-shadow: var(--shadow-sm);
        transition: all 0.25s;
    }

    .vm-card:hover {
        box-shadow: var(--shadow-md);
        border-left-color: var(--blue-dark);
    }

    .vm-card h4 {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vm-card h4::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--blue-mid);
        flex-shrink: 0;
    }

    .vm-card p {
        font-size: 0.9rem;
        color: #334155;
        line-height: 1.75;
        margin: 0;
    }

    .vm-card ul {
        padding-left: 0;
        margin: 0;
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .vm-card ul li {
        font-size: 0.9rem;
        color: #334155;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .vm-card ul li::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--blue-mid);
        flex-shrink: 0;
        margin-top: 7px;
    }

    /* ===================== */
    /* DEVELOPER             */
    /* ===================== */
    /* .dev-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 640px;
    }

    .dev-card {
        background: var(--white);
        padding: 32px 24px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .dev-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    .dev-avatar-wrap {
        position: relative;
        margin-bottom: 4px;
    }

    .dev-card img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--blue-light);
        display: block;
    }

    .dev-avatar-ring {
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        border: 2px dashed var(--blue-light);
        animation: spin 12s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .dev-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
        line-height: 1.4;
    }

    .dev-role {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--blue-mid);
        background: var(--blue-xlight);
        padding: 3px 12px;
        border-radius: 99px;
    }

    .dev-univ {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 500;
    } */

    /* ===================== */
    /* CTA BANNER            */
    /* ===================== */
    .cta-banner {
        background: linear-gradient(130deg, var(--blue-dark) 0%, var(--blue-mid) 50%, var(--red) 100%);
        padding: 56px 48px;
        border-radius: 18px;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
        margin-top: 16px;
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
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 800;
        margin-bottom: 0.8rem;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 1;
    }

    .cta-banner p {
        font-size: 0.95rem;
        opacity: 0.88;
        margin-bottom: 2rem;
        line-height: 1.75;
        position: relative;
        z-index: 1;
        max-width: 460px;
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

        .tentang-hero { padding: 48px var(--page-px); }

        .fitur-grid,
        .visi-misi { grid-template-columns: 1fr; }

        .dev-grid {
            grid-template-columns: 1fr;
            max-width: 320px;
            margin: 0 auto;
        }

        .card-box { padding: 24px 20px; }
        .cta-banner { padding: 48px 24px; border-radius: 14px; }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .tentang-hero h1 { font-size: 1.65rem; }
    }
</style>

{{-- ======================== --}}
{{-- HERO                     --}}
{{-- ======================== --}}
<div class="tentang-hero">
    <div class="tentang-hero-inner">
        <div class="tentang-hero-badge">
            <i class="fas fa-info-circle"></i>
            Tentang Kami
        </div>
        <h1>Tentang Sistem Review RBTV</h1>
        <p>Platform Multi-Stage Validation Pipeline untuk meningkatkan kualitas program berita RBTV melalui feedback masyarakat</p>
    </div>
</div>

{{-- ======================== --}}
{{-- MAIN CONTENT             --}}
{{-- ======================== --}}
<div class="tentang-page">

    {{-- ======================== --}}
    {{-- TENTANG PROYEK           --}}
    {{-- ======================== --}}
    <div class="section">
        <div class="section-header">
            <h2>Tentang Proyek</h2>
        </div>
        <p class="section-subtitle">Latar belakang dan tujuan pengembangan platform ini</p>

        <div class="card-box">
            <p>
                <strong>Pengembangan Sistem Review Program di RBTV Berbasis Multi-Stage Validation Pipeline</strong>
                adalah inisiatif untuk menciptakan platform yang memungkinkan masyarakat memberikan ulasan
                dan feedback terhadap program berita yang disiarkan oleh RBTV.
            </p>
            <p>
                Sistem ini dirancang dengan pendekatan multi-stage validation yang memastikan setiap ulasan
                yang masuk melalui proses verifikasi untuk menjaga kualitas dan relevansi feedback.
                Dengan platform ini, kami berharap dapat meningkatkan kualitas program berita dan memberikan
                konten yang lebih sesuai dengan kebutuhan masyarakat.
            </p>
        </div>
    </div>

    {{-- ======================== --}}
    {{-- FITUR UTAMA              --}}
    {{-- ======================== --}}
    <div class="section">
        <div class="section-header">
            <h2>Fitur Utama</h2>
        </div>
        <p class="section-subtitle">Kemampuan unggulan yang tersedia di platform ini</p>

        <div class="fitur-grid">

            <div class="fitur-card">
                <div>
                    <h4><i class="fas fa-star"></i> Review & Rating</h4>
                    <p>Sistem rating bintang dan ulasan untuk setiap program berita yang disiarkan RBTV</p>
                </div>
            </div>

            <div class="fitur-card">
                <div>
                    <h4><i class="fas fa-shield-alt"></i> Multi-Stage Validation</h4>
                    <p>Validasi bertahap untuk menjaga kualitas dan relevansi setiap ulasan yang masuk</p>
                </div>
            </div>

            <div class="fitur-card">
                <div>
                    <h4><i class="fas fa-th-large"></i> User-Friendly</h4>
                    <p>Antarmuka yang mudah digunakan oleh semua kalangan pengguna tanpa hambatan</p>
                </div>
            </div>

            <div class="fitur-card">
                <div>
                    <h4><i class="fas fa-folder-open"></i> Kategori Terorganisir</h4>
                    <p>Program berita dikelompokkan dengan rapi berdasarkan kategori yang relevan</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ======================== --}}
    {{-- VISI MISI                --}}
    {{-- ======================== --}}
    <div class="section">
        <div class="section-header">
            <h2>Visi & Misi</h2>
        </div>
        <p class="section-subtitle">Arah dan tujuan jangka panjang platform ini</p>

        <div class="visi-misi">

            <div class="vm-card">
                <h4>Visi</h4>
                <p>
                    Menjadi platform review terdepan yang menjembatani komunikasi antara RBTV dan masyarakat
                    demi jurnalisme yang lebih berkualitas.
                </p>
            </div>

            <div class="vm-card">
                <h4>Misi</h4>
                <ul>
                    <li>Menyediakan platform feedback yang transparan dan dapat dipercaya</li>
                    <li>Meningkatkan kualitas ulasan melalui sistem validasi bertahap</li>
                    <li>Membantu RBTV meningkatkan kualitas program secara berkelanjutan</li>
                </ul>
            </div>

        </div>
    </div>

    {{-- ======================== --}}
    {{-- DEVELOPER                --}}
    {{-- ======================== --}}
    <!-- <div class="section">
        <div class="section-header">
            <h2>Tim Developer</h2>
        </div>
        <p class="section-subtitle">Orang-orang di balik pengembangan platform ini</p>

        <div class="dev-grid">

            <div class="dev-card">
                <div class="dev-avatar-wrap">
                    <img src="{{ asset('images/sella.jpg') }}"
                         alt="Sallaa Fikriyatul Arifah"
                         onerror="this.src='{{ asset('images/default.jpg') }}'">
                    <div class="dev-avatar-ring"></div>
                </div>
                <h4>Sallaa Fikriyatul Arifah</h4>
                <span class="dev-role">Developer</span>
                <span class="dev-univ">Universitas Bengkulu</span>
            </div>

            <div class="dev-card">
                <div class="dev-avatar-wrap">
                    <img src="{{ asset('images/najwa.jpg') }}"
                         alt="Najwa Nabilah Wibisono"
                         onerror="this.src='{{ asset('images/default.jpg') }}'">
                    <div class="dev-avatar-ring"></div>
                </div>
                <h4>Najwa Nabilah Wibisono</h4>
                <span class="dev-role">Developer</span>
                <span class="dev-univ">Universitas Bengkulu</span>
            </div>

        </div>
    </div> -->

    {{-- ======================== --}}
    {{-- CTA BANNER               --}}
    {{-- ======================== --}}
    <div class="cta-banner">
        <h2>Bantu Kami Meningkatkan Kualitas Program</h2>
        <p>Ulasan Anda sangat berarti untuk kualitas jurnalisme kami. Bantu kami menjadi lebih baik hari ini.</p>
        <a href="{{ url('/ulasan') }}" class="btn-cta">
            <i class="fas fa-pen-alt"></i>
            Mulai Beri Ulasan
        </a>
    </div>

</div>

@endsection