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
        return view('admin.tim.index', compact('members'));
    }

    public function create()
    {
        return view('admin.tim.create');
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

    public function show(Member $member)
    {
        return view('admin.tim.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.tim.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'posisi' => 'required|string',
            'departemen' => 'required|in:Produksi,Teknis,Redaksi,Marketing,IT',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'telepon' => 'nullable|string',
            'status' => 'required|in:Aktif,Cuti,Tidak Aktif'
        ]);

        $member->update($validated);
        return redirect()->route('admin.tim.show', $member)->with('success', 'Anggota tim berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.tim.index')->with('success', 'Anggota tim berhasil dihapus');
    }
}