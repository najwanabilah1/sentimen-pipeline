<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function index(Request $request)
    {
        // AMBIL BERITA
        if($request->id){
            $data = DB::table('berita')
                ->where('id_berita', $request->id)
                ->first();
        } else {
            $data = DB::table('berita')
                ->where('judul_berita', $request->judul)
                ->where('kategori_berita', $request->kategori)
                ->first();
        }

        if(!$data){
            return view('detail', ['data' => null]);
        }

        // AMBIL ULASAN
        $ulasan = DB::table('ulasan')
            ->where('judul_berita', $data->judul_berita)
            ->where('kategori_berita', $data->kategori_berita)
            ->where('status', 'Approved')
            ->orderBy('waktu_kirim','desc')
            ->get();

        // HITUNG RATING
        $count = $ulasan->count();
        $avg = $count > 0 ? round($ulasan->avg('rating'),1) : 0;

        return view('detail', compact('data','ulasan','count','avg'));
    }
}