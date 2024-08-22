<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatJalan;
use Illuminate\Http\Request;
use App\Models\Obat;

class RawatJalanController extends Controller
{




    // app/Http/Controllers/YourController.php
public function saveData(Request $request)
{
    $validated = $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'dokter_id' => 'required|exists:dokters,id',
        'obat_id' => 'array',
        'obat_id.*' => 'exists:obats,id_obat',
        'jumlah' => 'array',
        'jumlah.*' => 'integer|min:1',
        'invoice_total' => 'required|numeric'
    ]);

    // Logika untuk menyimpan data, misalnya
    // Simpan data ke session atau database sesuai kebutuhan

    return response()->json(['success' => true]);
}
public function store(Request $request)
{
    $data = $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'dokter_id' => 'required|exists:dokters,id',
        'obat_id' => 'required|array',
        'obat_id.*' => 'exists:obats,id_obat',
        'jumlah' => 'required|array',
        'jumlah.*' => 'integer|min:1',
        'invoice_total' => 'required|numeric',
    ]);

    $obatData = array_map(function($id, $jumlah) {
        return ['id' => $id, 'jumlah' => $jumlah];
    }, $data['obat_id'], $data['jumlah']);

    RawatJalan::create([
        'pasien_id' => $data['pasien_id'],
        'dokter_id' => $data['dokter_id'],
        'obat_data' => $obatData,
        'total_harga' => $data['invoice_total'],
    ]);

    return redirect()->route('rawat-jalan.form')->with('success', 'Data has been saved successfully.');
}

public function showForm()
{
    $pasiens = Pasien::all();
    $dokters = Dokter::all();
    $obats = Obat::all();

    // Ambil data dari session jika ada
    $step1 = session('step1', []);
    $step2 = session('step2', []);

    return view('rawat_jalan.form', compact('pasiens', 'dokters', 'obats', 'step1', 'step2'));
}


public function saveStep1(Request $request)
{
    $riwayat = session()->get('riwayat_pendaftaran', []);
    $riwayat[] = [
        'nama_lengkap' => $request->input('nama_lengkap'),
        'nama_dokter' => $request->input('nama_dokter'),
        'nama_obat' => '',
        'jumlah' => '',
        'total_harga' => ''
    ];
    session()->put('riwayat_pendaftaran', $riwayat);
}

public function saveStep2(Request $request)
{
    $riwayat = session()->get('riwayat_pendaftaran', []);
    $lastIndex = count($riwayat) - 1;

    $obatData = [];
    foreach ($request->input('obats') as $obat) {
        $obatData[] = $obat['nama_obat'] . ' - ' . $obat['jumlah'] . ' x Rp ' . $obat['harga'] . ' = Rp ' . ($obat['jumlah'] * $obat['harga']);
    }

    $riwayat[$lastIndex]['obat'] = implode('<br>', $obatData);
    $riwayat[$lastIndex]['total_harga'] = 'Rp ' . $request->input('total_harga');

    session()->put('riwayat_pendaftaran', $riwayat);
}



public function index()
{
    $pasiens = Pasien::all();
    $dokters = Dokter::all();
    $obats = Obat::all();
    $riwayat = session()->get('riwayat_pendaftaran', []);

    return view('rawat_jalan.form', compact('pasiens', 'dokters', 'obats', 'riwayat'));
}

}
