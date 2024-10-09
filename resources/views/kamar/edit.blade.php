@extends('layouts.user_type.admin')

@section('content')
<div class="container">
    <h1>Edit Kamar</h1>
    <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
            <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required>
        </div>

        <div class="mb-3">
            <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
            <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" value="{{ old('tipe_kamar', $kamar->tipe_kamar) }}" required>
        </div>

        <div class="mb-3">
            <label for="pasien_id" class="form-label">Pasien</label>
            <select class="form-control" id="pasien_id" name="pasien_id">
                <option value="">Pilih Pasien</option>
                @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}" {{ (old('pasien_id', $kamar->pasien_id) == $pasien->id) ? 'selected' : '' }}>
                        {{ $pasien->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dokter_jaga_id" class="form-label">Dokter Jaga</label>
            <select class="form-control" id="dokter_jaga_id" name="dokter_jaga_id">
                <option value="">Pilih Dokter Jaga</option>
                @foreach($dokterJagas as $dokter)
                    <option value="{{ $dokter->id }}" {{ (old('dokter_jaga_id', $kamar->dokter_jaga_id) == $dokter->id) ? 'selected' : '' }}>
                        {{ $dokter->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dokter_spesialis_id" class="form-label">Dokter Spesialis</label>
            <select class="form-control" id="dokter_spesialis_id" name="dokter_spesialis_id">
                <option value="">Pilih Dokter Spesialis</option>
                @foreach($dokterSpesialis as $dokter)
                    <option value="{{ $dokter->id }}" {{ (old('dokter_spesialis_id', $kamar->dokter_spesialis_id) == $dokter->id) ? 'selected' : '' }}>
                        {{ $dokter->nama_dokter }} ({{ $dokter->nama_spesialis }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="perawat_id" class="form-label">Perawat</label>
            <select class="form-control" id="perawat_id" name="perawat_id">
                <option value="">Pilih Perawat</option>
                @foreach($perawats as $perawat)
                    <option value="{{ $perawat->id }}" {{ (old('perawat_id', $kamar->perawat_id) == $perawat->id) ? 'selected' : '' }}>
                        {{ $perawat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="kosong" {{ (old('status', $kamar->status) == 'kosong') ? 'selected' : '' }}>Kosong</option>
                <option value="terisi" {{ (old('status', $kamar->status) == 'terisi') ? 'selected' : '' }}>Terisi</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
