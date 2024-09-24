<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $fillable = ['kunci', 'nilai'];

    public static function ambil($kunci, $default = null)
    {
        $pengaturan = static::where('kunci', $kunci)->first();
        return $pengaturan ? $pengaturan->nilai : $default;
    }

    public static function atur($kunci, $nilai)
    {
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
    }
}
