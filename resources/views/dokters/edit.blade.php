@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('dokters.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Edit Pasien</h1>
    </div>
    <form action="{{ route('pasiens.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_dokter" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter) }}">
        </div>
        <div class="mb-3">
            <label for="nip" class="form-label">nip</label>
            <input class="form-control" id="nip" name="nip" value="{{ old('nip', $dokter->nip) }}">
        </div>
        <div class="mb-3">
            <label for="sip" class="form-label">sip</label>
            <input type="text" class="form-control" id="sip" name="sip" value="{{ old('sip', $dokter->sip) }}">
        </div>  
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                <option value="Laki-laki" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="spesialis" class="form-label">Spesialis</label>
            <select class="form-select" id="spesialis" name="spesialis" required>
                <option value="{{ old('nama_spesialis', $dokter->spesialis) }}" id="spesialis" selected disabled>{{ old('spesialis', $dokter->spesialis) }}</option>
                <option value="Umum">Umum</option>
                <option value="Spesialis">Spesialis</option>
            </select>
        </div>
        <div id="nama-spesialis-container" style="display: none;">
            <div class="mb-3">
                <label for="nama_spesialis" class="form-label">Nama Spesialis</label>
                <input type="text" class="form-control" id="nama_spesialis" name="nama_spesialis" value="{{ old('nama_spesialis', $dokter->nama_spesialis) }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="biaya_pelayanan" class="form-label">Biaya Pelayanan</label>
            <input type="numeric" class="form-control" id="biaya_pelayanan" name="biaya_pelayanan" value="{{ old('biaya_pelayanan', $dokter->biaya_pelayanan) }}">
        </div>
        <div class="mb-3">
            <label for="tlp" class="form-label">No tlp</label>
            <input type="numeric" class="form-control" id="tlp" name="tlp" value="{{ old('tlp', $dokter->tlp) }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $dokter->email) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<x-info-dokter-script />
@endsection
