<?php

namespace App\Services;

class PreprocessService
{
    public static function process($text)
    {
        try {
            $python = base_path('python_services/analyzer_user.py');
            $history = base_path('python_services/comments_history.json');

            // Escape text untuk shell
            $text = escapeshellarg($text);
            $history = escapeshellarg($history);

            // Coba berbagai cara untuk jalankan Python di Windows/Linux
            $python_cmd = self::getPythonCommand();
            $command = "$python_cmd " . escapeshellarg($python) . " $text $history";

            // Error logging
            $error_file = base_path('storage/logs/python_error.log');
            $command .= " 2>>" . escapeshellarg($error_file);

            $output = shell_exec($command);

            if (!$output) {
                return [
                    'clean_text' => null,
                    'is_kasar' => 0,
                    'is_spam' => 0,
                    'status' => 'Pending',
                    'skor_cosine' => 0.0
                ];
            }

            $result = json_decode($output, true);
            
            if (!is_array($result)) {
                return [
                    'clean_text' => null,
                    'is_kasar' => 0,
                    'is_spam' => 0,
                    'status' => 'Pending',
                    'skor_cosine' => 0.0
                ];
            }

            return $result;
        } catch (\Exception $e) {
            // Fallback jika ada error
            return [
                'clean_text' => null,
                'is_kasar' => 0,
                'is_spam' => 0,
                'status' => 'Pending',
                'skor_cosine' => 0.0,
                'error' => $e->getMessage()
            ];
        }
    }

    public static function getPythonCommand()
    {
        // Cek OS dan tentukan Python command (kembalikan path jika tersedia)
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if ($isWindows) {
            // Coba dapatkan path dari 'where'
            $output = shell_exec('where python.exe 2>nul');
            if ($output) {
                $lines = preg_split('/\r?\n/', trim($output));
                return $lines[0];
            }
            $output = shell_exec('where python 2>nul');
            if ($output) {
                $lines = preg_split('/\r?\n/', trim($output));
                return $lines[0];
            }
            // Fallback nama command
            return 'python';
        } else {
            // Linux/Mac: try which
            $output = shell_exec('which python3 2>/dev/null');
            if ($output) {
                return trim($output);
            }
            $output = shell_exec('which python 2>/dev/null');
            if ($output) {
                return trim($output);
            }
            return 'python3';
        }
    }
}