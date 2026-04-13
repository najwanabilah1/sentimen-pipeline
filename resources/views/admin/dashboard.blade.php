@extends('layouts.admin')

@section('content')
<style>
    /* --- ANIMASI & HERO STYLE --- */
    @keyframes shine {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .hero-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        overflow: hidden;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .text-shine {
        background: linear-gradient(to right, #f43f5e 20%, #fbbf24 40%, #fbbf24 60%, #f43f5e 80%);
        background-size: 200% auto;
        color: #000;
        background-clip: text;
        text-fill-color: transparent;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shine 4s linear infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
    .floating { animation: float 6s ease-in-out infinite; }

    @keyframes fillProgress {
        from { width: 0; }
        to { width: {{ $accuracy }}%; }
    }
    .animate-progress {
        animation: fillProgress 1.5s ease-out forwards;
    }

    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-7xl mx-auto space-y-8">
    
    <div class="hero-gradient rounded-[2rem] p-6 md:p-8 shadow-xl animate-fade-in relative">
        <div class="absolute top-0 right-0 w-48 h-48 bg-red-500/10 blur-[80px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-500/10 blur-[60px] rounded-full"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="max-w-xl text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-white/80 text-[10px] font-bold uppercase tracking-widest mb-4 backdrop-blur-md">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-red-500"></span>
                    </span>
                    AI Engine v3.0
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-2">
                    Monitor <span class="text-shine">Sentimen</span> Pemirsa
                </h1>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed opacity-80">
                    Wawasan strategis dari <span class="text-white font-bold">{{ $stats['total_ulasan'] }} data</span> ulasan secara real-time.
                </p>
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <div class="glass-card px-5 py-4 rounded-2xl text-center flex-1 md:flex-none min-w-[100px]">
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mb-1 text-white/60">Accuracy</p>
                    <h4 class="text-2xl font-black text-white">{{ $accuracy }}%</h4>
                </div>
                <div class="glass-card px-5 py-4 rounded-2xl text-center flex-1 md:flex-none min-w-[100px]">
                    <p class="text-slate-400 text-[9px] font-bold uppercase tracking-widest mb-1 text-white/60">Trend</p>
                    <h4 class="text-lg font-black {{ $trend == 'Positif' ? 'text-emerald-400' : 'text-rose-400' }}">{{ strtoupper($trend) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in" style="animation-delay: 0.2s">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Berita</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_berita'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center text-xl group-hover:bg-red-500 group-hover:text-white transition-all">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
        </div>

        <div class="bg-emerald-500 p-6 rounded-[2rem] shadow-lg shadow-emerald-200 hover:scale-105 transition-all text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-widest mb-1">Sentimen Positif</p>
                    <h3 class="text-3xl font-black">{{ $sentimentData['positif'] }}</h3>
                </div>
                <i class="fa-solid fa-face-smile-beam text-3xl text-emerald-200/50"></i>
            </div>
        </div>

        <div class="bg-rose-500 p-6 rounded-[2rem] shadow-lg shadow-rose-200 hover:scale-105 transition-all text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-rose-100 text-xs font-bold uppercase tracking-widest mb-1">Sentimen Negatif</p>
                    <h3 class="text-3xl font-black">{{ $sentimentData['negatif'] }}</h3>
                </div>
                <i class="fa-solid fa-face-frown-open text-3xl text-rose-200/50"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Ulasan</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $stats['total_ulasan'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-comments"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: 0.4s">
        <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-[2rem] border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="font-extrabold text-gray-800 text-lg">Distribusi Sentimen Pemirsa</h4>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Real-time Graph</span>
            </div>
            <div class="relative w-full h-[350px] flex justify-center">
                <canvas id="sentimentChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden flex flex-col justify-center">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h4 class="font-extrabold text-gray-800 text-lg">Wawasan Sistem</h4>
                </div>
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="font-bold text-gray-600">Akurasi Analisis</span>
                            <span class="font-extrabold text-red-600">{{ $accuracy }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-rose-600 h-2.5 rounded-full animate-progress" style="width: 0;"></div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 leading-relaxed space-y-4">
                         <p>Berdasarkan pengolahan data, pemirsa cenderung memberikan respon bersifat <strong class="{{ $trend == 'Positif' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $trend }}</strong> terhadap konten berita yang ditayangkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="animate-fade-in" style="animation-delay: 0.6s">
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white">
                <h4 class="font-extrabold text-gray-800 text-lg">Ulasan Terbaru</h4>
                <button class="px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition-colors border border-red-100">
                    Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                </button>
            </div>
            
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pemirsa</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Komentar</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Sentimen</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentReviews as $review)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm font-bold">
                                        {{ substr($review->nama_user ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-700">{{ $review->nama_user }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600 line-clamp-1 group-hover:line-clamp-none transition-all duration-300">
                                    "{{ $review->isi_ulasan_raw }}"
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full 
                                    {{ $review->sentimen == 'Positif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 
                                       ($review->sentimen == 'Negatif' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-slate-50 text-slate-600 border border-slate-100') }}">
                                    <i class="fa-solid {{ $review->sentimen == 'Positif' ? 'fa-smile' : ($review->sentimen == 'Negatif' ? 'fa-frown' : 'fa-meh') }} mr-1.5"></i> 
                                    {{ $review->sentimen }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold text-gray-400 uppercase">
                                {{ \Carbon\Carbon::parse($review->waktu_kirim)->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada ulasan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('sentimentChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Positif', 'Netral', 'Negatif'],
                datasets: [{
                    data: [{{ $sentimentData['positif'] }}, {{ $sentimentData['netral'] }}, {{ $sentimentData['negatif'] }}],
                    backgroundColor: ['#10B981', '#94A3B8', '#F43F5E'],
                    borderWidth: 0,
                    hoverOffset: 25,
                    spacing: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '78%',
                plugins: { 
                    legend: { position: 'bottom', labels: { padding: 35, usePointStyle: true, font: { size: 13, weight: '700' } } }
                }
            }
        });
    });
</script>
@endsection