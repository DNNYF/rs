@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mb-4">Obat</h2>

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
                    <table class="table table-bordered">
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
                                    <!-- Remove or comment out the ID column value -->
                                    <!-- <td>{{ $obat->id_obat }}</td> -->
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
    </div>
</div>
@endsection
