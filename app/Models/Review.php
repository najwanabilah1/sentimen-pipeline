<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'ulasan';

    protected $primaryKey = 'id_ulasan';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'kategori_berita',
        'judul_berita',
        'rating',
        'nama_user',
        'isi_ulasan_raw',
        'isi_ulasan_clean',
        'status',
        'is_spam',
        'is_kasar',
        'skor_cosine',
        'waktu_kirim',
        'waktu_analisis',
        'sentimen'
    ];

    // 🔥 FIX DI SINI
    protected $casts = [
        'waktu_analisis' => 'datetime',
    ];
}