@extends('layouts.user_type.auth')

@section('content')

<h1>Daftar Pasien</h1>
    <a href="{{ route('pasiens.create') }}" class="btn btn-primary">Tambah Pasien Baru</a>
    <table class="table">
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
                        <a href="{{ route('pasiens.show', $pasien->id) }}" class="btn btn-info">Lihat</a>
                        <a href="{{ route('pasiens.edit', $pasien->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection