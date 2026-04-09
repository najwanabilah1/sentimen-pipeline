@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeInUp 0.5s ease-out forwards; }
    
    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    /* Shadow Glass Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Analisis Sentimen AI</h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <span class="flex h-2 w-2 relative">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                Monitoring persepsi publik secara real-time melalui engine RBTV-AI
            </p>
        </div>
        
        <form action="{{ route('admin.sentiment.process') }}" method="POST">
            @csrf
            <button type="submit" class="group relative bg-slate-900 hover:bg-slate-800 text-white px-8 py-3.5 rounded-2xl flex items-center gap-3 shadow-2xl shadow-slate-200 transition-all hover:-translate-y-1 active:scale-95">
                <i class="fa-solid fa-wand-sparkles text-amber-400 group-hover:rotate-12 transition-transform"></i>
                <span class="font-bold">Jalankan Engine AI</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-5 animate-fade-in" style="animation-delay: 100ms">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm h-full">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Distribusi Sentimen</h3>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Visualisasi Parameter</p>
                    </div>
                    <div class="bg-slate-50 p-2 rounded-xl text-slate-400">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
                
                <div class="relative h-[300px] w-full flex items-center justify-center">
                    <canvas id="sentimentRadarChart"></canvas>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 animate-fade-in" style="animation-delay: 200ms">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm h-full">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Pencarian Cerdas</h3>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Filter Data Ulasan</p>
                    </div>
                </div>

                <form action="{{ route('admin.sentiment.index') }}" method="GET" class="space-y-5">
                    <div class="relative group">
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 mb-1 block">Kata Kunci</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-red-500 transition-colors"></i>
                            <input type="text" name="search" placeholder="Cari ulasan, user, atau judul..." value="{{ request('search') }}"
                                class="w-full pl-12 pr-6 py-4 bg-slate-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 block">Kategori Berita</label>
                            <select name="category" class="w-full px-5 py-4 bg-slate-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm appearance-none">
                                <option value="">Semua Kategori</option>
                                <option value="Politik" {{ request('category') == 'Politik' ? 'selected' : '' }}>Politik</option>
                                <option value="Ekonomi" {{ request('category') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="Sosial" {{ request('category') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest ml-1 block">Hasil Sentimen</label>
                            <select name="sentiment" class="w-full px-5 py-4 bg-slate-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none font-semibold text-sm appearance-none">
                                <option value="">Semua Sentimen</option>
                                <option value="Positif" {{ request('sentiment') == 'Positif' ? 'selected' : '' }}>Positif</option>
                                <option value="Negatif" {{ request('sentiment') == 'Negatif' ? 'selected' : '' }}>Negatif</option>
                                <option value="Netral" {{ request('sentiment') == 'Netral' ? 'selected' : '' }}>Netral</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <a href="{{ route('admin.sentiment.index') }}" class="flex-1 text-center py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-colors">Reset</a>
                        <button type="submit" class="flex-[2] bg-red-600 hover:bg-red-700 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-100 transition-all active:scale-95">Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden animate-fade-in" style="animation-delay: 300ms">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xl font-extrabold text-slate-900">Log Analisis Terbaru</h3>
            <span class="px-4 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase">Total: {{ $reviews->count() }} Data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Detail Berita</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">User & Rating</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Konteks Ulasan</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] text-center">AI Result</th>
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-slate-800 group-hover:text-red-600 transition-colors">{{ Str::limit($review->judul_berita, 35) }}</span>
                                <span class="inline-flex w-fit px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold uppercase">{{ $review->kategori_berita }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($review->nama_user, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">{{ $review->nama_user }}</p>
                                    <div class="flex text-amber-400 text-[10px] mt-0.5">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa-{{ $i <= ($review->rating ?? 0) ? 'solid' : 'regular' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 max-w-xs">
                            <p class="text-xs font-medium text-slate-500 leading-relaxed italic line-clamp-2">
                                "{{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}"
                            </p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center">
                                @if($review->sentimen == 'Positif')
                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-emerald-100">
                                        <i class="fa-solid fa-face-smile"></i> POSITIF
                                    </span>
                                @elseif($review->sentimen == 'Negatif')
                                    <span class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-rose-100">
                                        <i class="fa-solid fa-face-frown"></i> NEGATIF
                                    </span>
                                @elseif($review->sentimen == 'Netral')
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-xl text-[10px] font-extrabold flex items-center gap-2 border border-slate-200">
                                        <i class="fa-solid fa-face-meh"></i> NETRAL
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-xl text-[10px] font-extrabold flex items-center gap-2 animate-pulse border border-amber-100">
                                        <i class="fa-solid fa-spinner fa-spin"></i> PROCESSING
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                {{ $review->waktu_analisis ? $review->waktu_analisis->diffForHumans() : '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                    <i class="fa-solid fa-database text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-800">Tidak Ada Data</h4>
                                <p class="text-xs text-slate-400 mt-1">Gunakan filter lain atau jalankan engine AI.</p>
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
    const ctx = document.getElementById('sentimentRadarChart').getContext('2d');
    
    // Gradient background for the chart area
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 400);
    chartGradient.addColorStop(0, 'rgba(230, 57, 70, 0.2)');
    chartGradient.addColorStop(1, 'rgba(230, 57, 70, 0)');

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Positif', 'Negatif', 'Netral', 'Rating High', 'Rating Low'],
            datasets: [{
                label: 'Volume Data',
                data: [
                    {{ $reviews->where('sentimen', 'Positif')->count() }},
                    {{ $reviews->where('sentimen', 'Negatif')->count() }},
                    {{ $reviews->where('sentimen', 'Netral')->count() }},
                    {{ $reviews->where('rating', '>=', 4)->count() }},
                    {{ $reviews->where('rating', '<=', 2)->count() }}
                ],
                fill: true,
                backgroundColor: chartGradient,
                borderColor: '#E63946',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#E63946',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                r: {
                    grid: { color: '#f1f5f9' },
                    angleLines: { color: '#f1f5f9' },
                    suggestedMin: 0,
                    pointLabels: {
                        font: { 
                            family: "'Plus Jakarta Sans', sans-serif", 
                            size: 10, 
                            weight: '800' 
                        },
                        color: '#94a3b8',
                        padding: 15
                    },
                    ticks: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    cornerRadius: 12,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 12 }
                }
            }
        }
    });
</script>
@endsection