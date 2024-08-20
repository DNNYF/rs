<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = ['pasien_id', 'status'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function periksa()
    {
        return $this->hasOne(Periksa::class);
    }
}
