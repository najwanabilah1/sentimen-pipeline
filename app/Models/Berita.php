<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    public $timestamps = false;

    protected $fillable = [
        'kategori_berita',
        'judul_berita',
        'tanggal_berita',
        'caption_berita',
        'gambar_berita',
    ];
}
