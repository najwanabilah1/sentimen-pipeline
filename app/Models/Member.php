<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'posisi',
        'departemen', // Produksi, Teknis, Redaksi, Marketing, IT
        'email',
        'telepon',
        'status', // Aktif, Cuti, Tidak Aktif
    ];
}