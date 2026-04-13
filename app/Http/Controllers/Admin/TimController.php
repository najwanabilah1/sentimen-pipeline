<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class TimController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();
        return view('admin.tim', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'posisi' => 'required|string',
            'departemen' => 'required|in:Produksi,Teknis,Redaksi,Marketing,IT',
            'email' => 'required|email|unique:members',
            'telepon' => 'nullable|string',
            'status' => 'required|in:Aktif,Cuti,Tidak Aktif'
        ]);

        Member::create($validated);
        return redirect()->route('admin.tim.index')->with('success', 'Anggota tim berhasil ditambahkan');
    }

    public function update(Request $request, Member $tim)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'posisi' => 'required|string',
            'departemen' => 'required|in:Produksi,Teknis,Redaksi,Marketing,IT',
            'email' => 'required|email|unique:members,email,' . $tim->id,
            'telepon' => 'nullable|string',
            'status' => 'required|in:Aktif,Cuti,Tidak Aktif'
        ]);

        $tim->update($validated);
        return redirect()->route('admin.tim.index')->with('success', 'Anggota tim berhasil diupdate');
    }

    public function destroy(Member $tim)
    {
        $tim->delete();
        return redirect()->route('admin.tim.index')->with('success', 'Anggota tim berhasil dihapus');
    }
}