<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['periksa_id', 'total'];

    public function periksa()
    {
        return $this->belongsTo(Periksa::class);
    }
}
