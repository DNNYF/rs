@extends('layouts.user_type.admin') 

@section('content')
<div class="container">
    <h2>Edit VOD</h2>
    <form action="{{ route('vod.update', $vod->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required value="{{ old('title', $vod->title) }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $vod->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="video_file">Video File (leave empty to keep current video)</label>
            <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file">
            @error('video_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="thumbnail">Thumbnail (leave empty to keep current thumbnail)</label>
            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_premium" name="is_premium" value="1" {{ old('is_premium', $vod->is_premium) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_premium">Premium Content</label>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection