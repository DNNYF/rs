<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class PengaturanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Muat pengaturan
        $pengaturan = Pengaturan::all();
        foreach ($pengaturan as $item) {
            Config::set('pengaturan.index' . $item->kunci, $item->nilai);
        }

        // Ganti nama aplikasi
        $namaAplikasi = Config::get('pengaturan.nama_aplikasi');
        if ($namaAplikasi) {
            Config::set('app.name', $namaAplikasi);
        }
    }

    public function register()
    {
        //
    }
}
