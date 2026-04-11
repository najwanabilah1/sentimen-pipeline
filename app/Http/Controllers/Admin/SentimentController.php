<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Symfony\Component\Process\Process;

class SentimentController extends Controller
{
    // =========================
    // HALAMAN INDEX (FIXED)
    // =========================
    public function index()
    {
        $query = Review::query();

        // 🔎 SEARCH
        if (request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('isi_ulasan_clean', 'like', "%{$search}%")
                  ->orWhere('isi_ulasan_raw', 'like', "%{$search}%")
                  ->orWhere('judul_berita', 'like', "%{$search}%")
                  ->orWhere('nama_user', 'like', "%{$search}%");
            });
        }

        // 🏷️ FILTER KATEGORI (sesuai DB kamu)
        if (request()->filled('category')) {
            $query->where('kategori_berita', request('category'));
        }

        // 😊 FILTER SENTIMEN
        if (request()->filled('sentiment')) {
            $query->where('sentimen', request('sentiment'));
        }

        // 🔽 SORT (PAKAI waktu_kirim, bukan created_at!)
        $query->orderBy('waktu_kirim', 'desc');

        // 🔥 AMBIL DATA
        $reviews = $query->get();

        return view('admin.sentiment.index', compact('reviews'));
    }

    // =========================
    // PROSES ANALISIS
    // =========================
    public function process()
    {
        // 1. Ambil data yang belum dianalisis
        $dataUlasan = Review::whereNotNull('isi_ulasan_clean')
                            ->whereNull('sentimen')
                            ->get();

        if ($dataUlasan->isEmpty()) {
            return back()->with('info', 'Tidak ada data baru untuk dianalisis.');
        }

        // 2. Ambil teks
        $listTeks = $dataUlasan->pluck('isi_ulasan_clean')->toArray();
        $jsonTeks = json_encode($listTeks, JSON_UNESCAPED_UNICODE);

        // 3. PATH PYTHON
        $pythonPath = base_path('venv\\Scripts\\python.exe');
        $scriptPath = base_path('python_services/analyzer.py');

        $process = new Process([
            $pythonPath,
            $scriptPath,
            $jsonTeks
        ]);

        $process->setTimeout(120);

        // ENV FIX
        $process->setEnv([
            'SYSTEMROOT' => getenv('SYSTEMROOT'),
            'WINDIR' => getenv('WINDIR'),
            'PATH' => getenv('PATH') . ';' . base_path('venv\\Scripts'),
            'PYTHONPATH' => base_path('venv\\Lib\\site-packages'),
            'PYTHONHASHSEED' => '0',
        ]);

        $process->run();

        // ❌ HANDLE ERROR
        if (!$process->isSuccessful()) {
            \Log::error('Python Error: ' . $process->getErrorOutput());
            return back()->with('error', 'Gagal memanggil Python');
        }

        // ✅ AMBIL OUTPUT
        $output = json_decode($process->getOutput(), true);

        if (!isset($output['sentiment'])) {
            \Log::error('Output tidak valid: ' . $process->getOutput());
            return back()->with('error', 'Output Python tidak valid');
        }

        $hasilSentimen = $output['sentiment'];

        // ✅ UPDATE DATABASE
        foreach ($dataUlasan as $index => $review) {
            if (isset($hasilSentimen[$index])) {
                $review->update([
                    'sentimen' => ucfirst(trim($hasilSentimen[$index])),
                    'waktu_analisis' => now()
                ]);
            }
        }

        return back()->with('success', 'Analisis Sentimen Berhasil!');
    }
}