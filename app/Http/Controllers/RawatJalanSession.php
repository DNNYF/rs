<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawatJalanSession;

class RawatJalanController extends Controller
{

    public function createStep1(Request $request)
    {
        $pasien = $request->session()->get('rawat_jalan_data.pasien_id');
        $dokter = $request->session()->get('rawat_jalan_data.dokter_id');
        return view('rawat_jalan.step1', compact('pasien', 'dokter'));
    }


    public function postStep1(Request $request)
    {
    
        $request->validate([
            'pasien_id' => 'required',
            'dokter_id' => 'required',
        ]);

    
        $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);
        $rawat_jalan_data['pasien_id'] = $request->input('pasien_id');
        $rawat_jalan_data['dokter_id'] = $request->input('dokter_id');
        $rawat_jalan_data['step'] = 1;

    
        $request->session()->put('rawat_jalan_data', $rawat_jalan_data);

    
        return redirect()->route('rawat-jalan.createStep2');
    }


    public function createStep2(Request $request)
    {
        $obat_list = $request->session()->get('rawat_jalan_data.obat_list', []);
        return view('rawat_jalan.step2', compact('obat_list'));
    }


    public function postStep2(Request $request)
    {
    
        $request->validate([
            'obat_list' => 'required|array',
        ]);

    
        $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);

    
        $rawat_jalan_data['obat_list'] = $request->input('obat_list');
        $rawat_jalan_data['step'] = 2;

    
        $request->session()->put('rawat_jalan_data', $rawat_jalan_data);

    
        return redirect()->route('rawat-jalan.createStep3');
    }


    public function createStep3(Request $request)
    {
        $total_biaya = $request->session()->get('rawat_jalan_data.total_biaya', 0);
        return view('rawat_jalan.step3', compact('total_biaya'));
    }


    public function postStep3(Request $request)
    {
    
        $request->validate([
            'total_biaya' => 'required|numeric',
        ]);

    
        $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);

    
        $rawat_jalan_data['total_biaya'] = $request->input('total_biaya');
        $rawat_jalan_data['step'] = 3;

    
        $request->session()->put('rawat_jalan_data', $rawat_jalan_data);

    
        return redirect()->route('rawat-jalan.review');
    }


    public function review(Request $request)
    {
    
        $rawat_jalan_data = $request->session()->get('rawat_jalan_data');

        return view('rawat_jalan.review', compact('rawat_jalan_data'));
    }


    public function store(Request $request)
    {
    
        $rawat_jalan_data = $request->session()->get('rawat_jalan_data', []);

    
        if (!empty($rawat_jalan_data)) {

        
            RawatJalanSession::create([
                'pasien_id' => $rawat_jalan_data['pasien_id'],
                'dokter_id' => $rawat_jalan_data['dokter_id'],
                'obat_list' => json_encode($rawat_jalan_data['obat_list']),
                'total_biaya' => $rawat_jalan_data['total_biaya'],
                'step' => $rawat_jalan_data['step'], 
            ]);

        
            $request->session()->forget('rawat_jalan_data');

        
            return redirect()->route('rawat-jalan.index')->with('success', 'Data berhasil disimpan ke database.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang disimpan.');
    }
}

