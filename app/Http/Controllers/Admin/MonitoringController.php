<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class MonitoringController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('admin.monitoring', compact('jadwals'));
    }

    public function storeJadwal(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'waktu' => 'required',
            'durasi' => 'required|numeric',
            'kategori' => 'required',
            'tanggal' => 'required|date'
        ]);
        
        $jadwal = Jadwal::create($validated);
        return response()->json(['success' => true, 'data' => $jadwal]);
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required',
            'waktu' => 'required',
            'durasi' => 'required|numeric',
            'kategori' => 'required',
            'tanggal' => 'required|date'
        ]);
        
        $jadwal->update($validated);
        return response()->json(['success' => true, 'data' => $jadwal]);
    }

    public function destroyJadwal($id)
    {
        Jadwal::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}