@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* ----- COLOR PALETTE & TYPOGRAPHY ----- */
    :root {
        --bg-body: #F4F7FE;
        --dark-text: #1B254B;
        --gray-text: #A3AED0;
        --border-color: #E0E5F2;
        --primary-red: #E63946;
        --white: #FFFFFF;
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: var(--bg-body); 
        color: var(--dark-text);
    }

    /* ----- PREMIUM CARD STYLING ----- */
    .card-modern { 
        background: var(--white); 
        border: none;
        border-radius: 20px; 
        box-shadow: 0px 18px 40px rgba(112, 144, 176, 0.12);
        padding: 24px;
        height: 100%;
        transition: all 0.3s ease;
    }

    /* ----- BUTTONS ----- */
    .btn-ai-magic { 
        background: linear-gradient(135deg, #111C44 0%, #0B1437 100%);
        color: white; 
        border: none; 
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-ai-magic:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px rgba(17, 28, 68, 0.2);
        color: white;
    }

    /* ----- INPUT & FILTER FORM ----- */
    .form-control-modern, .form-select-modern {
        background-color: #F4F7FE;
        border: 1px solid transparent;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        color: var(--dark-text);
        transition: all 0.2s ease;
    }
    .form-control-modern:focus, .form-select-modern:focus {
        background-color: var(--white);
        border-color: var(--primary-red);
        box-shadow: 0 0 0 4px rgba(230, 57, 70, 0.1);
        outline: none;
    }
    .search-icon-wrapper {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-text);
        z-index: 4;
    }
    .search-input-modern {
        padding-left: 44px !important;
    }

    /* ----- TABLE STYLING ----- */
    .table-modern { border-collapse: separate; border-spacing: 0; width: 100%; }
    .table-modern thead th {
        background-color: transparent;
        color: var(--gray-text);
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px;
        border-bottom: 2px solid var(--border-color);
    }
    .table-modern tbody td {
        padding: 20px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        color: var(--dark-text);
    }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody tr:hover { background-color: #F8FAFC; }

    /* ----- BADGES ----- */
    .badge-sentiment {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.3px;
    }
    .badge-pos { background: #E2FFED; color: #05CD99; }
    .badge-neg { background: #FFEDEC; color: #EE5D50; }
    .badge-neu { background: #F4F7FE; color: #8F9BBA; }
    .badge-pending { background: #FFF4E5; color: #FF9800; }

    /* ----- MOBILE RESPONSIVE ----- */
    @media (max-width: 991px) {
        .mobile-stack { flex-direction: column; align-items: stretch !important; gap: 15px; }
        .btn-ai-magic { justify-content: center; width: 100%; }
        
        .responsive-table thead { display: none; }
        .responsive-table tr { 
            display: block; margin-bottom: 16px; border: 1px solid var(--border-color); 
            border-radius: 16px; padding: 16px; background: white; 
        }
        .responsive-table td { 
            display: flex; justify-content: space-between; align-items: center; 
            border: none; padding: 8px 0; font-size: 0.9rem; text-align: right;
        }
        .responsive-table td::before { 
            content: attr(data-label); font-weight: 700; color: var(--gray-text); font-size: 0.8rem; text-align: left;
        }
        .responsive-table td > div, .responsive-table td > span, .responsive-table td > p {
            text-align: right; justify-content: flex-end;
        }
    }

    /* Fix Chart Container so it doesn't stretch weirdly */
    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container-fluid py-4 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-5 mobile-stack">
        <div>
            <h1 class="h2 fw-800 mb-1" style="color: var(--dark-text); letter-spacing: -0.5px;">Analisis Sentimen AI</h1>
            <p class="mb-0 fw-500" style="color: var(--gray-text);">Monitor persepsi publik terhadap berita secara real-time.</p>
        </div>
        <form action="{{ route('admin.sentiment.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn-ai-magic">
                <i class="bi bi-magic"></i> Jalankan Engine AI
            </button>
        </form>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-5 col-lg-6">
            <div class="card-modern">
                <h5 class="fw-800 mb-1">Distribusi Sentimen</h5>
                <p class="small mb-4" style="color: var(--gray-text);">Visualisasi persentase ulasan user</p>
                
                <div class="chart-container">
                    <canvas id="sentimentRadarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card-modern">
                <h5 class="fw-800 mb-1">Pencarian Cerdas</h5>
                <p class="small mb-4" style="color: var(--gray-text);">Filter data ulasan yang ingin Anda analisis</p>
                
                <form action="{{ route('admin.sentiment.index') }}" method="GET" class="row g-3">
                    <div class="col-12 position-relative">
                        <label class="small fw-700 mb-2" style="color: var(--dark-text);">Kata Kunci</label>
                        <i class="bi bi-search search-icon-wrapper"></i>
                        <input type="text" name="search" class="form-control form-control-modern search-input-modern" placeholder="Cari ulasan, nama user, atau judul berita..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="small fw-700 mb-2" style="color: var(--dark-text);">Kategori Berita</label>
                        <select name="category" class="form-select form-select-modern">
                            <option value="">Semua Kategori</option>
                            <option value="Politik" {{ request('category') == 'Politik' ? 'selected' : '' }}>Politik</option>
                            <option value="Ekonomi" {{ request('category') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="Sosial" {{ request('category') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="small fw-700 mb-2" style="color: var(--dark-text);">Hasil Sentimen</label>
                        <select name="sentiment" class="form-select form-select-modern">
                            <option value="">Semua Sentimen</option>
                            <option value="Positif" {{ request('sentiment') == 'Positif' ? 'selected' : '' }}>Positif</option>
                            <option value="Negatif" {{ request('sentiment') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                            <option value="Netral" {{ request('sentiment') == 'Netral' ? 'selected' : '' }}>Netral</option>
                        </select>
                    </div>
                    
                    <div class="col-12 mt-4 d-flex gap-3 justify-content-end mobile-stack">
                        <a href="{{ route('admin.sentiment.index') }}" class="btn btn-light fw-700 px-4 py-2" style="border-radius: 12px; color: var(--gray-text);">Reset</a>
                        <button type="submit" class="btn fw-700 px-4 py-2" style="background-color: var(--primary-red); color: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(230, 57, 70, 0.2);">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-modern p-0 overflow-hidden">
        <div class="p-4 border-bottom border-light">
            <h5 class="fw-800 mb-0">Log Analisis Terbaru</h5>
        </div>
        <div class="table-responsive">
            <table class="table-modern responsive-table">
                <thead>
                    <tr>
                        <th class="ps-4">Detail Berita</th>
                        <th>User</th>
                        <th class="text-center">Rating</th>
                        <th style="width: 35%;">Konteks Ulasan</th>
                        <th class="text-center">AI Result</th>
                        <th class="pe-4 text-end">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td class="ps-4" data-label="Berita">
                            <div class="fw-800 mb-1" style="color: var(--dark-text);">{{ Str::limit($review->judul_berita, 40) }}</div>
                            <span class="badge" style="background: var(--bg-body); color: var(--gray-text); font-weight: 600;">{{ $review->kategori_berita }}</span>
                        </td>
                        <td data-label="User">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-800" style="width: 36px; height: 36px; background: #F4F7FE; color: var(--primary-red);">
                                    {{ strtoupper(substr($review->nama_user, 0, 1)) }}
                                </div>
                                <span class="fw-700">{{ $review->nama_user }}</span>
                            </div>
                        </td>
                        <td class="text-center" data-label="Rating">
                            <span class="fw-800" style="color: #FFB547; font-size: 1.1rem;">
                                ★ {{ $review->rating ?? '-' }}
                            </span>
                        </td>
                        <td data-label="Ulasan">
                            <p class="mb-0 fw-500" style="color: var(--gray-text); font-size: 0.9rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                "{{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}"
                            </p>
                        </td>
                        <td class="text-center" data-label="Sentimen">
                            @if($review->sentimen == 'Positif')
                                <span class="badge-sentiment badge-pos"><i class="bi bi-check-circle-fill"></i> POSITIF</span>
                            @elseif($review->sentimen == 'Negatif')
                                <span class="badge-sentiment badge-neg"><i class="bi bi-exclamation-triangle-fill"></i> NEGATIF</span>
                            @elseif($review->sentimen == 'Netral')
                                <span class="badge-sentiment badge-neu"><i class="bi bi-dash-circle-fill"></i> NETRAL</span>
                            @else
                                <span class="badge-sentiment badge-pending"><i class="bi bi-hourglass-split"></i> MENUNGGU AI</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end fw-600 small" style="color: var(--gray-text);" data-label="Waktu">
                            {{ $review->waktu_analisis ? $review->waktu_analisis->diffForHumans() : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-folder2-open mb-3" style="font-size: 3rem; color: var(--border-color);"></i>
                                <h6 class="fw-700" style="color: var(--gray-text);">Belum ada data ulasan yang ditemukan.</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Kunci agar Radar Chart tidak membesar sendirian / gepeng
    const ctx = document.getElementById('sentimentRadarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Positif', 'Negatif', 'Netral', 'Bintang 4-5', 'Bintang 1-2'],
            datasets: [{
                label: 'Data Analisis',
                data: [
                    {{ $reviews->where('sentimen', 'Positif')->count() }},
                    {{ $reviews->where('sentimen', 'Negatif')->count() }},
                    {{ $reviews->where('sentimen', 'Netral')->count() }},
                    {{ $reviews->where('rating', '>=', 4)->count() }},
                    {{ $reviews->where('rating', '<=', 2)->count() }}
                ],
                fill: true,
                backgroundColor: 'rgba(230, 57, 70, 0.1)',
                borderColor: '#E63946',
                borderWidth: 2,
                pointBackgroundColor: '#111C44',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            maintainAspectRatio: false, /* INI SANGAT PENTING AGAR TIDAK GEPENG */
            responsive: true,
            scales: {
                r: {
                    grid: { color: '#E0E5F2' },
                    angleLines: { color: '#E0E5F2' },
                    pointLabels: {
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 11, weight: '600' },
                        color: '#A3AED0'
                    },
                    ticks: { display: false, min: 0 }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111C44',
                    titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                    bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                    padding: 12,
                    cornerRadius: 8
                }
            }
        }
    });
</script>
@endsection