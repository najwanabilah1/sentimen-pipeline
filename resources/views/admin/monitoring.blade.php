@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="bg-red-50 border border-red-100 p-4 rounded-2xl flex items-center gap-4">
        <div class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center animate-pulse">
            <i class="fa-solid fa-tower-broadcast"></i>
        </div>
        <div>
            <h4 class="font-bold text-red-900">Live Monitoring Aktif</h4>
            <p class="text-red-700 text-xs">Data diperbarui setiap 30 detik secara otomatis.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-6">Grafik Penonton Real-time</h3>
            <canvas id="liveViewersChart" height="250"></canvas>
        </div>
        
        <div class="space-y-4">
            <h3 class="font-bold text-gray-800">Status Program Saat Ini</h3>
            @foreach($livePrograms as $lp)
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-red-600 text-white rounded-full uppercase tracking-tighter">Live</span>
                    <span class="text-xs text-gray-400 font-medium"><i class="fa-solid fa-eye mr-1"></i> {{ number_format($lp->viewers ?? 1250) }}</span>
                </div>
                <h5 class="font-bold text-gray-900 text-sm">{{ $lp->judul }}</h5>
                <p class="text-xs text-gray-500 mt-1">{{ $lp->kategori }}</p>
                <div class="mt-3 w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-red-600 h-full w-2/3"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('liveViewersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['18:00', '18:30', '19:00', '19:30', '20:00'],
            datasets: [{
                label: 'Viewers',
                data: [1200, 1500, 2100, 1800, 2450],
                borderColor: '#DC2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection