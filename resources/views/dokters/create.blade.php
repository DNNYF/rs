@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('dokters.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Create Dokter</h1>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('dokters.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_dokter" class="form-label">Nama Dokter</label>
            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" required>
        </div>
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" required>
        </div>
        <div class="mb-3">
            <label for="sip" class="form-label">SIP</label>
            <input type="text" class="form-control" id="sip" name="sip" required>
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="spesialis" class="form-label">Spesialis</label>
            <select class="form-select" id="spesialis" name="spesialis" required>
                <option value="" disabled selected>Pilih Spesialis</option>
                <option value="Umum">Umum</option>
                <option value="Spesialis">Spesialis</option>
            </select>
        </div>
        <div id="nama-spesialis-container" class="mb-3" style="display: none;">
            <label for="nama_spesialis" class="form-label">Nama Spesialis</label>
            <input type="text" class="form-control" id="nama_spesialis" name="nama_spesialis">
        </div>
        <div class="mb-3">
            <label for="biaya_pelayanan" class="form-label">Biaya Pelayanan</label>
            <input type="text" class="form-control" id="biaya_pelayanan" name="biaya_pelayanan" value="Rp 0" required>
        </div>
        <div class="mb-3">
            <label for="tlp" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="tlp" name="tlp" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<x-info-dokter-script />

<script>
    const biayaPelayananInput = document.getElementById('biaya_pelayanan');

biayaPelayananInput.addEventListener('input', function(e) {
    let input = e.target.value;

    input = input.replace(/[^,\d]/g, '');

    const formattedInput = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(input);

    e.target.value = formattedInput.replace(/[A-Za-z]{3}/g, 'Rp').trim();
});

document.querySelector('form').addEventListener('submit', function() {
    let rawValue = biayaPelayananInput.value;

    rawValue = rawValue.replace(/[^,\d]/g, '');

    biayaPelayananInput.value = rawValue;
});
;
</script>
@endsection




