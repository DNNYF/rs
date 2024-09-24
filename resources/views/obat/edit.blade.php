@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mb-4">Edit Obat</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Edit Obat</h4>
                </div>
                <div class="card-body">
                    <<form action="{{ route('obat.update', $obat->obat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stok_obat" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok_obat" name="stok_obat" value="{{ old('stok_obat', $obat->stok_obat ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga_obat" class="form-label">Harga Obat</label>
                            <input type="number" class="form-control" id="harga_obat" name="harga_obat" value="{{ old('harga_obat', $obat->harga_obat) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Obat</button>
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
