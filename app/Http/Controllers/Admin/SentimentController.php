<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Symfony\Component\Process\Process;

class SentimentController extends Controller
{
    // =========================
    // HALAMAN INDEX
    // =========================
    public function index()
    {
        $reviews = Review::all();
        return view('admin.sentiment.index', compact('reviews'));
    }

    // =========================
    // PROSES ANALISIS
    // =========================
    public function process()
    {
        // 1. Ambil data
        $dataUlasan = Review::whereNotNull('isi_ulasan_clean')
                            ->whereNull('sentimen')
                            ->get();

        if ($dataUlasan->isEmpty()) {
            return back()->with('info', 'Tidak ada data baru untuk dianalisis.');
        }

        // 2. Ambil teks
        $listTeks = $dataUlasan->pluck('isi_ulasan_clean')->toArray();
        $jsonTeks = json_encode($listTeks, JSON_UNESCAPED_UNICODE);

        // 3. PATH PYTHON (VENV)
        $pythonPath = base_path('venv\\Scripts\\python.exe');
        $scriptPath = base_path('python_services/analyzer.py');

        $process = new Process([
            $pythonPath,
            $scriptPath,
            $jsonTeks
        ]);

        $process->setTimeout(120);

        // 🔥 ENV FIX FINAL (WAJIB)
        $process->setEnv([
            'SYSTEMROOT' => getenv('SYSTEMROOT'),
            'WINDIR' => getenv('WINDIR'),
            'PATH' => getenv('PATH') . ';' . base_path('venv\\Scripts'),
            'PYTHONPATH' => base_path('venv\\Lib\\site-packages'),
            'PYTHONHASHSEED' => '0',
        ]);

        $process->run();

        // =========================
        // HANDLE ERROR
        // =========================
        if (!$process->isSuccessful()) {
            \Log::error('Python Error: ' . $process->getErrorOutput());
            return back()->with('error', 'Gagal memanggil Python: ' . $process->getErrorOutput());
        }

        // =========================
        // AMBIL OUTPUT
        // =========================
        $output = json_decode($process->getOutput(), true);

        if (!isset($output['sentiment'])) {
            \Log::error('Output tidak valid: ' . $process->getOutput());
            return back()->with('error', 'Output Python tidak valid');
        }

        $hasilSentimen = $output['sentiment'];

        // =========================
        // UPDATE DATABASE
        // =========================
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