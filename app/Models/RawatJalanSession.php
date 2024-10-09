<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawatJalanSession extends Model
{
    protected $table = 'rawat_jalan_sessions'; 

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'obat_list',
        'step',
        'total_biaya',
        'step',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id','id');
    }
}

