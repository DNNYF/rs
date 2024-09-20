<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vod extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan
    protected $table = 'vod';

    // Tentukan kolom mana yang bisa diisi secara massal
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'thumbnail_path',
        'is_premium',
        'view_count',
    ];
}
