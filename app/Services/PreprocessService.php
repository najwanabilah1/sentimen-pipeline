<?php

namespace App\Services;

class PreprocessService
{
    public static function process($text)
    {
        try {
            $pythonScript = base_path('python_services/analyzer_user.py');
            $historyFile  = base_path('python_services/comments_history.json');

            // Escape argument (aman dari karakter aneh & spasi)
            $escapedText    = escapeshellarg($text);
            $escapedHistory = escapeshellarg($historyFile);

            // 🔥 Ambil Python command (prioritas venv)
            $pythonCmd = self::getPythonCommand();

            // 🔥 Escape python command juga (ANTI ERROR PATH SPASI)
            $command = escapeshellarg($pythonCmd) . " " 
                     . escapeshellarg($pythonScript) . " "
                     . $escapedText . " " 
                     . $escapedHistory;

            // 🔥 Logging error ke file
            $errorFile = base_path('storage/logs/python_error.log');
            $command .= " 2>>" . escapeshellarg($errorFile);

            // 🔥 Eksekusi Python
            $output = shell_exec($command);

            // 🔥 Jika Python tidak menghasilkan output
            if (!$output) {
                return self::defaultResult();
            }

            // 🔥 Decode JSON dari Python
            $result = json_decode($output, true);

            if (!is_array($result)) {
                return self::defaultResult();
            }

            return $result;

        } catch (\Exception $e) {
            // 🔥 Fallback jika error
            return array_merge(self::defaultResult(), [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * 🔥 Default hasil jika Python gagal
     */
    private static function defaultResult()
    {
        return [
            'clean_text'   => null,
            'is_kasar'     => 0,
            'is_spam'      => 0,
            'status'       => 'Pending',
            'skor_cosine'  => 0.0
        ];
    }

    /**
     * 🔥 Ambil Python command (prioritas venv, fallback global)
     */
    public static function getPythonCommand()
    {
        // 🔥 1. Cek Virtual Environment (PRIORITAS UTAMA)
        $venvWindows = base_path('venv\\Scripts\\python.exe');
        $venvUnix    = base_path('venv/bin/python');

        if (file_exists($venvWindows)) {
            return $venvWindows;
        }

        if (file_exists($venvUnix)) {
            return $venvUnix;
        }

        // 🔥 2. Fallback ke Python global
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if ($isWindows) {
            // Cari python.exe
            $output = shell_exec('where python.exe 2>nul');
            if ($output) {
                $lines = preg_split('/\r?\n/', trim($output));
                return $lines[0];
            }

            // Cari python
            $output = shell_exec('where python 2>nul');
            if ($output) {
                $lines = preg_split('/\r?\n/', trim($output));
                return $lines[0];
            }

            return 'python'; // fallback terakhir
        } else {
            // Linux / Mac
            $output = shell_exec('which python3 2>/dev/null');
            if ($output) {
                return trim($output);
            }

            $output = shell_exec('which python 2>/dev/null');
            if ($output) {
                return trim($output);
            }

            return 'python3'; // fallback terakhir
        }
    }
}