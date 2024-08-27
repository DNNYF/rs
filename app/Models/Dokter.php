<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'nama_dokter',
        'nip',
        'sip',
        'jenis_kelamin',
        'spesialis',
        'nama_spesialis',
        'biaya_pelayanan',
        'tlp',
        'email',
    ];
    use HasFactory;
}
