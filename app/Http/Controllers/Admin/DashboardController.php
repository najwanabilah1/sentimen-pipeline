<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Review;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar
        $stats = [
            'total_berita' => Berita::count(),
            'berita_7hari'  => Berita::where('tanggal_berita', '>=', now()->subDays(7))->count(),
            'total_ulasan'  => Review::count(),
            'rating_avg'    => round(Review::whereNotNull('rating')->average('rating') ?? 0, 1),
        ];

        // 2. Data Grafik Sentimen
        $sentimentData = [
            'positif' => Review::where('sentimen', 'Positif')->count(),
            'netral'  => Review::where('sentimen', 'Netral')->count(),
            'negatif' => Review::where('sentimen', 'Negatif')->count(),
        ];

        // 3. LOGIKA AKTUAL UNTUK ANALISIS AI
        
        // Menghitung Akurasi Data Terproses
        // Logika: Berapa persen ulasan yang sudah memiliki label 'sentimen' dibanding total ulasan
        $totalUlasan = $stats['total_ulasan'];
        $ulasanTerproses = Review::whereNotNull('sentimen')->where('sentimen', '!=', '')->count();
        
        $accuracy = $totalUlasan > 0 
            ? round(($ulasanTerproses / $totalUlasan) * 100) 
            : 0;

        // Menentukan Kesimpulan Tren secara Otomatis
        $trend = 'Seimbang';
        if ($sentimentData['positif'] > $sentimentData['negatif'] && $sentimentData['positif'] > $sentimentData['netral']) {
            $trend = 'Positif';
        } elseif ($sentimentData['negatif'] > $sentimentData['positif'] && $sentimentData['negatif'] > $sentimentData['netral']) {
            $trend = 'Negatif';
        }

        return view('admin.dashboard', compact('stats', 'sentimentData', 'accuracy', 'trend'));
    }
}