<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Gunakan tabel 'ulasan' (form publik menyimpan ke tabel ini)
    protected $table = 'ulasan';

    protected $fillable = [
        'id_ulasan',
        'kategori_berita',
        'judul_berita',
        'rating',
        'nama_user',
        'isi_ulasan_raw',   // Teks asli dari user
        'isi_ulasan_clean', // Teks yang sudah dibersihkan teman kamu
        'status',
        'is_spam',
        'is_kasar',
        'skor_cosine',
        'waktu_kirim',
        'waktu_analisis',
        'sentimen'          // Kolom yang akan diupdate oleh Python kamu
    ];

    // Karena kamu pakai waktu_kirim/analisis sendiri, 
    // kita matikan timestamps default Laravel jika tidak dipakai
    public $timestamps = false; 
}