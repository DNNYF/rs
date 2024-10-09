<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJalanObat extends Model
{
    use HasFactory;

    protected $table = 'rawat_jalan_obats';

    protected $fillable = [
        'rawat_jalan_id',
        'obat_id',
        'jumlah',
    ];

    
    public function rawatJalan()
    {
        return $this->belongsTo(RawatJalan::class);
    }
}
