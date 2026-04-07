<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;

class MonitoringController extends Controller
{
    public function index()
    {
        // Menampilkan program yang sedang/akan tayang hari ini
        $livePrograms = Program::where('tanggal', now()->toDateString())
                                ->withCount('reviews')
                                ->get();

        return view('admin.monitoring', compact('livePrograms'));
    }
}