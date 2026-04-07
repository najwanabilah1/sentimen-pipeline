<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ProgramUserController extends Controller
{
    public function index()
    {
        $berita = DB::table('berita')
            ->orderBy('tanggal_berita', 'desc')
            ->get();

        return view('program', compact('berita'));
    }
}