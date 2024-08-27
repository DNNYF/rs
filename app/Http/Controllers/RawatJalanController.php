<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawatJalanController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        $obats = Obat::all();
        $rawatJalan = $id ? RawatJalan::find($id) : null;

        return view('rawat-jalan.index', [
            'dokters' => $dokters,
            'obats' => $obats,
            'pasiens' => $pasiens,
            'rawatJalan' => $rawatJalan
        ]);
    }

    public function step1(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
        ]);


        $rawatJalanId = DB::table('rawat_jalans')->insertGetId([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'step' => 'step2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'rawat_jalan_id' => $rawatJalanId]);
    }


    public function step2(Request $request)
    {
        
        $request->validate([
            'rawat_jalan_id' => 'required|exists:rawat_jalans,id',
            'obat_id.*' => 'required|exists:obats,id',
            'obat_list.*' => 'required|exists:obats,nama_obat',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        
        $rawatJalan = RawatJalan::find($request->rawatJalanId);
        if (!$rawatJalan) {
            return response()->json(['success' => false, 'message' => 'Rawat Jalan not found'], 404);
        }

        $totalBiaya = 0;
        foreach ($request->obat_id as $index => $obatId) {
            $obat = Obat::find($obatId);
            if (!$obat) {
                return response()->json(['success' => false, 'message' => 'Obat not found'], 404);
            }
            $totalBiaya += $obat->harga_obat * $request->jumlah[$index];
        }

        $rawatJalan->obat_list = json_encode($request->obat_id);
        // $rawatJalan->total_biaya = $totalBiaya;
        $rawatJalan->step = 'step3';
        $rawatJalan->save();

        return response()->json(['success' => true]);
    }



    public function step3(Request $request)
    {
        $request->validate([
            'rawat_jalan_id' => 'required|exists:rawat_jalans,id',
            'invoice_total' => 'required|numeric',
        ]);

        $rawatJalan = RawatJalan::find($request->rawat_jalan_id);
        $rawatJalan->total_biaya = $request->invoice_total;
        $rawatJalan->step = 'done';
        $rawatJalan->save();

        return response()->json(['success' => true]);
    }
}
