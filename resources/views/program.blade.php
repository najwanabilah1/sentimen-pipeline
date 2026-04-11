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
    /* PROGRAM HERO          */
    /* ===================== */
    .program-hero {
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

    .program-hero::before {
        content: "";
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
    }

    .program-hero::after {
        content: "";
        position: absolute;
        bottom: -80px; left: -40px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .program-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 600px;
        margin: 0 auto;
    }

    .program-hero-badge {
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

    .program-hero h1 {
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
    }

    .program-hero p {
        font-size: 1rem;
        opacity: 0.88;
        line-height: 1.8;
        margin: 0;
    }

    /* ===================== */
    /* MAIN WRAPPER          */
    /* ===================== */
    .program-main {
        padding: 48px var(--page-px) 64px;
    }

    /* ===================== */
    /* FILTER BAR            */
    /* ===================== */
    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        align-items: center;
        background: var(--white);
        padding: 16px 20px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        box-shadow: var(--shadow-sm);
    }

    .filter-bar input {
        flex: 1;
        min-width: 180px;
        padding: 9px 14px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray);
        font-size: 0.875rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        color: var(--text-main);
        background: var(--off-white);
    }

    .filter-bar input:focus {
        border-color: var(--blue-mid);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: var(--white);
    }

    .filter-bar input::placeholder {
        color: var(--text-muted);
    }

    .filter-bar select {
        padding: 9px 36px 9px 14px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--gray);
        font-size: 0.875rem;
        font-family: inherit;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-color: var(--off-white);
        background-image: url("data:image/svg+xml;utf8,<svg fill='%2364748b' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5' stroke='%2364748b' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/></svg>");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        color: var(--text-main);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-bar select:hover {
        border-color: var(--blue-mid);
    }

    .filter-bar select:focus {
        border-color: var(--blue-mid);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background-color: var(--white);
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
        margin-bottom: 24px;
        font-weight: 500;
    }

    /* ===================== */
    /* BERITA LIST (CARDS)   */
    /* ===================== */
    #beritaList {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .berita-item {
        display: flex;
        gap: 20px;
        background: var(--white);
        padding: 16px;
        border-radius: var(--radius);
        border: 1px solid var(--gray);
        align-items: center;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .berita-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: var(--blue-light);
    }

    /* IMAGE */
    .thumb {
        flex-shrink: 0;
        overflow: hidden;
        border-radius: var(--radius-sm);
        background: var(--blue-xlight);
    }

    .thumb img {
        width: 200px;
        height: 130px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        display: block;
        transition: transform 0.4s ease;
    }

    .berita-item:hover .thumb img {
        transform: scale(1.04);
    }

    /* CONTENT */
    .berita-content {
        flex: 1;
        min-width: 0;
    }

    .top {
        margin-bottom: 6px;
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
        width: fit-content;
    }

    .berita-content h3 {
        margin: 6px 0;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.45;
        color: var(--text-main);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .berita-content p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .meta {
        font-size: 0.775rem;
        color: var(--text-muted);
        margin-top: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ACTION */
    .action {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }

    .btn-detail {
        background: var(--blue-mid);
        color: var(--white);
        padding: 9px 20px;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 700;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: var(--blue-dark);
        color: var(--white);
        transform: translateY(-1px);
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
        color: var(--text-muted);
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--gray);
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--gray);
        display: block;
    }

    .empty-state p {
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* ===================== */
    /* RESPONSIVE            */
    /* ===================== */
    @media (max-width: 991px) {
        :root { --page-px: 32px; }
    }

    @media (max-width: 768px) {
        :root { --page-px: 20px; }

        .program-hero {
            padding: 48px var(--page-px);
        }

        .berita-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .thumb img {
            width: 100%;
            height: 200px;
        }

        .action {
            width: 100%;
            margin-top: 4px;
        }

        .btn-detail {
            width: 100%;
            justify-content: center;
        }

        .filter-bar {
            flex-direction: column;
            gap: 10px;
        }

        .filter-bar input,
        .filter-bar select {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        :root { --page-px: 16px; }
        .program-hero h1 { font-size: 1.65rem; }
    }
</style>

{{-- ======================== --}}
{{-- PROGRAM HERO             --}}
{{-- ======================== --}}
<div class="program-hero">
    <div class="program-hero-inner">
        <div class="program-hero-badge">
            <i class="fas fa-newspaper"></i>
            Program Berita
        </div>
        <h1>Program Berita RBTV</h1>
        <p>Jelajahi seluruh program berita terbaru dan terupdate dari RBTV</p>
    </div>
</div>

{{-- ======================== --}}
{{-- MAIN CONTENT             --}}
{{-- ======================== --}}
<div class="program-main">

    {{-- FILTER --}}
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Cari berita...">

        <select id="sortSelect">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
            <option value="az">Judul A-Z</option>
            <option value="za">Judul Z-A</option>
        </select>

        <select id="kategoriSelect">
            <option value="">Semua Kategori</option>
            <option value="Malam">Berita Malam</option>
            <option value="Daerah">Berita Daerah</option>
            <option value="Pekaro">Pekaro</option>
        </select>
    </div>

    {{-- SECTION HEADER --}}
    <div class="section-header">
        <h2>Semua Berita</h2>
    </div>
    <p class="section-subtitle">Menampilkan seluruh program berita dari redaksi RBTV</p>

    {{-- LIST --}}
    <div id="beritaList">

        @forelse($berita as $row)
        <div class="berita-item"
            data-judul="{{ strtolower($row->judul_berita) }}"
            data-kategori="{{ $row->kategori_berita }}"
            data-tanggal="{{ $row->tanggal_berita }}"
        >
            {{-- IMAGE --}}
            <div class="thumb">
                <img src="{{ asset('uploads/' . $row->gambar_berita) }}"
                     alt="{{ $row->judul_berita }}"
                     onerror="this.src='{{ asset('images/default.jpg') }}'">
            </div>

            {{-- CONTENT --}}
            <div class="berita-content">
                <div class="top">
                    <span class="badge-kategori">{{ $row->kategori_berita }}</span>
                </div>

                <h3>{{ $row->judul_berita }}</h3>

                <p>{{ \Illuminate\Support\Str::limit($row->caption_berita, 120) }}</p>

                <div class="meta">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($row->tanggal_berita)->translatedFormat('d F Y') }}
                </div>
            </div>

            {{-- ACTION --}}
            <div class="action">
                <a href="{{ url('detail/' . $row->id_berita) }}" class="btn-detail">
                    <i class="fas fa-arrow-right"></i>
                    Baca Detail
                </a>
            </div>

        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <p>Belum ada berita tersedia.</p>
        </div>
        @endforelse

    </div>

</div>

<script>
    const searchInput   = document.getElementById('searchInput');
    const sortSelect    = document.getElementById('sortSelect');
    const kategoriSelect = document.getElementById('kategoriSelect');
 
    // Ambil semua item sekali saja saat halaman load
    const items = Array.from(document.querySelectorAll('.berita-item'));
 
    function filterData() {
        const search   = searchInput.value.toLowerCase();
        const kategori = kategoriSelect.value;
 
        items.forEach(item => {
            const judulMatch    = item.dataset.judul.includes(search);
            const kategoriMatch = !kategori || item.dataset.kategori === kategori;
 
            item.style.display = (judulMatch && kategoriMatch) ? 'flex' : 'none';
        });
    }
 
    function sortData() {
        const container = document.getElementById('beritaList');
        const sort      = sortSelect.value;
 
        const sorted = [...items].sort((a, b) => {
            const dateA = new Date(a.dataset.tanggal);
            const dateB = new Date(b.dataset.tanggal);
 
            if (sort === 'terbaru') return dateB - dateA;
            if (sort === 'terlama') return dateA - dateB;
            if (sort === 'az')      return a.dataset.judul.localeCompare(b.dataset.judul);
            if (sort === 'za')      return b.dataset.judul.localeCompare(a.dataset.judul);
        });
 
        sorted.forEach(el => container.appendChild(el));
    }
 
    searchInput.addEventListener('input', filterData);
    kategoriSelect.addEventListener('change', filterData);
    sortSelect.addEventListener('change', () => {
        sortData();
        filterData(); // tetap terapkan filter aktif setelah sort
    });
</script>

@endsection