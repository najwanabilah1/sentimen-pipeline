@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-4 text-xl">
            <i class="fa-solid fa-tv"></i>
        </div>
        <p class="text-gray-500 text-sm font-medium">Total Berita</p>
        <h3 class="text-2xl font-bold">{{ $stats['total_berita'] }}</h3>
    </div>
    
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-xl">
            <i class="fa-solid fa-comments"></i>
        </div>
        <p class="text-gray-500 text-sm font-medium">Total Ulasan</p>
        <h3 class="text-2xl font-bold">{{ $stats['total_ulasan'] }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 text-xl">
            <i class="fa-solid fa-smile"></i>
        </div>
        <p class="text-gray-500 text-sm font-medium">Sentimen Positif</p>
        <h3 class="text-2xl font-bold text-emerald-600">{{ $sentimentData['positif'] }}</h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-4 text-xl">
            <i class="fa-solid fa-frown"></i>
        </div>
        <p class="text-gray-500 text-sm font-medium">Sentimen Negatif</p>
        <h3 class="text-2xl font-bold text-red-600">{{ $sentimentData['negatif'] }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
        <h4 class="font-bold text-gray-800 mb-6">Persentase Sentimen Penonton</h4>
        <div class="h-64">
            <canvas id="sentimentChart"></canvas>
        </div>
    </div>
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
        <h4 class="font-bold text-gray-800 mb-4 text-center">Analisis Singkat</h4>
        <div class="space-y-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500">Akurasi Model</span>
                <span class="font-bold">92%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-red-600 h-2 rounded-full" style="width: 92%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-4 leading-relaxed">
                Hasil analisis menunjukkan sebagian besar penonton merasa puas dengan program Berita Malam RBTV. Ulasan negatif biasanya berkaitan dengan durasi iklan.
            </p>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('sentimentChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Positif', 'Netral', 'Negatif'],
            datasets: [{
                data: [{{ $sentimentData['positif'] }}, {{ $sentimentData['netral'] }}, {{ $sentimentData['negatif'] }}],
                backgroundColor: ['#10B981', '#94a3b8', '#EF4444'],
                borderWidth: 0,
                spacing: 10
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection