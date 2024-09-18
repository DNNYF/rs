<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $fillable = ['antrian_id', 'dokter_id', 'biaya'];

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
