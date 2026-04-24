<footer class="site-footer">

    <div class="footer-main">

        {{-- ======================== --}}
        {{-- KOLOM 1 — BRAND         --}}
        {{-- ======================== --}}
        <div class="footer-brand">
            <a href="{{ url('/') }}" class="footer-logo">
                <img src="{{ asset('images/logo.png') }}"
                     alt="RBTV"
                     onerror="this.style.display='none'">
                <div class="footer-logo-text">
                    <strong>RBTV</strong>
                    <span>Review System</span>
                </div>
            </a>

            <p class="footer-desc">
                Platform ulasan terpercaya untuk program berita RBTV. Suara Anda adalah inspirasi kami untuk menyajikan informasi yang lebih akurat dan tajam.
            </p>

            {{-- SOSMED --}}
            <div class="footer-sosmed">
                <a href="https://wa.me/6282186599322" target="_blank" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://www.youtube.com/redirect?event=channel_description&redir_token=QUFFLUhqbHR4c1ZMWHRCbHVjZXczSHp2ekxXbUYtTFg5d3xBQ3Jtc0ttLVd4dG8yN0RWZ3RYbnJqRkNtOWp6MXhkLTBCbkpSTjlhdHVQbUU2NGkyaUZzbUFRN201My1zc1BOMGxqZW91RlVReUo3SGY0UE9xbzQ3WkNITzR4MnhvQTJPS1RGS1g5ck5fMGVvM2tWeTJoOW9KOA&q=https%3A%2F%2Fwww.instagram.com%2Frbtvcamkoha%3Figsh%3DMWUwcm9uMmlwbWFxNw%3D%3D" target="_blank" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.youtube.com/@RBTVMAKINCAMKOHA" target="_blank" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=info@rbtv.co.id&subject=Hubungi%20RBTV%20Review%20System" target="_blank" aria-label="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>

        {{-- ======================== --}}
        {{-- KOLOM 2 — LINK CEPAT    --}}
        {{-- ======================== --}}
        <div class="footer-col">
            <h4 class="footer-col-title">Navigasi</h4>
            <ul class="footer-links">
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ url('/program') }}">
                        <i class="fas fa-newspaper"></i> Program
                    </a>
                </li>
                <li>
                    <a href="{{ url('/ulasan') }}">
                        <i class="fas fa-star"></i> Ulasan
                    </a>
                </li>
                <li>
                    <a href="{{ url('/tentang') }}">
                        <i class="fas fa-info-circle"></i> Tentang
                    </a>
                </li>
                <li>
                    <a href="{{ url('/kontak') }}">
                        <i class="fas fa-envelope"></i> Kontak
                    </a>
                </li>
            </ul>
        </div>

        {{-- ======================== --}}
        {{-- KOLOM 3 — KONTAK        --}}
        {{-- ======================== --}}
        <div class="footer-col">
            <h4 class="footer-col-title">Kontak Kami</h4>
            <ul class="footer-contact">
                <li>
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <span>Email</span>
                        <a href="mailto:info@rbtv.co.id">info@rbtv.co.id</a>
                    </div>
                </li>
                <li>
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <span>Telepon</span>
                        <a href="tel:+6281234567890">+62 812 3456 7890</a>
                    </div>
                </li>
                <li>
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <span>Alamat</span>
                        <p>Bengkulu, Indonesia</p>
                    </div>
                </li>
                <li>
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <span>Jam Operasional</span>
                        <p>Senin – Jumat, 08.00 – 17.00</p>
                    </div>
                </li>
            </ul>
        </div>

        {{-- ======================== --}}
        {{-- KOLOM 4 — CTA           --}}
        {{-- ======================== --}}
        <div class="footer-col">
            <h4 class="footer-col-title">Beri Ulasan</h4>
            <p class="footer-cta-desc">
                Punya pendapat tentang program berita RBTV? Bagikan ulasan Anda dan bantu kami berkembang.
            </p>
            <a href="{{ url('/ulasan') }}" class="footer-btn-ulasan">
                <i class="fas fa-pen-alt"></i>
                Tulis Ulasan
            </a>

            <div class="footer-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Ulasan terverifikasi & aman</span>
            </div>
        </div>

    </div>

    {{-- ======================== --}}
    {{-- FOOTER BOTTOM            --}}
    {{-- ======================== --}}
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p class="footer-copy">
                &copy; {{ date('Y') }} <strong>RBTV Review System</strong>. All rights reserved.
            </p>
            <p class="footer-made">
                Dibuat oleh Mahasiswa <strong>Universitas Bengkulu</strong>
            </p>
        </div>
    </div>

</footer>

<style>
    .site-footer {
        background: #0f172a;
        color: #94a3b8;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ===================== */
    /* MAIN AREA             */
    /* ===================== */
    .footer-main {
        display: grid;
        grid-template-columns: 1.8fr 1fr 1.3fr 1.2fr;
        gap: 48px;
        padding: 64px 48px 48px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    /* ===================== */
    /* BRAND                 */
    /* ===================== */
    .footer-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        margin-bottom: 18px;
    }

    .footer-logo img {
        height: 34px;
        width: auto;
        object-fit: contain;
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }

    .footer-logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .footer-logo-text strong {
        font-size: 1rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.02em;
    }

    .footer-logo-text span {
        font-size: 0.68rem;
        font-weight: 500;
        color: #64748b;
        letter-spacing: 0.02em;
    }

    .footer-desc {
        font-size: 0.855rem;
        line-height: 1.75;
        color: #64748b;
        margin-bottom: 24px;
        max-width: 280px;
    }

    /* SOSMED */
    .footer-sosmed {
        display: flex;
        gap: 10px;
    }

    .footer-sosmed a {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.25s;
    }

    .footer-sosmed a:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        transform: translateY(-3px);
    }

    /* ===================== */
    /* KOLOM JUDUL           */
    /* ===================== */
    .footer-col-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .footer-col-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 24px;
        height: 2px;
        background: #2563eb;
        border-radius: 2px;
    }

    /* ===================== */
    /* NAV LINKS             */
    /* ===================== */
    .footer-links {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .footer-links a {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 6px 8px;
        border-radius: 6px;
        text-decoration: none;
        color: #64748b;
        font-size: 0.855rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .footer-links a i {
        font-size: 0.78rem;
        color: #334155;
        width: 14px;
        text-align: center;
        transition: color 0.2s;
    }

    .footer-links a:hover {
        color: #ffffff;
        background: rgba(255,255,255,0.05);
        padding-left: 12px;
    }

    .footer-links a:hover i {
        color: #2563eb;
    }

    /* ===================== */
    /* KONTAK LIST           */
    /* ===================== */
    .footer-contact {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .contact-icon {
        width: 32px;
        height: 32px;
        background: rgba(37, 99, 235, 0.15);
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .contact-icon i {
        color: #3b82f6;
        font-size: 0.78rem;
    }

    .footer-contact li div span {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #475569;
        margin-bottom: 2px;
    }

    .footer-contact li div a,
    .footer-contact li div p {
        font-size: 0.845rem;
        color: #94a3b8;
        text-decoration: none;
        font-weight: 500;
        margin: 0;
        transition: color 0.2s;
    }

    .footer-contact li div a:hover {
        color: #ffffff;
    }

    /* ===================== */
    /* CTA KOLOM             */
    /* ===================== */
    .footer-cta-desc {
        font-size: 0.845rem;
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .footer-btn-ulasan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.845rem;
        font-weight: 700;
        transition: all 0.25s;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        margin-bottom: 16px;
    }

    .footer-btn-ulasan:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
    }

    .footer-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 99px;
        padding: 6px 12px;
        font-size: 0.72rem;
        color: #475569;
        font-weight: 600;
    }

    .footer-badge i {
        color: #22c55e;
        font-size: 0.75rem;
    }

    /* ===================== */
    /* FOOTER BOTTOM         */
    /* ===================== */
    .footer-bottom {
        padding: 20px 48px;
    }

    .footer-bottom-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .footer-copy,
    .footer-made {
        font-size: 0.8rem;
        color: #334155;
        margin: 0;
    }

    .footer-copy strong,
    .footer-made strong {
        color: #475569;
        font-weight: 700;
    }

    /* ===================== */
    /* RESPONSIVE            */
    /* ===================== */
    @media (max-width: 1024px) {
        .footer-main {
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
    }

    @media (max-width: 768px) {
        .footer-main {
            grid-template-columns: 1fr;
            padding: 48px 20px 36px;
            gap: 36px;
        }

        .footer-bottom {
            padding: 20px;
        }

        .footer-bottom-inner {
            flex-direction: column;
            text-align: center;
        }

        .footer-desc { max-width: 100%; }
    }

    @media (max-width: 480px) {
        .footer-main { padding: 40px 16px 32px; }
        .footer-bottom { padding: 18px 16px; }
    }
</style>