@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-light">
        <div class="card-body">
            <h2 class="card-title text-primary text-uppercase">{{ $vod->title }}</h2>

            <div class="mb-4">
                <strong>Description:</strong>
                <p class="text-muted">{{ $vod->description }}</p>
            </div>

            <div class="mb-4">
                <strong>Video:</strong>
                <div class="d-flex justify-content-center mb-3">
                    <div class="embed-responsive embed-responsive-16by9" style="max-width: 80%;">
                        <video controls class="embed-responsive-item">
                            <source src="{{ asset('storage/' . $vod->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <strong>Thumbnail:</strong>
                @if($vod->thumbnail_path)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $vod->thumbnail_path) }}" alt="Thumbnail" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                    </div>
                @else
                    <p class="text-muted">No thumbnail available.</p>
                @endif
            </div>

            <a href="{{ route('vod.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
