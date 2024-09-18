@extends('layouts.user_type.admin')
@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Daftar Dokter</h1>

    <div class="mb-3">
        <a href="{{ route('dokters.create') }}" class="btn btn-primary">Tambah Dokter Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dokters.index') }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($dokters->count() > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Spesialis</th>
                            <th scope="col">Nama Spesialis</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokters as $dokter)
                            <tr>
                                <td>{{ $dokter->nama_dokter }}</td>
                                <td>{{ $dokter->spesialis }}</td>
                                <td>{{ $dokter->nama_spesialis }}</td>
                                <td>{{ $dokter->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('dokters.show', $dokter->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <a href="{{ route('dokters.edit', $dokter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('dokters.destroy', $dokter->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    {{-- {{ $dokters->links() }} --}}
                </div>
            @else
                <p class="text-muted">Tidak ada data yang ditemukan.</p>
            @endif
        </div>
    </div>
</div>

@endsection
