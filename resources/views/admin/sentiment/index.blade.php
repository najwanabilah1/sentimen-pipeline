@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* --- ANIMASI & TRANSISI --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .animate-fade-in { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .floating { animation: float 4s ease-in-out infinite; }
    
    /* Delay Utilities */
    .delay-100 { animation-delay: 100ms; opacity: 0; }
    .delay-200 { animation-delay: 200ms; opacity: 0; }
    .delay-300 { animation-delay: 300ms; opacity: 0; }

    /* Custom Scrollbar yang Lebih Elegan */
    .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<div class="px-2 sm:px-4 lg:px-6 pt-2 pb-8 max-w-7xl mx-auto space-y-8">
    
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 lg:p-10 overflow-hidden shadow-xl animate-fade-in">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-red-500/20 blur-[40px] animate-pulse"></div>
        <div class="absolute bottom-0 left-5 -mb-10 w-32 h-32 rounded-full bg-indigo-500/20 blur-[40px] animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="absolute top-1/2 right-1/4 -translate-y-1/2 text-white/5 text-7xl pointer-events-none">
            <i class="fa-solid fa-brain"></i>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-white/10 border border-white/10 text-white backdrop-blur-sm text-[10px] font-bold uppercase tracking-widest mb-1 shadow-sm">
                    <span class="flex h-1.5 w-1.5 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span>
                    </span>
                    Live Monitoring Active
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Analisis Sentimen <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-amber-400">AI</span></h1>
                <p class="text-slate-400 text-sm md:text-base max-w-lg leading-relaxed">
                    Pantau persepsi publik secara instan melalui engine RBTV-AI.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                <a href="{{ route('admin.sentiment.pdf') }}" target="_blank" class="group relative w-full lg:w-auto bg-slate-800 hover:bg-slate-700 border border-slate-600 text-white px-6 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-lg transition-all duration-300 hover:-translate-y-1 active:scale-95">
                    <i class="fa-solid fa-file-pdf text-red-400 group-hover:-translate-y-0.5 transition-transform duration-300"></i>
                    <span class="font-extrabold text-xs tracking-wide">Laporan Evaluasi</span>
                </a>
                
                <form action="{{ route('admin.sentiment.process') }}" method="POST" class="w-full lg:w-auto shrink-0">
                    @csrf
                    <button type="submit" class="group relative w-full lg:w-auto bg-white hover:bg-slate-50 text-slate-900 px-7 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-[0_0_20px_rgba(255,255,255,0.15)] hover:shadow-[0_0_30px_rgba(255,255,255,0.25)] transition-all duration-300 hover:-translate-y-1 active:scale-95">
                        <i class="fa-solid fa-wand-magic-sparkles text-red-500 group-hover:rotate-12 transition-transform duration-300"></i>
                        <span class="font-extrabold text-xs tracking-wide">Jalankan Engine AI</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Memanjang -->
    <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm animate-fade-in delay-100">
        <form action="{{ route('admin.sentiment.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-3 md:gap-4">
            <div class="flex-1 space-y-1.5 flex flex-col justify-end">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 block">Kata Kunci</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" placeholder="Cari ulasan, judul berita..." value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 rounded-xl transition-all outline-none font-semibold text-xs text-slate-700 placeholder:text-slate-400">
                </div>
            </div>

            <div class="w-full md:w-56 space-y-1.5">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 block">Kategori</label>
                <div class="relative">
                    <select name="category" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 rounded-xl transition-all outline-none font-semibold text-xs text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <option value="Malam" {{ request('category') == 'Malam' ? 'selected' : '' }}>Malam</option>
                        <option value="Pekaro" {{ request('category') == 'Pekaro' ? 'selected' : '' }}>Pekaro</option>
                        <option value="Daerah" {{ request('category') == 'Daerah' ? 'selected' : '' }}>Daerah</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                </div>
            </div>

            <div class="w-full md:w-56 space-y-1.5">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 block">Sentimen</label>
                <div class="relative">
                    <select name="sentiment" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/10 rounded-xl transition-all outline-none font-semibold text-xs text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Sentimen</option>
                        <option value="Positif" {{ request('sentiment') == 'Positif' ? 'selected' : '' }}>Positif</option>
                        <option value="Negatif" {{ request('sentiment') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                        <option value="Netral" {{ request('sentiment') == 'Netral' ? 'selected' : '' }}>Netral</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2 md:pt-0 shrink-0">
                <a href="{{ route('admin.sentiment.index') }}" class="px-4 py-2.5 rounded-xl font-bold text-slate-500 bg-slate-50 hover:bg-slate-100 border border-slate-100 transition-colors text-[11px] flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left mr-1.5"></i> Reset
                </a>
                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-md shadow-red-500/20 transition-all active:scale-95 text-[11px] flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Data
                </button>
            </div>
        </form>
    </div>

    <!-- MAIN CONTENT GRID -->
    <div class="flex flex-col gap-8 w-full">
        
        <!-- CHART SECTION -->
        <div class="animate-fade-in delay-200">
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Distribusi Parameter</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Visualisasi Kinerja Kategori</p>
                    </div>
                    <div class="w-8 h-8 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-sm floating">
                        <i class="fa-solid fa-radar text-red-500"></i>
                    </div>
                </div>
                
                <div class="relative w-full max-w-[400px] mx-auto min-h-[280px] flex items-center justify-center">
                    <canvas id="sentimentRadarChart"></canvas>
                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="animate-fade-in delay-300">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-5 border-b border-slate-50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 bg-slate-50/30">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">Log Analisis Terbaru</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5 uppercase tracking-widest">Daftar ulasan diproses AI</p>
                    </div>
                    <span class="inline-flex items-center w-fit px-3 py-1.5 bg-white text-slate-600 rounded-[10px] text-[10px] font-extrabold uppercase tracking-wide border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-database mr-1.5 text-slate-400"></i> Total: {{ $reviews->count() }} Data
                    </span>
                </div>

                <div class="overflow-x-auto custom-scroll flex-1">
                    <table class="w-full text-left whitespace-nowrap min-w-[600px]">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest pl-6">Detail Berita</th>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Konteks Ulasan</th>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">AI Result</th>
                                <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right pr-6">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @forelse($reviews as $review)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1 max-w-[250px]">
                                        <span class="font-bold text-slate-800 text-sm group-hover:text-red-600 transition-colors truncate" title="{{ $review->judul_berita }}">
                                            {{ $review->judul_berita }}
                                        </span>
                                        <span class="inline-flex w-fit px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-black uppercase tracking-widest border border-slate-200">
                                            {{ $review->kategori_berita }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 w-1/3">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-600 flex items-center justify-center font-extrabold text-base shadow-inner">
                                            {{ strtoupper(substr($review->nama_user, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-600 leading-relaxed italic line-clamp-2 max-w-[300px] sm:max-w-md text-[13px] whitespace-normal">
                                                "{{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}"
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex justify-center flex-col items-center gap-1.5">
                                        @if($review->sentimen == 'Positif')
                                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded w-fit text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 border border-emerald-100 shadow-sm">
                                                <i class="fa-solid fa-face-smile text-xs"></i> POSITIF
                                            </span>
                                        @elseif($review->sentimen == 'Negatif')
                                            <span class="px-2.5 py-1 bg-rose-50 text-rose-600 rounded w-fit text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 border border-rose-100 shadow-sm">
                                                <i class="fa-solid fa-face-frown text-xs"></i> NEGATIF
                                            </span>
                                        @elseif($review->sentimen == 'Netral')
                                            <span class="px-2.5 py-1 bg-slate-50 text-slate-600 rounded w-fit text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 border border-slate-200 shadow-sm">
                                                <i class="fa-solid fa-face-meh text-xs"></i> NETRAL
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded w-fit text-[10px] font-black uppercase tracking-wider flex items-center gap-1.5 animate-pulse border border-amber-100 shadow-sm">
                                                <i class="fa-solid fa-spinner fa-spin text-xs"></i> WAIT
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <span class="text-xs font-bold text-slate-400 tracking-wider bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        {{ $review->waktu_analisis ? \Carbon\Carbon::parse($review->waktu_analisis)->shortAbsoluteDiffForHumans() : '-' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-300">
                                        <i class="fa-solid fa-folder-open text-2xl mb-3"></i>
                                        <p class="text-xs font-bold text-slate-400">Tidak ada data ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sentimentRadarChart').getContext('2d');
        
        // Gradient area
        const chartGradient = ctx.createLinearGradient(0, 0, 0, 400);
        chartGradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)'); // Tailwind red-500
        chartGradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Positif', 'Negatif', 'Netral', 'Rating Tinggi', 'Rating Rendah'],
                datasets: [{
                    label: 'Distribusi',
                    data: [
                        {{ $reviews->where('sentimen', 'Positif')->count() }},
                        {{ $reviews->where('sentimen', 'Negatif')->count() }},
                        {{ $reviews->where('sentimen', 'Netral')->count() }},
                        {{ $reviews->where('rating', '>=', 4)->count() }},
                        {{ $reviews->where('rating', '<=', 2)->count() }}
                    ],
                    fill: true,
                    backgroundColor: chartGradient,
                    borderColor: '#ef4444', // red-500
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#ef4444',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    r: {
                        grid: { color: 'rgba(241, 245, 249, 1)' }, // slate-100
                        angleLines: { color: 'rgba(241, 245, 249, 1)' },
                        suggestedMin: 0,
                        pointLabels: {
                            font: { family: "inherit", size: 11, weight: '700' },
                            color: '#64748b', // slate-500
                            padding: 15
                        },
                        ticks: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a', // slate-900
                        padding: 12,
                        cornerRadius: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: false
                    }
                }
            }
        });
    });
</script>
@endsection