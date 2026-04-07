<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PreprocessService; 

class UlasanController extends Controller
{
    public function index()
    {
        $berita = DB::table('berita')->get();

        $ulasan = DB::table('ulasan')
            ->leftJoin('berita', function($join) {
                $join->on('ulasan.judul_berita','=','berita.judul_berita')
                     ->on('ulasan.kategori_berita','=','berita.kategori_berita');
            })
            ->where('ulasan.status','Approved')
            ->orderBy('ulasan.waktu_kirim','desc')
            ->limit(10)
            ->select('ulasan.*','berita.gambar_berita')
            ->get();

        return view('ulasan', compact('berita','ulasan'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama_user ?: 'Anonim';

        // 🔥 KIRIM KE PYTHON
        $hasil = PreprocessService::process($request->isi_ulasan_raw);

        // 🔥 AMBIL HASIL (PAKAI DEFAULT BIAR AMAN)
        $status = $hasil['status'] ?? 'Pending';
        // Normalisasi: pastikan value status cocok dengan ENUM di DB
        try {
            $col = DB::select("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ulasan' AND COLUMN_NAME = 'status' AND TABLE_SCHEMA = DATABASE()");
            if (!empty($col) && isset($col[0]->COLUMN_TYPE)) {
                $type = $col[0]->COLUMN_TYPE; // e.g. enum('pending','Approved')
                preg_match_all("/'([^']+)'/", $type, $matches);
                $allowed = array_map(function($v){ return $v; }, $matches[1] ?? []);

                // Try case-insensitive match
                $found = null;
                foreach ($allowed as $a) {
                    if (strcasecmp($a, $status) === 0) { $found = $a; break; }
                }

                // If not found, try some common mappings
                if (!$found) {
                    $map = [
                        'pending' => ['pending','Pending','PENDING'],
                        'approved' => ['approved','Approved','APPROVED'],
                        'rejected' => ['rejected','Rejected','REJECTED']
                    ];
                    foreach ($map as $target => $variants) {
                        foreach ($variants as $v) {
                            if (strcasecmp($v, $status) === 0 && in_array($target, $allowed, true)) {
                                $found = $target; break 2;
                            }
                        }
                    }
                }

                // Fallback to first allowed value
                if ($found) {
                    $status = $found;
                } elseif (!empty($allowed)) {
                    $status = $allowed[0];
                }
            }
        } catch (\Exception $e) {
            // ignore and keep original status
        }
        $clean = $hasil['clean_text'] ?? null;
        $is_spam = $hasil['is_spam'] ?? 0;
        $is_kasar = $hasil['is_kasar'] ?? 0;
        $cosine = $hasil['skor_cosine'] ?? 0;

        DB::table('ulasan')->insert([
            'kategori_berita' => $request->kategori_berita,
            'judul_berita' => $request->judul_berita,
            'rating' => $request->rating,
            'nama_user' => $nama,

            // 🔥 DATA ASLI
            'isi_ulasan_raw' => $request->isi_ulasan_raw,

            // 🔥 HASIL PREPROCESSING
            'isi_ulasan_clean' => $clean,

            // 🔥 STATUS DARI AI
            'status' => $status,

            // 🔥 ANALISIS TAMBAHAN
            'is_spam' => $is_spam,
            'is_kasar' => $is_kasar,
            'skor_cosine' => $cosine,

            'waktu_kirim' => now()
        ]);

        return redirect()->back()->with('notif','Ulasan berhasil dikirim!');
    }
}