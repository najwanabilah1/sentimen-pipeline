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
    .kontak-hero {
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

    .kontak-hero::before {
        content: "";
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .kontak-hero::after {
        content: "";
        position: absolute;
        bottom: -80px; left: -40px;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .kontak-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 560px;
        margin: 0 auto;
    }

    .kontak-hero-badge {
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

    .kontak-hero h1 {
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    .kontak-hero p {
        font-size: 1rem;
        opacity: 0.88;
        line-height: 1.8;
        margin: 0;
    }

    /* ===================== */
    /* MAIN WRAPPER          */
    /* ===================== */
    .kontak-page {
        padding: 56px var(--page-px) 72px;
    }

    /* ===================== */
    /* CONTENT GRID          */
    /* ===================== */
    .kontak-content {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        margin-bottom: 56px;
        align-items: start;
    }

    /* ===================== */
    /* SECTION TITLE         */
    /* ===================== */
    .card-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 20px;
        padding-left: 13px;
        position: relative;
        letter-spacing: -0.01em;
    }

    .card-title::before {
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

    /* ===================== */
    /* KONTAK AKSI (KIRI)    */
    /* ===================== */
    .kontak-aksi {
        background: var(--white);
        padding: 32px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
    }

    .kontak-aksi-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: -12px 0 24px;
        font-weight: 500;
    }

    /* SOCIAL BUTTONS GRID */
    .sosmed-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .sosmed-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 18px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 700;
        border: 1.5px solid var(--gray);
        background: var(--white);
        color: var(--text-main);
        transition: all 0.25s;
    }

    .sosmed-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .sosmed-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        color: var(--white);
    }

    .sosmed-btn-label {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .sosmed-btn-label span {
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--text-muted);
    }

    /* WARNA PER PLATFORM */
    .sosmed-btn.whatsapp:hover { border-color: #25d366; }
    .sosmed-btn.whatsapp .sosmed-icon { background: #25d366; }

    .sosmed-btn.email:hover { border-color: var(--blue-mid); }
    .sosmed-btn.email .sosmed-icon { background: var(--blue-mid); }

    .sosmed-btn.instagram:hover { border-color: #e1306c; }
    .sosmed-btn.instagram .sosmed-icon {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }

    .sosmed-btn.youtube:hover { border-color: #ff0000; }
    .sosmed-btn.youtube .sosmed-icon { background: #ff0000; }

    /* ===================== */
    /* KONTAK INFO (KANAN)   */
    /* ===================== */
    .kontak-info {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-card {
        background: var(--white);
        padding: 20px 22px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.25s;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    .info-icon {
        width: 44px;
        height: 44px;
        background: var(--blue-xlight);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon i {
        color: var(--blue-mid);
        font-size: 1rem;
    }

    .info-text strong {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--blue-mid);
        margin-bottom: 3px;
    }

    .info-text p {
        font-size: 0.875rem;
        color: var(--text-main);
        font-weight: 600;
        margin: 0;
    }

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
        line-height: 1.75;
        position: relative;
        z-index: 1;
        max-width: 460px;
        margin: 0 auto 2rem;
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
        .kontak-content { grid-template-columns: 1fr; }
        .kontak-info { flex-direction: row; flex-wrap: wrap; }
        .info-card { flex: 1 1 calc(50% - 8px); }
    }

    @media (max-width: 768px) {
        :root { --page-px: 20px; }
        .kontak-hero { padding: 48px var(--page-px); }
        .sosmed-grid { grid-template-columns: 1fr; }
        .kontak-info { flex-direction: column; }
        .info-card { flex: unset; }
        .cta-banner { padding: 48px 24px; border-radius: 14px; }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .kontak-hero h1 { font-size: 1.65rem; }
        .kontak-aksi { padding: 24px 20px; }
    }
</style>

{{-- ======================== --}}
{{-- HERO                     --}}
{{-- ======================== --}}
<div class="kontak-hero">
    <div class="kontak-hero-inner">
        <div class="kontak-hero-badge">
            <i class="fas fa-headset"></i>
            Hubungi Kami
        </div>
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu Anda terkait sistem review RBTV</p>
    </div>
</div>

{{-- ======================== --}}
{{-- MAIN CONTENT             --}}
{{-- ======================== --}}
<div class="kontak-page">

    <div class="kontak-content">

        {{-- ======================== --}}
        {{-- KIRI — TOMBOL SOSMED    --}}
        {{-- ======================== --}}
        <div class="kontak-aksi">
            <h3 class="card-title">Hubungi Kami Langsung</h3>
            <p class="kontak-aksi-subtitle">Pilih platform yang paling nyaman untuk Anda</p>

            <div class="sosmed-grid">

                <a href="https://wa.me/6282186599322" target="_blank" class="sosmed-btn whatsapp">
                    <div class="sosmed-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="sosmed-btn-label">
                        WhatsApp
                        <span>Chat langsung</span>
                    </div>
                </a>

                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=rbtvdaerah@gmail.com&subject=Hubungi%20RBTV%20Review%20System" target="_blank" class="sosmed-btn email">
                    <div class="sosmed-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="sosmed-btn-label">
                        Email
                        <span>rbtvdaerah@gmail.com</span>
                    </div>
                </a>

                <a href="https://www.instagram.com/rbtvcamkoha?igsh=ZmZpa2RxZ2wzNXE2" target="_blank" class="sosmed-btn instagram">
                    <div class="sosmed-icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="sosmed-btn-label">
                        Instagram
                        <span>@rbtv</span>
                    </div>
                </a>

                <a href="https://www.youtube.com/@RBTVMAKINCAMKOHA" target="_blank" class="sosmed-btn youtube">
                    <div class="sosmed-icon">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <div class="sosmed-btn-label">
                        YouTube
                        <span>RBTV Official</span>
                    </div>
                </a>

            </div>
        </div>

        {{-- ======================== --}}
        {{-- KANAN — INFO KONTAK     --}}
        {{-- ======================== --}}
        <div class="kontak-info">

            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-text">
                    <strong>Email</strong>
                    <p>rbtvdaerah@gmail.com</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="info-text">
                    <strong>Telepon</strong>
                    <p>+62 821 8659 9322</p>
                </div>
            </div>

            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-text">
                    <strong>Alamat</strong>
                    <p>Bengkulu, Indonesia</p>
                </div>
            </div>

            <!-- <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="info-text">
                    <strong>Jam Operasional</strong>
                    <p>Senin – Jumat, 08.00 – 17.00</p>
                </div>
            </div> -->

        </div>

    </div>

    {{-- ======================== --}}
    {{-- CTA BANNER               --}}
    {{-- ======================== --}}
    <div class="cta-banner">
        <h2>Butuh Bantuan Cepat?</h2>
        <p>Hubungi kami langsung melalui WhatsApp untuk respon yang lebih cepat dari tim kami.</p>
        <a href="https://wa.me/6281234567890" target="_blank" class="btn-cta">
            <i class="fab fa-whatsapp"></i>
            Chat Sekarang
        </a>
    </div>

</div>

@endsection