@extends('layouts.app')

@section('content')

<style>

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
    .ulasan-hero {
        background: linear-gradient(110deg,
            rgba(30, 58, 138, 0.97) 0%,
            rgba(37, 99, 235, 0.88) 55%,
            rgba(29, 78, 216, 0.75) 100%);
        color: var(--white);
        padding: 64px var(--page-px);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .ulasan-hero::before {
        content: "";
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .ulasan-hero::after {
        content: "";
        position: absolute;
        bottom: -80px; left: -40px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .ulasan-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 560px;
        margin: 0 auto;
    }

    .ulasan-hero-badge {
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

    .ulasan-hero h1 {
        font-size: clamp(1.8rem, 4vw, 2.6rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    .ulasan-hero p {
        font-size: 1rem;
        opacity: 0.88;
        line-height: 1.8;
        margin: 0;
    }

    /* ===================== */
    /* MAIN WRAPPER          */
    /* ===================== */
    .ulasan-page {
        padding: 48px var(--page-px) 64px;
    }

    /* ===================== */
    /* ALERT NOTIF           */
    /* ===================== */
    .alert-notif {
        background: #16a34a;
        color: var(--white);
        padding: 14px 20px;
        border-radius: var(--radius-sm);
        margin-bottom: 28px;
        text-align: center;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        max-width: 860px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ===================== */
    /* FORM WRAPPER          */
    /* ===================== */
    .form-wrapper {
        background: var(--white);
        padding: 36px 40px;
        border-radius: var(--radius);
        max-width: 860px;
        margin: 0 auto 56px;
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-md);
    }

    .form-wrapper h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 28px;
        text-align: center;
        letter-spacing: -0.01em;
    }

    /* ===================== */
    /* FORM GRID             */
    /* ===================== */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    .form-left {
        padding-right: 32px;
        border-right: 1px solid var(--gray);
    }

    .form-right {
        padding-left: 32px;
    }

    /* ===================== */
    /* FORM ELEMENTS         */
    /* ===================== */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-group label .required {
        color: var(--red);
        margin-left: 2px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray);
        font-size: 0.875rem;
        font-family: inherit;
        color: var(--text-main);
        background: var(--off-white);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--blue-mid);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: var(--white);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: var(--text-muted);
    }

    .form-group select {
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        padding-right: 36px;
        background-image: url("data:image/svg+xml;utf8,<svg fill='none' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5' stroke='%2364748b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/></svg>");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        background-color: var(--off-white);
    }

    .form-group select:hover {
        border-color: var(--blue-mid);
    }

    .form-group textarea {
        height: 120px;
        resize: vertical;
        line-height: 1.65;
    }

    /* ===================== */
    /* SEARCH INPUT ICON     */
    /* ===================== */
    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.85rem;
        pointer-events: none;
    }

    .input-icon-wrap input {
        padding-left: 34px;
    }

    /* ===================== */
    /* RATING STARS          */
    /* ===================== */
    .rating-stars {
        display: flex;
        gap: 6px;
        margin-top: 4px;
    }

    .star {
        font-size: 1.75rem;
        cursor: pointer;
        color: #d1d5db;
        transition: color 0.15s, transform 0.15s;
        line-height: 1;
        user-select: none;
    }

    .star:hover,
    .star.active {
        color: #f59e0b;
        transform: scale(1.15);
    }

    /* ===================== */
    /* ANONIM BOX            */
    /* ===================== */
    .anonim-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--off-white);
        border: 1px solid var(--gray);
        border-radius: var(--radius-sm);
        padding: 12px 14px;
        margin-top: 4px;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .anonim-box:hover {
        border-color: var(--blue-mid);
    }

    .anonim-box input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--blue-mid);
        cursor: pointer;
        flex-shrink: 0;
        margin: 0;
    }

    .anonim-box label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        margin: 0;
        text-transform: none;
        letter-spacing: 0;
    }

    /* ===================== */
    /* SUBMIT BUTTON         */
    /* ===================== */
    .form-submit {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--gray);
        text-align: center;
    }

    .btn-submit {
        background: var(--blue-mid);
        color: var(--white);
        padding: 13px 40px;
        border: none;
        border-radius: var(--radius-sm);
        font-size: 0.9rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-submit:hover {
        background: var(--blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
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

    .section-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    /* ===================== */
    /* ULASAN CARDS          */
    /* ===================== */
    .ulasan-wrapper {
        display: flex;
        gap: 18px;
        overflow-x: auto;
        padding: 4px 2px 24px;
        scrollbar-width: thin;
        scrollbar-color: var(--gray) transparent;
    }

    .ulasan-wrapper::-webkit-scrollbar { height: 5px; }
    .ulasan-wrapper::-webkit-scrollbar-track { background: transparent; }
    .ulasan-wrapper::-webkit-scrollbar-thumb { background: var(--gray); border-radius: 10px; }

    .ulasan-card {
        flex: 0 0 295px;
        background: var(--white);
        padding: 20px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s;
    }

    .ulasan-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    .ulasan-card-top {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-grow: 1;
    }

    .ulasan-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .stars-display {
        display: flex;
        gap: 2px;
        font-size: 0.9rem;
    }

    .stars-display .fas.fa-star { color: #f59e0b; }
    .stars-display .far.fa-star { color: #d1d5db; }

    .ulasan-text {
        font-size: 0.86rem;
        font-style: italic;
        color: #475569;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.65;
        flex-grow: 1;
    }

    .user-footer {
        font-weight: 700;
        font-size: 0.83rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
        border-top: 1px solid var(--gray);
        padding-top: 12px;
        margin-top: 14px;
    }

    .user-footer::before {
        content: "";
        width: 18px;
        height: 3px;
        background: var(--red);
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* EMPTY */
    .empty-ulasan {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        width: 100%;
    }

    .empty-ulasan i {
        font-size: 2rem;
        margin-bottom: 12px;
        color: var(--gray);
        display: block;
    }

    /* ===================== */
    /* RESPONSIVE            */
    /* ===================== */
    @media (max-width: 991px) {
        :root { --page-px: 32px; }
    }

    @media (max-width: 768px) {
        :root { --page-px: 20px; }

        .ulasan-hero { padding: 48px var(--page-px); }

        .form-wrapper { padding: 24px 20px; }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-left {
            padding-right: 0;
            border-right: none;
            border-bottom: 1px solid var(--gray);
            padding-bottom: 24px;
            margin-bottom: 8px;
        }

        .form-right { padding-left: 0; }

        .ulasan-card { flex: 0 0 270px; }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .ulasan-hero h1 { font-size: 1.65rem; }
        .btn-submit { width: 100%; justify-content: center; }
    }
</style>

{{-- ======================== --}}
{{-- HERO                     --}}
{{-- ======================== --}}
<div class="ulasan-hero">
    <div class="ulasan-hero-inner">
        <div class="ulasan-hero-badge">
            <i class="fas fa-star"></i>
            Ulasan Program
        </div>
        <h1>Beri Ulasan</h1>
        <p>Bagikan pendapat Anda tentang program berita RBTV</p>
    </div>
</div>

{{-- ======================== --}}
{{-- MAIN CONTENT             --}}
{{-- ======================== --}}
<div class="ulasan-page">

    {{-- ALERT NOTIF --}}
    @if(session('notif'))
        <div class="alert-notif" id="alertNotif">
            <i class="fas fa-check-circle"></i>
            {{ session('notif') }}
        </div>
    @endif

    {{-- ======================== --}}
    {{-- FORM                     --}}
    {{-- ======================== --}}
    <div class="form-wrapper">
        <h3>Formulir Ulasan</h3>

        <form action="{{ route('ulasan.store') }}" method="POST" id="ulasanForm">
            @csrf

            <div class="form-grid">

                {{-- LEFT SIDE --}}
                <div class="form-left">

                    {{-- KATEGORI --}}
                    <div class="form-group">
                        <label>Pilih Kategori</label>
                        <select name="kategori_berita" id="kategoriSelect">
                            <option value="">Semua Kategori</option>
                            <option value="Malam">Malam</option>
                            <option value="Daerah">Daerah</option>
                            <option value="Pekaro">Pekaro</option>
                        </select>
                    </div>

                    {{-- SEARCH --}}
                    <div class="form-group">
                        <label>Cari Berita</label>
                        <div class="input-icon-wrap">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchBerita" placeholder="Cari berdasarkan judul...">
                        </div>
                    </div>

                    {{-- JUDUL --}}
                    <div class="form-group">
                        <label>Pilih Berita <span class="required">*</span></label>
                        <select name="judul_berita" id="judulSelect" required>
                            <option value="">Pilih berita yang ingin diulas</option>
                            @foreach($berita as $row)
                                <option value="{{ $row->judul_berita }}"
                                        data-kategori="{{ $row->kategori_berita }}">
                                    {{ $row->judul_berita }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- RATING --}}
                    <div class="form-group">
                        <label>Rating Bintang <span class="required">*</span></label>
                        <div class="rating-stars" id="starContainer">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}">☆</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" required>
                    </div>

                </div>

                {{-- RIGHT SIDE --}}
                <div class="form-right">

                    {{-- ULASAN --}}
                    <div class="form-group">
                        <label>Ulasan Anda <span class="required">*</span></label>
                        <textarea name="isi_ulasan_raw" placeholder="Tulis ulasan Anda..." required></textarea>
                    </div>

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label>Nama Pemberi Ulasan</label>
                        <input type="text" name="nama_user" id="namaInput" placeholder="Nama lengkap Anda">
                    </div>

                    {{-- ANONIM --}}
                    <div class="form-group">
                        <label>Opsi Anonim</label>
                        <div class="anonim-box">
                            <input type="checkbox" id="anonimCheck">
                            <label for="anonimCheck">Kirim sebagai anonim</label>
                        </div>
                    </div>

                </div>

            </div>

            {{-- SUBMIT --}}
            <div class="form-submit">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Ulasan
                </button>
            </div>

        </form>
    </div>

    {{-- ======================== --}}
    {{-- ULASAN SEBELUMNYA        --}}
    {{-- ======================== --}}
    <div class="section-header">
        <h2>Ulasan Sebelumnya</h2>
    </div>
    <p class="section-subtitle">Feedback nyata dari penonton setia RBTV</p>

    <div class="ulasan-wrapper">
        @forelse($ulasan as $row)
        <div class="ulasan-card">
            <div class="ulasan-card-top">

                {{-- HEADER --}}
                <div class="ulasan-card-header">
                    <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                    <a href="{{ url('detail/' . $row->id_berita) }}"
                       class="badge-program">
                        Detail Berita
                    </a>
                </div>

                {{-- THUMB --}}
                <div class="news-mini-info">
                    <img src="{{ asset('uploads/'.($row->gambar_berita ?? 'default.jpg')) }}"
                         alt="{{ $row->judul_berita }}"
                         onerror="this.src='{{ asset('images/default.jpg') }}'">
                    <div class="news-mini-title">{{ $row->judul_berita }}</div>
                </div>

                {{-- RATING --}}
                <div class="stars-display">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $row->rating ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>

                {{-- TEXT --}}
                <p class="ulasan-text">"{{ $row->isi_ulasan_raw }}"</p>

            </div>

            {{-- USER --}}
            <div class="user-footer">
                {{ $row->nama_user }}
            </div>
        </div>
        @empty
        <div class="empty-ulasan">
            <i class="fas fa-comment-slash"></i>
            <p>Belum ada ulasan yang tersedia.</p>
        </div>
        @endforelse
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ========================
    // RATING INTERAKTIF
    // ========================
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('ratingValue');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const val = this.dataset.value;
            ratingValue.value = val;

            stars.forEach(s => {
                if (s.dataset.value <= val) {
                    s.classList.add('active');
                    s.textContent = '★';
                } else {
                    s.classList.remove('active');
                    s.textContent = '☆';
                }
            });
        });

        // Hover preview
        star.addEventListener('mouseenter', function () {
            const val = this.dataset.value;
            stars.forEach(s => {
                s.style.color = s.dataset.value <= val ? '#f59e0b' : '#d1d5db';
            });
        });

        star.addEventListener('mouseleave', function () {
            const current = ratingValue.value;
            stars.forEach(s => {
                if (current) {
                    s.style.color = s.dataset.value <= current ? '#f59e0b' : '#d1d5db';
                } else {
                    s.style.color = '#d1d5db';
                }
            });
        });
    });

    // ========================
    // FILTER KATEGORI → JUDUL
    // ========================
    const kategoriSelect = document.getElementById('kategoriSelect');
    const searchBerita   = document.getElementById('searchBerita');
    const judulSelect    = document.getElementById('judulSelect');
    const allOptions     = Array.from(judulSelect.options).slice(1); // skip placeholder

    function filterJudul() {
        const kategori = kategoriSelect.value.toLowerCase();
        const search   = searchBerita.value.toLowerCase();

        judulSelect.innerHTML = '<option value="">Pilih berita yang ingin diulas</option>';

        allOptions.forEach(opt => {
            const optKat  = (opt.getAttribute('data-kategori') || '').toLowerCase();
            const optText = opt.text.toLowerCase();

            const matchKat    = !kategori || optKat === kategori;
            const matchSearch = !search || optText.includes(search);

            if (matchKat && matchSearch) {
                judulSelect.appendChild(opt.cloneNode(true));
            }
        });
    }

    kategoriSelect.addEventListener('change', filterJudul);
    searchBerita.addEventListener('input', filterJudul);

    // ========================
    // ANONIM CHECKBOX
    // ========================
    const anonimCheck = document.getElementById('anonimCheck');
    const namaInput   = document.getElementById('namaInput');
    let savedName     = '';

    anonimCheck.addEventListener('change', function () {
        if (this.checked) {
            savedName       = namaInput.value;
            namaInput.value = 'Anonim';
            namaInput.readOnly = true;
            namaInput.style.color = 'var(--text-muted)';
        } else {
            namaInput.value = savedName;
            namaInput.readOnly = false;
            namaInput.style.color = 'var(--text-main)';
        }
    });

    // ========================
    // AUTO HIDE ALERT
    // ========================
    const alertBox = document.getElementById('alertNotif');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = 'opacity 0.5s';
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500);
        }, 3000);
    }

    // ========================
    // FORM VALIDATION
    // ========================
    document.getElementById('ulasanForm').addEventListener('submit', function (e) {
        if (!ratingValue.value) {
            alert('Rating bintang wajib dipilih!');
            e.preventDefault();
        }
    });

});
</script>

@endsection