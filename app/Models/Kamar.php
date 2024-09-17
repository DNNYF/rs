<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'tipe_kamar',
        'penghuni_kamar',
        'dokter_jaga',
        'dokter_spesialis',
        'perawat',
        'status',
    ];

}
