<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawatJalan extends Model
{
    protected $table = 'rawat_jalans'; 
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'obat_list',
        'total_biaya',
        'step'
    ];

    // Relasi ke model Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke model Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
