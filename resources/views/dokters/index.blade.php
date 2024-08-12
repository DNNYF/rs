@extends('layouts.user_type.auth')

@section('content')

<h1>Daftar Dokter</h1>
    <a href="{{ route('dokters.create') }}" class="btn btn-primary">Tambah Dokter Baru</a>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('pasiens.index') }}" method="GET">
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Spesialis</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dokters as $dokter)
                    <tr>
                        <td scope="row">{{ $dokter->nama_dokter }}</td>
                        <td>{{ $dokter->alamat }}</td>
                        <td>{{ $dokter->spesialis }}</td>
                        <td>{{ $dokter->jenis_kelamin }}</td>
                        <td>
                            <a href="{{ route('dokters.show', $dokter->id) }}" class="btn btn-info">Lihat</a>
                            <a href="{{ route('dokters.edit', $dokter->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('dokters.destroy', $dokter->id) }}" style="display:inline-block;" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection