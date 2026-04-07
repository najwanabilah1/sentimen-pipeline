<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $berita = DB::table('berita')
            ->orderBy('tanggal_berita', 'desc')
            ->limit(5)
            ->get();

        $ulasan = DB::table('ulasan')
            ->leftJoin('berita', function($join) {
                $join->on('ulasan.judul_berita', '=', 'berita.judul_berita')
                     ->on('ulasan.kategori_berita', '=', 'berita.kategori_berita');
            })
            ->where('ulasan.status', 'Approved')
            ->orderBy('ulasan.waktu_kirim', 'desc')
            ->limit(5)
            ->select('ulasan.*', 'berita.gambar_berita')
            ->get();

        return view('index', compact('berita', 'ulasan'));
    }
}