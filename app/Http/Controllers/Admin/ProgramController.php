<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $beritas = Berita::orderBy('tanggal_berita', 'desc')->get();
        return view('admin.program', compact('beritas'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul_berita' => 'required|string|max:255',
                'kategori_berita' => 'required|in:Malam,Daerah,Pekaro',
                'tanggal_berita' => 'required|date',
                'caption_berita' => 'required|string',
                'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'link_berita' => 'nullable|url'
            ]);

            // Set default gambar
            $validated['gambar_berita'] = 'default.jpg';

            // Handle file upload
            if ($request->hasFile('gambar_berita')) {
                $file = $request->file('gambar_berita');
                
                // Check jika file valid
                if ($file->isValid()) {
                    // Buat nama file unik
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    
                    // Pastikan folder ada
                    $uploadPath = public_path('uploads');
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    
                    // Upload ke folder public/uploads
                    $file->move($uploadPath, $filename);
                    $validated['gambar_berita'] = $filename;
                }
            }

            $berita = Berita::create($validated);
            
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'berita' => $berita]);
            }
            
            return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }

    public function update(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            $validated = $request->validate([
                'judul_berita' => 'required|string|max:255',
                'kategori_berita' => 'required|in:Malam,Daerah,Pekaro',
                'tanggal_berita' => 'required|date',
                'caption_berita' => 'required|string',
                'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'link_berita' => 'nullable|url'
            ]);

            // Handle file upload
            if ($request->hasFile('gambar_berita')) {
                $file = $request->file('gambar_berita');
                
                // Check jika file valid
                if ($file->isValid()) {
                    // Delete old file jika bukan default
                    if ($berita->gambar_berita && $berita->gambar_berita !== 'default.jpg' && file_exists(public_path('uploads/' . $berita->gambar_berita))) {
                        unlink(public_path('uploads/' . $berita->gambar_berita));
                    }
                    
                    // Buat nama file unik
                    $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    
                    // Pastikan folder ada
                    $uploadPath = public_path('uploads');
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    
                    // Upload ke folder public/uploads
                    $file->move($uploadPath, $filename);
                    $validated['gambar_berita'] = $filename;
                }
            }

            $berita->update($validated);
            
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'berita' => $berita]);
            }
            
            return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id, Request $request)
    {
        $berita = Berita::findOrFail($id);
        
        // Delete file jika bukan default
        if ($berita->gambar_berita && $berita->gambar_berita !== 'default.jpg' && file_exists(public_path('uploads/' . $berita->gambar_berita))) {
            unlink(public_path('uploads/' . $berita->gambar_berita));
        }
        
        $berita->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil dihapus');
    }
}