<?php

// app/Models/Pasien.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'tgl_lahir',
        'jenis_kelamin',
        'tinggi_badan',
        'berat_badan',
        'golongan_darah',
    ];
}