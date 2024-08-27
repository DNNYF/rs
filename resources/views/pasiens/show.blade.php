@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pasiens.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Detail Pasien</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $pasien->nama_lengkap }}</h5>
            <p class="card-text"><strong>Alamat:</strong> {{ $pasien->alamat }}</p>
            <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $pasien->tgl_lahir }}</p>
            <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin }}</p>
            <p class="card-text"><strong>Tinggi Badan:</strong> {{ $pasien->tb }} cm</p>
            <!-- Tambahkan field lainnya sesuai kebutuhan -->
            
            <hr>
            
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('pasiens.edit', $pasien->id) }}" class="btn btn-primary me-2">Edit</a>
                <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection