@extends('layouts.user_type.auth')

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
                    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Obat Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $obat->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $obat->quantity }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Obat</button>
                        <a href="{{ route('obat.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
