@extends('layouts.app')

@section('content')

<style>
    /* CUSTOM CSS INTEGRATION */
    .ulasan-page {
        padding: 40px 15px;
    }

    /* HERO */
    .ulasan-hero {
        background: linear-gradient(90deg, #2563eb, #1e3a8a);
        color: white;
        padding: 50px 20px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }

    /* FORM WRAPPER */
    .form-wrapper {
        background: white;
        padding: 40px;
        border-radius: 16px;
        max-width: 1000px;
        margin: auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* INPUT CUSTOMIZATION */
    label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 5px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #dee2e6;
    }

    /* CUSTOM SELECT ARROW */
    .custom-select-wrapper select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='%23666' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5'/></svg>");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    /* RATING STARS */
    .rating-stars {
        font-size: 28px;
        cursor: pointer;
        color: #d1d5db;
        transition: 0.2s;
    }

    .star.active {
        color: #fbbf24;
    }

    /* ANONIM CHECKBOX */
    .anonim-box {
        background: #f9fafb;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* HORIZONTAL SCROLL FOR CARDS */
    .ulasan-container {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding: 20px 5px 40px;
        scrollbar-width: thin;
    }

    .ulasan-container::-webkit-scrollbar {
        height: 6px;
    }

    .ulasan-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .ulasan-card {
        min-width: 300px;
        max-width: 300px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        border: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .ulasan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .kategori-badge {
        font-size: 11px;
        background: #e0e7ff;
        padding: 4px 10px;
        border-radius: 20px;
        color: #3730a3;
        font-weight: 600;
    }

    .berita-info img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 8px;
    }

    .ulasan-text {
        font-size: 14px;
        color: #4b5563;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.6;
    }

    .btn-submit {
        background: #2563eb;
        border: none;
        padding: 12px 40px;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #1d4ed8;
        transform: scale(1.02);
    }
</style>

<div class="container ulasan-page">

    <div class="ulasan-hero shadow-sm">
        <h1 class="fw-bold">Beri Ulasan</h1>
        <p class="lead opacity-75">Bagikan pendapat Anda tentang program berita RBTV</p>
    </div>

    @if(session('notif'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('notif') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="form-wrapper">
        <form action="{{ route('ulasan.store') }}" method="POST" id="ulasanForm">
            @csrf
            <h3 class="mb-4 fw-bold text-center">Formulir Ulasan</h3>

            <div class="row g-4">
                <div class="col-md-6 border-end">
                    <div class="mb-3 custom-select-wrapper">
                        <label class="form-label">Pilih Kategori</label>
                        <select name="kategori_berita" id="kategoriSelect" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Malam">Malam</option>
                            <option value="Daerah">Daerah</option>
                            <option value="Pekaro">Pekaro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cari Berita</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchBerita" class="form-control bg-light border-start-0" placeholder="Ketik judul berita...">
                        </div>
                    </div>

                    <div class="mb-3 custom-select-wrapper">
                        <label class="form-label">Pilih Berita <span class="text-danger">*</span></label>
                        <select name="judul_berita" id="judulSelect" class="form-select" required>
                            <option value="">-- Pilih Berita --</option>
                            @foreach($berita as $row)
                                <option value="{{ $row->judul_berita }}" data-kategori="{{ $row->kategori_berita }}">
                                    {{ $row->judul_berita }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Rating</label>
                        <div class="rating-stars" id="starContainer">
                            @for($i=1;$i<=5;$i++)
                                <span class="star" data-value="{{ $i }}">★</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Ulasan Anda <span class="text-danger">*</span></label>
                        <textarea name="isi_ulasan_raw" class="form-control" rows="4" placeholder="Tulis masukan Anda di sini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pengirim</label>
                        <input type="text" name="nama_user" id="namaInput" class="form-control" placeholder="Nama lengkap">
                    </div>

                    <div class="anonim-box mt-4">
                        <input type="checkbox" id="anonimCheck" class="form-check-input">
                        <label class="form-check-label mb-0" for="anonimCheck">Kirim sebagai <strong>Anonim</strong></label>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary btn-submit btn-lg px-5">Kirim Ulasan Sekarang</button>
            </div>
        </form>
    </div>

    <div class="ulasan-list-section mt-5 pt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Ulasan Sebelumnya</h3>
            <span class="text-muted small">Geser horizontal <i class="bi bi-arrow-right"></i></span>
        </div>

        <div class="ulasan-container">
            @forelse($ulasan as $row)
            <div class="ulasan-card shadow-sm">
                <div class="top-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="kategori-badge text-uppercase">{{ $row->kategori_berita }}</span>
                        <a href="{{ url('detail?judul='.urlencode($row->judul_berita).'&kategori='.$row->kategori_berita) }}" 
                           class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 10px;">
                            DETAIL
                        </a>
                    </div>

                    <div class="berita-info d-flex gap-3 align-items-center mb-3">
                        <img src="{{ asset('images/'.($row->gambar_berita ?? 'default.jpg')) }}" alt="Thumbnail">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark lh-sm" style="font-size: 12px;">{{ $row->judul_berita }}</div>
                        </div>
                    </div>

                    <div class="mb-2 text-warning">
                        @for($i=1; $i<=5; $i++)
                            {!! $i <= $row->rating ? '★' : '<span class="text-muted">☆</span>' !!}
                        @endfor
                    </div>

                    <p class="ulasan-text">
                        "{{ $row->isi_ulasan_raw }}"
                    </p>
                </div>

                <div class="user-info pt-3 border-top mt-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:30px; height:30px;">
                            <i class="bi bi-person text-secondary"></i>
                        </div>
                        <span class="fw-semibold text-secondary" style="font-size: 13px;">{{ $row->nama_user }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="w-100 text-center py-5">
                <p class="text-muted">Belum ada ulasan untuk ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Star Rating Logic ---
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                
                stars.forEach(s => {
                    s.classList.toggle('active', s.getAttribute('data-value') <= value);
                    s.innerHTML = s.getAttribute('data-value') <= value ? '★' : '☆';
                });
            });
        });

        // --- 2. Anonymous Logic ---
        const anonimCheck = document.getElementById('anonimCheck');
        const namaInput = document.getElementById('namaInput');
        let originalName = "";

        anonimCheck.addEventListener('change', function() {
            if(this.checked) {
                originalName = namaInput.value;
                namaInput.value = "Anonim";
                namaInput.readOnly = true;
            } else {
                namaInput.value = originalName;
                namaInput.readOnly = false;
            }
        });

        // --- 3. Filter Berita Logic ---
        const kategoriSelect = document.getElementById('kategoriSelect');
        const searchBerita = document.getElementById('searchBerita');
        const judulSelect = document.getElementById('judulSelect');
        const options = Array.from(judulSelect.options);

        function filterBerita() {
            const kategori = kategoriSelect.value.toLowerCase();
            const search = searchBerita.value.toLowerCase();

            judulSelect.innerHTML = '<option value="">-- Pilih Berita --</option>';

            options.forEach(opt => {
                if(opt.value === "") return;
                
                const optKategori = opt.getAttribute('data-kategori').toLowerCase();
                const optText = opt.text.toLowerCase();

                const matchKategori = !kategori || optKategori === kategori;
                const matchSearch = !search || optText.includes(search);

                if(matchKategori && matchSearch) {
                    judulSelect.appendChild(opt);
                }
            });
        }

        kategoriSelect.addEventListener('change', filterBerita);
        searchBerita.addEventListener('input', filterBerita);
    });
</script>

@endsection