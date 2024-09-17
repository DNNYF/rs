@extends('layouts.user_type.admin')

@section('content')

<h1>Daftar Kamar</h1>
<a href="{{ route('kamar.create') }}" class="btn btn-primary">Tambah Kamar Baru</a>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- search bar here --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('kamar.index') }}" method="GET">
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" placeholder="Cari kamar" aria-label="Search" name="search" value="{{ request('search') }}">
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
                        <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('kamar.destroy', $kamar->id) }}" style="display:inline-block;" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?');">
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
