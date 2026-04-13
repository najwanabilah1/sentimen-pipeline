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
            ->select('ulasan.*', 'berita.id_berita', 'berita.gambar_berita')
            ->get();

        return view('ulasan', compact('berita','ulasan'));
    }

    public function store(Request $request)
    {
        
        // 🔥 VALIDASI (WAJIB)
        $request->validate([
            'kategori_berita' => 'required',
            'judul_berita' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'isi_ulasan_raw' => 'required|string',
            'recaptcha_token' => 'required'
        ]);

        // 2. VALIDASI RECAPTCHA
        $recaptcha = $request->recaptcha_token;

        $response = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=6LcrmbUsAAAAAAnIuFQHkTxd6AUBk3h7a4oqRUqW&response=".$recaptcha
        );

        $result = json_decode($response);

        // Debug (opsional)
        \Log::info('RECAPTCHA RESULT', (array)$result);

        if (!$result || !$result->success || $result->score < 0.5) {
            return redirect()->back()->with('notif', 'Verifikasi gagal! Terindikasi bot.');
        }

        // 🔥 DEFAULT NAMA
        $nama = $request->nama_user ?: 'Anonim';

        // 🔥 AUTO AMBIL KATEGORI (opsional tapi disarankan)
        $kategori = $request->kategori_berita;

        if (!$kategori && $request->judul_berita) {
            $berita = DB::table('berita')
                ->where('judul_berita', $request->judul_berita)
                ->first();

            $kategori = $berita->kategori_berita ?? null;
        }

        $request->merge(['kategori_berita' => $kategori]);

        // 🔥 PREPROCESSING (PYTHON)
        $hasil = PreprocessService::process($request->isi_ulasan_raw);

        // 🔥 AMBIL HASIL DENGAN DEFAULT
        $status   = $hasil['status'] ?? 'Pending';
        $clean    = $hasil['clean_text'] ?? null;
        $is_spam  = $hasil['is_spam'] ?? 0;
        $is_kasar = $hasil['is_kasar'] ?? 0;
        $cosine   = $hasil['skor_cosine'] ?? 0;

        // 🔥 NORMALISASI STATUS ENUM (BIAR GA ERROR DB)
        try {
            $col = DB::select("
                SELECT COLUMN_TYPE 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'ulasan' 
                AND COLUMN_NAME = 'status' 
                AND TABLE_SCHEMA = DATABASE()
            ");

            if (!empty($col) && isset($col[0]->COLUMN_TYPE)) {
                preg_match_all("/'([^']+)'/", $col[0]->COLUMN_TYPE, $matches);
                $allowed = $matches[1] ?? [];

                $found = null;

                foreach ($allowed as $a) {
                    if (strcasecmp($a, $status) === 0) {
                        $found = $a;
                        break;
                    }
                }

                if (!$found && !empty($allowed)) {
                    $found = $allowed[0]; // fallback
                }

                if ($found) {
                    $status = $found;
                }
            }
        } catch (\Exception $e) {
            // abaikan error, pakai status default
        }

        // 🔥 INSERT KE DATABASE
        DB::table('ulasan')->insert([
            'kategori_berita'   => $request->kategori_berita,
            'judul_berita'      => $request->judul_berita,
            'rating'            => $request->rating,
            'nama_user'         => $nama,

            // DATA ASLI
            'isi_ulasan_raw'    => $request->isi_ulasan_raw,

            // HASIL PREPROCESSING
            'isi_ulasan_clean'  => $clean,

            // STATUS
            'status'            => $status,

            // ANALISIS TAMBAHAN
            'is_spam'           => $is_spam,
            'is_kasar'          => $is_kasar,
            'skor_cosine'       => $cosine,

            'waktu_kirim'       => now()
        ]);

        return redirect()->back()->with('notif','Ulasan berhasil dikirim!');
    }
}