<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'obat_data',
        'total_harga',
    ];

    protected $casts = [
        'obat_data' => 'array', // Automatically cast JSON to array
    ];
}
