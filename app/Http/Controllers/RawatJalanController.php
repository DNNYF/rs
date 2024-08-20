<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Obat;
use Illuminate\Http\Request;

class RawatJalanController extends Controller
{
    public function showForm()
{
    $dokters = Dokter::all();
    $pasiens = Pasien::all();
    $obats   = Obat::all();

    return view('rawat-jalan.form', [
        'dokters' => $dokters,
        'pasiens' => $pasiens,
        'obats'   => $obats
    ]);
}


    public function submitForm(Request $request)
    {
        // Validasi dan logika penyimpanan data di sini
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'dokter_id' => 'required|exists:dokters,id',
            // Validasi lainnya
        ]);

        // Contoh penyimpanan data
        $pasien = Pasien::create($request->only('nama_pasien', 'alamat', 'tgl_lahir', 'jenis_kelamin'));
        $dokter = Dokter::find($request->dokter_id);

        // Logika tambahan di sini...

        return redirect()->route('rawat_jalan.form')->with('success', 'Data berhasil disimpan');
    }
}
