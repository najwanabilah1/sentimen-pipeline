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
    /* WRAPPER               */
    /* ===================== */
    .detail-container {
        padding: 48px var(--page-px) 64px;
    }

    /* ===================== */
    /* BACK BUTTON           */
    /* ===================== */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        color: var(--blue-mid);
        font-size: 0.85rem;
        font-weight: 600;
        background: var(--blue-xlight);
        padding: 8px 16px;
        border-radius: 99px;
        margin-bottom: 28px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: var(--blue-mid);
        color: var(--white);
    }

    /* ===================== */
    /* MAIN CARD             */
    /* ===================== */
    .detail-card {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-md);
        margin-bottom: 48px;
    }

    /* IMAGE */
    .detail-hero {
        overflow: hidden;
        height: 380px;
        background: var(--blue-xlight);
    }

    .detail-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .detail-card:hover .detail-hero img {
        transform: scale(1.02);
    }

    /* CONTENT */
    .detail-content {
        padding: 32px 36px;
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
        margin-bottom: 14px;
        width: fit-content;
    }

    .detail-content h1 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: -0.02em;
        color: var(--text-main);
        margin: 0 0 18px;
    }

    /* META */
    .meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.825rem;
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .meta-date {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rating-summary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        color: #92400e;
        padding: 5px 12px;
        border-radius: 99px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .rating-summary i {
        color: #f59e0b;
    }

    /* DIVIDER */
    .detail-divider {
        border: none;
        border-top: 1px solid var(--gray);
        margin: 0 0 24px;
    }

    /* CAPTION */
    .caption {
        font-size: 0.95rem;
        line-height: 1.85;
        color: #334155;
        margin: 0 0 32px;
    }

    /* BUTTONS */
    .action-btn {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        padding-top: 8px;
        border-top: 1px solid var(--gray);
    }

    .btn-primary {
        background: var(--blue-mid);
        color: var(--white);
        padding: 12px 28px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 700;
        transition: all 0.25s;
        min-width: 160px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .btn-primary:hover {
        background: var(--blue-dark);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--text-main);
        padding: 12px 28px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 700;
        border: 1.5px solid var(--gray);
        transition: all 0.25s;
        min-width: 160px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .btn-secondary:hover {
        background: var(--off-white);
        border-color: var(--blue-mid);
        color: var(--blue-mid);
        transform: translateY(-2px);
    }

    /* ===================== */
    /* ULASAN SECTION        */
    /* ===================== */
    .ulasan-section {
        margin-top: 8px;
    }

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

    /* SCROLL WRAPPER */
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

    /* CARD */
    .ulasan-card {
        flex: 0 0 300px;
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

    /* TOP */
    .ulasan-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .stars {
        display: flex;
        gap: 2px;
        font-size: 0.85rem;
        color: #f59e0b;
    }

    .stars .far {
        color: #d1d5db;
    }

    .tanggal {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* TEXT */
    .ulasan-text {
        font-size: 0.875rem;
        color: #475569;
        font-style: italic;
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 16px;
        flex-grow: 1;
    }

    /* USER */
    .user-footer {
        font-weight: 700;
        font-size: 0.83rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
        border-top: 1px solid var(--gray);
        padding-top: 12px;
        margin-top: auto;
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
    }

    .empty-ulasan i {
        font-size: 2rem;
        margin-bottom: 12px;
        color: var(--gray);
        display: block;
    }

    .empty-ulasan p {
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }

    /* NOT FOUND */
    .not-found {
        text-align: center;
        padding: 80px 24px;
        color: var(--text-muted);
    }

    .not-found i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--gray);
        display: block;
    }

    .not-found h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    /* ===================== */
    /* RESPONSIVE            */
    /* ===================== */
    @media (max-width: 991px) {
        :root { --page-px: 32px; }
    }

    @media (max-width: 768px) {
        :root { --page-px: 20px; }

        .detail-hero { height: 240px; }
        .detail-content { padding: 24px 20px; }

        .meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-btn {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .ulasan-card { flex: 0 0 270px; }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .detail-content h1 { font-size: 1.4rem; }
    }
</style>

<div class="detail-container">

    {{-- BACK --}}
    <a href="{{ url('/program') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Program
    </a>

    @if(!$data)

        <div class="not-found">
            <i class="fas fa-newspaper"></i>
            <h2>Berita tidak ditemukan</h2>
            <p>Berita yang kamu cari tidak tersedia atau telah dihapus.</p>
        </div>

    @else

    {{-- MAIN CARD --}}
    <div class="detail-card">

        {{-- IMAGE --}}
        <div class="detail-hero">
            <img src="{{ asset('uploads/' . $data->gambar_berita) }}"
                 alt="{{ $data->judul_berita }}"
                 onerror="this.src='{{ asset('images/default.jpg') }}'">
        </div>

        {{-- CONTENT --}}
        <div class="detail-content">

            <span class="badge-kategori">{{ $data->kategori_berita }}</span>

            <h1>{{ $data->judul_berita }}</h1>

            {{-- META --}}
            <div class="meta">
                <span class="meta-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($data->tanggal_berita)->translatedFormat('l, d F Y') }}
                </span>

                <span class="rating-summary">
                    <i class="fas fa-star"></i>
                    {{ $avg }} &nbsp;·&nbsp; {{ $count }} ulasan
                </span>
            </div>

            <hr class="detail-divider">

            <p class="caption">
                {!! nl2br(e($data->caption_berita)) !!}
            </p>

            {{-- BUTTONS --}}
            <div class="action-btn">
                <a href="{{ url('/ulasan') }}" class="btn-primary">
                    <i class="fas fa-star"></i>
                    Beri Ulasan
                </a>
                <a href="{{ url('/program') }}" class="btn-secondary">
                    <i class="fas fa-th-list"></i>
                    Lihat Program Lain
                </a>
            </div>

        </div>

    </div>

    {{-- ULASAN SECTION --}}
    <div class="ulasan-section">

        <div class="section-header">
            <h2>Ulasan Pengguna</h2>
        </div>
        <p class="section-subtitle">
            {{ $count > 0 ? $count . ' ulasan telah diberikan untuk berita ini' : 'Belum ada ulasan untuk berita ini' }}
        </p>

        @if($count > 0)
            <div class="ulasan-wrapper">

                @foreach($ulasan as $row)
                <div class="ulasan-card">

                    {{-- TOP --}}
                    <div class="ulasan-top">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $row->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="tanggal">
                            {{ \Carbon\Carbon::parse($row->waktu_kirim)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    {{-- ISI --}}
                    <p class="ulasan-text">"{{ $row->isi_ulasan_raw }}"</p>

                    {{-- USER --}}
                    <div class="user-footer">
                        {{ $row->nama_user }}
                    </div>

                </div>
                @endforeach

            </div>

        @else
            <div class="empty-ulasan">
                <i class="fas fa-comment-slash"></i>
                <p>Belum ada ulasan untuk berita ini. Jadilah yang pertama memberi ulasan!</p>
            </div>
        @endif

    </div>

    @endif

</div>

<script src="{{ asset('assets/js/detail.js') }}"></script>

@endsection