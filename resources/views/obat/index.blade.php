@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Stok Obat</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    <!-- Button to go to the Add Obat page -->
    <a href="{{ route('obat.create') }}" class="btn btn-primary mb-4">Tambah Obat Baru</a>

    <div class="card">
        <div class="card-header">
            <h4>Obat Tersedia</h4>
        </div>
        <div class="card-body">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <!-- Remove or comment out the ID column header -->
                        <!-- <th>ID</th> -->
                        <th>Nama Obat</th>
                        <th>Quantity</th>
                        <th>Harga Obat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($obats as $obat)
                        <tr>
                            {{-- <td>{{ $obat->id_obat }}</td>  --}}
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->stok_obat }}</td>
                            <td>Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('obat.edit', $obat->id_obat) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('obat.destroy', $obat->id_obat) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
