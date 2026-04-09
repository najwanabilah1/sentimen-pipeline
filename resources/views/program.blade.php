@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
  :root {
    --primary-blue: #0A58CA;
    --deep-navy: #0B192C;
    --accent-red: #E63946;
    --accent-cyan: #00B4DB;
    --pure-white: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --bg-light: #f1f5f9;
    --font-heading: 'Outfit', sans-serif;
    --font-body: 'Plus Jakarta Sans', sans-serif;
  }

  body { 
    background-color: var(--bg-light); 
    color: var(--text-main); 
    font-family: var(--font-body); 
    overflow-x: hidden;
  }

  /* BACKGROUND BLOB ANIMATION */
  .bg-animated {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    z-index: -1; background: var(--bg-light); overflow: hidden;
  }
  .blob {
    position: absolute; filter: blur(80px); opacity: 0.12; 
    animation: floatBlob 25s infinite alternate ease-in-out;
  }
  .blob-1 { width: 500px; height: 500px; background: var(--primary-blue); top: -150px; right: -100px; border-radius: 40% 60% 70% 30%; }
  .blob-2 { width: 400px; height: 400px; background: var(--accent-red); bottom: -100px; left: -100px; border-radius: 60% 40% 30% 70%; animation-delay: -5s; }
  .blob-3 { width: 350px; height: 350px; background: var(--accent-cyan); top: 30%; left: 15%; border-radius: 50% 50% 60% 40%; animation-delay: -12s; }

  @keyframes floatBlob {
    0% { transform: translate(0, 0) rotate(0deg) scale(1); }
    100% { transform: translate(-30px, 120px) rotate(360deg) scale(0.9); }
  }

  /* HERO SECTION */
  .hero-section { padding: 60px 20px 40px; text-align: center; }
  .hero-section h1 { 
    font-family: var(--font-heading); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; 
    background: linear-gradient(135deg, var(--deep-navy) 20%, var(--primary-blue) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    letter-spacing: -1.5px; margin-bottom: 15px;
  }

  /* SEARCH & FILTER BOX - HORIZONTAL FIX */
  .search-container { max-width: 1100px; margin: 0 auto 50px; padding: 0 20px; }
  
  .filter-panel {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 1);
    border-radius: 24px;
    padding: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.06);
    /* Penting: Memungkinkan scroll horizontal jika layar terlalu sempit */
    overflow-x: auto;
  }

  /* Force Flexbox agar tidak wrap ke bawah */
  .filter-wrapper {
    display: flex;
    flex-wrap: nowrap;
    gap: 12px;
    align-items: center;
    min-width: min-content;
  }

  .custom-input-group {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    padding: 0 15px;
    height: 52px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
  }

  .custom-input-group:focus-within {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(10, 88, 202, 0.1);
  }

  .filter-input {
    border: none !important;
    background: transparent !important;
    font-weight: 600;
    color: var(--text-main);
    font-size: 0.9rem;
    box-shadow: none !important;
    padding-left: 10px !important;
    flex-grow: 1; 
    width: 100%;
  }
  
  select.filter-input {
  cursor: pointer;
}

  /* Aturan lebar masing-masing elemen filter */
  .search-box { flex: 2; min-width: 250px; }
  .sort-box { flex: 1; min-width: 150px; }
  .category-box { flex: 1.2; min-width: 180px; }

  /* ARTIKEL CARD REFINED */
  .artikel-container { max-width: 1050px; margin: 0 auto 100px; padding: 0 20px; }

  .artikel-item {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 30px;
    padding: 20px;
    margin-bottom: 25px;
    transition: all 0.4s ease;
    display: flex; gap: 35px; align-items: center;
  }

  .artikel-item:hover { 
    transform: translateY(-8px); 
    background: #ffffff;
    box-shadow: 0 30px 60px rgba(15, 23, 42, 0.1);
    border-color: var(--primary-blue);
  }

  .artikel-img-wrapper {
    width: 340px; height: 220px; flex-shrink: 0; border-radius: 22px; 
    overflow: hidden; position: relative;
  }
  .artikel-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 1.2s ease; }
  .artikel-item:hover .artikel-img-wrapper img { transform: scale(1.1); }

  .badge-kat { 
    background: var(--primary-blue); color: white; 
    padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; 
    text-transform: uppercase; position: absolute; top: 15px; left: 15px; z-index: 5;
  }

  .artikel-content h5 { 
    font-family: var(--font-heading); font-size: 1.6rem; color: var(--deep-navy); 
    margin-bottom: 12px; font-weight: 800; line-height: 1.3;
  }

  .btn-read {
    display: inline-flex; align-items: center; gap: 10px; color: var(--pure-white); 
    font-weight: 700; text-decoration: none; transition: all 0.3s ease;
    font-size: 0.85rem; background: var(--deep-navy); padding: 12px 26px;
    border-radius: 14px; align-self: flex-start; margin-top: auto;
  }
  .btn-read:hover { background: var(--primary-blue); transform: translateX(5px); }

  /* RESPONSIVE FIX */
  @media (max-width: 991px) {
    .artikel-item { flex-direction: column; align-items: flex-start; gap: 20px; }
    .artikel-img-wrapper { width: 100%; height: 250px; }
    .filter-panel::-webkit-scrollbar { height: 4px; }
    .filter-panel::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
  }
</style>

<div class="bg-animated">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
</div>

<div class="container-fluid px-0">
  
  <section class="hero-section animate__animated animate__fadeIn">
    <h1>Program Berita RBTV</h1>
    <p>Portal informasi digital terdepan di Bengkulu, menyajikan berita terkini dengan akurasi tinggi.</p>
  </section>

  <div class="search-container animate__animated animate__fadeInUp">
    <div class="filter-panel">
      <div class="filter-wrapper">
        
        <div class="search-box">
          <div class="custom-input-group">
            <i class="bi bi-search text-primary"></i>
            <input type="text" id="searchInput" class="form-control filter-input" placeholder="Cari berita...">
          </div>
        </div>

        <div class="sort-box">
          <div class="custom-input-group">
            <i class="bi bi-filter-left text-primary"></i>
            <select id="sortSelect" class="form-select filter-input">
              <option value="terbaru">Terbaru</option>
              <option value="terlama">Terlama</option>
              <option value="az">A - Z</option>
            </select>
          </div>
        </div>

        <div class="category-box">
          <div class="custom-input-group">
            <i class="bi bi-tags text-primary"></i>
            <select id="kategoriSelect" class="form-select filter-input">
              <option value="">Semua Kategori</option>
              <option value="Malam">Berita Malam</option>
              <option value="Daerah">Berita Daerah</option>
              <option value="Pekaro">Pekaro</option>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="artikel-container">
    <div id="beritaList">
      @foreach($berita as $row)
      <div class="artikel-item animate__animated animate__fadeInUp" 
           data-judul="{{ strtolower($row->judul_berita) }}"
           data-kategori="{{ $row->kategori_berita }}"
           data-tanggal="{{ $row->tanggal_berita }}">
        
        <div class="artikel-img-wrapper">
          <span class="badge-kat">{{ $row->kategori_berita }}</span>
          <img src="{{ asset('images/'.$row->gambar_berita) }}" alt="Thumbnail">
        </div>

        <div class="artikel-content">
          <div class="date-info" style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700; margin-bottom: 8px;">
            <i class="bi bi-calendar3 text-primary me-2"></i>
            {{ \Carbon\Carbon::parse($row->tanggal_berita)->translatedFormat('d M Y') }}
          </div>
          
          <h5>{{ $row->judul_berita }}</h5>
          <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6;">
            {{ \Illuminate\Support\Str::limit($row->caption_berita, 150) }}
          </p>

          <a href="{{ url('detail/'.$row->id_berita) }}" class="btn-read">
            Selengkapnya <i class="bi bi-chevron-right"></i>
          </a>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const sortSelect = document.getElementById("sortSelect");
    const kategoriSelect = document.getElementById("kategoriSelect");
    const items = document.querySelectorAll(".artikel-item");

    function filterData() {
        const search = searchInput.value.toLowerCase();
        const kategori = kategoriSelect.value;

        items.forEach(item => {
            const judul = item.dataset.judul;
            const kat = item.dataset.kategori;

            let show = true;

            if (!judul.includes(search)) show = false;
            if (kategori && kat !== kategori) show = false;

            item.style.display = show ? "flex" : "none";
        });
    }

    function sortData() {
        const container = document.getElementById("beritaList");
        const itemsArray = Array.from(document.querySelectorAll(".artikel-item"));
        const sort = sortSelect.value;

        itemsArray.sort((a, b) => {
            const dateA = new Date(a.dataset.tanggal);
            const dateB = new Date(b.dataset.tanggal);

            const titleA = a.dataset.judul;
            const titleB = b.dataset.judul;

            if (sort === "terbaru") return dateB - dateA;
            if (sort === "terlama") return dateA - dateB;
            if (sort === "az") return titleA.localeCompare(titleB);
            if (sort === "za") return titleB.localeCompare(titleA);
        });

        itemsArray.forEach(el => container.appendChild(el));
    }

    // EVENT
    searchInput.addEventListener("input", filterData);
    kategoriSelect.addEventListener("change", filterData);
    sortSelect.addEventListener("change", sortData);

    // ENTER SEARCH
    searchInput.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            filterData();
        }
    });
});
</script>
@endsection