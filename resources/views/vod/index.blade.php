@extends('layouts.user_type.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">VOD List</h2>

    <a href="{{ route('vod.create') }}" class="btn btn-primary mb-3">Add New VOD</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($vods->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Premium</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vods as $vod)
                            <tr>
                                <td>{{ $vod->title }}</td>
                                <td>{{ Str::limit($vod->description, 50) }}</td>
                                <td>{{ $vod->is_premium ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('vod.show', $vod->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('vod.edit', $vod->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('vod.destroy', $vod->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this VOD?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Menambahkan kontrol paginasi -->
                <div class="d-flex justify-content-center mt-3">
                    {{-- {{ $vods->links() }} --}}
                </div>
            @else
                <p class="text-muted">No VODs found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
