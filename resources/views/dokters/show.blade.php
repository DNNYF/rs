@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('dokters.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Detail Dokter</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="w-30">Nama Dokter</th>
                        <td class="w-70">{{ $dokter->nama_dokter }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">NIP</th>
                        <td class="w-70">{{ $dokter->nip }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">SIP</th>
                        <td class="w-70">{{ $dokter->sip }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Gelar Depan</th>
                        <td class="w-70">{{ $dokter->gelar_depan }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Gelar Belakang</th>
                        <td class="w-70">{{ $dokter->gelar_belakang }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Jenis Kelamin</th>
                        <td class="w-70">{{ $dokter->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Spesialis</th>
                        <td class="w-70">{{ $dokter->spesialis }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Alamat</th>
                        <td class="w-70">{{ $dokter->alamat }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Telepon</th>
                        <td class="w-70">{{ $dokter->tlp }}</td>
                    </tr>
                    <tr>
                        <th class="w-30">Email</th>
                        <td class="w-70">{{ $dokter->email }}</td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('dokters.edit', $dokter->id) }}" class="btn btn-primary me-2">Edit</a>
                <form action="{{ route('dokters.destroy', $dokter->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
