@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('vod.index') }}" class="me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
        </a>
        <h1 class="mb-0">Tambah Video On Demand</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('vod.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="title">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter VOD Title" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter VOD Description" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="file_path">Berkas VOD</label>
                    <input type="file" class="form-control" id="file_path" name="file_path" accept=".mp4,.avi,.mov" required>
                </div>
                <div class="form-group mb-3">
                    <label for="thumbnail_path">Thumbnail Image (Optional)</label>
                    <input type="file" class="form-control" id="thumbnail_path" name="thumbnail_path" accept="image/*">
                </div>
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_premium" name="is_premium" value="1">
                        <label class="form-check-label" for="is_premium">Is Premium</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
