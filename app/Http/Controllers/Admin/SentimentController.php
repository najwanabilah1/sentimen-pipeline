<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Symfony\Component\Process\Process;
use Barryvdh\DomPDF\Facade\Pdf;

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

    // =========================
    // DOWNLOAD PDF REPORT
    // =========================
    public function downloadPdf()
    {
        $reviews = Review::whereNotNull('sentimen')->orderBy('waktu_kirim', 'desc')->get();
        $total = $reviews->count();
        
        $positif = $reviews->where('sentimen', 'Positif')->count();
        $negatif = $reviews->where('sentimen', 'Negatif')->count();
        $netral  = $reviews->where('sentimen', 'Netral')->count();

        // Insight AI (Improvement untuk Perusahaan)
        $insight_status = "STABIL";
        $insight_message = "Kondisi respon publik terhadap tayangan berita RBTV cukup stabil. Terus pantau konten yang berpotensi memicu diskusi audiens.";
        $action_recommendation = "Lanjutkan strategi penayangan sesuai jadwal. Pastikan selalu memverifikasi ulang setiap berita sensitif.";
        
        // Dynamic Logic for Insights
        if ($negatif > $positif && $negatif > $netral) {
            $insight_status = "WASPADA (EVALUASI KRITIS)";
            $insight_message = "Terdeteksi sentimen negatif yang mendominasi! Terdapat pola ketidakpuasan pemirsa terhadap beberapa liputan atau layanan kami.";
            $action_recommendation = "SARAN PERUSAHAAN:\n1. Adakan meeting internal tim Redaksi untuk meninjau ulang gaya peliputan yang memicu polemik.\n2. Tim Media Sosial perlu merespons lebih aktif untuk meredam bola liar sentimen negatif.";
        } elseif ($positif > $negatif && $positif > $netral) {
            $insight_status = "SANGAT BAIK";
            $insight_message = "Apresiasi luar biasa dari masyarakat! Tayangan RBTV berhasil membangun opini dan kepercayaan yang sukses positif.";
            $action_recommendation = "SARAN PERUSAHAAN:\n1. Replikasi gaya peliputan pada berita yang paling menuai respons positif ini ke acara lainnya.\n2. Berikan semacam apresiasi untuk tim redaktur di balik acara unggulan ini.";
        } elseif ($negatif >= ($total * 0.25) && $total > 10) {
            $insight_status = "WASPADA MINOR";
            $insight_message = "Lebih dari 25% pemirsa kita memberikan respons negatif.";
            $action_recommendation = "Tindak Lanjut: Perhatikan ulasan negatif untuk mengetahui keluhan spesifik (apakah itu suara cacat, visual yang kurang jelas, atau gaya presenter) agar standar mutu segera ditingkatkan.";
        }

        $pdf = Pdf::loadView('admin.sentiment.pdf', compact(
            'reviews', 'total', 'positif', 'negatif', 'netral', 
            'insight_status', 'insight_message', 'action_recommendation'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Kinerja-Sentimen-RBTV.pdf');
    }
}