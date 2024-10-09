@extends('layouts.user_type.admin')

@section('content')
<div class="container">
    <h1>Tambah Kamar Baru</h1>
    <form action="{{ route('kamar.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
            <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" required>
        </div>
        <div class="mb-3">
            <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
            <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" required>
        </div>
        <div class="mb-3">
            <label for="pasien_id" class="form-label">Pasien</label>
            <select class="form-control" id="pasien_id" name="pasien_id">
                <option value="">Pilih Pasien</option>
                @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}">{{ $pasien->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="dokter_jaga_id" class="form-label">Dokter Jaga</label>
            <select class="form-control" id="dokter_jaga_id" name="dokter_jaga_id">
                <option value="">Pilih Dokter Jaga</option>
                @foreach($dokterJagas as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="dokter_spesialis_id" class="form-label">Dokter Spesialis</label>
            <select class="form-control" id="dokter_spesialis_id" name="dokter_spesialis_id">
                <option value="">Pilih Dokter Spesialis</option>
                @foreach($dokterSpesialis as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }} ({{ $dokter->nama_spesialis }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="perawat_id" class="form-label">Perawat</label>
            <select class="form-control" id="perawat_id" name="perawat_id">
                <option value="">Pilih Perawat</option>
                @foreach($perawats as $perawat)
                    <option value="{{ $perawat->id }}">{{ $perawat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="kosong">Kosong</option>
                <option value="terisi">Terisi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
