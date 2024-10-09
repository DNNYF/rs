<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kamar',
        'pasien_id',
        'dokter_jaga_id',
        'dokter_spesialis_id',
        'perawat_id',
        'tipe_kamar',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokterJaga()
    {
        return $this->belongsTo(User::class, 'dokter_jaga_id');
    }

    public function dokterSpesialis()
    {
        return $this->belongsTo(Dokter::class, 'dokter_spesialis_id');
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }
}
