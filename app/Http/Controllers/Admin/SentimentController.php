<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Services\PreprocessService;

class SentimentController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('admin.sentiment.index', compact('reviews'));
    }

    public function process()
    {
        // 1. Ambil data yang ulasan_clean-nya ada tapi sentimen-nya masih kosong   
        $dataUlasan = Review::whereNotNull('isi_ulasan_clean')
                            ->whereNull('sentimen')
                            ->get();

        if ($dataUlasan->isEmpty()) {
            return back()->with('info', 'Tidak ada data baru untuk dianalisis.');   
        }

        // 2. Kirim data 'isi_ulasan_clean' ke Python
        $listTeks = $dataUlasan->pluck('isi_ulasan_clean')->toArray();
        $jsonTeks = json_encode($listTeks);

        // Run Python analyzer via Symfony Process (non-static)
        $pythonCmd = PreprocessService::getPythonCommand();

        $cmd = [
            $pythonCmd,
            base_path('python_services/analyzer.py'),
            $jsonTeks,
        ];

        $process = new Process($cmd);
        $process->setTimeout(120);
        $process->run();

        if (!$process->isSuccessful()) {
            \Log::error('Python Process Error: ' . $process->getErrorOutput());
            \Log::error('Python Command Line: ' . $process->getCommandLine());
            // Optionally, return the error message directly to the front-end to see what happened
            return back()->with('error', 'Gagal memanggil Python. Error: ' . $process->getErrorOutput());
        }

        $hasilSentimen = json_decode($process->getOutput(), true);

        // 3. Update kolom 'sentimen' dan 'waktu_analisis'
        foreach ($dataUlasan as $index => $review) {
            $review->update([
                'sentimen' => $hasilSentimen[$index],
                'waktu_analisis' => now() // Catat waktu kapan AI memprosesnya
            ]);
        }

        return back()->with('success', 'Analisis Sentimen Berhasil!');
    }
}
