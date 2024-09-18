@extends('layouts.user_type.admin')

@section('content')

<h1>{{ isset($kamar) ? 'Edit' : 'Tambah' }} Kamar</h1>

<form action="{{ isset($kamar) ? route('kamar.update', $kamar->id) : route('kamar.store') }}" method="POST">
    @csrf
    @if(isset($kamar))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
        <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="{{ isset($kamar) ? $kamar->nomor_kamar : old('nomor_kamar') }}" required>
    </div>

    <div class="mb-3">
        <label for="pasien_id" class="form-label">Penghuni Kamar</label>
        <select class="form-control" id="pasien_id" name="pasien_id" required>
            <option value="">Pilih Pasien</option>
            @foreach($pasiens as $pasien)
                <option value="{{ $pasien->id }}" {{ (isset($kamar) && $kamar->pasien_id == $pasien->id) || old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                    {{ $pasien->nama_lengkap }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="dokter_jaga_id" class="form-label">Dokter Jaga</label>
        <select class="form-control" id="dokter_jaga_id" name="dokter_jaga_id" required>
            <option value="">Pilih Dokter Jaga</option>
            @foreach($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ (isset($kamar) && $kamar->dokter_jaga_id == $dokter->id) || old('dokter_jaga_id') == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama_dokter }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="dokter_spesialis_id" class="form-label">Dokter Spesialis</label>
        <select class="form-control" id="dokter_spesialis_id" name="dokter_spesialis_id" required>
            <option value="">Pilih Dokter Spesialis</option>
            @foreach($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ (isset($kamar) && $kamar->dokter_spesialis_id == $dokter->id) || old('dokter_spesialis_id') == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama_dokter }} ({{ $dokter->nama_spesialis }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="perawat" class="form-label">Perawat</label>
        <input type="text" class="form-control" id="perawat" name="perawat" value="{{ isset($kamar) ? $kamar->perawat : old('perawat') }}" required>
    </div>

    <div class="mb-3">
        <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
        <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" value="{{ isset($kamar) ? $kamar->tipe_kamar : old('tipe_kamar') }}" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="kosong" {{ isset($kamar) && $kamar->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
            <option value="terisi" {{ isset($kamar) && $kamar->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">{{ isset($kamar) ? 'Update' : 'Simpan' }}</button>
</form>

@endsection
