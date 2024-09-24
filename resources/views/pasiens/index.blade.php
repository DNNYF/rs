@extends('layouts.user_type.admin')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Daftar Pasien</h1>

    <div class="mb-3">
        <a href="{{ route('pasiens.create') }}" class="btn btn-primary">Tambah Pasien Baru</a>
    </div>

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
                    <button class="btn btn-outline-primary my-sm-0" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($pasiens->count() > 0)
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasiens as $pasien)
                            <tr>
                                <td>{{ $pasien->nama_lengkap }}</td>
                                <td>{{ $pasien->alamat }}</td>
                                <td>{{ $pasien->tgl_lahir }}</td>
                                <td>{{ $pasien->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('pasiens.show', $pasien->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <a href="{{ route('pasiens.edit', $pasien->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Tidak ada data yang ditemukan.</p>
            @endif
        </div>
    </div>
</div>

@endsection
