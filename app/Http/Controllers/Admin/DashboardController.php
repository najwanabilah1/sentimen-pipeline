<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Review;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_berita' => Berita::count(),
            'berita_7hari'  => Berita::where('tanggal_berita', '>=', now()->subDays(7))->count(),
            'total_ulasan'  => Review::count(),
            'rating_avg'    => Review::whereNotNull('rating')->average('rating') ?? 0,
        ];

        // Data untuk Grafik Sentimen (Pie Chart)
        $sentimentData = [
            'positif' => Review::where('sentimen', 'Positif')->count(),
            'netral'  => Review::where('sentimen', 'Netral')->count(),
            'negatif' => Review::where('sentimen', 'Negatif')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'sentimentData'));
    }
}