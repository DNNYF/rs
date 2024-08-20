<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $fillable = ['pasien_id', 'dokter_id', 'keluhan', 'total_biaya', 'status'];

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
        return $this->belongsToMany(Obat::class)->withPivot('jumlah');
    }
}