@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Daftar Kamar</h1>
            <a href="{{ route('kamar.create') }}" class="btn btn-primary mb-3">Tambah Kamar Baru</a>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('kamar.index') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control" type="search" placeholder="Cari kamar" aria-label="Search" name="search" value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Kamar --}}
            <div class="card">
                <div class="card-body">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Nomor Kamar</th>
                                <th>Tipe Kamar</th>
                                <th>Penghuni Kamar</th>
                                <th>Dokter Jaga</th>
                                <th>Dokter Spesialis</th>
                                <th>Perawat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kamars as $kamar)
                                <tr>
                                    <td>{{ $kamar->nomor_kamar }}</td>
                                    <td>{{ $kamar->tipe_kamar }}</td>
                                    <td>{{ $kamar->penghuni_kamar }}</td>
                                    <td>{{ $kamar->dokter_jaga }}</td>
                                    <td>{{ $kamar->dokter_spesialis }}</td>
                                    <td>{{ $kamar->perawat }}</td>
                                    <td>
                                        @if($kamar->status == 'kosong')
                                            <span class="badge bg-success">Kosong</span>
                                        @else
                                            <span class="badge bg-danger">Terisi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{-- {{ $kamars->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
