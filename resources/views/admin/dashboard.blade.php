@extends('layouts.admin')

@section('content')
<style>
    /* --- ANIMASI & TRANSISI --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    .delay-100 { animation-delay: 100ms; opacity: 0; }
    .delay-200 { animation-delay: 200ms; opacity: 0; }
    .delay-300 { animation-delay: 300ms; opacity: 0; }
    
    @keyframes fillProgress {
        from { width: 0; }
        to { width: {{ $accuracy }}%; }
    }
    .animate-progress {
        animation: fillProgress 1.5s ease-out forwards;
        animation-delay: 600ms;
    }
</style>

<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-7xl mx-auto">
    
    <div class="mb-8 animate-fade-in">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">Dashboard Sentimen</h2>
        <p class="text-sm md:text-base text-gray-500 mt-1">Berdasarkan data aktual dari {{ $stats['total_ulasan'] }} ulasan pemirsa.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-in group">
            <div class="w-14 h-14 bg-gradient-to-br from-red-50 to-red-100 text-red-600 rounded-xl flex items-center justify-center mb-4 text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-tv"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total Berita</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_berita'] }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-in delay-100 group">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-comments"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total Ulasan</p>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['total_ulasan'] }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-in delay-200 group">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-smile"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Sentimen Positif</p>
            <h3 class="text-3xl font-extrabold text-emerald-500">{{ $sentimentData['positif'] }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-in delay-300 group">
            <div class="w-14 h-14 bg-gradient-to-br from-rose-50 to-rose-100 text-rose-600 rounded-xl flex items-center justify-center mb-4 text-2xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-frown"></i>
            </div>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Sentimen Negatif</p>
            <h3 class="text-3xl font-extrabold text-rose-500">{{ $sentimentData['negatif'] }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in delay-300">
        
        <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
                <h4 class="font-extrabold text-gray-800 text-lg">Distribusi Sentimen Pemirsa</h4>
                <div class="flex items-center gap-2">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-gray-500 text-xs font-bold uppercase tracking-wider">Data Aktual</span>
                </div>
            </div>
            
            <div class="relative w-full h-[300px] sm:h-[350px] md:h-[400px] flex justify-center">
                <canvas id="sentimentChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col justify-center relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-3xl z-0"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h4 class="font-extrabold text-gray-800 text-lg">Wawasan Sistem</h4>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="font-bold text-gray-600">Data Terproses AI</span>
                            <span class="font-extrabold text-red-600">{{ $accuracy }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-rose-600 h-2.5 rounded-full animate-progress" style="width: 0;"></div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600 leading-relaxed space-y-4">
                        @if($trend == 'Positif')
                            <p>
                                Analisis mendeteksi tren <strong class="text-emerald-600">Dominan Positif</strong>. Pemirsa merespons sangat baik terhadap konten berita terbaru.
                            </p>
                            <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-r-xl">
                                <p class="text-emerald-800 font-medium">
                                    <i class="fa-solid fa-check-circle mr-1"></i> Rekomendasi: 
                                    <span class="font-normal">Pertahankan durasi dan gaya penyampaian berita saat ini.</span>
                                </p>
                            </div>
                        @elseif($trend == 'Negatif')
                            <p>
                                Sistem mendeteksi tren <strong class="text-rose-600">Dominan Negatif</strong>. Terdapat kritik yang perlu segera ditinjau pada kolom ulasan.
                            </p>
                            <div class="bg-rose-50 border-l-4 border-rose-400 p-4 rounded-r-xl">
                                <p class="text-rose-800 font-medium">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Rekomendasi: 
                                    <span class="font-normal">Tinjau kembali ulasan terbaru untuk mengidentifikasi masalah teknis atau konten.</span>
                                </p>
                            </div>
                        @else
                            <p>
                                Respon pemirsa saat ini berada pada tingkat <strong class="text-slate-600">Netral / Seimbang</strong>.
                            </p>
                            <div class="bg-slate-50 border-l-4 border-slate-400 p-4 rounded-r-xl">
                                <p class="text-slate-800 font-medium">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Catatan: 
                                    <span class="font-normal">Terus pantau perkembangan sentimen pada berita utama mendatang.</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
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
                    data: [
                        {{ $sentimentData['positif'] }}, 
                        {{ $sentimentData['netral'] }}, 
                        {{ $sentimentData['negatif'] }}
                    ],
                    backgroundColor: ['#10B981', '#94A3B8', '#F43F5E'],
                    hoverBackgroundColor: ['#059669', '#64748B', '#E11D48'],
                    borderWidth: 0,
                    hoverOffset: 20,
                    spacing: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1800,
                    easing: 'easeOutQuart'
                },
                plugins: { 
                    legend: { 
                        position: 'bottom',
                        labels: {
                            padding: 30,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 14, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 15,
                        cornerRadius: 12,
                        usePointStyle: true
                    }
                }
            }
        });
    });
</script>
@endsection