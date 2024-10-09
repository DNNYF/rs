<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawatJalan extends Model
{
    protected $table = 'rawat_jalans'; 
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'total_biaya',
        'step'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'rawat_jalan_obats', 'rawat_jalan_id', 'obat_id')
                    ->withPivot('jumlah');
    }
}
