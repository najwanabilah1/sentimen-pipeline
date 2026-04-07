<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'waktu',
        'durasi',
        'deskripsi',
        'status',
    ];

    /**
     * Relasi: Satu program bisa memiliki banyak ulasan
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}