@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rawat Jalan</h1>
    <form action="{{ route('rawat-jalan.cari-pasien') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="no_rm">Nomor Rekam Medis</label>
            <input type="text" class="form-control" id="no_rm" name="no_rm" required>
        </div>
        <button type="submit" class="btn btn-primary">Cari Pasien</button>
    </form>
</div>
@endsection