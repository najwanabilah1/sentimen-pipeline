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

<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-7xl mx-auto space-y-6 md:space-y-8">
    
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-[2rem] p-8 md:p-10 overflow-hidden shadow-2xl animate-fade-in">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-red-500/20 blur-[60px] animate-pulse"></div>
        <div class="absolute bottom-0 left-10 -mb-16 w-48 h-48 rounded-full bg-indigo-500/20 blur-[50px] animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="absolute top-1/2 right-1/4 -translate-y-1/2 text-white/5 text-9xl pointer-events-none">
            <i class="fa-solid fa-brain"></i>
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-white backdrop-blur-sm text-xs font-bold uppercase tracking-widest mb-2">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    Live Monitoring Active
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">Analisis Sentimen <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-amber-400">AI</span></h1>
                <p class="text-slate-400 md:text-lg max-w-xl leading-relaxed">
                    Pantau persepsi publik secara real-time melalui engine RBTV-AI. Data diproses secara instan untuk wawasan yang lebih akurat.
                </p>
            </div>
            
            <form action="{{ route('admin.sentiment.process') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="group relative w-full lg:w-auto bg-white hover:bg-slate-50 text-slate-900 px-8 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-[0_0_40px_rgba(255,255,255,0.2)] hover:shadow-[0_0_60px_rgba(255,255,255,0.3)] transition-all duration-300 hover:-translate-y-1 active:scale-95">
                    <i class="fa-solid fa-wand-magic-sparkles text-red-500 group-hover:rotate-12 group-hover:scale-110 transition-all duration-300 text-lg"></i>
                    <span class="font-extrabold text-sm tracking-wide">Jalankan Engine AI</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
        
        <div class="lg:col-span-5 animate-fade-in delay-100">
            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-800">Distribusi Parameter</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Visualisasi Kinerja Berita</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-xl floating">
                        <i class="fa-solid fa-radar text-red-500"></i>
                    </div>
                </div>
                
                <div class="relative flex-grow min-h-[300px] w-full flex items-center justify-center">
                    <canvas id="sentimentRadarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 animate-fade-in delay-200">
            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 h-full">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-filter"></i>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-800">Pencarian Cerdas</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-1">Saring Data Spesifik</p>
                    </div>
                </div>

                <form action="{{ route('admin.sentiment.index') }}" method="GET" class="space-y-6">
                    <div class="relative group">
                        <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Kata Kunci</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-red-500 transition-colors"></i>
                            <input type="text" name="search" placeholder="Cari ulasan, nama user, atau judul berita..." value="{{ request('search') }}"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm text-slate-700 placeholder:text-slate-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-2 block">Kategori Berita</label>
                            <div class="relative">
                                <select name="category" class="w-full pl-5 pr-12 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Semua Kategori</option>
                                    <option value="Malam" {{ request('category') == 'Malam' ? 'selected' : '' }}>Malam</option>
                                    <option value="Pekaro" {{ request('category') == 'Pekaro' ? 'selected' : '' }}>Pekaro</option>
                                    <option value="Daerah" {{ request('category') == 'Daerah' ? 'selected' : '' }}>Daerah</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-2 block">Hasil Sentimen</label>
                            <div class="relative">
                                <select name="sentiment" class="w-full pl-5 pr-12 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Semua Sentimen</option>
                                    <option value="Positif" {{ request('sentiment') == 'Positif' ? 'selected' : '' }}>Positif</option>
                                    <option value="Negatif" {{ request('sentiment') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                                    <option value="Netral" {{ request('sentiment') == 'Netral' ? 'selected' : '' }}>Netral</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                        <a href="{{ route('admin.sentiment.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl font-bold text-slate-500 bg-slate-50 hover:bg-slate-100 transition-colors text-center text-sm">Reset Filter</a>
                        <button type="submit" class="w-full sm:flex-1 bg-red-600 hover:bg-red-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95 text-sm flex justify-center items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terapkan Pencarian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden animate-fade-in delay-300">
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Log Analisis Terbaru</h3>
                <p class="text-xs font-medium text-slate-400 mt-1">Daftar ulasan yang telah diproses AI</p>
            </div>
            <span class="inline-flex w-fit px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-xs font-extrabold uppercase tracking-wide border border-slate-100">
                <i class="fa-solid fa-database mr-2 text-slate-400"></i> Total: {{ $reviews->count() }} Data
            </span>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left whitespace-nowrap md:whitespace-normal">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 md:px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Detail Berita</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">User & Rating</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] w-1/3">Konteks Ulasan</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] text-center">AI Result</th>
                        <th class="px-6 md:px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 md:px-8 py-6">
                            <div class="flex flex-col gap-1.5 max-w-[200px] md:max-w-xs">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-red-600 transition-colors truncate" title="{{ $review->judul_berita }}">
                                    {{ $review->judul_berita }}
                                </span>
                                <span class="inline-flex w-fit px-2.5 py-1 bg-slate-100 text-slate-500 rounded-md text-[9px] font-extrabold uppercase tracking-wider">
                                    {{ $review->kategori_berita }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-600 flex items-center justify-center font-extrabold text-sm shadow-inner">
                                    {{ strtoupper(substr($review->nama_user, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $review->nama_user }}</p>
                                    <div class="flex text-amber-400 text-[10px] mt-1 gap-0.5">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-{{ $i <= ($review->rating ?? 0) ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-sm font-medium text-slate-500 leading-relaxed italic line-clamp-2 min-w-[250px]">
                                "{{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}"
                            </p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center">
                                @if($review->sentimen == 'Positif')
                                    <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-emerald-100 shadow-sm">
                                        <i class="fa-solid fa-face-smile text-sm"></i> POSITIF
                                    </span>
                                @elseif($review->sentimen == 'Negatif')
                                    <span class="px-3.5 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-rose-100 shadow-sm">
                                        <i class="fa-solid fa-face-frown text-sm"></i> NEGATIF
                                    </span>
                                @elseif($review->sentimen == 'Netral')
                                    <span class="px-3.5 py-1.5 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-slate-200 shadow-sm">
                                        <i class="fa-solid fa-face-meh text-sm"></i> NETRAL
                                    </span>
                                @else
                                    <span class="px-3.5 py-1.5 bg-amber-50 text-amber-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 animate-pulse border border-amber-100 shadow-sm">
                                        <i class="fa-solid fa-spinner fa-spin text-sm"></i> PROSES
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 md:px-8 py-6 text-right">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">
                                {{ $review->waktu_analisis ? \Carbon\Carbon::parse($review->waktu_analisis)->diffForHumans() : '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-24 text-center">
                            <div class="flex flex-col items-center justify-center animate-fade-in">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-5 border-2 border-dashed border-slate-200">
                                    <i class="fa-solid fa-folder-open text-3xl"></i>
                                </div>
                                <h4 class="font-extrabold text-slate-800 text-lg">Tidak Ada Data Ditemukan</h4>
                                <p class="text-sm text-slate-400 mt-2 max-w-xs mx-auto">Coba sesuaikan kata kunci pencarian atau jalankan engine AI untuk memproses data baru.</p>
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