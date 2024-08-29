@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('operator.fasilitas.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1>Edit Fasilitas</h1>
    </div>
    <form action="{{ route('operator.fasilitas.update',$fasilitas->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="fasilitas" class="form-label">Fasilitas</label>
            <input type="text" class="form-control" id="fasilitas" name="fasilitas" value="{{ old('fasilitas', $fasilitas->fasilitas) }}" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="1" {{ old('status', $fasilitas->status) == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status', $fasilitas->status) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    
</div>

@endsection
