<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class RawatJalanController extends Controller
{
    public function index()
    {
        return view('rawat-jalan.index');
    }

    public function cariPasien(Request $request)
    {
        $request->validate([
            'no_rm' => 'required|string',
        ]);

        $pasien = Pasien::where('no_rm', $request->no_rm)->first();

        if ($pasien) {
            session(['pasien_id' => $pasien->id]);
            session(['rawat_jalan_step' => 2]);
            return redirect()->route('rawat-jalan.pilih-dokter');
        }

        return view('rawat-jalan.daftar-pasien');
    }

    public function daftarPasien(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_rm' => 'required|string|unique:pasiens',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        $pasien = Pasien::create($request->all());

        session(['pasien_id' => $pasien->id]);
        session(['rawat_jalan_step' => 2]);

        return redirect()->route('rawat-jalan.pilih-dokter');
    }

    public function pilihDokter()
    {
        $dokters = Dokter::all();
        return view('rawat-jalan.pilih-dokter', compact('dokters'));
    }

    public function simpanDokter(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
        ]);

        session(['dokter_id' => $request->dokter_id]);
        session(['rawat_jalan_step' => 3]);

        return redirect()->route('rawat-jalan.konfirmasi');
    }

    public function konfirmasi()
    {
        $pasien = Pasien::findOrFail(session('pasien_id'));
        $dokter = Dokter::findOrFail(session('dokter_id'));

        return view('rawat-jalan.konfirmasi', compact('pasien', 'dokter'));
    }

    public function simpanPemeriksaan(Request $request)
    {
        $request->validate([
            'keluhan' => 'required|string',
        ]);

        $pemeriksaan = Pemeriksaan::create([
            'pasien_id' => session('pasien_id'),
            'dokter_id' => session('dokter_id'),
            'keluhan' => $request->keluhan,
            'status' => 'antri',
            'total_biaya' => Dokter::find(session('dokter_id'))->biaya_konsultasi,
        ]);

        session(['pemeriksaan_id' => $pemeriksaan->id]);
        session(['rawat_jalan_step' => 4]);

        return redirect()->route('rawat-jalan.invoice');
    }

    public function invoice()
    {
        $pemeriksaan = Pemeriksaan::with(['pasien', 'dokter'])->findOrFail(session('pemeriksaan_id'));
        return view('rawat-jalan.invoice', compact('pemeriksaan'));
    }

    public function prosesPembayaran(Request $request)
    {
        $pemeriksaan = Pemeriksaan::findOrFail(session('pemeriksaan_id'));
        $pemeriksaan->status = 'selesai';
        $pemeriksaan->save();

        session()->forget(['pasien_id', 'dokter_id', 'pemeriksaan_id', 'rawat_jalan_step']);

        return redirect()->route('rawat-jalan.index')->with('success', 'Pembayaran berhasil');
    }

    public function histori()
    {
        $pemeriksaans = Pemeriksaan::with(['pasien', 'dokter'])->orderBy('created_at', 'desc')->get();
        return view('rawat-jalan.histori', compact('pemeriksaans'));
    }

    public function lanjutkanPemeriksaan($id)
    {
        $pemeriksaan = Pemeriksaan::findOrFail($id);
        
        session(['pasien_id' => $pemeriksaan->pasien_id]);
        session(['dokter_id' => $pemeriksaan->dokter_id]);
        session(['pemeriksaan_id' => $pemeriksaan->id]);
        
        if ($pemeriksaan->status == 'antri') {
            session(['rawat_jalan_step' => 3]);
            return redirect()->route('rawat-jalan.konfirmasi');
        } elseif ($pemeriksaan->status == 'pembayaran') {
            session(['rawat_jalan_step' => 4]);
            return redirect()->route('rawat-jalan.invoice');
        }
        
        return redirect()->route('rawat-jalan.histori')->with('error', 'Tidak dapat melanjutkan pemeriksaan ini');
    }
}